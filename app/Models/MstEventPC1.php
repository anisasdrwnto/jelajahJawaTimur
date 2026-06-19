<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MstEventPc1 extends Model
{
    protected $connection = 'db_pc1';
    protected $table = 'mst_event';
    protected $primaryKey = 'eve_id_event';
    public $keyType = 'string';
    public $incrementing = false;
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
}