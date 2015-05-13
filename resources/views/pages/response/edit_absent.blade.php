<?php 
	$karyawan_object = new \App\Model\Karyawan(); 
	function change_date($date){
			$exploded_date = explode('-',$date);
			$array = array($exploded_date[2],$exploded_date[1],$exploded_date[0]);
			$today_date = implode('-',$array);
			return $today_date;
		}
?>

{!! Form::open(array('name' => 'absen_form', 'action' => 'AbsentController@edit_absent')) !!}
	<div class="form-group">
		<div class="form-inline">
		<label>Nama Karyawan</label>
		</div>
		<input type="text" class="form-control" value="{{ $karyawan_object::find($absents->Karyawan_ID)->Nama_karyawan }}" disabled>
	</div>
	<div class="form-group">
		<label>Tanggal</label>
		<input type="text" class="form-control" value="{{ change_date($absents->Tanggal_absen) }}" readonly>
	</div>
	<div class="form-group">
		<label>Tipe Absen</label>
		<select class="form-control" name="absen_type_text">
		<option value="Masuk" <?php echo ($absents->Tipe_absen == "Masuk") ? 'selected': ''; ?>>Masuk</option>
		<option value="Cuti" <?php echo ($absents->Tipe_absen == "Cuti") ? 'selected': ''; ?>>Cuti</option>
		<option value="Sakit" <?php echo ($absents->Tipe_absen == "Sakit") ? 'selected': ''; ?>>Sakit</option>
		</select>
	</div>
	<div class="form-group">
		<label>Lokasi</label>
		<input type="text" class="form-control" value="{{ $absents->Lokasi }}" name="lokasi_text">
	</div>
	<div class="form-group">
		<label>Waktu Datang</label>
		<input type="text" class="form-control" value="{{ $absents->Waktu_masuk }}" name="Waktu_datang_text">
	</div>
	<div class="form-group">
		<label>Waktu Pulang</label>
		<input type="text" class="form-control" value="{{ $absents->Waktu_pulang }}" name="Waktu_pulang_text">
	</div>
	<div class="form-group">
		<label>Keterangan</label>
		<textarea class="form-control" name="keterangan_text" rows="3" placeholder="Masukan Keterangan anda . . ." style="resize:none;">{{ $absents->Keterangan }}</textarea>
	</div>
	<div class="form-group">
		<label>Keterangan Pulang</label>
		<textarea class="form-control" name="keterangan_pulang_text" rows="3" placeholder="Masukan Keterangan anda . . ." style="resize:none;">{{ $absents->Keterangan_pulang }}</textarea>
	</div>
	<hr>
	<input type="hidden" name="Absensi_ID" value="{{ $absents->Absensi_ID }}" >
	<center><button type="submit" class="btn btn-info">Submit</button></center>
{!! Form::close() !!}