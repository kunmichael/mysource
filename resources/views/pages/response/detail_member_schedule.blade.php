<?php 
	$karyawan_object = new \App\Model\Karyawan();
	$no=1;
?>

<table>
@foreach($detail_schedules as $row)
	<tr>
		<td>{{$no}}.</td>
		<td style="padding-left:5px;">{{$karyawan_object::find($row->Karyawan_ID)->Nama_karyawan}}</td>
	</tr>
	<?php $no++;?>
@endforeach
</table>