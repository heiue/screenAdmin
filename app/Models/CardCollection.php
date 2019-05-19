<?php
/**
 * Created by PhpStorm.
 * User: mr.heiue
 * Date: 2019/5/19
 * Time: 2:00 PM
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class CardCollection extends Model
{
    protected $appends = ['rid_info'];

    public function getRidInfoAttribute() {
        if ($this->rType == 1) {
            return ($card = CardCard::findOrFail($this->rid)) ? $card : [];
        } else if ($this->rType == 2) {
            return ($pro = CardProject::findOrFail($this->rid)) ? $pro : [];
        } else {
            return [];
        }
    }
}