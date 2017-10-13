<?php

namespace App\DataSources;

class Example implements DataSource
{
    protected function setConfig()
    {
        
    }

    public function getConnectionName() : string
    {
        return config('app.')
    }
}
