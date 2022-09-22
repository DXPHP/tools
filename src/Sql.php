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
     * @param $data
     * @return bool|string
     */
    public static function insertSql($table, $data) {
        $arrValues = array();
        if (empty($table) || !is_array($data)) {
            return false;
        }
        $sql = "INSERT INTO %s( %s ) values %s ";
        foreach ($data as $k => $v) {
            $arrValues[ $k ] = "'" . implode("','", array_values($v)) . "'";
        }
        $sql = sprintf(
            $sql,
            "`".$table."`",
            "`" . implode("` ,`", array_keys($data[0])) . "`",
            "(" . implode(") , (", array_values($arrValues)) . ");"
        );
        return $sql;
    }

    /**
     * @param $table
     * @param $data
     * @param $field 要更新的字段
     * @param string $con 更新的条件
     * @return bool|string
     */
    public static function updateFiledSql($table,$data,$field,$con='id'){
        if ($field == $con) return false;
        $conStr = implode(',',array_column($data,$con));
        $sql = "UPDATE `{$table}` SET `{$field}` = CASE `{$con}` ";
        foreach($data as $key=>$value){
            $sql .= sprintf(" WHEN %s THEN '%s' ",$value[$con],$value[$field]);
        }
        $sql .= "END WHERE `{$con}` IN ($conStr)";
        return $sql;
    }


    public static function updateFiledsSql($table,$data,$con='id'){
        //拼接批量更新sql语句
        $sql = "UPDATE `{$table}` SET ";
        foreach ($data[0] as $key => $value) {
            if ($key!=$con) {
                $sql .= "`{$key}` = CASE `{$con}` ";
                foreach ($data as $k=>$v) {
                    $sql .= sprintf("WHEN %d THEN '%s' ", $v[$con], $v[$key]);
                }
                $sql .= "END, ";
            }
        }
        //把最后一个,去掉
        $sql = substr($sql, 0, strrpos($sql,',')); 
        $conStr = implode(',',array_column($data,$con));
        $sql .= " WHERE ID IN ({$conStr});";
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
echo Sql::updateFiledSql('user',$arr,'name','id');
//UPDATE `user` SET `name` = CASE `id`  WHEN 1 THEN 'zhangsan'  WHEN 2 THEN 'lisi'  WHEN 3 THEN 'wangwu' END WHERE `id` IN (1,2,3)

echo Sql::updateFiledsSql('user',$arr,'id');
//UPDATE `user` SET `name` = CASE `id` WHEN 1 THEN 'zhangsan' WHEN 2 THEN 'lisi' WHEN 3 THEN 'wangwu' END, `age` = CASE `id` WHEN 1 THEN '20' WHEN 2 THEN '22' WHEN 3 THEN '25' END WHERE ID IN (1,2,3);*/