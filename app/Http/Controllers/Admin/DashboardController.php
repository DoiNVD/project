<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dashboard;
use App\Models\Order;
use App\Models\product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // __construct() Thực thi những xử lý có thể chạy ngay từ đầu
    public function __construct()   
    {
        $this->middleware(function ($request, $next){
            session(['module_active'=>'Dashboard']);
            return $next($request);
        });
       
    } 


    public function index(){
        $order_pending = Order::where('status', 1)->get();
        $order_driving = Order::where('status', 2)->get();
        $order_success = Order::where('status', 3)->get();
        $order_cancel = Order::onlyTrashed()->get();
        $orders=Order::orderBy('created_at','desc')->limit(40)->get();
        $total_product_sell=0;
        foreach($orders as $order){
            $total_product_sell+=$order->total_qty;
        }
        $revenue=0;
        $total_product=0;
        foreach(product::all() as $product){
            $total_product+=$product->num;
        }
        foreach($orders as $order){
            $revenue+=$order->total_price;
        }
        return view('admin.dashboard.index', compact('orders', 'order_success', 'order_driving', 'order_pending', 'order_cancel','revenue','total_product','total_product_sell'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Dashboard  $dashboard
     * @return \Illuminate\Http\Response
     */
    public function show(Dashboard $dashboard)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Dashboard  $dashboard
     * @return \Illuminate\Http\Response
     */
    public function edit(Dashboard $dashboard)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Dashboard  $dashboard
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Dashboard $dashboard)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Dashboard  $dashboard
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dashboard $dashboard)
    {
        //
    }
}
