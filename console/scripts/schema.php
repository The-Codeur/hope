<?php

use Command\Schema;
use Command\DeberyHelper;
use Illuminate\Database\Capsule\Manager as DB;

if($debery->getArgv(1) === 'db:create' && $debery->argcOp() === 3)
{
    if(Schema::createDatabase($debery->getArgv(2)))
    {
        echo "\033[32m Base des données ". $debery->getArgv(2) . " crée avec succès \033[0m \n";
    }else{
        echo "\033[31m".$debery->getArgv(2) . " existe déja comme base des données \033[0m \n";
    }
}

if($debery->getArgv(1) === 'migration:create' && $debery->argcOp() === 3)
{
    $file = glob(databasePath('migrations/*create_'.strtolower($debery->getArgv(2)).'_table.php') ?: []);

    if(empty($file))
    {
        $file = fopen(databasePath('migrations/'.time().'_create_' . strtolower($debery->getArgv(2)) . '_table.php'), 'w');
    
        $content = Schema::createMigration($debery->getArgv(2));

        fwrite($file, $content);

        fclose($file);

        echo "\033[32m MIGRATION: {$debery->getArgv(2)} crée avec succès \033[0m \n";
    }else{

        echo "\033[31m MIGRATION: {$debery->getArgv(2)} existe déja \033[0m \n";
    }
}

if($debery->getArgv(1) === 'migration:alter' && $debery->argcOp() === 3)
{
    
    $file = glob(databasePath('migrations/*create_' . strtolower($debery->getArgv(2)) . '_table.php') ?: []);

    if(!empty($file))
    {
        
        $content = Schema::alterMigration($debery->getArgv(2));

        file_put_contents($file[0], $content, FILE_APPEND);

        echo "\033[32m MIGRATION: {$debery->getArgv(2)} modifier avec succès \033[0m \n";
    }else{

        echo "\033[31m MIGRATION: {$debery->getArgv(2)} n'existe pas \033[0m \n";
    }
}

if($debery->getArgv(1) === 'migration:rename' && $debery->argcOp() === 4)
{
    
    $file = glob(databasePath('migrations/*create_' . strtolower($debery->getArgv(2)) . '_table.php') ?: []);

    if(!empty($file))
    {
        
        $content = Schema::renameMigration($debery->getArgv(2), $debery->getArgv(3));

        file_put_contents($file[0], $content, FILE_APPEND);

        echo "\033[32m MIGRATION: {$debery->getArgv(2)} modifier avec succès \033[0m \n";
    }else{

        echo "\033[31m MIGRATION: {$debery->getArgv(2)} n'existe pas \033[0m \n";
    }
}

if($debery->getArgv(1) === 'db:migrate' && $debery->argcOp() === 2)
{
    
    $files = glob(databasePath('migrations/*_table.php') ?: []);

    if(!empty($file))
    {
        
       array_map(function($file){
            DB::statement("SET foreign_key_checks=0");
            require_once $file;
            DB::statement("SET foreign_key_checks=1");
       }, $files);

        echo "\033[32m MIGRATION: effectuer avec succès \033[0m \n";
    }else{

        echo "\033[31m MIGRATION: aucun fichier à migrer \033[0m \n";
    }
}

if($debery->getArgv(1) === 'db:migrate' && $debery->argcOp() === 3)
{
    
    $file = glob(databasePath('migrations/*_create_' . strtolower($debery->getArgv(2)) . '_table.php') ?: []);

    if(!empty($file))
    {
        DB::statement("SET foreign_key_checks=0");
        require_once $file[0];
        DB::statement("SET foreign_key_checks=1");


        echo "\033[32m MIGRATION: effectuer avec succès \033[0m \n";
    }else{

        echo "\033[31m MIGRATION: aucun fichier à migrer \033[0m \n";
    }
}

if($debery->getArgv(1) === 'migration:create' && $debery->argcOp() === 4)
{
    
    $fileModel = glob(basePath('app/Models/' . ucfirst($debery->getArgv(2)) . '.php') ?: []);

    $fileMigration = glob(databasePath('migrations/*_' . strtolower($debery->getArgv(2)) . '_table.php') ?: []);

    if($debery->getArgv(3) === '--model' || $debery->getArgv(3) === '-m')
    {
        if(empty($fileModel) || empty($fileMigration))
        {
            $fileModel = fopen(basePath('app/Models/' . ucfirst($debery->getArgv(2)) . '.php'), 'w');
            $contentModel = DeberyHelper::createModel($debery->getArgv(2));
            
            $fileMigration = fopen(databasePath('migrations/'.time().'_create_'.strtolower($debery->getArgv(2)).'_table.php'), 'w');
            $contentMigration = Schema::createMigration($debery->getArgv(2));

            fwrite($fileModel, $contentModel);
            fwrite($fileMigration, $contentMigration);

            fclose($fileModel);
            fclose($fileMigration);

            echo "\033[32m MIGRATION & MODEL: ".ucfirst($debery->getArgv(2)). " crée avec succès \033[0m\n";
        }else{

            echo "\033[31m MIGRATION & MODEL: {$debery->getArgv(2)} existe déja \033[0m \n";
        }
    }    
}

if($debery->getArgv(1) === 'migration:create' && $debery->argcOp() === 4)
{
    
    $fileSeeder = glob(databasePath('seeders/' . strtolower($debery->getArgv(2)) . '.php') ?: []);
    
    $fileMigration = glob(databasePath('migrations/*_' . strtolower($debery->getArgv(2)) . '_table.php') ?: []);

    if($debery->getArgv(3) === '--seeder' || $debery->getArgv(3) === '-s')
    {
        if(empty($fileSeeder) || empty($fileMigration))
        {
            $fileSeeder = fopen(databasePath('seeders/' . strtolower($debery->getArgv(2)) . '.php'), 'w');
            $contentSeeder = Schema::createSeeder($debery->getArgv(2));
            
            $fileMigration = fopen(databasePath('migrations/' . time() . '_create_' . strtolower($debery->getArgv(2)) . '_table.php'), 'w');
            $contentMigration = Schema::createMigration($debery->getArgv(2));

            fwrite($fileSeeder, $contentSeeder);
            fwrite($fileMigration, $contentMigration);

            fclose($fileSeeder);
            fclose($fileMigration);

            echo "\033[32m MIGRATION & SEEDER: ".ucfirst($debery->getArgv(2)). " crée avec succès \033[0m \n";
        }else{

            echo "\033[31m MIGRATION & SEEDER: {$debery->getArgv(2)} existe déja \033[0m \n";
        }
    }    
}

if($debery->getArgv(1) === 'seeder:create' && $debery->argcOp() === 3)
{
    
    $file = glob(databasePath('seeders/' . strtolower($debery->getArgv(2)) . '.php') ?: []);

    if(empty($file))
    {
        $file = fopen(databasePath('seeders/' . strtolower($debery->getArgv(2)) . '.php'), 'w');
        
        $content = Schema::createSeeder($debery->getArgv(2));

        fwrite($file, $content);

        fclose($file);

        echo "\033[32m SEEDER: {$debery->getArgv(2)} crée avec succès \033[0m \n";
    }else{

        echo "\033[31m SEEDER: {$debery->getArgv(2)} existe déja \033[0m \n";
    }
}

if($debery->getArgv(1) === 'seeder:create' && $debery->argcOp() === 4)
{

    $fileSeeder = glob(databasePath('seeders/' . strtolower($debery->getArgv(2)) . '.php') ?: []);

    $fileMigration = glob(databasePath('migrations/*_' . strtolower($debery->getArgv(2)) . '_table.php') ?: []);

    if($debery->getArgv(3) === '--migration' || $debery->getArgv(3) === '-m')
    {
        if(empty($fileSeeder) || empty($fileMigration))
        {
            $fileSeeder = fopen(databasePath('seeders/' . strtolower($debery->getArgv(2)) . '.php'), 'w');
            $contentSeeder = Schema::createSeeder($debery->getArgv(2));

            $fileMigration = fopen(databasePath('migrations/' . time() . '_create_' . strtolower($debery->getArgv(2)) . '_table.php'), 'w');
            $contentMigration = Schema::createMigration($debery->getArgv(2));

            fwrite($fileSeeder, $contentSeeder);
            fwrite($fileMigration, $contentMigration);

            fclose($fileSeeder);
            fclose($fileMigration);

            echo "\033[32m SEEDER & MIGRATION: ".ucfirst($debery->getArgv(2)). " crée avec succès \033[0m \n";
        }else{

            echo "\033[31m SEEDER & MIGRATION: {$debery->getArgv(2)} existe déja \033[0m \n";
        }
    }    
}

if($debery->getArgv(1) === 'db:seed' && $debery->argcOp() === 2)
{

    $files = glob(databasePath('seeders/*.php') ?: []);

    if(!empty($file))
    {
        
       array_map(function($file){

            DB::statement("SET foreign_key_checks=0");
            require_once $file;
            DB::statement("SET foreign_key_checks=1");

       }, $files);

        echo "\033[32m SEEDER: effectuer avec succès \033[0m \n";
    }else{

        echo "\033[31m SEEDER: aucun fichier à migrer \033[0m \n";
    }
}

if($debery->getArgv(1) === 'db:seed' && $debery->argcOp() === 3)
{
    
    $file = glob(databasePath('seeders/' . $debery->getArgv(2) . '.php') ?: []);

    if(!empty($file))
    {

        DB::statement("SET foreign_key_checks=0");
        require_once $file[0];
        DB::statement("SET foreign_key_checks=1");

        echo "\033[32m SEEDER: effectuer avec succès \033[0m \n";
    }else{

        echo "\033[31m SEEDER: aucun fichier à migrer \033[0m \n";
    }
}