<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $table = 'control_panel_course_report_general';
    protected $primaryKey = 'id';
    public $keyType = 'string';
    protected $connection = 'pgsql';
    protected $fillable = [
        'course_id','name'
    ];
}
