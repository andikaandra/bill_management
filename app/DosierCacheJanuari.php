<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class DosierCacheJanuari extends Model
{
	use Sortable;
	protected $table = 'dosier_cache_januari';
    protected $guarded = [];
	public $timestamps = false;
	public $sortable = ['id', 'ND', 'NCLI', 'ND_REFERENCE', 'NAMA', 'RP_TAGIHAN'];
}
