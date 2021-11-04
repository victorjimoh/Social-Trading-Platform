<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Portfolio_Stock;

class Portfolio extends Model
{

    use HasFactory;
    //Indicates if the table associated with this model.

    protected $table = 'portfolios';

//Indicates if the model should be timestamped.
    public $timestamps = false;

    protected $fillable = ['cash_owned'];

//Gets all the portfolio stocks for this portfolio.

public function portfolio_stocks()
{
    return $this->hasMany(Portfolio_Stock::class);
}

public function user()
{
    return $this->belongsTo(User::class);
}
}
