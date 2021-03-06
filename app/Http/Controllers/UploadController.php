<?php

namespace App\Http\Controllers;

use DB;
use File;
use View;
use Excel;
use Response;
use Illuminate\Http\Request;
use Rap2hpoutre\FastExcel\FastExcel;
use Illuminate\Support\Facades\Redirect;

class UploadController extends Controller
{

    public function uploadBill(Request $Request)
    {   
        $start = microtime(true);
        // if (!file_exists(storage_path('app/public/'.$Request->revenue))) {
        //     return Redirect::back()->withErrors(['File '.$Request->revenue.' tidak ada.']);
        // }

        DB::connection()->disableQueryLog();
        DB::table('bill_'.$Request->bulan)->truncate();

        $contentBill = File::get($Request->revenue);
        // $contentBill = File::get(storage_path('app/public/'.$Request->revenue));
        $headerBill = array("NPER", "TYPE_POHON", "CCA", "SND", "SND_GROUP", "PRODUK", "BISNIS_AREA", "CATEGORY", "STO_DESC", "DATMS", "DATRS", "UMUR_PLG", "USAGE_DESC", "PAKET_FBIP", "PAKET_SPEEDY_DESC", "STATUS", "TOTAL_NET", "TOTAL", "PPN", "ABONEMEN", "PEMAKAIAN", "KREDIT", "DEBIT", "BAYAR", "BAYAR_DESC", "CENTITE", "GROUP_PORTFOLIO", "INDIHOME_DESC", "BUNDLING");

        $dataBill = explode("\n", $contentBill);
        $listKolom = explode('|', $dataBill[0]);
        $listKolom[count($listKolom)-1] = str_replace("\r", '', $listKolom[count($listKolom)-1]);
        $indexHeader = array();

        $countHeaderBill = count($headerBill);
        $countListKolom = count($listKolom);
        for ($i=0; $i < $countHeaderBill ; $i++) {
            $flag=0;
            for ($j=0; $j < $countListKolom ; $j++) { 
                if ($listKolom[$j]==$headerBill[$i]) {
                    array_push($indexHeader, $j);
                    $flag=1;
                    break;
                }
            }
            if ($flag==0) {
                array_push($indexHeader, -1);
            }
        }
        $arrayBill = array();
        array_shift($dataBill);
        array_pop($dataBill);
        
        foreach ($dataBill as $d) {
            $d = str_replace("\r", '', $d);

            $temp = explode('|', $d);
            $temp2 = array();
            for ($i=0; $i < $countHeaderBill; $i++) {
                $index = $indexHeader[$i];
                if ($index >= 0) {
                    $temp2[$headerBill[$i]] = $temp[$index];
                }
                else{
                    $temp2[$headerBill[$i]] = "-";
                }
            }
            array_push($arrayBill, $temp2);
        }
        $chunks = array_chunk($arrayBill,1000);
        foreach ($chunks as $c) {
            DB::table('bill_'.$Request->bulan)->insert($c);
        }
        DB::table('last_update')->where('type', 'bill')->where('bulan', $Request->bulan)->update(['updated_at' => date('Y-m-d G:i:s')]);
        return Redirect::back()->withErrors(['Upload berhasil! <br>waktu : '.(microtime(true) - $start).' detik <br> Nama File : '.$Request->file('revenue')->getClientOriginalName().' <br>Bulan : '.$Request->bulan]);
    }

    public function uploadUnbill(Request $Request)
    {   
        $start = microtime(true);
        // if (!file_exists(storage_path('app/public/'.$Request->revenue))) {
        //     return Redirect::back()->withErrors(['File '.$Request->revenue.' tidak ada.']);
        // }

        DB::connection()->disableQueryLog();
        DB::table('unbill_'.$Request->bulan)->truncate();

        $contentBill = File::get($Request->revenue);
        // $contentBill = File::get(storage_path('app/public/'.$Request->revenue));
        $headerBill = array("NPER", "TYPE_POHON", "CCA", "SND", "SND_GROUP", "PRODUK", "BISNIS_AREA", "CATEGORY", "STO_DESC", "DATMS", "DATRS", "UMUR_PLG", "USAGE_DESC", "PAKET_FBIP", "PAKET_SPEEDY_DESC", "STATUS", "TOTAL_NET", "TOTAL", "PPN", "ABONEMEN", "PEMAKAIAN", "KREDIT", "DEBIT", "BAYAR", "BAYAR_DESC", "CENTITE", "GROUP_PORTFOLIO", "INDIHOME_DESC", "BUNDLING");

        $dataBill = explode("\n", $contentBill);
        $listKolom = explode('|', $dataBill[0]);
        $listKolom[count($listKolom)-1] = str_replace("\r", '', $listKolom[count($listKolom)-1]);
        $indexHeader = array();

        $countHeaderBill = count($headerBill);
        $countListKolom = count($listKolom);
        for ($i=0; $i < $countHeaderBill ; $i++) {
            $flag=0;
            for ($j=0; $j < $countListKolom ; $j++) { 
                if ($listKolom[$j]==$headerBill[$i]) {
                    array_push($indexHeader, $j);
                    $flag=1;
                    break;
                }
            }
            if ($flag==0) {
                array_push($indexHeader, -1);
            }
        }
        $arrayBill = array();
        array_shift($dataBill);
        array_pop($dataBill);
        
        foreach ($dataBill as $d) {
            $d = str_replace("\r", '', $d);

            $temp = explode('|', $d);
            $temp2 = array();
            for ($i=0; $i < $countHeaderBill; $i++) {
                $index = $indexHeader[$i];
                if ($index >= 0) {
                    $temp2[$headerBill[$i]] = $temp[$index];
                }
                else{
                    $temp2[$headerBill[$i]] = "-";
                }
            }
            array_push($arrayBill, $temp2);
        }

        $chunks = array_chunk($arrayBill,1000);
        foreach ($chunks as $c) {
            DB::table('unbill_'.$Request->bulan)->insert($c);
        }
        DB::table('last_update')->where('type', 'unbill')->where('bulan', $Request->bulan)->update(['updated_at' => date('Y-m-d G:i:s')]);
        return Redirect::back()->withErrors(['Upload berhasil! <br>waktu : '.(microtime(true) - $start).' detik <br> Nama File : '.$Request->file('revenue')->getClientOriginalName().' <br>Bulan : '.$Request->bulan]);
    }

    public function uploadDosier(Request $Request)
    {   
        $start = microtime(true);
        // if (!file_exists(storage_path('app/public/'.$Request->revenue))) {
        //     return Redirect::back()->withErrors(['File '.$Request->revenue.' tidak ada.']);
        // }

        DB::connection()->disableQueryLog();
        DB::table('dosier_'.$Request->bulan)->truncate();

        $contentDosier = File::get($Request->revenue);
        // $contentDosier = File::get(storage_path('app/public/'.$Request->revenue));
        $headerDosier = array("NCLI", "ND", "ND_REFERENCE", "NAMA", "DATEL", "CMDF", "RK", "DP", "LGEST", "LCAT", "LCOM", "CQUARTIER", "LQUARTIER", "CPOSTAL", "LVOIE", "NVOIE", "BAT", "RP_TAGIHAN", "TUNDA_CABUT", "LART", "LTARIF", "KWADRAN", "KWADRAN_POTS", "IS_IPTV");

        $dataDosier = explode("\n", $contentDosier);
        $listKolom = explode('|', $dataDosier[0]);
        $listKolom[count($listKolom)-1] = str_replace("\r", '', $listKolom[count($listKolom)-1]);
        $indexHeader = array();

        $countHeaderDosier = count($headerDosier);
        $countListKolom = count($listKolom);

        for ($i=0; $i < $countHeaderDosier ; $i++) {
            $flag=0;
            for ($j=0; $j < $countListKolom ; $j++) { 
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
            for ($i=0; $i < $countHeaderDosier; $i++) {
                $temp2[$headerDosier[$i]] = $temp[$indexHeader[$i]];
            }
            array_push($arrayDosier, $temp2);
        }

        $chunks = array_chunk($arrayDosier,1000);
        foreach ($chunks as $c) {
            DB::table('dosier_'.$Request->bulan)->insert($c);
        }
        DB::table('last_update')->where('type', 'dosier')->where('bulan', $Request->bulan)->update(['updated_at' => date('Y-m-d G:i:s')]);
        return Redirect::back()->withErrors(['Upload berhasil! <br>waktu : '.(microtime(true) - $start).' detik <br> Nama File : '.$Request->file('revenue')->getClientOriginalName().' <br>Bulan : '.$Request->bulan]);
    }

    public function uploadUkurVoice(Request $Request)
    {
        $start = microtime(true);
        // if (!file_exists(storage_path('app/public/'.$Request->revenue))) {
        //     return Redirect::back()->withErrors(['File '.$Request->revenue.' tidak ada.']);
        // }

        DB::connection()->disableQueryLog();
        DB::table('ukur_voice_'.$Request->bulan)->truncate();

        $contentUkur = File::get($Request->revenue);
        // $contentUkur = File::get(storage_path('app/public/'.$Request->revenue));
        $headerUkur = array("NO", "NODE_IP", "RACK", "SLOT", "PORT", "ONU_ID", "POTS_ID", "NODE_TYPE", "ONU_TYPE", "ONU_ACTUAL_TYPE", "ONU_SN", "SIP_USERNAME", "PHONE_NUMBER", "TYPE", "ONU_STATUS", "SIP_STATUS", "ONU_RX_LEVEL", "ONU_INSERTED_AT", "ONU_UPDATED_AT", "SIP_INSERTED_AT", "SIP_UPDATED_AT");

        $dataUkur = explode("\n", $contentUkur);
        $listKolom = explode("\t", str_replace('"', '', $dataUkur[0]));
        $listKolom[count($listKolom)-1] = str_replace("\r", '', $listKolom[count($listKolom)-1]);
        $indexHeader = array();

        $countHeaderUkur = count($headerUkur);
        $countListKolom = count($listKolom);

        for ($i=0; $i < $countHeaderUkur ; $i++) {
            $flag=0;
            for ($j=0; $j < $countListKolom ; $j++) { 
                if ($listKolom[$j]==$headerUkur[$i]) {
                    array_push($indexHeader, $j);
                    $flag=1;
                    break;
                }
            }
            if ($flag==0) {
                array_push($indexHeader, -1);
            }
        }
        // return $indexHeader;
        // return $listKolom;
        $araryUkur = array();
        array_shift($dataUkur);
        array_pop($dataUkur);
        foreach ($dataUkur as $d) {
            $d = str_replace("\r", '', $d);
            $d = str_replace('"', '', $d);
            $temp = array();

            if (strpos($d, 'USERNAME')) {
                continue;
            }

            $temp = explode("\t", $d);

            $temp2 = array();
            for ($i=0; $i < $countHeaderUkur; $i++) {
                $temp2[$headerUkur[$i]] = strtok($temp[$indexHeader[$i]], ",");
            }
            if ($temp[$indexHeader[13]]=='GPON') {
                $temp2['NO_TYPE'] = 'FO';
            }
            else{
                $temp2['NO_TYPE'] = 'CU';
            }
            $temp2['CLID'] = $temp[$indexHeader[1]].'/'.$temp[$indexHeader[2]].'/'.$temp[$indexHeader[3]].'/'.$temp[$indexHeader[4]].'/'.$temp[$indexHeader[5]];
            $temp2['ND'] = '0'.str_replace("\r", '', $temp[$indexHeader[12]]);
            $temp2['MERK'] = '-';
            array_push($araryUkur, $temp2);
        }
        $chunks = array_chunk($araryUkur,1000);
        foreach ($chunks as $c) {
            DB::table('ukur_voice_'.$Request->bulan)->insert($c);
        }
        DB::table('last_update')->where('type', 'ukur-voice')->where('bulan', $Request->bulan)->update(['updated_at' => date('Y-m-d G:i:s')]);
        return Redirect::back()->withErrors(['Upload berhasil! <br>waktu : '.(microtime(true) - $start).' detik <br> Nama File : '.$Request->file('revenue')->getClientOriginalName().' <br>Bulan : '.$Request->bulan]);

        return $Request;
    }

    public function uploadGpon(Request $Request)
    {   
        $start = microtime(true);
        // if (!file_exists(storage_path('app/public/'.$Request->revenue))) {
        //     return Redirect::back()->withErrors(['File '.$Request->revenue.' tidak ada.']);
        // }

        DB::connection()->disableQueryLog();
        DB::table('gpon_'.$Request->bulan)->truncate();

        $contentUkur = File::get($Request->revenue);
        // $contentUkur = File::get(storage_path('app/public/'.$Request->revenue));
        $headerUkur = array("NO", "User_Internet", "NASIPAddress", "AcctStartTime", "AccStopTime", "Up", "Down", "FramedIPAddress", "CallingStationId", "Last_Seen", "Status_Koneksi", );

        $dataUkur = explode("\n", $contentUkur);
        $listKolom = explode("\t", str_replace('"', '', $dataUkur[0]));
        $listKolom[count($listKolom)-1] = str_replace("\r", '', $listKolom[count($listKolom)-1]);
        $indexHeader = array();

        $countHeaderUkur = count($headerUkur);
        $countListKolom = count($listKolom);

        for ($i=0; $i < $countHeaderUkur ; $i++) {
            $flag=0;
            for ($j=0; $j < $countListKolom ; $j++) { 
                if ($listKolom[$j]==$headerUkur[$i]) {
                    array_push($indexHeader, $j);
                    $flag=1;
                    break;
                }
            }
            if ($flag==0) {
                array_push($indexHeader, -1);
            }
        }
        // return $indexHeader;
        // return $listKolom;
        $araryUkur = array();
        array_shift($dataUkur);
        array_pop($dataUkur);

        foreach ($dataUkur as $d) {
            $d = str_replace("\r", '', $d);
            $d = str_replace('"', '', $d);
            $temp = array();

            if (strpos($d, 'NASIPAddress')) {
                continue;
            }
            $temp = explode("\t", $d);

            $temp2 = array();
            $shift=0;
            $gpon=8;
            for ($i=0; $i < $countHeaderUkur; $i++) {
                $value = $temp[$indexHeader[$i]];
                if ($shift) {
                    $gpon=9;
                    $temp2[$headerUkur[$i]] = $temp[$indexHeader[$i]+1];
                }
                else{
                    $temp2[$headerUkur[$i]] = $value;               
                }
                if ($value=='1' and $i > 5) {
                    $shift=1;
                    $temp2[$headerUkur[$i]] = '1'.$temp[$indexHeader[$i]+1];
                }
            }
            if (strpos('-'.$temp[$indexHeader[$gpon]], 'GPON')) {
                $temp2['DAT'] = 'FO';
            }
            else{
                $temp2['DAT'] = 'CU';
            }
            $temp2['INET'] = strtok($temp[$indexHeader[1]], '@');
            array_push($araryUkur, $temp2);
        }
        // return count($dataUkur);
        $chunks = array_chunk($araryUkur,1000);
        foreach ($chunks as $c) {
            DB::table('gpon_'.$Request->bulan)->insert($c);
        }
        DB::table('last_update')->where('type', 'gpon')->where('bulan', $Request->bulan)->update(['updated_at' => date('Y-m-d G:i:s')]);
        return Redirect::back()->withErrors(['Upload berhasil! <br>waktu : '.(microtime(true) - $start).' detik <br> Nama File : '.$Request->file('revenue')->getClientOriginalName().' <br>Bulan : '.$Request->bulan]);

        return $Request;
    }
}
