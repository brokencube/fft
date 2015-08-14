<?php

require_once 'src/FFT.php';

$data = [1,4,9,16,25,36,49,64];

$output = \Brokencube\FFT\FFT::run($data);

var_dump($output);

