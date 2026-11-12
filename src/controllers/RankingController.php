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
use open20\amos\moodle\models\Ranking;
use open20\amos\core\controllers\CrudController;
use open20\amos\core\icons\AmosIcons;
use open20\amos\core\helpers\Html;
use open20\amos\moodle\models\ServiceCall;
use open20\amos\moodle\utility\MoodleUtility;
use Yii;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;

/**
 * This is the class for controller "RankingController".
 */
class RankingController extends CrudController
{
    /**
     *
     * @var type 
     */
    protected $serviceCall;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = ArrayHelper::merge(parent::behaviors(), [
                'access' => [
                    'class' => AccessControl::className(),
                    'rules' => [
                        [
                            'allow' => true,
                            'actions' => [
                                'index'
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
        $this->setModelObj(new Ranking());
        $this->setModelSearch(new Ranking());
        $this->serviceCall = new ServiceCall();

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
     * Lists all Topic models.
     * @return mixed
     */
    public function actionIndex($layout = null)
    {
        Url::remember();

        //$courseId = Yii::$app->request->get('courseId');

        $course = MoodleUtility::getCommunityCourse();

        if (!empty($course)) {
            $courseId = $course->moodle_courseid;

            $rankingArray = $this->serviceCall->getRanking($courseId);
            $rankingObjectList = $this->getModelObj()->getRankingObjectList($rankingArray);

            $arrayDataProvider = new \yii\data\ArrayDataProvider(['allModels' => $rankingObjectList]);
            $this->view->params['dataProvider'] = $arrayDataProvider;

//            $this->setParametro($arrayDataProvider);

            return parent::actionIndex();
        }
    }

}
