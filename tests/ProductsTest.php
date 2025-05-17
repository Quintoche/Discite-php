<?php

use DisciteDB\Config\Enums\KeyUsage;
use DisciteDB\Config\Enums\QueryLocation;
use DisciteDB\DisciteDB;
use DisciteDB\Methods\QueryMethod;

    ini_set('display_errors','1');
    ini_set('display_startup_erros','1');
    error_reporting(E_ALL);
    
    require dirname(__DIR__, 2).'/discite-php/vendor/autoload.php';


        $connection = mysqli_connect('localhost','root','','gfis_boutique');
        // $database = new \DisciteDB\Database($connection);

        // $database->config()->setTableUsage(DisciteDB::TABLE_USAGE_LOOSE);
        // $database->config()->setKeyusage(KeyUsage::LooseUsage);


        // $database->tables()->add('test');

    // $user = new \disciteDB\Core\UsersManager();

    // $database->configuration()->security->enableCsrf(true);
    // $database->config()->security->enablePermissions(false);
    // $database->config()->security->enableSanitize(false);

    // $database->config()->logs->enableLogs(false);
    // $database->config()->logs->setTable();
    // $database->config()->logs->createTable('disc_logs');
        // $account = $database->configuration()->tables->create('account',['alias'=>'accounter','prefix'=>'disc_']);

        // $key_id = $database->keys()->create('itemId',['type'=>TypeInteger::BigInt,'default'=>null,'nullable'=>true,'secure'=>false,'updatable'=>false]);
        // $key_token = $database->keys()->create('itemToken',['type'=>TypeString::String,'default'=>'bite','nullable'=>false,'secure'=>true,'updatable'=>false]);
        // $key_bite = $database->keys()->create('itemNomWeb',['type'=>TypeString::String,'default'=>DefaultValue::UUIDv4,'nullable'=>false,'secure'=>false,'updatable'=>true]);
        // $key_bdate = $database->keys()->create('itemNomSubtitle',['type'=>TypeString::String,'default'=>DefaultValue::CurrentTimestamp,'nullable'=>false,'secure'=>false,'updatable'=>true]);

        // echo '<pre>',var_dump($account->getAlias()),'</pre>';
        // $database->configuration()->tables->appendKey($account->getAlias(),$key_id,$key_token,$key_bite);
        
        // echo '<pre>',var_dump($account->getMap()),'</pre>';
        
        // $database->tables()->create('gfisAdmnItems',['alias'=>'gfisAdmnItems']);
        // $database->config()->tables->create('table',['alias'=>'table_alias','prefix'=>'disc_'],['key_1','key_2']);
        // $database->config()->tables->update('table',['alias'=>'table_alias','prefix'=>'disc_'],['key_1','key_2']);
        // $database->config()->tables->delete('table');
        // $database->tables()->appendKey('gfisAdmnItems',$key_id,$key_token,$key_bite,$key_bdate);
        // $database->accounter->create(['id'=>3]);
        // $items_result = $database->gfisAdmnItems->listing(['itemNomWeb'=>QueryMethod::Contains('cle',QueryLocation::Between)]);
        
        // echo '<pre>', var_dump($items_result->fetchInformations()), '</pre>';
        // echo '<pre>', var_dump($items_result->fetchNext()), '</pre>';
        // echo '<pre>', var_dump($items_result->fetchNext()), '</pre>';
        // echo '<pre>', var_dump($items_result->fetchNext()), '</pre>';
        // echo '<pre>', var_dump($items_result->fetchNext()), '</pre>';

        // $items_result_all = $database->users->all();
        // $items_result_all = $database->table('gfis_admn_images')->create(['image_token'=>bin2hex(random_bytes(64)),'image_lien'=>3,'image_document'=>'2025-05-13']);
 
        // echo '<pre>',var_dump($items_result_all->fetchArray()),'</pre>';
        // echo '<pre>',var_dump($database->gfis_admn_mouvements->all()->fetchArray()),'</pre>';

// if ($connection->connect_error) {
//     die('Erreur mysqli : ' . $connection->connect_error);
// }

// Connexion via ta librairie
$database = new \DisciteDB\Database($connection);

$database->config()->setTableUsage(DisciteDB::TABLE_USAGE_LOOSE);
    $database->config()->setKeyusage(DisciteDB::KEY_USAGE_LOOSE);
    $database->config()->setNamingConvention(DisciteDB::NAMING_CONVENTION_UNDEFINED);

$tableName = 'gfis_admn_mouvements';
$iterations = 500;

// Utils
function ms(float $start, float $end): float {
    return round(($end - $start) * 1000, 4); // millisecondes
}

function average(array $values): float {
    return round(array_sum($values) / count($values), 4);
}

// Benchmark mysqli brut
$rawTimes = [];

for ($i = 0; $i < $iterations; $i++) {
    $start = microtime(true);
    $result = $connection->query("SELECT * FROM `$tableName`");
    $data = $result->fetch_all(MYSQLI_ASSOC);
    $end = microtime(true);
    $rawTimes[] = ms($start, $end);
}

// Benchmark DisciteDB
$libTimes = [];

for ($i = 0; $i < $iterations; $i++) {
    $start = microtime(true);
    $data = $database->table($tableName)->all()->fetchArray(); // ou $db->$tableName->all();
    $end = microtime(true);
    $libTimes[] = ms($start, $end);
}

// Résultat
echo "=== Résultats après $iterations itérations ===\n\n<br/>";
echo "=== LOOSE MODE ===\n\n<br/>";
echo "[mysqli]    Moyenne : " . average($rawTimes) . " ms\n<br/>";
echo "[Discite-PHP] Moyenne : " . average($libTimes) . " ms\n<br/>";



echo '<br/><br/><br/><br/>';

$database->config()->setTableUsage(DisciteDB::TABLE_USAGE_STRICT);
    $database->config()->setKeyusage(DisciteDB::KEY_USAGE_STRICT);

    $database->tables()->add($tableName,$tableName);

    $key_mvt_id = $database->keys()->create('mouvement_id',['type'=>DisciteDB::TYPE_INTEGER_BIGINT]);

    $database->tables()->appendKey($tableName,$key_mvt_id);


// Benchmark mysqli brut
$rawTimes = [];

for ($i = 0; $i < $iterations; $i++) {
    $start = microtime(true);

    $result = $connection->query("SELECT * FROM `$tableName` WHERE `mouvement_id` != 9999 ");
    $data = $result->fetch_all(MYSQLI_ASSOC);

    
    $end = microtime(true);
    $rawTimes[] = ms($start, $end);
}

// Benchmark DisciteDB
$libTimes = [];

for ($i = 0; $i < $iterations; $i++) {
    $start = microtime(true);


    $data = $database->table($tableName)->listing(
        ['mouvement_id'=>QueryMethod::Not(9999)]
        )->fetchArray(); // ou $db->$tableName->all();



    $end = microtime(true);
    $libTimes[] = ms($start, $end);
}


// Résultat
echo "=== Résultats après $iterations itérations ===\n\n<br/>";
echo "=== STRICT MODE ===\n\n<br/>";
echo "[mysqli]    Moyenne : " . average($rawTimes) . " ms\n<br/>";
echo "[Discite-PHP] Moyenne : " . average($libTimes) . " ms\n<br/>";

        // $database->accounter->update(['id'=>3],['token'=>QueryMethod::Contains('discite',QueryLocation::Between),'datecreated'=>'2024-09-22']);
        // print_r(($database->gfis_admn_mouvements->all())->fetchArray());
    // $database->config()->tables->loadExistingTables();

    // $database->config()->users->create('name',['table.all','table.compare','table.count','table.create']);

    // $csrfSecurity = SecurityCsrf::generateCsrf(64);
    // $csrfSecurity = SecurityCsrf::checkCsrf('test');
    
    // var_dump(FieldValidator::validate($database->keys()->create('test_longText',['type'=>TypeString::LongText,'default'=>null,'nullable'=>true,'secure'=>false,'updatable'=>false]),Operators::Listing, QueryMethod::Or('yes','no','maybe')));
    // TypeManager::checkType('LongText',TypeString::String);
    $database->keys()->create('password',[]);

    // echo '<pre>',var_dump($database->keys()->test_longText->getAll()),'</pre>';
    // echo '<pre>',var_dump($database->keys()->password->getAll()),'</pre>';

    // $database->keys()->update();

    // $database->tables()->create();
    // $database->tables()->update();

    // $database->users()->create();
    // $database->users()->update();

    // $database->security()::generateCsrf(64);
    // $database->security()::checkCsrf('test');

?>