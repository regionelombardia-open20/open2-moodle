<?php

/**
 * Aria S.p.A.
 * OPEN 2.0
 *
 *
 * @package    open20\amos\moodle
 * @category   CategoryName
 */
/** @var \open20\amos\dashboard\models\AmosUserDashboards $currentDashboard * */
/** @var \yii\web\View $this * */
use open20\amos\moodle\AmosMoodle;
use open20\amos\moodle\helpers\MoodleHelper;
use open20\amos\core\helpers\Html;

/**
 * @var yii\web\View $this
 * @var  $certificateDetails
 */
?>
<p>
    <strong><?= AmosMoodle::t('amosmoodle', '#issued_on') ?> </strong>
    <?= date('d/m/Y H:i', $certificateDetails["timecreated"]) ?>
</p>

<p><?= AmosMoodle::t('amosmoodle', '#click_to_download_certificate') ?></p>

<?php 
if (!empty($certificateDetails["fileurl"])) {
    echo Html::a(
        AmosMoodle::t('amosmoodle', '#get_your_certificate', [
            'modelClass' => 'Moodle Topic',
        ]),
        MoodleHelper::getMoodleOAuthLink($certificateDetails["fileurl"]),
        [
            'id' => 'btn-get-resource',
            'class' => 'btn btn-amministration-primary',
            'target' => '_blank'
        ]
    );
}

