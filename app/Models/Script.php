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
    protected $fillable = ['scriptTitle', 'scriptType', 'scriptTheme', 'cover'];
    protected $table = 'card_scripts';
    protected $appends = ['script_type_name', 'script_theme_name'];

    public function getScriptTypeNameAttribute() {
        $scriptType = [
            '1' => '小说',
            '2' => '网剧',
            '3' => '综艺',
            '4' => '电视剧',
        ];

        return $this->scriptType ? $scriptType[$this->scriptType] : '';
    }

    public function getScriptThemeNameAttribute() {
        $scriptTheme = [
            '1' => '都市',
            '2' => '剧情',
            '3' => '民国',
            '4' => '犯罪',
        ];

        return $this->scriptTheme ? $scriptTheme[$this->scriptTheme] : '';
    }

}