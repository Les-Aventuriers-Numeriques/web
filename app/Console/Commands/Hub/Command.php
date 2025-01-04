<?php

namespace App\Console\Commands\Hub;

use Illuminate\Console\Command as BaseCommand;
use Illuminate\Support\Facades\Config;

abstract class Command extends BaseCommand
{
    public function __construct()
    {
        config([
            'app.name' => 'Hub '.Config::string('app.name'),
        ]);

        parent::__construct();
    }
}
