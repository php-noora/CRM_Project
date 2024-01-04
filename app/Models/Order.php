<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Order extends Model
{

    use HasFactory;
    use softDeletes;
    protected  $date=['deleted_at'];
    Protected $fillable =[
        'title',
         'user_id',
          'total_price'
        ];

    public function user()
    {
return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('count');
    }




}




