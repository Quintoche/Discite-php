<?php

namespace DisciteDB\Tables;

use DisciteDB\Config\Enums\Operators;
use DisciteDB\Config\Enums\QuerySort;
use DisciteDB\Keys\BaseKey;
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
     * Get all entries from the table.
     *
     * @return QueryResult
     */
    public function compare() : QueryResult;
    /**
     * Get all entries from the table.
     *
     * @param array $data
     * @return QueryResult
     */
    public function count(array $args) : QueryResult;

    /**
     * Insert a new row in the table.
     *
     * @param array $data
     * @return QueryResult
     */
    public function create(array $data): QueryResult;

    /**
     * Listing rows in the table.
     *
     * @param array $data
     * @return QueryResult
     */
    public function listing(array $data): QueryResult;

    /**
     * Update existing rows in the table.
     *
     * @param string|int|array $uuid, array $args
     * @param array $data
     * @return QueryResult
     */
    public function update(string|int|array $uuid, array $args): QueryResult;

    /**
     * Delete rows in the table.
     *
     * @param string|int|array $uuid
     * @return QueryResult
     */
    public function delete(string|int|array $uuid): QueryResult;

    /**
     * Retrieve specific row in the table.
     *
     * @param string|int|array $uuid
     * @return QueryResult
     */
    public function retrieve(string|int|array $uuid): QueryResult;

    /**
     * Search in the table.
     *
     * @param mixed $argument
     * @return QueryResult
     */
    public function search(mixed $argument): QueryResult;

    /**
     * Get table keys.
     *
     * @return QueryResult
     */
    public function keys(): QueryResult;
}

?>