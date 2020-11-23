<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = 'metadata_courses';
    protected $primaryKey = 'studio_id_1';
    public $keyType = 'string';
    protected $connection = 'pgsql';
    protected $fillable = [
        'name', 'studio_id_1','is_active',
    ];

    public function chapters()
    {
        return $this->hasMany('App\Chapter');
    }
}
