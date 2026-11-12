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

defined('MOODLE_INTERNAL') || die();

class local_open20integration_observer {

    public static function observe_course($eventdata) {
        $config = get_config('local_open20integration');
        if (isset($config->callbacks_url) && $config->callbacks_url != '') {
            $ch = curl_init();
            
            $authtokenData = self::generateAuthToken();

            curl_setopt($ch, CURLOPT_URL, $config->callbacks_url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, array(
                'objectid' => $eventdata->objectid,
                'courseid' => $eventdata->courseid,
                'action' => $eventdata->action,
                'target' => $eventdata->target,
                'authtoken' => $authtokenData->token,
                'timestamp' => $authtokenData->timestamp,
            ));

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $curlResult = curl_exec($ch);
            if($curlResult === false){
                error_log("Callback verso ".$config->callbacks_url." fallita: ".curl_error($ch));
            }
            curl_close($ch);
        }
    }

    public static function observe_user_enrolment($eventdata) {
        $config = get_config('local_open20integration');
        if (isset($config->callbacks_url) && $config->callbacks_url != '') {
            $ch = curl_init();
            
            $authtokenData = self::generateAuthToken();

            curl_setopt($ch, CURLOPT_URL, $config->callbacks_url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, array(
                'objectid' => $eventdata->objectid,
                'action' => $eventdata->action,
                'target' => $eventdata->target,
                'relateduserid' => $eventdata->relateduserid,
                'courseid' => $eventdata->courseid,
                'authtoken' => $authtokenData->token,
                'timestamp' => $authtokenData->timestamp,
            ));

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $curlResult = curl_exec($ch);
            if($curlResult === false){
                error_log("Callback verso ".$config->callbacks_url." fallita: ".curl_error($ch));
            }
            curl_close($ch);
        }
    }
    
    public static function observe_course_category($eventdata) {
        $config = get_config('local_open20integration');
        if (isset($config->callbacks_url) && $config->callbacks_url != '') {
            $ch = curl_init();
            
            $authtokenData = self::generateAuthToken();

            curl_setopt($ch, CURLOPT_URL, $config->callbacks_url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, array(
                'objectid' => $eventdata->objectid,
                'action' => $eventdata->action,
                'target' => $eventdata->target,
                'authtoken' => $authtokenData->token,
                'timestamp' => $authtokenData->timestamp,
            ));

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $curlResult = curl_exec($ch);
            if($curlResult === false){
                error_log("Callback verso ".$config->callbacks_url." fallita: ".curl_error($ch));
            }
            curl_close($ch);
        }
    }
    
    private static function generateAuthToken(){
        $authtokenData = new stdClass();
        $authtokenData->timestamp = time();
        $authtokenData->token = hash('sha256',get_config('local_open20integration')->secretkey.$authtokenData->timestamp);
        return $authtokenData;
    }

}
