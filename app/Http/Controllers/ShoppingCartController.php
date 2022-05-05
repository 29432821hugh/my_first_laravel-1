<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\ShoppingCart;

class ShoppingCartController extends Controller
{

    public function step01(){
        //登入的使用者ID, 為了搜尋屬於他的購物清單
        $user = Auth::id();
        $shopping = ShoppingCart::where('user_id',$user)->get();
        //每次從資料庫抓資料出來都應當先dd一下確認是否有抓對
        $subtotal = 0;
        foreach ($shopping as $value) {
            $subtotal += $value->qty * $value->product->product_price;
        }

        // for ($i=0; $i < count($shopping); $i++) {
        //     $item = $shopping[$i]->product;
        //     dump($item->product_name);
        //     dump($item->img_path);
        //     dump($item->product_qty);
        // }

        // foreach ($shopping as $item ) {
        //     dump($item->product->product_name);
        //     dump($item->product->img_path);
        //     dump($item->product->product_qty);
        // }


        return view('shopping.checkedout1',compact('shopping','subtotal'));
    }
    public function step02(Request $request){



        // session的使用方法 使用 鍵與值的方式將想帶到下一頁的資料寫進去
        session([
            // key and value; (鍵 與 值)
            'amount' => $request->qty,
        ]);
        return view('shopping.checkedout2');
    }
    public function step03(Request $request){
        session([
            // key and value; (鍵 與 值)
            'pay' => $request->pay,
            'deliver' => $request->deliver,

        ]);

        return view('shopping.checkedout3');
    }
    public function step04(Request $request){

        dump(session()->all());
        dd($request->all());
        // return view('shopping.checkedout4');
    }
}
