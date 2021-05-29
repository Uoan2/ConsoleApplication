<?php

namespace DmitryFedorov\ConsoleTest\Collections;

abstract class AbstractCollection implements \ArrayAccess, \Iterator, \Countable
{
    private $position = 0;

    public $collection = [];

    /**
     *
     * @param  $value
     * @param $offset
     * @return void
     */
    public function offsetSet($value, $offset = null): void
    {
        $this->checkValueForInstance($value);

        if (is_null($offset)) {
            $this->collection[] = $value;
        } else {
            $this->collection[$offset] = $value;
        }
    }

    /**
     *
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset): bool
    {
        return isset($this->collection[$offset]);
    }

    /**
     *
     * @param mixed $offset
     * @return void
     */
    public function offsetUnset($offset): void
    {
        unset($this->collection[$offset]);
    }

    /**
     *
     * @param mixed $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return isset($this->collection[$offset]) ? $this->collection[$offset] : null;
    }

    /**
     *
     * @return void
     */
    public function next(): void
    {
        $this->position++;
    }

    /**
     *
     * @return integer
     */
    public function key(): int
    {
        return $this->position;
    }

    /**
     *
     * @return boolean
     */
    public function valid(): bool
    {
        return array_key_exists($this->position, $this->collection);
    }

    /**
     *
     * @return void
     */
    public function rewind(): void
    {
        $this->position = 0;
    }

    /**
     *
     * @return mixed
     */
    public function current()
    {
        return $this->collection[$this->position];
    }

    /**
     *
     * @return integer
     */
    public function count(): int
    {
        return count($this->collection);
    }

    /**
     * check Value for instance of object
     *
     * @param object $value
     * @return void
     */
    abstract protected function checkValueForInstance($value): void;
}
