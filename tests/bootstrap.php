<?php

declare(strict_types=1);

use Doctrine\Common\Annotations\AnnotationRegistry;

// Loader for annotation classes for old doctrine/annotations ^1.0
// @phpstan-ignore-next-line
if (method_exists(AnnotationRegistry::class, 'registerLoader')) {
    AnnotationRegistry::registerLoader('class_exists');
}
