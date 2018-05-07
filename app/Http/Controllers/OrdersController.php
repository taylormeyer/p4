<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use App\Http\Requests\OrderRequest;
use App\Order;
use App\MenuItem;
use DB;

class OrdersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("orders.index");
    }

    public function getDatatable(Request $request)
    {
        $user_id = auth()->id();
        $result = Order::select('orders.*', 'orders.id AS formated_order_id')
                    ->join("order_user", function($join) use($user_id)  {
                        $join->on("order_user.order_id", "=", "orders.id");
                        $join->on("order_user.user_id", "=", DB::raw("'".$user_id."'"));
                    });
        return datatables()->of($result)->addIndexColumn()->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $menuItems = MenuItem::all();
        return view('orders.create', compact("menuItems"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrderRequest $request)
    {
        try {
            $orderInput = $request->only(['description', 'order_time']);
            $orderQty = $request->get("quantity", []);
            $insertOrderItems = [];
            foreach ($orderQty as $menuItemId => $value) {
                if(!empty($value)) {
                    $insertOrderItems[] = [
                                                "menu_item_id" => $menuItemId,
                                                "quantity" => $value,
                                            ];
                }
            }

            if(count($insertOrderItems)) {
                $order = Order::create($orderInput);
                if ($order) {
                    $data = $order->orderUser()->create(["user_id" => auth()->id()]);
                    $order->orderItems()->createMany($insertOrderItems);

                    return redirect("orders")->with('success', 'Order Added Successfully');
                }
            }
            else {
                return redirect()->back()->with("error", "Please add quantity for your order")->withInput();
            }

            return redirect("orders")->with('error', 'Sorry, Something went wrong please try again');
        } catch (\Exception $e) {
            return redirect("orders")->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Logos  $logos
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::select("*", 'id AS formated_order_id')->find($id);
        if($order) {
            if ( $order->orderUser->user_id == auth()->id() ) {
                $orderItems  = $order->orderItems()->with("menuItem")->get();

                return view('orders.show', compact('order', 'orderItems'));
            }
        }

        return redirect("orders")->with('error', "Sorry, Order not found");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Logos  $logos
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order = Order::find($id);
        if($order) {
            if ( $order->orderUser->user_id == auth()->id() ) {
                $menuItems = MenuItem::all();
                $orderQtyList = $order->orderItems()->pluck("quantity", "menu_item_id")->all();
                
                return view('orders.edit', compact('order', 'menuItems', 'orderQtyList'));
            }
        }

        return redirect("orders")->with('error', "Sorry, Order not found");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Logos  $logos
     * @return \Illuminate\Http\Response
     */
    public function update(OrderRequest $request, $id)
    {
        try {
            $order = Order::find($id);
            if($order) {
                if ( $order->orderUser->user_id == auth()->id() ) {
                    
                    $orderInput = $request->only(['description', 'order_time']);
                    $orderQty = $request->get("quantity", []);
                    $insertOrderItems = [];
                    foreach ($orderQty as $menuItemId => $value) {
                        if(!empty($value)) {
                            $insertOrderItems[] = [
                                                        "menu_item_id" => $menuItemId,
                                                        "quantity" => $value,
                                                    ];
                        }
                    }

                    if(count($insertOrderItems)) {
                        $order->update($orderInput);
                        $order->orderItems()->delete();
                        $order->orderItems()->createMany($insertOrderItems);

                        return redirect("orders")->with('success', 'Order Updated Successfully');
                    }

                }
            }

            return redirect("orders")->with('error', 'Sorry, Something went wrong please try again');
        } catch (\Exception $e) {
            return redirect("orders")->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Logos  $logos
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = array();
        try {
            $order = Order::find($id);
            if ($order) {
                if ( $order->orderUser->user_id == auth()->id() ) {
                    $order->delete();
                    $result['message'] = "Order Deleted Successfully.";
                    $result['code'] = 200;
                }
                else {
                    $result['code'] = 400;
                    $result['message'] = 'You can not delete this order';
                }
            } else {
                $result['code'] = 400;
                $result['message'] = 'Something went wrong';
            }
        } catch (\Exception $e) {
            $result['message'] = $e->getMessage();
            $result['code'] = 400;
        }

        return response()->json($result, $result['code']);
    }
}
