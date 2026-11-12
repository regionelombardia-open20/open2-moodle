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

use open20\amos\moodle\AmosMoodle;

$this->title = AmosMoodle::_t('#courses');
$this->params['breadcrumbs'][] = $this->title;

/**
 * @var yii\web\View $this
 * @var ebike\assets\models\EbikeAssets $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="moodle-category-form col-xs-12 nop">
    <div class="col-xs-12">
        <h2><?= AmosMoodle::_t('#warning_no_courses_available_yet') ?></h2>
    </div>
    <hr />
    <div class="col-xs-12">
        <?= AmosMoodle::_t('#message_no_courses_available_yet') ?>
    </div>
    <div class="col-xs-12 nop">
        <a class="btn btn-secondary pull-right" href="/"><?= AmosMoodle::_t('#btn_cancel') ?></a>
    </div>
</div>
