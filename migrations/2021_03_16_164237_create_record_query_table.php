<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecordQueryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('record_query', function (Blueprint $table) {
            $table->id();
            $table->string('model_type','50')->nullable(false)->comment('模型名称');
            $table->unsignedBigInteger('model_id')->nullable(false)->comment('模型id');
            $table->string('database','50')->nullable(false)->comment('数据库名称');
            $table->string('sql','500')->nullable(false)->comment('query语句');
            $table->unsignedFloat('time',12,6)->nullable(false)->comment('耗时时常 ms');
            $table->timestamp('created_at')->nullable(false)->comment('生产时间');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('record_query');
    }
}
