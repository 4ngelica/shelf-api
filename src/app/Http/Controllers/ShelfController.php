<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Arr;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Shelf;
use Exception;

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
  * @return JsonResponse
  * @author Angélica Nunes
  */
  public function index(): JsonResponse
  {
    $shelf_list = $this->handleRequest();
    return response()->json($shelf_list, JsonResponse::HTTP_OK);
  }

  /**
  * Responds to a GET request into the
  * /shelf/{item} endpoint with the
  * product classified in this position
  *
  * @return JsonResponse
  * @param Int $item
  * @author Angélica Nunes
  */
  public function show(Int $item): JsonResponse
  {
    try{
        $shelf_item = $this->handleRequest($item);
        return response()->json(
        $shelf_item, JsonResponse::HTTP_CREATED);

    }catch (Exception $e) {
      return response()->json(
        ['error' => 'The requested resource does not exist.'],
        JsonResponse::HTTP_NOT_FOUND);
    }
  }

  /**
  * Sends a GET request to the Vtex Search API
  * and returns an array with the 12 top selling
  * products into "Perfume" (1000001) category.
  *
  * @return Array
  * @param Int $item
  * @author Angélica Nunes
  */
  public function handleRequest(Int $item = null): Array
  {
    $response = Http::withHeaders($this->shelf->header())
    ->get(
      $this->shelf->url(),
      $this->shelf->queryParams()
    );

    $products = collect(json_decode($response, true));

    if (!is_null($item)) {
      return $products[$item-1];
    }else {
      return self::generateProductList($products);
    }
  }

  /**
  * Responds to a GET request into the /product/
  * endpoint with the 12 top selling products
  *
  * @return Array
  * @param Array $products
  * @author Angélica Nunes
  */
  public function generateProductList($products): Array
  {
    $prices = [];
    $shelf_list = [];

    foreach ($products as $product => $value) {
      array_push($shelf_list, [
        'item' => $product+1,
        'productName' => Arr::get($products, $product . '.productName'),
        'brand' => Arr::get($products, $product . '.brand'),
        'imageUrl' => Arr::get($products, $product . '.items.0.images.0.imageUrl'),
        'pricesPerSize' => [],
      ]);

      $items = Arr::get($products, $product . '.items');

      for ($i=0; $i < count($items); $i++) {

        array_push($prices, [
          $items[$i]['name'] => [
            'Price' => $items[$i]['sellers'][0]['commertialOffer']['Price'],
            'ListPrice'=>$items[$i]['sellers'][0]['commertialOffer']['ListPrice']]
          ]);
      }

      $shelf_list[$product]['pricesPerSize'] = $prices;
      $prices =[];
    }
    return $shelf_list;
  }
}
