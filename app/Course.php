<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = 'control_panel_course';
    protected $primaryKey = 'id';
    public $keyType = 'string';
    protected $connection = 'pgsql';
    protected $fillable = [
        'name', 'id','is_active',
    ];

    public function chapters()
    {
        return $this->hasMany('App\Chapter');
    }
}
