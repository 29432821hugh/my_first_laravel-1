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
        Schema::table('orders', function (Blueprint $table) {
            $table->integer('subtotal')->nullable()->change();  //商品金額小記
            $table->integer('shipping_fee')->nullable()->change();  //運費
            $table->integer('total')->nullable()->change();  //總計
            $table->integer('product_qty')->nullable()->change();  //品項
            $table->string('name')->nullable()->change();  //姓名
            $table->string('phone')->nullable()->change();  //電話
            $table->string('email')->nullable()->change();  //email
            $table->string('address')->nullable()->change();  //地址
            $table->integer('pay_way')->nullable()->change();  //付款方式 : 1->代表信用卡, 2->網路ATM, 3->超商代碼
            $table->integer('shipping_way')->nullable()->change();  //運送方式 1->黑貓宅配 ,2->超商店到店
            $table->string('store_address')->nullable()->change();  //取貨超商
            $table->integer('status')->nullable()->change();  //訂單狀態  1->訂單成立(未付款), 2->已付款, 3->已出貨, 4->已結單, 5->已取消
            $table->string('ps')->nullable()->change();  //訂單備註
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
};
