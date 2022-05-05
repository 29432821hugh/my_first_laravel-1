<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('subtotal');  //商品金額小記
            $table->integer('shipping_fee');  //運費
            $table->integer('total');  //總計
            $table->integer('product_qty');  //品項
            $table->string('name');  //姓名
            $table->string('phone');  //電話
            $table->string('email');  //email
            $table->string('address');  //地址
            $table->integer('pay_way');  //付款方式 : 1->代表信用卡, 2->網路ATM, 3->超商代碼
            $table->integer('shipping_way');  //運送方式 1->黑貓宅配 ,2->超商店到店
            $table->string('store_address');  //取貨超商
            $table->integer('status');  //訂單狀態  1->訂單成立(未付款), 2->已付款, 3->已出貨, 4->已結單, 5->已取消
            $table->string('ps');  //訂單備註

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
