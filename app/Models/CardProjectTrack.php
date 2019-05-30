<?php
/**
 * Created by PhpStorm.
 * User: mr.heiue
 * Date: 2019/5/25
 * Time: 9:45 AM
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class CardProjectTrack extends Model
{
    protected $appends = ['admin_name'];

    public function getAdminNameAttribute() {
        if ($user = User::where(['id' => $this->adminUid])->first()) {
            return $user['username'];
        } else {
            return '';
        }
    }
}