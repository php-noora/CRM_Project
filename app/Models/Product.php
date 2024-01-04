<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Product extends Model
{
    use HasFactory , HasApiTokens, Notifiable;
    use softDeletes;
    protected  $date=['deleted_at'];

    protected $fillable=[
        'title',
        'price',
        'inventory',
        'description',
    ];


    /*public function Orders(){
        return $this->belongsToMany(Order::class)->withPivot('count');
    }

    public function user()
    {
        return $this->belongsTo(User::class);   }*/


    Public function orders(){
        return $this->belongsToMany(Order::class)->withPivot('count');
    }


    public function user(){
        return $this->belongsTo(User::class);
    }
}
