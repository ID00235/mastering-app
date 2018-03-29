<?php
$path = Request::segment(1);

$menu_session  = Session::get('menu_session');
$menu_session = json_decode($menu_session);

?>
<div class="navbar nav_title" style="border: 0;">
  <a href="{{url('beranda')}}" class="site_title">
    <i class="fa fa-paw"></i> <span>E-Planning Batanghari</span></a>
</div>

<div class="clearfix"></div>
<!-- menu profile quick info -->
<div class="profile clearfix">
  
  <div class="profile_info">
    <img  style="padding-top: -5px;" src="{{url('img/batanghari.png')}}" height="60" class="pull-right">
    <div style="padding-top: 15px !important">
      <span><b style="color:#fff; padding-top: 15px !important;"><i class="la la-user"></i> {{Auth::user()->username}}</b></span>
      <h2>Administrator</h2>
    </div>
  </div>
</div>
<!-- /menu profile quick info -->
<br />
<!-- sidebar menu -->
<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
  <div class="menu_section">
    <h3>Menu</h3>
    <ul class="nav side-menu">
      <li class="@if($path=='beranda') active current-page @endif"><a href="{{url('beranda')}}" ><i class="fa fa-home"></i> Beranda</a></li>
      @foreach($menu_session as $mnu_induk)
        <li id="mnu_g_{{$mnu_induk->id_menu}}">
          <a href="#"><i class="{{$mnu_induk->icon}}"></i> {{$mnu_induk->nama_menu}} <span class="fa fa-chevron-down"></span></a>
          <ul class="nav child_menu" id="mnu_gc_{{$mnu_induk->id_menu}}">
            @foreach($mnu_induk->child as $mnu_child)
            <li class="@if($path==$mnu_child->url) active current-page @endif" id="mnu_c_{{$mnu_child->id_menu}}">
              <a href="{{url($mnu_child->url)}}">{{$mnu_child->nama_menu}}</a>
            </li>
            @endforeach
          </ul>

        </li>
      @endforeach
    </ul>
  </div>
</div>
<!-- /sidebar menu -->
<!-- /menu footer buttons -->
<div class="sidebar-footer hidden-small">
  <a data-toggle="tooltip" data-placement="top" title="Settings">
    <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
  </a>
  <a data-toggle="tooltip" data-placement="top" title="FullScreen">
    <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
  </a>
  <a data-toggle="tooltip" data-placement="top" title="Lock">
    <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
  </a>
  <a data-toggle="tooltip" data-placement="top" title="Logout" href="login.html">
    <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
  </a>
</div>

<script type="text/javascript">
  var $curent_url="{{url($path)}}";
</script>