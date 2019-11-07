<?php

declare(strict_types=1);

namespace Happyr\AnnotationWarmer;

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
    private $classes;

    public function __construct(AnnotationValidator $validator, array $classes)
    {
        parent::__construct();
        $this->validator = $validator;
        $this->classes = $classes;
    }

    protected function configure()
    {
        $this->setHelp('Lint all annotations in paths specified in happyr_annotation_warmer.paths');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $style = new SymfonyStyle($input, $output);
        $errors = $this->validator->validateClasses($this->classes);
        if (empty($errors)) {
            $style->success('Everything is fine');

            return;
        }

        $style->error('Found some issues: ');
        foreach ($errors as $error) {
            $style->error($error);
        }
    }
}