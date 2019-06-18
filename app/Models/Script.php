<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/6
 * Time: 21:40
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Script extends Model
{
    protected $fillable = ['scriptTitle', 'scriptType', 'scriptTheme', 'cover', 'introduction', 'keyword'];
    protected $table = 'card_scripts';
    protected $appends = ['script_type_name', 'script_theme_name'];

    public function getScriptTypeNameAttribute() {
        $scriptType = [
            '1' => '院线电影',
            '2' => '电视剧',
            '3' => '网络大电影',
            '4' => '网络剧',
            '5' => '央6',
            '6' => '舞台剧',
            '7' => '短视频',
            '8' => '小说',
        ];

        return $this->scriptType ? $scriptType[$this->scriptType] : '';
    }

    public function getScriptThemeNameAttribute() {
        $scriptTheme = [
            '1' => '犯罪',
            '2' => '悲剧',
            '3' => '喜剧',
            '4' => '爱情',
            '5' => '动作',
            '6' => '枪战',
            '7' => '惊悚',
            '8' => '恐怖',
            '9' => '悬疑',
            '10' => '动画',
            '11' => '奇幻',
            '12' => '魔幻',
            '13' => '科幻',
            '14' => '战争',
            '15' => '剧情片',
            '16' => '伦理片',
            '17' => '传记片',
            '18' => '青春',
            '19' => '歌舞',
            '20' => '热血',
            '21' => '冒险',
            '22' => '校园',
            '23' => '运动',
            '24' => '历史',
            '25' => '励志',
            '26' => '古装',
            '27' => '言情',
            '28' => '军事',
            '29' => '警匪',
            '30' => '武侠',
            '31' => '农村',
            '32' => '都市',
            '33' => '神话',
            '34' => '玄幻',
            '35' => '谍战',
            '36' => '年代',
            '37' => '儿童',
            '38' => '音乐',
            '39' => '西部',
            '40' => '治愈',
            '41' => '史诗',
            '42' => '主旋律',
            '43' => '军旅',
            '44' => '抗战',
            '45' => '江湖',
            '46' => '现代',
            '47' => '公路',
            '48' => '商战',
            '49' => '民国',
            '50' => '仙侠',
            '51' => '宫廷',
            '52' => '穿越',

        ];

        return $this->scriptTheme ? $scriptTheme[$this->scriptTheme] : '';
    }

}