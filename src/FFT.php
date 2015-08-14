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

    public static function run(array $input_real, array $input_im = null)
    {
    	static $fft, $tr, $ti, $tlength;
		$length = count($input_real);
		
		// Use previously calculated values if length of data is the same as the last FFT we ran
		if ($tlength != $length)
		{
			$tlength = $length;
			$halfLength = $length / 2;
			for ($i = 0; $i < $halfLength; ++$i) {
				$p = $i / $length;
				$t = -2 * M_PI * $p;
				$tr[$i] = cos($t);
				$ti[$i] = sin($t);
			}
			
			$fft = function ($real, $im) use (&$fft, $tr, $ti, $tlength) {
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
	
				list($even_real, $even_im) = $fft($even_real, $even_im);
				list($odd_real, $odd_im) = $fft($odd_real, $odd_im);
	
				for ($i = 0; $i < $halfLength; ++$i) {
	
					// $t = $t->cexp(); -- Precalculated for ~20% speed improvement
					$p = $i / $length;
					$t_real = $tr[$p * $tlength];
					$t_im = $ti[$p * $tlength];
	
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
			};
		}


		return $fft($input_real, $input_im);
	}
}
