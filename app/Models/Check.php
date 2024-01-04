<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Check extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected  $date=['deleted_at'];

    protected $fillable = [
        'name',
        'order_id',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

}
