<?php
App::uses('AppHelper', 'View/Helper');

class PathHelper extends AppHelper {
    public function myroot() {
    	echo str_replace("//","/", $this->webroot); 
    }
}