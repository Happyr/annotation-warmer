<?php

declare(strict_types=1);

namespace Happyr\AnnotationWarmer\Command;

use Doctrine\Common\Annotations\AnnotationException;
use Happyr\AnnotationWarmer\Service\AnnotationManager;
use Happyr\AnnotationWarmer\Service\AnnotationValidator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
final class AnnotationLintCommand extends Command
{
    protected static $defaultName = 'lint:annotations';

    private $validator;
    private $manager;

    public function __construct(AnnotationValidator $validator, AnnotationManager $manager)
    {
        parent::__construct();
        $this->validator = $validator;
        $this->manager = $manager;
    }

    public function getAliases()
    {
        return ['lint:annotation'];
    }

    protected function configure()
    {
        $this->setHelp('Lint all annotations in paths specified in happyr_annotation_warmer.paths');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $style = new SymfonyStyle($input, $output);
        /** @var AnnotationException[] $errors */
        $errors = $this->validator->validateClasses($this->manager->getAllClasses());
        if (empty($errors)) {
            $style->success('Everything is fine');

            return 0;
        }

        $style->error(sprintf('Found %d issues.', count($errors)));
        foreach ($errors as $error) {
            $style->error($error->getMessage());
        }

        return 1;
    }
}
