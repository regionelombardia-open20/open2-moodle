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
 * This is the model class for Moodle Topic
 */
class Topic extends Model
{
    /**
     * 
     */
    const TOPIC_STATUS_COMPLETED = 1;
    const TOPIC_STATUS_UNCOMPLETED = 0;

    /**
     *
     * @var type 
     */
    public $id;
    public $courseId;
    public $nome;
    public $num_attivita_tot;
    public $num_attivita_completate;
    public $avanzamento_attivita;
    public $stato;
    public $created_by = null;
    
    /**
     *
     * @var type 
     */
    public $description;

    /**
     * 
     * @return type
     */
    public function rules()
    {
        return [
            /*  [['$num_attivita_tot', 'completato', 'courseId'], 'integer'],
              [['nome'], 'string', 'max' => 255], */
        ];
    }

    /**
     * 
     */
    public function getWorkflowStatus() {}
    
    /**
     * 
     * @return type
     */
    public function attributeLabels()
    {
        return [
            //'id' => AmosMoodle::_t('ID'),
            'nome' => AmosMoodle::_t('Argomento'),
            'avanzamento_attivita' => AmosMoodle::_t('Numero attività completate / numero attività totali'),
            'stato' => AmosMoodle::_t('Stato'),
            //'courseId' => AmosMoodle::_t('Id Corso'),
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
     * @param type $contentsList
     * @return array
     */
    public function getTopicList($contentsList)
    {
        $topicList = array();
        foreach ($contentsList as $contents) {
            $newTopic = new Topic();
            $newTopic->id = $contents["id"];
            $newTopic->courseId = $this->courseId;
            $newTopic->nome = $contents["name"];
            $newTopic->num_attivita_tot = sizeof($contents["modules"]);
            $newTopic->num_attivita_completate = $contents["moodleActivitiesCompleted"];
            $newTopic->avanzamento_attivita = $newTopic->num_attivita_completate
                . ' / '
                . $newTopic->num_attivita_tot;

            if ($newTopic->num_attivita_completate == $newTopic->num_attivita_tot) {
                $newTopic->stato = self::TOPIC_STATUS_COMPLETED;
            } else {
                $newTopic->stato = self::TOPIC_STATUS_UNCOMPLETED;
            }
            
            array_push($topicList, $newTopic);
        }

        return $topicList;
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
