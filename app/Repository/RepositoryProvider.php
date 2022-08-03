<?php

namespace App\Repository;

use Illuminate\Support\ServiceProvider;

class RepositoryProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->bind(
            'App\Repository\Category\CategoryInterface',
            'App\Repository\Category\CategoryRepository'
        );
        $this->app->bind(
            'App\Repository\Product\ProductInterface',
            'App\Repository\Product\ProductRepository'
        );
        $this->app->bind(
            'App\Repository\Customer\CustomerInterface',
            'App\Repository\Customer\CustomerRepository'
        );
        $this->app->bind(
            'App\Repository\Order\OrderInterface',
            'App\Repository\Order\OrderRepository'
        );
        $this->app->bind(
            'App\Repository\OrderDiscount\OrderDiscountInterface',
            'App\Repository\OrderDiscount\OrderDiscountRepository'
        );

    }

}
