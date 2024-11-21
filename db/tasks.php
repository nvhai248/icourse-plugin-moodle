<?php
defined('MOODLE_INTERNAL') || die();

$tasks = [
    [
        'classname' => 'mod_icourse\task\cleanup_deleted_courses',
        'blocking' => 0,
        'minute' => '0',
        'hour' => '22',
        'day' => '*',
        'month' => '*',
        'dayofweek' => '*',
        'disabled' => 0,
    ],
];
