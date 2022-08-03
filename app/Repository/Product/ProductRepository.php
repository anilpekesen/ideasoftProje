<?php


namespace App\Repository\Product;

use App\Models\Product;

class ProductRepository implements ProductInterface
{
    protected $model;

    public function __construct(Product $product)
    {
        $this->model = $product;
    }

    public function all()
    {
        $product =  $this->model->all();
        return $product;
    }

    public function create(object $data)
    {
        $this->model->name = $data->name;
        $this->model->category = $data->category;
        $this->model->price = $data->price;
        $this->model->stock = $data->stock;
        $this->model->save();
        return $this->model;
    }

    public function update(object $data, $id)
    {
        $product = $this->model->find($id);
        $product->name = $data->name;
        $product->category = $data->category;
        $product->price = $data->price;
        $product->stock = $data->stock;
        $product->save();
        return $product;
    }

    public function delete($id)
    {
        $product = $this->model->find($id);
        $product->delete();
    }

    public function find($id)
    {
        return $this->model->find($id);
    }
}
