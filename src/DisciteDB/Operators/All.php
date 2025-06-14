<?php

namespace DisciteDB\Operators;

use DisciteDB\Config\Enums\Operators;
use DisciteDB\QueryHandler\QueryResult;

/**
 * Récupère toutes les entrées de la table.
 *
 * @return QueryResult
 */
trait All
{

    /**
     * Récupère toutes les entrées de la table.
     *
     * @return QueryResult
     */
    public function all() : QueryResult
    {
        $this->query->setOperator(Operators::All);

        // Add auto sorting if 
        $this->query->setArgs([]);


        return $this->query->makeQuery();
    }
}

?>