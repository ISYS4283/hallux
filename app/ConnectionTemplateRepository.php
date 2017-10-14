<?php

namespace App;

class ConnectionTemplateRepository
{
    public function getTemplatesArray() : array
    {
        $blacklist = [
            'host',
            'database',
            'username',
            'password',
        ];

        foreach (config('database.connections') as $key => $connection) {
            foreach ($connection as $name => &$attribute) {
                if (in_array($name, $blacklist)) {
                    $attribute = null;
                }
            }

            $return[$key] = $connection;
        }

        return $return;
    }
}
