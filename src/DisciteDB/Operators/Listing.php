<?php

namespace DisciteDB\Operators;

use DisciteDB\Config\Enums\Operators;
use DisciteDB\QueryHandler\QueryResult;

trait Listing
{
    public function listing(?array $args) : QueryResult
    {
        
        $this->query->setOperator(Operators::Listing);
        $this->query->setArgs($args);

        // if(ClauseMethod::hasQueryMethod($args)) echo '<pre>',var_dump((new ClauseMethod($this, Operators::Listing, $this->query->getConnection(), $this->query->getInstance(), $args))->makeQuery()),'</pre>';

        return $this->query->makeQuery();
    }
}

?>