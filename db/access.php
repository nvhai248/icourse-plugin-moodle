<?php

defined('MOODLE_INTERNAL') || die();

$capabilities = array(
    'local/icourse:viewcourses' => array(
        'captype' => 'read',
        'contextlevel' => CONTEXT_SYSTEM,
        'archetypes' => array(
            'user' => CAP_ALLOW,
            'guest' => CAP_PREVENT,
            'manager' => CAP_ALLOW,
        ),
    ),
    'local/icourse:managecourses' => array(
        'captype' => 'write',
        'contextlevel' => CONTEXT_SYSTEM,
        'archetypes' => array(
            'manager' => CAP_ALLOW,
            'coursecreator' => CAP_ALLOW,
        ),
    ),
);
