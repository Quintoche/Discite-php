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
  - [Creating Keys](#creating-keys)  
- [Key Types](#key-types)  
- [Key Index Types](#key-index-types)  
- [Default Key Values](#default-key-values)  
- [Query Methods](#Query-Methods)
- [Fetching Results](#Fetching-Results)
- [Project Structure](#Project-Structure)
- [License](#License)

--

## Installation

Install with Composer:

```bash
composer require dscite/discite-php
```

---


## Usage Example

This snippet demonstrates how to initialize DisciteDB, configure it, and run a `SELECT` query with condition modifiers:

```php
use DisciteDB\Config\Enums\QueryLocation;
use DisciteDB\DisciteDB;
use DisciteDB\Methods\QueryMethod;

ini_set('display_errors','1');
ini_set('display_startup_errors','1');
error_reporting(E_ALL);

require 'default_file.php';

$_connection = new mysqli('localhost','root','','test_db');
$disciteDB = new \DisciteDB\Database($_connection);

$disciteDB->configuration()->setCharset(DisciteDB::CHARSET_UTF8MB4);
$disciteDB->config()->setCollation(DisciteDB::COLLATION_UTF8MB4_UNICODE_CI);
$disciteDB->conf()->setTableUsage(DisciteDB::TABLE_USAGE_LOOSE);
$disciteDB->conf()->setKeyUsage(DisciteDB::KEY_USAGE_LOOSE);

$queryFakeItems = $disciteDB->table('disciteDB_FakeItems')->listing([
    'name'=>QueryMethod::Not('White Widget'),
    'description'=>QueryMethod::Contains('and', QueryLocation::Between),
    'price' => QueryMethod::LessOrEqual(25),
]);

echo '<b>QUERY</b>';
var_dump($queryFakeItems->fetchQuery());

echo '<b>INFORMATIONS ONLY</b>';
var_dump($queryFakeItems->fetchInformations());

echo '<b>NEXT DATA</b>';
var_dump($queryFakeItems->fetchNext());

echo '<b>ALL DATA</b>';
var_dump($queryFakeItems->fetchAll());

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
    <tr><td>Host</td><td>`localhost`</td><td></td></tr>
    <tr><td>Username</td><td>`root`</td><td></td></tr>
    <tr><td>Password</td><td>`null`</td><td></td></tr>
    <tr><td>Database</td><td>`db`</td><td></td></tr>
    <tr><td>Port</td><td>`null`</td><td></td></tr>
  </tbody>
</table>

---

## Configuration

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
    <tr><td>CHARSET_UTF8</td><td>`utf8`</td><td></td></tr>
    <tr><td>CHARSET_UTF8MB4</td><td>`utf8mb4`</td><td>✓</td></tr>
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
    <tr><td>COLLATION_UTF8_GENERAL_CI</td><td>`utf8_general_ci`</td><td></td></tr>
    <tr><td>COLLATION_UTF8MB4_BIN</td><td>`utf8mb4_bin`</td><td></td></tr>
    <tr><td>COLLATION_UTF8MB4_UNICODE_CI</td><td>`utf8mb4_unicode_ci`</td><td>✓</td></tr>
  </tbody>
</table>

---

### Naming Convention

** Can be used only in `strict` mode **

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
    <tr><td>SORT_NO_SORT</td><td>`null`</td><td>✓</td></tr>
    <tr><td>SORT_DESC</td><td>`DESC`</td><td></td></tr>
    <tr><td>SORT_ASC</td><td>`ASC`</td><td></td></tr>
  </tbody>
</table>

---

### Joining

** Can be used only in `strict` mode **

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
    <tr><td>JOIN_METHOD_FLAT</td><td>joined using `INNER RIGHT` sql </td><td></td></tr>
    <tr><td>JOIN_METHOD_CONCAT</td><td>joined using `CONCAT` sql, return in plain text</td><td></td></tr>
    <tr><td>JOIN_METHOD_JSON</td><td>joined using `JSON_AGG` sql, return in json</td><td></td></tr>
    <tr><td>JOIN_METHOD_MULTIDIMENSIONAL_ARRAY</td><td>joined using `JSON_AGG`, return in php array</td><td></td></tr>
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

WIP

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

## Key Types

WIP - documentation

---

## Key Index Types

WIP - documentation

---

## Default Key Values

WIP - documentation

---

## Tables

WIP - documentation

--- 


## Query Methods

Theses methods, used in `listing` and `count`, will auto-format (even in loose usage mode) query based on parameters you give.

```php
QueryMethod::Equals('value');
QueryMethod::Not('value');
QueryMethod::Contains('value', QueryLocation::Between);
QueryMethod::StartsWith('value');
QueryMethod::EndsWith('value');
QueryMethod::MoreThan(10);
QueryMethod::LessOrEqual(100);
QueryMethod::Between(10, 20);
QueryMethod::In(['val1', 'val2']);
QueryMethod::NotIn(['val3', 'val4']);
QueryMethod::IsNull();
QueryMethod::IsNotNull();
```

---

## Fetching Results

| Method               | Description                          |
|----------------------|--------------------------------------|
| `fetchQuery()`       | Returns SQL string only              |
| `fetchInformations()`| Meta-information (types, keys, etc.)|
| `fetchNext()`        | Gets the next row                    |
| `fetchAll()`         | Gets all matching rows               |
| `fetchArray()`       | Gets all rows and schema info        |


--- 

## Project Structure

- `src/` – Core library files  
- `example/` – Usage demonstrations  
- `tests/` – PHPUnit testing  

## License

MIT License — see `LICENSE` file.
