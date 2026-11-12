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

$observers = array(
    array(
        'eventname' => '\core\event\course_created',
        'callback' => 'local_open20integration_observer::observe_course',
    ),
    array(
        'eventname' => '\core\event\course_deleted',
        'callback' => 'local_open20integration_observer::observe_course',
    ),
    array(
        'eventname' => '\core\event\course_updated',
        'callback' => 'local_open20integration_observer::observe_course',
    ),
    array(
        'eventname' => '\core\event\user_enrolment_created',
        'callback' => 'local_open20integration_observer::observe_user_enrolment',
    ),
    array(
        'eventname' => '\core\event\user_enrolment_deleted',
        'callback' => 'local_open20integration_observer::observe_user_enrolment',
    ),
    array(
        'eventname' => '\core\event\user_enrolment_updated',
        'callback' => 'local_open20integration_observer::observe_user_enrolment',
    ),
    array(
        'eventname' => '\core\event\course_category_created',
        'callback' => 'local_open20integration_observer::observe_course_category',
    ),
    array(
        'eventname' => '\core\event\course_category_deleted',
        'callback' => 'local_open20integration_observer::observe_course_category',
    ),
    array(
        'eventname' => '\core\event\course_category_updated',
        'callback' => 'local_open20integration_observer::observe_course_category',
    ),
);
