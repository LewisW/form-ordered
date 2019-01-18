<?php

namespace Tenolo\FormOrdered\Extension;

use Symfony\Component\Form\AbstractExtension;

/**
 * Class OrderedExtension
 *
 * @package Tenolo\FormOrdered\Extension
 * @author  GeLo <geloen.eric@gmail.com>
 * @author  Nikita Loges
 * @company tenolo GbR
 */
class OrderedExtension extends AbstractExtension
{
    /**
     * @inheritdoc
     */
    protected function loadTypeExtensions()
    {
        return [
            new OrderedFormExtension(),
            new OrderedButtonExtension(),
        ];
    }
}
