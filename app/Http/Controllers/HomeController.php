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
        $start = microtime(true);        
        // $datas = DB::table('dosier_januari')
        //         ->select('dosier_januari.ND', 'dosier_januari.ND_REFERENCE', 'dosier_januari.NCLI', 'dosier_januari.RP_TAGIHAN', 'dosier_januari.NAMA')
        //         ->join(DB::raw('(SELECT min(ND) as ND, max(ND_REFERENCE) as ND_REFERENCE, NCLI, NAMA, sum(RP_TAGIHAN) as RP_TAGIHAN, DATEL, NVOIE, LVOIE FROM dosier_januari GROUP BY NAMA, LVOIE, DATEL, NVOIE, NCLI) as dataDosier'), function($join){
        //                 $join->on('dosier_januari.ND', '=', 'dataDosier.ND');
        //             })
        //         ->paginate(25);
        $datas = DB::table('dosier_januari')
                ->selectRaw('min(ND) as ND, max(ND_REFERENCE) as ND_REFERENCE, NCLI, NAMA, sum(RP_TAGIHAN) as RP_TAGIHAN, DATEL, NVOIE, LVOIE')
                ->groupBy('NAMA', 'LVOIE', 'DATEL', 'NVOIE', 'NCLI')
                ->paginate(25);
        return view('welcome', compact('datas'));
                return (microtime(true) - $start);
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
