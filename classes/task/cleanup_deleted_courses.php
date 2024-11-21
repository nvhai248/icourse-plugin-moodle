<?php
namespace mod_icourse\task;

defined('MOODLE_INTERNAL') || die();

class cleanup_deleted_courses extends \core\task\scheduled_task
{
    /**
     * Get the task's name.
     * @return string
     */
    public function get_name()
    {
        return get_string('cleanup_deleted_courses_task', 'mod_icourse');
    }

    /**
     * Execute the task.
     */
    public function execute()
    {
        icourse_cleanup_deleted_courses();
    }
}
