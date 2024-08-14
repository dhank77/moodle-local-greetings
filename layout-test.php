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
 * layout test page
 * @package local_greetings
 * @copyright   2024 Dhank77 <dhank77@example.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../config.php');

$context = context_system::instance();
$PAGE->set_context($context);
$PAGE->set_url(new moodle_url('/local/greetings/layout-test.php'));

$PAGE->set_title(get_string('pluginname', 'local_greetings'));
$PAGE->set_heading(get_string('pluginname', 'local_greetings'));

$output = $PAGE->get_renderer('local_greetings');

echo $output->header();
// Your content goes here. We will just echo some HTML for simplicity.
// echo '<div class="box border p-3">Here is some content but it can be anything else, too.</div>';

$sometext = 'Here is some content but it can be anything else, too alsi.';
$renderable = new \local_greetings\output\layout_test_page($sometext);
echo $output->render($renderable);

echo $output->footer();
