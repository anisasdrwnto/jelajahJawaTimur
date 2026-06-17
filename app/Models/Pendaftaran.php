<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    use HasFactory;

    protected $table = 'trx_pendaftaran';
    protected $primaryKey = 'pdf_id_pendaftaran';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'pdf_id_pendaftaran',
        'pdf_id_users',
        'pdf_id_event',
        'pdf_nama',
        'pdf_email',
        'pdf_no_hp',
        'pdf_status',
        'pdf_createDate',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class, 'pdf_id_event', 'eve_id_event');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'pdf_id_users', 'mus_id_users');
    }
}