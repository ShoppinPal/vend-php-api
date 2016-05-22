<?php

namespace ShoppinPal\Vend\DataObject\Entity;

use ShoppinPal\Vend\Helper\StringHelper;
use YapepBase\Exception\ParameterException;

/**
 * Base class for entity DOs
 */
class EntityDoAbstract {

    /** Single sub entity type */
    const SUB_ENTITY_TYPE_SINGLE = 'single';

    /** Collection sub entity type */
    const SUB_ENTITY_TYPE_COLLECTION = 'collection';

    /** Sub entity key: type */
    const SUB_ENTITY_KEY_TYPE = 'type';

    /** Sub entity key: class */
    const SUB_ENTITY_KEY_CLASS = 'class';

    /** Throw an exception if encountering an unkown property. */
    const UNKNOWN_PROPERTY_THROW = 'throw';

    /** Trigger a notice if encountering an unknown property. */
    const UNKNOWN_PROPERTY_NOTICE = 'notice';

    /** Ignore unkonwn properties. */
    const UNKNOWN_PROPERTY_IGNORE = 'ignore';

    /**
     * The sub entities for this entity.
     * 
     * @var array
     */
    protected $subEntities = [];

    /**
     * The properties that should be ignored when converting to an array.
     * 
     * @var array
     */
    protected $ignoredProperties = [];

    /**
     * EntityDoAbstract constructor.
     *
     * @param array  $data                    The data to be represented.
     * @param string $unknownPropertyHandling How to handle unknown properties.
     *
     * @throws ParameterException If an unknown property is encountered and using throw.
     */
    public function __construct(array $data = [], $unknownPropertyHandling = self::UNKNOWN_PROPERTY_THROW)
    {
        foreach ($data as $key => $value) {
            $propertyName= StringHelper::underScoreToCamel($key);

            if (!property_exists($this, $propertyName)) {
                $errorMessage = 'Unknown property "' . $propertyName . '" while constructing DO "' . get_class($this) . '".';
                switch ($unknownPropertyHandling) {
                    case self::UNKNOWN_PROPERTY_IGNORE:
                        // Ignore the issue
                        break;

                    case self::UNKNOWN_PROPERTY_NOTICE:
                        trigger_error($errorMessage, E_USER_NOTICE);
                        break;

                    case self::UNKNOWN_PROPERTY_THROW:
                    default:
                        throw new ParameterException($errorMessage);
                }
            }

            if (array_key_exists($propertyName, $this->subEntities)) {
                $className = $this->subEntities[$propertyName][self::SUB_ENTITY_KEY_CLASS];

                if ($this->subEntities[$propertyName][self::SUB_ENTITY_KEY_TYPE] == self::SUB_ENTITY_TYPE_COLLECTION) {
                    $tmpValue = [];
                    foreach ($value as $subEntity) {
                        $tmpValue[] = new $className($subEntity, $unknownPropertyHandling);
                    }
                    $this->$propertyName = $tmpValue;
                } else {
                    $this->$propertyName = new $className($value, $unknownPropertyHandling);
                }
            } else {
                $this->$propertyName = $value;
            }
        }
    }

    /**
     * Returns the data in the DO as an underscored array (as used by the Vend API).
     *
     * Properties defined in the entity, that are marked to be ignored will never be included.
     *
     * @param array $ignoredProperties Properties listed in this array will not be included.
     *
     * @return array
     */
    public function toUnderscoredArray(array $ignoredProperties = [], $removeNulls = false)
    {
        $ignoredProperties = array_merge(
            $ignoredProperties,
            $this->ignoredProperties,
            ['subEntities', 'ignoredProperties']
        );
        $result = [];

        foreach (get_object_vars($this) as $propertyName => $value) {
            if (in_array($propertyName, $ignoredProperties)) {
                continue;
            }

            if ($removeNulls && $value === null) {
                continue;
            }

            $index = StringHelper::camelToUnderScode($propertyName);

            if (array_key_exists($propertyName, $this->subEntities)) {
                if ($value === null) {
                    $result[$index] = null;
                } elseif ($this->subEntities[$propertyName][self::SUB_ENTITY_KEY_TYPE] == self::SUB_ENTITY_TYPE_COLLECTION) {
                    $result[$index] = [];

                    /** @var EntityDoAbstract $subEntity */
                    foreach ($value as $subEntity) {
                        $result[$index][] = $subEntity->toUnderscoredArray([], $removeNulls);
                    }

                } else {
                    /** @var EntityDoAbstract $value */
                    $result[$index] = $value->toUnderscoredArray([], $removeNulls);
                }
            } else {
                $result[$index] = $value;
            }
        }

        return $result;
    }
}
