<?php

namespace Tenolo\FormOrdered;

use Symfony\Component\Form\FormConfigInterface;

/**
 * Interface OrderedFormConfigInterface
 *
 * @package Tenolo\FormOrdered
 * @author  GeLo <geloen.eric@gmail.com>
 * @author  Nikita Loges
 * @company tenolo GbR
 */
interface OrderedFormConfigInterface extends FormConfigInterface
{
    /**
     * @return string|array|null
     */
    public function getPosition();
}
