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
            return ($card = CardCard::where(['id' => $this->rid])->first()) ? $card : [];
        } else if ($this->rType == 2) {
            return ($pro = CardProject::where(['id' => $this->rid])->first()) ? $pro : [];
        } else if ($this->rType == 3) {
            return ($pro = script::where(['id' => $this->rid])->first()) ? $pro : [];
        } else if ($this->rType == 4) {
            return ($pro = Screenwriter::where(['id' => $this->rid])->first()) ? $pro : [];
        } else {
            return [];
        }
    }
}