<?php
namespace Hoa\Composer\tests\units;

use atoum;
use Hoa\Composer\Consistency as TestedClass;

require_once __DIR__ . '/../../vendor/autoload.php';

class Consistency extends atoum {
    public function testFrom() {
        $this
            ->object(TestedClass::from(uniqid()))->isInstanceOf('\\Hoa\\Composer\\Consistency')
        ;
    }

    public function testImport() {
        $this
            ->if($object = TestedClass::from(uniqid()))
            ->then
                ->object($object->from(uniqid()))->isIdenticalTo($object)
        ;
    }

    public function testResolve() {
        $this
            ->given($family = uniqid())
            ->and($class = uniqid())
            ->if($object = TestedClass::from($family))
            ->then
                ->string($object->resolve($class))->isEqualTo($family . '\\' . $class)
                ->string($object->resolve($class. '.~'))->isEqualTo($family . '\\' . $class . '\\' . $class)
                ->string($object->resolve($class. '.I~'))->isEqualTo($family . '\\' . $class . '\\I' . $class)
                ->string($object->resolve($class. '.~I'))->isEqualTo($family . '\\' . $class . '\\' . $class . 'I')
        ;
    }
}