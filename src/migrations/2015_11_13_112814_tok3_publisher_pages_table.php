<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Tok3PublisherPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tok3_publisher_pages', function (Blueprint $table)
        {
            $table->increments('id');
            $table->string('slug')
                ->unique();
            $table->string('title');
            $table->string('heading');
            $table->text('teaser');
            $table->text('text');
            $table->string('meta_description');
            $table->string('meta_keywords');
            $table->string('schema');
            $table->string('open_graph');
            $table->integer('published');
            $table->integer('domain_id')
            ->default(0);
            $table->string('ip')
                ->length(39);
            $table->timestamp('published_at');
            $table->timestamp('published_till');
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tok3_publisher_pages');
    }
}
