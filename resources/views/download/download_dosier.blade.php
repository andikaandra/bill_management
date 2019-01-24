@extends('layouts.apps')

@section('content')
<div class="container">
	<h3 class="text-center">Download file Dosier</h3>
	<hr>
	<div class="row justify-content-md-center">
	 	<div class="col-12">
	    	<div class="card">
	      		<div class="card-body">
			        <table class="table table-bordered table-striped">
					<caption>*urutan kecepatan download dari yang paling cepat ( txt -> csv -> xlsx )<br></caption>
					 <thead>
					    <tr>
					      	<th scope="col">#</th>
					      	<th scope="col">Bulan</th>
					      	<th class="text-center" scope="col">Download Original (ekstensi)*</th>
					      	<th class="text-center" scope="col">Download Lookup (ekstensi)*</th>
					      	<th scope="col">Last update</th>
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
							    @if($ketersediaan[$bulans[$i]])
						      	<td align="center">
						      		<a class="btn btn-warning btn-sm m-2" href="{{ url("download/dosier/$bulans[$i]/txt") }}" target="_blank" role="button">txt</a>
						      		<a class="btn btn-primary btn-sm m-2" href="{{ url("download/dosier/$bulans[$i]/csv") }}" target="_blank" role="button">csv</a>
						      		<a class="btn btn-success btn-sm m-2" href="{{ url("download/dosier/$bulans[$i]/xlsx") }}" target="_blank" role="button">xlsx</a>
						      	</td>
						      	<td align="center">
{{-- 						      		<a class="btn btn-warning btn-sm m-2" href="{{ url("download/dosier-mod/$bulans[$i]/txt") }}" target="_blank" role="button">txt</a> --}}
						      		<a class="btn btn-primary btn-sm m-2" href="{{ url("download/dosier-mod/$bulans[$i]/csv") }}" target="_blank" role="button">csv</a>
						      		<a class="btn btn-success btn-sm m-2" href="{{ url("download/dosier-mod/$bulans[$i]/xlsx") }}" target="_blank" role="button">xlsx</a>
						      	</td>
							    <td>{{ \Carbon\Carbon::parse($sync[$bulans[$i]]->updated_at)->format('d/M/Y - G:i:s A')}}</td>
						      	@else
						      	<td align="center"></td>
						      	<td align="center"></td>
						      	<td align="center"></td>
						      	@endif
						    </tr>
					    @endfor
					 	</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('script')
<script>
	$('#item-download3').addClass('active');
	$('#ui-basic5').collapse('show');
</script>
@endsection