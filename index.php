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

$context = context_system::instance();
$PAGE->set_context($context);

$PAGE->set_title(get_string('pluginname', 'local_greetings'));
$PAGE->set_heading(get_string('pluginname', 'local_greetings'));
$PAGE->set_url(new moodle_url('/local/greetings/index.php'));
$PAGE->set_pagelayout('standard');

echo $OUTPUT->header();

echo local_greetings_get_greeting($USER);

$messageform = new \local_greetings\form\message_form();
$messageform->display();

echo $OUTPUT->box_start('card-columns');
// OLD
// $allmessage = $DB->get_records('local_greetings_messages');

// TO-TRY
// $allmessage = $DB->get_records('local_greetings_messages', ['userid' => $USER->id]);

$userfield = \core_user\fields::for_name()->with_identity($context);
$userfieldssql = $userfield->get_sql('u');

$sql = "SELECT m.id, m.messages, m.timecreated, m.userid {$userfieldssql->selects} FROM {local_greetings_messages} m LEFT JOIN {user} u ON m.userid = u.id ORDER BY m.timecreated DESC";

$allmessage = $DB->get_records_sql($sql);
foreach ($allmessage as $m) {
    echo html_writer::start_tag('div', ['class' => 'card']);
    echo html_writer::start_tag('div', ['class' => 'card-body']);
    echo html_writer::tag('p', $m->messages, ['class' => 'card-text']);
    echo html_writer::tag('p', get_string('postedby', 'local_greetings', $m->firstname), ['class' => 'card-text']);
    echo html_writer::start_tag('p', ['class' => 'card-text']);
    echo html_writer::tag('small', $m->timecreated, ['class' => 'text-muted']);
    echo html_writer::end_tag('p');
    echo html_writer::end_tag('div');
    echo html_writer::end_tag('div');
}
echo $OUTPUT->box_end();

if ($data = $messageform->get_data()) {
    $message = $data->messages;
    if (!empty($message)) {
        $record = new stdClass;
        $record->messages = $message;
        $record->timecreated = time();
        $record->userid = $USER->id;

        $DB->insert_record('local_greetings_messages', $record);
    }
}

echo $OUTPUT->footer();
