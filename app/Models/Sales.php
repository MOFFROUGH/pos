<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    public function invoices()
    {
      return $this->hasMany(Invoices::class);
    }
}
