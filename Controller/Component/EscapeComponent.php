<?php

/**
 * d
 *
 * @param string $text Text to decode
 * @param string $charset Character set to use when decoding.  Defaults to config value in 'App.encoding' or 'UTF-8'
 * @return string decoded text
 */
function d($text, $charset = null) {
    if (is_array($text)) {
        return array_map('d', $text);
    }

    static $defaultCharset = false;
    if ($defaultCharset === false) {
        $defaultCharset = Configure::read('App.encoding');
        if ($defaultCharset === null) {
            $defaultCharset = 'UTF-8';
        }
    }
    if ($charset) {
        return html_entity_decode($text, ENT_QUOTES, $charset);
    } else {
        return html_entity_decode($text, ENT_QUOTES, $defaultCharset);
    }
}

/**
 * Escaper
 *
 * @params
 */
class Escaper {

    public $escaped = null;
    public $raw = null;

    public function __construct($value, $charset = 'UTF-8') {
        $this->escaped = htmlspecialchars($value, ENT_QUOTES, $charset);
        $this->raw = $value;
    }

    public function __toString() {
        return $this->escaped;
    }

}

/**
 * EscapeComponent code license:
 *
 * @copyright   Copyright (C) 2011 by 101000code/101000LAB
 * @since       CakePHP(tm) v 1.3
 * @license     http://www.opensource.org/licenses/mit-license.php The MIT License
 */
class EscapeComponent extends Component {

    private $_settings = array(
        'objectEscape' => false,
        'formDataEscape' => true,
        'enabled' => true
    );

    /**
     * initialize
     *
     * @return
     */
    public function initialize($controller) {
        $this->settings = Set::merge($this->_settings, $this->settings);
        $this->controller = $this->_Collection->getController();
    }

    /**
     * beforeRender
     *
     * @return
     */
    public function beforeRender($controller) {
        if ($this->settings['enabled']) {
            $this->automate();
        }
    }

    /**
     * enable
     *
     * @return
     */
    function enable($controller, $enabled){
        if (!is_bool($enabled)) {
            return false;
        }
        $this->settings['enabled'] = $enabled;
        return true;
    }

    /**
     * automate
     * wrap value through h()
     *
     * @return
     */
    public function automate() {
        if ($this->settings['objectEscape']) {
            $this->controller->viewVars = $this->_createObject($this->controller->viewVars);
            if ($this->settings['formDataEscape']) {
                if (!empty($this->controller->request->data)) {
                    $this->controller->request->data = $this->_createObject($this->controller->request->data);
                }
            }
        } else {
            $this->controller->viewVars = $this->_h($this->controller->viewVars);
            if ($this->settings['formDataEscape']) {
                if (!empty($this->controller->request->data)) {
                    $this->controller->request->data = $this->_h($this->controller->request->data);
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