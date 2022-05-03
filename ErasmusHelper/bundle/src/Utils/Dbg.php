<?php

namespace AgileBundle\Utils;

use AgileBundle\Bundle;

/**
 * Class Dbg
 * Logging and debug
 *
 * @package AgileBundle\Utils
 */
class Dbg {

    /**
     * Text color depending on log level
     *
     * @const string[]
     */
    const LOG_COLORS = [
        LOG_DEBUG   => '1;90',
        LOG_INFO    => '1;32',
        LOG_NOTICE  => '0;37',
        LOG_WARNING => '0;35',
        LOG_ERR     => '1;33',
        LOG_CRIT    => '0;31',
    ];

    /**
     * Init the PHP default log behavior and change the default log file
     */
    public static function init() {
        ini_set("log_errors", 1);
        ini_set("error_log", Dbg::getFileName());
        ini_set("memory_limit", "128M");
        if (is_dev()) {
            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);
        }
    }

    /**
     * Write a log message in the current log file with the given log level
     *
     * @param $msg
     * @param int|string $level
     * @return bool
     */
    private static function logs($msg, $level = LOG_NOTICE): bool {
        if (is_array($msg)) $msg = print_r($msg, true);
        if (is_object($msg)) $msg = json_encode($msg);
        if (is_int($level)) $level = self::colorize($level);

        $ms = substr(microtime(true) - time(), 2, 2);
        $content = "\e[1;90m" . date('H:i:s') . ".$ms | " . Bundle::getInstance()->dbgPrefix . " | \e[" . $level . "m" . $msg . "\e[0m\n";
        syslog(LOG_NOTICE, $content);
        return file_put_contents(self::getFileName(), $content, FILE_APPEND);
    }

    /**
     * Return the colorization chain for the given log level
     *
     * @param int $level
     * @return int|string
     */
    private static function colorize(int $level): int|string {
        return (isset(self::LOG_COLORS[$level]) ? self::LOG_COLORS[$level] : $level);
    }

    // ************* Logs functions ******************** //

    public static function info($data) { self::logs($data, LOG_NOTICE); }
    public static function debug($data) { self::logs($data, LOG_DEBUG); }
    public static function warning($data) { self::logs($data, LOG_WARNING); }
    public static function error($data) { self::logs($data, LOG_ERR); }
    public static function critical($data) { self::logs($data, LOG_CRIT); }
    public static function success($data) { self::logs($data, LOG_INFO); }

    // ************* Logs functions ******************** //

    /**
     * Return the path to the logs folder
     *
     * @return string
     */
    static public function getPath(): string {
        $filePath[0] = Bundle::getInstance()->projectRoot . '/data/logs/';
        $filePath[1] = $filePath[0] . date('Y') . "/";
        $filePath[2] = $filePath[1] . date('m') . "/";

        foreach ($filePath as $fp) {
            if (!file_exists($fp)) {
                mkdir($fp);
                chmod($fp, 0774);
            }
        }
        return $filePath[2];
    }

    /**
     * Return the actual log file name
     *
     * @return string
     */
    public static function getFileName(): string {
        return self::getPath() . date('d') . '.log';
    }

}
