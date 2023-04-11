<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Mail\vsmartMail;
use App\Models\Customer;
use App\Models\Detail_Order;
use App\Models\District;
use App\Models\Order;
use App\Models\product;
use App\Models\Province;
use App\Models\Ward;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return view('client.cart.show');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add($id, $qty = "")
    {
        //    return $qty ;
        $type = $qty;
        if ($qty == "") {
            $qty = 1;
        }
        $product = product::find($id);
        Cart::add([
            'id' => $product->id,
            'name' => $product->name,
            'qty' => $qty,
            'price' => $product->price_real,
            'options' => ['product_thumb' => $product->product_thumb, 'code' => $product->code, 'slug' => $product->slug]
        ]);
        if ($type == "") {

            $total = Cart::total() . "đ";
            return response()->json(['data' => Cart::content(), 'total' => $total], 200);
        } else {
            return redirect(Route('cart.show'));
        }
    }
    public  function buy_now($slug)
    {
        $product = Product::where('slug', $slug)->first();
        Cart::add([
            'id' => $product->id,
            'name' => $product->name,
            'qty' => 1,
            'price' => $product->price_real,
            'options' => ['product_thumb' => $product->product_thumb, 'code' => $product->code, 'slug' => $product->slug]
        ]);
        return redirect(Route('cart.checkout'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function checkout()
    {
        $provinces = Province::all();
        return view('client.cart.checkout', compact('provinces'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function order(Request $request)
    {
        $request->validate([
            'fullname' => 'required|max:255',
            'email' => 'required|email',
            'phone' => 'required',
            'address' => 'required',
            'province' => 'required',
            'district' => 'required',
            'ward' => 'required',
        ], [
            'required' => ':attribute không được để trống',
            'email' => ':attribute không đúng định dạng',
            'min' => ':attribute phải có ít nhất :min kí tự',
            'max' => ':attribute có độ dài tối đa :max kí tự',
        ], [
            'fullname' => 'Họ và tên',
            'email' => 'Email',
            'phone' => 'Số điện thoại',
            'address' => 'Địa chỉ',
            'province' => 'Tỉnh/Thành phố',
            'district' => 'Quận/Huyện',
            'ward' => 'Phường/Xã',
        ]);
        $order_code = "ISM_" . mt_rand(0, 10) . strtoupper(substr(md5(time()), 0, 5));
        $ward = Ward::find($request->ward);
        $district = District::find($request->district);
        $province = Province::find($request->province);
        try {
            DB::beginTransaction();
            $address_customer = $request->address . ', ' . $ward->name . ', ' . $district->name . ', ' . $province->name;
            $customer = Customer::create([
                'name' => $request->fullname,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $address_customer,
                'note' => $request->note
            ]);
            $total_price = 0;
            $total_qty = 0;
            foreach (Cart::Content() as $item) {
                $total_price += $item->price * $item->qty;
                $total_qty += $item->qty;
            }
            $order = Order::create([
                'order_code' => $order_code,
                'customer_id' => $customer->id,
                'status' => 1,
                'total_price' => $total_price,
                'total_qty' => $total_qty
            ]);

            session(['order' => $order]);
            foreach (Cart::content() as $item) {
                \App\Models\Detail_Order::create([
                    'order_code' => $order_code,
                    'product_id' => $item->id,
                    'qty' => $item->qty,
                    'sub_total' => $total_price,
                ]);
            }
            foreach (Cart::content() as $item) {
                DB::table('products')
                    ->where('id', $item->id)
                    ->increment('num_sold', $item->qty);
            }
            // DB::table('products')
            // ->whereIn('id', $order->products->pluck('id'))
            // ->increment('num_sold', $qty);
            $data = [
                'name_store' => "Vsmart",
                'fullname' => $request->fullname,
                'order_code' => $order_code,
                'address' => $address_customer,
                'phone' => $request->phone,
                'time' => $order->created_at->translatedFormat('l j F Y h:m A'),
                'email' => $request->email,
            ];
            Mail::to($request->email)->send(new vsmartMail($data));
            DB::commit();
            return redirect(Route('order.success'));
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('message:' . $e->getMessage() . 'Line' . $e->getLine());;
        }
    }
    public  function order_success()
    {
        $cart = Cart::content();
        $total = Cart::total();
        Cart::destroy();
        $order = session('order');
        $customer = $order->customer;
        return view('client.cart.orderSuccess', compact('order', 'customer', 'cart', 'total'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $rowId)
    {

        Cart::update($rowId, $request->qty);
        $product = Cart::get($rowId);
        $sub_total = $product->total() . "đ";
        $total = Cart::total() . "đ";
        return response()->json(['rowId' => $rowId, 'sub_total' => $sub_total, 'total' => $total], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    function remove($rowId)
    {
        Cart::remove($rowId);
        return response()->json(['data' => 'removed'], 200);
    }

    public function destroy()
    {
        Cart::destroy();
        return response()->json(['data' => 'destroy'], 200);
    }
}
