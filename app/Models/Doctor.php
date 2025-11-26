<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'cmp',
        'specialty',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'doctor_id');
    }

    public function images()
    {
        return $this->hasMany(Image::class, 'doctor_id');
    }

    public function diagnoses()
    {
        return $this->hasMany(Diagnosis::class, 'doctor_id');
    }
}
