<?php

namespace App\Http\Controllers;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
* @OA\Server(
* url="http://shelf-api-challenge.herokuapp.com/api/"
* )
* @OA\Info(title="Shelf API", version="1.0.0",
* description="RestAPI based on building a shelf of products using the VTEX Search API as a database.",
*)
*/
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
