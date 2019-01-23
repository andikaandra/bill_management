@extends('layouts.apps')

@section('content')
<div class="container">
  <h2 class="text-center">Data Lengkap {{$bulan}} <a class="btn btn-sm btn-success text-white" target="_blank" href="{{url("download/full/data/$bulan")}}" role="button">csv</a></h2>
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
                <label for="title1" class="col-sm-12 col-form-label text-center">DATA PELANGGAN BILL</label>
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
                <label for="title1" class="col-sm-12 col-form-label text-center">DATA PELANGGAN UNBILL</label>
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
        <hr>
        <div class="row">
          <div class="col">
            <form>
              <div class="form-group row">
                <label for="title1" class="col-sm-12 col-form-label text-center">DATA DOSIER PELANGGAN</label>
              </div>
              <div class="form-group row">
                <label for="total_net" class="col-sm-4 col-form-label">NCLI</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="ncli" disabled>
                </div>
              </div>
              <div class="form-group row">
                <label for="total_net" class="col-sm-4 col-form-label">ND</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="nd3" disabled>
                </div>
              </div>
              <div class="form-group row">
                <label for="total_net" class="col-sm-4 col-form-label">ND_REFERENCE</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="nd_reference3" disabled>
                </div>
              </div>
              <div class="form-group row">
                <label for="total_net" class="col-sm-4 col-form-label">DATEL</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="datel" disabled>
                </div>
              </div>
              <div class="form-group row">
                <label for="total_net" class="col-sm-4 col-form-label">RK</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="rk" disabled>
                </div>
              </div>
              <div class="form-group row">
                <label for="total_net" class="col-sm-4 col-form-label">DP</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="dp" disabled>
                </div>
              </div>
              <div class="form-group row">
                <label for="total_net" class="col-sm-4 col-form-label">TUNDA_CABUT</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="tunda_cabut" disabled>
                </div>
              </div>
              <div class="form-group row">
                <label for="total_net" class="col-sm-4 col-form-label">LART</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="lart" disabled>
                </div>
              </div>
              <div class="form-group row">
                <label for="total_net" class="col-sm-4 col-form-label">LTARIF</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="ltarif" disabled>
                </div>
              </div>
              <div class="form-group row">
                <label for="total_net" class="col-sm-4 col-form-label">IS_IPTV</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="is_iptv" disabled>
                </div>
              </div>
            </form>
          </div>
          <div class="col">
            <form>
              <div class="form-group row">
                <label for="title1" class="col-sm-12 col-form-label text-center">DATA UKUR VOICE PELANGGAN</label>
              </div>
              <div class="form-group row">
                <label for="total_net" class="col-sm-4 col-form-label">NO</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="no" disabled>
                </div>
              </div>
              <div class="form-group row">
                <label for="total_net" class="col-sm-4 col-form-label">NODE</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="node_ip" disabled>
                </div>
              </div>
              <div class="form-group row">
                <label for="total_net" class="col-sm-4 col-form-label">POTS_ID</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="pots_id" disabled>
                </div>
              </div>
              <div class="form-group row">
                <label for="total_net" class="col-sm-4 col-form-label">ONU_SN</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="onu_sn" disabled>
                </div>
              </div>
              <div class="form-group row">
                <label for="total_net" class="col-sm-4 col-form-label">SIP_USERNAME</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="sip_username" disabled>
                </div>
              </div>
              <div class="form-group row">
                <label for="total_net" class="col-sm-4 col-form-label">PHONE_NUMBER</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="phone_number" disabled>
                </div>
              </div>
              <div class="form-group row">
                <label for="total_net" class="col-sm-4 col-form-label">ONU_STATUS</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="onu_status" disabled>
                </div>
              </div>
            </form>
          </div>          
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
{{--         <button type="button" class="btn btn-primary">Save changes</button> --}}
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
        if (data.data) {
          $("input[id='total_net']").val("Rp. "+data.data.TOTAL_NET);
          $("input[id='total']").val("Rp. "+data.data.TOTAL);
          $("input[id='ppn']").val("Rp. "+data.data.PPN);
          $("input[id='abonemen']").val("Rp. "+data.data.ABONEMEN);
          $("input[id='pemakaian']").val(data.data.PEMAKAIAN);
          $("input[id='kredit']").val("Rp. "+data.data.KREDIT);
          $("input[id='debit']").val("Rp. "+data.data.DEBIT);
          $("input[id='bayar']").val("Rp. "+data.data.BAYAR);
          $("input[id='umur']").val("Rp. "+data.data.UMUR_PLG + " Bulan");
        }
        if (data.data2) {
          $("input[id='total_netun']").val("Rp. "+data.data2.TOTAL_NET);
          $("input[id='totalun']").val("Rp. "+data.data2.TOTAL);
          $("input[id='ppnun']").val("Rp. "+data.data2.PPN);
          $("input[id='abonemenun']").val("Rp. "+data.data2.ABONEMEN);
          $("input[id='pemakaianun']").val(data.data2.PEMAKAIAN);
          $("input[id='kreditun']").val("Rp. "+data.data2.KREDIT);
          $("input[id='debitun']").val("Rp. "+data.data2.DEBIT);
          $("input[id='bayarun']").val("Rp. "+data.data2.BAYAR);
          $("input[id='umurun']").val("Rp. "+data.data2.UMUR_PLG + " Bulan");
        }
        if (data.data3) {
          $("input[id='ncli']").val(data.data3.NCLI);
          $("input[id='nd3']").val(data.data3.ND);
          $("input[id='nd_reference3']").val(data.data3.ND_REFERENCE);
          $("input[id='datel']").val(data.data3.DATEL);
          $("input[id='rk']").val(data.data3.RK);
          $("input[id='dp']").val(data.data3.DP);
          $("input[id='tunda_cabut']").val(data.data3.TUNDA_CABUT);
          $("input[id='lart']").val(data.data3.LART);
          $("input[id='ltarif']").val(data.data3.LTARIF);
          $("input[id='is_iptv']").val(data.data3.IS_IPTV);
        }
        if (data.data4) {
          $("input[id='no']").val(data.data4.NO);
          $("input[id='node_ip']").val(data.data4.NODE_IP+'/'+data.data4.SLOT+'/'+data.data4.PORT+'/'+data.data4.ONU_ID);
          $("input[id='pots_id']").val(data.data4.POTS_ID);
          $("input[id='onu_sn']").val(data.data4.ONU_SN);
          $("input[id='sip_username']").val(data.data4.SIP_USERNAME);
          $("input[id='phone_number']").val(data.data4.PHONE_NUMBER);
          $("input[id='onu_status']").val(data.data4.ONU_STATUS);
        }

        $("#modal-data").modal('show');

      });
  });
</script>
@endsection