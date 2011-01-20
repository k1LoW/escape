# Auto escaping plugin for CakePHP #

## Insttallation ##

First, put `escape’ directory on app/plugins in your CakePHP application.

Second, add the following code in app_controller.php

    <?php
        class AppController extends Controller {
            var $components = array('Escape.Escape');

            public function beforeRender() {
                $this->Escape->automate(); // escape all valiables
            }
        }

## row() ##

`rouw()' decode escaped valiables.