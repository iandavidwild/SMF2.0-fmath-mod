<?php
/**
 * @package SMF fMath Mod
 * @author Lumina Consultancy
 * @copyright 2018
 * @license GPLv3
 * @file hooks.php
 * @version 0.1
 *
 * To run this install manually please make sure you place this
 * in the same place and SSI.php and index.php
 */

global $context, $user_info;

if (file_exists(dirname(__FILE__) . '/SSI.php') && !defined('SMF')) {
    require_once(dirname(__FILE__) . '/SSI.php');
} elseif (!defined('SMF')) {
    die('<b>Error:</b> Cannot install - please verify that you put this file in the same place as SMF\'s index.php and SSI.php files.');
}

if ((SMF == 'SSI') && !$user_info['is_admin']) {
    die('Admin privileges required.');
}

if (!empty($context['uninstalling'])) {
    $call = 'remove_integration_function';
} else {
    $call = 'add_integration_function';
}

$hooks = array(
    'integrate_pre_include' => '$sourcedir/Mod-fMath.php',
    'integrate_pre_load' => 'loadfMathHooks'
);

foreach ($hooks as $hook => $function) {
    $call($hook, $function);
}

if (SMF == 'SSI') {
    echo 'Database changes are complete! <a href="/">Return to the main page</a>.';
}
