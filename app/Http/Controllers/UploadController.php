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

class UploadController extends Controller
{

    public function uploadBill(Request $Request)
    {	
        $start = microtime(true);
        DB::connection()->disableQueryLog();
        DB::table('bill_'.$Request->bulan)->delete();

        $contentBill = File::get(storage_path('app/public/'.$Request->revenue));
        $headerBill = array("NPER", "TYPE_POHON", "CCA", "SND", "SND_GROUP", "PRODUK", "BISNIS_AREA", "CATEGORY", "STO_DESC", "DATMS", "DATRS", "UMUR_PLG", "USAGE_DESC", "PAKET_FBIP", "PAKET_SPEEDY_DESC", "STATUS", "TOTAL_NET", "TOTAL", "PPN", "ABONEMEN", "PEMAKAIAN", "KREDIT", "DEBIT", "TOTAL_NET_LALU", "TOTAL_LALU", "PPN_LALU", "ABONEMEN_LALU", "PEMAKAIAN_LALU", "KREDIT_LALU", "DEBIT_LALU", "BAYAR", "BAYAR_DESC", "CENTITE", "GROUP_PORTFOLIO", "INDIHOME_DESC", "BUNDLING");
        $dataBill = explode("\n", $contentBill);
        $arrayBill = array();

        array_shift($dataBill);
        foreach ($dataBill as $d) {
            $d = str_replace("\r", '', $d);

            $temp = explode('|', $d);
            $temp2 = array();
            for ($i=0; $i < count($temp) -1 ; $i++) {
                $temp2[$headerBill[$i]] = $temp[$i];
            }
            array_push($arrayBill, $temp2);
        }
        array_pop($arrayBill);

        $chunks = array_chunk($arrayBill,1000);
        foreach ($chunks as $c) {
            DB::table('bill_'.$Request->bulan)->insert($c);
        }
        return Redirect::back()->withErrors(["Upload berhasil! <br>waktu : ".(microtime(true) - $start)." detik <br> Nama File : ".$Request->revenue." <br>Bulan : ".$Request->bulan]);
    }

    public function uploadUnbill(Request $Request)
    {	
        $start = microtime(true);
        DB::connection()->disableQueryLog();
        DB::table('unbill_'.$Request->bulan)->delete();

        $contentBill = File::get(storage_path('app/public/'.$Request->revenue));
        $headerBill = array("NPER", "TYPE_POHON", "CCA", "SND", "SND_GROUP", "PRODUK", "BISNIS_AREA", "CATEGORY", "STO_DESC", "DATMS", "DATRS", "UMUR_PLG", "USAGE_DESC", "PAKET_FBIP", "PAKET_SPEEDY_DESC", "STATUS", "TOTAL_NET", "TOTAL", "PPN", "ABONEMEN", "PEMAKAIAN", "KREDIT", "DEBIT", "TOTAL_NET_LALU", "TOTAL_LALU", "PPN_LALU", "ABONEMEN_LALU", "PEMAKAIAN_LALU", "KREDIT_LALU", "DEBIT_LALU", "BAYAR", "BAYAR_DESC", "CENTITE", "GROUP_PORTFOLIO", "INDIHOME_DESC", "BUNDLING");
        $dataBill = explode("\n", $contentBill);
        $arrayBill = array();

        array_shift($dataBill);
        foreach ($dataBill as $d) {
            $d = str_replace("\r", '', $d);

            $temp = explode('|', $d);
            $temp2 = array();
            for ($i=0; $i < count($temp) -1 ; $i++) {
                $temp2[$headerBill[$i]] = $temp[$i];
            }
            array_push($arrayBill, $temp2);
        }
        array_pop($arrayBill);

        $chunks = array_chunk($arrayBill,1000);
        foreach ($chunks as $c) {
            DB::table('unbill_'.$Request->bulan)->insert($c);
        }
        return Redirect::back()->withErrors(["Upload berhasil! <br>waktu : ".(microtime(true) - $start)." detik <br> Nama File : ".$Request->revenue." <br>Bulan : ".$Request->bulan]);
    }

    public function uploadDosier(Request $Request)
    {	
        $start = microtime(true);
        DB::connection()->disableQueryLog();
        DB::table('dosier_'.$Request->bulan)->delete();

        $contentDosier = File::get(storage_path('app/public/'.$Request->revenue));
        $headerDosier = array("NCLI", "ND", "ND_REFERENCE", "NAMA", "DATEL", "CMDF", "RK", "DP", "LGEST", "LCAT", "LCOM", "CQUARTIER", "LQUARTIER", "CPOSTAL", "LVOIE", "NVOIE", "BAT", "RP_TAGIHAN", "TUNDA_CABUT", "LART", "LTARIF", "KWADRAN", "KWADRAN_POTS", "IS_IPTV", "CDATEL");

        $dataDosier = explode("\n", $contentDosier);
       	$listKolom = explode('|', $dataDosier[0]);
       	$listKolom[count($listKolom)-1] = str_replace("\r", '', $listKolom[count($listKolom)-1]);
        $indexHeader = array();

        for ($i=0; $i < count($headerDosier) ; $i++) {
        	$flag=0;
        	for ($j=0; $j < count($listKolom) ; $j++) { 
        		if ($listKolom[$j]==$headerDosier[$i]) {
        			array_push($indexHeader, $j);
        			$flag=1;
        			break;
        		}
        	}
        	if ($flag==0) {
        		array_push($indexHeader, -1);
        	}
        }
        $arrayDosier = array();
        array_shift($dataDosier);
        array_pop($dataDosier);
        
        foreach ($dataDosier as $d) {
            $d = str_replace("\r", '', $d);

            $temp = explode('|', $d);
            $temp2 = array();
            for ($i=0; $i < count($headerDosier); $i++) {
                $temp2[$headerDosier[$i]] = $temp[$indexHeader[$i]];
            }
            array_push($arrayDosier, $temp2);
        }

        $chunks = array_chunk($arrayDosier,1000);
        foreach ($chunks as $c) {
            DB::table('dosier_'.$Request->bulan)->insert($c);
        }
        return Redirect::back()->withErrors(["Upload berhasil! <br>waktu : ".(microtime(true) - $start)." detik <br> Nama File : ".$Request->revenue." <br>Bulan : ".$Request->bulan]);
    }
}
