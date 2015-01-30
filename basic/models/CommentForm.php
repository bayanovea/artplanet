<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * PostForm is the model behind the add post form.
 */
class CommentForm extends Model
{
	public $content;

	/**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name and content are required
            [['content'], 'required']
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'content' => 'Комментарий'
        ];
    }
}