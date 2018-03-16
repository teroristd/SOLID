<?php

namespace application\routers;

class DefaultRouter
{
    public function http()
    {
        return 'http://';
    }

    public function host()
    {
        return $_SERVER['HTTP_HOST'];
    }

    public function projectName()
    {
        $projectName = explode('/', filter_input(INPUT_SERVER, 'PHP_SELF'));

        return $projectName[1];
    }

    public function getUrl()
    {
        return $_SERVER['REQUEST_URI'];
    }

    public function getFullUrl()
    {
        return $this->http() . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    }

    public function link()
    {
        // TODO In hosting must use this link
        //return $this->http() . $this->host();

        return $this->http() . $this->host() . '/' . $this->projectName() . '/public';
    }

    public function linkUploads()
    {
        // TODO In hosting must use this link
        //return $this->http() . $this->host();

        return $this->http() . $this->host() . '/' . $this->projectName();
    }
}