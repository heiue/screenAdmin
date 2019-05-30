<?php
/**
 * Created by PhpStorm.
 * User: mr.heiue
 * Date: 2019/5/14
 * Time: 5:39 PM
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class CardCard extends Model
{
    protected $fillable = ['uid','style_group_id','name','company','position'];

    public function cardInfo() {
        return $this->hasOne('App\Models\CardInfo', 'card_id');
    }
}