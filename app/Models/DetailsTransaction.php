<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailsTransaction extends Model
{
    use HasFactory;

    protected $table = 'details_transactions';

    protected $guarded = ['id'];

    public function productRelation()
    {
        return $this->hasOne(\App\Models\DetailsTransaction::class, 'id', 'product_id',);
    }
}
