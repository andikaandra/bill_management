@extends('layouts.apps')

@section('content')
<div class="container">
  @if (session('error'))
    <div class="alert alert-warning text-danger" role="alert">
      {!!session('error')!!}
    </div>    
  @endif
  <div class="alert alert-success" role="alert">
    Pilih data yang akan anda gunakan. Jika anda memilih januari, maka data yang akan digunakan adalah <strong>bill bulan januari</strong>, <strong>unbill bulan januari</strong>, <strong>dosier bulan januari</strong> dan <strong>ukur voice bulan januari</strong>, <strong>gpon bulan januari</strong>, jika ke 5 data tidak tersedia, maka anda harus mengupoad terlebih dahulu
  </div>
      <div class="form-group">
        <label for="bulan">Bulan</label>
        <select class="form-control" name="bulan" required id="bulan">
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
      <button type="button" id="submit" class="btn btn-primary">Lihat data</button>
  <div class="row justify-content-center my-3">
    <div class="col-6">
      <table class="table table-dark table-md table-hover table-striped table-bordered">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Bulan</th>
            <th scope="col" class="text-center">Status</th>
          </tr>
        </thead>
        <tbody>
          @php
            $count=0;
          @endphp
          @foreach($ketersediaan as $k)
          <tr>
            <th scope="row">{{$count+1}}</th>
            <td>{{$bulans[$count++]}}</td>
            <td class="text-center">{{$k}}</td>
          </tr>
          @endforeach
        </tbody>
      </table>      
    </div>
  </div>
</div>
@endsection

@section('script')
<script>
$("#submit").click(function() {
  window.location.href = location.href+'cek-data/'+$("#bulan").val();;
  return false;
});
</script>
@endsection