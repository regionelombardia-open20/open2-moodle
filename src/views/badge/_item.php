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

use open20\amos\core\icons\AmosIcons;
use open20\amos\core\helpers\Html;
/*
 * Personalizzare a piacimento la vista
 * $model è il model legato alla tabella del db
 * $buttons sono i tasti del template standard {view}{update}{delete}
 */

//pr($model, '$model');exit;

?>


<div class="listview-container news-item grid-item nop">
    <div class="post col-xs-12">
        <div class="post-content col-xs-12 nop">
            <div class="post-title col-xs-10">
                <?= Html::tag('h2', $model["name"]) ?>
            </div>
            <div class="post-image col-xs-12">
                <?php 
                $imgUrl = $model["badgeurl"];
                $contentImage = Html::img($imgUrl, [
                    'class' => 'img-responsive',
                    'alt' => $model["description"]
                ]);
                ?>
                <?=$contentImage ?>
            </div>
            <div class="post-text col-xs-12">
                <p>
                    <?= $model["description"] ?>
                   
                </p>
            </div>
          
        </div>
    </div>
</div>