<?php

namespace Tenolo\FormOrdered;

use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\Form\ResolvedFormTypeFactory;
use Symfony\Component\Form\ResolvedFormTypeInterface;
use Tenolo\FormOrdered\Orderer\FormOrderer;
use Tenolo\FormOrdered\Orderer\FormOrdererInterface;

/**
 * Class OrderedResolvedFormTypeFactory
 *
 * @package Tenolo\FormOrdered
 * @author  GeLo <geloen.eric@gmail.com>
 * @author  Nikita Loges
 * @company tenolo GbR
 */
class OrderedResolvedFormTypeFactory extends ResolvedFormTypeFactory
{

    /** @var FormOrdererInterface */
    protected $orderer;

    /**
     * @param FormOrdererInterface|null $orderer
     */
    public function __construct(FormOrdererInterface $orderer = null)
    {
        $this->orderer = $orderer ?: new FormOrderer();
    }

    /**
     * @inheritdoc
     */
    public function createResolvedType(FormTypeInterface $type, array $typeExtensions, ResolvedFormTypeInterface $parent = null)
    {
        return new OrderedResolvedFormType($this->orderer, $type, $typeExtensions, $parent);
    }
}
