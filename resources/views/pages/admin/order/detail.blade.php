@extends('admin.layout')
@section('title', 'Order management')
@section('content')
    <!--main content start-->
    <section id="main-content">
        <section class="wrapper">
            <ol class="breadcrumb">
                <li><a href="{{ route('admin.order.index') }}">Order management</a></li>
                <li class="active">Order #{{ $order->id }}</li>
            </ol>
            <section class="panel">
                <div class="panel-heading">
                    Order's information
                    <span class="tools pull-right">
                        <a href="javascript:;" class="fa fa-chevron-down"></a>
                    </span>
                </div>
                <div class="panel-body">
                    <div class="position-center">
                        <form id="update_order_form" enctype="multipart/form-data"
                            action="{{route('admin.order.update') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="name">Create at</label>
                                <input type="date" class="form-control" value="{{ $order->create_date }}" disabled>
                                <input type="hidden" class="form-control" name="id" placeholder="name"
                                    value="{{ $order->id }}">
                            </div>
                            <div class="form-group">
                                <label for="name">Ship to </label>
                                <div class="row">
                                    <input type="text" class="form-control"
                                        value="{{ $order->shipping_address->address . ', ' . $order->shipping_address->ward . ', ' . $order->shipping_address->district . ', ' . $order->shipping_address->province }}"
                                        disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name">Sub total</label>
                                <input type="number" class="form-control" value="{{ $order->sub_total }}" disabled>
                            </div>
                            <div class="form-group">
                                <label for="name">Discount</label>
                                <input type="number" class="form-control" value="{{ $order->discount }}" disabled>
                            </div>
                            <div class="form-group">
                                <label for="name">Total</label>
                                <input type="number" class="form-control" value="{{ $order->total }}" disabled>
                            </div>
                            <div class="form-group">
                                <label for="name">Status</label>
                                <select class="form-control" name="status">
                                    <option value="0" @if ($order->status == 0)
                                        selected
                                        @endif>Pending</option>
                                    <option value="1" @if ($order->status == 1)
                                        selected
                                        @endif>Waiting for goods</option>
                                    <option value="2" @if ($order->status == 2)
                                        selected
                                        @endif>On Delivery</option>
                                    <option value="3" @if ($order->status == 3)
                                        selected
                                        @endif>Delivered</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="name">Payment</label>
                                <select class="form-control" name="payment">
                                    <option value="1" @if ($order->is_paid == 1)
                                        selected
                                        @endif>Paid</option>
                                    <option value="0" @if ($order->is_paid == 0)
                                        selected
                                        @endif>Unpaid</option>
                                </select>
                            </div>
                            @if ($order->payment != null)
                                <h3>Credit card</h3>
                                <div class="form-group">
                                    <label for="name">Owner name: </label>
                                    <input type="text" class="form-control" value="{{ $order->payment->name }}" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="name">Type: </label>
                                    <input type="text" class="form-control" @switch($order->payment->type)
                                        @case(1)
                                        value="American Express"
                                        @break
                                        @case(2)
                                        value="Visa"
                                        @break
                                        @case(3)
                                        value="MasterCard"
                                        @break
                                        @case(4)
                                        value="Discover"
                                        @break
                                    @endswitch
                                    disabled>
                                </div>
                                <div class="form-group">
                                    <label for="name">Card number: </label>
                                    <input type="text" class="form-control" value="{{ $order->payment->card_number }}"
                                        disabled>
                                </div>
                                <div class="form-group">
                                    <label for="name">Expiration time: </label>
                                    <input type="text" class="form-control"
                                        value="{{ $order->payment->expire_month . '/' . $order->payment->expire_year }}"
                                        disabled>
                                </div>
                            @endif
                            <div class="form-group">
                                <div class="col-sm-2 col-sm-hidden"></div>
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                            <div id="errorMessage"></div>
                        </form>
                    </div>
                </div>
            </section>
            <section class="panel">
                <div class="panel-heading">
                    Order's details
                    <span class="tools pull-right">
                        <a href="javascript:;" class="fa fa-chevron-down"></a>
                    </span>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped b-t b-light">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order_details as $detail)
                                    <tr class="first odd">
                                        @foreach ($order_detail_products as $product)
                                            @if ($detail->product_id == $product->id)
                                                <td class="image">
                                                    <a class="product-image" title="Sample Product"
                                                        href="{{ URL::to('product-details/' . $product->idd) }}"><img
                                                            width="100" height="auto" alt="Sample Product"
                                                            src="{{ url('uploads/products-images/' . $product->id . '/' . $product->image) }}"></a>
                                                </td>
                                                <td>
                                                    <p class="product-name">
                                                        <a
                                                            href="{{ URL::to('product-details/' . $product->id) }}">{{ $product->name }}</a>
                                                    </p>
                                                </td>
                                                <td>
                                                    @if ($detail->product_discount != null)
                                                        <span class="cart-price">
                                                            <p class="special-price text-danger"> <span class="price">
                                                                    {{ $detail->price - ($detail->price * $detail->product_discount) / 100 }}
                                                                </span>
                                                            </p>
                                                            <p class="old-price"> <span class="price-sep">-</span> <span
                                                                    class="price"><del> {{ $detail->price }}</del>
                                                                </span> </p>
                                                        </span>
                                                    @else
                                                        <span class="cart-price">
                                                            <p class="price"> <span class="price">
                                                                    {{ $detail->price }} </span>
                                                            </p>
                                                        </span>
                                                    @endif

                                                </td>
                                                <td>
                                                    <input type="number" min="0" class="form-control"
                                                        value="{{ $detail->quantity }}" name="" disabled>
                                                </td>
                                                <td>
                                                    <span class="cart-price text-danger">
                                                        @if ($detail->product_discount != null)
                                                            <span
                                                                class="price">{{ ($detail->price - ($detail->price * $detail->product_discount) / 100) * $detail->quantity }}
                                                            </span>
                                                        @else
                                                            <span class="price">{{ $detail->price * $detail->quantity }}
                                                            </span>
                                                        @endif

                                                    </span>
                                                </td>
                                            @endif
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="cart-collaterals row">
                            <div class="col-sm-8">
                            </div>
                            <div class="totals col-sm-4">
                                <h3>Shopping Cart Total</h3>
                                <div class="inner">
                                    <table class="table shopping-cart-table-total" id="shopping-cart-totals-table">
                                        <colgroup>
                                            <col>
                                            <col width="1">
                                        </colgroup>
                                        <tfoot>
                                            <tr>
                                                <td colspan="1" class="a-left" style="">
                                                    <strong>Grand Total</strong>
                                                </td>
                                                <td class="a-right" style="">
                                                    <strong>
                                                        <span class="price">{{ $order->total }}</span>
                                                    </strong>
                                                </td>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            <tr>
                                                <td colspan="1" class="a-left" style=""> Subtotal </td>
                                                <td class="a-right" style="">
                                                    <span class="price">{{ $order->sub_total }}
                                                    </span>
                                                </td>
                                            </tr>
                                            @if ($order->discount))
                                                <tr>
                                                    <td colspan="1" class="a-left" style=""> Discount </td>
                                                    <td class="a-right" style="">
                                                        <span class="">-{{ $order->discount }}</span>
                                                    </td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                <!--inner-->

                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </section>
        <!-- footer -->
        @include('admin.footer')
        <!-- / footer -->
    </section>

    <!--main content end-->
    <script>
        $(document).ready(function() {
            $('#update_order_form').on('submit', (function(e) {
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ url('administrator/order/update') }}",
                    type: 'POST',
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: 'JSON',
                    beforeSend: function() {},
                    success: function(response) {
                        console.log(response);
                        if (response.error == true) {
                            if (response.message.name != undefined) {
                                $("#errorMessage").fadeIn(1000, function() {
                                    $("#errorMessage").html(
                                        "<div class='alert alert-danger' style='width:100%; margin:auto;'>" +
                                        response.message.name[0] +
                                        "</div>"
                                    );
                                    $("#errorMessage").fadeOut(10000);
                                });
                            }
                            if (response.message != undefined) {
                                $("#errorMessage").fadeIn(1000, function() {
                                    $("#errorMessage").html(
                                        "<div class='alert alert-danger' style='width:100%; margin:auto;'>" +
                                        response.message[0] +
                                        "</div>"
                                    );
                                    $("#errorMessage").fadeOut(10000);
                                });
                            }
                        } else {
                            alert("Update status of order.");
                            window.location.href = "{{ url('administrator/order') }}";
                        }
                    },
                    error: function(e) {
                        console.log(e);
                    }
                });
            }));
        });

    </script>
@endsection
