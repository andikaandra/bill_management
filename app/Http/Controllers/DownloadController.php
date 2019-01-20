<?php

namespace App\Http\Controllers;

use DB;
use File;
use View;
use Response;
use App\BillJanuari;
use App\BillFebruari;
use App\BillMaret;
use App\BillApril;
use App\BillMei;
use App\BillJuni;
use App\BillJuli;
use App\BillAgustus;
use App\BillSeptember;
use App\BillOktober;
use App\BillNovember;
use App\BillDesember;
use App\UnbillJanuari;
use App\UnbillFebruari;
use App\UnbillMaret;
use App\UnbillApril;
use App\UnbillMei;
use App\UnbillJuni;
use App\UnbillJuli;
use App\UnbillAgustus;
use App\UnbillSeptember;
use App\UnbillOktober;
use App\UnbillNovember;
use App\UnbillDesember;

use App\DosierDesember;
use Illuminate\Http\Request;
use App\Exports\BillDesemberExport;
use Rap2hpoutre\FastExcel\FastExcel;
use Illuminate\Support\Facades\Redirect;

class DownloadController extends Controller
{
    private $bulan = array('januari', 'februari', 'maret', 'april', 'mei', 'juni', 'juli', 'agustus', 'september', 'oktober', 'november', 'desember');

    private $tipe = array('csv', 'xlsx', 'txt');

    public function downloadBill($bulan, $tipe)
    {
        $start = microtime(true);
        $namaFile = date('dmy_').'bill_'.$bulan.'_'.time().'.'.$tipe;

        if (in_array($bulan, $this->bulan) and in_array($tipe, $this->tipe)) {
            if ($tipe == 'xlsx' or $tipe == 'csv') {
                if ($bulan == 'januari') {
                    return (new FastExcel(BillJanuari::all()))->download($namaFile);
                }
                elseif ($bulan == 'februari') {
                    return (new FastExcel(BillFebruari::all()))->download($namaFile);
                }
                elseif ($bulan == 'maret') {
                    return (new FastExcel(BillMaret::all()))->download($namaFile);
                }
                elseif ($bulan == 'april') {
                    return (new FastExcel(BillApril::all()))->download($namaFile);
                }
                elseif ($bulan == 'mei') {
                    return (new FastExcel(BillMei::all()))->download($namaFile);
                }
                elseif ($bulan == 'juni') {
                    return (new FastExcel(BillJuni::all()))->download($namaFile);
                }
                elseif ($bulan == 'juli') {
                    return (new FastExcel(BillJuli::all()))->download($namaFile);
                }
                elseif ($bulan == 'agustus') {
                    return (new FastExcel(BillAgustus::all()))->download($namaFile);
                }
                elseif ($bulan == 'september') {
                    return (new FastExcel(BillSeptember::all()))->download($namaFile);
                }
                elseif ($bulan == 'oktober') {
                    return (new FastExcel(BillOktober::all()))->download($namaFile);
                }
                elseif ($bulan == 'november') {
                    return (new FastExcel(BillNovember::all()))->download($namaFile);
                }
                elseif ($bulan == 'desember') {
                    return (new FastExcel(BillDesember::all()))->download($namaFile);
                }
                return 'coba lagi';
            }
            elseif ($tipe == 'txt') {
                $bill = DB::table('bill_'.$bulan)->get();
                if (!count($bill)) {
                    return 'data kosong';
                }
                $bill = json_decode(json_encode($bill), true);
                $headerBill = array_keys($bill[0]);

                $billLength = count($bill);
                $dataBill = array();

                for ($i=0; $i < $billLength ; $i++) { 
                    $temp2 = implode('|',array_values($bill[$i]))."\n";
                    array_push($dataBill, $temp2);
                }
                array_unshift($dataBill, implode('|',$headerBill)."\n");

                $resBill = implode("\r",$dataBill);

                File::put(storage_path('app/public/'.$namaFile),$resBill);
                return Response::download(storage_path('app/public/'.$namaFile));
                return (microtime(true) - $start);
            }
        } 
        else{
            return 'Format salah';
        }
    }

    public function downloadUnbill($bulan, $tipe)
    {
        $namaFile = date('dmy_').'unbill_'.$bulan.'_'.time().'.'.$tipe;

        if (in_array($bulan, $this->bulan) and in_array($tipe, $this->tipe)) {
            if ($tipe == 'xlsx' or $tipe == 'csv') {
                if ($bulan == 'januari') {
                    return (new FastExcel(UnbillJanuari::all()))->download($namaFile);
                }
                elseif ($bulan == 'februari') {
                    return (new FastExcel(UnbillFebruari::all()))->download($namaFile);
                }
                elseif ($bulan == 'maret') {
                    return (new FastExcel(UnbillMaret::all()))->download($namaFile);
                }
                elseif ($bulan == 'april') {
                    return (new FastExcel(UnbillApril::all()))->download($namaFile);
                }
                elseif ($bulan == 'mei') {
                    return (new FastExcel(UnbillMei::all()))->download($namaFile);
                }
                elseif ($bulan == 'juni') {
                    return (new FastExcel(UnbillJuni::all()))->download($namaFile);
                }
                elseif ($bulan == 'juli') {
                    return (new FastExcel(UnbillJuli::all()))->download($namaFile);
                }
                elseif ($bulan == 'agustus') {
                    return (new FastExcel(UnbillAgustus::all()))->download($namaFile);
                }
                elseif ($bulan == 'september') {
                    return (new FastExcel(UnbillSeptember::all()))->download($namaFile);
                }
                elseif ($bulan == 'oktober') {
                    return (new FastExcel(UnbillOktober::all()))->download($namaFile);
                }
                elseif ($bulan == 'november') {
                    return (new FastExcel(UnbillNovember::all()))->download($namaFile);
                }
                elseif ($bulan == 'desember') {
                    return (new FastExcel(UnbillDesember::all()))->download($namaFile);
                }
                return 'coba lagi';
            }
            elseif ($tipe == 'txt') {
                $bill = DB::table('unbill_'.$bulan)->get();
                if (!count($bill)) {
                    return 'data kosong';
                }
                $bill = json_decode(json_encode($bill), true);
                $headerBill = array_keys($bill[0]);

                $billLength = count($bill);
                $dataBill = array();

                for ($i=0; $i < $billLength ; $i++) { 
                    $temp2 = implode('|',array_values($bill[$i]))."\n";
                    array_push($dataBill, $temp2);
                }
                array_unshift($dataBill, implode('|',$headerBill)."\n");

                $resBill = implode("\r",$dataBill);

                File::put(storage_path('app/public/'.$namaFile),$resBill);
                return Response::download(storage_path('app/public/'.$namaFile));
                return (microtime(true) - $start);
            }
        } 
        else{
            return 'Format salah';
        }
    }
    
    public function importFast()
    {
        $start = microtime(true);
        // $collection = (new FastExcel)->import(storage_path('app/public/file.xlsx'));
        // $collection = (new FastExcel)->configureCsv(',', '|', 'UTF-8')->import(storage_path('app/public/dosier.csv'));
        DB::connection()->disableQueryLog();
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
    
    public function test3(Request $Request)
    {   
        $start = microtime(true);

        if (!file_exists(storage_path('app/public/'.$Request->dosier)) or !file_exists(storage_path('app/public/'.$Request->revenue))) {
            return Redirect::back()->withErrors(['File tidak tersedia', 'File tidak tersedia']);
        }

        $contentDosier = File::get(storage_path('app/public/'.$Request->dosier));
        $contentBill = File::get(storage_path('app/public/'.$Request->revenue));
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
        
        array_unshift($dataDosier , $header);
        $resDosier = implode("\r",$dataDosier);

        $fileNameDosier = time() . '_data-profiling.txt';
        File::put(storage_path('app/public/'.$fileNameDosier),$resDosier);
        return Response::download(storage_path('app/public/'.$fileNameDosier));
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
        return false;
    }
}
