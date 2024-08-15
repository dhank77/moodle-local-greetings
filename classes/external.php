<?php
namespace local_greetings;

use core_external\external_api;
use core_external\external_function_parameters;
use core_external\external_value;

class external extends external_api {
    public static function save_message_parameters() {
        return new external_function_parameters(
            array(
                'message' => new external_value(PARAM_TEXT, 'Message to save'),
            )
        );
    }

    public static function save_message($message) {
        global $DB, $USER;

        // Validation and capability check
        require_login();
        require_capability('local/greetings:postmessages', context_system::instance());

        $record = new \stdClass();
        $record->messages = $message;
        $record->timecreated = time();
        $record->userid = $USER->id;

        $DB->insert_record('local_greetings_messages', $record);

        return array('status' => 'success');
    }

    public static function save_message_returns() {
        return new \external_single_structure(
            array(
                'status' => new \external_value(PARAM_TEXT, 'Status of the operation'),
            )
        );
    }
}
