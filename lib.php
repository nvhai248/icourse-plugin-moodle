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
 * Library of interface functions and constants.
 *
 * @package     mod_icourse
 * @copyright   2024 Hai Nguyen Van <nvhai@gmail.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Return if the plugin supports $feature.
 *
 * @param string $feature Constant representing the feature.
 * @return true | null True if the feature is supported, null otherwise.
 */
function icourse_supports($feature)
{
    switch ($feature) {
        case FEATURE_MOD_INTRO:
            return true;
        default:
            return null;
    }
}

/**
 * Saves a new instance of the mod_icourse into the database.
 *
 * Given an object containing all the necessary data, (defined by the form
 * in mod_form.php) this function will create a new instance and return the id
 * number of the instance.
 *
 * @param object $moduleinstance An object from the form.
 * @param mod_icourse_mod_form $mform The form.
 * @return int The id of the newly inserted record.
 */
function icourse_add_instance($moduleinstance, $mform = null)
{
    global $DB;

    $moduleinstance->timecreated = time();

    $id = $DB->insert_record('icourse', $moduleinstance);

    return $id;
}

/**
 * Updates an instance of the mod_icourse in the database.
 *
 * Given an object containing all the necessary data (defined in mod_form.php),
 * this function will update an existing instance with new data.
 *
 * @param object $moduleinstance An object from the form in mod_form.php.
 * @param mod_icourse_mod_form $mform The form.
 * @return bool True if successful, false otherwise.
 */
function icourse_update_instance($moduleinstance, $mform = null)
{
    global $DB;

    $moduleinstance->timemodified = time();
    $moduleinstance->id = $moduleinstance->instance;

    return $DB->update_record('icourse', $moduleinstance);
}

/**
 * Removes an instance of the mod_icourse from the database.
 *
 * @param int $id Id of the module instance.
 * @return bool True if successful, false on failure.
 */
function icourse_delete_instance($id)
{
    global $DB;

    $exists = $DB->get_record('icourse', array('id' => $id));
    if (!$exists) {
        return false;
    }

    $DB->delete_records('icourse', array('id' => $id));

    return true;
}


/**
 * Clean up deleted courses.
 * This function will delete the courses that have been marked as deleted in the Moodle database.
 */
function icourse_cleanup_deleted_courses()
{
    global $DB;

    // Find courses that are deleted (visible = 0)
    $courses = $DB->get_records('course', array('visible' => 0));

    foreach ($courses as $course) {
        delete_course($course);
    }

    mtrace('Course cleanup completed.');
}