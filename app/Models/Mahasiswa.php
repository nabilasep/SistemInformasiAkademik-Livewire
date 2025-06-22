<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;
    
    protected $fillable = ['nim', 'nama', 'prodi_id', 'user_id', 'tahun_masuk'];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function prodi()
    {
        return $this->belongsTo(Prodi::class);
    }

    public function krs()
    {
        return $this->hasMany(Krs::class);
    }

    public function matakuliahs()
    {
        return $this->belongsToMany(Matakuliah::class, 'krs')->withTimestamps();
    }
}