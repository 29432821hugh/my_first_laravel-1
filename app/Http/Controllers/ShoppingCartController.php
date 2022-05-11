<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\ShoppingCart;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Mail\OrderComplete;

class ShoppingCartController extends Controller
{

    public function step01(){
        //登入的使用者ID        為了搜尋屬於他的購物清單
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
        // key and value; (鍵 與 值)
        // session([
        //     'amount' => $request->qty,
        // ]);

        // 不使用session 直接將新數量寫入購物車(待買清單)的資料表
        $shopping = ShoppingCart::where('user_id', Auth::id())->get();

        //事先將新的數量更新至資料表中
        foreach ($shopping as $key => $item) {
            $item->qty = $request->qty[$key];
            $item->save();
        }


        return view('shopping.checkedout2');
    }
    public function step03(Request $request){
        session([
            // key and value; (鍵 與 值)
            'pay' => $request->pay,
            'deliver' => $request->deliver,
        ]);
        $deliver = $request->deliver;

        return view('shopping.checkedout3', compact('deliver'));
    }
    public function step04(Request $request){
        //為了計算單價 將購物車根據使用者的ID抓出來
        $merch = ShoppingCart::where('user_id', Auth::id())->get();
        $subtotal = 0;
        //利用foreach迴圈 將價格與數量乘在一起
        //(因為第一步驟的數量本身商品順序就是跟購物車一樣 所以直接用相同索引值的資料互乘再加總)
        //$merch[0]->product->product_price * $amount[0]
        //$merch[1]->product->product_price * $amount[1]
        //$merch[2]->product->product_price * $amount[2]
        //$merch[3]->product->product_price * $amount[3]
        // for ($key=0; $key < count($merch); $key++) {
        //     $goods =  $merch[$key];
        //     $subtotal += $goods->product->product_price * session()->get('amount')[$key];
        // }
        // foreach ($merch as $key => $goods) {
        //     $subtotal += $goods->product->product_price * session()->get('amount')[$key];
        // }

        // 如果購物車的數量有在第一步驟更新到最新

        foreach ($merch as $value) {
            $subtotal += $value->qty * $value->product->product_price;
        }

        // 根據取貨方式決定運費金額  1 = 黑貓宅急便 所以是150元, 2 = 超商店到店 所以是60元
        if (session()->get('deliver') == "1"){
            $fee = 150;
        }else{
            $fee = 60;
        }

        //如果要做 滿額免運 (EX:3000)
        // if ($subtotal >= 3000){
        //     $fee = 0;
        // }

        $order = Order::create([
            'subtotal' => $subtotal,
            'shipping_fee' => $fee ,
            'total' => $subtotal + $fee,
            'product_qty' => count($merch),
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'pay_way' => session()->get('pay'),
            'shipping_way' => session()->get('deliver'),
            'status' => 1,
            'user_id' => Auth::id(),
        ]);

        if ($order->shipping_way == 1){
            // 如果運送方式(shipping_way)是1 代表是黑貓宅急便 地址要填入address
            $order->address =  $request->code.$request->city.$request->address;
        }else{
            // 如果運送方式(shipping_way)是2 代表是店到店 地址要填入store_address
            $order->store_address =  $request->code.$request->city.$request->address;
        }
        //別忘記任何資料的改動都需要儲存 save()
        $order->save();

        // 雖然訂單的主資料內容已經找齊而且存好, 但是還沒有把購買明細準備好

        foreach ($merch as $key => $value) {
            OrderDetail::create([
                'product_id' => $value->product->id,
                'qty' => $value->qty,
                'price' => $value->product->product_price,
                'order_id' =>  $order->id,
            ]);
        }
        // 訂單建立成功, 將購物車資料清除
        ShoppingCart::where('user_id', Auth::id())->delete();


        // 訂單建立成功, 寄信通知使用者

        $data = [
            'order_id' => $order->id,
            'user_name' => Auth::user()->name,
            'subject' => '來自好友的通知'
        ];

        Mail::to(Auth::user()->email)->send(new OrderComplete($data));

        return redirect('/show_order/'.$order->id);
    }

    public function show_order($id){
        $order = Order::find($id);
        return view('shopping.checkedout4',compact('order'));
    }
}
