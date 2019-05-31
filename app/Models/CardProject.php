<?php
/**
 * Created by PhpStorm.
 * User: mr.heiue
 * Date: 2019/5/12
 * Time: 9:21 AM
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class CardProject extends Model
{
    protected $table = 'card_projects';
    protected $fillable = ['projectTitle', 'projectType', 'introduction', 'isPublic', 'remark'];
    protected $appends = ['project_type_name'];

    public function cardAnnexImg() {
        return $this->hasMany('App\Models\CardAnnex', 'aboutId');
    }

    public function getProjectTypeNameAttribute() {
        $projectType = [
            '1' => '小说',
            '2' => '网剧',
            '3' => '综艺',
            '4' => '电视剧',
        ];
        return $this->projectType ? $projectType[$this->projectType] : '';
    }
}