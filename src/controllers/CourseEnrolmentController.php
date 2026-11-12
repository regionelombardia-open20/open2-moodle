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

namespace open20\amos\moodle\controllers;

use open20\amos\moodle\AmosMoodle;
use open20\amos\moodle\models\MoodleCourse;
use open20\amos\moodle\models\search\MoodleCourseSearch;
use open20\amos\core\controllers\CrudController;
use open20\amos\core\icons\AmosIcons;
use open20\amos\core\helpers\Html;
use open20\amos\moodle\assets\MoodleAsset;
use open20\amos\core\user\User;
use open20\amos\core\user\AmosUser;

use Yii;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;

/**
 * This is the class for controller "CourseEnrolmentController".
 */
class CourseEnrolmentController extends CrudController {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        $behaviors = ArrayHelper::merge(parent::behaviors(), [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => [
                            'search-courses',
                        ],
                        'roles' => [
                            AmosMoodle::MOODLE_RESPONSABILE,
                            AmosMoodle::MOODLE_ADMIN,
                        ]
                    ],
                ]
            ],
        ]);
        
        return $behaviors;
    }

    /**
     * @inheritdoc
     */
    public function init() {
        MoodleAsset::register(Yii::$app->view);

        $this->setModelObj(new MoodleCourse());
        $this->setModelSearch(new MoodleCourseSearch());

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

    /**
     * @param int $userId : l'utente da iscivere 
     * Mostra tutti i corsi ad iscrizione autonoma (aperti) con il bottone per iscrivere un certo utente passato come parametro
     * @return mixed
     */
    public function actionSearchCourses($layout = null, $userId = null) {
        Url::remember();

        //$provider = Yii::$app->session->get('social-match');
        // Yii::$app->session->set('match', 'en-US');
        $userNotValid = true;
        $userToEnrol = null;
        if (!empty($userId)) {
            $userToEnrol = User::findOne([
                        'id' => $userId,
            ]);

            if ($userToEnrol) {
                $amosUser = new AmosUser(['identityClass' => User::className()]);
                $amosUser->setIdentity($userToEnrol);

                if ($amosUser->can(AmosMoodle::MOODLE_STUDENT)) {
                    $userNotValid = false;
                }
            }

            if (!$userNotValid) {
                $arrayDataProvider = $this->getModelSearch()->searchOpenCoursesForUser(Yii::$app->request->getQueryParams(), $userId);

//           $this->setParametro($arrayDataProvider);
                $this->view->params['dataProvider'] = $arrayDataProvider;
            }
        }

        $this->setUpLayout('list');

        if ($layout) {
            $this->setUpLayout($layout);
        }


        return $this->render('index', [
                    'dataProvider' => $this->getDataProvider(),
                    'model' => $this->getModelSearch(),
                    'currentView' => $this->getAvailableView('grid'),
                    'availableViews' => $this->getAvailableViews(),
                    'url' => ($this->url) ? $this->url : null,
                    'parametro' => ($this->parametro) ? $this->parametro : null,
                    'userToEnrol' => $userToEnrol,
                    'userNotValid' => $userNotValid,
        ]);
    }

}
