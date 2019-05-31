<?php
/**
 * Created by PhpStorm.
 * User: mr.heiue
 * Date: 2019/5/30
 * Time: 10:25 PM
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class CardInfo extends Model
{
    protected $table = 'card_card_infos';
    protected $fillable = ['card_id', 'uid', 'mobile', 'wechat', 'email', 'address', 'intro'];
}