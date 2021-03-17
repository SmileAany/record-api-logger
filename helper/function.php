<?php

if(!function_exists('custom_transformation_millisecond')){
    /**
     * 将毫秒输出成有效的格式
     * @param float $millisecond
     * @return string
     */
    function custom_transformation_millisecond(float $millisecond) : string {
        $seconds = $millisecond / 1000;

        if ($seconds < 0.001) {
            return round($seconds * 1000000).'μs';
        }

        if ($seconds < 1) {
            return round($seconds * 1000, 2).'ms';
        }

        return round($seconds, 2).'s';
    }
}