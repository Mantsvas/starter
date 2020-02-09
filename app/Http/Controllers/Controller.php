<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function royaleKeyValidation($key)
    {
      if ( preg_match("/^[0289PYLQGRJCUVpylqgrjcuv]*$/",$key)){
          return true;
      }
      return false;
    }
}
