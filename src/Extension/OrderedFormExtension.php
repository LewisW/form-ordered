<?php

namespace Tenolo\FormOrdered\Extension;

use Symfony\Component\Form\Extension\Core\Type\FormType;

/**
 * Class OrderedFormExtension
 *
 * @package Tenolo\FormOrdered\Extension
 * @author  GeLo <geloen.eric@gmail.com>
 * @author  Nikita Loges
 * @company tenolo GbR
 */
class OrderedFormExtension extends AbstractOrderedExtension
{

    /**
     * @inheritdoc
     */
    public function getExtendedType()
    {
        return FormType::class;
    }

    /**
     * @inheritdoc
     */
    public static function getExtendedTypes()
    {
        return [FormType::class];
    }
}
