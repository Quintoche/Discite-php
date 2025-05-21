<?php

namespace DisciteDB\Tables;

use DisciteDB\Config\Enums\QuerySort;
use DisciteDB\Config\Enums\QueryType;
use DisciteDB\Database;
use DisciteDB\Connection;

use DisciteDB\Core\QueryManager;
use DisciteDB\DisciteDB;
use DisciteDB\Keys\BaseKey;
use DisciteDB\Keys\KeyTemplates\TemplateId;

/**
 * Class BaseTable
 *
 * Abstract representation of a database table used in DisciteDB.
 * This class acts as a base template for all specific table types.
 *
 * @package DisciteDB\Tables
 */
abstract class BaseTable implements TableInterface
{
    
    use TableTraitGet, TableTraitSet, TableTraitMap;


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
     * The default key used to identify a row (usually a primary key).
     *
     * Defaults to a TemplateId key unless overridden.
     *
     * @var BaseKey|null
     */
    protected ?BaseKey $primaryKey = null;


    /**
     * Default sorting direction for queries.
     *
     * Usually 'DESC' or 'ASC'. Used when retrieving collections.
     *
     * @var QuerySort|null
     */
    protected ?QuerySort $sort = DisciteDB::SORT_NO_SORT;


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

        // Assign a default key template for indexing
        $this->primaryKey = new TemplateId($this->database);

        // Set up query manager and associate it with this table and connection
        $this->query = new QueryManager($this->database);
        $this->query->setTable($this);
        $this->query->setConnection($this->database->connection()->get());
    }
}
