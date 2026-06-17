<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $table = 'mst_event';
    protected $primaryKey = 'eve_id_event';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'eve_id_event',
        'eve_nama_event',
        'eve_deskripsi',
        'eve_kategori',
        'eve_tanggal',
        'eve_lokasi',
        'eve_gambar',
        'eve_kuota',
        'eve_createBy',
        'eve_createDate',
    ];

    public function pendaftaran()
    {
        return $this->hasMany(Pendaftaran::class, 'pdf_id_event', 'eve_id_event');
    }
}
