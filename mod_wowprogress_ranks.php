<?php
/**
 * @copyright	Copyright (C) 2010 - 2012 Sven Versteegen (http://joomworker.com)
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
*/

// no direct access
defined('_JEXEC') or die;

// check if curl is installed
if (!function_exists('curl_init')) {
	JError::raiseError('WoWProgress Ranks Module', JText::_('MOD_WOWPROGRESS_RANKS_ERROR_NOCURL'));
}

require_once dirname( __FILE__ ).'/helper.php';

$guild_name		= htmlspecialchars(JString::trim($params->get('guildName')));
$realm_name		= htmlspecialchars(JString::trim($params->get('realmName')));
$guild_area		= $params->get('guildArea', 'eu');

$tier_ranks_num	= (int) JString::substr($params->get('tierRanks'), -2);
$rankBy			= ('enc' === $params->get('rankingEncAch', 'enc')) ? JText::_('MOD_WOWPROGRESS_RANKS_ENC') : JText::_('MOD_WOWPROGRESS_RANKS_ACH');
$ranksdef		= (int) $params->get('showDefRanks', 1);
$ranks10		= (int) $params->get('show10Ranks', 1);
$ranks25		= (int) $params->get('show25Ranks', 1);

// TODO: change deprecated JRequest
$cacheid = md5(JRequest::getVar('lang').$module->module);

$cacheparams				= new stdClass;
$cacheparams->cachemode		= 'id';
$cacheparams->class			= 'modWowProgressRanksHelper';
$cacheparams->method		= 'getRanks';
$cacheparams->methodparams	= $params;
$cacheparams->modeparams	= $cacheid;

// insert css for the layout when activated
if ($params->get('useOwnCss', 1)) {
	// calculate widht for dd`s
	$dd = $ranksdef + $ranks10 + $ranks25;
	modWowProgressRanksHelper::insertCss($params->get('layout', 'default'), $dd);
}

// get ranks
$ranks = JModuleHelper::moduleCache($module, $params, $cacheparams);

require JModuleHelper::getLayoutPath('mod_wowprogress_ranks', $params->get('layout', 'default'));