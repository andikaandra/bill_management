@extends('layouts.apps')

@section('content')
<div class="container">
	<h3 class="text-center">Upload file Pohon Revenue Bill</h3>
	@if($errors->any())
		<div class="alert alert-warning" role="alert">
			{!!$errors->first()!!}
		</div>		
	@endif
  	<h2 class="text-center"></h2>
	<form action="{{ route('upload.bill') }}" method="post">
   	@csrf
	  	<div class="form-group">
	    	<label for="exampleInputPassword1">Nama File Pohon Revenue Bill</label>
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
	  <h4 class="alert-heading">Note!</h4>
	  <p class="mb-0">- File harus berupa .txt</p>
	  <p class="mb-0">- Urutan kolom harus sesuai seperti berikut.</p>
	  <p class="mb-0">- Jika ada kolom tambahan lain setelah "BUNDLING" maka tidak akan tercatat.</p>
	  <hr>
	  <p class="mb-0">"NPER", "TYPE_POHON", "CCA", "SND", "SND_GROUP", "PRODUK", "BISNIS_AREA", "CATEGORY", "STO_DESC", "DATMS", "DATRS", "UMUR_PLG", "USAGE_DESC", "PAKET_FBIP", "PAKET_SPEEDY_DESC", "STATUS", "TOTAL_NET", "TOTAL", "PPN", "ABONEMEN", "PEMAKAIAN", "KREDIT", "DEBIT", "TOTAL_NET_LALU", "TOTAL_LALU", "PPN_LALU", "ABONEMEN_LALU", "PEMAKAIAN_LALU", "KREDIT_LALU", "DEBIT_LALU", "BAYAR", "BAYAR_DESC", "CENTITE", "GROUP_PORTFOLIO", "INDIHOME_DESC", "BUNDLING"</p>
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