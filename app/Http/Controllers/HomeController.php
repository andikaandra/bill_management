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
            $res = (DB::table('bill_'.$b)->first() and DB::table('unbill_'.$b)->first() and DB::table('dosier_'.$b)->first() and DB::table('ukur_voice_'.$b)->first());
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

            if (!DB::table('dosier_cache_'.$b)->first()) {
                $datas = DB::table('dosier_januari')
                        ->selectRaw('dosier_januari.NCLI, dosier_januari.ND, dosier_januari.ND_REFERENCE, dosier_januari.NAMA, dosier_januari.DATEL, dosier_januari.CMDF, dosier_januari.RK, dosier_januari.DP, dosier_januari.LGEST, dosier_januari.LCAT, dosier_januari.LCOM, dosier_januari.CQUARTIER, dosier_januari.LQUARTIER, dosier_januari.CPOSTAL, dosier_januari.LVOIE, dosier_januari.NVOIE, dosier_januari.BAT, dosier_januari.RP_TAGIHAN, dosier_januari.TUNDA_CABUT, dosier_januari.LART, dosier_januari.LTARIF, dosier_januari.KWADRAN, dosier_januari.KWADRAN_POTS, dosier_januari.IS_IPTV')
                        ->join(DB::raw('(SELECT min(ND) as ND, max(ND_REFERENCE) as ND_REFERENCE, NCLI, NAMA, sum(RP_TAGIHAN) as RP_TAGIHAN, DATEL, NVOIE, LVOIE FROM dosier_januari GROUP BY NAMA, LVOIE, DATEL, NVOIE, NCLI) as dataDosier'), function($join){
                                $join->on('dosier_januari.ND', '=', 'dataDosier.ND');
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
                $datas = DB::table('dosier_januari')
                        ->selectRaw('dosier_januari.NCLI, dosier_januari.ND, dosier_januari.ND_REFERENCE, dosier_januari.NAMA, dosier_januari.DATEL, dosier_januari.CMDF, dosier_januari.RK, dosier_januari.DP, dosier_januari.LGEST, dosier_januari.LCAT, dosier_januari.LCOM, dosier_januari.CQUARTIER, dosier_januari.LQUARTIER, dosier_januari.CPOSTAL, dosier_januari.LVOIE, dosier_januari.NVOIE, dosier_januari.BAT, dosier_januari.RP_TAGIHAN, dosier_januari.TUNDA_CABUT, dosier_januari.LART, dosier_januari.LTARIF, dosier_januari.KWADRAN, dosier_januari.KWADRAN_POTS, dosier_januari.IS_IPTV')
                        ->join(DB::raw('(SELECT min(ND) as ND, max(ND_REFERENCE) as ND_REFERENCE, NCLI, NAMA, sum(RP_TAGIHAN) as RP_TAGIHAN, DATEL, NVOIE, LVOIE FROM dosier_januari GROUP BY NAMA, LVOIE, DATEL, NVOIE, NCLI) as dataDosier'), function($join){
                                $join->on('dosier_januari.ND', '=', 'dataDosier.ND');
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
        $bulans = $this->bulan;
        return view('download.download_bill', compact('bulans'));
    }

    public function downloadUnbill()
    {
        $bulans = $this->bulan;
        return view('download.download_unbill', compact('bulans'));
    }

    public function downloadDosier()
    {
        $bulans = $this->bulan;
        return view('download.download_dosier', compact('bulans'));
    }

    public function downloadUkurVoice()
    {
        $bulans = $this->bulan;
        return view('download.download_ukur_voice', compact('bulans'));
    }    

    public function downloadGpon()
    {
        $bulans = $this->bulan;
        return view('download.download_gpon', compact('bulans'));
    }

    public function getData($id, $snd, $bulan)
    {
        $data = DB::table('bill_'.$bulan)->select('ABONEMEN', 'DEBIT', 'UMUR_PLG' ,'KREDIT', 'PEMAKAIAN', 'BAYAR', 'SND' , 'TOTAL_NET', 'TOTAL', 'PPN')->where('snd', $id)->first();
        return response()->json(['data' => $data]);
    }
}
