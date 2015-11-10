<!DOCTYPE html>
<html class="bg-black">
    <head>
        <meta charset="UTF-8">
        <title>SChoolM | Log in</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
        <link href="{{asset("/adminltemaster/css/bootstrap.min.css")}}"  rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="{{asset("/adminltemaster/css/font-awesome.min.css")}}"  rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="{{asset("/adminltemaster/css/AdminLTE.css")}}"  rel="stylesheet" type="text/css" />

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="bg-black">
        <div class="form-box" id="login-box">
            <div class="header">
               Sign In
            </div>
            <form action="auth/login" method="post">
                 {!! csrf_field() !!}
                <div class="body bg-gray">
                    <div class="form-group">
                        <input type="email" name="email" class="form-control" placeholder="User Email"/>
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control" placeholder="Password"/>
                    </div>
                    <div class="form-group">
                    <div id="flashmsg" class="flash-message">
                        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                          @if(Session::has('alert-' . $msg))
                          <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} 
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                          @endif
                        @endforeach
                    </div> <!-- end .flash-message --> 
                    </div>
                </div>
                <div class="footer">                                                               
                    <button type="submit" class="btn bg-olive btn-block">Sign me in</button>  
                </div>
            </form>
        </div>


        <!-- jQuery 2.0.2 -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="{{asset("/adminltemaster/js/bootstrap.min.js")}}" type="text/javascript"></script>        

    </body>
    <style type="text/css">
        body {
          background-image: url("schoolm.jpg");
          background-position: 50% 50%;
          background-repeat: repeat;
        }
    </style>
    <script type="text/javascript">
       setTimeout(function() {
            $('#flashmsg').fadeOut('slow');
        }, 1500); // <-- time in milliseconds
    </script>
</html>