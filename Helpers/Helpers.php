<?php
//declare(strict_types=1);

namespace Framework\Helpers;

use DateTime;
use Framework\Config\AppConfig;

class Helpers
{
    /**
     * @return string
     */
    public static function url() : string {
        $self = $_SERVER['PHP_SELF'];
        $index = basename($self);
        $directories = str_replace($index, '', $self);

        return $directories;
    }

    /**
     * @param string $path
     */
    public static function redirect(string $path = AppConfig::DEFAULT_REDIRECTION) {
        header("Location: " . self::url() . $path);
        exit;
    }

    /**
     * @param string $haystack
     * @param string $needle
     * @return bool
     */
    public static function startsWith(string $haystack, string $needle) : bool {
        // search backwards starting from haystack length characters from the end
        return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== FALSE;
    }

    /**
     * @param string $haystack
     * @param string $needle
     * @return bool
     */
    public static function endsWith(string $haystack, string $needle) : bool {
        // search forward starting from end minus needle length characters
        return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== FALSE);
    }

    /**
     * @param $input
     * @return bool
     */
    public static function isInteger($input) : bool{
        return(ctype_digit(strval($input)));
    }

    /**
     * @param string $filePath
     * @param string $content
     */
    public static function writeInFile(string $filePath,string $content){
        $fh = fopen($filePath, 'w+');
        fwrite($fh, $content);
        fclose($fh);
    }

    /**
     * @param string $filePath
     * @param string $folderPath
     * @return bool
     */
    public static function needScan(string $filePath, string $folderPath) : bool{
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

    /**
     * @param string $timestamp
     * @return bool
     */
    public static function isValidTimeStamp(string $timestamp) : bool {
        return ((string) (int) $timestamp === $timestamp)
        && ($timestamp <= PHP_INT_MAX)
        && ($timestamp >= ~PHP_INT_MAX);
    }

    /**
     * @param string $date
     * @param string $format
     * @return bool
     */
    public static function validateDate(string $date, string $format = 'Y-m-d H:i') : bool
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }
}