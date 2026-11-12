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

namespace open20\amos\moodle\utility;

use open20\amos\moodle\models\MoodleUser;
use open20\amos\moodle\AmosMoodle;
use open20\amos\core\user\User;
use open20\amos\core\utilities\Email;

use Yii;

class EmailUtil extends Email {

    /**
     * Manda la mail di richiesta iscrizione ad un corso chiuso di Moodle. 
     * La manda a tutti i MOODLE_ADMIN
     *
     * @param type $course Moodle Course
     * @param type $userId
     * @return bool
     */
    public static function sendEmailEnrolInClosedCourse($course, $userId = null) {
        $from = \Yii::$app->params['supportEmail'];
        $emailMoodleAdmin = MoodleUtility::getAllMoodleAdminUsersEmail();

        $to = $emailMoodleAdmin;

        if ($userId == null) {
            $loggedUser = \Yii::$app->getUser()->identity;
            $loggedUserId = $loggedUser->id;
        } else {
            $loggedUserId = $userId;
        }

        $moodleUser = MoodleUser::findOne([
            'user_id' => $loggedUserId,
        ]);
        
        $infoMoodleUser = $moodleUser->moodle_name 
            . ' '
            . $moodleUser->moodle_surname
            . ' '
            . $moodleUser->moodle_email
            . ' (ID Moodle.'
            . $moodleUser->moodle_userid
            . ')';

        $subject = AmosMoodle::_t('#subscription_request_to_closed_course');

        $body [] = AmosMoodle::_t('#enrollment_request_sent');
        $body [] = AmosMoodle::_t('#moodle_course_details', [
            'name' => $course->name,
            'moodle_courseid' => $course->moodle_courseid
        ]);

        $body [] = AmosMoodle::_t('#moodle_requested_by', [
            'infoMoodleUser' => $infoMoodleUser
        ]);

        $params = [
            'body' => $body,
        ];

        $layout = '@vendor/open20/amos-moodle/src/mail/generic/generic-html';

        return self::sendEmail($from, $to, $subject, $params, $layout, null, $userId);
    }

    /**
     * Manda allo studente la mail di avvenuta iscrizione ad un corso di Moodle, 
     * con il link per accedere al corso.
     *
     * @param type $course
     * @param type $userId
     * @param type $paypal
     * @param type $courseCost
     * @param type $enrollerId Chi iscrive chi
     * @return type
     */
    public static function sendEmailEnrolledInCourse($course, $userId, $paypal = false, $courseCost = null, $enrollerId = null) {
        $from = \Yii::$app->params['supportEmail'];

        $userStudent = User::findOne([
            'id' => $userId,
        ]);

        $to = $userStudent->email;
        
        $amosMoodle = \Yii::$app->getModule(AmosMoodle::getModuleName());
        
        $courseUrl = '';
        if ($amosMoodle->disableEnrolmentOption == false) {
            if (!empty($course->community_id)) {
                $urlParams = [
                    '/community/join',
                    'id' => $course->community_id,
                ];
            }
        } else {
            $urlParams = [
                'moodle/course/own-courses',
            ];
        }        
        
        if (!empty($urlParams)) {
            $courseUrl = Yii::$app->urlManager->createAbsoluteUrl($urlParams);
        }

        $subject = AmosMoodle::_t('#welcome_to_the_course_email_subject', [
            'name' => $course->name
        ]);

        if ($paypal == true) {
            $body [] = AmosMoodle::_t('#confirm_paypal_payment', [
                'cost' => $courseCost,
                'name' => $course->name
            ]);
        }

        $body [] = AmosMoodle::_t('#subscribed', ['name' => $course->name]);
        $body [] = AmosMoodle::_t('#course_info_link', [
            'courseUrl' => $courseUrl
        ]);

        $params = [
            'userProfile' => $userStudent->userProfile->toArray(),
            'body' => $body,
        ];

        $layout = '@vendor/open20/amos-moodle/src/mail/generic/generic-user-html';

        // Send an email to enroller user
        if ($enrollerId != null) {
            $userEnroller = User::findOne(['id' => $enrollerId]);
            $to = $userEnroller->email;
            
            return self::sendEmail($from, $to, $subject, $params, $layout, null, $userId);
        }

        return self::sendEmail($from, $to, $subject, $params, $layout, null, $userId);
    }

    /**
     * 
     * @param type $from
     * @param type $to
     * @param type $subject
     * @param type $params
     * @param type $layout
     * @param type $layoutHtml
     * @param type $userId
     * @return type
     */
    public static function sendEmail($from, $to, $subject, $params, $layout, $layoutHtml = null, $userId = null) {
        $email = new Email();
        $text = $email->renderMailPartial($layout, $params, $userId);
      
        return $email->sendMail($from, $to, $subject, $text);
    }

}
