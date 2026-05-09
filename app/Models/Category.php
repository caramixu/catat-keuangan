<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // Tambahkan baris ini
    protected $fillable = ['user_id', 'nama_kategori', 'tipe', 'deskripsi'];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
