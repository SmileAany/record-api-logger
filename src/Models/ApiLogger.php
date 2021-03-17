<?php

namespace Smbear\RecordApiLogger\Models;

use Illuminate\Database\Eloquent\Model;

class ApiLogger extends Model
{
    const UPDATED_AT = NULL;

    protected $table = 'record_api';

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

    protected function setMethodAttribute($value)
    {
        switch (strtolower($value)){
            case 'get':
                $method = 1;
                break;
            default:
                $method = 2;
        }

        $this->attributes['method'] = $method;
    }

    public function queries()
    {
        return $this->hasMany(QueryLogger::class,'model_id','id');
    }
}