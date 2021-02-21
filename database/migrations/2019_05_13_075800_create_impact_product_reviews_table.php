<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImpactProductReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('impact_product_reviews', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('impact_product_id')->nullable();
            $table->integer('store_cat_id')->nullable();
            $table->string('name')->nullable();
            $table->string('image')->nullable();
            $table->string('youtube_url')->nullable();
            $table->integer('status')->default(1);
            $table->integer('trash')->default(0);
            $table->integer('created_by')->nullable(0);
            $table->integer('updated_by')->nullable(0);
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
        Schema::dropIfExists('impact_product_reviews');
    }
}
