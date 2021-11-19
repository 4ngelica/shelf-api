<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shelf extends Model
{
  use HasFactory;

  /**
  * Returns a array with the header params.
  *
  * @return array
  * @author Angélica Nunes
  */
  public function header(): array
  {
    return [
      'Accept' => 'application/json',
      'Content-Type' => 'application/json',
    ];
  }

  /**
  * Returns an array with the query params.
  *
  * @return array
  * @author Angélica Nunes
  */
  public function queryParams(): array
  {
    return [
      '_from'=>'0',
      '_to' => '11',
      'fq'=>'C:/1000001/'
    ];
  }

  /**
  * Returns a string with the Vtex search API endpoint.
  *
  * @return array
  * @author Angélica Nunes
  */
  public function url(): string
  {
    $url = 'http://epocacosmeticos.vtexcommercestable.com.br/api/catalog_system/pub/products/search/?O=OrderByTopSaleDESC';
    return $url;
  }
}
