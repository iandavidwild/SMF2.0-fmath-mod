<?php
/**
 * @package SMF fMath Mod
 * @author Lumina Consultancy <https://luminaconsultancy.com>
 * @copyright 2018
 * @license GPLv3
 * @file Mod-fMath.php
 * @version 0.0.1
 */

if (!defined('SMF')) {
    die('Hacking attempt...');
}


/**
 * Load all needed hooks
 */
function loadfMathHooks()
{
    add_integration_function('integrate_load_theme', 'loadfMathJs', false);
    add_integration_function('integrate_bbc_buttons', 'addfMathBbcButton', false);
    add_integration_function('integrate_bbc_codes', 'addfMathBbcCode', false);
    add_integration_function('integrate_menu_buttons', 'addfMathCopyright', false);
}


/**
 * Load JS libraries
 */
function loadfMathJs()
{
    global $context;

    $context['insert_after_template'] .= '
      <script type="text/javascript" async src="https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.2/MathJax.js?config=default,Safe"></script>';
}


/**
 * Add editor buttons
 * @param $buttons
 */
function addfMathBbcButton(&$buttons)
{
    $buttons[1][] = array(
        'image' => 'fMath',
        'code' => 'fMath',
        'before' => '[latex]',
        'after' => '[/latex]',
        'description' => 'fMath',
    );
}


/**
 * Add latex bbc
 * @param $codes
 */
function addfMathBbcCode(&$codes)
{
    $codes[] = array(
        'tag' => 'fMath',
        'type' => 'unparsed_content',
        'content' => '\[ $1 \]',
    );

}


/**
 * Adds mod copyright to the forum credit's page
 */
function addfMathCopyright()
{
    global $context;

    if ($context['current_action'] == 'credits') {
        $context['copyrights']['mods'][] = '<a href="http://mysmf.net/mods/fmath" title="SMF fMath Mod" target="_blank">fMath Editor for SMF</a> &copy; 2018, Lumina Consultancy | <a href="http://www.fmath.info" title="Powered by fMath" target="_blank">Powered by fMath</a>';
    }
}
