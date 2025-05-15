<?php

namespace DisciteDB\Tables;

use DisciteDB\QueryHandler\QueryResult;

interface TableInterface
{
    /**
     * Get all entries from the table.
     *
     * @return QueryResult
     */
    public function all(): QueryResult;

    /**
     * Insert a new row in the table.
     *
     * @param array $data
     * @return QueryResult
     */
    public function create(array $data): QueryResult;

    /**
     * Update existing rows in the table.
     *
     * @param array $data
     * @return QueryResult
     */
    public function update(array $data): QueryResult;

    /**
     * Delete rows in the table.
     *
     * @return QueryResult
     */
    public function delete(): QueryResult;

    /**
     * Get table keys.
     *
     * @return QueryResult
     */
    public function keys(): QueryResult;

}

?>