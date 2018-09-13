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
    add_integration_function('integrate_admin_areas', 'iaa_fMath', false);
    add_integration_function('integrate_modify_modifications', 'imm_fMath', false);
}


/**
 * Load JS libraries
 */
function loadfMathJs()
{
    global $context, $modSettings, $settings;

    $context['html_headers'] .= '
      <script type="text/javascript">var fmath_opentag="'.$modSettings['fmath_opentag'].'";
                                     var fmath_inlineopentag="'.$modSettings['fmath_inlineopentag'].'";
                                     var fmath_closetag="'.$modSettings['fmath_closetag'].'";</script>';
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


/**
 * Adds mod copyright to the forum credit's page
 */
function fMathSettings(&$config_vars)
{
    // Load the language(s)
    loadLanguage('fmath');
    // Add the setting(s)
    $fmath = array(
        array('text', 'fmath_opentag'),
        array('text', 'fmath_inlineopentag'),
        array('text', 'fmath_closetag'),
    );
    // Insert after all available slice.
    $first = array_slice($config_vars, 0);
    $config_vars = array_merge($first, $fmath);
}

/**
 * Add fMath editor configuration to the modification settings menu
 * @global type $txt
 * @param array $admin_areas
 */
function iaa_fMath(&$admin_areas)
{
    global $txt;
    loadLanguage('fmath');
    $admin_areas['config']['areas']['modsettings']['subsections']['fmath'] = array($txt['mods_cat_modifications_fmath']);
}

/**
 * Adds the subaction to the modify menu
 *
 * @param array $sub_actions
 */
function imm_fMath(&$sub_actions)
{
    $sub_actions['fmath'] = 'ModifyfMathsettings';
}
/**
 * The settings page for the modificaiton
 */
function ModifyfMathsettings($return_config = false)
{
    global $txt, $scripturl, $context;
    
    loadLanguage('fmath');
    $context[$context['admin_menu_name']]['tab_data']['tabs']['fmath']['description'] = $txt['fmath_desc'];
    
    $config_vars = array(
        array('text', 'fmath_opentag'),
        array('text', 'fmath_inlineopentag'),
        array('text', 'fmath_closetag'),
    );
    
    if ($return_config)
        return $config_vars;
        
    $context['post_url'] = $scripturl . '?action=admin;area=modsettings;save;sa=fmath';
    $context['settings_title'] = $txt['mods_cat_modifications_fmath'];
    if (isset($_GET['save']))
    {
        checkSession();
        saveDBSettings($config_vars);
        redirectexit('action=admin;area=modsettings;sa=fmath');
    }
    prepareDBSettingContext($config_vars);
}