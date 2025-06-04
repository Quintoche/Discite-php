# Discite-PHP

Discite-PHP is a lightweight and extensible query builder for PHP using MySQLi. It provides an expressive, object-oriented API to manage SQL operations easily.

Discite-PHP helps manipulate, format, correct, and secure SQL queries based on the MySQL manager. The library uses MySQLi.

Several operating modes are available to best suit each use case. The library requires minimal initialization to reduce overhead.

Only the connection must be initialized outside the library for security reasons.

---

## Features

- Object-oriented and fluent interface  
- Automatic SQL injection protection  
- Modular configuration system  
- Charset, collation, naming convention, aliasing, prefixing control  
- Loose or strict usage modes for tables and keys  
- Field (key) declarations with type, index, nullable, default  
- Built-in query modifiers and logical operators  

---

## Summary

- [Installation](#installation)  
- [Usage Example](#usage-example)  
- [General Functionality](#general-functionality)  
- [Configuration](#configuration)  
  - [Load SQL database](#Load-SQL-database)  
    - [Load SQL database from file](#Load-SQL-database-from-file)  
    - [Load SQL database from database](#Load-SQL-database-from-database)  
    - [Retrieve map](#Retrieve-map)  
  - [Accessing Configuration](#accessing-the-configuration-interface)  
  - [Access to Configuration Constants](#access-to-configuration-variables)  
- [General Configuration](#general-configuration)  
  - [Charset](#charset)  
    - [Available Charsets](#available-charsets)  
  - [Collation](#collation)  
    - [Available Collations](#available-collations)  
  - [Naming Convention](#naming-convention)  
    - [Available Naming Conventions](#available-naming-conventions)  
  - [Sorting](#sorting)  
    - [Available sorting](#available-sorting)  
  - [joining](#joining)  
    - [Joining methods](#available-methods)  
    - [Joining Iterations](#available-iterations)  
    - [Joining Separator](#available-separator)  
    - [Available joining](#available-joining)  
- [Usage Modes](#usage-modes)  
  - [Table Usage](#table-usage)  
    - [Available Table Usage Modes](#available-table-usage-modes)  
  - [Key Usage](#key-usage)  
    - [Available Key Usage Modes](#available-key-usage-modes)  
- [Keys (Columns)](#keys-columns)  
  - [Parameters](#parameters)  
  - [Keys Type](#keys-type)  
  - [Keys Index](#keys-index)  
    - [Column Index](#Column-index)  
    - [Table Index](#Table-index)  
  - [Nullable](#nullable)  
  - [Secure](#secure)  
  - [Updatable](#updatable)  
  - [Default](#default)  
  - [Creating Keys](#creating-keys)  
- [Tables](#tables)  
  - [Table Parameters](#Table-parameters)  
- [Query Operators](#Query-Operators)
  - [All Operator](#All-Operator)
  - [Count Operator](#Count-Operator)
  - [Listing Operator](#Listing-Operator)
  - [Retrieve Operator](#Retrieve-Operator)
  - [Update Operator](#Update-Operator)
  - [Delete Operator](#Delete-Operator)
  - [Create Operator](#Create-Operator)
- [Manipulate Queries](#Manipulate-Queries)
  - [Query Conditions](#Query-Conditions)
    - [Equal Condition](#Equal-Condition)
    - [Or Condition](#Or-Condition)
    - [Contains Condition](#Contains-Condition)
    - [Between Condition](#Between-Condition)
    - [Not Condition](#Not-Condition)
    - [NotIn Condition](#NotIn-Condition)
    - [NotContains Condition](#NotContains-Condition)
    - [Like Condition](#Like-Condition)
    - [NotLike Condition](#NotLike-Condition)
    - [NotBetween Condition](#NotBetween-Condition)
    - [MoreThan Condition](#MoreThan-Condition)
    - [LessThan Condition](#LessThan-Condition)
    - [MoreOrEqual Condition](#MoreOrEqual-Condition)
    - [LessOrEqual Condition](#LessOrEqual-Condition)
  - [Query Modifiers](#Query-Modifiers)
    - [Order Modifier](#Order-Modifier)
    - [Sort Modifier](#Sort-Modifier)
    - [Limit Modifier](#Limit-Modifier)
- [Fetching Results](#Fetching-Results)
  - [Fetching Query](#Fetching-Query)
  - [Fetching All](#Fetching-All)
  - [Fetching Next](#Fetching-Next)
  - [Fetching Array](#Fetching-Array)
  - [Fetching Informations](#Fetching-Informations)
- [Project Structure](#Project-Structure)
- [License](#License)

--

## Installation

Install with Composer:

```bash
composer require discite/discite-php
```

---


## Usage Example

This snippet demonstrates how to initialize DisciteDB, configure it, and run a `SELECT` query with condition modifiers:

```php
use DisciteDB\Config\Enums\QueryLocation;
use DisciteDB\DisciteDB;
use DisciteDB\Methods\QueryCondition;

ini_set('display_errors','1');
ini_set('display_startup_errors','1');
error_reporting(E_ALL);

require 'default_file.php';

// Define your connection
$_connection = new mysqli('localhost','root','','test_db');

// Snitialize DisciteDB Database
$disciteDB = new \DisciteDB\Database($_connection);

// Set some configurations
  // Charset conf
$disciteDB->configuration()->setCharset(DisciteDB::CHARSET_UTF8MB4);
  // Collation conf
$disciteDB->config()->setCollation(DisciteDB::COLLATION_UTF8MB4_UNICODE_CI);
  // Table usage conf (look at [Usage Modes] for more informations)
$disciteDB->conf()->setTableUsage(DisciteDB::TABLE_USAGE_LOOSE);
  // Key usage conf (look at [Usage Modes] for more informations)
$disciteDB->conf()->setKeyUsage(DisciteDB::KEY_USAGE_LOOSE);

//Here, I decide to list all rows from 'disciteDB_FakeItems'
//That match the following arguments :
  // name is not "White Widget"
  // description start contains "and"
  // price is less or equal "25"
$queryFakeItems = $disciteDB->table('disciteDB_FakeItems')->listing([
    'name'=>QueryCondition::Not('White Widget'),
    'description'=>QueryCondition::Contains('and', DisciteDB::QUERY_LOCATION_BETWEEN),
    'price' => QueryCondition::LessOrEqual(25),
]);

// You can, after that :

// retrieve the SQL Query
echo '<b>QUERY</b>';
var_dump($queryFakeItems->fetchQuery());

// Retrieve informations (affected rows, time, statut, etc)
echo '<b>INFORMATIONS ONLY</b>';
var_dump($queryFakeItems->fetchInformations());

// Fetch the next data
  // Is like mysqli_fetch_row || mysqli_result::fetch_row
echo '<b>NEXT DATA</b>';
var_dump($queryFakeItems->fetchNext());

// Fetch all datas
  // Is like mysqli_fetch_all($result, MYSQLI_ASSOC); || mysqli_result::fetch_all(int $mode = MYSQLI_ASSOC)
echo '<b>ALL DATA</b>';
var_dump($queryFakeItems->fetchAll());

// Fetch all datas AND informations as an associative array
echo '<b>ALL DATA AND INFORMATIONS</b>';
var_dump($queryFakeItems->fetchArray());
```

---

## General Functionality

To begin using the library, you need a MySQLi connection and to initialize the database manager.

```php
// Initialize your connection as usual
$connection = new mysqli('host', 'username', 'password', 'database', 'port');

// Initialize the DisciteDB Manager
$disciteDB = new \DisciteDB\Database($connection);
```

If no connection is provided, the manager will use the following default values:  
<table>
  <thead>
    <tr>
      <th>Attribute</th>
      <th>Value</th>
    </tr>
  </thead>
  <tbody>
    <tr><td>Host</td><td>localhost</td><td></td></tr>
    <tr><td>Username</td><td>root</td><td></td></tr>
    <tr><td>Password</td><td>null</td><td></td></tr>
    <tr><td>Database</td><td>db</td><td></td></tr>
    <tr><td>Port</td><td>null</td><td></td></tr>
  </tbody>
</table>

---

## Configuration

### Load SQL database

if you want to keep `strict` mode (and so, have security, auto-join, etc) available, you can - if you don't want to make manuals definitions - load database directly from a file or the database.

#### Load SQL database from file

```php
// Initialize the DisciteDB Manager
$disciteDB = new \DisciteDB\Database($connection);

// Perform loading
$disciteDB->loadFromFile($path, $updatingTime);
```

The library will load tables and columns from a file. 

To improve some performances, you can add `$updatingTime` in seconds. If the file is older than the max storage time (`createdTime + $updatingTime`), the library will update the file.

If you want to update the file each time you initialize the library, just set the time to `0`.

#### Load SQL database from database

```php
// Initialize the DisciteDB Manager
$disciteDB = new \DisciteDB\Database($connection);

// Perform loading
$disciteDB->loadFromDatabase();
```

The library will load tables and columns directly from database connection. 

#### Retrieve map

You can retrieve `SQLmap` as an array with a simple method.

```php
// Initialize the DisciteDB Manager
$disciteDB = new \DisciteDB\Database($connection);

// Perform loading
$disciteDB->map();
```

### Overview

You can configure the manager to meet your needs until its destruction.

### Accessing the Configuration Interface

With the database manager initiated, access the configuration manager with:

```php
$disciteDB->configuration();
```

Aliases:

```php
$disciteDB->config();
$disciteDB->conf();
```

### Access to Configuration Variables

To configure the manager without having to import configuration classes, you can call constants via:

```php
use DisciteDB\DisciteDB;

// Example usage
DisciteDB::CONST_NAME;
```

---

## General Configuration

### Charset

You can define the charset of the database. By default, the charset used is `utf8mb4`.

```php
$disciteDB->config()->setCharset(selected_charset);
```

To retrieve the current charset:

```php
$disciteDB->config()->getCharset();
```

#### Available Charsets

<table>
  <thead>
    <tr>
      <th>Constant</th>
      <th>Value</th>
      <th>Default?</th>
    </tr>
  </thead>
  <tbody>
    <tr><td>CHARSET_UTF8</td><td>utf8</td><td></td></tr>
    <tr><td>CHARSET_UTF8MB4</td><td>utf8mb4</td><td>✓</td></tr>
  </tbody>
</table>

---

### Collation

You can define the collation associated with the charset. By default, the collation used is `utf8mb4_unicode_ci`.

```php
$disciteDB->config()->setCollation(selected_collation);
```

To retrieve the current collation:

```php
$disciteDB->config()->getCollation();
```

#### Available Collations

<table>
  <thead>
    <tr>
      <th>Constant</th>
      <th>Value</th>
      <th>Default?</th>
    </tr>
  </thead>
  <tbody>
    <tr><td>COLLATION_UTF8_GENERAL_CI</td><td>utf8_general_ci</td><td></td></tr>
    <tr><td>COLLATION_UTF8MB4_BIN</td><td>utf8mb4_bin</td><td></td></tr>
    <tr><td>COLLATION_UTF8MB4_UNICODE_CI</td><td>utf8mb4_unicode_ci</td><td>✓</td></tr>
  </tbody>
</table>

---

### Naming Convention

*Can be used only in `strict` mode*

You can define the naming convention to use. The library will automatically change the names and aliases to conform to the selected convention. By default, no convention is selected.

```php
$disciteDB->config()->setNamingConvention(selected_naming_convention);
```

To get the current naming convention:

```php
$disciteDB->config()->getNamingConvention();
```

#### Available Naming Conventions

<table>
  <thead>
    <tr>
      <th>Constant</th>
      <th>Value</th>
      <th>Default?</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>NAMING_CONVENTION_UNDEFINED</td>
      <td>Undefined</td>
      <td>✓</td>
    </tr>
    <tr>
      <td>NAMING_CONVENTION_CAMEL_CASE</td>
      <td>camelCase</td>
      <td></td>
    </tr>
    <tr>
      <td>NAMING_CONVENTION_PASCAL_CASE</td>
      <td>PascalCase</td>
      <td></td>
    </tr>
    <tr>
      <td>NAMING_CONVENTION_SNAKE_CASE</td>
      <td>snake_case</td>
      <td></td>
    </tr>
    <tr>
      <td>NAMING_CONVENTION_SNAKE_UPPERCASE</td>
      <td>SNAKE_UPPERCASE</td>
      <td></td>
    </tr>
  </tbody>
</table>

---


### Sorting

You can define if the library automaticly sort the database and if so, from `desc` or `asc`.

By default, the sorting method used is `no_sort`.

```php
$disciteDB->config()->setSort(selected_sorting_method);
```

To retrieve the current sorting method:

```php
$disciteDB->config()->getSort();
```

#### Available Sorting

<table>
  <thead>
    <tr>
      <th>Constant</th>
      <th>Value</th>
      <th>Default?</th>
    </tr>
  </thead>
  <tbody>
    <tr><td>SORT_NO_SORT</td><td>null</td><td>✓</td></tr>
    <tr><td>SORT_DESC</td><td>DESC</td><td></td></tr>
    <tr><td>SORT_ASC</td><td>ASC</td><td></td></tr>
  </tbody>
</table>

---

### Joining

*Can be used only in `strict` mode*

#### Joining Methods

The Discite-php library allow you to make auto-joining from defined database.

By default, the sorting method used is `no_join`.

```php
$disciteDB->config()->setJoinMethod(selected_joining_method);
```

To retrieve the current joining method:

```php
$disciteDB->config()->getJoinMethod();
```

#### Joining Iterations

You can also set the max occurences of joining the database will throw.

By default, the max interations is set to `0`. No maximum will be used.

You can set joining iterations by :

```php
$disciteDB->config()->setJoinMaxIterations(max_interations);
```

To retrieve the current joining method:

```php
$disciteDB->config()->getJoinMaxIterations();
```

#### Joining Separator

You can also set the separator used and retun in `CONCAT` mode.

By default, the separator is set to `, `. 

You can set joining separator by :

```php
$disciteDB->config()->setJoinSeparator(max_interations);
```

To retrieve the current joining method:

```php
$disciteDB->config()->getJoinSeparator();
```

#### Available Joining

<table>
  <thead>
    <tr>
      <th>Constant</th>
      <th>Method</th>
      <th>Default?</th>
    </tr>
  </thead>
  <tbody>
    <tr><td>JOIN_METHOD_NO_JOIN</td><td>no joining</td><td>✓</td></tr>
    <tr><td>JOIN_METHOD_FLAT</td><td>joined using INNER RIGHT sql </td><td></td></tr>
    <tr><td>JOIN_METHOD_CONCAT</td><td>joined using CONCAT sql, return in plain text</td><td></td></tr>
    <tr><td>JOIN_METHOD_JSON</td><td>joined using JSON_AGG sql, return in json</td><td></td></tr>
    <tr><td>JOIN_METHOD_MULTIDIMENSIONAL_ARRAY</td><td>joined using JSON_AGG, return in php array</td><td></td></tr>
  </tbody>
</table>

---


## Usage Modes

The library allows formatting, correction, and adding keys or values to limit errors and reduce tasks.

You can select independently for tables and columns ("keys") either strict or permissive usage modes.

### Table Usage

You can choose strict or permissive usage for tables. Default is strict usage.

```php
$disciteDB->config()->setTableUsage(selected_table_usage);
```

To retrieve the current table usage:

```php
$disciteDB->config()->getTableUsage();
```

#### Available Table Usage Modes

<table>
  <thead>
    <tr>
      <th>Constant</th>
      <th>Value</th>
      <th>Default?</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>TABLE_USAGE_STRICT</td>
      <td>Strict usage</td>
      <td>✓</td>
    </tr>
    <tr>
      <td>TABLE_USAGE_LOOSE</td>
      <td>Loose usage</td>
      <td></td>
    </tr>
  </tbody>
</table>

---

### Key Usage

You can choose strict or permissive usage for keys (columns). Default is strict usage.

```php
$disciteDB->config()->setKeyUsage(selected_key_usage);
```

To retrieve the current key usage:

```php
$disciteDB->config()->getKeyUsage();
```

#### Available Key Usage Modes

<table>
  <thead>
    <tr>
      <th>Constant</th>
      <th>Value</th>
      <th>Default?</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>KEY_USAGE_STRICT</td>
      <td>Strict usage</td>
      <td>✓</td>
    </tr>
    <tr>
      <td>KEY_USAGE_LOOSE</td>
      <td>Loose usage</td>
      <td></td>
    </tr>
  </tbody>
</table>

---

## Keys (Columns)

### Overview

If you are in `loose` usage mode, you may skip this section.

Access key configuration with:

```php
$disciteDB->keys();
```

### Parameters

A key has several parameters:

| Parameter | Type | Usage | Default | Nullable ? |
| --- | --- | --- | --- | --- |
| `name` | `string` | Showed name as object | `` |  |
| `alias` | `string` | Used name in database | `$name` | ✓ |
| `prefix` | `string` | Used prefix in database | `null` | ✓ |
| `type` | `DisciteDB::TYPE_[...]` | Used in `strict` mode [^1] | `DisciteDB::TYPE_STRING_STRING` | ✓ |
| `index` | `DisciteDB::INDEX_TYPE_[...]` | Used if you want to set index [^2] | `DisciteDB::INDEX_TYPE_NONE` | ✓ |
| `indexTable` | `Table` or `string` | Used if you previously set index type | `null` | ✓ |
| `default` | `DisciteDB::DEFAULT_VALUE_[...]` or your own value [^6] | Used to define default value | `DisciteDB::DEFAULT_VALUE_EMPTY_STRING` | ✓ |
| `nullable` | `bool` | Used in `strict` mode. [^3] | `false` | ✓ |
| `secure` | `bool` | Used in `strict` mode. [^4] | `false` | ✓ |
| `updatable` | `bool` | Used in `strict` mode. [^5] | `false` | ✓ |

### Keys Type

[^1]: 

You can select key type. It will be usefull while formatting values. It will escape values which aren't the same as selected type.

Groups are available to help definition :
- `Binary`[^7] ;
- `Date`[^8] ;
- `String`[^9] ;
- `Integer`[^10] ;
- `Float`[^11] .


[^7]: 
*Binary Type*

<table>
  <thead>
    <tr>
      <th>Constant</th>
      <th>Value</th>
      <th>Size</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>TYPE_BINARY_BLOB</td>
      <td>blob</td>
      <td>✓</td>
    </tr>
    <tr>
      <td>TYPE_BINARY_TINYBLOB</td>
      <td>tinyblob</td>
      <td></td>
    </tr>
    <tr>
      <td>TYPE_BINARY_MEDIUMBLOB</td>
      <td>mediumblob</td>
      <td></td>
    </tr>
    <tr>
      <td>TYPE_BINARY_LONGBLOB</td>
      <td>longblob</td>
      <td></td>
    </tr>
    <tr>
      <td>TYPE_BINARY_JSON</td>
      <td>json</td>
      <td></td>
    </tr>
    <tr>
      <td>TYPE_BINARY_FILE</td>
      <td>file</td>
      <td></td>
    </tr>
  </tbody>
</table>

[^8]: 
*Date Type*

<table>
  <thead>
    <tr>
      <th>Constant</th>
      <th>Value</th>
      <th>Size</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>TYPE_DATE_DATE</td>
      <td>date</td>
      <td>✓</td>
    </tr>
    <tr>
      <td>TYPE_DATE_TIME</td>
      <td>time</td>
      <td></td>
    </tr>
    <tr>
      <td>TYPE_DATE_DATETIME</td>
      <td>datetime</td>
      <td></td>
    </tr>
    <tr>
      <td>TYPE_DATE_TIMESTAMP</td>
      <td>timestamp</td>
      <td></td>
    </tr>
    <tr>
      <td>TYPE_DATE_YEAR</td>
      <td>year</td>
      <td></td>
    </tr>
  </tbody>
</table>

[^9]: 
*String Type*

<table>
  <thead>
    <tr>
      <th>Constant</th>
      <th>Value</th>
      <th>Size</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>TYPE_STRING_STRING</td>
      <td>string</td>
      <td>✓</td>
    </tr>
    <tr>
      <td>TYPE_STRING_SMALLTEXT</td>
      <td>smalltext</td>
      <td></td>
    </tr>
    <tr>
      <td>TYPE_STRING_MEDIUMTEXT</td>
      <td>mediumtext</td>
      <td></td>
    </tr>
    <tr>
      <td>TYPE_STRING_LONGTEXT</td>
      <td>longtext</td>
      <td></td>
    </tr>
    <tr>
      <td>TYPE_STRING_UUID</td>
      <td>uuid</td>
      <td></td>
    </tr>
    <tr>
      <td>TYPE_STRING_EMAIL</td>
      <td>email</td>
      <td></td>
    </tr>
    <tr>
      <td>TYPE_STRING_URL</td>
      <td>url</td>
      <td></td>
    </tr>
    <tr>
      <td>TYPE_STRING_IP</td>
      <td>ip</td>
      <td></td>
    </tr>
    <tr>
      <td>TYPE_STRING_USERNAME</td>
      <td>username</td>
      <td></td>
    </tr>
    <tr>
      <td>TYPE_STRING_PASSWORD</td>
      <td>password</td>
      <td></td>
    </tr>
  </tbody>
</table>

[^10]: 
*Integer Type*

<table>
  <thead>
    <tr>
      <th>Constant</th>
      <th>Value</th>
      <th>Size</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>TYPE_INTEGER_BOOLEAN</td>
      <td>boolean</td>
      <td>✓</td>
    </tr>
    <tr>
      <td>TYPE_INTEGER_INT</td>
      <td>int</td>
      <td></td>
    </tr>
    <tr>
      <td>TYPE_INTEGER_BIGINT</td>
      <td>bigint</td>
      <td></td>
    </tr>
    <tr>
      <td>TYPE_INTEGER_TINYINT</td>
      <td>tinyint</td>
      <td></td>
    </tr>
    <tr>
      <td>TYPE_INTEGER_MEDIUMINT</td>
      <td>mediumint</td>
      <td></td>
    </tr>
    <tr>
      <td>TYPE_INTEGER_SMALLINT</td>
      <td>smallint</td>
      <td></td>
    </tr>
    <tr>
      <td>TYPE_INTEGER_UNIXTIME</td>
      <td>unixtime</td>
      <td></td>
    </tr>
  </tbody>
</table>

[^11]: 
*Float Type*

<table>
  <thead>
    <tr>
      <th>Constant</th>
      <th>Value</th>
      <th>Size</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>TYPE_FLOAT_FLOAT</td>
      <td>float</td>
      <td>✓</td>
    </tr>
    <tr>
      <td>TYPE_FLOAT_DOUBLE</td>
      <td>double</td>
      <td></td>
    </tr>
    <tr>
      <td>TYPE_FLOAT_DECIMAL</td>
      <td>decimal</td>
      <td></td>
    </tr>
  </tbody>
</table>

### Keys Index


#### Column Index
[^2]: 

You can select key index.

Index will be usefull if you decide to make SQL joining method.

| Const               | Usage | Default ?                          |
|----------------------|----|-------------------------------|
| `DisciteDB::INDEX_TYPE_NONE` |   null   | ✓                |
| `DisciteDB::INDEX_TYPE_INDEX`|  |
| `DisciteDB::INDEX_TYPE_UNIQUE`|        |                     |
| `DisciteDB::INDEX_TYPE_PRIMARY`| |                     |
| `DisciteDB::INDEX_TYPE_FULLTEXT`| |                     |
| `DisciteDB::INDEX_TYPE_SPATIAL`|        |                     |

#### Table Index

You can put a table name as `indexTable`. Usefull to rach joining methods.

### Nullable

[^3]: 
You can decide if a column can be nullable or not.

### Secure

[^4]: 
In `strict` mode, secured values will not be returning. Such as password.

In the futur, I would like to implement a few new operators such as login who would return only true or false if password match.


### Updatable

[^5]: 
In `strict` mode, this will disable updatable column value. Would be useful for id.


### Default

[^6]: 
You can specify default values. Or you define a string, integer, flaot, etc or you decide to use default pre-defined values.

| Const               | Value |                          |
|----------------------|----|-------------------------------|
| `DisciteDB::DEFAULT_VALUE_NULL` |   `null`   |                 |
| `DisciteDB::DEFAULT_VALUE_CURRENT_TIMESTAMP`|  `CURRENT_TIMESTAMP()` |
| `DisciteDB::DEFAULT_VALUE_ZERO`|    0    |                     |
| `DisciteDB::DEFAULT_VALUE_EMPTY_STRING`| ` ` |                     |
| `DisciteDB::DEFAULT_VALUE_UUIDV4`| `uuid()` |                     |
| `DisciteDB::DEFAULT_VALUE_NOW`|    `CURRENT_TIMESTAMP()`    |                     |

### Creating Keys

You can create keys in two ways:

```php
$disciteDB->keys()->create('key_name', [
  'alias' => 'alias_name',
  'prefix' => 'wanted_prefix',
  'Type' => TYPE_STRING_STRING,
  // etc...
]);
```

or

```php
$disciteDB->keys()->add();
```

---

## Tables

WIP - documentation

### Overview

If you are in `loose` usage mode, you may skip this section.

Access key configuration with:

```php
$disciteDB->tables();
```

### Table Parameters

A table has several parameters:

| Parameter | Type | Usage | Default | Nullable ? |
| --- | --- | --- | --- | --- |
| `name` | `string` | Showed name as object | `` |  |
| `alias` | `string` | Used name in database | `$name` | ✓ |
| `prefix` | `string` | Used prefix in database | `null` | ✓ |
| `primaryKey` | `BaseKey` | Used to define primary key | `null` | ✓ |
| `sort` | `DisciteDB::SORT_[...]` | Used if you want to set a default sorting method | `DisciteDB::SORT_NO_SORT` | ✓ |


--- 

## Query Operators

You will be able to make queries with multiples operators.

Theses operators are :
- `All`;
- `Count`;
- `Listing`;
- `Retrieve`;
- `Update`;
- `Delete`;
- `Create` _Still not implemented_ ;
- `Compare` _Still not implemented_ ;
- `Keys` _Still not implemented_;

### All Operator

This operator will return every data in selected table

```php

$resultObject = $disciteDb->table('tableName')->all();

```

### Count Operator

This operator will return a count value.


```php

$resultObject = $disciteDb->table('tableName')->count($args);

```

You can put filters as arguments. Arguments must be an array. You're able to put flat values, Query Conditions.

```php

$args = [
  'columnName' => 'value',
  'columnName' => QueryCondition::Or('value_1', 'value_2');,
];

```

### Listing Operator

This operator will return a values based on filters. It's like `all` operator with arguments.


```php

$resultObject = $disciteDb->table('tableName')->listing($args);

```

You can put filters as arguments. Arguments must be an array. You're able to put flat values, Query Conditions or Query modifiers.

```php

$args = [
  'columnName' => 'value',
  'columnName' => QueryCondition::Or('value_1', 'value_2');,
  QueryModifier::Sort(DisciteDB::SORT_DESC, 'id');
];

```

### Retrieve Operator

This operator will be used to retrieve single data.


```php

$resultObject = $disciteDb->table('tableName')->retrieve($uuid);

```

UUID can be a `string`, an `integer` or an `array`. For the two first, in `strict` mode, primary indexed key will be used as id. If you want to manually specify uuid key name, you must set UUID as an array.

```php

// String or integer definition 
$uuid = 3;

// Array definition 
$uuid = [
  'columnName' => 'value',
];
```

---

### Update Operator

This operator will be used to update data.


```php

$resultObject = $disciteDb->table('tableName')->update($uuid, $args);

```

UUID can be a `string`, an `integer` or an `array`. For the two first, in `strict` mode, primary indexed key will be used as id. If you want to manually specify uuid key name, you must set UUID as an array.

```php

// String or integer definition 
$uuid = 3;

// Array definition 
$uuid = [
  'columnName' => 'value',
];
```

You must put values as arguments. Arguments must be an array. You're able to put flat values only.

```php

$args = [
  'columnName' => 'value',
];

```

---

### Delete Operator

This operator will be used to delete data.


```php

$resultObject = $disciteDb->table('tableName')->delete($uuid);

```

UUID can be a `string`, an `integer` or an `array`. For the two first, in `strict` mode, primary indexed key will be used as id. If you want to manually specify uuid key name, you must set UUID as an array.

```php

// String or integer definition 
$uuid = 3;

// Array definition 
$uuid = [
  'columnName' => 'value',
];
```

---

### Create Operator

This operator will be used to create data.

In `strict` mode, undefined values will be generate by the library with default previously defined values.

```php

$resultObject = $disciteDb->table('tableName')->create($args);

```

You must put values as arguments. Arguments must be an array. You're able to put flat values only.

```php

$args = [
  'columnName' => 'value',
];

```

---

## Manipulate Queries

You are able to manipulate queries. At this time, with previously showed `$args`. You would just set an `equal` condition and default sorting/limit.

With theses user-friendly queries "manipulators", you'll see that is easy to perform a strong query.

### Query Conditions

Theses methods, used in `listing` and `count`, will auto-format (even in loose usage mode) query based on parameters you give.

#### Equal Condition

Simple Condition. Must not be used because you can perform this condition with a standard argument.

```php

QueryCondition::Equal('value');

```

#### Or condition

You can put every values as you want to check.

```php
QueryCondition::Or('value_1','value_2');
```

Library will format like this :
```sql
('columnName' = 'value_1' OR 'columnName' = 'value_2')
```

#### Contains condition

You must send location. Default used const is `QUERY_LOCATION_BETWEEN`.

```php
QueryCondition::Contains('value', DisciteDB::QUERY_LOCATION_[...]);
```

Library will format like this :
```sql
'columnName' LIKE '%value%'
```

Location will format value as :
| Const               | Value format                          |
|----------------------|--------------------------------------|
| `DisciteDB::QUERY_LOCATION_STARTWITH`       | `%value`               |
| `DisciteDB::QUERY_LOCATION_ENDWITH`| `value%`|
| `DisciteDB::QUERY_LOCATION_BETWEEN`        | `%value%`                    |

#### Between condition

You can put every values as you want to check.

```php
QueryCondition::Between(10, 20);
```

Library will format like this :
```sql
'columnName' BETWEEN 10 AND 20
```

#### Not condition


```php
QueryCondition::Not('value');
```

Library will format like this :
```sql
'columnName' != 'value'
```

if you specify more than one argument. `NotIn` condition will replace `Not` condition automaticly.

#### NotIn condition


```php
QueryCondition::NotIn('value_1','value_2');
```

Library will format like this :
```sql
'columnName' NOT IN ('value_1', 'value_2')
```

if you specify only one argument. `Not` condition will replace `NotIn` condition automaticly.

#### NotContains condition

You must send location. Default used const is `QUERY_LOCATION_BETWEEN`.

```php
QueryCondition::NotContains('value', DisciteDB::QUERY_LOCATION_[...]);
```

Library will format like this :
```sql
'columnName' NOT LIKE '%value%'
```


Location will format value as :
| Const               | Value format                          |
|----------------------|--------------------------------------|
| `DisciteDB::QUERY_LOCATION_STARTWITH`       | `%value`               |
| `DisciteDB::QUERY_LOCATION_ENDWITH`| `value%`|
| `DisciteDB::QUERY_LOCATION_BETWEEN`        | `%value%`     

#### Like condition

You must send location. Default used const is `QUERY_LOCATION_BETWEEN`.

```php
QueryCondition::Like('value', DisciteDB::QUERY_LOCATION_[...]);
```

Library will format like this :
```sql
'columnName' LIKE '%value%'
```


Location will format value as :
| Const               | Value format                          |
|----------------------|--------------------------------------|
| `DisciteDB::QUERY_LOCATION_STARTWITH`       | `%value`               |
| `DisciteDB::QUERY_LOCATION_ENDWITH`| `value%`|
| `DisciteDB::QUERY_LOCATION_BETWEEN`        | `%value%`     

#### NotLike condition

Aliase of `NotContains`.


#### NotBetween condition

```php
QueryCondition::NotBetween(10, 20);
```

Library will format like this :
```sql
'columnName' NOT BETWEEN 10 AND 20
```


#### MoreThan condition

```php
QueryCondition::MoreThan(10);
```

Library will format like this :
```sql
'columnName' > 10
```


#### LessThan condition

```php
QueryCondition::LessThan(10);
```

Library will format like this :
```sql
'columnName' < 10
```


#### MoreOrEqual condition

```php
QueryCondition::MoreOrEqual(10);
```

Library will format like this :
```sql
'columnName' >= 10
```


#### LessOrEqual condition

```php
QueryCondition::LessOrEqual(10);
```

Library will format like this :
```sql
'columnName' <= 10
```

---

### Query Modifiers

Theses methods, used in `listing`, will give you additionals methods for results.


#### Order Modifier

```php
QueryModifier::Order(DisciteDB::SORT_[...], 'columnName');
```

Library will format like this :
```sql
ORDER BY 'columnName' 'DESC'
```

Sorting available constants are :
| Const               | Value format                          |
|----------------------|--------------------------------------|
| `DisciteDB::SORT_DESC`       | DESC sorting               |
| `DisciteDB::SORT_ASC`| ASC sorting|
| `DisciteDB::SORT_NO_SORT`        | null                    |


#### Sort Modifier

Aliase of order modifier.



#### Limit Modifier

If you decide to use limit modifier, you must specify a `limit` in `integer`.

Define `Offset` is optional.

```php
QueryModifier::Limit($limit, ?$offset);
```

Library will format like this :
```sql
LIMIT 10 OFFSET 20
```

---

## Fetching Results

Once you perform your query with operator. You will be able to retrieve results.

| Method               | Description                          |
|----------------------|--------------------------------------|
| `fetchQuery()`       | Returns SQL string only              |
| `fetchAll()`         | Gets all matching rows               |
| `fetchNext()`        | Gets the next row                    |
| `fetchArray()`       | Gets all rows and schema info        |
| `fetchInformations()`| Meta-information (types, keys, etc.)|

### Fetching Query

You'll retrieve the query as `string`

```php
$result = $disciteDB->table('disciteDB_FakeItems')->all();

// Fetching query for example.
print_r($result->fetchQuery());

```

Result will be :

```php

string(45) "SELECT * FROM `test_db`.`disciteDB_FakeItems`"

```

### Fetching All

You'll retrieve all results as `array`.

Doing this will make the same result as : `mysqli_fetch_all($result, MYSQLI_ASSOC)` or `mysqli_result::fetch_all(int $mode = MYSQLI_ASSOC)`

```php
$result = $disciteDB->table('disciteDB_FakeItems')->all();

// Fetching all datas for example.
print_r($result->fetchAll());

```

Result will be :

```php

array(12) {
    [0]=>
  array(6) {
    ["id"]=>
    int(2)
    ["category_id"]=>
    int(1)
    ["name"]=>
    string(10) "Red Widget"
    ["description"]=>
    string(29) "A slightly larger red widget."
    ["price"]=>
    float(15.4900000000000002131628207280300557613372802734375)
    ["created_at"]=>
    string(19) "2025-06-04 19:45:27"
  }
  [1]=>
  array(6) {
    ["id"]=>
    int(3)
    ["category_id"]=>
    int(1)
    ["name"]=>
    string(12) "Green Widget"
    ["description"]=>
    string(23) "A stylish green widget."
    ["price"]=>
    float(13.75)
    ["created_at"]=>
    string(19) "2025-06-04 19:45:27"
  }
  // .........
  }

```

### Fetching Next

You'll retrieve the next result as `array`.

Doing this will make the same result as : `mysqli_fetch_row($result)` or `mysqli_result::fetch_row()`.

Informations will be also returned.

```php
$result = $disciteDB->table('disciteDB_FakeItems')->all();

// Fetching next data for example.
print_r($result->fetchNext());

```

Result will be :

```php

array(2) {
  ["data"]=>
  array(6) {
    ["id"]=>
    int(1)
    ["category_id"]=>
    int(1)
    ["name"]=>
    string(11) "Blue Widget"
    ["description"]=>
    string(32) "A small blue widget for testing."
    ["price"]=>
    float(10.9900000000000002131628207280300557613372802734375)
    ["created_at"]=>
    string(19) "2025-06-04 19:45:27"
  }
  ["info"]=>
  array(4) {
    ["status"]=>
    string(7) "success"
    ["time"]=>
    int(1749059127)
    ["query"]=>
    array(5) {
      ["operator"]=>
      string(3) "All"
      ["table"]=>
      string(19) "disciteDB_FakeItems"
      ["context"]=>
      NULL
      ["gaveArgments"]=>
      int(0)
      ["affectedRows"]=>
      int(12)
    }
    ["error"]=>
    NULL
  }
}
```

### Fetching Array

You'll retrieve all datas as `array`.

Doing this will make the same result as : `mysqli_fetch_all($result, MYSQLI_ASSOC)` or `mysqli_result::fetch_all(int $mode = MYSQLI_ASSOC)`.

Informations will be also returned.

```php
$result = $disciteDB->table('disciteDB_FakeItems')->all();

// Fetching array datas for example.
print_r($result->fetchArray());

```

Result will be :

```php

array(2) {
  ["data"]=>
  array(12) {
    // Datas
  }
  ["info"]=>
  array(4) {
    ["status"]=>
    string(7) "success"
    ["time"]=>
    int(1749059127)
    ["query"]=>
    array(5) {
      ["operator"]=>
      string(3) "All"
      ["table"]=>
      string(19) "disciteDB_FakeItems"
      ["context"]=>
      NULL
      ["gaveArgments"]=>
      int(0)
      ["affectedRows"]=>
      int(12)
    }
    ["error"]=>
    NULL
  }
}
```

### Fetching Informations

You'll retrieve informations only as `array`.


```php
$result = $disciteDB->table('disciteDB_FakeItems')->all();

// Fetching informations for example.
print_r($result->fetchInformations());

```

Result will be :

```php

array(4) {
  ["status"]=>
  string(7) "success"
  ["time"]=>
  int(1749059127)
  ["query"]=>
  array(5) {
    ["operator"]=>
    string(3) "All"
    ["table"]=>
    string(19) "disciteDB_FakeItems"
    ["context"]=>
    NULL
    ["gaveArgments"]=>
    int(0)
    ["affectedRows"]=>
    int(12)
  }
  ["error"]=>
  NULL
}

```



--- 

## Project Structure

- `src/` – Core library files  
- `example/` – Usage demonstrations  
- `tests/` – PHPUnit testing  

## License

MIT License — see `LICENSE` file.

Created by Romain QUINTAINE.
