<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Collection;
use App\Http\Requests\OrderRequest;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Address;
use App\Models\Ward;
use App\Models\District;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function __construct(Order $order, OrderDetail $orderDetail, Product $product)
    {
        $this->product = $product;
        $this->order = $order;
        $this->middleware('auth:admin');
        $this->orderDetail = $orderDetail;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $orders = $this->order->notDone()
            ->status($request)->sortId($request)->active()
            ->sortTotal($request)->sortDate($request)->sortPaid($request);
        $orders_count = $orders->count();
        $view = $request->has('view') ? $request->view : 10;
        $orders = $orders->paginate($view);

        // filter
        $sort_id = $request->sort_id;
        $status = $request->status;
        $sort_total = $request->sort_total;
        $sort_date = $request->sort_date;
        $sort_paid = $request->sort_paid;
        // user
        $user = Auth::guard('admin')->user();
        return view('pages.admin.order.index', [
            // order
            'orders' => $orders,
            'orders_count' => $orders_count,
            'view' => $view,

            // filter
            'sort_id' => $sort_id,
            'sort_total' => $sort_total,
            'sort_date' => $sort_date,
            'status' => $status,
            'sort_paid' => $sort_paid,
            // current user
            'current_user' => $user,

        ]);
    }

    /**
     * Verify an item.
     *
     * @return \Illuminate\Http\Response
     */
    public function verify($id, $verified)
    {
        //
        $order = $this->order->find($id);
        $verify = $order->update([
            'verified' => $verified,
        ]);
        if ($verified == 0) {
            foreach ($order->orderDetails as $detail) {
                $product = null;
                $product = $this->product->find($detail->product_id);
                $product = $product->update(['remaining' => $product->remaining + $detail->quantity]);
            }
            return back()->with('success', 'Hóa đơn #' . $id . ' đã được bật .');
        } else {
            foreach ($order->orderDetails as $detail) {
                $product = null;
                $product = $this->product->find($detail->product_id);
                $product = $product->update(['remaining' => $product->remaining - $detail->quantity]);
            }
            return back()->with('success', 'Hóa đơn #' . $id . ' đã được tắt.');
        }
    }

    public function comfirm($id, $confirmed)
    {
        //
        $order = $this->order->find($id);
        if ($confirmed == 0) {
            $confirmation = $order->update([
                'delivered_at' => null,
                'done' => $confirmed,
            ]);
            return back()->withSuccess('Hóa đơn #' . $id . ' chưa được xác nhận và hoàn tất');
        } else {
            if (!$order->done)
                return back()->withError('Hóa đơn  #' . $id . ' chưa được thanh toán, không thể xác nhận');
            else
                $confirmation = $order->update([
                    'delivered_at' => date("Y-m-d H:i:s"),
                    'done' => $confirmed,
                ]);
            return back()->withSuccess('Hóa đơn  #' . $id . ' đã được xác nhận và hoàn tất');
        }
    }

    public function pay($id, $paid)
    {
        //
        $order = $this->order->find($id);
        $confirmation = $order->update([
            'paid' => $paid,
        ]);
        if ($paid == 0)
            return back()->withSuccess('Hóa đơn #' . $id . ' chưa được thanh toán');
        else
            return back()->withSuccess('Hóa đơn  #' . $id . ' đã được thanh toán');
    }

    public function history(Request $request)
    {
        $orders =  $this->order->done()
            ->status($request)->sortId($request)
            ->sortTotal($request)->sortDate($request)->sortPaid($request);
        $orders_count = $orders->count();
        $view = $request->has('view') ? $request->view : 10;

        // filter
        $sort_id = $request->sort_id;
        $status = $request->status;
        $sort_total = $request->sort_total;
        $sort_date = $request->sort_date;
        $sort_paid = $request->sort_paid;
        // user
        $user = Auth::guard('admin')->user();
        return view('pages.admin.order.history', [
            // order
            'orders' => $orders,
            'orders_count' => $orders_count,
            'view' => $view,

            // filter
            'sort_id' => $sort_id,
            'sort_total' => $sort_total,
            'sort_date' => $sort_date,
            'status' => $status,
            'sort_paid' => $sort_paid,
            'current_user' => $user,

        ]);
    }

    public function cancel(Request $request)
    {
        $orders = $this->order
            ->status($request)->sortId($request)->inactive()
            ->sortTotal($request)->sortDate($request)->sortPaid($request);
        $orders_count = $orders->count();
        $view = $request->has('view') ? $request->view : 10;
        $orders = $orders->paginate($view);

        // filter
        $sort_id = $request->sort_id;
        $status = $request->status;
        $sort_total = $request->sort_total;
        $sort_date = $request->sort_date;
        $sort_paid = $request->sort_paid;
        // user
        $user = Auth::guard('admin')->user();
        return view('pages.admin.order.cancel', [
            // order
            'orders' => $orders,
            'orders_count' => $orders_count,
            'view' => $view,

            // filter
            'sort_id' => $sort_id,
            'sort_total' => $sort_total,
            'sort_date' => $sort_date,
            'status' => $status,
            'sort_paid' => $sort_paid,
            'current_user' => $user,

        ]);
    }

    public function edit($id)
    {
        $order = $this->order->find($id);
        // user
        $user = Auth::guard('admin')->user();
        return view('pages.admin.order.detail', [
            // order
            'order' => $order,
            'current_user' => $user,
        ]);
    }

    public function update(OrderRequest $request, $id)
    {
        $order = $this->order->find($id);
        $result = $order->update(['status' => $request->status, 'paid' => $request->payment]);
        return $result ? back()->withSuccess('Đơn hàng #' . $id . ' đã được cập nhật') : back()->withError('Xảy ra lỗi trong quá trình cập nhật đơn hàng #' . $id);
    }

    public function delete($id)
    {
        $order = $this->order->find($id);
        if ($order->done == 0) {
            return back()->with('error', 'Đơn hàng #' . $order->id . ' chưa được hoàn thiện.');
        } else {
            if ($order->paid == 1) {
                return back()->with('error', 'Đơn hàng #' . $order->id . ' đã được thanh toán.');
            } else {
                $result = $order->delete();
                return $result ? back()->withSuccess('Đơn hàng #' . $id . ' đã được xóa') : back()->withError('Lỗi xảy ra khi xóa đơn hang #' . $id);
            }
        }
    }
    public function recycle(Request $request)
    {
        $orders = $this->order->onlyTrashed()
            ->status($request)->sortId($request)
            ->sortTotal($request)->sortDate($request)->sortPaid($request);
        $orders_count = $orders->count();
        $view = $request->has('view') ? $request->view : 10;
        $orders = $orders->paginate($view);
        // filter
        $sort_id = $request->sort_id;
        $status = $request->status;
        $sort_total = $request->sort_total;
        $sort_date = $request->sort_date;
        $sort_paid = $request->sort_paid;
        // user
        $user = Auth::guard('admin')->user();
        return view('pages.admin.order.recycle', [
            // order
            'orders' => $orders,
            'order_count' => $orders_count,
            'view' => $view,

            // filter
            'sort_id' => $sort_id,
            'sort_total' => $sort_total,
            'sort_date' => $sort_date,
            'status' => $status,
            'sort_paid' => $sort_paid,
            // current user
            'current_user' => $user,

        ]);
    }
    public function restore($id)
    {
        $result = $this->order->onlyTrashed()->find($id)->restore();
        return back()->with('success', 'Đơn hàng #' . $id . ' đã được khôi phục.');
    }

    public function destroy($id)
    {
        $order = $this->order->find($id);
        if ($order->done == 0) {
            return back()->with('error', 'Đơn hàng #' . $order->id . ' chưa được hoàn thiện.');
        } else {
            if ($order->paid == 1) {
                return back()->with('error', 'Đơn hàng #' . $order->id . ' đã được thanh toán.');
            } else {
                $result = $order->forceDelete();
                return $result ? back()->withSuccess('Đơn hàng #' . $id . ' đã được xóa vĩnh viễn') : back()->withError('Lỗi xảy ra khi xóa vĩnh viễn đơn hang #' . $id);
            }
        }
    }

    public function bulk_action(Request $request)
    {
        if ($request->has('bulk_action')) {
            if ($request->has('order_id_list')) {
                $message = null;
                $errors = null;
                switch ($request->bulk_action) {
                    case 0: // deactivate
                        $message = 'Đơn hàng ';
                        foreach ($request->order_id_list as $order_id) {
                            $order = $this->order->find($order_id);
                            $verify = $order->update([
                                'verified' => 0,
                            ]);
                            if ($verify) {
                                $message .= ' #' . $order->id . ', ';
                            } else {
                                $errors[] = 'Lỗi xảy ra khi tắt Đơn hàng #' . $order->id . '.';
                            }
                        }
                        $message .= 'đã được tắt.';
                        break;
                    case 1: // activate
                        $message = 'Đơn hàng ';
                        foreach ($request->order_id_list as $order_id) {
                            $order = $this->order->find($order_id);
                            $verify = $order->update([
                                'verified' => 1,
                            ]);
                            if ($verify) {
                                $message .= ' #' . $order->id . ', ';
                            } else {
                                $errors[] = 'Lỗi xảy ra khi bật Đơn hàng #' . $order->id . '.';
                            }
                        }
                        $message .= 'đã được bật.';
                        break;
                    case 2: // undone
                        $message = 'Đơn hàng ';
                        foreach ($request->order_id_list as $order_id) {
                            $order = $this->order->find($order_id);
                            $verify = $order->update([
                                'done' => 0,
                            ]);
                            if ($verify) {
                                $message .= ' #' . $order->id . ', ';
                            } else {
                                $errors[] = 'Lỗi xảy ra khi đánh dấu Đơn hàng #' . $order->id . ' là chưa hoàn thiện.';
                            }
                        }
                        $message .= 'đã được đánh dấu là chưa hoàn thiện.';
                        break;
                    case 3: // done
                        $message = 'Đơn hàng ';
                        foreach ($request->order_id_list as $order_id) {
                            $order = $this->order->find($order_id);
                            $verify = $order->update([
                                'done' => 1,
                            ]);
                            if ($verify) {
                                $message .= ' #' . $order->id . ', ';
                            } else {
                                $errors[] = 'Lỗi xảy ra khi hoàn thiện Đơn hàng #' . $order->id . '.';
                            }
                        }
                        $message .= 'đã được đánh dấu là hoàn thiện.';
                        break;
                    case 4: // paid
                        $message = 'Đơn hàng ';
                        foreach ($request->order_id_list as $order_id) {
                            $order = $this->order->find($order_id);
                            $verify = $order->update([
                                'paid' => 1,
                            ]);
                            if ($verify) {
                                $message .= ' #' . $order->id . ', ';
                            } else {
                                $errors[] = 'Lỗi xảy ra khi đánh dấu Đơn hàng #' . $order->id . ' là đã thanh toán.';
                            }
                        }
                        $message .= 'đã được thanh toán.';
                        break;
                    case 5: // un paid
                        $message = 'Đơn hàng ';
                        foreach ($request->order_id_list as $order_id) {
                            $order = $this->order->find($order_id);
                            $verify = $order->update([
                                'paid' => 0,
                            ]);
                            if ($verify) {
                                $message .= ' #' . $order->id . ', ';
                            } else {
                                $errors[] = 'Lỗi xảy ra khi đánh dấu Đơn hàng #' . $order->id . ' là chưa thanh toán.';
                            }
                        }
                        $message .= 'đã được đánh dấu là chưa thanh toán.';
                        break;
                    case 6: // remove
                        $message = 'Đơn hàng';
                        foreach ($request->order_id_list as $order_id) {
                            $order = null;
                            $order = $this->order->find($order_id);
                            $result = $order->delete();
                            if ($result) {
                                $message .= ' #' . $order->id . ', ';
                            } else {
                                $errors[] = 'Lỗi xảy ra khi loại bỏ Đơn hàng #' . $order->id . '.';
                            }
                        }
                        $message .= 'đã được loại bỏ.';
                        break;
                    case 7: // restore
                        $message = 'Đơn hàng';
                        foreach ($request->order_id_list as $order_id) {
                            $order = null;
                            $order = $this->order->onlyTrashed()->find($order_id);
                            $result = $order->restore();
                            if ($result) {
                                $message .= ' #' . $order->id . ', ';
                            } else {
                                $errors[] = 'Lỗi xảy ra khi khôi phục Đơn hàng #' . $order->id . '.';
                            }
                        }
                        $message .= 'đã được khôi phục.';
                        break;
                    case 8: // delete
                        $message = 'Đơn hàng';
                        foreach ($request->order_id_list as $order_id) {
                            $order = null;
                            $order = $this->order->onlyTrashed()->find($order_id);
                            $result = $order->forceDelete();
                            if ($result) {
                                $message .= ' #' . $order->id . ', ';
                            } else {
                                $errors[] = 'Lỗi xảy ra khi xóa vĩnh viễn Đơn hàng #' . $order->id . '.';
                            }
                        }
                        $message .= 'đã được xóa vĩnh viễn.';
                        break;
                }
                if ($errors != null) {
                    return back()->withSuccess($message)->withErrors($errors);
                } else {
                    return back()->withSuccess($message);
                }
            } else {
                return back()->withError('Hãy chọn ít nhất 1 Đơn hàng để thực hiện thao tác!');
            }
        } else {
            return back()->withError('Hãy chọn 1 thao tác cụ thể!');
        }
    }
}
