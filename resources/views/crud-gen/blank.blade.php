@extends('layout')
@section('content')
<?php
loadHelper('akses');
$base_route = '{{$prefix}}';
?>
<hr>
<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12 pd-20">
	    <div class="x_panel">
		      <div class="x_title">
		      	<div class="pull-right"><span class="loading-panel"></span></div>
		        <h2>{TITLE PAGE}</h2>
		        <div class="clearfix"></div>
		      </div>
		      <div class="x_content">
		        <p>
		        	<!--tombol aksi disini cuy-->
		        </p>
		        <hr>
		        <div class="row">
			         <div class="col-md-12">
			         	<!--Kopikan disini cuy-->
			         </div>			        
		        </div>				
		      </div>
	    </div>
	  </div>
</div>
@endsection

@section("modal")
	<!--Kopikan disini cuy-->
@endsection


@section('js')
<script type="text/javascript">
	$(function(){
		//Kopikan disini cuy
	})
@endsection