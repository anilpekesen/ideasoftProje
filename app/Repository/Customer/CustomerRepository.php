<?php


namespace App\Repository\Customer;


use App\Models\Customer;

class CustomerRepository implements CustomerInterface
{
    protected $model;

    public function __construct(Customer $customer)
    {
        $this->model = $customer;
    }


    public function all()
    {
        $customer =  $this->model->all();
        return $customer;
    }

    public function create(object $data)
    {
        $this->model->name = $data->name;
        $this->model->since = $data->since;
        $this->model->revenue = $data->revenue;
        $this->model->save();
        return $this->model;
    }

    public function update(object $data, $id)
    {
        $customer = $this->model->find($id);
        $this->model->name = $data->name;
        $this->model->since = $data->since;
        $this->model->revenue = $data->revenue;
        $customer->save();
        return $customer;
    }

    public function delete($id)
    {
        $customer = $this->model->find($id);
        $customer->delete();
    }

    public function find($id)
    {
        return $this->model->find($id);
    }
}
