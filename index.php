<?php
include 'src/Yanatoon.php';

use danilo9\Yanatoon;

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

//print_r(glob("./src/imgs/background/*.png"));
Yanatoon::setContentType();
Yanatoon::randomSize(512)->printImage();