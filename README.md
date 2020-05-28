# Amos Moodle #

Plugin description

### Moodle integration ###
Copy the directory `MoodlePlugin/open20integration` into `${MOODLE_INSTALLATION_PATH}/local/.`
and access the moodle administration area to run the configuration wizard.

### Installation ###
Add Moodle requirement in your composer.json

    "open20/amos-moodle": "dev-master",

Enable the Moodle module in `backend/config/modules-amos.php`

    'moodle' => [
    	'class' => 'open20\amos\moodle\AmosMoodle',
    ],

Add Moodle migrations to console modules `console/config/migrations-amos.php`

	'@vendor/open20/amos-moodle/src/migrations'

Add Moodle bootstrap definition to `backend/config/bootstrap.php`

    if (isset($modules['moodle'])) {
    	$bootstrap[] = 'open20\amos\moodle\bootstrap\EventRoleUser';
	}

### Required fields ###

	'moodle' => [
    	'class' => 'open20\amos\moodle\AmosMoodle',	
		'moodleUrl' => 'https://my-moodle-platform.example.com',
		'moodleAdministratorToken' => '1234567890987654321',
        'moodleOpen20baseRoleId' => 123,
    	'secretKey' => 'secret-key',
    	'adminUsername' => 'admin-username',
    ],

* **moodleUrl** - string, required
The main URL of the Moodle platform you want to connect with.

* **moodleAdministratorToken** - string, required
The administrative token for Moodle WebServices authentication. Must be generated manually from the Moodle platform by an administrative user.

* **moodleOpen20baseRoleId** - int, required
The ID of a new "open20base" role to be created on the Moodle platform. This role must have the `moodle/webservice:createtoken` permission and must be associated to the "System" context.

* **secretKey** - string, required
The secret key used to authenticate Moodle callbacks against the Open 2.0 platform. Must be identical to the secret key configured within the Open 2.0 Integration plugin installed on the Moodle platform.

* **adminUsername** - string, required
The username of an active Open 2.0 user with Moodle Administrator role. The new communities created for each Moodle Course will be owned by this user.


Add themes to view in `backend/config/components-amos.php` view entry should be:

    'view' => [
        'class' => 'open20\amos\core\components\AmosView',
    	'theme' => [
        	'pathMap' => [
                '@vendor/open20/amos-community/src/views' => '@vendor/open20/amos-moodle/src/views/community',
        	],
        ],
    ],


