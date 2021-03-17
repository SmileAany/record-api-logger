<?php

namespace Smbear\RecordApiLogger\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Smbear\RecordApiLogger\Models\ApiLogger;
use Smbear\RecordApiLogger\Exceptions\ConfigException;
use Smbear\RecordApiLogger\Models\Mongodb\ApiLogger AS MongodbApiLogger;

class CleanRecordLogger extends Command
{
    protected $signature = 'clear:api-logger';

    protected $description = '清除历史接口日志';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        if ( !in_array(config('record_api_logger.default'),['mongodb','database']) ){
            throw new ConfigException('配置文件，字段default设置错误！',500);
        }

        $days = config('record_api_logger.days');

        if ($days < 0 || !is_int($days)){
            throw new ConfigException('配置文件，字段days设置错误！',500);
        }

        if ( config('record_api_logger.default') == 'mongodb' ){
            $model = MongodbApiLogger::class;
        }else {
            $model = ApiLogger::class;
        }

        $model::where('created_at','>',Carbon::now()->subDays($days))
            ->get()
            ->map(function ($api){
                $api->delete();
            });
    }
}