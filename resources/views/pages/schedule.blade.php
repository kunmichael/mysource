@extends('layouts.main')
@section('content')
	<?php
		function change_date($date){
			$exploded_date = explode('-',$date);
			$array = array($exploded_date[2],$exploded_date[1],$exploded_date[0]);
			$today_date = implode('-',$array);
			return $today_date;
		}

		$karyawan_object = new \App\Model\Karyawan();
	?>

	<div class="content-wrapper">
		{!! HTML::style('css/jquery-ui.css') !!}
		{!! HTML::script('js/jquery-ui.js') !!}
		<section class="content-header">
			<ol class="breadcrumb">
				<li><a href="/public/home"><i class="fa fa-home"></i> Home</a></li>
				<li><a href="/schedule"> Jadwal</a></li>
			</ol>
		</section>
		
		<section class="content" style="margin-top:30px;" >
		<div class="row">
			
			<div class="col-sm-12 col-md-12 col-lg-12">
				<div class="box">
				<div class="box-header with-border">
				  <h3 class="box-title"><b>Jadwal</b></h3> <small><a href="#add" data-toggle='modal'><span class="glyphicon glyphicon-plus"></span></a></small>
				  <div class="box-tools pull-right">
					<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
				  </div>
				</div><!-- /.box-header -->
				<div class="box-body">
					<div class="row" style="margin-top:5px;">
						<div class="col-sm-12 col-md-12 col-lg-12">
							<div class="nav-tabs-custom">
								<ul class="nav nav-tabs">
									<li class="active"><a href="#tab_1" data-toggle="tab">ALL <small class="label pull-right bg-blue" style="margin-left:5px;">{{$count_all_jadwal}}</small></a></li>
									<li><a href="#tab_2" data-toggle="tab">Complete <small class="label pull-right bg-green" style="margin-left:5px;">{{$count_complete_jadwal}}</small></a></li>
									<li><a href="#tab_3" data-toggle="tab">No Report <small class="label pull-right bg-red" style="margin-left:5px;">{{$count_no_report_jadwal}}</small></a></li>
									<li><a href="#tab_4" data-toggle="tab">Upcoming <small class="label pull-right bg-gray" style="margin-left:5px;">{{$count_upcoming_jadwal}}</small></a></li>
								</ul>
								<div class="tab-content">
									<div class="tab-pane active" id="tab_1">
										<table id="data_jadwal" class="table table-bordered table-hover">
											<thead>
												<tr>
													<th>Nama Projek</th>
													<th>Subjek</th>
													<th>Nama Pembuat</th>
													<th>Tanggal</th>
													<th>Waktu</th>
													<th>Aksi</th>
												</tr>
											</thead>
											<tbody>
											<?php  ?>
												@foreach($data_jadwal as $row)
												<tr class="<?php echo ($row->Laporan_selesai == 0) ? 'danger': ''; ?>">
													<td>{{ $row->project->Nama_project }}</td>
													<td>{{ $row->Subjek }}</td>
													<td>{{ $row->Nama_pembuat }}</td>
													<td>{{ change_date($row->Tanggal_jadwal) }}</td>
													<td>{{ $row->Waktu_jadwal }}</td>
													<td>
														<div class="btn-group">
															<button type="button" class="btn btn-sm btn-info dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
																Aksi <span class="caret"></span>
															</button>
															<ul class="dropdown-menu pull-right" role="menu">
																@if($row->Laporan_selesai == 0)	
																	<li>
																	@if($row->Jenis_laporan == "Instalasi")								
																		<a href="instalation_report/{{ $row->Jadwal_ID }}"><i class="fa fa-pencil-square-o" style="color:green;"></i>Buat Laporan</a>
																	@elseif($row->Jenis_laporan == "Maintenance")
																		<a href="maintenance_report/{{ $row->Jadwal_ID }}"><i class="fa fa-pencil-square-o" style="color:green;"></i>Buat Laporan</a>
																	@elseif($row->Jenis_laporan == "Troubleshoot")
																		<a href="troubleshoot_report/{{ $row->Jadwal_ID }}"><i class="fa fa-pencil-square-o" style="color:green;"></i>Buat Laporan</a>
																	@else
																		<a href="trainning_report/{{ $row->Jadwal_ID }}"><i class="fa fa-pencil-square-o" style="color:green;"></i>Buat Laporan</a>	
																	@endif
																	</li>
																@else
																	<li>
																	@if($row->Jenis_laporan == "Instalasi" && $row->ID_laporan != "")								
																		<a href="detail_instalation_report/{{ $row->ID_laporan }}"><span class="glyphicon glyphicon-list-alt" style="color:blue;"></span>Lihat Laporan</a>
																	@elseif($row->Jenis_laporan == "Maintenance" && $row->ID_laporan != "")
																		<a href="detail_maintenance_report/{{ $row->ID_laporan }}"><span class="glyphicon glyphicon-list-alt" style="color:blue;"></span>Lihat Laporan</a>
																	@elseif($row->Jenis_laporan == "Troubleshoot" && $row->ID_laporan != "")
																		<a href="detail_troubleshoot_report/{{ $row->ID_laporan }}"><span class="glyphicon glyphicon-list-alt" style="color:blue;"></span>Lihat Laporan</a>
																	@elseif($row->Jenis_laporan == "Trainning" && $row->ID_laporan != "")
																		<a href="detail_trainning_report/{{ $row->ID_laporan }}"><span class="glyphicon glyphicon-list-alt" style="color:blue;"></span>Lihat Laporan</a>	
																	@endif
																	</li>
																@endif
																	<li>
																	<a href="#member_schedule" data-toggle='modal' onclick="detail_member({{ $row->Jadwal_ID }})"><i class="fa fa-group" style="color:blue;"></i>Detail Member</a>
																	</li>
																	@if(Session::get('user_login_data')->Jabatan_ID == 1 || Session::get('user_login_data')->Jabatan_ID == 3 || Session::get('user_login_data')->Jabatan_ID == 4)
																		<li>
																		<a href="#detail_schedule" data-toggle='modal' onclick="detail_schedule({{ $row->Jadwal_ID }})"><span class="glyphicon glyphicon-list-alt" style="color:blue;"></span>Detail Jadwal</a>
																		</li>
																		@if($row->Laporan_selesai == 0)
																			<li>
																			<a href="#edit_schedule" data-toggle='modal' onclick="edit_schedule({{ $row->Jadwal_ID }})"><i class="fa fa-edit"></i>Ubah</a>
																			</li>
																			<li>
																			<a href="delete_schedule/{{ $row->Jadwal_ID }}"><i class="fa fa-trash-o" style="color:red;"></i>Hapus</a>
																			</li>
																		@endif
																	@endif
															</ul>
														</div>
														
													</td>
												</tr>
												@endforeach	
											</tbody>
										</table>
									</div><!-- /.tab-pane -->
									<div class="tab-pane" id="tab_2">
										<table id="data_complete" class="table table-bordered table-hover">
											<thead>
												<tr>
													<th>Nama Projek</th>
													<th>Subjek</th>
													<th>Nama Pembuat</th>
													<th>Tanggal</th>
													<th>Waktu</th>
													<th>Aksi</th>
												</tr>
											</thead>
											<tbody>
											<?php  ?>
												@foreach($data_complete_jadwal as $row)
												<tr>
													<td>{{ $row->project->Nama_project }}</td>
													<td>{{ $row->Subjek }}</td>
													<td>{{ $row->Nama_pembuat }}</td>
													<td>{{ change_date($row->Tanggal_jadwal) }}</td>
													<td>{{ $row->Waktu_jadwal }}</td>
													<td>
														<div class="btn-group">
															<button type="button" class="btn btn-sm btn-info dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
																Aksi <span class="caret"></span>
															</button>
															<ul class="dropdown-menu pull-right" role="menu">
																@if($row->Laporan_selesai == 0)	
																	<li>
																	@if($row->Jenis_laporan == "Instalasi")								
																		<a href="instalation_report/{{ $row->Jadwal_ID }}"><i class="fa fa-pencil-square-o" style="color:green;"></i>Buat Laporan</a>
																	@elseif($row->Jenis_laporan == "Maintenance")
																		<a href="maintenance_report/{{ $row->Jadwal_ID }}"><i class="fa fa-pencil-square-o" style="color:green;"></i>Buat Laporan</a>
																	@elseif($row->Jenis_laporan == "Troubleshoot")
																		<a href="troubleshoot_report/{{ $row->Jadwal_ID }}"><i class="fa fa-pencil-square-o" style="color:green;"></i>Buat Laporan</a>
																	@else
																		<a href="trainning_report/{{ $row->Jadwal_ID }}"><i class="fa fa-pencil-square-o" style="color:green;"></i>Buat Laporan</a>	
																	@endif
																	</li>
																@else
																	<li>
																	@if($row->Jenis_laporan == "Instalasi" && $row->ID_laporan != "")								
																		<a href="detail_instalation_report/{{ $row->ID_laporan }}"><span class="glyphicon glyphicon-list-alt" style="color:blue;"></span>Lihat Laporan</a>
																	@elseif($row->Jenis_laporan == "Maintenance" && $row->ID_laporan != "")
																		<a href="detail_maintenance_report/{{ $row->ID_laporan }}"><span class="glyphicon glyphicon-list-alt" style="color:blue;"></span>Lihat Laporan</a>
																	@elseif($row->Jenis_laporan == "Troubleshoot" && $row->ID_laporan != "")
																		<a href="detail_troubleshoot_report/{{ $row->ID_laporan }}"><span class="glyphicon glyphicon-list-alt" style="color:blue;"></span>Lihat Laporan</a>
																	@elseif($row->Jenis_laporan == "Trainning" && $row->ID_laporan != "")
																		<a href="detail_trainning_report/{{ $row->ID_laporan }}"><span class="glyphicon glyphicon-list-alt" style="color:blue;"></span>Lihat Laporan</a>	
																	@endif
																	</li>
																@endif
																	<li>
																	<a href="#member_schedule" data-toggle='modal' onclick="detail_member({{ $row->Jadwal_ID }})"><i class="fa fa-group" style="color:blue;"></i>Detail Member</a>
																	</li>
																	@if(Session::get('user_login_data')->Jabatan_ID == 1 || Session::get('user_login_data')->Jabatan_ID == 3 || Session::get('user_login_data')->Jabatan_ID == 4)
																		<li>
																		<a href="#detail_schedule" data-toggle='modal' onclick="detail_schedule({{ $row->Jadwal_ID }})"><span class="glyphicon glyphicon-list-alt" style="color:blue;"></span>Detail Jadwal</a>
																		</li>
																		@if($row->Laporan_selesai == 0)
																			<li>
																			<a href="#edit_schedule" data-toggle='modal' onclick="edit_schedule({{ $row->Jadwal_ID }})"><i class="fa fa-edit"></i>Ubah</a>
																			</li>
																			<li>
																			<a href="delete_schedule/{{ $row->Jadwal_ID }}"><i class="fa fa-trash-o" style="color:red;"></i>Hapus</a>
																			</li>
																		@endif
																	@endif
															</ul>
														</div>
														
													</td>
												</tr>
												@endforeach	
											</tbody>
										</table>
									</div>
									<div class="tab-pane" id="tab_3">
										<table id="data_no_report" class="table table-bordered table-hover">
											<thead>
												<tr>
													<th>Nama Projek</th>
													<th>Subjek</th>
													<th>Nama Pembuat</th>
													<th>Tanggal</th>
													<th>Waktu</th>
													<th>Aksi</th>
												</tr>
											</thead>
											<tbody>
											<?php  ?>
												@foreach($data_no_report_jadwal as $row)
												<tr>
													<td>{{ $row->project->Nama_project }}</td>
													<td>{{ $row->Subjek }}</td>
													<td>{{ $row->Nama_pembuat }}</td>
													<td>{{ change_date($row->Tanggal_jadwal) }}</td>
													<td>{{ $row->Waktu_jadwal }}</td>
													<td>
														<div class="btn-group">
															<button type="button" class="btn btn-sm btn-info dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
																Aksi <span class="caret"></span>
															</button>
															<ul class="dropdown-menu pull-right" role="menu">
																@if($row->Laporan_selesai == 0)	
																	<li>
																	@if($row->Jenis_laporan == "Instalasi")								
																		<a href="instalation_report/{{ $row->Jadwal_ID }}"><i class="fa fa-pencil-square-o" style="color:green;"></i>Buat Laporan</a>
																	@elseif($row->Jenis_laporan == "Maintenance")
																		<a href="maintenance_report/{{ $row->Jadwal_ID }}"><i class="fa fa-pencil-square-o" style="color:green;"></i>Buat Laporan</a>
																	@elseif($row->Jenis_laporan == "Troubleshoot")
																		<a href="troubleshoot_report/{{ $row->Jadwal_ID }}"><i class="fa fa-pencil-square-o" style="color:green;"></i>Buat Laporan</a>
																	@else
																		<a href="trainning_report/{{ $row->Jadwal_ID }}"><i class="fa fa-pencil-square-o" style="color:green;"></i>Buat Laporan</a>	
																	@endif
																	</li>
																@else
																	<li>
																	@if($row->Jenis_laporan == "Instalasi" && $row->ID_laporan != "")								
																		<a href="detail_instalation_report/{{ $row->ID_laporan }}"><span class="glyphicon glyphicon-list-alt" style="color:blue;"></span>Lihat Laporan</a>
																	@elseif($row->Jenis_laporan == "Maintenance" && $row->ID_laporan != "")
																		<a href="detail_maintenance_report/{{ $row->ID_laporan }}"><span class="glyphicon glyphicon-list-alt" style="color:blue;"></span>Lihat Laporan</a>
																	@elseif($row->Jenis_laporan == "Troubleshoot" && $row->ID_laporan != "")
																		<a href="detail_troubleshoot_report/{{ $row->ID_laporan }}"><span class="glyphicon glyphicon-list-alt" style="color:blue;"></span>Lihat Laporan</a>
																	@elseif($row->Jenis_laporan == "Trainning" && $row->ID_laporan != "")
																		<a href="detail_trainning_report/{{ $row->ID_laporan }}"><span class="glyphicon glyphicon-list-alt" style="color:blue;"></span>Lihat Laporan</a>	
																	@endif
																	</li>
																@endif
																	<li>
																	<a href="#member_schedule" data-toggle='modal' onclick="detail_member({{ $row->Jadwal_ID }})"><i class="fa fa-group" style="color:blue;"></i>Detail Member</a>
																	</li>
																	@if(Session::get('user_login_data')->Jabatan_ID == 1 || Session::get('user_login_data')->Jabatan_ID == 3 || Session::get('user_login_data')->Jabatan_ID == 4)
																		<li>
																		<a href="#detail_schedule" data-toggle='modal' onclick="detail_schedule({{ $row->Jadwal_ID }})"><span class="glyphicon glyphicon-list-alt" style="color:blue;"></span>Detail Jadwal</a>
																		</li>
																		@if($row->Laporan_selesai == 0)
																			<li>
																			<a href="#edit_schedule" data-toggle='modal' onclick="edit_schedule({{ $row->Jadwal_ID }})"><i class="fa fa-edit"></i>Ubah</a>
																			</li>
																			<li>
																			<a href="delete_schedule/{{ $row->Jadwal_ID }}"><i class="fa fa-trash-o" style="color:red;"></i>Hapus</a>
																			</li>
																		@endif
																	@endif
															</ul>
														</div>
														
													</td>
												</tr>
												@endforeach	
											</tbody>
										</table>
									</div>
									<div class="tab-pane" id="tab_4">
										<table id="data_upcoming" class="table table-bordered table-hover">
											<thead>
												<tr>
													<th>Nama Projek</th>
													<th>Subjek</th>
													<th>Nama Pembuat</th>
													<th>Tanggal</th>
													<th>Waktu</th>
													<th>Aksi</th>
												</tr>
											</thead>
											<tbody>
											<?php  ?>
												@foreach($data_upcoming_jadwal as $row)
												<tr>
													<td>{{ $row->project->Nama_project }}</td>
													<td>{{ $row->Subjek }}</td>
													<td>{{ $row->Nama_pembuat }}</td>
													<td>{{ change_date($row->Tanggal_jadwal) }}</td>
													<td>{{ $row->Waktu_jadwal }}</td>
													<td>
														<div class="btn-group">
															<button type="button" class="btn btn-sm btn-info dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
																Aksi <span class="caret"></span>
															</button>
															<ul class="dropdown-menu pull-right" role="menu">
																@if($row->Laporan_selesai == 0)	
																	<li>
																	@if($row->Jenis_laporan == "Instalasi")								
																		<a href="instalation_report/{{ $row->Jadwal_ID }}"><i class="fa fa-pencil-square-o" style="color:green;"></i>Buat Laporan</a>
																	@elseif($row->Jenis_laporan == "Maintenance")
																		<a href="maintenance_report/{{ $row->Jadwal_ID }}"><i class="fa fa-pencil-square-o" style="color:green;"></i>Buat Laporan</a>
																	@elseif($row->Jenis_laporan == "Troubleshoot")
																		<a href="troubleshoot_report/{{ $row->Jadwal_ID }}"><i class="fa fa-pencil-square-o" style="color:green;"></i>Buat Laporan</a>
																	@else
																		<a href="trainning_report/{{ $row->Jadwal_ID }}"><i class="fa fa-pencil-square-o" style="color:green;"></i>Buat Laporan</a>	
																	@endif
																	</li>
																@else
																	<li>
																	@if($row->Jenis_laporan == "Instalasi" && $row->ID_laporan != "")								
																		<a href="detail_instalation_report/{{ $row->ID_laporan }}"><span class="glyphicon glyphicon-list-alt" style="color:blue;"></span>Lihat Laporan</a>
																	@elseif($row->Jenis_laporan == "Maintenance" && $row->ID_laporan != "")
																		<a href="detail_maintenance_report/{{ $row->ID_laporan }}"><span class="glyphicon glyphicon-list-alt" style="color:blue;"></span>Lihat Laporan</a>
																	@elseif($row->Jenis_laporan == "Troubleshoot" && $row->ID_laporan != "")
																		<a href="detail_troubleshoot_report/{{ $row->ID_laporan }}"><span class="glyphicon glyphicon-list-alt" style="color:blue;"></span>Lihat Laporan</a>
																	@elseif($row->Jenis_laporan == "Trainning" && $row->ID_laporan != "")
																		<a href="detail_trainning_report/{{ $row->ID_laporan }}"><span class="glyphicon glyphicon-list-alt" style="color:blue;"></span>Lihat Laporan</a>	
																	@endif
																	</li>
																@endif
																	<li>
																	<a href="#member_schedule" data-toggle='modal' onclick="detail_member({{ $row->Jadwal_ID }})"><i class="fa fa-group" style="color:blue;"></i>Detail Member</a>
																	</li>
																	@if(Session::get('user_login_data')->Jabatan_ID == 1 || Session::get('user_login_data')->Jabatan_ID == 3 || Session::get('user_login_data')->Jabatan_ID == 4)
																		<li>
																		<a href="#detail_schedule" data-toggle='modal' onclick="detail_schedule({{ $row->Jadwal_ID }})"><span class="glyphicon glyphicon-list-alt" style="color:blue;"></span>Detail Jadwal</a>
																		</li>
																		@if($row->Laporan_selesai == 0)
																			<li>
																			<a href="#edit_schedule" data-toggle='modal' onclick="edit_schedule({{ $row->Jadwal_ID }})"><i class="fa fa-edit"></i>Ubah</a>
																			</li>
																			<li>
																			<a href="delete_schedule/{{ $row->Jadwal_ID }}"><i class="fa fa-trash-o" style="color:red;"></i>Hapus</a>
																			</li>
																		@endif
																	@endif
															</ul>
														</div>
														
													</td>
												</tr>
												@endforeach	
											</tbody>
										</table>
									</div>
								</div>
							</div>
			            </div>
					</div><!-- /.row -->
				</div><!-- ./box-body -->
				</div><!-- /.box -->
			</div>
		</div>
		
		<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top:3px;"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Tambah Jadwal</h4>
			</div>
			<div class="modal-body">
				{!! Form::open(array('ng-app' => 'MyApp', 'novalidate' => 'novalidate', 'ng-controller' => 'FormController', 'name' => 'schedule_form', 'action' => 'ScheduleController@add_schedule')) !!}
					<div class="form-group">
						<div class="form-inline">
						<label>Nama Pembuat Jadwal</label>
						</div>
						<input type="text" class="form-control" value="{{Session::get('user_login_data')->Nama_karyawan}}" disabled>
					</div>
					<div class="form-group">
						<label>Tipe Jadwal</label>
						<select class="form-control" name="schedule_type_text">
							<option value="Instalasi" <?php echo (Form::old('schedule_type_text') == "Instalasi") ? 'selected': ''; ?>>Instalasi</option>
							<option value="Maintenance" <?php echo (Form::old('schedule_type_text') == "Maintenance") ? 'selected': ''; ?>>Maintenance</option>
							<option value="Troubleshoot" <?php echo (Form::old('schedule_type_text') == "Troubleshoot") ? 'selected': ''; ?>>Troubleshoot</option>
							<option value="Trainning" <?php echo (Form::old('schedule_type_text') == "Trainning") ? 'selected': ''; ?>>Trainning</option>
						</select>
					</div>
					<div class="form-group">
						<label>Nama Project</label>
						<select class="form-control" id="project_name_text" name="project_name_text">
							@foreach ($data_project as $project)
								<option value="{{$project->Project_ID}}" <?php echo (Form::old('project_name_text') == $project->Project_ID) ? 'selected': ''; ?>>{{$project->Nama_project}}</option>
							@endforeach
						</select>
					</div>
					<div class="form-group" ng-class="{ 'has-error' : ( schedule_form.subject_text.$invalid && !schedule_form.subject_text.$pristine ) || schedule_form.subject_text.$error.minlength }">
						<div class="form-inline">
							<label>Subjek</label>
							<label style="color:red;font-size:x-small;" ng-show="schedule_form.subject_text.$error.required && !schedule_form.subject_text.$pristine">Subject is required.</label>
							<label style="color:red;font-size:x-small;" ng-show="schedule_form.subject_text.$error.minlength">Minimal 3 character.</label>
							<label style="color:red;font-size:x-small;"><?=$errors->first('subject_text');?></label>
						</div>
						<input type="text" class="form-control" name="subject_text" placeholder="Subject dari jadwal" ng-model="subject_text" ng-minlength="3" required>
					</div>
					<div class="form-group" ng-class="{ 'has-error' : ( schedule_form.schedule_date_text.$invalid && !schedule_form.schedule_date_text.$pristine ) || schedule_form.schedule_date_text.$error.minlength }">
							<div class="form-inline">
							<label>Tanggal Jadwal</label>
							<label style="color:red;font-size:x-small;" ng-show="schedule_form.schedule_date_text.$error.required && !schedule_form.schedule_date_text.$pristine">Schedule date is required.</label>
							<label style="color:red;font-size:x-small;" ng-show="schedule_form.schedule_date_text.$error.minlength || schedule_form.schedule_date_text.$error.maxlength">Must 10 character.</label>
							<label style="color:red;font-size:x-small;"><?=$errors->first('schedule_date_text');?></label>
							</div>
							<input type="text" id="datepicker" class="form-control" name="schedule_date_text" placeholder="Tanggal jadwal di laksanakan" ng-model="schedule_date_text" ng-minlength="10" ng-maxlength="10" required/>
					</div>
					<div class="form-group"  ng-class="{ 'has-error' : ( schedule_form.schedule_time_text.$invalid && !schedule_form.schedule_time_text.$pristine ) || schedule_form.schedule_time_text.$error.minlength }">
						<div class="form-inline">
							<label>Waktu Jadwal</label>
							<label style="color:red;font-size:x-small;" ng-show="schedule_form.schedule_time_text.$error.required && !schedule_form.schedule_time_text.$pristine">Schedule time is required.</label>
							<label style="color:red;font-size:x-small;" ng-show="schedule_form.schedule_time_text.$error.minlength || schedule_form.schedule_time_text.$error.maxlength">Must 8 character.</label>
							<label style="color:red;font-size:x-small;"><?=$errors->first('schedule_time_text');?></label>
						</div>
						<input type="text" class="form-control" name="schedule_time_text" placeholder="Waktu jadwal di laksanakan ( 00:00:00 - 23:59:59 )" ng-model="schedule_time_text" ng-minlength="8" ng-maxlength="8" required/>
                    </div>
					<div class="form-group" ng-class="{ 'has-error' : ( schedule_form.description_text.$invalid && !schedule_form.description_text.$pristine ) || schedule_form.description_text.$error.minlength }">
						<div class="form-inline">
							<label>Deskripsi</label>
							<label style="color:red;font-size:x-small;" ng-show="schedule_form.description_text.$error.required && !schedule_form.description_text.$pristine">Description is required.</label>
							<label style="color:red;font-size:x-small;" ng-show="schedule_form.description_text.$error.minlength">Minimal 5 character.</label>
							<label style="color:red;font-size:x-small;"><?=$errors->first('description_text');?></label>
						</div>
						<textarea class="form-control" name="description_text" rows="3" placeholder="Deskripsi jadwal untuk meperjelas pekerjaan pada jadwal . . ." style="resize:none;" ng-model="description_text" ng-minlength="5" required></textarea>
					</div>
					<div class="form-group">
							<label>Nama Peserta</label><br/>
							<?php
								$no = 1;
								$data_checked = Session::get('data_checked');
								Session::forget('data_checked');
							?>
							@foreach ($data_karyawan as $karyawan)
								@if($karyawan->Karyawan_ID != 1)
								<input type="checkbox" class="minimal" name="karyawan_id{{$no}}" value="{{$karyawan->Karyawan_ID}}" <?php echo ($data_checked[$no] == 1) ? 'checked': ''; ?>/> {{$karyawan->Nama_karyawan}} <br/>
								<?php
									$no++;
								?>
								@endif
							@endforeach
							<input type="hidden" name="no" value="{{$no}}">
					</div>
					<hr>
					<center><button type="submit" ng-disabled="schedule_form.$invalid" class="btn btn-info">Submit</button></center>
				{!! Form::close() !!}
			</div>
		</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
		
		<div class="modal fade" id="detail_schedule" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top:3px;"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Detail jadwal</h4>
			</div>
			<div class="modal-body">
				<center>{!! HTML::image('img/loading.gif', 'Loading image', array('class' => 'img-responsive','id'=>'loading_detail_schedule')) !!}</center>
				<div id="response_detail_schedule"></div> <!--untuk menaruh hasil response-->
			</div>
		</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
		
		<div class="modal fade" id="edit_schedule" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top:3px;"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Ubah jadwal</h4>
			</div>
			<div class="modal-body">
				<center>{!! HTML::image('img/loading.gif', 'Loading image', array('class' => 'img-responsive','id'=>'loading_edit_schedule')) !!}</center>
				<div id="response_edit_schedule"></div> <!--untuk menaruh hasil response-->
			</div>
		</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
		
		<div class="modal fade" id="member_schedule" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top:3px;"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Member</h4>
			</div>
			<div class="modal-body">
				<center>{!! HTML::image('img/loading.gif', 'Loading image', array('class' => 'img-responsive','id'=>'loading_member_schedule')) !!}</center>
				<div id="response_member_schedule"></div> <!--untuk menaruh hasil response-->
			</div>
		</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
		
		</section>
		
		<?php
			$error = Session::get('error_schedule');
			if(!empty($error)){
		?>
			<script>
				alert("{{$error}}");
			</script>
		<?php
			Session::forget('error_schedule');
			}
		?>
		
		<script>
			var year=new Date().getFullYear();
			var yearTo=year+10;
			var yearFrom=year-50;
			
			$( "#datepicker" ).datepicker({
				changeMonth: true,
				changeYear: true,
				yearRange: yearFrom+":"+yearTo,
				dateFormat: "yy-mm-dd"
			});
			
			$("#data_jadwal, #data_complete, #data_no_report, #data_upcoming").dataTable({
				"bPaginate": true,
				"bLengthChange": true,
				"bFilter": true,
				"bSort": true,
				"bInfo": true,
				"bAutoWidth": true,
				"aaSorting": [],
			});
			
			var myapp = angular.module('MyApp', []);

			myapp.controller('FormController', function($scope){
				$scope.subject_text = '{!!Form::old('subject_text')!!}';
				$scope.schedule_date_text = '{!!Form::old('schedule_date_text')!!}';
				$scope.schedule_time_text = '{!!Form::old('schedule_time_text')!!}';
				$scope.description_text = '{!!Form::old('description_text')!!}';
			})
			
			function detail_schedule(ID){
				$.ajaxSetup({
					cache: false,
					beforeSend: function() {
						$('#response_detail_schedule').hide();
						$('#loading_detail_schedule').show();
					},
					complete: function() {
						$('#loading_detail_schedule').hide();
						$('#response_detail_schedule').show();
					},
					success: function() {
						$('#loading_detail_schedule').hide();
						$('#response_detail_schedule').show();
					}
				});
				$.ajax();
				var xmlhttp;  
				if (ID=="")
				{
					alert("ID not found");
				}
				else{
					if (window.XMLHttpRequest)
					{// code for IE7+, Firefox, Chrome, Opera, Safari
						xmlhttp=new XMLHttpRequest();
					}
					else
					{// code for IE6, IE5
						xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
					}
					
					xmlhttp.onreadystatechange=function()
					{
						if (xmlhttp.readyState==4 && xmlhttp.status==200)
						{
							document.getElementById("response_detail_schedule").innerHTML=xmlhttp.responseText;
						}
					}
					xmlhttp.open("GET","get_detail_schedule/"+ID,true);
					xmlhttp.send();
				}
			}
			
			function edit_schedule(ID){
				$.ajaxSetup({
					cache: false,
					beforeSend: function() {
						$('#response_edit_schedule').hide();
						$('#loading_edit_schedule').show();
					},
					complete: function() {
						$('#loading_edit_schedule').hide();
						$('#response_edit_schedule').show();
					},
					success: function() {
						$('#loading_edit_schedule').hide();
						$('#response_edit_schedule').show();
					}
				});
				$.ajax();
				var xmlhttp;  
				if (ID=="")
				{
					alert("ID not found");
				}
				else{
					if (window.XMLHttpRequest)
					{// code for IE7+, Firefox, Chrome, Opera, Safari
						xmlhttp=new XMLHttpRequest();
					}
					else
					{// code for IE6, IE5
						xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
					}
					
					xmlhttp.onreadystatechange=function()
					{
						if (xmlhttp.readyState==4 && xmlhttp.status==200)
						{
							document.getElementById("response_edit_schedule").innerHTML=xmlhttp.responseText;
						}
					}
					xmlhttp.open("GET","get_edit_schedule/"+ID,true);
					xmlhttp.send();
				}
			}
			
			function detail_member(ID){
				$.ajaxSetup({
					cache: false,
					beforeSend: function() {
						$('#response_member_schedule').hide();
						$('#loading_member_schedule').show();
					},
					complete: function() {
						$('#loading_member_schedule').hide();
						$('#response_member_schedule').show();
					},
					success: function() {
						$('#loading_member_schedule').hide();
						$('#response_member_schedule').show();
					}
				});
				$.ajax();
				var xmlhttp;  
				if (ID=="")
				{
					alert("ID not found");
				}
				else{
					if (window.XMLHttpRequest)
					{// code for IE7+, Firefox, Chrome, Opera, Safari
						xmlhttp=new XMLHttpRequest();
					}
					else
					{// code for IE6, IE5
						xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
					}
					
					xmlhttp.onreadystatechange=function()
					{
						if (xmlhttp.readyState==4 && xmlhttp.status==200)
						{
							document.getElementById("response_member_schedule").innerHTML=xmlhttp.responseText;
						}
					}
					xmlhttp.open("GET","get_detail_member_schedule/"+ID,true);
					xmlhttp.send();
				}
			}
		</script>
	</div>
@stop

