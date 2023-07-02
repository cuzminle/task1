<?php

namespace App\Http\Controllers;

use App\Services\User\Service;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public $userService;

    public function __construct(Service $userService)
    {
        $this->userService = $userService;
    }
}
