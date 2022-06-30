<?php

namespace open20\amos\moodle\models;

use open20\amos\moodle\AmosMoodle;
use Yii;
use yii\helpers\ArrayHelper;
use yii\base\Model;

/**
 * This is the model class for Moodle Ranking
 */
class Ranking extends Model
{

    public $position;
    public $name;
    public $picture;
    public $points;

    public function rules()
    {
        return [
            /* [['num_lezioni', 'completato', 'courseId'], 'integer'],
              [['nome'], 'string', 'max' => 255], */
        ];
    }

    public function attributeLabels()
    {
        return [
            'position' => AmosMoodle::_t('Posizione'),
            'name' => AmosMoodle::_t('Nome'),
            'points' => AmosMoodle::_t('Punti'),
            'picture' => AmosMoodle::_t('Foto'),
        ];
    }

    /**
     * inserire il campo o i campi rappresentativi del modulo
     * @return type
     */
    public function representingColumn()
    {
        return [];
    }

    /**
     * 
     * @return type
     */
    public function attributeHints()
    {
        return [];
    }

    /**
     * Returns the text hint for the specified attribute.
     * @param string $attribute the attribute name
     * @return string the attribute hint
     */
    public function getAttributeHint($attribute)
    {
        $hints = $this->attributeHints();

        return isset($hints[$attribute]) ? $hints[$attribute] : null;
    }

    /**
     * 
     * @param type $rankingArray
     * @return array
     */
    public function getRankingObjectList($rankingArray)
    {
        $rankingObjectList = array();
        foreach ($rankingArray as $current) {
            $newRanking = new Ranking();
            $newRanking->position = $current["position"];
            $newRanking->name = $current["name"];
            $newRanking->picture = $current["picture"];
            $newRanking->points = $current["points"];

            array_push($rankingObjectList, $newRanking);
        }
        
        return $rankingObjectList;
    }

    /**
     * 
     * @return string
     */
    public function __toString()
    {
        return '';
    }

}
