<?php

namespace Smbear\RecordApiLogger\Models;

use Illuminate\Database\Eloquent\Model;

class QueryLogger extends Model
{
    const UPDATED_AT = NULL;

    protected $table = 'record_query';

    protected $fillable = [
        'ip','model_type','model_id','database','sql','time','created_at'
    ];

}