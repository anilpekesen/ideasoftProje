<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDiscountCategory extends Model
{
    use HasFactory;


    public function category()
    {
        return $this->belongsTo(Category::class, 'order_discount_categories', 'id');
    }


    public function getTotalDiscount($producttotal)
    {

        $rule = OrderDiscount::where('minimum_amount_discount', '<>', '0.00')->where('minimum_order_amount', '<', $producttotal)->where('status', TRUE)->first();
        if ($rule) {
            return $rule;
        }

    }

    public function getCategoryCountDiscount()
    {

        $rule = OrderDiscount::where('categoty_product_count', '<>', '0')->where('status', TRUE)->first();
        if ($rule) {
            return $rule;
        }

    }



}
