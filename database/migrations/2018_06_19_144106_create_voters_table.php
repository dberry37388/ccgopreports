<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVotersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('voters', function (Blueprint $table) {
            $table->increments('id');
            $table->string('state_id')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('title')->nullable();
            $table->integer('house_number')->nullable();
            $table->string('street_address')->nullable();
            $table->string('address')->nullable();
            $table->string('address2')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zip')->nullable();
            $table->string('phone')->nullable();
            $table->string('pct_nbr')->nullable();
            $table->integer('pct')->nullable();
            $table->integer('pct_sub')->nullable();
            $table->string('mail')->nullable();
            $table->string('mail_city')->nullable();
            $table->string('mail_state')->nullable();
            $table->string('mail_zip')->nullable();
            $table->string('e_1')->nullable();
            $table->string('e_2')->nullable();
            $table->string('e_3')->nullable();
            $table->string('e_4')->nullable();
            $table->string('e_5')->nullable();
            $table->string('e_6')->nullable();
            $table->string('e_7')->nullable();
            $table->string('e_8')->nullable();
            $table->string('e_9')->nullable();
            $table->string('e_10')->nullable();
            $table->string('e_11')->nullable();
            $table->string('e_12')->nullable();
            $table->string('e_13')->nullable();
            $table->string('e_14')->nullable();
            $table->string('e_15')->nullable();
            $table->tinyInteger('republican_votes')->default(0);
            $table->tinyInteger('democrat_votes')->default(0);
            $table->tinyInteger('nonparty_votes')->default(0);
            $table->tinyInteger('total_votes')->default(0);
            $table->double('longitude')->nullable();
            $table->double('latitude')->nullable();
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
        Schema::dropIfExists('voters');
    }
}
