@extends('layouts.main')
@section('content')
	<div class="content-wrapper">
		{!! HTML::style('css/jquery-ui.css') !!}
		{!! HTML::script('js/jquery-ui.js') !!}
		<section class="content-header">
			<ol class="breadcrumb">
				<li><a href="/public/home"><i class="fa fa-home"></i> Home</a></li>
				<li class="active">Data berkas pdf</li>
			</ol>
		</section>
		
		<section class="content" style="margin-top:30px;">
		<div class="row">
			<div class="col-sm-12 col-md-12 col-lg-12">
				<div class="box">
				<div class="box-header with-border">
				  <h3 class="box-title"><b>Detail pdf</b></h3>
				  <div class="box-tools pull-right">
					<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
				  </div>
				</div><!-- /.box-header -->
				<div class="box-body">
					<iframe src="http://docs.google.com/viewer?url=www.miland.asia%2Fv2%2Fpublic%2Ffiles%2Fpdf%2F{{$pdfs->File_name}}&embedded=true" width="100%" height="650px" style="border:none;"></iframe>
				</div><!-- ./box-body -->
				</div><!-- /.box -->

			</div><!-- /.col -->
		</div><!-- /.row -->
		</section>
	</div>
@stop