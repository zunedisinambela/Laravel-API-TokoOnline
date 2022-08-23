<?php

namespace App\Models\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailsTransaction extends Model
{
    use HasFactory;

    protected $table = 'details_transactions';

    protected $guarded = ['id'];
}
