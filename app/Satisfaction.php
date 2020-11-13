<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Satisfaction extends Model
{
    protected $table = 'control_panel_course_report_satisfaction';
    protected $primaryKey = 'id_satisfaction';    
    protected $connection = 'pgsql';
    protected $fillable = [
        'course_id','name'
    ];
}
