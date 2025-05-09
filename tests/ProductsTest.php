<?php
    ini_set('display_errors','1');
    ini_set('display_startup_erros','1');
    error_reporting(E_ALL);
    
    require dirname(__DIR__, 2).'/discite-php/vendor/autoload.php';


        $connection = new \DisciteDB\Connection();
        $database = new \DisciteDB\Database($connection);
    // $user = new \disciteDB\Core\UsersManager();

    // $database->config()->security->enableCsrf(true);
    // $database->config()->security->enablePermissions(false);
    // $database->config()->security->enableSanitize(false);

    // $database->config()->logs->enableLogs(false);
    // $database->config()->logs->setTable();
    // $database->config()->logs->createTable('disc_logs');
        $account = $database->config()->tables->create('account',['alias'=>'accounter','prefix'=>'disc_']);

        $key_id = $database->config()->keys->create('id',['type'=>'int','default'=>null,'nullable'=>false,'secure'=>false,'updatable'=>false]);
        $key_token = $database->config()->keys->create('token',['type'=>'string','default'=>'bite','nullable'=>false,'secure'=>true,'updatable'=>false]);

        // echo '<pre>',var_dump($account->getAlias()),'</pre>';
        $database->config()->tables->appendKey($account->getAlias(),$key_id,$key_token);
        
        // echo '<pre>',var_dump($account->getMap()),'</pre>';
        
        $database->accounter->create();
    // $database->config()->tables->create('table',['alias'=>'table_alias','prefix'=>'disc_'],['key_1','key_2']);
    // $database->config()->tables->update('table',['alias'=>'table_alias','prefix'=>'disc_'],['key_1','key_2']);
    // $database->config()->tables->delete('table');
    // $database->config()->tables->appendKey('table',['key_1','key_2']);
    // $database->config()->tables->loadExistingTables();

    // $database->config()->users->create('name',['table.all','table.compare','table.count','table.create']);

    // $csrfSecurity = SecurityCsrf::generateCsrf(64);
    // $csrfSecurity = SecurityCsrf::checkCsrf('test');

?>