<?php
namespace Hoa\Composer {

class Consistency {
    protected static $_multiton = array();

    protected $_family;

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

        if(null !== ($alias = $this->alias($resolved))) {
            class_alias($resolved, $alias);
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

    public function alias($resolved) {
        if(false === class_exists($resolved, false)) {
            $parts = $resolved = explode('\\', $resolved);
            $class = array_pop($parts);
            $ns = array_pop($parts);

            if($class === $ns) {
                $alias = implode('\\', array_slice($resolved, 0, -1));

                if(false === class_exists($alias) && false === interface_exists($alias)) {
                    return $alias;
                }
            }
        }
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
