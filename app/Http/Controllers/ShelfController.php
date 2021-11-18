<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Arr;
use Illuminate\Http\JsonResponse;
use App\Models\Shelf;


class ShelfController extends Controller
{

  /**
  * ShelfController constructor.
  * @param Shelf $shelf
  */
  public function __construct(Shelf $shelf)
  {
    $this->shelf = $shelf;
  }

  /**
  * Responds to a GET request into the /product/
  * endpoint with the 12 top selling products
  *
  * @return JsonResponse
  * @author Angélica Nunes
  */
  public function index(): JsonResponse
  {
    $shelf_list = $this->handle();
    return response()->json($shelf_list, 201);
  }

  /**
  * Responds to a GET request into the
  * /product/{rate} endpoint with the
  * product classified in this position
  *
  * @return JsonResponse
  * @author Angélica Nunes
  */
  public function show($rate): JsonResponse
  {
    if($rate < 1 || $rate > 12){
      return response()->json(['error'=>'The requested resource does not exist.'], 404);
    }

    $shelf_item = $this->handle()[$rate-1];
    return response()->json($shelf_item, 201);
  }

  /**
  * Sends a GET request to the Vtex Search API
  * and returns an array with the 12 top selling
  * products into "Perfume" (1000001) category.
  *
  * @return JsonResponse
  * @author Angélica Nunes
  */
  public function handle(): Array
  {
    $shelf_list = [];
    $i = 1;

    $response = Http::withHeaders($this->shelf->header())
      ->get(
        $this->shelf->url(),
        $this->shelf->queryParams()
      );

    $products = collect(json_decode($response, true));

    foreach ($products as $product => $value) {

      array_push($shelf_list, [
        'productName' => Arr::get($products, $product . '.productName'),
        'rate' => $i,
        'productId' => Arr::get($products, $product . '.productId'),
        'brand' => Arr::get($products, $product . '.brand'),
      ]);

      $i++;
    }

    return $shelf_list;
  }
}
