<?php
// Based on http://rosettacode.org/wiki/Fast_Fourier_transform#Javascript
namespace Brokencube\FFT;

class FFT
{
    public static function magnitude(array $data)
    {
		list($real, $im) = static::run($data);
		$count = count($real);
        for ($i = 0; $i < $count; $i++) {
            $output[$i] = sqrt(pow($real[$i], 2) + pow($im[$i],2));
        }
        return $output;
    }
    
    public static function run(array $real, array $im = null)
    {
        $length = count($real);
        $halfLength = $length / 2;
        if (!$im) $im = array_fill(0, $length, 0);
        if ($length < 2) return [$real, $im];
        
        for($i = 0; $i < $halfLength; ++$i) {
            $even_real[$i] = $real[$i*2];
            $odd_real[$i] = $real[($i*2)+1];
            $even_im[$i] = $im[$i*2];
            $odd_im[$i] = $im[($i*2)+1];
        }
        
        list($even_real, $even_im) = static::run($even_real, $even_im);
        list($odd_real, $odd_im) = static::run($odd_real, $odd_im);
		
        for ($i = 0; $i < $halfLength; ++$i) {
            $p = $i / $length;
            $t = -2 * M_PI * $p;
            
            // $t = $t->cexp();
            $t_real = cos($t);
            $t_im = sin($t);
            
            // $t = $t->mul($odd[$i]);
            $t_real2 = ($t_real * $odd_real[$i]) - ($t_im * $odd_im[$i]);
            $t_im2 = ($t_real * $odd_im[$i]) + ($t_im * $odd_real[$i]);
            
            // $return[$i] = $even[$i]->add($t);
            $return_real[$i] = $even_real[$i] + $t_real2;
            $return_im[$i] = $even_im[$i] + $t_im2;
            
            //$return[$i + $halfLength] = $even[$i]->sub($t);
            $return_real[$i + $halfLength] = $even_real[$i] - $t_real2;
            $return_im[$i + $halfLength] = $even_im[$i] - $t_im2;
        }
        return [$return_real, $return_im];
    }
}
