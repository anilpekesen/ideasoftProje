<?php


namespace App\Repository\OrderDiscount;


use App\Abstracts\OrderRequest;
use App\Models\Order;
use App\Models\OrderDiscount;
use App\Models\OrderDiscountCategory;
use App\Models\Product;
use App\Traits\HasErrors;

class OrderDiscountRepository implements OrderDiscountInterface
{
    use HasErrors;

    protected $model;

    public function __construct(OrderDiscount $orderdiscount, Order $orders, Product $product, OrderDiscountCategory $orderdiscountCategory)
    {
        $this->model = $orderdiscount;
        $this->orders = $orders;
        $this->product = $product;
        $this->orderdiscountCategory = $orderdiscountCategory;
    }


    public function all()
    {
        $discountresponse = [];
        $orderdiscounts = $this->model->get();
        $orderslist = $this->orders->get();
        $data = [];

        foreach ($orderslist as $key => $order) {
            $totalDiscount = $discountedTotal = $discountAmount = 0;

            $subtotal = $order->total;

            $data[$key] = ['orderId' => $order->id,];
            $totalorderdiscount = $this->orderdiscountCategory->getTotalDiscount($order->total);

            if ($totalorderdiscount) {
                $totalDiscount += $order->total * $totalorderdiscount->minimum_amount_discount / 100;
                $subtotal = $order->total - ($order->total * $totalorderdiscount->minimum_amount_discount / 100);
                $discountAmount += $order->total * $totalorderdiscount->minimum_amount_discount / 100;
                $data[$key]['discounts'] = [
                    'discountReason' => $totalorderdiscount->capain_code,
                    'discountAmount' => $order->total * $totalorderdiscount->minimum_amount_discount / 100,
                    'subtotal' => $subtotal,

                ];

            }
            $orderproductscat = [];
            $orderproductcountsix = [];

            foreach (array(json_decode($order->items)) as $products) {


                if(!is_array(json_decode($products)) && json_decode($products)->quantity >= 6){
                    array_push($orderproductcountsix, json_decode($products)->productId);
                }
                if (is_array(json_decode($products))) {
                    foreach (json_decode($products) as $key2 => $product) {
                        if($product->quantity>=6){
                            array_push($orderproductcountsix, $product->productId);
                        }
                    }

                    if ($this->product->getCategoryProductCount($orderproductscat) >= 2) {

                        $minprice = $this->product->getCategoryProductMinPrice($orderproductscat);

                        $CategoryCountDiscount = $this->orderdiscountCategory->getCategoryCountDiscount();

                        if ($CategoryCountDiscount) {

                            $totalDiscount += $minprice * $CategoryCountDiscount->cheapest_product_discount / 100;
                            $discountAmount += $minprice * $CategoryCountDiscount->cheapest_product_discount / 100;
                            $subtotal -= $order->total - ($minprice * $CategoryCountDiscount->cheapest_product_discount / 100);


                            $data[$key]['discounts'][] = [
                                'discountReason' => $CategoryCountDiscount->capain_code,
                                'discountAmount' => $minprice * $CategoryCountDiscount->cheapest_product_discount / 100,
                                'subtotal' => $subtotal,

                            ];

                        }

                    }
                }
                if ($this->model->getOrderProductcountSix($orderproductcountsix)) {
                    $price=$this->model->getOrderProductcountSix($orderproductcountsix)->price;
                        $totalDiscount += $price;
                        $discountAmount += $price;
                        $subtotal -=  $price;

                        $data[$key]['discounts'][] = [
                            'discountReason' => 'BUY_5_GET_1',
                            'discountAmount' => $price,
                            'subtotal' => $subtotal,

                        ];

                }


            }

            $data[$key] += [
                'totalDiscount' => $discountAmount,
                'discountedTotal' => $order->total- $discountAmount,

            ];


        }

        return ($data);

    }


}
