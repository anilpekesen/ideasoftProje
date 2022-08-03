<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Repository\Product\ProductInterface;
use App\Traits\ApiResponseInfo;


class ProductController extends Controller
{
    use ApiResponseInfo;

    private ProductInterface $productRepository;

    public function __construct(ProductInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function index()
    {
        $product = $this->productRepository->all();
        return $this->success([
            $product
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {

        $product = $this->productRepository->create($request);

        return $this->success([
            $product
        ], 'Product Saved !');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Product $Product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = $this->productRepository->find($id);

        if (is_null($product)) {
            return $this->error('Error', '404', [
                'Product not found !'
            ]);
        }
        return $this->success([
            $product
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $Product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, $id)
    {
        $product = $this->productRepository->update($request, $id);

        return $this->success([
            $product
        ], 'Product Updated !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Product $Product
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        $product = $this->productRepository->delete($id);
        return $this->success([
            $product
        ], 'Product Deleted !');
    }
}
