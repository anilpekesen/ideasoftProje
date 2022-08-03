<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Repository\Category\CategoryInterface;
use App\Traits\ApiResponseInfo;

use Validator;


class CategoryController extends Controller
{
    use ApiResponseInfo;

    private CategoryInterface $categoryRepository;

    public function __construct(CategoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function index()
    {
        $category = $this->categoryRepository->all();
        return $this->success([
            $category
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $category = $this->categoryRepository->create($request);

        return $this->success([
            $category,
        ],'Category Created !');

    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Category $category
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = $this->categoryRepository->find($id);

        if (is_null($category)) {
            return $this->error('Error','404',[
                'Category not found !'
            ]);
        }
        return $this->success([
            $category,
        ],'Category successfully shown !');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Category $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, $id)
    {
        $category = $this->categoryRepository->update($request, $id);

        if($category){
            return $this->success([
                $category
            ], 'Category Successfully Updated !');
        }else{
            return $this->error('Something went wrong');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Category $category
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        $category = $this->categoryRepository->delete($id);
        return $this->success([
            $category
        ], 'Category Deleted.');
    }
}
