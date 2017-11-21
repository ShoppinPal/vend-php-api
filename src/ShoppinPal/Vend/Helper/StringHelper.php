<?php

namespace ShoppinPal\Vend\Helper;

/**
 * Helper class for simple string manipulations
 */
class StringHelper {

    /**
     * Converts an under_scored string to camelCase.
     *
     * @param string $string
     *
     * @return string
     */
    public static function underScoreToCamel($string)
    {
        return lcfirst(implode('', array_map(function ($a) {
            return ucfirst($a);
        }, explode('_', $string))));
    }

    /**
     * Converts a camelCase string to under_scored
     *
     * @param string $string
     *
     * @return string
     */
    public static function camelToUnderScore($string)
    {
        return strtolower(implode('_', preg_split(
            '/((?:[A-Z]|[0-9]+)[a-z]*)/',
            $string,
            -1,
            PREG_SPLIT_DELIM_CAPTURE|PREG_SPLIT_NO_EMPTY
        )));
    }
}
