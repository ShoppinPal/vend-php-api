<?php
namespace ShoppinPal\Vend\DataObject\Entity;

trait ArrayAccessEntity
{
    public function offsetExists($offset)
    {
        return in_array($offset, $this->getValidOffsets());
    }

    public function offsetGet($offset)
    {
        return $this->offsetExists($offset) ? $this->$offset : null;
    }

    public function offsetSet($offset, $value)
    {
        if ($this->offsetExists($offset)) {
            $this->setProperty($offset, $value);
        }
    }

    public function offsetUnset($offset)
    {
        if ($this->offsetExists($offset)) {
            $this->$offset = null;
        }
    }

    public function jsonSerialize()
    {
        return $this->toUnderscoredArray([], false);
    }

    /**
     * Returns the allowed offsets to access
     *
     * @return array
     */
    abstract protected function getValidOffsets();

    /**
     * @param string $key
     * @param mixed  $value
     * @param string $unknownPropertyHandling
     *
     * @return mixed
     */
    abstract protected function setProperty(
        $key,
        $value,
        $unknownPropertyHandling = EntityDoAbstract::UNKNOWN_PROPERTY_THROW
    );

    /**
     * @param array $ignoredProperties Properties listed in this array will not be included.
     * @param bool  $removeNulls       If TRUE, null values will be removed from the entity.
     *
     * @return array
     */
    abstract public function toUnderscoredArray(array $ignoredProperties = [], $removeNulls = false);
}
