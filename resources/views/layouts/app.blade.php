<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>



    <!--説明文-->
    <meta name="description" content="ひきこもりの居場所として当事者向けに設置した掲示板です。
        他愛のない話題でも悩み事でもなんでもかまいませんのでどうぞご利用ください。
        初めて投稿される方はご利用上の注意を守ってご投稿、コメント、お願いします。">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <!-- <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css"> -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- 追加のcss -->
    <style>
        .container-fluid {
            margin-right: auto;
            margin-left: auto;
            max-width: 1280px; //例えば
        }

        .sidebar_fixed {
            position: sticky;
            top: 60px;
            z-index: 2;
        }
        .sidebar_content {
            margin-bottom: 100px;
        }

        body{ 
            padding-top: 60px; 
        }

        .icon_color {
            color: #428bca;
        }

        .pagination { 
            justify-content: center;
            padding-top: 20px;
        }
    }
    </style>

    <meta name="google-site-verification" content="9TTnTDzFe64i2j7rKRFhys3rRPNHXEYiVyXMAtk9Dws" />
  
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm fixed-top">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('ログイン') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('ユーザー登録') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ Auth::user()->name }}</button>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">

                                    <a href="{{ route('posts.create') }}" class="dropdown-item">投稿する</a>

                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                        {{ __('ログアウト') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container-fluid">
            <div class="row">
                <!-- 左サイドバー固定　-->
                <div class="col-md-3">
                    <div class="sidebar_fixed">                    
                        <div class="card">
                            <div class="card-body">
                                <ul class="list-group list-group-flush">
                                @guest
                                    <li class="list-group-item">
                                        <div class="home_button row justify-content-center">
                                            <a type="button" class="btn btn-link font-weight-bold" href="{{ url('/') }}">ホーム</a>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="home_button row justify-content-center">                                                
                                            <a type="button" class="btn btn-link font-weight-bold" href="{{ url('/information') }}">インフォメーション</a>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="home_button row justify-content-center">                                            
                                            <a type="button" class="btn btn-link font-weight-bold" href="{{ url('/how_to_use') }}">掲示板の使い方</a>
                                        </div>                                    
                                    </li>
                                    <li class="list-group-item">
                                        <div class="home_button row justify-content-center">                                            
                                            <a type="button" class="btn btn-link font-weight-bold" href="{{ url('/caution') }}">ご利用上の注意</a>
                                        </div>                                    
                                    </li>
                                    <li class="list-group-item">
                                        <div class="home_button row justify-content-center">                                            
                                            <a type="button" class="btn btn-link font-weight-bold" href="{{ url('/users/2') }}">管理人(リターン計画）の雑記</a>
                                        </div>                                    
                                    </li>
                                    
                                    @if (Route::has('register'))
                                        <li class="list-group-item">
                                            <div class="home_button row justify-content-center">
                                                <a href="{{ route('register') }}" class="btn btn-primary">ユーザー登録</a>
                                            </div>
                                            <hr>
                                            ユーザー登録しないとログインできません。
                                        </li>
                                    @endif
                                    <li class="list-group-item">
                                        <div class="home_button row justify-content-center">
                                            <a href="{{ route('login') }}" class="btn btn-primary">ログイン</a>
                                        </div>
                                        <hr>
                                        ログインしないと投稿やコメントは書き込めません。                                        
                                    </li>
                                @else
                                    <li class="list-group-item">
                                        <div class="home_button row justify-content-center">
                                            <a type="button" class="btn btn-link font-weight-bold" href="{{ url('/') }}">ホーム</a>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="home_button row justify-content-center">                                                
                                            <a type="button" class="btn btn-link font-weight-bold" href="{{ url('/information') }}">インフォメーション</a>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="home_button row justify-content-center">                                            
                                            <a type="button" class="btn btn-link font-weight-bold" href="{{ url('/how_to_use') }}">掲示板の使い方</a>
                                        </div>                                    
                                    </li>
                                    <li class="list-group-item">
                                        <div class="home_button row justify-content-center">                                            
                                            <a type="button" class="btn btn-link font-weight-bold" href="{{ url('/caution') }}">ご利用上の注意</a>
                                        </div>                                    
                                    </li>
                                    <li class="list-group-item">
                                        <div class="home_button row justify-content-center">                                            
                                            <a type="button" class="btn btn-link font-weight-bold" href="{{ url('/users/2') }}">管理人(リターン計画）の雑記</a>
                                        </div>                                    
                                    </li>
                                    <li class="list-group-item">
                                        <div class="home_button row justify-content-center">
                                            <a href="{{ route('posts.create') }}" class="btn btn-primary">投稿する</a>
                                        </div>
                                    </li>
                                @endguest    
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- メインコンテンツ -->
                <main class="py-4 col-md-6">
                    <div class="card">
                        @yield('content')
                    </div>
                </main>
                
                <!-- 右サイドバー　-->
                <div class="col-md-3">
                    <div class="sidebar_fixed">                   
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title">検索フォーム</h6>
                                <div id="custom-search-input">
                                    <div class="input-group col-md-12">
                                        <form action="{{ route('posts.search') }}" method="get">
                                        {{ csrf_field() }}    
                                            <input type="text" class="form-control input-lg" placeholder="Buscar" name="search" value="">
                                            <span class="input-group-btn" style="position:relative; top:-37px; right:-201px;">
                                                <button class="btn btn-primary" type="submit">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </span>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--<div class="sidebar_content">-->
                        <div class="card">
                            <div class="card-body">
                                <li class="list-group-item">ここのエリアはまだ使用していません。</li>
                            </div>
                        </div>    
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
