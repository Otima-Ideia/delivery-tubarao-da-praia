<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\User;

use App\Order;

use Faker\Provider\zh_CN\DateTime;

use App\Product;

use App\OrderProduct;

use App\OrderStatus;

use App\PaymentMethod;

use App\OrderComplements;

use App\OrderUpdatedStatusTime;

use App\Jobs\SendMail;

use App\Mail\DeliveryMail;

use App\Mail\DeliveryStatusMail;

use Illuminate\Contracts\Support\MessageProvider;

use Illuminate\Support\Facades\Mail;

use Carbon\Carbon;

use Hash;

use App\Avaliation;

use App\Http\Controllers\StaticMethodsController;
use function GuzzleHttp\json_encode;

class OrderController extends Controller
{

    public function index()
    {

        $data = date("Y-m-d");

        if (\Auth::user()->role == User::ROLE_ADMIN) {

            $orders = Order::select('*')

                ->with(['getClient'])

                ->with(['getLoja'])

                ->with(['getStatus'])

                ->with(['getPaymentMethod'])

                ->with('getPaymentMethod')

                ->orderBy('id', 'desc')

                ->paginate(100);
                
                 $ordersAjax = Order::select('*')

                ->with(['getClient'])

                ->with(['getLoja'])

                ->with(['getStatus'])

                ->with(['getPaymentMethod'])

                ->with('getPaymentMethod')

                ->orderBy('id', 'desc')
                
                ->where('order_status', '=', 2)

                ->paginate(100);
                
                
                
        } else {

            $orders = Order::select('*')

                ->with(['getClient'])

                ->with(['getLoja'])

                ->with(['getStatus'])

                ->with(['getPaymentMethod'])

                ->where('order_loja_id', '=', \Auth::user()->loja_id)

                ->where('created_at', 'like', '%' . $data . '%')

                ->orderBy('id', 'desc')

                ->paginate(100);
        }
        
        

        $status = OrderStatus::all();

        $entregadores = json_encode(User::where('role', '=', User::ROLE_DELIVERYMAN)->where('deliveryman_online', '=', 1)->get());
        
        return view('admin.order.index', compact('orders', 'status', 'entregadores','ordersAjax'));
    }
    public function indexAjax(Request $request)
    {

        $data = date("Y-m-d");

        if (\Auth::user()->role == User::ROLE_ADMIN) {

            $orders = Order::select('*')

                ->with(['getClient'])

                ->with(['getLoja'])

                ->with(['getStatus'])

                ->with(['getPaymentMethod'])

                ->with('getPaymentMethod')

                ->orderBy('id', 'desc')
                
                ->where('order_status', '=', '3')

                ->paginate(100);
        } else {

            $orders = Order::select('*')

                ->with(['getClient'])

                ->with(['getLoja'])

                ->with(['getStatus'])

                ->with(['getPaymentMethod'])

                ->where('order_loja_id', '=', \Auth::user()->loja_id)

                ->where('created_at', 'like', '%' . $data . '%')

                ->orderBy('id', 'desc')

                ->paginate(100);
        }

        $status = OrderStatus::all();

        $entregadores = json_encode(User::where('role', '=', User::ROLE_DELIVERYMAN)->where('deliveryman_online', '=', 1)->get());
        
        return count($orders);
    }

    public function create()
    { }

    public function store(Request $request)
    { }

    public function show($id)
    {
        
        $order = Order::select('*')

            ->with(['getClient'])->First()

            ->where('orders.id', '=', $id);
  
        $next = $this->nextButton($id);

        $method = $this->paymentMethod($order->First()->order_payment_method);

        // $productss = OrderProduct::select('*')

        // ->with(['getOrderProducts'])->get()

        // ->where('order_id', '=', $id);

        // $productsJson = $productss->toJson();

        // $products     = json_decode($productsJson);

        $status = $this->statusList();

        $lojas = StaticMethodsController::getLojasList();

        $products = OrderProduct::with(['getOrderProducts'])
            ->with(['getVariations'])
            
            ->where('order_id', '=', $id)->get();

        $variableProds = OrderComplements::with(['getOrderVariableProducts'])
            ->with(['getComplement'])
            
            ->where('order_id', '=', $id)->get();

       
        $comboVarOrder = [];
        foreach($products as $product){

            array_push( $comboVarOrder, Product::findCombo(  explode( ',', str_replace( ["[","]",'"'],"",$product['order_combo_ids']   )) ));
           
        }
        
      

        return view('admin.order.show', compact(['id','order', 'products','comboVarOrder', 'next', 'status', 'method', 'lojas', 'variableProds']));
    }

    public function updateStatus(Request $request, $id, $status, $ent = null)
    {
       
        $up = Order::where('id', $id)->update(array(

            'order_status' => $status,
            'deliveryman_id' => $ent ?? null

        ));
        
         $order = Order::select('*')

            ->with(['getClient'])->First()

            ->where('orders.id', '=', $id);
            
             
       
       
        if ($up == 1) {

            $stat = OrderStatus::find($status);

            $this->registerUpdateStatusTime($id, $stat->status_name);

            $this->sendStatusEmailOrder($id);

            $this->pusher($stat->status_name, $id,$order->First()->order_client_id);

            return 1;
        }

        return 0;
    }
    
    public function testPusher(){
        
        $this->pusher('Test', "TAte");
    }

    public function nextButton($id)
    {

        $next = Order::select('id')

            ->where('id', '>', $id)

            ->limit(1);

        return $next;
    }

    public function next($id)
    {

        $next = $this->nextButton($id);

        return $next->First()->id;
    }

    public function statusList()
    {

        return OrderStatus::pluck('status_name', 'id');
    }

    public function paymentMethod($id)
    {

        $data = PaymentMethod::find($id);

        return $data;
    }

    public function exportOrder(Request $request)
    {

        try {

            $req = json_encode($request->all());

            $req = json_decode($req);

            $order = Order::where('id', $req->id)->update(array(

                'order_loja_id' => $req->loja,

            ));

            return $order;
        } catch (\Exception $e) {

            return false;
        }
    }

    public function print($id)
    {

        $order = Order::select('*')

            ->with(['getClient'])->First()

            ->with(['getLoja'])

            ->where('orders.id', '=', $id);

        $next = $this->nextButton($id);

        $method = $this->paymentMethod($order->First()->order_payment_method);

        $products = OrderProduct::with(['getOrderProducts'])
            ->with('getVariations')
            ->where('order_id', '=', $id)->get();

        $variableProds = OrderComplements::with(['getOrderVariableProducts'])
            ->with(['getComplement'])
            ->where('order_id', '=', $id)->get();

        $status = $this->statusList();

        return view('admin.order.print', compact([
            'order',
            'products', 'next', 'status', 'method', 'lojas', 'variableProds'
        ]));
    }

    public function sendStatusEmailOrder($id)
    {
        $order = Order::with('getClient')
            ->with('getStatus')
            ->where('id', '=', $id)
            ->First();

        $ava = Avaliation::select('*')
            ->where('order_id', '=', $id)
            ->get();
        
        
         $mail = new DeliveryStatusMail($order);

         return Mail::to($order->getClient->email)->send($mail);
    }

    public function getNewOrders($id_prod)
    {

        $orders = Order::select('*')

            ->with(['getClient'])

            ->with(['getLoja'])

            ->with(['getStatus'])

            ->with(['getPaymentMethod'])

            ->where('order_loja_id', '=', \Auth::user()->loja_id)

            ->where('orders.id', '>', $id_prod)

            ->orderBy('id', 'desc')

            ->get();

        return response()->json($orders);
    }

    function registerUpdateStatusTime($id_order, $status_name)
    {

        $data = [
            'order_status_updated_id' => $id_order,
            'order_user_updated_id' => \Auth::user()->id,
            'order_status_name' => $status_name
        ];

        if (!empty($id_order) && !empty($status_name)) {
            $status_up_time = OrderUpdatedStatusTime::create($data);
        }
    }

    public function editLogin($email, $password)
    {

        $user = User::select('*')
            ->where('email', '=', $email)
            ->get();

        if (Hash::check($password, $user->First()->password)) {

            if ($user->First()->role == User::ROLE_ADMIN) {
                return $bool = "true";
            }
        }

        return $bool = "false";
    }

    public function excludeOrderProd($id, $order_id, $value, $qtd)
    {

        $find = OrderProduct::findOrFail($id);

        $order = Order::findOrFail($order_id);

        if ($find) {

            $find->destroy($id);

            $order->update(array(

                'order_total' => $value,
                'order_prod_qtd' => $qtd

            ));

            return $stat = "true";
        }

        return $stat = "false";
    }

    public function pusher($status, $id,$cliente)
    {

        

  $options = array(
    'cluster' => 'mt1',
    'useTLS' => true
  );
  $pusher = new \Pusher\Pusher(
    'c14930fdd698633ad169',
    '72475962d8abdc5ffac5',
    '1013281',
    $options
  );

        $data = [
            'order_id' => $id,
            'order_status' => $status,
            'cliente_id' => $cliente
        ];

        $pusher->trigger('my-channel2', 'my-event', $data);
    }
}
