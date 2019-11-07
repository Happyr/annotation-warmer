# Annotation Warmer

[![Latest Version](https://img.shields.io/github/release/Happyr/annotation-warmer.svg?style=flat-square)](https://github.com/Happyr/annotation-warmer/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Build Status](https://img.shields.io/travis/Happyr/annotation-warmer.svg?style=flat-square)](https://travis-ci.org/Happyr/annotation-warmer)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/Happyr/annotation-warmer.svg?style=flat-square)](https://scrutinizer-ci.com/g/Happyr/annotation-warmer)
[![Quality Score](https://img.shields.io/scrutinizer/g/Happyr/annotation-warmer.svg?style=flat-square)](https://scrutinizer-ci.com/g/Happyr/annotation-warmer)
[![Total Downloads](https://img.shields.io/packagist/dt/happyr/annotation-warmer.svg?style=flat-square)](https://packagist.org/packages/happyr/annotation-warmer)

When this bundle is installed and enabled it will make sure all your annotation metadata
is cached when your container dependency container is built. 

We also provide a command to validate that all annotations are properly loaded. 

## Install

```cli
composer require happyr/annotation-warmer
```

## Use

We warm upp all classes in `src` by default. You may use a different configuration of paths if you like:

```yaml
happyr_annotation_warmer:
    paths:
        - '%kernel.project_dir%/src/Message/Command'
        - '%kernel.project_dir%/src/Message/Event'

```

## Annotation lint

To make sure your annotations are properly configured you may run the lint command: 

```cli
bin/console lint:annotations
```

## Assumptions

We assume that the classes in the specified paths are using PSR-4. We also assume
that all *.php classes in the path has a class which is the same as the filename. 

## Limitations

We are only preloading annotations for Serializer and Validation component.
