<?php

namespace module\main\driver;

use module\main\driver\UserSession;
use Mustache_Loader_FilesystemLoader;
use module\main\usecase\TranslateToLanguage;

class MustacheEngine extends \Mustache_Engine
{

    public function __construct(array $options = array())
    {
        global $CFG;
        $this->setOptionCache($options);
        $this->setOptionCharset($options);
        $this->setOptionLoader($options);
        $this->addHelper('CFG', $CFG);
        $this->addHelper('USER', (new UserSession())->get());
        $this->addHelper('lang', function($value) {
            $params = explode(',', $value);
            if (count($params) == 2) {
                return (new TranslateToLanguage())->translate($params[0], $params[1]);
            }
            return null;
        });
        return parent::__construct($options);
    }

    private function setOptionCache(array &$options)
    {
        global $PATH;
        if (empty($options['cache'])) {
            $options['cache'] = $PATH->cache . DIRECTORY_SEPARATOR . 'mustache';
        }
        $options['cache_file_mode'] = 0777;
    }

    private function setOptionCharset(array &$options)
    {
        global $CFG;
        if (empty($options['charset'])) {
            $options['charset'] = $CFG->environment->charset;
        }
    }

    private function setOptionLoader(array &$options)
    {
        global $PATH;
        $loader = (empty($options['loader'])) ? $PATH->module . DIRECTORY_SEPARATOR . 'view' : $options['loader'];
        $options['loader'] = new Mustache_Loader_FilesystemLoader($loader);
        $options['partials_loader'] = new Mustache_Loader_FilesystemLoader($loader);
    }

}
