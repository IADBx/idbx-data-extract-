<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sequential extends Model
{
    protected $table = 'control_panel_course_sequentials';
    protected $primaryKey = 'module_id';
    public $keyType = 'string';
    protected $connection = 'pgsql';
    protected $fillable = [
        'display_name', 'module_id','chapter_id'
    ];

    public function verticals()
    {
        return $this->hasMany('App\Vertical','sequential_id');
    }
    
}
