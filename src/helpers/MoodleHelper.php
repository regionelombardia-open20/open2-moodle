<?php

/**
 * Aria S.p.A.
 * OPEN 2.0
 *
 *
 * @package    Open20Package
 * @category   CategoryName
 */

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MoodleHelper
 *
 * @author matteo
 */

namespace open20\amos\moodle\helpers;

use Yii;

class MoodleHelper {
    public static function getMoodleOAuthLink($url) {
        return Yii::$app->getModule('moodle')->moodleOAuthUrl . "?wantsurl=".rawurlencode($url);
    }
}
