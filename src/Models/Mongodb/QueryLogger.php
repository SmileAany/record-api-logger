<?php

namespace Smbear\RecordApiLogger\Models\Mongodb;

use Jenssegers\Mongodb\Eloquent\Model;

class QueryLogger extends Model
{
    const UPDATED_AT = NULL;

    protected $connection = 'mongodb';

    protected $collection = 'record_query';

    protected $fillable = [
        'ip','model_type','model_id','database','sql','time','created_at'
    ];
}