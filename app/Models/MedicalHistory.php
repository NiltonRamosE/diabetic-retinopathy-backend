<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalHistory extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'patient_id',
        'created_at',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function diagnoses()
    {
        return $this->hasMany(Diagnosis::class, 'history_id');
    }
}
