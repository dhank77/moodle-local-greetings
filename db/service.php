<?php
$functions = array(
    'local_greetings_save_message' => array(
        'classname'   => 'local_greetings_external',
        'methodname'  => 'save_message',
        'description' => 'Save a new greeting message',
        'type'        => 'write',
        'capabilities' => 'local/greetings:postmessages',
        'ajax'        => true,
    ),
);
