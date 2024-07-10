<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'category',
        'price',
        'type',
        'user_id'
    ];

    const TYPE_OUTCOME = 'outcome';
    const TYPE_INCOME = 'income';

    public function isOutcome()
    {
        return $this->type === self::TYPE_OUTCOME;
    }

    public function isIncome()
    {
        return $this->type === self::TYPE_INCOME;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
