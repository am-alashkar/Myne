<?php


class result implements ArrayAccess , IteratorAggregate
{
    use DynamicProperties;
    public function count() : int {
        return count($this->dynamicProperties);
    }
    public function is_empty() : bool {
        return $this->count() == 0;
    }
    public function join($data = null,$overwrite = true) {
        if ($data) foreach ($data as $key=>$var) {
            if (!isset($this->dynamicProperties[$key]) || (isset($this->dynamicProperties[$key]) && $overwrite) ) {
                $this->dynamicProperties[$key] = $var;
            }
        }
        return $this;
    }
    public function add($key ,$data = null) {
        $this->dynamicProperties[$key] = $data;
        return $this;
    }
//    public function to_array() {
//        foreach ($this as $key => $var) {
//            $arr[$key] = $var;
//        }
//        return $arr;
//    }
    function __toString(): string
    {
        return $this->count().'';
    }
    function first() {
        foreach ($this->dynamicProperties as $item) return $item;
    }
    function last() {
        $item = null;
        foreach ($this->dynamicProperties as $item) ;
        return $item;
    }
   

    public function offsetExists( $offset) : bool
    {
        return isset($this->$offset);
    }

    /**
     * @param mixed $offset
     * @return mixed
     */
    public function offsetGet($offset): mixed
    {
        return $this->$offset;
    }

    public function offsetSet($offset, $value) : void
    {
        if ($offset == '') $offset = $this->count()+1;
        $this->$offset = $value;
    }

    public function offsetUnset($offset) : void
    {
        unset($this->$offset);
    }
    public function implode(string $glue = ' ') : string
    {
        $array = [];
        foreach ($this as $key=>$it) {
            $array[] = $it;
        }
        return implode($glue, $array);
    }
}
