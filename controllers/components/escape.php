<?php
  /**
   * raw
   *
   * @param string $text Text to decode
   * @param string $charset Character set to use when decoding.  Defaults to config value in 'App.encoding' or 'UTF-8'
   * @return string decoded text
   */
function raw($text, $charset = null) {
    if (is_array($text)) {
        return array_map('raw', $text);
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
 * EscapeComponent code license:
 *
 * @copyright   Copyright (C) 2011 by 101000code/101000LAB
 * @since       CakePHP(tm) v 1.3
 * @license     http://www.opensource.org/licenses/mit-license.php The MIT License
 */
class EscapeComponent extends Object {

    /**
     * initialize
     *
     * @return
     */
    function initialize(&$controller, $settings) {
        $this->controller = $controller;
    }

    /**
     * beforeRender
     *
     * @return
     */
    function beforeRender(&$controller) {
        $this->automate();
    }

    /**
     * automate
     * wrap value through h()
     *
     * @return
     */
    function automate(){
        $this->controller->viewVars = $this->_h($this->controller->viewVars);
        $this->controller->data = $this->_h($this->controller->data);
    }

    /**
     * _h
     *
     * @param string $text Text to escape
     * @param string $charset Character set to use when escape.  Defaults to config value in 'App.encoding' or 'UTF-8'
     * @return string decoded text
     */
    function _h($text, $charset = null) {
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
        if (is_object($text)) {
            return $text;
        }
        if ($charset) {
            return htmlspecialchars($text, ENT_QUOTES, $charset);
        } else {
            return htmlspecialchars($text, ENT_QUOTES, $defaultCharset);
        }
    }

}