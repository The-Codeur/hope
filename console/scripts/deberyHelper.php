<?php

use Command\DeberyHelper;
use Command\Schema;

if($debery->getArgv(1) === 'model:create' && $debery->argcOp() === 3)
{
    $file = glob(basePath('app/Models/'.ucfirst($debery->getArgv(2)).'.php') ?: []);

    if(empty($file))
    {
        $file = fopen(basePath('app/Models/' .ucfirst($debery->getArgv(2)).'.php'), 'w');
        $content = DeberyHelper::createModel($debery->getArgv(2));

        fwrite($file, $content);

        fclose($file);

        echo "\033[32m MODEL: ".ucfirst($debery->getArgv(2)). " crée avec succès \033[0m \n";
    }else{

        echo "\033[31m MODEL: {$debery->getArgv(2)} existe déja \033[0m \n";
    }
}

if($debery->getArgv(1) === 'model:create' && $debery->argcOp() === 4)
{
    $fileModel = glob(basePath('app/Models/' .ucfirst($debery->getArgv(2)).'.php') ?: []);

    $fileMigration = glob(databasePath('migrations/*_'.strtolower($debery->getArgv(2)).'_table.php') ?: []);

    if($debery->getArgv(3) === '--migration' || $debery->getArgv(3) === '-m')
    {
        if(empty($fileModel) || empty($fileMigration))
        {
            $fileModel = fopen(basePath('app/Models/' .ucfirst($debery->getArgv(2)).'.php'), 'w');
            $contentModel = DeberyHelper::createModel($debery->getArgv(2));

            $fileMigration = fopen(databasePath('migrations/'.time().'_create_'.strtolower($debery->getArgv(2)).'_table.php'), 'w');
            $contentMigration = Schema::createMigration($debery->getArgv(2));

            fwrite($fileModel, $contentModel);
            fwrite($fileMigration, $contentMigration);

            fclose($fileModel);
            fclose($fileMigration);

            echo "\033[32m MODEL & MIGRATION: ".ucfirst($debery->getArgv(2)). " crée avec succès \033[0m \n";
        }else{

            echo "\033[31m MODEL & MIGRATION: {$debery->getArgv(2)} existe déja \033[0m \n";
        }
    }
}

if($debery->getArgv(1) === 'controller:create' && $debery->argcOp() === 3)
{
    $name = '';

    $name = strpos($debery->getArgv(2), 'Controller') !== false ? $debery->getArgv(2) : $debery->getArgv(2).'Controller';

    $file = glob(basePath('app/Http/Controllers/'.ucfirst($name).'.php') ?: []);

    if(empty($file))
    {

        $file = fopen(basePath('app/Http/Controllers/' . ucfirst($name) . '.php'), 'w');
        $content = DeberyHelper::createController($name);

        fwrite($file, $content);

        fclose($file);

        echo "\033[32m CONTROLLER: ".ucfirst($debery->getArgv(2)). " crée avec succès \033[0m \n";
    }else{

        echo "\033[31m CONTROLLER: {$debery->getArgv(2)} existe déja \033[0m \n";
    }
}

if($debery->getArgv(1) === 'middleware:create' && $debery->argcOp() === 3)
{
    $name = '';

    $name = strpos($debery->getArgv(2), 'Middleware') !== false ? $debery->getArgv(2) : $debery->getArgv(2).'Middleware';

    $file = glob(basePath('app/Http/Middlewares/'.ucfirst($name).'.php') ?: []);

    if(empty($file))
    {

        $file = fopen(basePath('app/Http/Middlewares/' . ucfirst($name) . '.php'), 'w');
        $content = DeberyHelper::createMiddleware($name);

        fwrite($file, $content);

        fclose($file);

        echo "\033[32m MIDDLEWARE: ".ucfirst($debery->getArgv(2)). " crée avec succès \033[0m \n";
    }else{

        echo "\033[31m MIDDLEWARE: {$debery->getArgv(2)} existe déja \033[0m \n";
    }
}

if($debery->getArgv(1) === 'event:create' && $debery->argcOp() === 3)
{

    $name = strpos($debery->getArgv(2), 'Event') !== false ? $debery->getArgv(2) : $debery->getArgv(2).'Event';

    $file = glob(basePath('app/Events'.DS.ucfirst($name).'.php') ?: []);

    if(empty($file))
    {

        $file = fopen(basePath('app/Events'.DS.ucfirst($name).'.php'), 'w');
        $content = DeberyHelper::createEvent($name);

        fwrite($file, $content);

        fclose($file);

        echo "\033[32m Event: ".ucfirst($debery->getArgv(2)). " crée avec succès \033[0m \n";
    }else{

        echo "\033[31m Event: {$debery->getArgv(2)} existe déja \033[0m \n";
    }
} //End Events

if ($debery->getArgv(1) === 'provider:create' && $debery->argcOp() === 3) {

    $name = strpos($debery->getArgv(2), 'ServiceProvider') !== false ? $debery->getArgv(2) : $debery->getArgv(2) . 'ServiceProvider';

    $file = glob(basePath('app/Providers' . DS . ucfirst($name) . '.php') ?: []);

    if (empty($file)) {

        $file = fopen(basePath('app/Providers' . DS . ucfirst($name) . '.php'), 'w');
        $content = DeberyHelper::createprovider($name);

        fwrite($file, $content);

        fclose($file);

        echo "\033[32m Provider: " . ucfirst($debery->getArgv(2)) . " crée avec succès \033[0m \n";
    } else {

        echo "\033[31m Provider: {$debery->getArgv(2)} existe déja \033[0m \n";
    }
} //end Providers

