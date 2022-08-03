<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;





    public function getCategoryProductCount($producttotal)
    {

        $rule = $this->whereIn('id',$producttotal)->groupBy('category')->count();
        return $rule;


    }
    public function getCategoryProductMinPrice($producttotal)
    {
        $rule = $this->whereIn('id',$producttotal)->groupBy('category')->count();
        if ($rule>=2) {
            $rule = $this->whereIn('id',$producttotal)->groupBy('category')->min('price');

            return $rule;
        }
    }
}
