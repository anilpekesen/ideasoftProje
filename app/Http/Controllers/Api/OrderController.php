<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Repository\Order\OrderInterface;
use App\Traits\ApiResponseInfo;

class OrderController extends Controller
{
    use ApiResponseInfo;

    private OrderInterface $orderRepository;

    public function __construct(OrderInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function index()
    {
        $order = $this->orderRepository->all();
        return $this->success([
            $order
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrderRequest $request)
    {
        $order = $this->orderRepository->create($request);

        if ($this->orderRepository->hasErrors()) {
            return $this->error('Error','404',[
                $this->orderRepository->getErrors()
            ]);
        }

        return $this->success([
            $order
        ], 'Order Saved !');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Order $Order
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = $this->orderRepository->find($id);

        if (is_null($order)) {
            return $this->error('Error','200',[
                'Order Not found !'
            ]);
        }
        return $this->success([
            $order
        ], 'Order Showing !');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Order $Order
     * @return \Illuminate\Http\Response
     */
    public function update(OrderRequest $request, $id)
    {

        $order = $this->orderRepository->update($request);

        if ($this->orderRepository->hasErrors()) {
            return $this->error('Error',404,[
                $this->orderRepository->getErrors()
            ]);
        }

        return $this->success('Success',[
            $order
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Order $Order
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        $order = $this->orderRepository->delete($id);
        return $this->success('Success',[
            $order
        ],200);
    }
}
