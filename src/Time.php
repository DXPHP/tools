<?php

/**
 * 时间工具类
 * Class TimeTool
 */
class Time
{
    /**
     * 计算两个时间戳间隔天数
     * @param $time1
     * @param $time2
     * @return string
     */
	public static function intervalDaysBytimestamp( $time1, $time2){
		$interval = date_diff(
            date_create(date('Y-m-d',$time1)),
            date_create(date('Y-m-d', $time2))
        );
        $days = $interval->format('%a');
        return $days;
	}

    /**
     * 计算两个日期间隔天数
     * @param $date1
     * @param $date2
     * @return string
     */
	public static function intervalDaysByDate( $date1, $date2){
		$interval = date_diff(
            date_create($date1),
            date_create($date2)
        );
        $days = $interval->format('%a');
        return $days;
	}
}

