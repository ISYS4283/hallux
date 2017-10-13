<?php

namespace App\DataSources;

interface DataSource
{
    public function getConnectionName() : string;
}
