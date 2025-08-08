<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/layout/common.css') }}" />
    @yield('css')
</head>

<body>
    <header class="header">
        <div class="header_inner">
            <a class="header_logo" href="/">
                <img src="{{ asset('images/logo.svg') }}" alt="ロゴ画像">
            </a>

            @php
                $route = Route::currentRouteName();
            @endphp

            @if (!in_array($route, ['register', 'login']))

                <input class="header-form" type="text" id="searchInput" placeholder="なにをお探しですか？">

                <script>
                    document.getElementById('searchInput').addEventListener('input', function () {
                        const keyword = this.value;

                        fetch(`/search?keyword=${encodeURIComponent(keyword)}`)
                            .then(response => response.text())
                            .then(html => {
                                document.getElementById('product-list').innerHTML = html;
                            });
                    });
                </script>

                @if (Auth::check())
                    <form class="button-logout" action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit">ログアウト</button>
                    </form>
                    <a class="button-mypage" href="{{ route('mypage.index') }}">マイページ</a>
                    <a class="button-sell" href="{{ route('sell.create') }}">出品</a>

                @else
                    <a class="button-login" href="{{ route('login') }}">ログイン</a>
                @endif
            @endif
        </div>
    </header>

    <main>
        @yield('content')

        @stack('scripts')
    </main>
</body>

</html>
