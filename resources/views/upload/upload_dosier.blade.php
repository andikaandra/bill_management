@extends('layouts.apps')

@section('content')
<div class="container">
	<h3 class="text-center">Upload file Dosier</h3>
	<hr>
	@if($errors->any())
		<div class="alert alert-warning" role="alert">
			{!!$errors->first()!!}
		</div>		
	@endif
  	<h2 class="text-center"></h2>
	<form action="{{ route('upload.dosier') }}" method="post">
   	@csrf
	  	<div class="form-group">
	    	<label for="exampleInputPassword1">Nama File Dosier</label>
	    	<input type="text" name="revenue" class="form-control" id="exampleInputPassword1" placeholder="namafile.txt" required>
	  	</div>
	  	<div class="form-group">
	    	<label for="exampleInputPassword1">Bulan</label>
			<select class="form-control" name="bulan" required>
			  	<option value="januari">Januari</option>
			  	<option value="februari">Februari</option>
			  	<option value="maret">Maret</option>
			  	<option value="april">April</option>
			  	<option value="mei">Mei</option>
			  	<option value="juni">Juni</option>
			  	<option value="juli">Juli</option>
			  	<option value="agustus">Agustus</option>
			  	<option value="september">September</option>
			  	<option value="oktober">Oktober</option>
			  	<option value="november">November</option>
			  	<option value="desember">Desember</option>
			</select>
	  	</div>
  		<button type="submit" class="btn btn-primary">Upload</button>
	</form>
  	<br>
	<div class="alert alert-success" role="alert">
	  <h4 class="alert-heading text-danger">Note!</h4>
	  <p class="mb-0">- File harus berupa .txt (delimiter '|')</p>
	  <p class="mb-0">- Jika anda mengupload data, maka data yang lama akan digantikan oleh data yang baru</p>
	  <p class="mb-0">- Sistem hanya akan mencatat kolom sebagai berikut. kolom lainnya akan diabaikan</p>
	  <hr>
	  <div class="row">
	  	<div class="col">
		  	<ul>
		  		<li>NCLI</li> 
		  		<li>ND</li> 
		  		<li>ND_REFERENCE</li> 
		  		<li>NAMA</li> 
		  		<li>DATEL</li> 
		  		<li>CMDF</li> 
		  		<li>RK</li> 
		  		<li>DP</li> 
		  	</ul>
	  	</div>
	  	<div class="col">
		  	<ul>
		  		<li>LGEST</li> 
		  		<li>LCAT</li> 
		  		<li>LCOM</li> 
		  		<li>CQUARTIER</li> 
		  		<li>LQUARTIER</li> 
		  		<li>CPOSTAL</li> 
		  		<li>LVOIE</li> 
		  		<li>NVOIE</li> 
		  	</ul>
	  	</div>
	  	<div class="col">
		  	<ul>
		  		<li>BAT</li> 
		  		<li>RP_TAGIHAN</li> 
		  		<li>TUNDA_CABUT</li> 
		  		<li>LART</li> 
		  		<li>LTARIF</li> 
		  		<li>KWADRAN</li> 
		  		<li>KWADRAN_POTS</li> 
		  		<li>IS_IPTV</li> 
		  	</ul>
	  	</div>
	  </div>
	</div>
</div>
@endsection

@section('script')
<script>
	$('#item-upload3').addClass('active');
	$('#ui-basic4').collapse('show');
</script>
@endsection