<?php
App::uses('AppHelper', 'View/Helper');

class EscapeHelper extends AppHelper {

    private $view;

    /**
     * __construct
     *
     * @return
     */
    function __construct(View $View, $settings = array()) {
        $this->view = $View;
        parent::__construct($View, $settings);
    }

    /**
     * beforeRender
     *
     * @param
     */
    public function beforeRender($viewFile){
        parent::beforeRender($viewFile);
        if(Configure::read('Escape.enabled')) {
            $this->automate();
        }
    }

    /**
     * automate
     * wrap value through h()
     *
     * @return
     */
    public function automate() {
        if (Configure::read('Escape.objectEscape')) {
            $this->view->viewVars = $this->_createObject($this->view->viewVars);
            if (Configure::read('Escape.formDataEscape')) {
                if (!empty($this->view->request->data)) {
                    $this->view->request->data = $this->_createObject($this->view->request->data);
                }
            }
        } else {
            $this->view->viewVars = $this->_h($this->view->viewVars);
            if (Configure::read('Escape.formDataEscape')) {
                if (!empty($this->view->request->data)) {
                    $this->view->request->data = $this->_h($this->view->request->data);
                }
            }
        }
    }

    /**
     * _h
     *
     * @param string $text Text to escape
     * @param string $charset Character set to use when escape.  Defaults to config value in 'App.encoding' or 'UTF-8'
     * @return string decoded text
     */
    private function _h($text, $charset = null) {
        if (is_array($text)) {
            return array_map(array($this, '_h'), $text);
        }
        static $defaultCharset = false;
        if ($defaultCharset === false) {
            $defaultCharset = Configure::read('App.encoding');
            if ($defaultCharset === null) {
                $defaultCharset = 'UTF-8';
            }
        }
        if (!is_string($text)) {
            return $text;
        }
        if ($charset) {
            return htmlspecialchars($text, ENT_QUOTES, $charset);
        } else {
            return htmlspecialchars($text, ENT_QUOTES, $defaultCharset);
        }
    }

    /**
     * _createObject
     *
     * @param string $text Text to escape
     * @param string $charset Character set to use when escape.  Defaults to config value in 'App.encoding' or 'UTF-8'
     * @return string decoded text
     */
    private function _createObject($text, $charset = null) {
        if (is_array($text)) {
            return array_map(array($this, '_createObject'), $text);
        }
        static $defaultCharset = false;
        if ($defaultCharset === false) {
            $defaultCharset = Configure::read('App.encoding');
            if ($defaultCharset === null) {
                $defaultCharset = 'UTF-8';
            }
        }
        if (is_object($text)) {
            return $text;
        }
        if ($charset) {
            return new Escaper($text, $charset);
        } else {
            return new Escaper($text, $defaultCharset);
        }
    }

}