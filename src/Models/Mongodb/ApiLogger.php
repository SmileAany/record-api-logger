<?php

namespace Smbear\RecordApiLogger\Models\Mongodb;

use Jenssegers\Mongodb\Eloquent\Model;

class ApiLogger extends Model
{
    const UPDATED_AT = NULL;

    protected $connection = 'mongodb';

    protected $collection = 'record_api';

    protected $fillable = [
        'ip','method','path','params','server','response','time','created_at'
    ];

    protected static function boot()
    {
        parent::boot();

        //删除api的时候，删除query
        static::deleting(function($api) {
            $api->queries()->delete();
        });
    }

    public function queries()
    {
        return $this->hasMany(QueryLogger::class,'model_id','id');
    }
}