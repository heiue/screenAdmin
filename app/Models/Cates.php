<?php
/**
 * Created by PhpStorm.
 * User: x1c
 * Date: 2019/3/1
 * Time: 10:53
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Cates extends Model
{
    protected $table = 'z_cates';
    protected $fillable = ['pid','ord','title','status'];


    //子分类
    public function childs()
    {
        return $this->hasMany('App\Models\Cates','pid','id');
    }

}