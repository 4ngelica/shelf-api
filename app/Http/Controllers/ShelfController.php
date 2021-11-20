<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Arr;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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
   * @OA\Get(
   *     path="/product",
   *     @OA\Response(response="201", description="Display a the shelf list.")
   * )
   */

  /**
  * @return JsonResponse
  * @author Angélica Nunes
  */
  public function index(): JsonResponse
  {
    $shelf_list = $this->handleRequest();
    return response()->json($shelf_list, 201);
  }

  /**
   * @OA\Get(
   *     path="/product/{item}",
   *     @OA\Response(response="201", description="Display item details.")
   * )
   */

  /**
  * Responds to a GET request into the
  * /product/{item} endpoint with the
  * product classified in this position
  *
  * @return JsonResponse
  * @param Int $item
  * @author Angélica Nunes
  */
  public function show(Int $item): JsonResponse
  {
    if($item < 1 || $item > 12){
      return response()->json(['error'=>'The requested resource does not exist.'], 404);
    }

    $shelf_item = $this->handleRequest($item);
    return response()->json($shelf_item, 201);
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

    if ($item != null) {
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
        'pricesPerSize' => ['hdhfushd' =>['hfsudhf'=>'hdhah', 'hdaushda'=>'hadhuah']],
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
