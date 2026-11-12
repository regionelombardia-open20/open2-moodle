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

namespace open20\amos\moodle\widgets\icons;

use open20\amos\moodle\AmosMoodle;
use open20\amos\core\widget\WidgetIcon;
use Yii;
use yii\helpers\ArrayHelper;

class WidgetIconMoodleLessons extends WidgetIcon {

    public function init() {
        parent::init();

       
        $this->setLabel(\Yii::t('open20\amos\moodle\widgets\icons' , 'Lezioni'));
        $this->setDescription(Yii::t('open20\amos\moodle\widgets\icons', 'Le lezioni del corso'));

        $this->setIcon('book');
        $this->setIconFramework('dash');

 //pr(Yii::$app->getUser()->can("MOODLE_ADMIN"),"user");
        $targetUrl = Yii::$app->urlManager->createUrl(['/moodle/topic/index']);
        if (Yii::$app->getUser()->can(AmosMoodle::MOODLE_ADMIN)) {
             $targetUrl = Yii::$app->urlManager->createUrl(['/moodle/administration/index']);
        }
        $this->setUrl($targetUrl);
        $this->setModuleName('moodle');
        $this->setNamespace(__CLASS__);
        $this->setClassSpan(ArrayHelper::merge($this->getClassSpan(), [
            'bk-backgroundIcon',
            'color-primary'
        ]));
    }

}