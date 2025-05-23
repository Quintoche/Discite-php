<?php

namespace DisciteDB\Users;

use DisciteDB\Connection;
use DisciteDB\Core\QueryManager;
use DisciteDB\Database;

abstract class BaseUser implements UserInterface
{
    


    /**
     * The main database handler.
     *
     * This holds a reference to the core Database instance
     * to allow communication and access to global configuration.
     *
     * @var Database
     */
    protected Database $database;


    /**
     * The connection wrapper for the database.
     *
     * Provides methods to interact with the raw database layer.
     *
     * @var Connection
     */
    protected Connection $connection;


    /**
     * Internal query manager for building and executing SQL queries.
     *
     * Acts as a bridge between table abstraction and SQL generation.
     *
     * @var QueryManager
     */
    protected QueryManager $query;


    /**
     * Table name as declared in the database.
     *
     * Can be null if not explicitly defined during construction.
     *
     * @var string|null
     */
    protected ?string $name = null;


    /**
     * Optional alias name for the table (used in SQL joins or shorthand).
     *
     * If set, replaces the actual table name in queries.
     *
     * @var string|null
     */
    protected ?string $alias = null;


    /**
     * Optional prefix for the table name.
     *
     * Used to handle cases where multiple projects share the same database.
     *
     * @var string|null
     */
    protected ?string $prefix = null;

    /**
     * Internal mapping between fields and their properties.
     *
     * Used to describe data structure, types, and rules.
     *
     * @var array
     */
    protected array $map;


    /**
     * BaseTable constructor.
     *
     * Initializes the table with a Database instance and
     * prepares the query builder and key system.
     *
     * @param Database $database The core database instance.
     */
    public function __construct(Database $database)
    {
        $this->database = $database;

        // Retrieve connection from Database
        $this->connection = $this->database->connection();

    }
}
