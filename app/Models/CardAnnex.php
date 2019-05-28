<?php
/**
 * Created by PhpStorm.
 * User: mr.heiue
 * Date: 2019/5/26
 * Time: 6:08 PM
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CardAnnex extends Model
{


    //插入多条数据
    public function addAll(Array $data)
    {
        $rs = DB::table($this->getTable())->insert($data);
        return $rs;
    }
}