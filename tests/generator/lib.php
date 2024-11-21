<?php
defined('MOODLE_INTERNAL') || die();

/**
 * Data generator for mod_icourse.
 */
class mod_icourse_generator extends testing_module_generator
{
    /**
     * Create an instance of the icourse activity.
     *
     * @param array $record The record data for the activity.
     * @param array|null $options Additional options for the activity.
     * @return stdClass The created activity record.
     * @throws coding_exception If required parameters are missing.
     */
    public function create_instance($record = null, array $options = null)
    {
        global $DB;

        // Set default values for missing parameters.
        $record = (array) $record;
        $record['name'] = $record['name'] ?? 'I Course';
        $record['intro'] = $record['intro'] ?? 'Default introduction';
        $record['introformat'] = $record['introformat'] ?? FORMAT_HTML;

        // Call the parent generator to create the activity.
        return parent::create_instance($record, $options);
    }
}
