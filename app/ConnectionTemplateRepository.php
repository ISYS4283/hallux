<?php

namespace App;

class ConnectionTemplateRepository
{
    public function getTemplatesArray() : array
    {
        return [
            'sqlite' => [
                'driver' => 'sqlite',
                'database' => null,
                'prefix' => null,
            ],

            'mysql' => [
                'driver' => 'mysql',
                'host' => '127.0.0.1',
                'port' => '3306',
                'database' => null,
                'username' => null,
                'password' => null,
                'unix_socket' => null,
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_ci',
                'prefix' => '',
                'strict' => true,
                'engine' => null,
            ],

            'pgsql' => [
                'driver' => 'pgsql',
                'host' => '127.0.0.1',
                'port' => '5432',
                'database' => null,
                'username' => null,
                'password' => null,
                'charset' => 'utf8',
                'prefix' => '',
                'schema' => 'public',
                'sslmode' => 'prefer',
            ],

            'sqlsrv' => [
                'driver' => 'sqlsrv',
                'host' => '127.0.0.1',
                'port' => '1433',
                'database' => null,
                'username' => null,
                'password' => null,
                'charset' => 'utf8',
                'prefix' => '',
            ],
        ];
    }
}
