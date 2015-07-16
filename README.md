# Brokencube\FFT\FFT
PHP FFT class based on Javascript implementation from http://rosettacode.org/wiki/Fast_Fourier_transform#Javascript

Originally used a Complex class, as per the original javascript, but moved to twin arrays ($real, $im) and inlining the complex arithmatic after benchmarks showed that to be at least twice as fast.
