<?php

namespace Tools;

/**
 * Class Sql
 * @package Tools
 */
class Sql
{
    /**
     * @param $table
     * @param $array
     * @return bool|string
     */
    public static function insertSql($table, $array) {
        $arrValues = array();
        if (empty($table) || !is_array($array)) {
            return false;
        }
        $sql = "INSERT INTO %s( %s ) values %s ";
        foreach ($array as $k => $v) {
            $arrValues[ $k ] = "'" . implode("','", array_values($v)) . "'";
        }
        $sql = sprintf(
            $sql,
            "`".$table."`",
            "`" . implode("` ,`", array_keys($array[0])) . "`",
            "(" . implode(") , (", array_values($arrValues)) . ");"
        );
        return $sql;
    }

    /**
     * @param $table
     * @param $array
     * @param $field 要更新的字段
     * @param string $con 更新的条件
     * @return bool|string
     */
    public static function updateSql($table,$array,$field,$con='id'){
        if ($field == $con) return false;
        $conStr = implode(',',array_column($array,$con));
        $sql = "UPDATE `{$table}` SET `{$field}` = CASE `{$con}` ";
        foreach($array as $key=>$value){
            $sql .= sprintf(" WHEN %s THEN '%s' ",$value[$con],$value[$field]);
        }
        $sql .= "END WHERE `{$con}` IN ($conStr)";
        return $sql;
    }
}

/*$arr = [
    [
        'name' => 'zhang3',
        'age' => '20',
        'height' => 180,
    ],
    [
        'name' => 'li4',
        'age' => '25',
        'height' => 170,
    ],
];
echo Sql::insertSql('user',$arr);
//INSERT INTO `user`( `name` ,`age` ,`height` ) values ('zhang3','20','180') , ('li4','25','170');
*/

/*$arr = [
    [
        'id'=> 1,
        'name' => 'zhangsan',
        'age' => '20',
    ],
    [
        'id'=> 2,
        'name' => 'lisi',
        'age' => '22',
    ],
    [
        'id'=> 3,
        'name' => 'wangwu',
        'age' => '25',
    ],
];
echo Sql::updateSql('user',$arr,'name','id');
//UPDATE `user` SET `name` = CASE `id`  WHEN 1 THEN 'zhangsan'  WHEN 2 THEN 'lisi'  WHEN 3 THEN 'wangwu' END WHERE `id` IN (1,2,3)*/
