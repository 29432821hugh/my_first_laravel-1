<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="this's Zon-Yi's work !">
    <title>

        @yield('pageTitle')

    </title>
    {{-- 共通CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    {{-- 各頁面專屬CSS --}}
    @yield('css')

</head>

<body>
    <nav>
        <!-- logo -->
        <div class="container-xxl d-flex justify-content-lg-between ">
            <a href="/">
                <div class="logo">
                    <img src="{{ asset('img/homepage-img/logo--u5T7hu.svg')}}" alt="">
                </div>
            </a>

            <!-- 相關超連結 -->
            <ul class="nav justify-content-end align-content-center ">

                <li class="nav-item">
                    <a class="nav-link" href="/comment">留言板</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/shopping1">購物車</a>
                </li>
                @auth

                {{-- 如果帳號是管理者  要顯示後台的連結 --}}

                <li class="nav-item">
                    <a href="/order_list" class="nav-link">訂單列表</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link">{{ Auth::user()->name}}, 您好</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="" onclick="event.preventDefault(); document.querySelector('#logout_form').submit()">登出</a>

                    <form method="POST" action="{{ route('logout') }}" hidden id="logout_form">
                        @csrf
                    </form>
                </li>
                @if (Auth::user()->power == 1)
                <li class="nav-item">
                    <a href="/dashboard" class="nav-link">後台</a>
                </li>
                @endif
                @endauth
                @guest
                <li class="nav-item">
                    <a class="user-icon nav-link " href="/login">
                        登入
                    </a>
                </li>
                @endguest

            </ul>
            <!-- 漢堡連結 -->
            <div class="burger-link tabindex='1'">
                <ul class="nav justify-content-end align-content-center ">
                    <li class="nav-item2">
                        <a class="nav-link active" aria-current="page" href="#"></a>
                    </li>
                    <li class="nav-item2">
                        <a class="nav-link" href="#">Portfolio</a>
                    </li>
                    <li class="nav-item2">
                        <a class="nav-link" href="#">About</a>
                    </li>
                    <li class="nav-item2">
                        <a class="nav-link" href="#">Contact</a>
                    </li>
                    <li class="nav-item2">
                        <a class="nav-link" href="#"><i class="fa-solid fa-cart-shopping"></i></a>
                    </li>
                    <li class="nav-item2">
                        <a class="user-icon nav-link " href="#">
                            <i class=" fa-solid fa-circle-user tabindex='1'"></i>
                        </a>
                        <div class="login-remind ">
                            <P>Login</P>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <main>
        @yield('main')
    </main>
    <footer>
        <!-- 網頁其他資訊 -->
        <!-- 資訊1 -->
        <div class="other-info1 d-flex align-items-center">
            <div class="l-box">
                <div class="logo">
                    <img src=" {{asset('img/homepage-img/little.logo.png')}}" alt="little logo" />
                    <span>數位方塊</span>
                </div>
                <div class="info">
                    <p>Air plant banjo lyft occupy retro adaptogen indego</p>
                </div>
            </div>
            <div class="r-box d-flex justify-content-around">
                <ul>
                    <li>
                        <h6>CATEGORIES</h6>
                    </li>
                    <li><a>First Link</a></li>
                    <li><a>Second Link</a></li>
                    <li><a>Third Link</a></li>
                    <li><a>Fourth Link</a></li>
                </ul>
                <ul>
                    <li>
                        <h6>CATEGORIES</h6>
                    </li>
                    <li><a>First Link</a></li>
                    <li><a>Second Link</a></li>
                    <li><a>Third Link</a></li>
                    <li><a>Fourth Link</a></li>
                </ul>
                <ul>
                    <li>
                        <h6>CATEGORIES</h6>
                    </li>
                    <li><a>First Link</a></li>
                    <li><a>Second Link</a></li>
                    <li><a>Third Link</a></li>
                    <li><a>Fourth Link</a></li>
                </ul>
                <ul>
                    <li>
                        <h6>CATEGORIES</h6>
                    </li>
                    <li><a>First Link</a></li>
                    <li><a>Second Link</a></li>
                    <li><a>Third Link</a></li>
                    <li><a>Fourth Link</a></li>
                </ul>
            </div>
        </div>
        <!-- 資訊2 -->
        <div class="other-info2">
            <div class="container d-flex align-items-center justify-content-between">
                <p>© 2020 Tailblocks — @善良的人</p>
                <div class="svg">

                    <img src=" {{asset('img/some-svg/facebook.svg')}}" alt="">
                    <img src=" {{asset('img/some-svg/twitter.svg')}}" alt="">
                    <img src=" {{asset('img/some-svg/instagram.svg')}}" alt="">
                    <img src=" {{asset('img/some-svg/linkedin.svg')}}" alt="">
                </div>
            </div>
        </div>
    </footer>
    {{-- 頁面共通JS --}}
    <script src="https://kit.fontawesome.com/1b22cb82e7.js" crossorigin="anonymous"></script>
    {{-- 各頁面專用JS --}}
    @yield('js')
</body>

</html>