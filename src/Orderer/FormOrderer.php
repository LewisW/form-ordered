<?php

namespace Tenolo\FormOrdered\Orderer;

use Symfony\Component\Form\FormInterface;
use Tenolo\FormOrdered\Exception\OrderedConfigurationException;

/**
 * Class FormOrderer
 *
 * @package Tenolo\FormOrdered\Orderer
 * @author  GeLo <geloen.eric@gmail.com>
 * @author  Nikita Loges
 * @company tenolo GbR
 */
class FormOrderer implements FormOrdererInterface
{

    /** @var array */
    protected $weights;

    /** @var array */
    protected $differed;

    /** @var int */
    protected $firstWeight;

    /** @var int */
    protected $currentWeight;

    /** @var int */
    protected $lastWeight;

    /**
     * @inheritdoc
     */
    public function order(FormInterface $form)
    {
        $this->reset();

        foreach ($form as $child) {
            $position = $child->getConfig()->getPosition();

            if (empty($position)) {
                $this->processEmptyPosition($child);
            } elseif (is_string($position)) {
                $this->processStringPosition($child, $position);
            } else {
                $this->processArrayPosition($child, $position);
            }
        }

        asort($this->weights, SORT_NUMERIC);

        return array_keys($this->weights);
    }

    /**
     * @param FormInterface $form
     */
    protected function processEmptyPosition(FormInterface $form)
    {
        $this->processWeight($form, $this->currentWeight);
    }

    /**
     * @param FormInterface $form
     * @param string        $position
     */
    protected function processStringPosition(FormInterface $form, $position)
    {
        if ($position === 'first') {
            $this->processFirst($form);
        } else {
            $this->processLast($form);
        }
    }

    /**
     * @param FormInterface $form
     * @param array         $position
     */
    protected function processArrayPosition(FormInterface $form, array $position)
    {
        if (isset($position['before'])) {
            $this->processBefore($form, $position['before']);
        }

        if (isset($position['after'])) {
            $this->processAfter($form, $position['after']);
        }
    }

    /**
     * @param FormInterface $form
     */
    protected function processFirst(FormInterface $form)
    {
        $this->processWeight($form, $this->firstWeight++);
    }

    /**
     * @param FormInterface $form
     */
    protected function processLast(FormInterface $form)
    {
        $this->processWeight($form, $this->lastWeight + 1);
    }

    /**
     * @param FormInterface $form
     * @param string        $before
     */
    protected function processBefore(FormInterface $form, $before)
    {
        if (!isset($this->weights[$before])) {
            $this->processDiffered($form, $before, 'before');
        } else {
            $this->processWeight($form, $this->weights[$before]);
        }
    }

    /**
     * @param FormInterface $form
     * @param string        $after
     */
    protected function processAfter(FormInterface $form, $after)
    {
        if (!isset($this->weights[$after])) {
            $this->processDiffered($form, $after, 'after');
        } else {
            $this->processWeight($form, $this->weights[$after] + 1);
        }
    }

    /**
     * @param FormInterface $form
     * @param int           $weight
     */
    protected function processWeight(FormInterface $form, $weight)
    {
        foreach ($this->weights as &$weightRef) {
            if ($weightRef >= $weight) {
                ++$weightRef;
            }
        }

        if ($this->currentWeight >= $weight) {
            ++$this->currentWeight;
        }

        ++$this->lastWeight;

        $this->weights[$form->getName()] = $weight;
        $this->finishWeight($form, $weight);
    }

    /**
     * @param FormInterface $form
     * @param int           $weight
     * @param string        $position
     *
     * @return int
     */
    protected function finishWeight(FormInterface $form, $weight, $position = null)
    {
        if ($position === null) {
            foreach (array_keys($this->differed) as $position) {
                $weight = $this->finishWeight($form, $weight, $position);
            }
        } else {
            $name = $form->getName();

            if (isset($this->differed[$position][$name])) {
                $postIncrement = $position === 'before';

                foreach ($this->differed[$position][$name] as $differed) {
                    $this->processWeight($differed, $postIncrement ? $weight++ : ++$weight);
                }

                unset($this->differed[$position][$name]);
            }
        }

        return $weight;
    }

    /**
     * @param FormInterface $form
     * @param string        $differed
     * @param string        $position
     *
     * @throws OrderedConfigurationException
     */
    protected function processDiffered(FormInterface $form, $differed, $position)
    {
        if (!$form->getParent()->has($differed)) {
            throw OrderedConfigurationException::createInvalidDiffered($form->getName(), $position, $differed);
        }

        $this->differed[$position][$differed][] = $form;

        $name = $form->getName();

        $this->detectCircularDiffered($name, $position);
        $this->detectedSymmetricDiffered($name, $differed, $position);
    }

    /**
     * @param string $name
     * @param string $position
     * @param array  $stack
     *
     * @throws OrderedConfigurationException
     */
    protected function detectCircularDiffered($name, $position, array $stack = [])
    {
        if (!isset($this->differed[$position][$name])) {
            return;
        }

        $stack[] = $name;

        foreach ($this->differed[$position][$name] as $differed) {
            $differedName = $differed->getName();

            if ($differedName === $stack[0]) {
                throw OrderedConfigurationException::createCircularDiffered($stack, $position);
            }

            $this->detectCircularDiffered($differedName, $position, $stack);
        }
    }

    /**
     * @param string $name
     * @param string $differed
     * @param string $position
     *
     * @throws OrderedConfigurationException
     */
    protected function detectedSymmetricDiffered($name, $differed, $position)
    {
        $reversePosition = ($position === 'before') ? 'after' : 'before';

        if (isset($this->differed[$reversePosition][$name])) {
            foreach ($this->differed[$reversePosition][$name] as $diff) {
                if ($diff->getName() === $differed) {
                    throw OrderedConfigurationException::createSymetricDiffered($name, $differed);
                }
            }
        }
    }

    /**
     *
     */
    protected function reset()
    {
        $this->weights = [];
        $this->differed = [
            'before' => [],
            'after'  => [],
        ];

        $this->firstWeight = 0;
        $this->currentWeight = 0;
        $this->lastWeight = 0;
    }
}
