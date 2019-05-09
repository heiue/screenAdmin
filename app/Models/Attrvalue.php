<?php
/**
 * Created by PhpStorm.
 * User: x1c
 * Date: 2019/1/28
 * Time: 14:39
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Attrvalue extends Model
{
    protected $table = 'z_attrvalue';
    protected $fillable = ['name_id','value','img'];

    public function attrname() {
        return $this->belongsTo('App\Models\Attrname','name_id','id');
    }
}