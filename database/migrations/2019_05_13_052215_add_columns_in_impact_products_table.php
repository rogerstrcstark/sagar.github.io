<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsInImpactProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('impact_products', function (Blueprint $table) {
            $table->integer('store_cat_id')->after('store_id')->nullable();
            $table->string('rating')->after('impact')->nullable();
            $table->string('imapct_image')->after('rating')->nullable();
            $table->string('imapct_video_url')->after('imapct_image')->nullable();
            $table->integer('is_featured')->after('is_verified')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('impact_products', function (Blueprint $table) {
            //
        });
    }
}
