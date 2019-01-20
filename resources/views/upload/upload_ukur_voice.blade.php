@extends('layouts.apps')

@section('content')
<div class="container">
	<h3 class="text-center">Upload file Ukur Voice</h3>
	<hr>
	@if($errors->any())
		<div class="alert alert-warning" role="alert">
			{!!$errors->first()!!}
		</div>		
	@endif
  	<h2 class="text-center"></h2>
	<form action="{{ route('upload.ukur.voice') }}" method="post">
   	@csrf
	  	<div class="form-group">
	    	<label for="exampleInputPassword1">Nama File Ukur Voice</label>
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
	  <p class="mb-0">- File harus berupa .txt (delimiter 'tab')</p>
	  <p class="mb-0">- Jika anda mengupload data, maka data yang lama akan digantikan oleh data yang baru</p>
	  <p class="mb-0">- Sistem hanya akan mencatat kolom sebagai berikut. kolom lainnya akan diabaikan</p>
	  <hr>
	  <div class="row">
	  	<div class="col">
		  	<ul>
				<li>ND</li>
				<li>NO</li>
				<li>NODE_IP</li>
				<li>RACK</li>
				<li>SLOT</li>
				<li>PORT</li>
				<li>ONU_ID</li>
			</ul>
	  	</div>
	  	<div class="col">
		  	<ul>
				<li>POTS_ID</li>
				<li>NODE_TYPE</li>
				<li>ONU_TYPE</li>
				<li>ONU_ACTUAL_TYPE</li>
				<li>ONU_SN</li>
				<li>SIP_USERNAME</li>
				<li>PHONE_NUMBER</li>
			</ul>
	  	</div>
	  	<div class="col">
		  	<ul>
				<li>TYPE</li>
				<li>ONU_STATUS</li>
				<li>SIP_STATUS</li>
				<li>ONU_RX_LEVEL</li>
				<li>INSERTED_AT</li>
				<li>UPDATED_AT</li>
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