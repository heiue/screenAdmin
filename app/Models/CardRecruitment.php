<?php
/**
 * Created by PhpStorm.
 * User: mr.heiue
 * Date: 2019/6/11
 * Time: 2:51 PM
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class CardRecruitment extends Model
{
    protected $fillable = ['position', 'address', 'education', 'experience', 'introduction', 'positionClaim'];


}