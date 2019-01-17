<?php

namespace App\Exports;

use App\BillDesember;
use Maatwebsite\Excel\Concerns\FromCollection;

class BillDesemberExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return BillDesember::select('SND' , 'UMUR_PLG', 'TOTAL_NET', 'TOTAL' , 'PPN' , 'ABONEMEN' , 'PEMAKAIAN', 'KREDIT', 'DEBIT', 'BAYAR')->get();
    }
}
