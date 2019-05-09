<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/6
 * Time: 21:40
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Script extends Model
{
    protected $fillable = ['scriptTitle', 'scriptType', 'scriptTheme'];
    protected $table = 'card_scripts';
}