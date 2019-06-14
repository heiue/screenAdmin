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
    protected $fillable = ['projectTitle', 'projectType', 'introduction', 'isPublic', 'remark', 'cover', 'financing'];
    protected $appends = ['project_type_name', 'track_count', 'collection_user_count'];

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

    /**
     * @remark 项目类型名字
     * @return mixed|string
     * 院线电影 电视剧 网络大电影 网络剧 央6 舞台剧 短视频 小说
     */
    public function getProjectTypeNameAttribute() {
        $projectType = [
            '1' => '院线电影',
            '2' => '电视剧',
            '3' => '网络大电影',
            '4' => '网络剧',
            '5' => '央6',
            '6' => '舞台剧',
            '7' => '短视频',
            '8' => '小说'
        ];
        return $this->projectType ? $projectType[$this->projectType] : '';
    }

    /**
     * @remark 收藏项目的用户数
     */
    public function getCollectionUserCountAttribute() {
        return CardCollection::where(['rid' => $this->id, 'rType' => 2])->count();
    }
}