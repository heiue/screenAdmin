<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/1
 * Time: 14:18
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Screenwriter extends Model
{
    protected $fillable = ['id','name','rating','residence','avatar', 'isPublic', 'isHot','introduction'];
    protected $table = 'card_screenwriters';
    protected $appends = ['rating_name'];

    public function getRatingNameAttribute($value)
    {
        $rating = [
            '1' => '金牌编剧',
            '2' => '著名编剧',
            '3' => '知名编剧',
            '4' => '新锐编剧',
        ];
        return $this->rating ? $rating[$this->rating] : '';
    }
}