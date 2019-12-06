<?php
namespace app\models;

use yii\db\ActiveRecord;

class News extends ActiveRecord
{

    public function rules() 
    {
        $rules = parent::rules();
        $newRules = [
            [['name','content'], 'safe']
        ];
        return ArrayHelper::merge($rules, $newRules);
    }
}