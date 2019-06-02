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
    protected $fillable = ['projectTitle', 'projectType', 'introduction', 'isPublic', 'remark', 'cover'];
    protected $appends = ['project_type_name', 'track_count'];

    /**
     * @remark 联查附件表里的图片
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cardAnnexImg() {
        return $this->hasMany('App\Models\CardAnnex', 'aboutId');
    }

    /**
     * @remark 联查跟踪记录的条数
     */
    public function cardTrackCount() {
        return $this->hasMany('App\Models\CardProjectTrack', 'projectId');
    }

    /**
     * @remark 跟踪记录条数
     */
    public function getTrackCountAttribute() {
        return CardProjectTrack::where(['projectId' => $this->id])->count();
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