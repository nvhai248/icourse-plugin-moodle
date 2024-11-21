<?php
require_once('../../config.php');
require_login();
$courseid = required_param('id', PARAM_INT);

$course = $DB->get_record('course', array('id' => $courseid));
if ($course) {
    $course->visible = 0;  // Set course to hidden
    $DB->update_record('course', $course);
    redirect(new moodle_url('/mod/icourse/view.php'), 'Course has been deleted.');
} else {
    redirect(new moodle_url('/mod/icourse/view.php'), 'Course not found.');
}
