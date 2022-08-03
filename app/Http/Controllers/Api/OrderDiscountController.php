<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repository\OrderDiscount\OrderDiscountInterface;
use Illuminate\Http\Request;

class OrderDiscountController extends Controller
{
    //

    public function __construct(OrderDiscountInterface $orderDiscountRepository)
    {
        $this->orderDiscountRepository = $orderDiscountRepository;
    }

    public function index()
    {
        $order= $this->orderDiscountRepository->all();
        return $order;
    }
}
