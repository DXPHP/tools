# tools
#### 封装了一些工作中常用到的方法(有工作用到自己写的，也有网上看到值得记录的，也有一些是框架里面搬过来的)

```
composer require weifd/tools 
```



#### Demo

```php
use \Tools\Arr;

Arr::array2Object();
```

```php
use \Tools\Sql;

$arr = [
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

echo Sql::updateFiledSql('user',$arr,'name','id');
//UPDATE `user` SET `name` = CASE `id`  WHEN 1 THEN 'zhangsan'  WHEN 2 THEN 'lisi'  WHEN 3 THEN 'wangwu' END WHERE `id` IN (1,2,3);
```

