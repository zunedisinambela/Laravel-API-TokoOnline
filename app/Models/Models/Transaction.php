<?php

namespace App\Models\Models;

use DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transactions';

    protected $guarded = ['id'];

    public function scopeGetCode($query)
    {
        // TR 00001
        $string = "TR";

        $selectLastCode = DB::raw(" coalesce( MAX( CAST( RIGHT( transaction_code, 5) AS UNSIGNED )), 0) as code ");

        $getData = $query->select($selectLastCode)->where('transaction_code', 'LIKE', '%'. $string .'%')->first();

        $number = sprintf("%'.05d ", $getData->code + 1);

        // 0001
        return $string.$number;
    }
}
