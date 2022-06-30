<?php

namespace open20\amos\moodle\models;

use open20\amos\community\models\CommunityContextInterface;
use open20\amos\moodle\models\ServiceCall;
use open20\amos\moodle\AmosMoodle;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "moodle_category".
 */
class MoodleCategory extends \open20\amos\moodle\models\base\MoodleCategory implements CommunityContextInterface
{
    /**
     * @deprecated since version 1.4.1 and replaced by "generalCategoryMoodleId" module property.
     */
    const GENERAL_CATEGORY_MOODLE_ID = 1; //ID che ha in Moodle la categoria GENERALE

    /**
     * 
     * @var type
     */
    public $name;   // Moodle

    /**
     * 
     * @var type
     */
    public $visible;

    /**
     * 
     * @var type
     */
    public $description;

    /**
     * Inserire il campo o i campi rappresentativi del modulo
     * @return type
     */
    public function representingColumn()
    {
        return [];
    }

    /**
     * 
     * @return type
     */
    public function attributeHints()
    {
        return [];
    }

    /**
     * Returns the text hint for the specified attribute.
     * @param string $attribute the attribute name
     * @return string the attribute hint
     */
    public function getAttributeHint($attribute)
    {
        $hints = $this->attributeHints();

        return isset($hints[$attribute]) ? $hints[$attribute] : null;
    }

    /**
     * 
     * @return type
     */
    public function rules()
    {
        return ArrayHelper::merge(
            parent::rules(), [
                [['name'], 'string', 'max' => 255],
                [['visible'], 'boolean'],
                [['description'], 'string' /* , 'max' => 500 */],
            ]
        );
    }

    /**
     * 
     * @return type
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(
            parent::attributeLabels(), [
            'name' => AmosMoodle::_t('Nome'),
            'visible' => AmosMoodle::_t('Visibile'),
            'description' => AmosMoodle::_t('Descrizione'),
        ]);
    }

    /**
     * 
     * @return string
     */
    public function __toString()
    {
        return '';
    }

    /**
     * Aggiunge ai dati del db il nome preso da moodle
     * 
     * @param type $condition
     */
    public static function findOne($condition)
    {
        $ret = parent::findOne($condition);
        if (!is_null($ret) && $ret->moodle_categoryid) {
            $ret->getMoodleCategoryData();
        }
        
        return $ret;
    }

    /**
     * 
     * @param type $condition
     * @return type
     */
    public static function findOneOnlyDbData($condition)
    {
        $ret = parent::findOne($condition);

        return $ret;
    }

    /**
     * legge i dati della categoria presenti su Moodle
     */
    public function getMoodleCategoryData()
    {
        if ($this->moodle_categoryid) {
            $serviceCall = new ServiceCall();
            $categoryList = $serviceCall->getCategoryList(null, $this->moodle_categoryid);

            //pr($categoryList, '$categoryList');exit;
            if (!empty($categoryList) && !empty($categoryList[0])) {
                $this->name = $categoryList[0]['name'];
                $this->visible = $categoryList[0]['visible'];
                $this->description = $categoryList[0]['description'];
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function getContextRoles()
    {
        $context_roles = [
            AmosMoodle::MOODLE_MANAGER,
            AmosMoodle::MOODLE_STUDENT
        ];
        
        return $context_roles;
    }

    /**
     * @inheritdoc
     */
    public function getBaseRole()
    {
        return AmosMoodle::MOODLE_STUDENT;
    }

    /**
     * @inheritdoc
     */
    public function getManagerRole()
    {
        return AmosMoodle::MOODLE_MANAGER;
    }

    /**
     * @inheritdoc
     */
    public function getRolePermissions($role)
    {
        switch ($role) {
            case AmosMoodle::MOODLE_MANAGER:
                return ['CWH_PERMISSION_CREATE', 'CWH_PERMISSION_VALIDATE'];
                break;
            case AmosMoodle::MOODLE_STUDENT:
                return ['CWH_PERMISSION_CREATE'];
                break;
            default:
                return ['CWH_PERMISSION_CREATE'];
                break;
        }
    }

    /**
     * @inheritdoc
     */
    public function getCommunityModel()
    {
        return $this->community;
    }

    /**
     * @inheritdoc
     */
    public function getNextRole($role)
    {
        switch ($role) {
            case AmosMoodle::MOODLE_MANAGER:
                return AmosMoodle::MOODLE_STUDENT;
                break;
            case AmosMoodle::MOODLE_STUDENT:
                return AmosMoodle::MOODLE_MANAGER;
                break;
            default :
                return AmosMoodle::MOODLE_STUDENT;
                break;
        }
    }

    /**
     * @inheritdoc
     */
    public function getPluginModule()
    {
        return 'moodle';
    }

    /**
     * @inheritdoc
     */
    public function getPluginController()
    {
        return 'moodle';
    }

    /**
     * @inheritdoc
     */
    public function getRedirectAction()
    {
        return 'view';  // TODO: verificare
    }

    /**
     * @inheritdoc
     */
    public function getAdditionalAssociationTargetQuery($communityId)
    {
        /** @var ActiveQuery $communityUserMms */
        // TODO: da verificare
        $communityUserMms = CommunityUserMm::find()
            ->andWhere(['community_id' => $communityId]);
        
        return User::find()
            ->andFilterWhere(['not in', 'id', $communityUserMms->select('user_id')]);
    }

}
