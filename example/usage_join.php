<?php

use DisciteDB\Config\Enums\QueryLocation;
use DisciteDB\DisciteDB;
use DisciteDB\Methods\QueryCondition;
use DisciteDB\Methods\QueryMethod;
use DisciteDB\Methods\QueryModifier;

ini_set('display_errors','1');
ini_set('display_startup_erros','1');
error_reporting(E_ALL);


    require 'default_file.php';


    // Create your connection
    $_connection = new mysqli('localhost','root','','test_db');


    // Initiate DisciteDB Manager
    // Put as argument the connection you've initiate 
    $disciteDB = new \DisciteDB\Database($_connection);

    // Make your configuration
    // You acn choose between alias
    // Configuration is not defined and explained here
    $disciteDB->configuration()->setCharset(DisciteDB::CHARSET_UTF8MB4);
    $disciteDB->config()->setCollation(DisciteDB::COLLATION_UTF8MB4_UNICODE_CI);

    // For a auto joining methods, you'll have to put strict usage for table and keys.
    $disciteDB->conf()->setTableUsage(DisciteDB::TABLE_USAGE_STRICT);
    $disciteDB->conf()->setKeyusage(DisciteDB::KEY_USAGE_STRICT);

    $disciteDB->config()->setNamingConvention(DisciteDB::NAMING_CONVENTION_UNDEFINED);


    $table_items = $disciteDB->tables()->add('disciteDB_FakeItems','disciteDB_FakeItems');
    $table_itemSuppliers = $disciteDB->tables()->add('disciteDB_FakeItemSuppliers','disciteDB_FakeItemSuppliers');
    $table_categories = $disciteDB->tables()->add('disciteDB_FakeCategories','disciteDB_FakeCategories');
    $table_suppliers = $disciteDB->tables()->add('disciteDB_FakeSuppliers','disciteDB_FakeSuppliers');

    $key_name = $disciteDB->keys()->create('name',['type'=>DisciteDB::TYPE_STRING_STRING]);
    $key_desc = $disciteDB->keys()->create('description',['type'=>DisciteDB::TYPE_STRING_STRING]);
    $key_price = $disciteDB->keys()->create('price',['type'=>DisciteDB::TYPE_FLOAT_DOUBLE]);
    $category_name = $disciteDB->keys()->create('category_name',['type'=>DisciteDB::TYPE_STRING_STRING]);
    $supplier_name = $disciteDB->keys()->create('supplier_name',['type'=>DisciteDB::TYPE_STRING_STRING]);
    $contact_email = $disciteDB->keys()->create('contact_email',['type'=>DisciteDB::TYPE_STRING_EMAIL]);
    $category_id = $disciteDB->keys()->create('category_id',['type'=>DisciteDB::TYPE_INTEGER_BIGINT,'index'=>DisciteDB::INDEX_TYPE_INDEX,'indexTable'=>$table_categories]);
    $item_id = $disciteDB->keys()->create('item_id',['type'=>DisciteDB::TYPE_INTEGER_BIGINT,'index'=>DisciteDB::INDEX_TYPE_INDEX,'indexTable'=>$table_items]);
    $supplier_id = $disciteDB->keys()->create('supplier_id',['type'=>DisciteDB::TYPE_INTEGER_BIGINT,'index'=>DisciteDB::INDEX_TYPE_INDEX,'indexTable'=>$table_suppliers]);

    $disciteDB->tables()->appendKey('disciteDB_FakeItems',$key_name,$key_desc,$key_price,$category_id);
    $disciteDB->tables()->appendKey('disciteDB_FakeItemSuppliers',$item_id,$supplier_id);
    $disciteDB->tables()->appendKey('disciteDB_FakeCategories',$category_name);
    $disciteDB->tables()->appendKey('disciteDB_FakeSuppliers',$supplier_name, $contact_email);



    // QUERY -- SELECT
    $queryFakeItems = $disciteDB->table('disciteDB_FakeItems')->listing([
        'name'=>QueryCondition::Not('White Widget'),
        'description'=>QueryCondition::Contains('and',QueryLocation::Between),
        'price' => QueryCondition::LessOrEqual(25),
        // QueryMethod::Async($user),
    ]);

    // After that, you can show values :

    // You will get only informations but no values
    echo '<br/><br/><br/><br/><b>QUERY</b>';
    echo '<pre>',var_dump($queryFakeItems->fetchQuery()),'</pre>';


    // You will get only informations but no values
    echo '<b>INFORMATIONS ONLY</b>';
    echo '<pre>',var_dump($queryFakeItems->fetchInformations()),'</pre>';
    
    // You will have the next data
    echo '<b>NEXT DATA</b>';
    echo '<pre>',var_dump($queryFakeItems->fetchNext()),'</pre>';
    
    // You will have all data
    echo '<b>ALL DATA</b>';
    echo '<pre>',var_dump($queryFakeItems->fetchAll()),'</pre>';
    
    // You will have all data and infos
    echo '<b>ALL DATA AND INFORMATIONS</b>';
    echo '<pre>',var_dump($queryFakeItems->fetchArray()),'</pre>';
    
?>