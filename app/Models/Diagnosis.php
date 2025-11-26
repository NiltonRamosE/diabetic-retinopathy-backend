<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diagnosis extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'diagnosis_date',
        'history_id',
        'doctor_id',
    ];

    public function medicalHistory()
    {
        return $this->belongsTo(MedicalHistory::class, 'history_id');
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }

    public function reports()
    {
        return $this->hasMany(Report::class, 'diagnosis_id');
    }
}
