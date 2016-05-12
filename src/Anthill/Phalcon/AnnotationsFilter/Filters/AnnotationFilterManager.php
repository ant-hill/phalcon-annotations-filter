<?php

namespace Anthill\Phalcon\AnnotationsFilter\Filters;

use Phalcon\Annotations\Adapter as AnnotationAdapter;
use Phalcon\Filter;
use Phalcon\FilterInterface;
use Anthill\Phalcon\AnnotationsFilter\Filters\Exceptions\FilterAnnotationException;

class AnnotationFilterManager extends FilterManager
{

    const ANNOTATION_NAME = 'Filter';

    /**
     * @var AnnotationAdapter
     */
    private $reader;

    /**
     * @var FilterInterface
     */
    private $filter;

    public function __construct(AnnotationAdapter $reader, FilterInterface $filter)
    {
        $this->reader = $reader;
        $this->filter = $filter;
    }

    public function filter($class)
    {
        $reader = $this->reader;

        // todo: change exception class
        if (gettype($class) !== 'object') {
            throw new \Exception('$class must be instance of object ' . gettype($class) . ' given');
        }

        $self = $this;
        $filter = $this->filter;

        $annotator = function (\Phalcon\Annotations\Reflection $reflector) use ($self, $filter) {
            $annotationName = $self::ANNOTATION_NAME;
            foreach ($reflector->getPropertiesAnnotations() as $name => $property) {
                if ($this->{$name} === null) {
                    continue;
                }
                if ($property->has($annotationName)) {
                    $annotatedFilters = $property->getAll($annotationName);
                    foreach ($annotatedFilters as $annotatedFilter) {
                        $arguments = $annotatedFilter->getArguments();
                        if ($arguments < 1) {
                            throw new FilterAnnotationException('Filter annotation must contain argument');
                        }
                        $argument = current($arguments);
                        $this->{$name} = $filter->sanitize($this->{$name}, $argument);
                    }
                }
            }
        };

        $reflector = $reader->get(get_class($class));
        $annotator = $annotator->bindTo($class, $class);
        $annotator($reflector);

    }
}