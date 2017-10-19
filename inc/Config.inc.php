<?php
function __autoload($classes) {

    $diretorios = array('Controller/','Model/');

    foreach ($diretorios as $valor) {
        if (file_exists($valor . $classes . '.class.php')) {
            require_once $valor . $classes . '.class.php';
        }elseif (file_exists('../'.$valor . $classes . '.class.php')){
            require_once '../'.$valor . $classes . '.class.php';
        }elseif (file_exists('../../'.$valor . $classes . '.class.php')){
            require_once '../../'.$valor . $classes . '.class.php';
        }
    }
}
