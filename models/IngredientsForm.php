<?php

namespace app\models;

use Yii;
use yii\base\Model;

class IngredientsForm extends Model
{
    public $ingredients;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['ingredients'], 'required'],
            [['ingredients'], 'checkIsArray']
        ];
    }
    public function checkIsArray( $attribute , $params ) {

        if ( count ( $this->ingredients ) > 5 ) {
            $this->addError ( $attribute , "Выберите не более 5 ингредиентов" );
        } elseif ( count ( $this->ingredients ) < 2 ) {
            $this->addError ( $attribute , "Выберите больше ингредиентов" );
        }
    }


    public function login()
    {
        if ($this->validate()) {

        }
        return false;
    }
}
