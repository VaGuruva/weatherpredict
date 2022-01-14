<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePredictionsPartnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('predictions_partners', function (Blueprint $table) {
            $table->bigInteger('partner_id')->unsigned();
            $table->bigInteger('prediction_id')->unsigned();
            $table->foreign('partner_id')->references('id')->on('partners')
                ->onDelete('cascade');
            $table->foreign('prediction_id')->references('id')->on('predictions')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('predictions_partners');
    }
}
