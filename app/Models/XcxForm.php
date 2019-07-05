<?php
/**
 * Created by PhpStorm.
 * User: mr.heiue
 * Date: 2019/7/4
 * Time: 3:18 PM
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class XcxForm extends Model
{
    public $fillable = ['openid', 'form_id', 'expires'];
}