<?php

namespace local_greetings\external;

defined('MOODLE_INTERNAL') || die();

require_once("$CFG->libdir/externallib.php");

use core_external\external_api;
use core_external\external_function_parameters;
use core_external\external_value;
use core_external\external_single_structure;

class local_greetings_external extends external_api {

    // Define parameters
    public static function save_message_parameters() {
        return new external_function_parameters([
            'message' => new external_value(PARAM_TEXT, 'Greeting message')
        ]);
    }

    // Main function to save the message
    public static function save_message($message) {
        global $DB, $USER;

        // Validate parameters
        $params = self::validate_parameters(self::save_message_parameters(), ['message' => $message]);

        // Validasi kapabilitas
        $context = context_system::instance();
        require_capability('local/greetings:postmessages', $context);

        // Simpan pesan ke database
        $record = new \stdClass();
        $record->messages = $params['message'];
        $record->timecreated = time();
        $record->userid = $USER->id;

        $DB->insert_record('local_greetings_messages', $record);

        return array('status' => 'success');
    }

    // Define the return structure
    public static function save_message_returns() {
        return new external_single_structure([
            'status' => new external_value(PARAM_TEXT, 'Status of the request')
        ]);
    }
}
