<?php
/**
 * Aria S.p.A.
 * OPEN 2.0
 *
 * @package   open20\amos-moodle
 * @author    Aria S.p.A. <protocollo@pec.ariaspa.it>
 * @license   GNU General Public License v3.0 <https://www.gnu.org/licenses/gpl-3.0.html>
 * @link      https://www.ariaspa.it/
 *
 * This file is part of OPEN 2.0.
 *
 * OPEN 2.0 is free software: you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * OPEN 2.0 is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with OPEN 2.0. If not, see <https://www.gnu.org/licenses/>.
 */

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
