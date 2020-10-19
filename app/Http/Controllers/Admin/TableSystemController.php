<?php 

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\Cashier;

use App\FacePurchase;

use App\CaixaStatus;
use App\TableSystem;
use DB; 

use App\Order;
use App\Product; 
use App\ProductCategories;  
use Auth;
 
use Carbon\Carbon; 

use Illuminate\Support\Collection;

class TableSystemController extends Controller
{
     private $model;

    public function __construct(Cashier $model)
    {
        $this->model = $model;
    }
    
    public function index()
    {
         $products = Product::select(

            'product.id',

            'product.product_pic_src',

            'product.name_product',

            'product.description_product',

            'product.price_product',

            'product.promotion_active',

            'product.category_id',

            'product.status_product',

            'product.promotion_price',

            'product.promotion_day',

            'product.product_type',

            'product.product_comps'
        )

            ->join('product_categories', 'product.category_id', '=', 'product_categories.id')

            //->where('product.product_lojas_id', 'like', '%' . $data['id-loja'] . '%')

            ->where('product.status_product', '=', '1')
 
            ->orderBy('product.product_order', 'asc')

            ->get();
            
            $prodK = $products->toArray();
            
            //dd($prodK);
            
            $categories = ProductCategories::select('*')
            ->orderBy('category_order', 'asc')
            ->get();


 
        $caixaAberto = false;
        
        
        $testUm = CaixaStatus::select('*')
        ->where('user_id','=',Auth::user()->id)
        ->where('status','=',1)
        
            ->first();
            
            if($testUm != null){
            
            $caixaAberto = true;
        }
        
        
        
   return view('admin.tablesystem.index', 
        compact(
           'caixaAberto'
        ));
    }
   

}
