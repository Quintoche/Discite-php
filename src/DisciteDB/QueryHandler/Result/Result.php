<?php

namespace DisciteDB\QueryHandler\Result;

use DisciteDB\Tables\BaseTable;

interface Result
{
    public function getResult() : mixed;

    public function getResultNext() : mixed;
    
    public function getResultAll() : mixed;
    
    public function getResulRows() : mixed;
    
    public function getQuery() : ?string;

    public function getContext() : ?string;
    
    public function hasError() : bool;
    
    public function getResultError() : ?array;
    
    public function handleNewResult(mixed $uuid, BaseTable $table) : void;
    
}

?>