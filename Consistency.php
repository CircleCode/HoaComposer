<?php
namespace Hoa\Composer {

class Consistency {
    private static $_multiton = array();

    private $_family;

    public static function instance($family) {
        if(false === isset(static::$_multiton[$family])) {
            static::$_multiton[$family] = new static($family);
        }

        return static::$_multiton[$family];
    }

    public static function from($family) {
        return static::instance($family);
    }

    private function __construct($family) {
        $this->_family = $family;
    }

    public function import($imported) {
        $resolved = $this->resolve($imported);

        if(false === class_exists($resolved)) {
            $alias = implode('\\', array_slice(explode('\\', $resolved), 0, -1));

            if(false === class_exists($alias) && false === interface_exists($alias)) {
                class_alias($resolved, $alias);
            }
        }

        return $this;
    }

    public function resolve($import) {
        $parts = explode('.', $import);

        array_walk(
            $parts,
            function(& $part, $key) use($parts) {
                if(false !== strpos($part, '~')) {
                    $part = str_replace('~', $parts[$key - 1], $part);
                }
            }
        );

        $import = implode('\\', $parts);

        return $this->_family . '\\' . $import;
    }
}

}

namespace {

if(false === function_exists('from')) {
    function from($family) {
        return Hoa\Composer\Consistency::instance($family);
    }
}

}
