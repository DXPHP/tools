<?php

class Preg
{

    protected static $patterns = [
        //邮箱
        'email'   => '/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/',
        //网址
        'url'     => '/^(((ht|f)tps?):\/\/)?([^!@#$%^&*?.\s-]([^!@#$%^&*?.\s]{0,63}[^!@#$%^&*?.\s])?\.)+[a-z]{2,6}\/?/',
        //手机号
        'phone'   => '/^(13[0-9]|14[01456879]|15[0-35-9]|16[2567]|17[0-8]|18[0-9]|19[0-35-9])\d{8}$/',
        //电话
        'tell'    => '/^(?:(?:\d{3}-)?\d{8}|^(?:\d{4}-)?\d{7,8})(?:-\d+)?$/',
        //域名
        'domain'  => '/[a-zA-Z0-9][-a-zA-Z0-9]{0,62}(\.[a-zA-Z0-9][-a-zA-Z0-9]{0,62})+\.?/',
        //身份证
        'idcard'  => '/(^\d{15}$)|(^\d{18}$)|(^\d{17}(\d|X|x)$)/',
        //汉字
        'chinese' => '/^[\u4e00-\u9fa5]{0,}$/',
        //密码(以字母开头，长度在6~18之间，只能包含字母、数字和下划线)
        'pwd1'    => '/^[a-zA-Z]\w{5,17}$/',
        //强密码(必须包含大小写字母和数字的组合，不能使用特殊字符，长度在 8-10 之间)
        'pwd2'    => '/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[a-zA-Z0-9]{8,10}$/',
        //强密码(必须包含大小写字母和数字的组合，可以使用特殊字符，长度在8-10之间)：
        'pwd3'    => '/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,10}$/',
        //日期格式
        'date'    => '/^\d{4}-\d{1,2}-\d{1,2}/',
        //日期(严谨, 支持闰年判断)
        'date1'   => '/^(([0-9]{3}[1-9]|[0-9]{2}[1-9][0-9]{1}|[0-9]{1}[1-9][0-9]{2}|[1-9][0-9]{3})-(((0[13578]|1[02])-(0[1-9]|[12][0-9]|3[01]))|((0[469]|11)-(0[1-9]|[12][0-9]|30))|(02-(0[1-9]|[1][0-9]|2[0-8]))))|((([0-9]{2})(0[48]|[2468][048]|[13579][26])|((0[48]|[2468][048]|[3579][26])00))-02-29)$/',
        //邮编
        'post'    => '/[1-9]\d{5}(?!\d)/',
        //ipv4
        'ipv4'    => '/((2(5[0-5]|[0-4]\d))|[0-1]?\d{1,2})(\.((2(5[0-5]|[0-4]\d))|[0-1]?\d{1,2})){3}/',
        //qq
        'qq'      => '/[1-9][0-9]{4,}/',
        //车牌号 (新能源+非新能源)
        'plate'   => '/^[京津沪渝冀豫云辽黑湘皖鲁新苏浙赣鄂桂甘晋蒙陕吉闽贵粤青藏川宁琼使领A-Z]{1}[A-Z]{1}[A-Z0-9]{4}[A-Z0-9挂学警港澳]{1}$/',
        //mac地址
        'mac'     => '/^((([a-f0-9]{2}:){5})|(([a-f0-9]{2}-){5}))[a-f0-9]{2}$/i',
        //图片链接地址
        'img'     => '/^https?:\/\/(.+\/)+.+(\.(gif|png|jpg|jpeg|webp|svg|psd|bmp|tif))$/i',
        //视频链接地址
        'video'   => '/^https?:\/\/(.+\/)+.+(\.(swf|avi|flv|mpg|rm|mov|wav|asf|3gp|mkv|rmvb|mp4))$/i',

    ];

    /**
     * 模式
     * @param $pattern
     * @return bool|string
     */
    public static function pattern($pattern) {
        if (!$pattern) {
            return false;
        }
        return self::$patterns[ $pattern ];
    }

    /**
     * 判断字符串是否符合条件
     * @param $pattern
     * @param $subject
     * @return bool
     */
    public static function match($pattern,$subject){
        if (preg_match(self::$patterns[ $pattern ],$subject)){
            return true;
        }
        return false;
    }

    /**
     * 返回匹配到的字符串
     * @param $pattern
     * @param $subject
     * @return mixed
     */
    public static function returnMatch($pattern,$subject){
        $pattern = self::$patterns[ $pattern ];
        preg_match($pattern,$subject,$match);
        return $match[0];
    }

}

