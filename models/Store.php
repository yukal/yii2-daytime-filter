<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "store".
 *
 * @property int $id
 * @property string $name
 *
 * @author Yukal Alexander <yukal.alexander@gmail.com>
 * @link https://github.com/yukal/
 * @copyright 2018 MIT
 * @license https://opensource.org/licenses/MIT
 */
class Store extends \yii\db\ActiveRecord
{
    const ON_MONDAY = 2;
    const ON_TUESDAY = 4;
    const ON_WEDNESDAY = 8;
    const ON_THURSDAY = 16;
    const ON_FRIDAY = 32;
    const ON_SATURDAY = 64;
    const ON_SUNDAY = 128;

    // From Monday to Friday
    const ON_WORKDAYS = 62;

    // On weekends
    const ON_WEEKENDS = 192;

    // On whole week
    const ON_WEEK = 254;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'store';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 128],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

}
