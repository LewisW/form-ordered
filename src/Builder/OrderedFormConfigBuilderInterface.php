<?php

namespace Tenolo\FormOrdered\Builder;

use Symfony\Component\Form\Exception\InvalidConfigurationException;
use Symfony\Component\Form\FormConfigBuilderInterface;

/**
 * Interface OrderedFormConfigBuilderInterface
 *
 * @package Tenolo\FormOrdered\Builder
 * @author  GeLo <geloen.eric@gmail.com>
 * @author  Nikita Loges
 * @company tenolo GbR
 */
interface OrderedFormConfigBuilderInterface extends FormConfigBuilderInterface
{
    /**
     * @param string|array|null $position
     *
     * @throws InvalidConfigurationException
     *
     * @return OrderedFormConfigBuilderInterface
     */
    public function setPosition($position);
}
