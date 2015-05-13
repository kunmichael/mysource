@extends('layouts.main')
@section('content')
	<?php
		$error = Session::get('error_file');
		if(!empty($error)){
	?>
		<script>
			alert('{{$error}}');
		</script>
	<?php
		Session::forget('error_file');
		}
	?>

	<div class="content-wrapper">
		{!! HTML::style('css/jquery-ui.css') !!}
		{!! HTML::script('js/jquery-ui.js') !!}
		<section class="content-header">
			<ol class="breadcrumb">
				<li><a href="/public/home"><i class="fa fa-home"></i> Home</a></li>
				<li class="active">Data gambar</li>
			</ol>
		</section>
		
		<section class="content" style="margin-top:30px;">
		<div class="row">
			<div class="col-sm-12 col-md-12 col-lg-12">
				<div class="box">
				<div class="box-header with-border">
				  <h3 class="box-title"><b>Data gambar</b></h3>
				  <div class="box-tools pull-right">
					<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
				  </div>
				</div><!-- /.box-header -->
				<div class="box-body">
					<div class="row" style="margin-top:5px;">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive">
						<table id="data_file" class="table table-bordered table-hover">
							<thead>
								<tr>
									<th>Nama</th>
									<th>Aksi</th>
								</tr>
							</thead>
								@foreach($images as $row)
								<tr>
									<td>{{$row->File_name}}</td>
									<td>
										<a href="files/images/{{$row->File_name}}"><i class="fa fa-arrows-alt"></i></a>
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
						</div><!-- /.col -->
					</div><!-- /.row -->
				</div><!-- ./box-body -->
				</div><!-- /.box -->

			</div><!-- /.col -->
		</div><!-- /.row -->
		
		<script>	
			$("#data_file").dataTable({
				"bPaginate": true,
				"bLengthChange": true,
				"bFilter": true,
				"bSort": true,
				"bInfo": true,
				"bAutoWidth": true
			});
		</script>
		</section>
	</div>
@stop