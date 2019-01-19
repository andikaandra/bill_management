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
        $datas = DB::table('bill_desember')->select('id', 'ABONEMEN', 'DEBIT', 'KREDIT', 'BAYAR', 'SND' , 'TOTAL_NET')->paginate(50);
        return view('welcome', compact('datas'));
    }

    public function unbill()
    {
        return view('welcome2');
    }

    public function uploadBill()
    {
        return view('upload_bill');
    }

    public function uploadUnbill()
    {
        return view('upload_unbill');
    }

    public function uploadDosier()
    {
        return view('upload_dosier');
    }

    public function uploadUkurVoice()
    {
        return view('upload_ukur_voice');
    }    

    public function uploadGpon()
    {
        return view('upload_gpon');
    }

    public function downloadBill()
    {
        $bulans = $this->bulan;
        return view('download_bill', compact('bulans'));
    }

    public function downloadUnbill()
    {
        return view('download_unbill');
    }

    public function downloadDosier()
    {
        return view('download_dosier');
    }

    public function downloadUkurVoice()
    {
        return view('download_ukur_voice');
    }    

    public function downloadGpon()
    {
        return view('download_gpon');
    }

    public function getData($id, $snd, $bulan)
    {
        $data = DB::table('bill_'.$bulan)->select('ABONEMEN', 'DEBIT', 'UMUR_PLG' ,'KREDIT', 'PEMAKAIAN', 'BAYAR', 'SND' , 'TOTAL_NET', 'TOTAL', 'PPN')->where('id', $id)->first();
        $pelanggan = DB::table('dosier_'.$bulan)->select('NAMA', 'DATEL' ,'LART')->where('ND', $snd)->first();

        return response()->json(['data' => $data, 'pelanggan' => $pelanggan]);
    }
}
