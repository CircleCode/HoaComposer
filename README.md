Hoa/Composer
===========

Compatibility layer between Hoa and Composer/PSR-0 autoloaders.

Typical patch to apply to Hoa libraries : https://github.com/jubianchi/Stream/commit/d0b2ae9058e6c2e5ffea06877a0e753aecfe942e
This has to be done for every Hoa library so that they provide every information needed to automatically generate a PSR-0 autoloader.

## Compatibility layer

This library makes the ```from```/```import```calls optionnal in the context of a PSR-0 autoloader, making it handle class resolution instead of using the Hoa's built-in autoloader.
Currently, this is only a POC and has to be improved to fully cover Hoa's functionnalities.

Check out the [example.php](example.php) file to get a tiny example.

This library has to be manually activated by requiring its main file **before** the autoloader (see [example.php (from line 3 to 4)](example.php#L3-L4))
