<?php
include 'src/Yanatoon.php';

use danilo9\Yanatoon;

Yanatoon::setContentType();
Yanatoon::make(800)->printImage();
