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
  * Handle the GET request by returning
  * a json with 12 items of the top
  * Selling products into "Perfume"
  * (1000001) category.
  *
  * @return JsonResponse
  * @author Angélica Nunes
  */
  public function handle(): JsonResponse
  {

    $response = Http::withHeaders($this->shelf->header())
      ->get(
        $this->shelf->url(),
        $this->shelf->queryParams()
      );

    $products = collect(json_decode($response, true));
    $shelf_list = [];

    foreach ($products as $product => $value) {
      array_push($shelf_list, [
        'productName' => Arr::get($products, $product . '.productName'),
        'productId' => Arr::get($products, $product . '.productId'),
        'brand' => Arr::get($products, $product . '.brand'),
      ]);
    }

    return response()->json($shelf_list, 201);
  }

  public function index(): JsonResponse
  {

  }

  public function show($rate): JsonResponse
  {

  }
}
