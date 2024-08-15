<?php
$functions = [
    'local_greetings_save_message' => [
        'classname'   => 'local_greetings_external',
        'methodname'  => 'save_message',
        'description' => 'Save a new greeting message',
        'type'        => 'write',
        'capabilities' => 'local/greetings:postmessages',
        'ajax'        => true,
    ],
    'mod_certificate_get_certificates_by_courses' => [
        'classname'     => 'mod_certificate_external',
        'methodname'    => 'get_certificates_by_courses',
        'description'   => 'Returns a list of certificate instances...',
        'type'          => 'read',
        'capabilities'  => 'mod/certificate:view',
        'services'      => [MOODLE_OFFICIAL_MOBILE_SERVICE, 'local_mobile'],
    ],
];
