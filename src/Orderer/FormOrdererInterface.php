<?php

namespace Tenolo\FormOrdered\Orderer;

use Symfony\Component\Form\FormInterface;

/**
 * Interface FormOrdererInterface
 *
 * @package Tenolo\FormOrdered\Orderer
 * @author  GeLo <geloen.eric@gmail.com>
 * @author  Nikita Loges
 * @company tenolo GbR
 */
interface FormOrdererInterface
{
    /**
     * @param FormInterface $form
     *
     * @return array
     */
    public function order(FormInterface $form);
}
