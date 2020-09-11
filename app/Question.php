<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = 'control_panel_course_resource_questions';
    protected $primaryKey = 'module_id';
    public $keyType = 'string';
    protected $connection = 'pgsql';
    protected $fillable = [
        'display_name', 'module_id','resource_id'
    ];

    public function students()
    {
        return $this->hasMany('App\Student','question_id');
    }
}
