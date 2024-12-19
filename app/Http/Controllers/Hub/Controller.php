<?php

namespace App\Http\Controllers\Hub;

use App\Http\Controllers\Controller as BaseController;
use Artesaos\SEOTools\Facades\SEOMeta;

abstract class Controller extends BaseController
{
    public function __construct()
    {
        SEOMeta::setTitleDefault('Hub Les Aventuriers Numériques');
        SEOMeta::setRobots('noindex, nofollow');
    }
}
