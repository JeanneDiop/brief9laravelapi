<?php

namespace App\Models;

use App\Models\User;
use App\Models\Candidature;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Formation extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'details',
        'duree',
        'user_id'
       
    ];

    public function candidature(){
        return $this->hasMany(Candidature::class);
    }

        public function user(){
            return $this->belongsTo(User::class);
}
}