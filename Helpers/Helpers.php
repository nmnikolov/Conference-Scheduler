<?php
//declare(strict_types=1);

namespace Framework\Helpers;

use Framework\Config\AppConfig;

class Helpers
{
    public static function url(){
        $self = $_SERVER['PHP_SELF'];
        $index = basename($self);
        $directories = str_replace($index, '', $self);

        return $directories;
    }

    public static function redirect($path = AppConfig::DEFAULT_REDIRECTION) {
        header("Location: " . self::url() . $path);
        exit;
    }

    public static function startsWith($haystack, $needle) {
        // search backwards starting from haystack length characters from the end
        return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== FALSE;
    }
    public static function endsWith($haystack, $needle) {
        // search forward starting from end minus needle length characters
        return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== FALSE);
    }

    public static function isInteger($input){
        return(ctype_digit(strval($input)));
    }

    public static function writeInFile(string $filePath,string $content){
        $fh = fopen($filePath, 'w+');
        fwrite($fh, $content);
        fclose($fh);
    }

//    public static function needScan(string $filePath, string $folderPath) : bool{
    public static function needScan(string $filePath, string $folderPath){
        if (file_exists($filePath)) {
            $fh = fopen($filePath, 'r');
            $time = fgets($fh);
            fclose($fh);
            if ($time !== "" && self::isValidTimeStamp($time)) {
                $lastChanges = filemtime($folderPath);
                if (intval($time) >= $lastChanges) {
                    return false;
                }
            }
        }

        return true;
    }

//    public static function isValidTimeStamp(string $timestamp) : bool {
    public static function isValidTimeStamp(string $timestamp){
        return ((string) (int) $timestamp === $timestamp)
        && ($timestamp <= PHP_INT_MAX)
        && ($timestamp >= ~PHP_INT_MAX);
    }
}