<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "store_schedule".
 *
 * @property int $id
 * @property int $owner_id
 * @property string $open
 * @property string $close
 * @property int $days_mask
 *
 * @author Yukal Alexander <yukal.alexander@gmail.com>
 * @link https://github.com/yukal/
 * @copyright 2018 MIT
 * @license https://opensource.org/licenses/MIT
 */
class StoreSchedule extends \yii\db\ActiveRecord
{
    const SCENARIO_SEARCH = 'search';

    public $name;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'store_schedule';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['owner_id'], 'required'],
            [['id', 'owner_id', 'days_mask'], 'integer'],
            [['open', 'close', 'days_mask'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_SEARCH] = ['open', 'close', 'days_mask'];

        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'owner_id' => 'Store ID',
            'open' => 'Open',
            'close' => 'Close',
            'days_mask' => 'Schedule',
        ];
    }

    public function getAttributeDays()
    {
        return [
            Store::ON_MONDAY => 'Пн',
            Store::ON_TUESDAY => 'Вт',
            Store::ON_WEDNESDAY => 'Ср',
            Store::ON_THURSDAY => 'Чт',
            Store::ON_FRIDAY => 'Пт',
            Store::ON_SATURDAY => 'Сб',
            Store::ON_SUNDAY => 'Нд',
        ];
    }

    /**
     * @inheritdoc
     */
    public function search()
    {
        $query = self::find()
            ->from(self::tableName() . ' t')
            ->select('s.name, t.id, t.owner_id, t.open, t.close, t.days_mask')
            ->leftJoin('store s', 's.id = t.owner_id');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!$this->validate('open, close, days_mask')) {
            return $dataProvider;
        }

        if (!empty($this->open))
            $dataProvider->query->andWhere(['<=', 't.open', $this->open]);

        if (!empty($this->close))
            $dataProvider->query->andWhere(['>=', 't.close', $this->close]);

        if (!empty($this->days_mask))
            $dataProvider->query->andWhere($this->days_mask . ' & days_mask = ' . $this->days_mask);

        return $dataProvider;
    }

    public function addSchedule($store_id, $store_opens, $store_closes, $days_mask)
    {
        $sql = "INSERT INTO `" . self::tableName() . "` 
            (`owner_id`, `open`, `close`, days_mask) VALUES (:owner_id, :open, :close, :days_mask)";

        $params = [
            ':owner_id' => $store_id,
            ':open' => $store_opens,
            ':close' => $store_closes,
            ':days_mask' => $days_mask,
        ];

        return $this->db->createCommand($sql, $params)->execute();
    }

    public function getSchedule($daysMask = False)
    {
        $schedule = [];

        if (empty($daysMask))
            $daysMask = $this->days_mask;


        if (Store::ON_MONDAY == (Store::ON_MONDAY & $daysMask))
            array_push($schedule, 'Пн');

        if (Store::ON_TUESDAY == (Store::ON_TUESDAY & $daysMask))
            array_push($schedule, 'Вт');

        if (Store::ON_WEDNESDAY == (Store::ON_WEDNESDAY & $daysMask))
            array_push($schedule, 'Ср');

        if (Store::ON_THURSDAY == (Store::ON_THURSDAY & $daysMask))
            array_push($schedule, 'Чт');

        if (Store::ON_FRIDAY == (Store::ON_FRIDAY & $daysMask))
            array_push($schedule, 'Пт');

        if (Store::ON_SATURDAY == (Store::ON_SATURDAY & $daysMask))
            array_push($schedule, 'Сб');

        if (Store::ON_SUNDAY == (Store::ON_SUNDAY & $daysMask))
            array_push($schedule, 'Нд');

        return implode(', ', $schedule);
    }

}
