<html lang="ja">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

        <title>中部大学チーム - @yield('title')</title>
    </head>
    {{-- <body> --}}
    <body style="padding-top:4.5rem;">

        <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <a class="navbar-brand" href="#">Hack Future</a>
        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="ナビゲーションの切替">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="/">ホーム <span class="sr-only">(現位置)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/review">リンク1</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="https://www.takamatsu-airport.com" target="blank">高松空港HP</a>
            </li>
            </ul>
        </div>
        </nav>

        <div class="container-fluid">
            @yield('content')
        </div>

        <div class="container">
            <div class="row">
                <div class="col-sm-8">
                @yield('content-main')
                </div>
                <div class="col-sm-4">
                @yield('content-sub')
                </div>
            </div>
        </div>


        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <script>
            $('#button-tag').click(function() {
            var r = $('#select-tag').val();

            if(r == ""){
                console.log(r);
                alert("選択してください");
            } else {
                console.log(r);
                alert(r+"が選択されました");
            }})
        </script>
    </body>

        <!--自作CSS -->
    <style type="text/css">
        /*ここに調整CSS記述*/
        .jumbotron { background:url(/picture/takamatsu.jpg) center no-repeat; background-position: bottom 60%; background-size: cover;}
        .background {opacity: 0.1;}
    </style>

</head>
</html>

