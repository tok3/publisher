<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Tok3PublisherAddTagForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('tok3_publisher_page_tag', function (Blueprint $table) {

            $table->foreign('page_id')->references('id')->on('tok3_publisher_pages')->onDelete('cascade');
        $table->foreign('tag_id')->references('id')->on('tok3_publisher_tags')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
         Schema::table('tok3_publisher_page_tag', function ($table)
       {

           $table->dropForeign('tok3_publisher_page_tag_page_id_foreign');
           $table->dropForeign('tok3_publisher_page_tag_tag_id_foreign');
       });


    }
}
