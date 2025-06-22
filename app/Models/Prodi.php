<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prodi extends Model
{
    use HasFactory;
    protected $fillable = ['nama_prodi', 'fakultas_id'];

    public function fakultas()
    {
        return $this->belongsTo(Fakultas::class);
    }

        public function mahasiswas()
    {
        return $this->hasMany(Mahasiswa::class);
    }

    public function matakuliahs()
    {
        return $this->hasMany(Matakuliah::class);
    }
}