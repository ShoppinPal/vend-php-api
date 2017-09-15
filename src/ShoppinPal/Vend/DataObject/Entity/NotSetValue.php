<?php
namespace ShoppinPal\Vend\DataObject\Entity;

class NotSetValue implements \JsonSerializable
{

    public function jsonSerialize()
    {
        return null;
    }

    public function __toString()
    {
        return '';
    }
}
