<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = ['uuid', 'subscription_id', 'amount', 'status'];

    const STATUS_PENDING = 'pending';
    const STATUS_PAID = 'paid';
}
