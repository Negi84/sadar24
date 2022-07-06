<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductTranslation extends Model
{
    protected $fillable = ['product_id','name', 'lang','specification','description','unit','created_at','updated_at'];

    public function product(){
      return $this->belongsTo(Product::class);
    }
}
