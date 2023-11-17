<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class nama_skpd extends Model
{
    use HasFactory;
    protected $table = 'tb_skpd';
    protected $fillable = [
        'kode_skpd',
        'nama_skpd',
        'npwp_bendahara'
    ];
}
