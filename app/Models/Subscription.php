<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = ['uuid', 'tenant', 'plan', 'status', 'start_date', 'end_date'];

    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
}
