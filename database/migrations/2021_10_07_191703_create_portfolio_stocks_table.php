<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePortfolioStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('portfolio_stocks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ticker_symbol');
            $table->unsignedBigInteger('portfolio_id')->index();
        
            $table->integer('share_count')->unsigned();
            $table->timestamp('purchase_date');
            $table->decimal('purchase_price', 10, 2);
            $table->decimal('weighted_price', 10, 2);
        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('portfolio_stocks');
    }
}
