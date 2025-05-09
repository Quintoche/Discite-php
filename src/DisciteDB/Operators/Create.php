<?php

namespace DisciteDB\Operators;

trait Create
{
    public function create()
    {
        echo 'je souhaite créer :<br/>';
        echo $this->prefix.$this->name.'<br/>';
        echo $this->alias.'<br/>';
        // echo $this->name.'<br/>';
    }
}

?>