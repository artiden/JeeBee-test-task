<?php

namespace App\Support;

use Dotenv\Dotenv;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

class Config
{
    public static function get(string $name, $default = null):?string
    {
        static $dotEnv = null;
        if (is_null($dotEnv)) {
            $dotEnv = new Dotenv(__DIR__.'/../..');
            $dotEnv->load();
        }

        $value = getenv($name);

        if (!$value || empty($value)) {
            $value = $default;
        }

        return $value;
    }

    public static function getEntityManager()
    {
        static $entityManager = null;

        if (is_null($entityManager)) {
            $configuration = Setup::createAnnotationMetadataConfiguration([__DIR__.'/../Models'], true, null, null, false);
            $connectionParams = [
                'dbname' => Config::get('DB_NAME'),
                'user' => Config::get('DB_USER'),
                'password' => Config::get('DB_PASSWORD'),
                'host' => Config::get('DB_HOST'),
                'driver' => Config::get('DB_DRIVER'),
            ];
            $entityManager = EntityManager::create($connectionParams, $configuration);
        }

        return $entityManager;
    }
}
