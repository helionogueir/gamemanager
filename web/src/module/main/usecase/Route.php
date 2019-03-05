<?php

namespace module\main\usecase;

use module\main\Usecase;

class Route implements Usecase
{

    private $request = null;
    private $modulename = null;
    private $controllername = null;

    public function __construct(string $request)
    {
        $this->setRequest($request);
        $this->setModulename();
        $this->setControllername();
        return $this;
    }

    public function getRequest()
    {
        return $this->request;
    }

    public function getModulename()
    {
        return $this->modulename;
    }

    public function getControllername()
    {
        return $this->controllername;
    }

    private function setRequest(string $request)
    {
        global $CFG;
        $this->request = empty($request) ?
                $CFG->environment->default : $request;
    }

    private function setModulename()
    {
        global $CFG;
        if (!empty($this->request)) {
            list($module) = explode('/', $this->request);
        }
        $this->modulename = empty($module) ?
                $CFG->environment->default : $module;
    }

    private function setControllername()
    {
        global $PATH;
        $filename = $PATH->dirroot
                . DIRECTORY_SEPARATOR . 'module'
                . DIRECTORY_SEPARATOR . $this->modulename
                . DIRECTORY_SEPARATOR . 'routes.json';
        if (file_exists($filename)) {
            $routes = json_decode(file_get_contents($filename));
            if (JSON_ERROR_NONE == json_last_error()) {
                foreach ($routes as $regexp => $classname) {
                    if (preg_match("#^({$regexp})$#", $this->request)) {
                        $this->controllername = $classname;
                        break;
                    }
                }
            }
        }
    }

}
