@extends('layouts.apps')

@section('content')
<div class="container">
  <h2 class="text-center">Data Lengkap </h2>
  <div class="row ">
    <div class="table-responsive">
      <table class="table table-sm table-dark table-hover table-bordered">
        <thead>
          <tr>
            <th scope="col" class="text-center">NCLI</th>
            <th scope="col" class="text-center">ND</th>
            <th scope="col" class="text-center">ND_REFERENCE</th>
            <th scope="col" class="text-center">NAMA</th>
            <th scope="col" class="text-center">RP_TAGIHAN</th>
            <th scope="col" class="text-center">RINCIAN</th>
          </tr>
        </thead>
        <tbody>
          @php
            $count=1;
          @endphp
          @foreach($datas as $data)
              <tr>
                <td>{{$data->NCLI}}</td>
                <td>{{$data->ND}}</td>
                <td>{{$data->ND_REFERENCE}}</td>
                <td>{{$data->NAMA}}</td>
                <td>Rp. @convert((int)$data->RP_TAGIHAN)</td>
                <td align="center">
                  <button type="button" data-snd="{{$data->ND}}" data-bulan="januari" data-id="{{$data->ND}}" class="btn btn-sm btn-warning m-2 info1">Bill</button>
                  <button type="button" data-snd="{{$data->ND}}" data-bulan="januari" data-id="{{$data->ND}}" class="btn btn-sm btn-danger m-2">Unbill</button>
                  <button type="button" data-snd="{{$data->ND}}" data-bulan="januari" data-id="{{$data->ND}}" class="btn btn-sm btn-primary m-2">UVoice</button>
{{--                   <button type="button" data-snd="{{$data->ND}}" data-bulan="januari" data-id="{{$data->ND}}" class="btn btn-sm btn-info m-2">Gpon</button> --}}
                </td>
              </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
  <br>
  <div class="row justify-content-md-center">
    {{ $datas->links("pagination::bootstrap-4") }}
  </div>
</div>
<div class="modal fade" id="modal-data" tabindex="-1" role="dialog" aria-labelledby="label-modal" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="label-modal">Data Bill dan Detail Pelanggan</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col">
            <form>
              <div class="form-group row">
                <label for="title1" class="col-sm-12 col-form-label text-center">DATA BILL PELANGGAN</label>
              </div>
              <div class="form-group row">
                <label for="snd" class="col-sm-4 col-form-label">SND</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="snd" disabled>
                </div>
              </div>
              <div class="form-group row">
                <label for="total_net" class="col-sm-4 col-form-label">TOTAL_NET</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="total_net" disabled>
                </div>
              </div>
              <div class="form-group row">
                <label for="total" class="col-sm-4 col-form-label">TOTAL</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="total" disabled>
                </div>
              </div>
              <div class="form-group row">
                <label for="ppn" class="col-sm-4 col-form-label">PPN</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="ppn" disabled>
                </div>
              </div>
              <div class="form-group row">
                <label for="abonemen" class="col-sm-4 col-form-label">ABONEMEN</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="abonemen" disabled>
                </div>
              </div>
              <div class="form-group row">
                <label for="pemakaian" class="col-sm-4 col-form-label">PEMAKAIAN</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="pemakaian" disabled>
                </div>
              </div>
              <div class="form-group row">
                <label for="kredit" class="col-sm-4 col-form-label">KREDIT</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="kredit" disabled>
                </div>
              </div>
              <div class="form-group row">
                <label for="debit" class="col-sm-4 col-form-label">DEBIT</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="debit" disabled>
                </div>
              </div>
              <div class="form-group row">
                <label for="bayar" class="col-sm-4 col-form-label">BAYAR</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="bayar" disabled>
                </div>
              </div>
              <div class="form-group row">
                <label for="umur" class="col-sm-4 col-form-label">UMUR PELANGGAN</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="umur" disabled>
                </div>
              </div>
            </form>
          </div>
          <div class="col">
          </div>          
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('script')
<script>
  $('#item-home').addClass('active');

  $( document ).ready(function() {
      $(document).on('click', '.info1', async function(){
        const id = $(this).attr('data-id');
        const bulan = $(this).attr('data-bulan');
        const snd = $(this).attr('data-snd');
        console.log(snd);
        let data;
        try {
            data = await $.ajax({
              url: '{{url('data/bill')}}/' + id + '/' + snd + '/' + bulan
            });

        } catch (e) {
          alert("Ajax error");
          console.log(e);
          return;
        }
        $("h4.modal-title").html("Data Bill");

        $("input[id='snd']").val(data.data.SND);
        $("input[id='total_net']").val("Rp. "+data.data.TOTAL_NET);
        $("input[id='total']").val("Rp. "+data.data.TOTAL);
        $("input[id='ppn']").val("Rp. "+data.data.PPN);
        $("input[id='abonemen']").val("Rp. "+data.data.ABONEMEN);
        $("input[id='pemakaian']").val(data.data.PEMAKAIAN);
        $("input[id='kredit']").val("Rp. "+data.data.KREDIT);
        $("input[id='debit']").val("Rp. "+data.data.DEBIT);
        $("input[id='bayar']").val("Rp. "+data.data.BAYAR);
        $("input[id='umur']").val("Rp. "+data.data.UMUR_PLG + " Bulan");

        $("#modal-data").modal('show');

      });
  });
</script>
@endsection