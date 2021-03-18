<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecordApiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('record_api', function (Blueprint $table) {
            $table->id();
            $table->ipAddress('ip')->nullable(false)->comment('请求ip地址');
            $table->unsignedTinyInteger('method')->nullable(false)->comment('请求类型');
            $table->string('params','500')->nullable()->comment('请求参数');
            $table->string('path','200')->nullable(false)->comment('请求地址');
            $table->string('server','50')->nullable(false)->comment('服务名称');
            $table->mediumText('response')->nullable(true)->comment('相应信息');
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
        Schema::dropIfExists('record_api');
    }
}
