<?php

/*
 * This file is part of the Ivory Ordered Form package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace  Tenolo\FormOrdered\Tests\Builder;

use Tenolo\FormOrdered\Builder\OrderedFormBuilder;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\FormFactoryInterface;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class OrderedFormBuilderTest extends AbstractOrderedBuilderTest
{
    /**
     * {@inheritdoc}
     */
    protected function createOrderedBuilder()
    {
        return new OrderedFormBuilder(
            'foo',
            null,
            $this->createMock(EventDispatcherInterface::class),
            $this->createMock(FormFactoryInterface::class)
        );
    }
}
