<?php
/**
 * Created by PhpStorm.
 * User: mr.heiue
 * Date: 2019/6/5
 * Time: 2:30 PM
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class CardElite extends Model
{
    protected $table = 'card_elite_articles';
    protected $fillable = ['category_id','title','keywords','description','content','thumb','click'];


}