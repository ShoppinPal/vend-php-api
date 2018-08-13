<?php

namespace ShoppinPal\Vend\DataObject\Entity;

use ShoppinPal\Vend\Helper\StringHelper;
use YapepBase\Exception\ParameterException;
use YapepBase\DataObject\NotSetValue;

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
     * @param bool   $skipNotSetValues        If TRUE, values not explicitly set will not have the not set value.
     *
     * @throws ParameterException If an unknown property is encountered and using throw.
     */
    public function __construct(
        array $data = [],
        $unknownPropertyHandling = self::UNKNOWN_PROPERTY_THROW,
        $skipNotSetValues = false
    ) {
        if (!$skipNotSetValues) {
            $this->setAllPropertiesToNotSet();
        }

        foreach ($data as $key => $value) {
            $this->setProperty($key, $value, $unknownPropertyHandling);
        }
    }

    /**
     * Returns the data in the DO as an underscored array (as used by the Vend API).
     *
     * Properties defined in the entity, that are marked to be ignored will never be included.
     *
     * @param array $ignoredProperties Properties listed in this array will not be included.
     * @param bool  $removeNulls       If TRUE, null values will be removed from the entity.
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

            if ($value instanceof NotSetValue || ($removeNulls && $value === null)) {
                continue;
            }

            $index = StringHelper::camelToUnderScore($propertyName);

            if (array_key_exists($propertyName, $this->subEntities)) {
                if ($value === null) {
                    $result[$index] = null;
                } elseif ($this->subEntities[$propertyName][self::SUB_ENTITY_KEY_TYPE] == self::SUB_ENTITY_TYPE_COLLECTION) {
                    $result[$index] = [];

                    foreach ($value as $subEntity) {
                        if ($subEntity instanceof EntityDoAbstract) {
                            $result[$index][] = $subEntity->toUnderscoredArray([], $removeNulls);
                        } else {
                            $result[$index][] = $subEntity;
                        }
                    }

                } else {
                    if ($value instanceof EntityDoAbstract) {
                        $result[$index] = $value->toUnderscoredArray([], $removeNulls);
                    } else {
                        $result[$index] = $value;
                    }
                }
            } else {
                $result[$index] = $value;
            }
        }

        return $result;
    }

    /**
     * Replaces all not set values in the entity with NULLs
     *
     * @return static
     */
    public function notSetsToNull()
    {
        foreach ($this->getProperties() as $property) {
            if ($this->$property instanceof NotSetValue) {
                $this->$property = null;
            }
        }

        return $this;
    }

    /**
     * Sets all properties of the entity to the special NotSetValue
     *
     * @return void
     */
    protected function setAllPropertiesToNotSet()
    {
        $notSetValue = new NotSetValue();

        foreach ($this->getProperties() as $property) {
            if (null === $this->$property) {
                $this->$property = $notSetValue;
            }
        }
    }

    /**
     * Returns the list of properties that are sent to Vend
     *
     * @return array
     */
    protected function getProperties()
    {
        $properties = [];

        $ignoredProperties = array_merge($this->ignoredProperties, ['subEntities', 'ignoredProperties']);

        foreach (get_object_vars($this) as $propertyName => $value) {
            if (in_array($propertyName, $ignoredProperties)) {
                continue;
            }

            $properties[] = $propertyName;
        }

        return $properties;
    }

    /**
     * @param string $key
     * @param mixed  $value
     * @param string $unknownPropertyHandling
     *
     * @return void
     * @throws ParameterException
     */
    protected function setProperty($key, $value, $unknownPropertyHandling = self::UNKNOWN_PROPERTY_THROW)
    {
        $propertyName = StringHelper::underScoreToCamel($key);

        if (!property_exists($this, $propertyName)) {
            $this->handleMissingProperty($propertyName, $unknownPropertyHandling);
        }

        if (array_key_exists($propertyName, $this->subEntities)) {
            $className = $this->subEntities[$propertyName][self::SUB_ENTITY_KEY_CLASS];

            if ($this->subEntities[$propertyName][self::SUB_ENTITY_KEY_TYPE] == self::SUB_ENTITY_TYPE_COLLECTION) {
                if (is_array($value)) {
                    $tmpValue = [];
                    foreach ($value as $subEntity) {
                        $tmpValue[] = new $className($subEntity, $unknownPropertyHandling);
                    }
                } else {
                    $tmpValue = null;
                }
                $this->$propertyName = $tmpValue;
            } else {
                $this->$propertyName = null === $value ? null : new $className($value, $unknownPropertyHandling);
            }
        } else {
            $this->$propertyName = $value;
        }
    }

    /**
     *
     *
     * @param string $propertyName
     * @param string $unknownPropertyHandling
     *
     * @return void
     * @throws ParameterException
     */
    protected function handleMissingProperty($propertyName, $unknownPropertyHandling)
    {
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
}
