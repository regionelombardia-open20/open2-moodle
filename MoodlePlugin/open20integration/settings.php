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

if ($hassiteconfig) {

    // Create the new settings page
    // - in a local plugin this is not defined as standard, so normal $settings->methods will throw an error as
    // $settings will be NULL
    $settings = new admin_settingpage('local_open20integration', 'Integrazione Open 2.0');

    // Create 
    $ADMIN->add('localplugins', $settings);

    // Add a setting field to the settings for this page
    $settings->add(new admin_setting_configtext(
            // This is the reference you will use to your configuration
            'local_open20integration/secretkey',
            // This is the friendly title for the config, which will be displayed
            'Callback Secret Key',
            // This is helper text for this config field
            'Chiave segreta utilizzata per generare il token di autenticazione per le callback verso Open 2.0',
            // This is the default value
            '',
            // This is the type of Parameter this config is
            PARAM_TEXT
    ));
    
    $settings->add(new admin_setting_configtext(
            // This is the reference you will use to your configuration
            'local_open20integration/callbacks_url',
            // This is the friendly title for the config, which will be displayed
            'Callback Endpoint URL',
            // This is helper text for this config field
            'URL per le callback verso Open 2.0',
            // This is the default value
            '',
            // This is the type of Parameter this config is
            PARAM_TEXT
    ));
    
    $settings->add(new admin_setting_configtext(
            // This is the reference you will use to your configuration
            'local_open20integration/oauth_issuerid',
            // This is the friendly title for the config, which will be displayed
            'ID Open 2.0 OAuth issuer',
            // This is helper text for this config field
            'ID issuer OAuth Open2.0 configurato su Moodle',
            // This is the default value
            '',
            // This is the type of Parameter this config is
            PARAM_INT
    ));
}

