<?php

class FFTTest extends PHPUnit_Framework_TestCase
{
    function testFFT() {
        $data = [1,4,9,16,25,36,49,64];
        
        list($real, $im) = \Brokencube\FFT\FFT::run($data);
        
        $this->assertEquals([
            204.0,
            -12.686291501015,
            -32.0,
            -35.313708498985,
            -36.0,
            -35.313708498985,
            -32.0,
            -12.686291501015
        ], $real, "Real Output Incorrect");

        $this->assertEquals([
            0.0,
            96.568542494924,
            40.0,
            16.568542494924,
            0,
            -16.568542494924,
            -40.0,
            -96.568542494924
        ], $im, "Complex Output Incorrect");
    }
}