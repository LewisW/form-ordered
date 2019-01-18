<?php

namespace Tenolo\FormOrdered\Builder;

use Symfony\Component\Form\Exception\BadMethodCallException;
use Symfony\Component\Form\FormBuilder;
use Tenolo\FormOrdered\Exception\OrderedConfigurationException;
use Tenolo\FormOrdered\OrderedFormConfigInterface;

/**
 * Class OrderedFormBuilder
 *
 * @package Tenolo\FormOrdered\Builder
 * @author  GeLo <geloen.eric@gmail.com>
 * @author  Nikita Loges
 * @company tenolo GbR
 */
class OrderedFormBuilder extends FormBuilder implements OrderedFormConfigBuilderInterface, OrderedFormConfigInterface
{
    /** @var string|array|null */
    protected $position;

    /**
     * @inheritdoc
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @inheritdoc
     */
    public function setPosition($position)
    {
        if ($this->locked) {
            throw new BadMethodCallException('The config builder cannot be modified anymore.');
        }

        if (is_string($position) && ($position !== 'first') && ($position !== 'last')) {
            throw OrderedConfigurationException::createInvalidStringPosition($this->getName(), $position);
        }

        if (is_array($position) && !isset($position['before']) && !isset($position['after'])) {
            throw OrderedConfigurationException::createInvalidArrayPosition($this->getName(), $position);
        }

        $this->position = $position;

        return $this;
    }
}
