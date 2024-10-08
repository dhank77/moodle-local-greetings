<?php
// This file is part of Moodle - https://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * Plugin version and other meta-data are defined here.
 *
 * @package     local_greetings
 * @copyright   2024 Dhank77 <dhank77@example.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../config.php');
require_once($CFG->dirroot . "/local/greetings/lib.php");

require_login();
if (isguestuser()) {
    throw new moodle_exception('noguest');
}

$context = context_system::instance();
$PAGE->set_context($context);

$PAGE->set_title(get_string('pluginname', 'local_greetings'));
$PAGE->set_heading(get_string('pluginname', 'local_greetings'));
$PAGE->set_url(new moodle_url('/local/greetings/index.php'));
$PAGE->set_pagelayout('standard');

$output = $PAGE->get_renderer('local_greetings');

echo $output->header();
echo $output->render_from_template('local_greetings/navmenu', []);


echo local_greetings_get_greeting($USER);

// Capabbilities!
$allowpost = has_capability('local/greetings:postmessages', $context);
$viewmessages = has_capability('local/greetings:viewmessages', $context);
$deleteanypost = has_capability('local/greetings:deleteanymessage', $context);

$messageform = new \local_greetings\form\message_form();
if ($allowpost) {
    $messageform->display();
}

$PAGE->requires->js_call_amd('local_greetings/form-handler', 'init');

if ($viewmessages) {
    require_capability('local/greetings:viewmessages', $context);
    $cardbackgroundcolor = get_config('local_greetings', 'messagecardbgcolor');
    $userfield = \core_user\fields::for_name()->with_identity($context);
    $userfieldssql = $userfield->get_sql('u');
    $sql = "SELECT m.id, m.messages, m.timecreated, m.userid {$userfieldssql->selects} FROM {local_greetings_messages} m LEFT JOIN {user} u ON m.userid = u.id ORDER BY m.timecreated DESC";
    $allmessage = $DB->get_records_sql($sql);
    $renderable = new \local_greetings\output\index_page($allmessage);
    echo $output->render($renderable);
}

$action = optional_param('action', '', PARAM_TEXT);
if ($action == 'del') {
    require_capability('local/greetings:deleteanymessage', $context);
    if ($deleteanypost) {
        require_sesskey();
        $id = required_param('id', PARAM_TEXT);
        $DB->delete_records('local_greetings_messages', ['id' => $id]);
        redirect($PAGE->url);
    }
}

// if ($data = $messageform->get_data()) {
//     require_capability('local/greetings:postmessages', $context);
//     $message = required_param('messages', PARAM_TEXT);

//     if (!empty($message)) {
//         $record = new stdClass;
//         $record->messages = $message;
//         $record->timecreated = time();
//         $record->userid = $USER->id;

//         $DB->insert_record('local_greetings_messages', $record);
//         redirect($PAGE->url);
//     }
// }

echo $output->footer();
