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
 * @copyright   Copyright (C) 2012 by 101000code/101000LAB
 * @since       CakePHP(tm) v 1.3
 * @license     http://www.opensource.org/licenses/mit-license.php The MIT License
 */
class EscapeComponent extends Component {

    private $default = array(
        'objectEscape' => false,
        'formDataEscape' => true,
        'enabled' => true
    );

    /**
     * initialize
     *
     * @return
     */
    public function initialize(Controller $controller) {
        $this->settings = Set::merge($this->default, $this->settings);
        $this->controller = $this->_Collection->getController();
        Configure::write('Escape.objectEscape', $this->settings['objectEscape']);
        Configure::write('Escape.formDataEscape', $this->settings['formDataEscape']);
        Configure::write('Escape.enabled', $this->settings['enabled']);
    }

    /**
     * startup
     *
     * @param &$controller
     * @return
     */
    public function startup(Controller $controller) {
        $controller->helpers[] = 'Escape.Escape';
    }

    /**
     * enable
     *
     * @return
     */
    public function enable($enabled){
        if (!is_bool($enabled)) {
            return false;
        }
        $this->settings['enabled'] = $enabled;
        Configure::write('Escape.enabled', $enabled);
        return true;
    }
}