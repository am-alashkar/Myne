<?php

trait DynamicProperties {
    protected $dynamicProperties = [];
    public function __get($name) {
        if (isset($this->dynamicProperties[$name])) {
            return $this->dynamicProperties[$name];
        }
        return null;
    }
    public function __set($name, $value) {
        $this->dynamicProperties[$name] = $value;
    }
    public function __isset($name) {
        return isset($this->dynamicProperties[$name]);
    }
    public function __unset($name) {
        unset($this->dynamicProperties[$name]);
    }
    public function __call($name, $arguments) {
        if (isset($this->dynamicProperties[$name])) {
            return $this->dynamicProperties[$name];
        }
        return null;
    }
    public function getIterator(): Traversable {
        return new ArrayIterator($this->dynamicProperties);
    }
}