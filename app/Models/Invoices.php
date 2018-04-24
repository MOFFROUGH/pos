<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoices extends Model
{
    public function sales()
    {
      return $this->belongsTo(Sales::class);
    }
}
