<?php


namespace App\Repository\Order;


use App\AllClass\OrderRequest;
use App\Models\Order;
use App\Traits\HasErrors;

class OrderRepository extends OrderRequest implements OrderInterface
{
    use HasErrors;

    protected $model;

    public function __construct(Order $order)
    {
        $this->model = $order;
    }


    public function all()
    {
        $orders = $this->model->all();
        return $orders;
    }

    public function create(object $data)
    {
        $this->stockControl($data->items);
        if ($this->hasErrors()) {
            return $this;
        }
        $this->productPriceControl($data->items, $data->total);
        if ($this->hasErrors()) {
            return $this->getErrors();
        }

        $this->model->customerId = $data->customerId;
        $this->model->total = $data->total;
        $this->model->items = json_encode($data->items);
        $this->model->save();
    }

    public function update(object $data, $id)
    {
        $this->stockControl($data->items);
        if ($this->hasErrors()) {
            return $this->getErrors();
        }
        $this->productPriceControl($data->items, $data->total);
        if ($this->hasErrors()) {
            return $this->getErrors();
        }
        $order = $this->model->find($id);
        $order->customerId = $data->customerId;
        $order->total = $data->total;
        $order->items = json_encode($data->items);
        $order->save();
    }

    public function delete($id)
    {
        $order = $this->model->find($id);
        $order->delete();
    }

    public function find($id)
    {
        return $this->model->find($id);
    }
}
