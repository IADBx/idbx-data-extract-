<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    protected $table = 'control_panel_course_resources';
    protected $primaryKey = 'module_id';
    public $keyType = 'string';
    protected $connection = 'pgsql';
    protected $fillable = [
        'display_name', 'module_id','resource_id'
    ];
    public function questions()
    {
        return $this->hasMany('App\Question','resource_id');
    }
    public function answers()
    {
        return $this->hasMany('App\Answer','resource_id');
    }
    public function comments()
    {
        return $this->hasMany('App\Comment','resource_id');
    }
}
