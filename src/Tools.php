<?php

namespace Tools;

class Tools
{
    /**
     * 数组转对象
     * @param $array
     * @return bool|stdClass
     */
    public static function array2Object($array) {
        if (!is_array($array)) {
            return $array;
        }
        $object = new \stdClass();
        if (is_array($array) && count($array) > 0) {
            foreach ($array as $name => $value) {
                $name = strtolower(trim($name));
                if ($name) {
                    $object->$name = self::array2Object($value);
                }
            }
            return $object;
        } else {
            return false;
        }
    }

    /**
     * 对象转换成数组
     * @param $objParam
     * @return array
     */
    public static function object2Array($objParam) {
        $obj_param = ( array )$objParam;
        foreach ($obj_param as $key => $value) {
            if (is_object($value)) {
                self::object2Array($value);
                $obj_param [ $key ] = ( array )$value;
            }
        }
        return $obj_param;
    }
}

