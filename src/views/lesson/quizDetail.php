<?php

/**
 * Aria S.p.A.
 * OPEN 2.0
 *
 *
 * @package    open20\amos\moodle
 * @category   CategoryName
 */

use open20\amos\moodle\AmosMoodle;
use open20\amos\moodle\helpers\MoodleHelper;

use open20\amos\core\helpers\Html;

?>
<p><?= AmosMoodle::t('amosmoodle', '#attemps_number', ['attemps' => count($quizDetails['attemps'])]) ?></p>

<?= Html::a(AmosMoodle::t('amosmoodle', '#get_your_quiz', 
    [
        'modelClass' => 'Moodle Quiz',
    ]),
    MoodleHelper::getMoodleOAuthLink(AmosMoodle::instance()->moodleUrl . $quizDetails['fileUrl']),
    [
        'id' => 'btn-get-resource',
        'class' => 'btn btn-amministration-primary',
        'target' => '_blank'
    ]
);
