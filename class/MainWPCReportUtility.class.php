<?php
class MainWPCReportUtility
{
    public static function formatTimestamp($timestamp)
    {
        return date_i18n(get_option('date_format') . ' ' . get_option('time_format'), $timestamp);
    }
    
    static function ctype_digit($str)
    {
        return (is_string($str) || is_int($str) || is_float($str)) && preg_match('/^\d+\z/', $str);
    }
    
    public static function mapSite(&$website, $keys)
    {
        $outputSite = array();
        foreach ($keys as $key)
        {
            $outputSite[$key] = $website->$key;
        }
        return $outputSite;
    }    
}