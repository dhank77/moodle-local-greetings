<?php
 defined('MOODLE_INTERNAL') || die();

$addons = [
    'local_greetings' => [ // Plugin identifier.
        'handlers' => [ // Different places where the plugin will display content.
            'hello' => [ // Handler unique name (alphanumeric).    
                'delegate' => 'CoreMainMenuDelegate', // Delegate (Add new items to the main menu).
                'method' => 'view_hello', // Main function in \local_greetings\output\mobile for this delegate.
                'displaydata' => [
                    'title' => 'hello', // Lang string identifier.
                    'icon' => 'earth',
                ],
            ],
            'greetingslist' => [ // Handler unique name (alphanumeric).
                'delegate' => 'CoreMainMenuHomeDelegate', // Delegate (Add new tabs in the home page).
                'method' => 'mobile_view_greetings_list', // Main function in \local_greetings\output\mobile for this delegate.
                'displaydata' => [
                    'title' => 'greetings', // Lang string identifier.
                ],
            ],
        ],
        'lang' => [ // Language strings that are used in all the handlers.
            ['greetings', 'local_greetings'],
            ['hello', 'local_greetings'],
            ['yourmessage', 'local_greetings'],
            ['messages', 'message'],
            ['submit', 'moodle'],
        ],
    ],
];