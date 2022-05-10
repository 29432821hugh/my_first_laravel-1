@extends('template.template')

@section('pageTitle')
    商品詳細頁
@endsection

@section('css')
<link rel="stylesheet" href="{{asset('css/boostrap.css')}}">
    <link rel="stylesheet" href="{{asset('css/checkedout1.css')}}">
    <style>
        main #section1{
            height: unset;
        }
        main .banner .list-detail #section2 .order-list *{
            font-size: 24px !important;
        }
        .quantity i{
            cursor: pointer;
        }
        main .banner .list-detail #section2 .order-list .third-item .r-box .quantity input{
            width: 60px;
        }
    </style>
@endsection

@section('main')

        <div class="banner .container-fluid">
            <div class="list-detail">

                <!-- 上方進度條 -->
                <div id="section1" class="container-xxl">
                    <!-- 購物車標題 -->
                    <div class="shop-car">
                        <h3>{{$product->product_name}}</h3>
                    </div>
                </div>
                <!-- 中間訂單資訊 -->
                <div id="section2">
                    <!-- 訂單明細 -->
                    <div class="list-title">
                        <h4>商品介紹</h4>
                    </div>
                    <!-- 訂單內容 -->
                    <div class="order-list">
                        <div class="first-item d-flex justify-content-between">
                            <!-- 訂單內容左方區塊 -->
                            <div class="l-box d-flex">
                                <!-- 商品照 -->
                                <div class="goods-img">
                                    <img src="{{$product->img_path}}" alt="Goods-Photo">
                                </div>
                                @foreach ($product->imgs as $item)
                                <div class="goods-img">
                                    <img src="{{$item->img_path}}" alt="Goods-Photo">
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="second-item d-flex justify-content-between">
                            <!-- 訂單內容左方區塊 -->
                            <div class="l-box d-flex">
                                <!-- 商品名稱&訂單編號 -->
                                <div class="goods-info d-flex justify-content-center align-items-start">
                                    <div class="name">{{$product->product_detail}}</div>
                                </div>
                            </div>
                        </div>
                        <div class="third-item d-flex justify-content-between">
                            <!-- 訂單內容左方區塊 -->
                            <div class="l-box d-flex">
                                <!-- 商品名稱&訂單編號 -->
                                <div class="goods-info d-flex justify-content-center align-items-start">
                                    <div class="name">剩餘數量</div>
                                    <div class="number">{{$product->product_qty}}</div>
                                </div>
                            </div>
                            <!-- 訂單內容右方區塊 -->
                            <div class="r-box d-flex align-items-center">
                                <!-- 商品數量與商品價格 -->
                                <div class="quantity">
                                    商品價格
                                </div>
                                <div class="sum-price">${{$product->product_price}}</div>
                            </div>
                            <div class="r-box d-flex align-items-center">
                                <!-- 商品數量與商品價格 -->
                                <div class="quantity d-flex align-items-center">
                                    <i class="fa-solid fa-minus" id="minus"></i>
                                    <input type="number" value="1" name="qty" id="qty" max="{{$product->product_qty}}">
                                    <i class="fa-solid fa-plus" id="plus"></i>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- 底部按鈕 -->
                <div id="section4">
                    <!-- 功能按鈕 -->
                    <div class="button-box d-flex justify-content-between">
                        <div class="l-button"><a class="btn btn-primary" href="/" role="button"><i
                                    class="fa-solid fa-arrow-left"></i>返回首頁</a>
                        </div>
                        <div class="r-button">
                            <input type="number" id="product_id" value="{{$product->id}}" hidden>
                            <a class="btn btn-primary" role="button" id="add_product">加入購物車</a>
                        </div>
                    </div>
                </div>
            </div>
@endsection


@section('js')
        <script>
            const minus = document.querySelector('#minus')
            const qty = document.querySelector('#qty')
            const plus = document.querySelector('#plus')
            const add_product = document.querySelector('#add_product')

            minus.onclick = function(){
                // 用parseInt 將字串轉換為數字
                if (parseInt(qty.value)> 1){
                    qty.value = parseInt(qty.value) - 1
                }
            }
            plus.onclick = function(){
                if (parseInt(qty.value) < {!! $product->product_qty !!} ){
                    qty.value = parseInt(qty.value) + 1
                }
            }

            add_product.onclick = function(){
                // 在JS建立一個虛擬的form表單
                var formData = new FormData();

                formData.append('add_qty',   parseInt(qty.value));
                formData.append('product_id',  {!! $product->id !!});
                formData.append('_token',  '{!! csrf_token() !!}');
                // 利用fetch將form表單送過去

                fetch('/add_to_cart', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .catch(error => {
                    alert('新增失敗, 請再嘗試一次')
                    return 'error';
                })
                .then(response => {

                    if (response != 'error'){
                        if (response.result == 'success'){
                            alert('新增成功')
                        }else{
                            alert('新增失敗:' + response.message)
                        }
                    }

                });
            }


        </script>

@endsection