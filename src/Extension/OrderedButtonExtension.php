<?php

namespace Tenolo\FormOrdered\Extension;

use Symfony\Component\Form\Extension\Core\Type\ButtonType;

/**
 * Class OrderedButtonExtension
 *
 * @package Tenolo\FormOrdered\Extension
 * @author  GeLo <geloen.eric@gmail.com>
 * @author  tweini <tweini@gmail.com>
 * @author  Nikita Loges
 * @company tenolo GbR
 */
class OrderedButtonExtension extends AbstractOrderedExtension
{
    /**
     * @inheritdoc
     */
    public function getExtendedType()
    {
        return ButtonType::class;
    }

    /**
     * @inheritdoc
     */
    public static function getExtendedTypes()
    {
        return [ButtonType::class];
    }
}
