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

namespace open20\amos\moodle\models\base;

use common\models\User;
use open20\amos\moodle\AmosMoodle;
use Yii;

/**
 * This is the base-model class for table "moodle_user".
 *
 * @property integer $id
 * @property string $moodle_name
 * @property string $moodle_surname
 * @property integer $moodle_userid
 * @property string $moodle_token
 * @property integer $user_id
 * @property string $moodle_username
 * @property string $moodle_password
 * @property string $moodle_email
 *
 * @property \open20\amos\moodle\models\User $user
 */
class MoodleUser 
    extends \open20\amos\core\record\Record
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'moodle_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['moodle_userid', 'user_id', 'moodle_email'], 'required'],
            [['moodle_userid', 'user_id'], 'integer'],
            [['moodle_username','moodle_password'], 'default', 'value'=> ''],
            [['moodle_name', 'moodle_surname', 'moodle_token', 'moodle_username', 'moodle_password', 'moodle_email'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => AmosMoodle::_t('ID'),
            'moodle_name' => AmosMoodle::_t('Nome utente Moodle'),
            'moodle_surname' => AmosMoodle::_t('Cognome utente Moodle'),
            'moodle_userid' => AmosMoodle::_t('ID utente Moodle'),
            'moodle_token' => AmosMoodle::_t('Token utente Moodle'),
            'user_id' => AmosMoodle::_t('Id Utente Open2.0'),
            'moodle_username' => AmosMoodle::_t('Username utente Moodle'),
            'moodle_password' => AmosMoodle::_t('Password utente Moodle'),
            'moodle_email' => AmosMoodle::_t('Email utente Moodle'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(\open20\amos\moodle\models\User::className(), ['id' => 'user_id']);
    }

}
