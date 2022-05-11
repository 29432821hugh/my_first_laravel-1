@extends('template.template')

@section('pageTitle')
    訂單第一頁
@endsection

@section('css')
<link rel="stylesheet" href="{{asset('css/boostrap.css')}}">
    <link rel="stylesheet" href="{{asset('css/checkedout1.css')}}">
    <style>
        main #section1{
            height: unset;
        }
        main *{
            font-size: 20px;
        }
        main .banner .list-detail #section2 .order-list .first-item .r-box{
            width: 250px;
        }
        main .banner .list-detail #section2 .order-list .first-item .r-box .quantity input{
            width: 60px;
        }
    </style>
@endsection

@section('main')

        <div class="banner .container-fluid">
            <form action="/shopping2" method="post" class="list-detail">
                @csrf
                <!-- 上方進度條 -->
                <div id="section1" class="container-xxl">
                    <!-- 購物車標題 -->
                    <div class="shop-car">
                        <h3>購物車</h3>
                    </div>
                    <!-- 進度表 -->
                    <div class="progress-container">
                        <div class="progress">
                            <div class="box1">
                                <div class="box1-t d-flex">
                                    <div class="l-line"></div>
                                    <div class="step1 d-flex ">1</div>
                                    <div class="r-line"></div>
                                </div>
                                <div class="box1-b">
                                    <li>確認購物車</li>
                                </div>
                            </div>
                            <div class="box2">
                                <div class="box2-t d-flex">
                                    <div class="l-line"></div>
                                    <div class="step2 d-flex ">2</div>
                                    <div class="r-line"></div>
                                </div>
                                <div class="box2-b">
                                    <li>付款與運送方式</li>
                                </div>
                            </div>
                            <div class="box3">
                                <div class="box3-t d-flex">
                                    <div class="l-line"></div>
                                    <div class="step3 d-flex ">3</div>
                                    <div class="r-line"></div>
                                </div>
                                <div class="box3-b">
                                    <li>填寫資料</li>
                                </div>
                            </div>
                            <div class="box4">
                                <div class="box4-t d-flex">
                                    <div class="l-line"></div>
                                    <div class="step4 d-flex ">4</div>
                                    <div class="r-line"></div>
                                </div>
                                <div class="box4-b">
                                    <li>完成訂購</li>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- 中間訂單資訊 -->
                <div id="section2">
                    <!-- 訂單明細 -->
                    <div class="list-title">
                        <h4>訂單明細</h4>
                    </div>
                    <!-- 訂單內容 -->
                    <div class="order-list">
                        @foreach ($shopping as $item )
                        <div class="first-item d-flex justify-content-between">
                            <!-- 訂單內容左方區塊 -->
                            <div class="l-box d-flex">
                                <!-- 商品照 -->
                                <div class="goods-img">
                                    <img src="{{ $item->product->img_path }}" alt="Goods-Photo">
                                </div>
                                <!-- 商品名稱&訂單編號 -->
                                <div class="goods-info d-flex justify-content-center align-items-start">
                                    <div class="name">{{$item->product->product_name}}</div>
                                    <div class="number"
                                        data-product_qty="{{$item->product->product_qty}}"
                                        data-product_price="{{$item->product->product_price}}"
                                        >{{$item->product->product_detail}}</div>
                                </div>
                            </div>
                            <!-- 訂單內容右方區塊 -->
                            <div class="r-box d-flex align-items-center">
                                <!-- 商品數量與商品價格 -->
                                <div class="quantity">
                                    <i class="fa-solid fa-minus"></i>
                                    <input type="number" name="qty[]" class="qty" value="{{$item->qty}}" readonly>
                                    <i class="fa-solid fa-plus"></i>
                                </div>
                                <div class="sum-price"> ${{$item->qty * $item->product->product_price}}</div>
                                <div class="btn btn-danger" onclick="delete_cart('{{$item->id}}')">刪除</div>
                            </div>
                        </div>
                        @endforeach


                    </div>
                </div>
                <!-- 下方價格 -->
                <div id="section3">
                    <div class="name-no-idea">
                        <!-- 價格明細 -->
                        <div class="price-box d-flex">
                            <div class="quantity d-flex justify-content-between">
                                <h5>數量:</h5>
                                <span> {{ count($shopping) }}</span>
                            </div>
                            <div class="subtotal d-flex justify-content-between">
                                <h5>小計:</h5>
                                <span>${{ $subtotal }}</span>
                            </div>
                            <div class="shipping-fee d-flex justify-content-between">
                                <h5>運費:</h5>
                                <span>$150</span>
                            </div>
                            <div class="total d-flex justify-content-between">
                                <h5>總計:</h5>
                                <span>${{$subtotal+150}}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- 底部按鈕 -->
                <div id="section4">
                    <!-- 功能按鈕 -->
                    <div class="button-box d-flex justify-content-between">
                        <div class="l-button">
                            <a class="btn btn-primary" href="/" role="button">
                                <i class="fa-solid fa-arrow-left"></i>返回購物
                            </a>
                        </div>
                        <div class="r-button"><button class="btn btn-primary" type="submit" role="button">下一步</button></div>
                    </div>
                </div>
            </form>
@endsection


@section('js')

    <script>
        const minus = document.querySelectorAll('.fa-minus')
        const plus = document.querySelectorAll('.fa-plus')
        const qty = document.querySelectorAll('.qty')
        const sum_price = document.querySelectorAll('.sum-price')
        // 為了知道各個產品所剩數量方便判斷 所以將資料印在html中, 再使用JS抓進來
        const number = document.querySelectorAll('.number')

        // 小計與總計的元素
        const subtotal = document.querySelector('.subtotal span')
        const total = document.querySelector('.total span')


        for (let i = 0; i < minus.length; i++) {
            minus[i].onclick = function(){

                if (parseInt(qty[i].value)> 1){
                    qty[i].value = parseInt(qty[i].value) - 1
                    // 重新計算價格 (商品單價*數量)
                    sum_price[i].innerHTML = '$' + (parseInt(number[i].dataset.product_price) * parseInt(qty[i].value))
                }
                get_total()
            }

            plus[i].onclick = function(){

                if (parseInt(qty[i].value) < parseInt(number[i].dataset.product_qty) ){
                    qty[i].value = parseInt(qty[i].value) + 1
                    sum_price[i].innerHTML = '$' + (parseInt(number[i].dataset.product_price) * parseInt(qty[i].value))
                }
                get_total()
            }
        }


        function get_total(){
            // 計算所有品項的金額 並加總
            var sum = 0
            for (let j = 0; j < minus.length; j++) {
                sum += parseInt(number[j].dataset.product_price) * parseInt(qty[j].value)
            }
            subtotal.innerHTML = '$' + sum
            total.innerHTML = '$' + (sum + 150)
        }

        function delete_cart(id){
            var form = new FormData();
            form.append('_token',  '{!! csrf_token() !!}');
            fetch('/delete_from_cart/'+ id, {
                method: 'POST',
                body: form
            }).then(res => {
                // 使用js重新整理網頁 dirty but work
                location.reload()
            })


        }

    </script>






@endsection