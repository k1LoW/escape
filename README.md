# Auto escaping plugin for CakePHP #

## Requirements ##

* PHP >= 5.2.6
* CakePHP >= 2.0

## Installation ##

First, put `escape’ directory on app/plugins in your CakePHP application.

Second, add the following code in app_controller.php

    <?php
        class AppController extends Controller {
            var $components = array('Escape.Escape');
        }

## Escape type ##

### use htmlspecialchars() and html_entity_decode() ###

Escape / decode valiables.

* `d()' decode escaped valiables.

app_controller.php example

    <?php
        class AppController extends Controller {
            var $components = array('Escape.Escape');
        }

view.ctp example

    <?php echo $escaped; // echo escaped value; ?>
    <?php echo d($escaped); // echo decode value; ?>  

### create object and set escaped/raw value ###

app_controller.php example

    <?php
        class AppController extends Controller {
            var $components = array('Escape.Escape' => array('objectEscape' => true));
        }

view.ctp example

    <?php echo $escaped; // echo escaped value; ?>
    <?php echo $escaped->raw; // echo raw value; ?>  

## $this->data escape ##

If you do not escape $this->data, add the following code in app_controller.php.

    <?php
        class AppController extends Controller {
            var $components = array('Escape.Escape' => array('formDataEscape' => false));
        }

## TODO ##

* Auto Decoding in FormHelper::input()
