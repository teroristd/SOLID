<?php

namespace application;

class View
{
    private $_config;
    private $_configArr = array();
    private $_viewPath;
    private $_viewDir;
    private $_extension = '.php';
    private $_data = array();
    private $_layoutParts = array();
    private $_layoutData = array();

    public function __construct(Config $config)
    {
        $this->_config = $config;

        $this->_configArr = $this->_config->getConfigFile('viewArr');

        if (is_array($this->_configArr) && is_dir($this->_configArr[0]) && is_readable($this->_configArr[0]))
        {
            $this->_viewPath = realpath($this->_configArr[0]);
        }
        elseif ($this->_viewPath === null)
        {
            $this->_viewPath = realpath('../views/');
        }
    }

    private function setViewDir($path)
    {
        if (trim($path))
        {
            $path = realpath($path) . DIRECTORY_SEPARATOR;

            if (is_dir($path) && is_readable($path))
            {
                $this->_viewDir = $path;
            }
            else
            {
                throw new \Exception('Invalid Path Param In: ' . __METHOD__, 500);
            }
        }
        else
        {
            throw new \Exception('Missing Path Param In: ' . __METHOD__, 500);
        }
    }

    public function setLayout($key, $template)
    {
        if ($key && $template)
        {
            $this->_layoutParts[$key] = $template;
        }
        else
        {
            throw new \Exception('Layout Require Valid Key And Template In: ' . __METHOD__, 500);
        }
    }

    public function getLayout($name)
    {
        return $this->_layoutData[$name];
    }

    public function display($name, $data = array(), $returnAsString = false)
    {
        if (is_array($data))
        {
            $this->_data = array_merge($this->_data, $data);
        }

        if (count($this->_layoutParts) > 0)
        {
            foreach ($this->_layoutParts as $key => $val)
            {
                $result = $this->incFile($val);

                if ($result)
                {
                    $this->_layoutData[$key] = $result;
                }
            }
        }

        if ($returnAsString)
        {
            return $this->incFile($name);
        }
        else
        {
            echo $this->incFile($name);
        }
    }

    private function incFile($path)
    {
        if ($this->_viewDir === null)
        {
            $this->setViewDir($this->_viewPath);
        }

        $file = $this->_viewDir . str_replace('/', DIRECTORY_SEPARATOR, $path) . $this->_extension;

        if (file_exists($file) && is_readable($file))
        {
            ob_start();

            require_once $file;

            return ob_get_clean();
        }
        else
        {
            throw new \Exception('This View Can Not Be Included In: ' . __METHOD__, 500);
        }
    }

    public function setData($name, $value)
    {
        $this->_data[$name] = $value;
    }

    public function getData($name)
    {
        return $this->_data[$name];
    }
}