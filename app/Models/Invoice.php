<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable=[
        'items','due_date','description','tax_percentage'
    ];

    public function items(){
        return $this->hasMany('App\Models\Item', 'invoice_id', 'id');
    }

    
}
