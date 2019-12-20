<html lang="ja">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">


        <title>うっどんずラブ</title>
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
                <a class="nav-link" href="https://www.takamatsu-airport.com" target="blank">高松空港HP</a>
            </li>
            </ul>
        </div>
        </nav>

        <div class="container-fluid">
            @yield('content')
        </div>

        <div class="container-fluid">
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
        .jumbotron { background:url(/picture/takamatsu.png) center no-repeat; background-position: bottom 60%; background-size: cover;}
        .background {opacity: 0.1;}
        .row-eq-height {display: flex; flex-wrap: wrap;}

        h1 {
        color: #364e96;/*文字色*/
        border: solid 3px #364e96;/*線色*/
        padding: 0.5em;/*文字周りの余白*/
        border-radius: 0.5em;/*角丸*/
        }

        h3 {
        padding: 0.4em 0.5em;/*文字の上下 左右の余白*/
        color: #494949;/*文字色*/
        background: #f4f4f4;/*背景色*/
        border-left: solid 5px #7db4e6;/*左線*/
        border-bottom: solid 3px #d7d7d7;/*下線*/
        }

        h4 {
        padding: 0.4em 0.5em;/*文字の上下 左右の余白*/
        color: #494949;/*文字色*/
        background: #f4f4f4;/*背景色*/
        border-left: solid 5px #7db4e6;/*左線*/
        border-bottom: solid 3px #d7d7d7;/*下線*/
        text-align: center;
        }

        section {
            overflow: scroll;
            margin: 50px auto 20px;
            padding: 25px;
            width: auto;
            height: 600px;
            border: 2px solid #ccc;
        }

        p {
            min-width: 400px;
        }

        figure {
            width: 400px;
        }

        .balloon5 {
        width: 100%;
        margin: 1.5em 0;
        overflow: hidden;
        }

        .balloon5 .faceicon {
        float: left;
        margin-right: -90px;
        width: 80px;
        }

        .balloon5 .faceicon img{
        width: 100%;
        height: auto;
        border: solid 3px #d7ebfe;
        border-radius: 50%;
        }

        .balloon5 .chatting {
        width: 100%;
        }

        .says {
        display: inline-block;
        position: relative; 
        margin: 5px 0 0 105px;
        padding: 17px 13px;
        border-radius: 12px;
        background: #d7ebfe;
        }

        .says:after {
        content: "";
        display: inline-block;
        position: absolute;
        top: 18px; 
        left: -24px;
        border: 12px solid transparent;
        border-right: 12px solid #d7ebfe;
        }

        .says p {
        margin: 0;
        padding: 0;
        }
    </style>



</head>
</html>

