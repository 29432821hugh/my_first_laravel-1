@extends('layouts.app')


@section('pageTitle')
   商品管理-編輯頁
@endsection

@section('css')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

<meta name="_token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="{{ asset('css/boostrap.css') }}">
<link rel="stylesheet" href=" {{ asset('css/checkedout4.css') }}">
<style>
    main #section1 {
        height: unset;
    }
    #ps{
        width: 100%;
        height: 60px;
        resize: none;
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
                    <h3>訂單管理 - 修改狀態</h3>
                </div>

            </div>
            <!-- 中間內容：訂單資訊確認 -->
            <div id="section2">
                <!-- 訂單明細 -->
                <div class="order-list">
                    <div class="list-title">
                        <h3>訂單明細</h3>
                    </div>
                    <div class="order-content">
                        <div class="order-list">
                            @foreach ($order->detail as $item)
                                <div class="second-item d-flex justify-content-between">
                                    <!-- 訂單內容左方區塊 -->
                                    <div class="l-box d-flex">
                                        <!-- 商品照 -->
                                        <div class="goods-img">
                                            <img src="{{ $item->product->img_path }}" alt="Goods-Photo">
                                        </div>
                                        <!-- 商品名稱&訂單編號 -->
                                        <div class="goods-info d-flex justify-content-center align-items-start">
                                            <div class="name">{{ $item->product->product_name }}</div>
                                            <div class="number">{{ $item->product->product_detail }}</div>
                                        </div>
                                    </div>
                                    <!-- 訂單內容右方區塊 -->
                                    <div class="r-box d-flex align-items-center">
                                        <!-- 商品數量與商品價格 -->
                                        <div class="quantity">
                                            <p>{{ $item->qty }}</p>
                                        </div>
                                        <div class="sum-price"> ${{ $item->qty * $item->price }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <!-- 寄送資料 -->
                <div class="shipping-info">
                    <div class="shipping-title">
                        <h3>寄送資料</h3>
                    </div>
                    <div class="shipping-content">
                        <!--姓名 -->
                        <div class="name d-flex">
                            <h3>姓名</h3>
                            <p>{{ $order->name }}</p>
                        </div>
                        <!-- 電話 -->
                        <div class="tel d-flex">
                            <h3>電話</h3>
                            <p>{{ $order->phone }}</p>
                        </div>
                        <!-- 電子郵件 -->
                        <div class="email d-flex">
                            <h3>E-mail</h3>
                            <p>{{ $order->email }}</p>
                        </div>
                        <!-- 地址 -->
                        <div class="address d-flex">
                            @if ($order->shipping_way == 1)
                                <h3>地址</h3>
                                <p>{{ $order->address }}</p>
                            @else
                                <h3>超商地址</h3>
                                <p>{{ $order->store_address }}</p>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
            <!-- 下方價格 -->
            <div id="section3">
                <div class="name-no-idea">
                    <!-- 價格明細 -->
                    <div class="price-box d-flex">
                        <div class="quantity d-flex justify-content-between">
                            <h5>數量:</h5>
                            <span>{{ $order->product_qty }}</span>
                        </div>
                        <div class="subtotal d-flex justify-content-between">
                            <h5>小計:</h5>
                            <span>${{ $order->subtotal }}</span>
                        </div>
                        <div class="shipping-fee d-flex justify-content-between">
                            <h5>運費:</h5>
                            <span>${{ $order->shipping_fee }}</span>
                        </div>
                        <div class="total d-flex justify-content-between">
                            <h5>總計:</h5>
                            <span>${{ $order->total }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- 底部按鈕 -->
            <form id="section4" action="/order/update/{{$order->id}}" method="post">
                @csrf
                <!-- 訂單狀態以及備註 -->
                    {{-- 1->訂單成立(未付款), 2->已付款, 3->已出貨, 4->已結單, 5->已取消 --}}
                <h2>訂單狀態</h2>
                <select name="status" id="status">
                    <option value="1" @if ($order->status == 1) selected @endif>未付款</option>
                    <option value="2" @if ($order->status == 2) selected @endif>已付款</option>
                    <option value="3" @if ($order->status == 3) selected @endif>已出貨</option>
                    <option value="4" @if ($order->status == 4) selected @endif>已結單</option>
                    <option value="5" @if ($order->status == 5) selected @endif>已取消</option>
                </select>

                <h2>訂單備註</h2>
                <textarea name="ps" id="ps" >{{$order->ps}}</textarea>

                <!-- 功能按鈕 -->
                <div class="button-box d-flex justify-content-end">
                    <div class="l-button">
                        <a class="btn btn-primary" href="#" role="button">
                            <i class="fa-solid fa-arrow-left"></i>取消修改</a>
                    </div>
                    <div class="r-button">
                        <button class="btn btn-primary" type="submit" role="button">修改狀態</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection