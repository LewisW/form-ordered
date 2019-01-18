<?php

namespace Tenolo\FormOrdered\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class AbstractOrderedExtension
 *
 * @package Tenolo\FormOrdered\Extension
 * @author  GeLo <geloen.eric@gmail.com>
 * @author  Nikita Loges
 * @company tenolo GbR
 */
abstract class AbstractOrderedExtension extends AbstractTypeExtension
{

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->setPosition($options['position']);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('position', null);
        $resolver->setAllowedTypes('position', ['null', 'string', 'array']);
    }
}
