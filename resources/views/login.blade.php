<!DOCTYPE html>
<html lang="en">
  
<!-- Mirrored from colorlib.com/polygon/gentelella/fixed_sidebar.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 22 Mar 2018 07:27:00 GMT -->
<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>E-PLANNING Kab. Batanghari</title>

    <!-- Bootstrap -->
    <link href="{{asset('vendors/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{asset('vendors/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
    <!-- NProgress -->
    <link href="{{asset('vendors/nprogress/nprogress.css')}}" rel="stylesheet">
    <!-- jQuery custom content scroller -->
    <link href="{{asset('vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css')}}" rel="stylesheet"/>

    <!-- Custom Theme Style -->
    <link href="{{asset('css/custom.min.css')}}" rel="stylesheet">
  </head>

  <body class="login" style="background: #888 !important;">
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            @if(Session::has('warning'))
              <div class="alert alert-warning">
                  {{Session::get('warning')}} 
              </div>
            @endif
            <form method="post" action="{{url('login/submit')}}">
              {{csrf_field()}}
              
              <h1>Login Pengguna</h1>
              <div>
                <input type="text" class="form-control" placeholder="Username" 
                name="username" required="" />
              </div>
              <div>
                <input type="password" class="form-control" placeholder="Password" 
                name="password" required=""/>
              </div>
              <div>
                <center>
                  <button class="btn btn-primary" type="submit"> Login</button>
                </center>
              </div>
              <div class="clearfix"></div>
              <div class="separator">
                <div class="clearfix"></div>
                <br />

                <div>
                  <center>
                  <img src="{{asset('img/batanghari.png')}}" height="50">
                </center>
                  <h1><i class="fa fa-paw"></i> E-Planning Kab. Batanghari</h1>
                  <p>©2018 Bappeda Kab. Batanghari</p>
                </div>
              </div>
            </form>
          </section>
        </div>

         
      </div>
    </div>

    <!-- jQuery -->
    <script src="{{asset('vendors/jquery/dist/jquery.min.js')}}"></script>
    <!-- Bootstrap -->
    <script src="{{asset('vendors/bootstrap/dist/js/bootstrap.min.js')}}"></script>
    <!-- FastClick -->
    <script src="{{asset('vendors/fastclick/lib/fastclick.js')}}"></script>
    <!-- NProgress -->
    <script src="{{asset('vendors/nprogress/nprogress.js')}}"></script>
    <!-- jQuery custom content scroller -->
    <script src="{{asset('vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js')}}"></script>

    <!-- Custom Theme Scripts -->
    <script src="{{asset('js/custom.min.js')}}"></script>
<!-- Google Analytics -->
<script>
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','../../../www.google-analytics.com/analytics.js')}}','ga');

ga('create', 'UA-23581568-13', 'auto');
ga('send', 'pageview');

</script>
  </body>

<!-- Mirrored from colorlib.com/polygon/gentelella/fixed_sidebar.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 22 Mar 2018 07:27:01 GMT -->
</html>