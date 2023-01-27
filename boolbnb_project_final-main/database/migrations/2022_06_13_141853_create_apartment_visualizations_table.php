<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApartmentVisualizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apartment_visualizations', function (Blueprint $table) {
            $table->id();
            // ? Chiave esterna
            $table->unsignedBigInteger('apartment_id');
            // ? Gestione Delete alla cancellazione di un appartamento
            $table->foreign('apartment_id')->references('id')->on('apartments')->onDelete('cascade');
            $table->date('visualization_date');
            $table->string('ip_address', 15);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('apartment_visualizations');
    }
}
