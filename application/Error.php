<?php

namespace application;

class Error
{
    private $_WARNING = array(2 => 'E_WARNING', 512 => 'E_USER_WARNING', 32 => 'E_CORE_WARNING', 128 => 'E_COMPILE_WARNING');
    private $_NOTICE = array(8 => 'E_NOTICE', 1024 => 'E_USER_NOTICE', 8192 => 'E_DEPRECATED', 16384 => 'E_USER_DEPRECATED', 32767 => 'E_ALL');

    public function __construct()
    {
        set_error_handler(array($this, 'errorHandler'));
    }

    public function errorHandler($errno, $errstr, $errfile, $errline)
    {
        if (!(error_reporting() & $errno))
        {
            return;
        }
        else
        {
            if (array_key_exists($errno, $this->_WARNING))
            {
                $ErrorWarning = 'In ' . date('d-m-Y H:i:s') . ' is received ' . $errstr . ' at ' . $errfile . ' in line:' . $errline;

                error_log($ErrorWarning . PHP_EOL . PHP_EOL, 3, "../errors/WarningErrorLog.log");
            }
            if (array_key_exists($errno, $this->_NOTICE))
            {
                $ErrorNotice = 'In ' . date('d-m-Y H:i:s') . ' is received ' . $errstr . ' at ' . $errfile . ' in line:' . $errline;

                error_log($ErrorNotice . PHP_EOL . PHP_EOL, 3, "../errors/NoticeErrorLog.log");
            }
            if (!array_key_exists($errno, $this->_WARNING) && !array_key_exists($errno, $this->_NOTICE))
            {
                $ErrorFatal = 'In ' . date('d-m-Y H:i:s') . ' is received ' . $errstr . ' at ' . $errfile . ' in line:' . $errline;

                error_log($ErrorFatal . PHP_EOL . PHP_EOL, 3, "../errors/FatalErrorLog.log");
            }
            throw new \ErrorException($errstr, 0, $errno, $errfile, $errline);
        }
    }
}