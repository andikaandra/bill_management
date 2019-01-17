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

class HomeController extends Controller
{

    private $excel;
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function __construct(Excel $excel)
    {
        $this->excel = $excel;
    }
    
    public function export()
    {
        return $this->excel->download(new BillDesemberExport, 'file.xlsx');
    }
    
    public function import()
    {
        return $this->excel->import(new ImportExcell, 'file.xlsx');
    }

    public function exportFast()
    {
        return (new FastExcel(BillDesember::select('SND' , 'UMUR_PLG', 'TOTAL_NET', 'TOTAL' , 'PPN' , 'ABONEMEN' , 'PEMAKAIAN', 'KREDIT', 'DEBIT', 'BAYAR')->get()))->download('file.xlsx');
    }
    
    public function importFast()
    {
        // $collection = (new FastExcel)->import(storage_path('app/public/file.xlsx'));
        // $collection = (new FastExcel)->configureCsv(',', '|', 'UTF-8')->import(storage_path('app/public/file.csv'));
        DB::connection()->disableQueryLog();
        // return $collection[0];
        $users = (new FastExcel)->import(storage_path('app/public/dosier.csv'), function ($line) {
            // $bill = DB::table('bill_desember')->where('SND', $line['ND'])->first();
            return [
                'NCLI' => $line['NCLI'],
                'ND' => $line['ND'],
                'ND_REFERENCE' => $line['ND_REFERENCE'],
                'NAMA' => $line['NAMA'],
                'DATEL' => $line['DATEL'],
                'CMDF' => $line['CMDF'],
                'RK' => $line['RK'],
                'DP' => $line['DP'],
                'LGEST' => $line['LGEST'],
                'LCAT' => $line['LCAT'],
                'LCOM' => $line['LCOM'],
                'CQUARTIER' => $line['CQUARTIER'],
                'LQUARTIER' => $line['LQUARTIER'],
                'CPOSTAL' => $line['CPOSTAL'],
                'LVOIE' => $line['LVOIE'],
                'NVOIE' => $line['NVOIE'],
                'BAT' => $line['BAT'],
                'RP_TAGIHAN' => $line['RP_TAGIHAN'],
                'TUNDA_CABUT' => $line['TUNDA_CABUT'],
                'LART' => $line['LART'],
                'LTARIF' => $line['LTARIF'],
                'KWADRAN' => $line['KWADRAN'],
                'KWADRAN_POTS' => $line['KWADRAN_POTS'],
                'IS_IPTV' => $line['IS_IPTV'],
                // 'TOTAL_NET' => $bill['TOTAL_NET']
            ];
        });

        // return $users[0];
        return (new FastExcel($users))->download('file.csv');
    }


    public function index()
    {
        $datas = DB::table('bill_desember')->select('id_bill', 'ABONEMEN', 'DEBIT', 'KREDIT', 'BAYAR', 'SND' , 'TOTAL_NET')->paginate(50);
        return view('welcome', compact('datas'));
    }

    public function test()
    {
        $content = File::get(storage_path('app/public/PohonRevenue-v220190106 172648-bill.txt'));
        // $content = File::get(storage_path('app/public/lengkap.txt'));
        // $content = File::get(storage_path('app/public/Data Track 04 UTM.txt'));
        // return $content;
        foreach (explode("\n", $content) as $key=>$line){
            $line = str_replace("\r", '', $line);
            $array[$key] = explode('|', $line);
        }
        // return $array;
        $str="";
        foreach ($array as $a ) {
            $str=$str.implode('|', $a);
            $str=$str."\n";
        }
        return $str;

        $fileName = time() . '_datafile.txt';

        File::put(storage_path('app/public/'.$fileName),$str);
        return Response::download(storage_path('app/public/'.$fileName));
        // return (new FastExcel($array))->download(time().'.xlsx');
        // return Excel::download($array, time().'.xlsx');
        return $array;
    }

    public function unbill()
    {
        return view('welcome2');
    }

    public function download()
    {
        return view('welcome3');
    }

    public function getData($id, $snd, $bulan)
    {
        $data = DB::table('bill_'.$bulan)->select('ABONEMEN', 'DEBIT', 'UMUR_PLG' ,'KREDIT', 'PEMAKAIAN', 'BAYAR', 'SND' , 'TOTAL_NET', 'TOTAL', 'PPN')->where('id_bill', $id)->first();
        $pelanggan = DB::table('dosier_'.$bulan)->select('NAMA', 'WITEL', 'DATEL' ,'LART')->where('ND', $snd)->first();

        return response()->json(['data' => $data, 'pelanggan' => $pelanggan]);
    }
}
