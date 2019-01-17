@extends('layouts.apps')

@section('content')
<div class="container">
	<h3 class="text-center">Combine file Dosier bulan N dan Pohon revenue bulan N+1</h3>
	@if($errors->any())
		<div class="alert alert-warning" role="alert">
			{{$errors->first()}}
		</div>		
	@endif
  <h2 class="text-center"></h2>
	<form action="{{ route('test3') }}" method="post">
	   @csrf
	  <div class="form-group">
	    <label for="exampleInputEmail1">Nama file Dosier</label>
	    <input type="text" name="dosier" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="namafile.txt" required>
	  </div>
	  <div class="form-group">
	    <label for="exampleInputPassword1">Nama File Pohon Revenue</label>
	    <input type="text" name="revenue" class="form-control" id="exampleInputPassword1" placeholder="namafile.txt" required>
	  </div>
	  <button type="submit" class="btn btn-primary">Download</button>
	</form>
<!--   <div class="row justify-content-center m-3">
  	<a href="test3" role="button" target="_blank" class="btn btn-primary">Test3</a>
  </div> -->
<!--   <div class="row justify-content-center m-3">
  	<a href="import-fast" role="button" target="_blank" class="btn btn-primary">Test3</a>
  </div> -->
  <br>
</div>
@endsection