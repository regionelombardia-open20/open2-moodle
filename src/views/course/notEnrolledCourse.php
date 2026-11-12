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

use open20\amos\core\helpers\Html;
use open20\amos\core\views\DataProviderView;
use open20\amos\core\icons\AmosIcons;
use open20\amos\moodle\AmosMoodle;
use open20\amos\moodle\models\Topic;

$this->title = $course->name;
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="moodle-not-enrolled">
<?php
if (!$courseEnrolled) {
    if ($selfEnrollment) {
        $enrolUrl = [
            'enrol-in-course',
            'id' => $course->id,
            'uid' => $uid,
            'org' => $org
        ];
        ?>
        <div class="text-center col-sm-8 col-sm-offset-2 col-xs-12">
            <h2>
                <?= AmosIcons::show('check-circle', ['class' => 'am-4 text-success']) ?>
                <br /><?= AmosMoodle::_t('#ok_iscrizione_corso') ?>
            </h2>
            <?= Html::a(AmosMoodle::_t('#enrolme', [
                'modelClass' => 'Moodle Topic',
            ]), $enrolUrl, ['class' => 'btn btn-amministration-primary'])
            ?>
        </div>
        <?php
    } else {
        $askEnrolmentClosedCourseUrl = [
            'ask-enrolment-in-closed-course',
            'id' => $course->id,
            'uid' => $uid,
            'org' => $org
        ];
    ?>
    
    <div class="text-center">
        <div><h3><strong><?= AmosMoodle::_t('#course_intro') ?></strong></div>
        <?= $courseInfo['summary']; ?>
    </div>


    
    
        <div class="text-center">
            <h2 class="text-danger"><?= AmosIcons::show('alert-circle', ['class' => 'am-4']) ?>
                <br /><?= AmosMoodle::_t('#warning') ?>
            </h2>
            <?= AmosIcons::show('chevron-down', ['class' => 'am-4 text-danger']) ?>
            <h3><strong><?= AmosMoodle::_t('#gentle_user') ?></strong>,
                <br /><?=  AmosMoodle::_t('#not_public_course') ?>
                <br />
                <br />
              <?= AmosMoodle::_t('#need_subscription_request') ?>
            </h3>

            <?= Html::a(AmosMoodle::_t('#request_subscription', [
                'modelClass' => 'Moodle Topic',
            ]), $askEnrolmentClosedCourseUrl, ['class' => 'btn btn-amministration-primary'])
            ?>
            <br /> <br />
            <p><?= AmosMoodle::_t('#subscription_already_request') ?></p>
        </div>
        <?php
    }
} else {
?>
    <div class="text-center">
        <h2 class="text-success"><?= AmosIcons::show('check-circle', ['class' => 'am-4']) ?>
            <br /><?= AmosMoodle::_t('#congrats') ?>
        </h2>
        <?= AmosIcons::show('chevron-down', ['class' => 'am-4 text-success']) ?>
        <h3><strong><?= AmosMoodle::_t('#gentle_user') ?></strong>,
            <br /><?= AmosMoodle::_t('#user_already_subscribed') ?>
        </h3>
    </div>
<?php } ?>

</div>
