<?php

namespace App\Models;

use App\Models\PoliticalParty;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'number',
        'coalition',
        'political_party_id'
    ];

    public function politicalParty()
    {
        return $this->belongsTo(PoliticalParty::class);
    }
}
