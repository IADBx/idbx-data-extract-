<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table = 'control_panel_course_answers_students';
    protected $primaryKey = 'module_id';
    public $keyType = 'string';
    protected $connection = 'pgsql';
    protected $fillable = [
        'display_name', 'module_id','question_id'
    ];
    public function answer()
    {
        return $this->belongsTo('App\Answer','answer_id');
    }
}
