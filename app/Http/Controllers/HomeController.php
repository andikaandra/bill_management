<?php

namespace App\Http\Controllers;

use DB;
use File;
use View;
use Excel;
use Response;
use App\BillDesember;
use App\DosierDesember;
use Illuminate\Http\Request;
use App\Exports\BillDesemberExport;
use Rap2hpoutre\FastExcel\FastExcel;
use Illuminate\Support\Facades\Redirect;

class HomeController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }
    private $bulan = array('januari', 'februari', 'maret', 'april', 'mei', 'juni', 'juli', 'agustus', 'september', 'oktober', 'november', 'desember');

    public function index()
    {
        DB::connection()->disableQueryLog();

        $ketersediaan = array();
        $bulans = $this->bulan;
        foreach ($this->bulan as $b) {
            $res = (DB::table('bill_'.$b)->first() and DB::table('unbill_'.$b)->first() and DB::table('dosier_'.$b)->first() and DB::table('ukur_voice_'.$b)->first() and DB::table('gpon_'.$b)->first());
            if ($res) {
                $res = "Tersedia";
            }
            else{
                $res = "Tidak Tersedia";
            }
            $ketersediaan[$b] = $res;
        }

        // $datas = DB::table('dosier_januari')
        //         ->selectRaw('min(ND) as ND, max(ND_REFERENCE) as ND_REFERENCE, NCLI, NAMA, sum(RP_TAGIHAN) as RP_TAGIHAN, DATEL, NVOIE, LVOIE')
        //         ->groupBy('NAMA', 'LVOIE', 'DATEL', 'NVOIE', 'NCLI')
        //         ->paginate(25);
        return view('index', compact('ketersediaan', 'bulans'));
    }

    public function cekData($b)
    {
        $start = microtime(true);
        if (in_array($b, $this->bulan)){
            DB::connection()->disableQueryLog();
            // DB::table('dosier_cache_'.$b)->truncate();

            if (!(DB::table('bill_'.$b)->first() or DB::table('unbill_'.$b)->first() or DB::table('dosier_'.$b)->first() or DB::table('ukur_voice_'.$b)->first())) {
                return redirect()->route('index')->with('error', 'Data belum lengkap!');
            }

            // if (!DB::table('dosier_cache_'.$b)->first()) {
            //     $datas = DB::table('dosier_januari')
            //             ->selectRaw('dosier_januari.NCLI, dosier_januari.ND, dosier_januari.ND_REFERENCE, dosier_januari.NAMA, dosier_januari.DATEL, dosier_januari.CMDF, dosier_januari.RK, dosier_januari.DP, dosier_januari.LGEST, dosier_januari.LCAT, dosier_januari.LCOM, dosier_januari.CQUARTIER, dosier_januari.LQUARTIER, dosier_januari.CPOSTAL, dosier_januari.LVOIE, dosier_januari.NVOIE, dosier_januari.BAT, dosier_januari.RP_TAGIHAN, dosier_januari.TUNDA_CABUT, dosier_januari.LART, dosier_januari.LTARIF, dosier_januari.KWADRAN, dosier_januari.KWADRAN_POTS, dosier_januari.IS_IPTV')
            //             ->join(DB::raw('(SELECT min(ND) as ND, max(ND_REFERENCE) as ND_REFERENCE, NCLI, NAMA, sum(RP_TAGIHAN) as RP_TAGIHAN, DATEL, NVOIE, LVOIE FROM dosier_januari GROUP BY NAMA, LVOIE, DATEL, NVOIE, NCLI) as dataDosier'), function($join){
            //                     $join->on('dosier_januari.ND', '=', 'dataDosier.ND');
            //                 })
            //             ->get()
            //             ->toArray();
            //     $chunks = array_chunk($datas,1000);
            //     foreach ($chunks as $c) {
            //         $to_fill = [];
            //         foreach($c as $record) {
            //           $to_fill[] = (array)$record;
            //         }
            //         DB::table('dosier_cache_'.$b)->insert($to_fill);
            //     }
            //     DB::table('last_sync')->where('bulan', $b)->update(['updated_at' => date('Y-m-d G:i:s')]);
            // }

            $data = DB::table('dosier_cache_'.$b)->select('id', 'NCLI', 'ND', 'ND_REFERENCE', 'NAMA', 'RP_TAGIHAN')->paginate(50);

            $sync = DB::table('last_sync')->where('bulan', $b)->first();
            $bulan = $b;
            $time = (microtime(true) - $start);
            return view('welcome', compact('data', 'time', 'sync', 'bulan'));
        }
        else{
            return redirect()->route('index');
        }
    }

    public function syncData(Request $Request)
    {
        $start = microtime(true);
        $b = $Request->bulan;
        if (in_array($b, $this->bulan)){
            DB::connection()->disableQueryLog();
            DB::table('dosier_cache_'.$b)->truncate();

            if (!(DB::table('bill_'.$b)->first() or DB::table('unbill_'.$b)->first() or DB::table('dosier_'.$b)->first() or DB::table('ukur_voice_'.$b)->first())) {
                return redirect()->route('index')->with('error', 'Data belum lengkap!');
            }

            if (!DB::table('dosier_cache_'.$b)->first()) {
                $datas = DB::table('dosier_'.$b)
                        ->selectRaw('dosier_'.$b.'.NCLI, dosier_'.$b.'.ND, dosier_'.$b.'.ND_REFERENCE, dosier_'.$b.'.NAMA, dosier_'.$b.'.DATEL, dosier_'.$b.'.CMDF, dosier_'.$b.'.RK, dosier_'.$b.'.DP, dosier_'.$b.'.LGEST, dosier_'.$b.'.LCAT, dosier_'.$b.'.LCOM, dosier_'.$b.'.CQUARTIER, dosier_'.$b.'.LQUARTIER, dosier_'.$b.'.CPOSTAL, dosier_'.$b.'.LVOIE, dosier_'.$b.'.NVOIE, dosier_'.$b.'.BAT, dosier_'.$b.'.RP_TAGIHAN, dosier_'.$b.'.TUNDA_CABUT, dosier_'.$b.'.LART, dosier_'.$b.'.LTARIF, dosier_'.$b.'.KWADRAN, dosier_'.$b.'.KWADRAN_POTS, dosier_'.$b.'.IS_IPTV')
                        ->join(DB::raw('(SELECT min(ND) as ND, max(ND_REFERENCE) as ND_REFERENCE, NCLI, NAMA, sum(RP_TAGIHAN) as RP_TAGIHAN FROM dosier_'.$b.' GROUP BY NAMA, NCLI) as dataDosier'), function($join) use ($b){
                                $join->on('dosier_'.$b.'.ND', '=', 'dataDosier.ND');
                            })
                        ->get()
                        ->toArray();
                $chunks = array_chunk($datas,1000);
                foreach ($chunks as $c) {
                    $to_fill = [];
                    foreach($c as $record) {
                      $to_fill[] = (array)$record;
                    }
                    DB::table('dosier_cache_'.$b)->insert($to_fill);
                }
                DB::table('last_sync')->where('bulan', $b)->update(['updated_at' => date('Y-m-d G:i:s')]);
            }

            $data = DB::table('dosier_cache_'.$b)->select('id', 'NCLI', 'ND', 'ND_REFERENCE', 'NAMA', 'RP_TAGIHAN')->paginate(50);

            $sync = DB::table('last_sync')->where('bulan', $b)->first();
            $bulan = $b;
            $time = (microtime(true) - $start);
            return redirect()->back()->with(['data' => $data, 'time' => $time, 'sync' => $sync, 'bulan' => $bulan]);
            // return view('welcome', compact('data', 'time', 'sync', 'bulan'));
        }
        else{
            return redirect()->route('index');
        }
    }


    public function unbill()
    {
        return view('welcome2');
    }

    public function uploadBill()
    {
        return view('upload.upload_bill');
    }

    public function uploadUnbill()
    {
        return view('upload.upload_unbill');
    }

    public function uploadDosier()
    {
        return view('upload.upload_dosier');
    }

    public function uploadUkurVoice()
    {
        return view('upload.upload_ukur_voice');
    }    

    public function uploadGpon()
    {
        return view('upload.upload_gpon');
    }

    public function downloadBill()
    {
        $ketersediaan = array();
        $sync = array();
        foreach ($this->bulan as $b) {
            $ketersediaan[$b] = DB::table('bill_'.$b)->first();
            $sync[$b] = DB::table('last_update')->where('type', 'bill')->where('bulan', $b)->first();
        }
        $bulans = $this->bulan;
        return view('download.download_bill', compact('bulans', 'ketersediaan', 'sync'));
    }

    public function downloadUnbill()
    {
        $ketersediaan = array();
        foreach ($this->bulan as $b) {
            $ketersediaan[$b] = DB::table('unbill_'.$b)->first();
            $sync[$b] = DB::table('last_update')->where('type', 'unbill')->where('bulan', $b)->first();
        }
        $bulans = $this->bulan;
        return view('download.download_unbill', compact('bulans', 'ketersediaan', 'sync'));
    }

    public function downloadDosier()
    {
        $ketersediaan = array();
        foreach ($this->bulan as $b) {
            $ketersediaan[$b] = DB::table('dosier_'.$b)->first();
            $sync[$b] = DB::table('last_update')->where('type', 'dosier')->where('bulan', $b)->first();
        }
        $bulans = $this->bulan;
        return view('download.download_dosier', compact('bulans', 'ketersediaan', 'sync'));
    }

    public function downloadUkurVoice()
    {
        $ketersediaan = array();
        foreach ($this->bulan as $b) {
            $ketersediaan[$b] = DB::table('ukur_voice_'.$b)->first();
            $sync[$b] = DB::table('last_update')->where('type', 'ukur-voice')->where('bulan', $b)->first();
        }
        $bulans = $this->bulan;
        return view('download.download_ukur_voice', compact('bulans', 'ketersediaan', 'sync'));
    }    

    public function downloadGpon()
    {
        $ketersediaan = array();
        foreach ($this->bulan as $b) {
            $ketersediaan[$b] = DB::table('gpon_'.$b)->first();
            $sync[$b] = DB::table('last_update')->where('type', 'gpon')->where('bulan', $b)->first();
        }
        $bulans = $this->bulan;
        return view('download.download_gpon', compact('bulans', 'ketersediaan', 'sync'));
    }

    public function getData($snd, $bulan)
    {
        $data = DB::table('bill_'.$bulan)->select('ABONEMEN', 'DEBIT', 'UMUR_PLG' ,'KREDIT', 'PEMAKAIAN', 'BAYAR' , 'TOTAL_NET', 'TOTAL', 'PPN')->where('snd', $snd)->first();

        $data2 = DB::table('unbill_'.$bulan)->select('ABONEMEN', 'DEBIT', 'UMUR_PLG' ,'KREDIT', 'PEMAKAIAN', 'BAYAR' , 'TOTAL_NET', 'TOTAL', 'PPN')->where('snd', $snd)->first();

        $data3 = DB::table('dosier_cache_'.$bulan)->select('NCLI', 'ND', 'ND_REFERENCE' ,'DATEL', 'RK', 'DP' , 'TUNDA_CABUT', 'LART', 'LTARIF', 'IS_IPTV')->where('ND', $snd)->first();

        $data4 = DB::table('ukur_voice_'.$bulan)->select('NO', 'NODE_IP', 'SLOT' ,'PORT', 'ONU_ID', 'POTS_ID' , 'ONU_SN', 'SIP_USERNAME', 'PHONE_NUMBER', 'ONU_STATUS')->where('ND', $snd)->first();

        return response()->json(['data' => $data, 'data2' => $data2, 'data3' => $data3, 'data4' => $data4]);
    }

    public function fullData($bulan)
    {
        DB::connection()->disableQueryLog();
        // $namaFile = date('dmy_').'full_Data_'.$bulan.'_'.time().'.csv';
        // return (new FastExcel())->download($namaFile);

        $start = microtime(true);
        $data = DB::table('dosier_cache_'.$bulan)
        ->join('ukur_voice_'.$bulan, 'dosier_cache_'.$bulan.'.ND' , '=', 'ukur_voice_'.$bulan.'.ND')
        ->select('dosier_cache_'.$bulan.'.*', 'ukur_voice_'.$bulan.'.*')
        ->get();
        return (microtime(true) - $start);
    }
}
