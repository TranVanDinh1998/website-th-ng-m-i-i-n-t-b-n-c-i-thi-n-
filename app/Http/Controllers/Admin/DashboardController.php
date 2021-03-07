<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Collection;
use App\Models\CollectionProduct;
use App\Models\ProductImage;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Producer;
use App\Models\TagProduct;
use App\Models\Review;
use App\Models\User;
use App\Models\Address;
use App\Models\Ward;
use App\Models\District;
use App\Models\Province;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    public function __construct(Product $product, Order $order, User $user)
    {
        $this->user = $user;
        $this->middleware('auth:admin');
        $this->product = $product;
        $this->order = $order;
    }
    public function index()
    {
        $count_view = $this->product->sum('view');
        $count_user = $this->user->count();
        $count_sale = $this->order->done()->sum('total');
        $count_order = $this->order->count();
        $products = $this->product
            ->select(
                'id',
                'name',
                'price',
                'remaining',
                'quantity',
                DB::raw('quantity-remaining as leftover')
            )
            ->orderByDesc('leftover')
            ->limit(10)
            ->get();
        $user = Auth::guard('admin')->user();

        // chart
        // daily
        $daily = array();
        $daily_chart = null;
        $daily_chart =
            '<div id="graph8"></div>
        <script>
            var day_data = [';
        for ($i = 0; $i < 7; $i++) {
            $day = Carbon::now()->startOfWeek()->addDay($i)->toDateString();
            $sum_sale = $this->order->active()->where('created_at', $day)->done()->sum('total');
            $sum_pending = $this->order->active()->where('created_at', $day)->notDone()->sum('total');
            $daily[] = array('day' => $day, 'sale' => $sum_sale, 'pending' => $sum_pending);
        }
        // print_r($daily);
        foreach ($daily as $day) {
            $daily_chart .= '{
                "period": "' . $day['day'] . '",
                "sale": ' . $day['sale'] . ',
                "pending": ' . $day['pending'] . '
            },';
        }
        $daily_chart .= "        
            ];
            Morris.Bar({
                element: 'graph8',
                data: day_data,
                xkey: 'period',
                ykeys: ['sale', 'pending'],
                labels: ['Sale', 'Pending'],
                xLabelAngle: 60
            });

        </script> ";
        // month
        $monthly = array();
        $monthly_chart = null;
        $monthly_chart .= '
        <div id="graph7"></div>
        <script>
            // This crosses a DST boundary in the UK.
            Morris.Area(
                {
                element: "graph7",
                data: [ ';
        for ($i = 0; $i < 12; $i++) {
            $begin_day = Carbon::now()->startOfMonth()->addMonth($i)->toDateString();
            $end_day = Carbon::now()->endOfMonth()->addMonth($i)->toDateString();
            // echo $begin_day.'-'.$end_day.'<br>';
            $sum_sale = $this->order->active()->whereBetween('created_at', [$begin_day, $end_day])->done()->sum('total');
            $sum_cancel = $this->order->active()->whereBetween('created_at', [$begin_day, $end_day])->inActive()->sum('total');
            $monthly[] = array('day' => $end_day, 'sale' => $sum_sale, 'cancel' => $sum_cancel);
        }
        foreach ($monthly as $month) {
            $monthly_chart .= "
            {
                day: '" . $month['day'] . "',
                sale: " . $month['sale'] . ",
                cancel: " . $month['cancel'] . "
            },
            ";
        }
        $monthly_chart  .= "      
            ],
            xkey: 'day',
            ykeys: ['sale', 'cancel'],
            labels: ['Sale', 'Cancel']
            });

        </script>";
        // year
        $yearly = array();
        $yearly_chart = null;
        $yearly_chart .= '
        <div id="graph9"></div>
        <script>
            var day_data = [
        ';
        for ($i = 5; $i >= 0; $i--) {
            $begin_day = Carbon::now()->startOfYear()->subYear($i)->toDateString();
            $end_day = Carbon::now()->endOfYear()->subYear($i)->toDateString();
            $year = Carbon::now()->subYear($i)->year;
            $sum_sale = $this->order->active()->whereBetween('created_at', [$begin_day, $end_day])->done()->sum('total');
            $yearly[] = array('year' => $year, 'sale' => $sum_sale);
        }
        foreach ($yearly as $year) {
            $yearly_chart .= '
            {
                "elapsed": "'.$year['year'].'",
                "value": '.$year['sale'].'
            },
            ';
        }
        $yearly_chart .=  "];
            Morris.Line({
                element: 'graph9',
                data: day_data,
                xkey: 'elapsed',
                ykeys: ['value'],
                labels: ['value'],
                parseTime: false
            });
        </script>";

        return view('pages.admin.dashboard.index', [
            // count
            'count_view' => $count_view,
            'count_user' => $count_user,
            'count_sale' => $count_sale,
            'count_order' => $count_order,
            // user
            'current_user' => $user,
            // products
            'products' => $products,
            // categories

            // chart
            'daily_chart' => $daily_chart,
            'monthly_chart' => $monthly_chart,
            'yearly_chart' => $yearly_chart,

        ]);
    }
}
