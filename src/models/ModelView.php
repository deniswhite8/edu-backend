<?php

namespace App\Model;

class ModelView implements ISessionUser
{
    private $_layoutDir;
    private $_templateDir;
    private $_layout;
    private $_template;
    private $_params;
    private $_session;

    public function __construct($layoutDir, $templateDir, $layout, $template, $params)
    {
        $this->_layoutDir = $layoutDir;
        $this->_templateDir = $templateDir;
        $this->_layout = $layout;
        $this->_template = $template;
        $this->_params = $params;
    }

    public function setLayout($layout)
    {
        $this->_layout = $layout;
    }

    public function renderToString()
    {
        ob_start();

        if (isset($this->_layout))
            $this->render();
        else
            $this->renderTemplate();

        $contents = ob_get_contents();
        ob_end_clean();

        return $contents;
    }

    public function render()
    {
        require_once $this->_layoutDir . $this->_layout . '.phtml';
    }

    public function renderTemplate()
    {
        require_once $this->_templateDir . $this->_template . '.phtml';
    }

    public function get($param)
    {
        return $this->_params[$param];
    }

    public function set($param, $value)
    {
        $this->_params[$param] = $value;
    }

    public function setSession(Session $session)
    {
        $this->_session = $session;
    }

    public function session()
    {
        return $this->_session;
    }
}
 