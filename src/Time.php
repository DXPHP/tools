<?php

/**
 * 时间工具类
 * Class Time
 */
class Time
{
    /**
     * 计算两个时间间隔天数
     * @param $time1 [时间戳或者正确的日期格式]
     * @param $time2 [时间戳或者正确的日期格式]
     * @return string
     */
    public static function intervalDays($time1, $time2) {
        $time1 = is_numeric($time1) ? $time1 : strtotime($time1);
        $time2 = is_numeric($time2) ? $time2 : strtotime($time2);
        $interval = date_diff(
            date_create(date('Y-m-d', $time1)),
            date_create(date('Y-m-d', $time2))
        );
        $days = $interval->format('%a');
        return $days;
    }

    /**
     * 获取今日开始和结束的时间戳
     * @return array
     */
    public static function today() {
        list($y, $m, $d) = explode('-', date('Y-m-d'));
        return [
            mktime(0, 0, 0, $m, $d, $y),
            mktime(23, 59, 59, $m, $d, $y)
        ];
    }

    /**
     * 获取昨天开始和结束的时间戳
     * @return array
     */
    public static function yesterday() {
        $today = strtotime(date('Y-m-d'));
        return [
            $today - 86400,
            $today - 1,
        ];
    }

    /**
     * 获取这周的开始和结束的时间戳
     * @return array
     */
    public static function thisWeek() {
        return [
            strtotime('this week 00:00:00'),
            strtotime('next week 00:00:00') - 1
        ];
    }

    /**
     * 获取上周的开始和结束的时间戳
     * @return array
     */
    public static function lastWeek() {
        return [
            strtotime('last week 00:00:00'),
            strtotime('this week 00:00:00') - 1
        ];
    }

    /**
     * 获取这个月的开始和结束的时间戳
     * @return array
     */
    public static function thisMonth() {
        return [
            strtotime(date('Y-m-01')),
            strtotime(date('Y-m-t 23:59:59'))
        ];
    }

    /**
     * 获取上个月的开始和结束的时间戳
     * @return array
     */
    public static function lastMonth() {
        return [
            strtotime('first Day of last month 00:00:00'),
            strtotime('first Day of this month 00:00:00') - 1,
        ];
    }

    /**
     * 获取过去的时间
     * @param $time
     * @return string
     */
    public static function timeAgo($time) {
        $time = is_numeric($time) ? $time : strtotime($time);
        if (time() < $time) {
            return '不能大于当前时间';
        }
        $timeDiff = time() - $time;
        if ($timeDiff <10) {
            $msg = '刚刚';
        } else if ($timeDiff >= 10 && $timeDiff < 60) {
            $msg = $timeDiff . '秒前';
        } else if ($timeDiff >= 60 && $timeDiff < 3600) {
            $msg = intval($timeDiff / 60) . '分钟前';
        } else if ($timeDiff >= 3600 && $timeDiff < 86400) {
            $msg = intval($timeDiff / 3600) . '小时前';
        } else if ($timeDiff >= 86400 && $timeDiff < 31536000) {
            $msg = intval($timeDiff / 86400) . '天前';
        } else if ($timeDiff >= 31536000){
            $msg = intval($timeDiff / 31536000) . '年前';
        }
        return $msg;
    }

    /**
     * 获取某个月的天数
     * @param string $month
     * @param string $year
     * @return false|int|string
     */
    public static function daysInMonth($month='', $year='') {
        $month = $month?$month:date('m');
        $year = $year?$year:date('Y');
        if (function_exists("cal_days_in_month")) {
            return cal_days_in_month(CAL_GREGORIAN, $month, $year);
        } else {
            return date('t', mktime(0, 0, 0, $month, 1, $year));
        }
    }
}
