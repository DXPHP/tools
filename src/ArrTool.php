<?php
namespace Tools;

/**
 * 数组处理工具
 * Class ArrTool
 * @package Tools
 */
class ArrTool
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
        $obj = ( array )$objParam;
        foreach ($obj as $key => $value) {
            if (is_object($value)) {
                self::object2Array($value);
                $obj [ $key ] = ( array )$value;
            }
        }
        return $obj;
    }

    /**
     * 多维数组转一维数组
     * @param $array
     * @return array
     */
    public static function rebuildArray($array) {
        static $arr = array();
        for ($i = 0; $i < count($array); $i++) {
            if (is_array($array[ $i ])) {
                self::rebuildArray($array[ $i ]);
            } else {
                $arr[] = $array[ $i ];
            }
        }
        return $arr;
    }
}
