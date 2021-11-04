<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Portfolio;

class Portfolio_Stock extends Model
{
    use HasFactory;

    // The table associated with this model
    protected $table = 'portfolio_stocks';

    public $timestamps = false;

    protected $fillable = [
        'ticker_symbol',
        'share_count',
        'purchase_date',
        'purchase_price',
        'weighted_price'
    ];

    public function portfolios(){
        return $this->belongsTo(Portfolio::class);
    }

}
