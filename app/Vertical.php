<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vertical extends Model
{
    protected $table = 'control_panel_course_verticals';
    protected $primaryKey = 'module_id';
    public $keyType = 'string';
    protected $connection = 'pgsql';
    protected $fillable = [
        'display_name', 'module_id','vertical_id'
    ];

    public function resources()
    {
        return $this->hasMany('App\Resource','vertical_id');
    }
}
