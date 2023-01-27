<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apartments', function (Blueprint $table) {
            $table->id();
            // ? Chiave esterna
            $table->unsignedBigInteger('user_id');
            // ? Gestione Delete alla cancellazione di un utente con appartamento
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->string('title', 100);
            $table->text('description');
            $table->tinyInteger('rooms_number')->default(1);
            $table->tinyInteger('bathrooms_number')->default(1);
            $table->tinyInteger('beds_number')->default(1);
            $table->string('square_meters', 6);
            $table->float('price_per_night', 7, 2);
            $table->boolean('is_visible')->default(true);
            $table->string('address');
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
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
        Schema::dropIfExists('apartments');
    }
}
