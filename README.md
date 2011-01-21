# Auto escaping plugin for CakePHP #

## Installation ##

First, put `escape’ directory on app/plugins in your CakePHP application.

Second, add the following code in app_controller.php

    <?php
        class AppController extends Controller {
            var $components = array('Escape.Escape');
        }

## raw() ##

`raw()' decode escaped valiables.

## TODO ##

* Auto Decoding in FormHelper::input()