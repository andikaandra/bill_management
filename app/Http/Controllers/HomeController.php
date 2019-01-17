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
        $start = microtime(true);
        // $collection = (new FastExcel)->import(storage_path('app/public/file.xlsx'));
        // $collection = (new FastExcel)->configureCsv(',', '|', 'UTF-8')->import(storage_path('app/public/dosier.csv'));
        DB::connection()->disableQueryLog();
        // return $collection[0];
        $users = (new FastExcel)->configureCsv(';', '|', 'UTF-8')->import(storage_path('app/public/Book1.csv'), function ($line) {
            // $bill = DB::table('bill_desember')->where('SND', $line['ND'])->first();
            return ([
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
            ]);
        });
        return microtime(true) - $start;
        return $users[0];
        return (new FastExcel($users))->download('file.csv');
    }


    public function index()
    {
        $datas = DB::table('bill_desember')->select('id_bill', 'ABONEMEN', 'DEBIT', 'KREDIT', 'BAYAR', 'SND' , 'TOTAL_NET')->paginate(50);
        return view('welcome', compact('datas'));
    }

    public function test()
    {
        $start = microtime(true);

        $contentBill = File::get(storage_path('app/public/PohonRevenue-v220190106 172648-bill.txt'));
        foreach (explode("\n", $contentBill) as $key=>$line){
            $line = str_replace("\r", '', $line);
            $arrayBill[$key] = explode('|', $line);
        }
        array_pop($arrayBill);
        $dataBill = array();
        for ($i = 0; $i < count($arrayBill); $i++) {
            $temp = array($arrayBill[$i][3], $arrayBill[$i][4], $arrayBill[$i][11], $arrayBill[$i][4], $arrayBill[$i][12], $arrayBill[$i][16], $arrayBill[$i][17], $arrayBill[$i][8], $arrayBill[$i][19], $arrayBill[$i][20], $arrayBill[$i][21], $arrayBill[$i][22], $arrayBill[$i][30], $arrayBill[$i][35]);
            array_push($dataBill, implode("|",$temp));
        }
        // usort($dataBill, function($a, $b) {
        //     return $a[0] <=> $b[0];
        // });
        $resBill = implode("\r",$dataBill);
        // return $dataBill;

        $fileNameBill = time() . '_datafile.txt';
        File::put(storage_path('app/public/'.$fileNameBill),$resBill);
        return Response::download(storage_path('app/public/'.$fileNameBill));
        return microtime(true) - $start;
    }

    public function test2()
    {
        $start = microtime(true);

        $contentDosier = File::get(storage_path('app/public/Data_I_Dossier_Datek_2018-12_27_PEKALONGAN.txt'));

        $dataDosier = explode("\n", $contentDosier);
        $arrayDosier = array();
        foreach ($dataDosier as $d) {
            $d = str_replace("\r", '', $d);
            array_push($arrayDosier, explode('|', $d));
        }
        // foreach (explode("\n", $contentDosier) as $key=>$line){
        //     $line = str_replace("\r", '', $line);
        //     // $array[$key] = explode('|', $line);
        // }

        array_pop($arrayDosier);
        $dataDosier = array();
        for ($i = 0; $i < count($arrayDosier); $i++) {
            $tempDosier = array($arrayDosier[$i][3], $arrayDosier[$i][1], $arrayDosier[$i][4], $arrayDosier[$i][5], $arrayDosier[$i][16], $arrayDosier[$i][17], $arrayDosier[$i][18], $arrayDosier[$i][19], $arrayDosier[$i][30], $arrayDosier[$i][31], $arrayDosier[$i][36], $arrayDosier[$i][37], $arrayDosier[$i][38], $arrayDosier[$i][39], $arrayDosier[$i][40], $arrayDosier[$i][41], $arrayDosier[$i][42], $arrayDosier[$i][43], $arrayDosier[$i][44], $arrayDosier[$i][47], $arrayDosier[$i][49], $arrayDosier[$i][71], $arrayDosier[$i][72], $arrayDosier[$i][76]);
            array_push($dataDosier, implode("|",$tempDosier));
        }

        $resDosier = implode("\r",$dataDosier);

        $fileNameDosier = time() . '_datafile.txt';
        File::put(storage_path('app/public/'.$fileNameDosier),$resDosier);
        return Response::download(storage_path('app/public/'.$fileNameDosier));
        return microtime(true) - $start;
        // return (new FastExcel($arrayDosier))->download(time().'.xlsx');
        // return Excel::download($arrayDosier, time().'.xlsx');
    }

    public function test3()
    {
        $start = microtime(true);

        $contentDosier = File::get(storage_path('app/public/Data_I_Dossier_Datek_2018-12_27_PEKALONGAN.txt'));
        $contentBill = File::get(storage_path('app/public/PohonRevenue-v220190106 172648-bill.txt'));

        $dataDosier = explode("\n", $contentDosier);
        $arrayDosier = array();
        foreach ($dataDosier as $d) {
            $d = str_replace("\r", '', $d);
            array_push($arrayDosier, explode('|', $d));
        }

        foreach (explode("\n", $contentBill) as $key=>$line){
            $line = str_replace("\r", '', $line);
            $arrayBill[$key] = explode('|', $line);
        }

        array_pop($arrayDosier);
        array_pop($arrayBill);



        $dataBill = array();
        for ($i = 0; $i < count($arrayBill); $i++) {
            $temp = array($arrayBill[$i][3], $arrayBill[$i][4], $arrayBill[$i][11], $arrayBill[$i][4], $arrayBill[$i][12], $arrayBill[$i][16], $arrayBill[$i][17], $arrayBill[$i][8], $arrayBill[$i][19], $arrayBill[$i][20], $arrayBill[$i][21], $arrayBill[$i][22], $arrayBill[$i][30], $arrayBill[$i][35]);
            array_push($dataBill, array((float)$arrayBill[$i][3], implode("|",$temp)));
        }

        $dataDosier = array();
        for ($i = 0; $i < count($arrayDosier); $i++) {
            $tempDosier = array($arrayDosier[$i][3], $arrayDosier[$i][1], $arrayDosier[$i][4], $arrayDosier[$i][5], $arrayDosier[$i][16], $arrayDosier[$i][17], $arrayDosier[$i][18], $arrayDosier[$i][19], $arrayDosier[$i][30], $arrayDosier[$i][31], $arrayDosier[$i][36], $arrayDosier[$i][37], $arrayDosier[$i][38], $arrayDosier[$i][39], $arrayDosier[$i][40], $arrayDosier[$i][41], $arrayDosier[$i][42], $arrayDosier[$i][43], $arrayDosier[$i][44], $arrayDosier[$i][47], $arrayDosier[$i][49], $arrayDosier[$i][71], $arrayDosier[$i][72], $arrayDosier[$i][76]);
            array_push($dataDosier, array((float)$arrayDosier[$i][3], implode("|",$tempDosier)));
        }
        $headerDosier=$dataDosier[0][1];
        $headerBill=$dataBill[0][1];
        $header = $headerDosier."|".$headerBill;

        array_shift($dataBill);
        array_shift($dataDosier);

        usort($dataBill, function ($item1, $item2) {
            return $item1[0] <=> $item2[0];
        });

        for ($i=0; $i < count($dataDosier); $i++) {
            $loc = $this->binary_search($dataDosier[$i][0], $dataBill);
            if ($loc) {
                    $dataDosier[$i][1]=$dataDosier[$i][1]."|".$dataBill[$loc][1];
            }
            array_shift($dataDosier[$i]);
            $dataDosier[$i] = implode($dataDosier[$i]);
        }
        
        // for ($i=0; $i < 10 ; $i++) { 
        //     for ($j=0; $j < count($dataBill) ; $j++) { 
        //         if (substr($dataDosier[$i], 0, strpos($dataDosier[$i], '|'))==substr($dataBill[$j], 0, strpos($dataBill[$j], '|'))) {
        //             $dataDosier[$i]=$dataDosier[$i]."|".$dataBill[$j];
        //             break;
        //         }
        //     }
        // }
        // return $dataDosier[0];
        // return microtime(true) - $start;
        array_unshift($dataDosier , $header."\r");
        $resDosier = implode("\r",$dataDosier);

        $fileNameDosier = time() . '_datafile.txt';
        File::put(storage_path('app/public/'.$fileNameDosier),$resDosier);
        return Response::download(storage_path('app/public/'.$fileNameDosier));
        // return (new FastExcel($arrayDosier))->download(time().'.xlsx');
        // return Excel::download($arrayDosier, time().'.xlsx');
    }

    public function binary_search($nd, $data) {
        $min = 0;
        $max = count($data);
        while ($max > $min)
        {
            $mid = (int) (($min + $max) / 2);
            if ($data[$mid][0] == $nd) return $mid;
            else if ($data[$mid][0] < $nd) $min = $mid + 1;
            else $max = $mid - 1;
        }
        // $nd was not found
        return false;
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
