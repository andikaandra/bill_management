@extends('layouts.apps')

@section('content')
<div class="container">
	<h3 class="text-center">Upload file Unbill</h3>
	<hr>
	@if($errors->any())
		<div class="alert alert-warning" role="alert">
			{!!$errors->first()!!}
		</div>		
	@endif
  	<h2 class="text-center"></h2>
	<form action="{{ route('upload.unbill') }}" method="post">
   	@csrf
	  	<div class="form-group">
	    	<label for="exampleInputPassword1">Nama File Pohon Revenue UnBill</label>
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
	  <p class="mb-0">- File harus berupa .txt</p>
	  <p class="mb-0">- Jika anda mengupload data, maka data yang lama akan digantikan oleh data yang baru</p>
	  <p class="mb-0">- Sistem hanya akan mencatat kolom sebagai berikut. kolom lainnya akan diabaikan</p>
	  <hr>
	  <div class="row">
	  	<div class="col">
		  	<ul>
			  	<li>NPER</li> 
			  	<li>TYPE_POHON</li> 
			  	<li>CCA</li> 
			  	<li>SND</li> 
			  	<li>SND_GROUP</li> 
			  	<li>PRODUK</li> 
			  	<li>BISNIS_AREA</li> 
			  	<li>CATEGORY</li> 
			  	<li>STO_DESC</li> 
			  	<li>DATMS</li> 
			</ul>
	  	</div>
	  	<div class="col">
		  	<ul>
			  	<li>DATRS</li> 
			  	<li>UMUR_PLG</li> 
			  	<li>USAGE_DESC</li> 
			  	<li>PAKET_FBIP</li> 
			  	<li>PAKET_SPEEDY_DESC</li> 
			  	<li>STATUS</li> 
			  	<li>TOTAL_NET</li> 
			  	<li>TOTAL</li> 
			  	<li>PPN</li> 
			  	<li>ABONEMEN</li> 
			</ul>
	  	</div>
	  	<div class="col">
		  	<ul>
			  	<li>PEMAKAIAN</li> 
			  	<li>KREDIT</li> 
			  	<li>DEBIT</li> 
			  	<li>BAYAR</li> 
			  	<li>BAYAR_DESC</li> 
			  	<li>CENTITE</li> 
			  	<li>GROUP_PORTFOLIO</li> 
			  	<li>INDIHOME_DESC</li> 
		  		<li>BUNDLING</li>
		  	</ul>	  		
	  	</div>
	  </div>
	</div>
</div>
@endsection

@section('script')
<script type="text/javascript">
    $(document).ready(function(){
      $("#admin-upload").addClass("active");
      $(".nav-link").removeClass("active");

    });
  </script>
@endsection