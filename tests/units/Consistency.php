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
            ->given($family = uniqid())
            ->if($object = TestedClass::from($family))
            ->then
                ->object($object->from($family))->isIdenticalTo($object)
                ->object($object->from(uniqid()))->isNotIdenticalTo($object)
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

    public function testAlias() {
        $this
            ->given($namespace = uniqid())
            ->and($class = uniqid())
            ->if($object = TestedClass::from(uniqid()))
            ->and($this->function->class_exists = false)
            ->and($this->function->interface_exists = false)
            ->then
                ->variable($object->alias($namespace . '\\' . $class))->isNull()
            ->if($namespace = $class = uniqid())
            ->then
                ->string($object->alias($namespace . '\\' . $class))->isEqualTo($class)
            ->if($this->function->class_exists = true)
            ->then
                ->variable($object->alias($namespace . '\\' . $class))->isNull()
            ->if($this->function->class_exists = false)
            ->and($this->function->interface_exists = true)
            ->then
                ->variable($object->alias($namespace . '\\' . $class))->isNull()
        ;
    }
}