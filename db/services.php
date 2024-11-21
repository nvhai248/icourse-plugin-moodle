<?php
defined('MOODLE_INTERNAL') || die();

$services = [
    'mod_icourse_generator' => [
        'classname' => 'mod_icourse_generator',
        'filename' => 'tests/generator/lib.php',
        'classpath' => 'mod/icourse/tests/generator/lib.php',
        'methodname' => 'create_instance',
    ],
];
