<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>株日記| 取引記録を残すアプリ</title>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css" integrity="sha512-NhSC1YmyruXifcj/KFRWoC561YpHpc5Jtzgvbuzx5VozKpWvQ+4nXhPdFgmx8xqexRcpAglTj9sIBWINXa8x5w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        <link rel="stylesheet" href="{{asset('css/style.css')}}">

        <!-- Scripts -->
        @vite(['resources/sass/app.scss', 'resources/js/app.js'])
        
    </head>
    <body>
        <header>
            <div id="header-area">
                <img src="{{'storage/images/note.jpg'}}" class="header-img" alt="note">
                <h1>株日記</h1>
                <p>取引を記録して、過去の取引を振り返り。取引を改善。</p>
            </div>
        </header>
        <nav class="navbar navbar-expand-md navbar-dark bg-dark sticky-top">
            <div class="container">
                <a href="#" class="navbar-brand">株日記</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-content">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbar-content">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a href="#feature" class="nav-link active">特徴</a>
                        </li>
                        <li class="nav-item">
                            <a href="#usage" class="nav-link">使い方</a>
                        </li>
                        <li class="nav-item">
                            <a href="#register" class="nav-link">登録</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('login')}}" class="nav-link">ログイン</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('register')}}" class="nav-link">登録</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <main id="main-area">
            <section id="feature" class="bg-light border">
                <h2>特徴</h2>
                <div class="feature">
                    <div class="row justify-content-center">
                        <div class="col-md-2">
                            <img src="{{asset('storage/images/paperless.jpg')}}" alt="paperless">
                        </div>
                        <div class="col-md-2">
                            <h5>ペーパーレス</h5>
                            <p>電子的に保存するので、紙のノートの山になることはありません。</p>
                        </div>
                        <div class="col-md-2">
                            <img src="{{asset('storage/images/past.jpg')}}" alt="past">
                        </div>
                        <div class="col-md-2">
                            <h5>振り返り</h5>
                            <p>検索機能で過去の記録を探し出し、取引の振り返りができます。</p>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-md-2">
                            <img src="{{asset('storage/images/pc.jpg')}}" alt="pc">
                        </div>
                        <div class="col-md-2">
                            <h5>フォーマット</h5>
                            <p>入力項目が決まっているので、何を書くかに困らない。</p>
                        </div>
                        <div class="col-md-2">
                            <img src="{{asset('storage/images/report.jpg')}}" alt="report">
                        </div>
                        <div class="col-md-2">
                            <h5>レポート出力</h5>
                            <p>取引記録をExcelファイルに出力できます。</p>
                        </div>
                    </div>
                </div>
            </section>
            <section id="usage" class="border">
                <h2>使い方</h2>
                <video src="{{asset('/storage/movies/usage.mp4')}}" controls></video>
                <ul>
                    <li>P: 監視</li>
                    <li>D: IN</li>
                    <li>C: 確認</li>
                    <li>A: OUT</li>
                </ul>
            </section>
            <section id="register" class="bg-light border">
                <h2>株日記をはじめよう</h2>
                <p>取引を記録し、過去の記録を振り返る株日記。株日記で良い株ライフを。</p>
                <a href="{{route('register')}}" class="btn btn-primary">登録</a>
            </section>
        </main>
        <footer id="footer-area" class="bg-dark text-light">
            <div class="row">
                <div class="col-md-2">
                    <ul class="nav flex-column">
                        <li class="nav-item"><a href="#feature" class="nav-link link-light">特徴</a></li>
                        <li class="nav-item"><a href="#usage" class="nav-link link-light">使い方</a></li>
                        <li class="nav-item"><a href="{{route('register')}}" class="nav-link link-light">登録</a></li>
                    </ul>
                </div>
                <div class="col-md-2">
                    <ul class="nav flex-column">
                        <li class="nav-item"><a href="" class="nav-link link-light">利用規約</a></li>
                        <li class="nav-item"><a href="" class="nav-link link-light">プライバシーポリシー</a></li>
                        <li class="nav-item"><a href="" class="nav-link link-light">お問い合わせ</a></li>
                    </ul>
                </div>
            </div>
        </footer>
    </body>
</html>
