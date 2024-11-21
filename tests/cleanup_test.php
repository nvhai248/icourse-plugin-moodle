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

namespace mod_icourse\tests;

use advanced_testcase;

defined('MOODLE_INTERNAL') || die();

/**
 * Unit test for icourse_cleanup_deleted_courses.
 *
 * @group mod_icourse
 */
class cleanup_test extends advanced_testcase
{
    public function test_icourse_cleanup_deleted_courses()
    {
        global $DB;

        // Reset the test environment.
        $this->resetAfterTest();

        $initial_course_count = $DB->count_records('course');
        echo "\nInitial course count: $initial_course_count\n";

        $this->getDataGenerator()->create_course(['visible' => 0]);
        $this->getDataGenerator()->create_course(['visible' => 1]); 
        $this->getDataGenerator()->create_course(['visible' => 0]); 

        $this->assertEquals(4, $DB->count_records('course'), 'Three courses should exist before cleanup.');

        ob_start();
        icourse_cleanup_deleted_courses();
        $output = ob_get_clean();

        $this->assertStringContainsString('Course cleanup completed.', $output, 'Expected mtrace message not found.');

        $remaining_courses = $DB->get_records('course');
        $this->assertCount(2, $remaining_courses, 'Only two course should remain after cleanup.');
    }
}

