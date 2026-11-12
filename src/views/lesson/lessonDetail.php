<?php

/**
 * Aria S.p.A.
 * OPEN 2.0
 *
 * @package   open20\amos\moodle
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
/** @var \open20\amos\dashboard\models\AmosUserDashboards $currentDashboard * */

/** @var \yii\web\View $this * */
use open20\amos\core\helpers\Html;
use open20\amos\core\icons\AmosIcons;
use open20\amos\core\utilities\ModalUtility;
use open20\amos\core\views\DataProviderView;
use open20\amos\moodle\AmosMoodle;

use open20\amos\moodle\models\ServiceCall;
use open20\amos\moodle\helpers\MoodleHelper;

/**
 * @var yii\web\View $this
 * @var  $scormDetails
 */
?>
<?= $scormDetails['scormstatus']; ?>

<?= Html::a(
    AmosMoodle::_t('#course_enter', [
        'modelClass' => 'Moodle Topic',
    ]),
    MoodleHelper::getMoodleOAuthLink($scormDetails['playerurl']), 
    [
        'id' => 'btn-get-resource',
        'class' => 'btn btn-primary js-btn-entra',
        'target' => '_blank'
    ]
);
?>

<?php 
/*
if (!empty($scormDetails['playerurl'])) {
    if (!$close) {
        echo Html::a(Yii::t('cruds', 'Entra', [
                    'modelClass' => 'Moodle Topic',
                ]), 
                MoodleHelper::getMoodleOAuthLink($scormDetails['playerurl']), 
                [
                    'class' => 'btn btn-amministration-primary js-btn-entra',
                    'target' => '_blank']);
    }
}
if ($close) {
    echo Html::a(Yii::t('cruds', 'Chiudi', [
                'modelClass' => 'Moodle Topic',
            ]), 
            null, 
            [
                'class' => 'btn btn-amministration-primary js-btn-close', 
                'data-dismiss' => "modal",
                'target' => '_blank']
            );
}
*/