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
    protected $fillable = ['uid','style_group_id','name','company','position','pic', 'industry_id'];
    protected $appends = ['industry_name'];

    public function cardInfo() {
        return $this->hasOne('App\Models\CardInfo', 'card_id');
    }

    public function cardUser() {
        return $this->hasOne('App\Models\CardUser', 'id', 'uid');
    }

    public function getIndustryNameAttribute() {
        $id = $this->industry_id ? $this->industry_id : 0;
        return CardIndustry::where(['id' => $id])->value('name');
    }
}