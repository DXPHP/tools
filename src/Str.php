<?php

class Str
{
    /**
     * [getRandom 获取随机字符串]
     * @param  string  $type [description]
     * @param  integer $len  [description]
     * @return [type]        [description]
     */
	public static function getRandom($type = 'alnum', $len = 8)
    {
        switch ($type) {
            case 'alpha':
            case 'alnum':
            case 'numeric':
            case 'nozero':
                switch ($type) {
                    case 'alpha':
                        $pool = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                        break;
                    case 'alnum':
                        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                        break;
                    case 'numeric':
                        $pool = '0123456789';
                        break;
                    case 'nozero':
                        $pool = '123456789';
                        break;
                }
                return substr(str_shuffle(str_repeat($pool, ceil($len / strlen($pool)))), 0, $len);
            case 'unique':
            case 'md5':
                return md5(uniqid(mt_rand()));
            case 'encrypt':
            case 'sha1':
                return sha1(uniqid(mt_rand(), true));
        }
    }

    /**
     * [avatar 首字母头像 fastadmin的方法]
     * @param  [type] $text
     * @return [type]
     */
    public static function avatar($text) {
        $total = unpack('L', hash('adler32', $text, true))[1];
        $hue = $total % 360;
        list($r, $g, $b) = self::hsv2rgb($hue / 360, 0.3, 0.9);

        $bg = "rgb({$r},{$g},{$b})";
        $color = "#ffffff";
        $first = mb_strtoupper(mb_substr($text, 0, 1));
        $src = base64_encode(
            '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" height="100" width="100"><rect fill="' . $bg . '" x="0" y="0" width="100" height="100"></rect><text x="50" y="50" font-size="50" text-copy="fast" fill="' . $color . '" text-anchor="middle" text-rights="admin" dominant-baseline="central">' . $first . '</text></svg>'
        );
        $value = 'data:image/svg+xml;base64,' . $src;
        return $value;
    }

    /**
     * [hsv2rgb fastadmin的方法]
     */
    public static function hsv2rgb($h, $s, $v) {
        $r = $g = $b = 0;

        $i = floor($h * 6);
        $f = $h * 6 - $i;
        $p = $v * (1 - $s);
        $q = $v * (1 - $f * $s);
        $t = $v * (1 - (1 - $f) * $s);

        switch ($i % 6) {
            case 0:
                $r = $v;
                $g = $t;
                $b = $p;
                break;
            case 1:
                $r = $q;
                $g = $v;
                $b = $p;
                break;
            case 2:
                $r = $p;
                $g = $v;
                $b = $t;
                break;
            case 3:
                $r = $p;
                $g = $q;
                $b = $v;
                break;
            case 4:
                $r = $t;
                $g = $p;
                $b = $v;
                break;
            case 5:
                $r = $v;
                $g = $p;
                $b = $q;
                break;
        }

        return [
            floor($r * 255),
            floor($g * 255),
            floor($b * 255)
        ];
    }

    /**
     * 字符串转数组 支持中文
     * @param $str
     * @param int $split_len
     * @return array|bool|mixed
     */
    public static function strSplitUtf8($str, $split_len = 1) {
        if (!is_numeric($split_len) ||  $split_len < 1) {
            return false;
        }
        $len = mb_strlen($str, 'UTF-8');
        if ($len <= $split_len) {
            return array($str);
        }
        preg_match_all('/.{' . $split_len . '}|[^\x00]{1,' . $split_len . '}$/us', $str, $match);
        return $match[0];
    }

    /**
     * 根据坐标计算两个点的距离
     * @param $point1 114.018864,22.59099
     * @param $point2 113.273773,23.149345
     * @return float|int
     */
    public static function getDistanceBetweenPoints($point1,$point2) {
        $point1 = explode(',', $point1);
        $latitude1 = $point1[0];
        $longitude1 = $point1[1];
        $point2 = explode(',', $point2);
        $latitude2 = $point2[0];
        $longitude2 = $point2[1];
        $theta = $longitude1 - $longitude2;
        $miles = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))) + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta)));
        $miles = acos($miles);
        $miles = rad2deg($miles);
        $miles = $miles * 60 * 1.1515;
        $feet = $miles * 5280;
        $yards = $feet / 3;
        $kilometers = $miles * 1.609344;
        $meters = $kilometers * 1000;
        // return compact('miles','feet','yards','kilometers','meters');
        return $meters;
    }
}

