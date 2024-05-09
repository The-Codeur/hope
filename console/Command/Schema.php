<?php
namespace Command;

class Schema
{

    public static function createDatabase(string $name)
    {
    
        $stm = 'mysql:host=' . env('DB_HOST', '127.0.0.1') . ';charset=' . env('DB_CHARSET', 'utf8mb4');
        $db = new \PDO($stm, env('DB_USERNAME'), env('DB_PASSWORD'));

        return $db->exec("CREATE DATABASE IF NOT EXISTS {$name}")? true : false;    
    }

public static function createMigration(string $table){

$table = strpos($table, '_') !== false? $table : $table.'s';

return "<?php

use Illuminate\\Database\\Capsule\\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

Capsule::schema()->dropIfExists('".$table."');

Capsule::schema()->create('".$table."',function(Blueprint \$table){
    \$table->increments('id');
});";
}


public static function alterMigration(string $table){

$table = strpos($table, '_') !== false? $table : $table.'s';

return "\n 
Capsule::schema()->table('".$table."',function(Blueprint \$table){
    
});";
}

public static function renameMigration(string $from, string $to){

    $from = strpos($from, '_') !== false? $from : $from.'s';
    $to = strpos($to, '_') !== false? $to : $to.'s';
    
    return "\n 
Capsule::schema()->rename('".$from."', '".$to."');";
}

public static function createSeeder(string $table){

$table = strpos($table, '_') !== false? $table : $table.'s';
    
    return "<?php
    
use Illuminate\\Database\\Capsule\\Manager as Capsule;

\$faker = \\Faker\\Factory::create();

Capsule::select('TRUNCATE TABLE {$table}');

foreach(range(1, 10) as \$x)
{
    Capsule::table('{$table}')->insert([
        
    ]);
}";
}
    
}

