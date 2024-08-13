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
 *
 * @package local_greetings
 * @copyright   2024 Dhank77 <dhank77@example.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_greetings\form;

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir . "/formslib.php");

/**
 * Class message_form
 */
class message_form extends \moodleform {
    /**
     * Define the form
     */
    public function definition(): void {
        $mform = $this->_form;

        $mform->addElement("textarea", "messages", get_string("your_messages", "local_greetings"));
        $mform->setType("messages", PARAM_TEXT);

        // If editing the form, load data from db.
        if (isset($this->_customdata['message'])) {
            $message = $this->_customdata['message'];

            $mform->addElement('hidden', 'id', $message->id);
            $mform->setType('id', PARAM_INT); // Set type of element.

            $mform->setDefault('messages', $message->messages);
        }

        $submitlabel = get_string("submit");
        $mform->addElement("submit", 'submitmessage', $submitlabel);
    }
}
