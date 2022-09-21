<?php

namespace Tools;

/**
 * 数组处理工具
 * Class Arr
 * @package Tools
 */
class Arr
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
     * 数组转XML
     * @param $array
     * @param string $root
     * @return string
     */
    public static function array2Xml($array, $root = 'xml') {
        $xml = '<?xml version="1.0" encoding="utf-8"?>';
        $xml .= '<' . $root . '>';
        $xml .= self::arr2Xml($array);
        $xml .= '</' . $root . '>';
        return $xml;
    }

    private static function arr2Xml($array) {
        $xml = '';
        foreach ($array as $key => $value) {
            is_numeric($key) && $key = "item id=\"$key\"";
            $xml .= "<$key>";
            $xml .= (is_array($value) || is_object($value)) ? self::arr2Xml($value) : $value;
            list($key,) = explode(' ', $key);
            $xml .= "</$key>";
        }
        return $xml;
    }

    /**
     * xml转数组
     * @param $xml
     * @return mixed
     */
    public static function xml2Array($xml) {
        //禁止引用外部xml实体
        libxml_disable_entity_loader(true);
        $xmlstring = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
        $arr = json_decode(json_encode($xmlstring), true);
        return $arr;
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

    /**
     * 删除数组中指定元素
     * @param array $array
     * @param $value
     * @return array
     */
    public static function removeValue(array &$array, $value) {
        $index = \array_search($value, $array);
        if (false !== $index) {
            unset($array[ $index ]);
        }
        return $array;
    }

    /**
     * 根据键名获取数组中某一列的值
     * @param $array
     * @param $field
     * @return array
     */
    public static function getArrColumn($array, $field) {
        $arr = [];
        foreach ($array as $key => $value) {
            if ($value[ $field ]) {
                $arr[] = $value[ $field ];
            }
        }
        return $arr;
    }

    /**
     * 多维数组根据某个字段排序
     * @param $array
     * @param $field
     * @param string $order desc asc
     * @return mixed
     */
    public static function sortArrByfield($array, $field, $order = 'desc') {
        $column = array_column($array, $field);
        if ($order == 'desc') {
            array_multisort($column, SORT_DESC, $array);
        } else {
            array_multisort($column, SORT_ASC, $array);
        }
        return $array;
    }

    /**
     * 一维数组去重
     * @param $array
     * @return array
     */
    public static function uniqueArr($array) {
        return array_flip(array_flip($array));
    }

    /**
     * 获取二维数组中的某一列
     * @param $array
     * @param $field
     * @return array
     */
    public static function getColumn($array, $field) {
        $arr = [];
        foreach ($array as $key => $value) {
            if (is_array($value) && isset($value[ $field ])) {
                $arr[] = $value[ $field ];
            } else {
                $arr[ $field ] = $array[ $field ];
            }
        }
        return $arr;
    }

}
