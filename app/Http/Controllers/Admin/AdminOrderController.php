<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Detail_order;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'order']);
            return $next($request);
        });
    }
    public function list()
    {
        $num_per_page = 5;
        $search = isset($_GET['search']) ? $_GET['search'] : 'no_search';
        $status = !empty($_GET['status']) ? $_GET['status'] : '';
        $list_act = array();
        if ($status == 'pending') {
            $title = "DANH SÁCH ĐƠN HÀNG ĐANG XỬ LÍ";
            if ($search == 'no_search') {
                $orders = Order::where('status', '1')->orderBy('created_at', 'desc')->paginate($num_per_page);
            } else {
                $customers = Customer::where('name', 'like', "%{$search}%")->get();
                $listCustomerId = array();
                foreach ($customers as $customer) {
                    $listCustomerId[] = $customer->id;
                }
                $orders = Order::where('status', '1')->whereIn('customer_id', $listCustomerId)->paginate($num_per_page);
            }
            $list_act = array(
                'driving' => 'Đang vận chuyển',
                'success' => 'Thành công',
                'cancel' => 'Hủy đơn'
            );
        } else if ($status == 'driving') {
            $title = "DANH SÁCH ĐƠN HÀNG ĐANG VẬN CHUYỂN";
            if ($search == 'no_search') {
                $orders = Order::where('status', '2')->orderBy('created_at', 'desc')->paginate($num_per_page);
            } else {
                $customers = Customer::where('name', 'like', "%{$search}%")->get();
                $listCustomerId = array();
                foreach ($customers as $customer) {
                    $listCustomerId[] = $customer->id;
                }
                $orders = Order::where('status', '2')->whereIn('customer_id', $listCustomerId)->paginate($num_per_page);
            }
            $list_act = array(
                'pending' => 'Đang xử lí',
                'success' => 'Thành công',
                'cancel' => 'Hủy đơn'
            );
        } else if ($status == 'success') {
            $title = "DANH SÁCH ĐƠN HÀNG THÀNH CÔNG";
            if ($search == 'no_search') {
                $orders = Order::where('status', '3')->orderBy('created_at', 'desc')->paginate($num_per_page);
            } else {
                $customers = Customer::where('name', 'like', "%{$search}%")->get();
                $listCustomerId = array();
                foreach ($customers as $customer) {
                    $listCustomerId[] = $customer->id;
                }
                $orders = Order::where('status', '3')->whereIn('customer_id', $listCustomerId)->paginate($num_per_page);
            }
            $list_act = array(
                'pending' => 'Đang xử lí',
                'driving' => 'Đang vận chuyển',
                'cancel' => 'Hủy đơn',
                'delete_pernament' => 'Xóa vĩnh viễn'
            );
        } else if ($status == 'cancel') {
            $title = "DANH SÁCH ĐƠN HÀNG ĐÃ HỦY";
            $list_act = array(
                'pending' => 'Đang xử lí',
                'driving' => 'Đang vận chuyển',
                'success' => 'Thành công',
                'delete_pernament' => 'Xóa vĩnh viễn'
            );
            if ($search == 'no_search') {
                $orders = Order::onlyTrashed()->orderBy('created_at', 'desc')->paginate($num_per_page);
            } else {
                $customers = Customer::where('name', 'like', "%{$search}%")->get();
                $listCustomerId = array();
                foreach ($customers as $customer) {
                    $listCustomerId[] = $customer->id;
                }
                $orders = Order::onlyTrashed()->whereIn('customer_id', $listCustomerId)->paginate($num_per_page);
             
            }
        } else {
            $title = "DANH SÁCH ĐƠN HÀNG";
            $list_act = array(
                'pending' => 'Đang xử lí',
                'driving' => 'Đang vận chuyển',
                'success' => 'Thành công',
                'cancel' => 'Hủy đơn'
            );
            if ($search == 'no_search') {
                $orders = Order::withTrashed()->orderBy('created_at', 'desc')->paginate($num_per_page);
            } else {
                $customers = Customer::where('name', 'like', "%{$search}%")->get();
                $listCustomerId = array();
                foreach ($customers as $customer) {
                    $listCustomerId[] = $customer->id;
                }
                $orders = Order::withTrashed()->whereIn('customer_id', $listCustomerId)->paginate($num_per_page);
            }
        }
        $order_pending = Order::where('status', 1)->get();
        $order_driving = Order::where('status', 2)->get();
        $order_success = Order::where('status', 3)->get();
        $order_cancel = Order::onlyTrashed()->get();
        $order_all = Order::withTrashed()->get();
        return view('admin.order.list', compact('orders', 'num_per_page', 'order_success', 'order_driving', 'order_pending', 'order_cancel', 'order_all', 'list_act', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function detail($order_code)
    {
        $order = Order::withTrashed()->where('order_code', $order_code)->first();
        $detail_order = Detail_order::where('order_code', $order_code)->get();
        return view('admin.order.detail', compact('order', 'detail_order'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function action(Request $request)
    {
        $list_check = $request->input('list_check');
        if (!empty($list_check)) {
            $act = $request->input('act');
            if ($act == "pending") {
                Order::onlyTrashed()->whereIn('id', $list_check)->restore();
                Order::whereIn('id', $list_check)->update(
                    ['status' => 1]
                );
                return redirect('admin/order/list')->with('status', 'Bạn đã thay đổi trạng thái đơn hàng thành công');
            } else if ($act == "driving") {
                Order::onlyTrashed()->whereIn('id', $list_check)->restore();
                Order::whereIn('id', $list_check)->update(
                    ['status' => 2]
                );
                return redirect('admin/order/list')->with('status', 'Bạn đã thay đổi trạng thái đơn hàng thành công');
            } else if ($act == "success") {
                Order::onlyTrashed()->whereIn('id', $list_check)->restore();
                Order::whereIn('id', $list_check)->update(
                    ['status' => 3]
                );
                return redirect('admin/order/list')->with('status', 'Bạn đã thay đổi trạng thái đơn hàng thành công');
            } else if ($act == "cancel") {
                Order::whereIn('id', $list_check)->update(
                    ['status' => 4]
                );
                Order::destroy($list_check);
                return redirect('admin/order/list')->with('status', 'Bạn đã chuyển vào hủy đơn thành công');
            } else if ($act = "delete_pernament") {
                Order::onlyTrashed()->whereIn('id', $list_check)->forceDelete();
                return redirect('admin/order/list?status=cancel')->with('status', 'Bạn đã xóa vĩnh viễn đơn hàng thành công');
            } else {
                return back()->with('status', 'Bạn cần chọn hành động để thực hiện');
            }
        } else {
            return redirect('admin/order/list')->with('status', 'Bạn cần chọn phần tử để thực hiện');
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $order_code)
    {
        $order = Order::withTrashed()->where('order_code', $order_code)->first();
        $status = $request->status;
        if ($status == 0) {
            return redirect()->back()->with('status', 'Bạn cần chọn trạng thái cần cập nhật');
        }
        Order::onlyTrashed()->where('order_code', $order_code)->restore();
        $order->update([
            'status' => $status
        ]);
        if ($status == 4) {
            $order->delete();
            return redirect('admin/order/list')->with('status', 'Cập nhật trạng thái đơn hàng thành công');
        }
        return redirect('admin/order/list')->with('status', 'Cập nhật trạng thái đơn hàng thành công');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($order_code)
    {
        $product = Order::onlyTrashed()->get();
    //    show_array(  $product);
        if ($product->contains('order_code', $order_code)) {
            foreach($product as $item){
                $customer= $item->customer_id;
            }
            $product= Order::onlyTrashed()->where('order_code', $order_code)->forceDelete();
            Detail_order::where('order_code', $order_code)->forceDelete();
            Customer::where('id', $customer)->forceDelete();
            return redirect('admin/order/list?status=trash')->with('status', 'Bạn đã xóa vĩnh viễn đơn hàng thành công');
        } else {
            $product = Order::where('order_code', $order_code)->first();
            $product->update([
                'status' => 4
            ]);
         
            $product->delete();
            // Detail_order::where('order_code', $order_code)->delete();
            // Customer::where('id', $product->customer_id)->delete();
           
          
            return redirect('admin/order/list')->with('status', 'Bạn đã xóa đơn hàng thành công');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
