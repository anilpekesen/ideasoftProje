<?php


namespace App\Repository\Category;


use App\Models\Category;

class CategoryRepository implements CategoryInterface
{
    protected $model;

    public function __construct(Category $category)
    {
        $this->model = $category;
    }

    public function all()
    {
        $category =  $this->model->all();
        return $category;
    }

    public function create(object $data)
    {
        $this->model->name = $data->name;
        $this->model->save();
        return $this->model;
    }

    public function update(object $data, $id)
    {
        $category = $this->model->find($id);
        if($category) {
            $category->name = $data->name;
            $category->save();
            return $category;
        }else{
            return false;

        }
    }

    public function delete($id)
    {
        $category = $this->model->find($id);
        $category->delete();
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

}
