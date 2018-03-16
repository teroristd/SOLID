<?php

namespace application;

class Normalize
{
    private $_xss;

    public function __construct(XSS $xss)
    {
        $this->_xss = $xss;
    }

    public function get($value, $normalize = null)
    {
        if (array_key_exists($value, $_GET))
        {
            if ($normalize != null)
            {
                return $this->normalize(filter_input(INPUT_GET, $value, FILTER_SANITIZE_STRING), $normalize);
            }
            return filter_input(INPUT_GET, $value, FILTER_SANITIZE_STRING);
        }
        return null;
    }

    public function post($value, $normalize = null)
    {
        if (array_key_exists($value, $_POST))
        {
            if ($normalize != null)
            {
                return $this->normalize(filter_input(INPUT_POST, $value, FILTER_SANITIZE_STRING), $normalize);
            }
            return filter_input(INPUT_POST, $value, FILTER_SANITIZE_STRING);
        }
        return null;
    }

    public function cookie($value, $normalize = null)
    {
        if (array_key_exists($value, $_COOKIE))
        {
            if ($normalize != null)
            {
                return $this->normalize(filter_input(INPUT_COOKIE, $value, FILTER_SANITIZE_STRING), $normalize);
            }
            return filter_input(INPUT_COOKIE, $value, FILTER_SANITIZE_STRING);
        }
        return null;
    }

    private function normalize($data, $type)
    {
        $type = explode('|', $type);

        if (is_array($type))
        {
            foreach ($type as $val)
            {
                if ($val == 'int')
                {
                    $data = (int)$data;
                }
                if ($val == 'float')
                {
                    $data = (float)$data;
                }
                if ($val == 'double')
                {
                    $data = (double)$data;
                }
                if ($val == 'bool')
                {
                    $data = (bool)$data;
                }
                if ($val == 'string')
                {
                    $data = (string)$data;
                }
                if ($val == 'trim')
                {
                    $data = trim($data);
                }
                if ($val == 'xss')
                {
                    $data = $this->_xss->xss_clean($data);
                }
            }
        }
        return $data;
    }
}