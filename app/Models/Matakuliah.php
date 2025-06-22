<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matakuliah extends Model
{
    use HasFactory;
    // Tambahkan prodi_id ke fillable
    protected $fillable = ['kode', 'nama_matakuliah', 'sks', 'prodi_id'];

    // Definisikan relasi: Satu Matakuliah milik satu Prodi
    public function prodi()
    {
        return $this->belongsTo(Prodi::class);
    }
}