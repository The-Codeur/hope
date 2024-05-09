<?php
namespace App\Http\Core;

class Config
{
    public static function get(string $path)
    {
        if($path)
        {
            $path = explode('.', $path);

            $files = array_merge(glob(configPath('*.php') ?: []));

            $data = array_map(fn ($file) => require $file, $files);

            $config = array_merge_recursive(...$data);

            foreach($path as $bit)
            {
                if(isset($config[$bit]))
                {
                    $config = $config[$bit];
                }
            }

            return $config;
        }
    }
}