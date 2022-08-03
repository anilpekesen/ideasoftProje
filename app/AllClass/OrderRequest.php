<?php


namespace App\AllClass;


use App\Models\Product;
use App\Repository\Product\ProductInterface;
use App\Service\Translator;
use App\Traits\HasErrors;

abstract class OrderRequest
{
    use HasErrors;


    protected $productRepository;
    public function __construct(ProductInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function stockControl($items):void
    {

        foreach((array)$items as $product)
        {
            foreach(json_decode($product)as $products)
            {
                $model =  Product::find($products->productId);
                if(empty($model) || $model->stock < $products->quantity)
                {
                    $this->addError('Out of stock');
                    continue;
                }
            }

        }
    }

    public function productPriceControl($items,$total):void
    {
        $totalPrice = 0;
        foreach((array)$items as $product)
        {

            foreach(json_decode($product)as $products)
            {
                $model =  Product::find($products->productId);
                if(empty($model) || $model['price'] != floatval($products->unitPrice))
                {
                    $this->addErrors(['error' => 'Prices do not match']);
                    continue;
                }

                $totalPrice += floatval($products->unitPrice*$products->quantity);

            }
            if($totalPrice != $total)
            {

                $this->addErrors(['error' => 'Prices do not match']);
                continue;
            }

        }
    }

}
