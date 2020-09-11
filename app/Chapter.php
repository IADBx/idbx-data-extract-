<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    protected $table = 'control_panel_course_chapters';
    protected $primaryKey = 'module_id';
    public $keyType = 'string';
    protected $connection = 'pgsql';
    protected $fillable = [
        'display_name', 'module_id','course_id'
    ];
    public function sequentials()
    {
        return $this->hasMany('App\Sequential','chapter_id');
    }
}
