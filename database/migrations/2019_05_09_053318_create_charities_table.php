<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCharitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('charities', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cause_cat_id')->nullable();
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->text('description')->nullable();
            $table->string('shop_link')->nullable();
            $table->date('end_date')->nullable();
            $table->string('total_goals')->nullable();
            $table->string('achieved_goals')->nullable();
            $table->string('total_supporters')->nullable();
            $table->string('logo')->nullable();
            $table->string('image')->nullable();
            $table->text('photos')->nullable();
            $table->string('video_url')->nullable();
            $table->integer('is_verified')->default(1);
            $table->integer('is_completed')->default(0);
            $table->integer('status')->default(1);
            $table->integer('trash')->default(0);
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
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
        Schema::dropIfExists('charities');
    }
}
