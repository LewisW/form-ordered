<?php

namespace Tenolo\FormOrdered;

use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\Form\ButtonTypeInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\ResolvedFormType;
use Symfony\Component\Form\ResolvedFormTypeInterface;
use Symfony\Component\Form\SubmitButtonTypeInterface;
use Tenolo\FormOrdered\Builder\OrderedButtonBuilder;
use Tenolo\FormOrdered\Builder\OrderedFormBuilder;
use Tenolo\FormOrdered\Builder\OrderedSubmitButtonBuilder;
use Tenolo\FormOrdered\Orderer\FormOrdererInterface;

/**
 * Class OrderedResolvedFormType
 *
 * @package Tenolo\FormOrdered
 * @author  GeLo <geloen.eric@gmail.com>
 * @author  Nikita Loges
 * @company tenolo GbR
 */
class OrderedResolvedFormType extends ResolvedFormType
{

    /** @var FormOrdererInterface */
    private $orderer;

    /**
     * @param FormOrdererInterface           $orderer
     * @param FormTypeInterface              $innerType
     * @param array                          $typeExtensions
     * @param ResolvedFormTypeInterface|null $parent
     */
    public function __construct(FormOrdererInterface $orderer, FormTypeInterface $innerType, array $typeExtensions = [], ResolvedFormTypeInterface $parent = null)
    {
        parent::__construct($innerType, $typeExtensions, $parent);

        $this->orderer = $orderer;
    }

    /**
     * @inheritdoc
     */
    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        parent::finishView($view, $form, $options);

        $children = $view->children;
        $view->children = [];

        foreach ($this->orderer->order($form) as $name) {
            if (!isset($children[$name])) {
                continue;
            }

            $view->children[$name] = $children[$name];
            unset($children[$name]);
        }

        foreach ($children as $name => $child) {
            $view->children[$name] = $child;
        }
    }

    /**
     * @inheritdoc
     */
    protected function newBuilder($name, $dataClass, FormFactoryInterface $factory, array $options)
    {
        $innerType = $this->getInnerType();

        if ($innerType instanceof ButtonTypeInterface) {
            return new OrderedButtonBuilder($name, $options);
        }

        if ($innerType instanceof SubmitButtonTypeInterface) {
            return new OrderedSubmitButtonBuilder($name, $options);
        }

        return new OrderedFormBuilder($name, $dataClass, new EventDispatcher(), $factory, $options);
    }
}
