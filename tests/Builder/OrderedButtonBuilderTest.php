<?php

/*
 * This file is part of the Ivory Ordered Form package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Tenolo\FormOrdered\Tests\Builder;

use  Tenolo\FormOrdered\Builder\OrderedButtonBuilder;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class OrderedButtonBuilderTest extends AbstractOrderedBuilderTest
{
    /**
     * {@inheritdoc}
     */
    protected function createOrderedBuilder()
    {
        return new OrderedButtonBuilder('foo', []);
    }
}
