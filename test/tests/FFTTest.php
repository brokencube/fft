<?php

class FFTTest extends PHPUnit_Framework_TestCase
{
    function testFFT() {
        $data = [1,1,1,1,0,0,0,0];
        
        list($real, $im) = \Brokencube\FFT\FFT::run($data);
        
        $this->assertEquals([
            4.0,
            1.0,
            0.0,
            1.0,
            0.0,
            1.0,
            0.0,
            1.0
        ], $real, "Real Output Incorrect");

        $this->assertEquals([
            0.0,
            -2.414213562373095,
            0.0,
            -0.4142135623730949,
            0.0,
            0.41421356237309494,
            0.0,
            2.414213562373095
        ], $im, "Complex Output Incorrect");
    }
}