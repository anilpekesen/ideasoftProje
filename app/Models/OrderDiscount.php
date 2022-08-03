<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDiscount extends Model
{
    use HasFactory;



    public function CategoryDiscount()
    {
        return $this->hasMany(OrderDiscountCategory::class, 'orderdiscount_id', 'id')->first();
    }




    public function getOrderProductcountSix($producttotal)
    {
        $rule = OrderDiscount::where('buy_qty', '!=', '0')->where('free_product_count', '!=', 0)->where('status', TRUE)->first();

        if($rule->CategoryDiscount()){
            $rule = Product::whereIn('id',$producttotal)->where('category',$rule->CategoryDiscount()->category_id)->first();
            return $rule;

        }
        return false;
    }
}
