@extends('layouts.apps')

@section('content')
<div class="container">
  <h2 class="text-center">Data Lengkap {{$bulan}} <a class="btn btn-sm btn-success text-white" role="button">csv</a></h2>
  <br><br>
  <div class="row">
    <div class="col justify-content-md-start">
      <h5>Load time : {{$time}}</h5>  
    </div>
    <form action="{{route('sync.data')}}" method="post">
    @csrf
    <input type="hidden" name="bulan" value="{{$bulan}}">
    <div class="col justify-content-md-end">
      <h5 class="text-right">Last sync : {{ \Carbon\Carbon::parse($sync->updated_at)->format('d/M/Y - G:i:s A')}} <button class="btn btn-sm btn-success" type="submit">sync now</button></h5>
    </div>
    </form>
  </div>
  <hr>
  <div class="row justify-content-md-center">
    <div class="card">
      <div class="card-body">
        <table class="table table-sm table-bordered table-striped">
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
            @foreach($data as $d)
                <tr>
                  <td>{{$d->NCLI}}</td>
                  <td>{{$d->ND}}</td>
                  <td>{{$d->ND_REFERENCE}}</td>
                  <td>{{$d->NAMA}}</td>
                  <td>Rp. @convert((int)$d->RP_TAGIHAN)</td>
                  <td align="center">
                    <button type="button" data-snd="{{$d->ND}}" data-bulan="{{$bulan}}" class="btn btn-sm btn-danger info1 m-2">Cek</button>
                  </td>
                </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <br>
  <div class="row justify-content-md-center">
    {{ $data->links("pagination::bootstrap-4") }}
  </div>
</div>
<div class="modal fade" id="modal-data" tabindex="-1" role="dialog" aria-labelledby="label-modal" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="label-modal">Data lengkap</h4>
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
            <form>
              <div class="form-group row">
                <label for="title1" class="col-sm-12 col-form-label text-center">DATA BILL PELANGGAN</label>
              </div>
              <div class="form-group row">
                <label for="total_net" class="col-sm-4 col-form-label">TOTAL_NET</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="total_netun" disabled>
                </div>
              </div>
              <div class="form-group row">
                <label for="total" class="col-sm-4 col-form-label">TOTAL</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="totalun" disabled>
                </div>
              </div>
              <div class="form-group row">
                <label for="ppn" class="col-sm-4 col-form-label">PPN</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="ppnun" disabled>
                </div>
              </div>
              <div class="form-group row">
                <label for="abonemen" class="col-sm-4 col-form-label">ABONEMEN</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="abonemenun" disabled>
                </div>
              </div>
              <div class="form-group row">
                <label for="pemakaian" class="col-sm-4 col-form-label">PEMAKAIAN</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="pemakaianun" disabled>
                </div>
              </div>
              <div class="form-group row">
                <label for="kredit" class="col-sm-4 col-form-label">KREDIT</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="kreditun" disabled>
                </div>
              </div>
              <div class="form-group row">
                <label for="debit" class="col-sm-4 col-form-label">DEBIT</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="debitun" disabled>
                </div>
              </div>
              <div class="form-group row">
                <label for="bayar" class="col-sm-4 col-form-label">BAYAR</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="bayarun" disabled>
                </div>
              </div>
              <div class="form-group row">
                <label for="umur" class="col-sm-4 col-form-label">UMUR PELANGGAN</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="umurun" disabled>
                </div>
              </div>
            </form>
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
        const bulan = $(this).attr('data-bulan');
        const snd = $(this).attr('data-snd');
        console.log(snd);
        let data;
        try {
            data = await $.ajax({
              url: '{{url('data/full')}}/' + snd + '/' + bulan
            });

        } catch (e) {
          alert("Ajax error");
          console.log(e);
          return;
        }
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