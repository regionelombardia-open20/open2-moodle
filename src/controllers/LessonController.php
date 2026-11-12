<?php

/**
 * Aria S.p.A.
 * OPEN 2.0
 *
 * @package   open20\amos\moodle\controllers
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

namespace open20\amos\moodle\controllers;

use open20\amos\moodle\AmosMoodle;
use open20\amos\moodle\models\Lesson;
use open20\amos\moodle\models\ServiceCall;

use open20\amos\core\controllers\CrudController;
use open20\amos\core\icons\AmosIcons;
use open20\amos\core\helpers\Html;
use open20\amos\layout\Module;

use Yii;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use yii\data\ArrayDataProvider;

/**
 * This is the class for controller "LessonController".
 */
class LessonController extends CrudController
{

    /**
     * @inheritdoc
     */
    protected $serviceCall;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = ArrayHelper::merge(parent::behaviors(), [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => [
                            'index',
                            'lesson-detail',
                            'certificate-detail',
                            'quiz-detail',
                            'resource-detail',
                            'page-detail',
                            'questionnaire-detail',
                            'customcert-detail',
                        ],
                        'roles' => [AmosMoodle::MOODLE_STUDENT]
                    ],
                ]
            ],
        ]);

        return $behaviors;
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->serviceCall = new ServiceCall();
        $this->setModelObj(new Lesson());
        $this->setModelSearch(new Lesson());

        $this->setAvailableViews([
            'grid' => [
                'name' => 'grid',
                'label' => Yii::t('amoscore', '{iconaTabella}' . Html::tag('p', Yii::t('amoscore', 'Table')), [
                    'iconaTabella' => AmosIcons::show('view-list-alt')
                ]),
                'url' => '?currentView=grid'
            ],
        ]);

        parent::init();
    }


    public function beforeAction($action)
    {
        $titleSection = AmosMoodle::_t('Attività');
      
        $this->view->params = [
            'hideCreate'=>true,
            'isGuest' => \Yii::$app->user->isGuest,
            'modelLabel' => 'moodle',
            'titleSection' => $titleSection,
        ];

        if (!parent::beforeAction($action)) {
            return false;
        }

        // other custom code here

        return true;
    }

    /**
     * Lists all Topic models.
     * @return mixed
     */
    public function actionIndex($layout = null)
    {
        Url::remember();

        $topicId = Yii::$app->request->get('topicId');
        $courseId = Yii::$app->request->get('courseId');

        if (!empty($topicId) && !empty($courseId)) {
            $contentsList = $this->serviceCall->getCourseContents($courseId, $topicId);
            $lessonList = $this->getModelObj()->getLessonList($contentsList);
            $arrayDataProvider = new \yii\data\ArrayDataProvider(['allModels' => $lessonList]);

            $this->view->params['dataProvider'] = $arrayDataProvider;

            return parent::actionIndex();
        }
    }

    /**
     * 
     * @param type $lessonId
     * @return type
     */
    public function actionLessonDetail($lessonId)
    {
        return $this->renderPartial('lessonDetail', [
            'scormDetails' => $this->serviceCall->getScormDetails($lessonId),
            'close' => (Yii::$app->request->get('close') == 1),
        ]);
    }

    /**
     * 
     * @param type $certificateId
     * @return type
     */
    public function actionCertificateDetail($certificateId)
    {
        return $this->renderPartial('certificateDetail', [
            'certificateDetails' => $this->serviceCall->getCertificateDetails($certificateId),
        ]);
    }

    /**
     * 
     * @param type $quizId
     */
    public function actionQuizDetail($lessonId, $quizId)
    {
        return $this->renderPartial('quizDetail', [
            'quizDetails' => $this->serviceCall->getQuizDetails($quizId, $lessonId),
        ]);
    }

    /**
     * 
     * @param type $quizId
     */
    public function actionPageDetail($lessonId, $pageId)
    {
        return $this->renderPartial('pageDetail', [
            'pageDetails' => $this->serviceCall->getPageDetails($lessonId, $pageId),
        ]);
    }
    
    /**
     * 
     * @param type $quizId
     */
    public function actionQuestionnaireDetail($lessonId, $questionnaireId)
    {
        return $this->renderPartial('questionnaireDetail', [
            'questionnaireDetails' => $this->serviceCall->getQuestionnaireDetails($lessonId, $questionnaireId),
        ]);
    }

    /**
     * 
     * @param type $quizId
     */
    public function actionCustomcertDetail($lessonId, $customcertId = null)
    {
        return $this->renderPartial('customcertDetail', [
            'customcertDetails' => $this->serviceCall->getCustomCertDetails($lessonId, $customcertId),
        ]);
    }

    /**
     * 
     * @param type $quizId
     */
    public function actionResourceDetail($lessonId, $resourceId)
    {
        return $this->renderPartial('resourceDetail', [
            'resourceDetails' => $this->serviceCall->getResourceDetails($resourceId, $lessonId),
        ]);
    }

}
