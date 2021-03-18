<?php

namespace Smbear\RecordApiLogger\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Smbear\RecordApiLogger\Models\ApiLogger;
use Smbear\RecordApiLogger\Models\QueryLogger;
use Smbear\RecordApiLogger\Models\Mongodb\ApiLogger AS MongodbApiLogger;
use Smbear\RecordApiLogger\Models\Mongodb\QueryLogger AS MongodbQueryLogger;


class SaveApiLoggerData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public array $params;

    public int $timeout;

    public int $tries;

    /**
     * Create a new job instance.
     * @param array
     * @return void
     */
    public function __construct($params = [])
    {
        $this->params = $params;

        $this->timeout = 60;

        $this->tries = 3;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (config('record_api_logger.default') == 'mongodb'){

            DB::transaction(function () {
                $api = MongodbApiLogger::create($this->params['request']);

                foreach ($this->params['query'] as $value){
                    $api->queries()->create(array_merge($value,[
                        'model_type' => MongodbQueryLogger::class
                    ]));
                }
            });
        }

        if (config('record_api_logger.default') == 'database'){

            DB::transaction(function () {
                $api = ApiLogger::create($this->params['request']);

                foreach ($this->params['query'] as $value){
                    $api->queries()->create(array_merge($value,[
                        'model_type' => QueryLogger::class
                    ]));
                }
            });
        }
    }
}
