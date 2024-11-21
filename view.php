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
 * Prints an instance of mod_icourse.
 *
 * @package     mod_icourse
 * @copyright   2024 Hai Nguyen Van <nvhai@gmail.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../config.php');
require_login();
global $DB, $OUTPUT, $PAGE, $USER;

$context = context_system::instance();
$PAGE->set_context($context);
$PAGE->set_url('/mod/icourse/view.php');
$PAGE->set_title(get_string('modulename', 'mod_icourse'));
$PAGE->set_heading('ICourse');

$PAGE->requires->css('/mod/icourse/style/style.css');

echo $OUTPUT->header();

// Check user permissions
if (has_capability('local/icourse:viewcourses', $context)) {
    // Fetch courses with additional fields like timecreated
    $sql = "SELECT c.id, c.fullname, c.visible, c.timecreated
            FROM mdl_course c
            JOIN mdl_enrol e ON e.courseid = c.id
            JOIN mdl_user_enrolments ue ON ue.enrolid = e.id
            WHERE ue.userid = :userid";
    $courses = $DB->get_records_sql($sql, ['userid' => $USER->id]);
    $sesskey = sesskey();

    if (has_capability('local/icourse:managecourses', $context)) {
        $url = new moodle_url('/course/edit.php', array('returnto' => 'url', 'returnurl' => '/mod/icourse/view.php', 'sesskey' => $sesskey));

        echo '<a href="' . $url . '" class="icourse-button" role="button" aria-label="Create a new course">Create New Course</a>';
    }

    echo '<table class="icourse-table" role="table">';
    echo '<thead>';
    echo '<tr>';
    echo '<th scope="col">ID</th>';
    echo '<th scope="col">Image</th>';
    echo '<th scope="col">Name</th>';
    echo '<th scope="col">Date Created</th>';
    echo '<th scope="col">Action</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';

    foreach ($courses as $course) {
        echo '<tr>';
        echo '<td>' . $course->id . '</td>';
        echo '<td>';
        if (!empty($course->summaryfiles)) {
            $imageurl = reset($course->summaryfiles)->fileurl;
            echo '<img src="' . $imageurl . '" alt="Image for ' . htmlspecialchars($course->fullname) . '" width="50" height="50">';
        } else {
            echo '<img src="/mod/icourse/assets/default.jpg" alt="Default course image" width="50" height="50">';
        }
        echo '</td>';
        echo '<td><a href="' . $CFG->wwwroot . '/course/view.php?id=' . $course->id . '">' . htmlspecialchars($course->fullname) . '</a></td>';
        echo '<td>' . userdate($course->timecreated) . '</td>';
        echo '<td>';
        if ($course->visible) {
            if (has_capability('local/icourse:managecourses', $context)) {
                $updateUrl = new moodle_url('/course/edit.php', array('id' => $course->id, 'returnurl' => '/mod/icourse/view.php', 'sesskey' => $sesskey));

                echo '<a href="' . $updateUrl . '"  class="action-link" role="button">Update</a>';
                echo ' | ';
                echo '<a href="delete.php?id=' . $course->id . '" class="action-link" role="button" onclick="return confirm(\'Are you sure you want to delete this course?\');">Delete</a>';
            } else {
                echo 'Visible';
            }
        } else {
            echo 'Hidden';
        }

        echo '</td>';
        echo '</tr>';
    }

    echo '</tbody>';
    echo '</table>';
} else {
    echo '<p role="alert" class="accessibility-message">You cannot access this page.</p>';
}

echo $OUTPUT->footer();

