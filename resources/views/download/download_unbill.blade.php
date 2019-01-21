@extends('layouts.apps')

@section('content')
<div class="container">
	<h3 class="text-center">Download file Pohon Revenue UnBill</h3>
	<hr>
	<table class="table table-striped table-dark table-bordered table-hover">
		<caption>*urutan kecepatan download dari yang paling cepat ( txt -> csv -> xlsx )<br></caption>
		 <thead>
		    <tr>
		      	<th scope="col">#</th>
		      	<th scope="col">Bulan</th>
		      	<th class="text-center" scope="col">Download (ekstensi)*</th>
		    </tr>
		</thead>
	  	<tbody>
		  	@php
		  		$n=1;
		  	@endphp
		  	@for($i = 0 ; $i < count($bulans) ; $i++)
			    <tr>
			      	<td>{{ $n++ }}</td>
			      	<td class="text-capitalize">{{ $bulans[$i] }}</td>
			      	<td align="center">
			      		<a class="btn btn-warning btn-sm m-2" href="{{ url("download/unbill/$bulans[$i]/txt") }}" target="_blank" role="button">txt</a>
			      		<a class="btn btn-primary btn-sm m-2" href="{{ url("download/unbill/$bulans[$i]/csv") }}" target="_blank" role="button">csv</a>
			      		<a class="btn btn-success btn-sm m-2" href="{{ url("download/unbill/$bulans[$i]/xlsx") }}" target="_blank" role="button">xlsx</a>
			      	</td>
			    </tr>
		    @endfor
		 </tbody>
	</table>
</div>
@endsection

@section('script')
<script>
	$('#item-download2').addClass('active');
	$('#ui-basic5').collapse('show');
</script>
@endsection