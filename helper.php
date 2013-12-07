<?php
/**
 * @copyright	Copyright (C) 2010 - 2012 Sven Versteegen (http://joomworker.com)
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
*/

// no direct access
defined('_JEXEC') or die;

abstract class modWowProgressRanksHelper
{
	/**
	 * Get Ranks
	 *
	 * @param	object	$params		Module params.
	 * @return	mixed	$output		Rank data object or error.
	 */
	public static function getRanks($params)
	{
		// get guild data
		$guild_name	= htmlspecialchars(JString::trim($params->get('guildName')));
		$realm_name	= htmlspecialchars(JString::trim($params->get('realmName')));
		$guild_area	= $params->get('guildArea', 'eu');

		$output = self::getData($guild_name, $realm_name, $guild_area, $params);

		return $output;
	}

	/**
	 * getData
	 *
	 * @param	string	$guild_name	The guild name.
	 * @param	string	$realm_name	The realm name.
	 * @param	string	$guild_area	The area where the guild play.
	 * @param	object	$params		Module params.
	 * @return	object	$out		Rank data and errors.
	 */
	private static function getData($guild_name, $realm_name, $guild_area, $params)
	{
		$pregsearch		= array(" ", "'");
		$guild_name		= str_replace($pregsearch, '+', $guild_name);
		$realm_name		= JString::strtolower(str_replace($pregsearch, '-', $realm_name));
		$wp_guild_url	= 'http://www.wowprogress.com/guild/'. $guild_area .'/'. $realm_name .'/'. $guild_name;
		$tier_rank		= $params->get('tierRanks');

		$out			= new stdClass;
		$out->error		= false;
		$out->errormsg	= array();
		$out->guildlink	= $wp_guild_url;

		$encach = ('enc' === $params->get('rankingEncAch', 'enc')) ? '' : '.ach';

		$ranksdef_url	= '/rating.'. $tier_rank . $encach .'/json_rank';
		$ranks10_url	= '/rating.'. $tier_rank .'_10'. $encach .'/json_rank';
		$ranks25_url	= '/rating.'. $tier_rank .'_25'. $encach .'/json_rank';
				
		if ($params->get('showDefRanks', 1))
		{
			$ranks_def = self::grabData($wp_guild_url . $ranksdef_url);

			if (array_key_exists('error', $ranks_def)) {
				$out->error			= true;
				$out->errormsg[]	= $ranks_def['errormsg'];
			} else {
				$out->ranksdef = $ranks_def;
			}
		}

		if ($params->get('show10Ranks', 1))
		{
			$ranks_10 = self::grabData($wp_guild_url . $ranks10_url);

			if (array_key_exists('error', $ranks_10)) {
				$out->error			= true;
				$out->errormsg[]	= $ranks_10['errormsg'];
			} else {
				$out->ranks10 = $ranks_10;
			}
		}

		if ($params->get('show25Ranks', 1))
		{
			$ranks_25 = self::grabData($wp_guild_url . $ranks25_url);

			if (array_key_exists('error', $ranks_25)) {
				$out->error			= true;
				$out->errormsg[]	= $ranks_25['errormsg'];
			} else {
				$out->ranks25 = $ranks_25;
			}
		}

		return $out;
	}

	/**
	 * grabData
	 *
	 * @param	string	$url	Url to grab the json data.
	 * @return	array	$return	Rank data or error.
	 */
	private static function grabData($url)
	{
		$uagent	= 'Mozilla/5.0 (X11; Linux i686; rv:6.0) Gecko/20100101 Firefox/6.0';
		$ch		= curl_init();
		$options	= array(
						CURLOPT_URL				=> $url,
						CURLOPT_HEADER			=> false,				
						CURLOPT_USERAGENT		=> $uagent,
						CURLOPT_RETURNTRANSFER	=> true,
						CURLOPT_TIMEOUT			=> 15
						);

		curl_setopt_array($ch, $options);
		$wp_data = curl_exec($ch);

		//check for curl error
		if (curl_errno($ch))
		{
			$result = array('error' => 1, 'errormsg' => 'Curl error: '. curl_error($ch));
			curl_close($ch);
			return $result;
		}

		curl_close($ch);
		$wp_data = explode("\n", $wp_data);

		//check if guild is ranked
		if ('null' === $wp_data[0] or empty($wp_data[0])) {
			$result = array('score' => 'MOD_WOWPROGRESS_RANKS_NOT_RANKED', 'world_rank' => 'MOD_WOWPROGRESS_RANKS_NOT_RANKED', 'area_rank' => 'MOD_WOWPROGRESS_RANKS_NOT_RANKED', 'realm_rank' => 'MOD_WOWPROGRESS_RANKS_NOT_RANKED');
		}
		else {
			$wpr = json_decode(trim($wp_data[0]), true);

			//check if we have an array
			if (!is_array($wpr) or 4 !== count($wpr)) {
				$result = array('error' => 1, 'errormsg' => 'MOD_WOWPROGRESS_RANKS_ERROR_GETDATA');
			}
			else {
				$score	= (int) $wpr['score'];
				$sc		= strlen($score) - 2;

				$wpr['score']		= substr($score, 0, $sc) .'.'. substr($score, -2);
				$wpr['world_rank']	= (int) $wpr['world_rank'];
				$wpr['area_rank']	= (int) $wpr['area_rank'];
				$wpr['realm_rank']	= (int) $wpr['realm_rank'];
				
				$result = $wpr;
			}
		}

		return $result;
	}

	/**
	 * insertCss
	 *
	 * We look for an override in /yourTemplate/html/mod_wowprogress_ranks/css/
	 * the css files are named like the layout files
	 *
	 * @param	string	$css_file	Css file to include.
	 */
	public static function insertCss($layout, $dd = 3)
	{	
		if (false !== strpos($layout, ':')) {
			$temp = explode(':', $layout);
			$layout = ($temp[1]) ? $temp[1] : 'default';
		}
		
		$doc			= JFactory::getDocument();
		$css_file		= $layout .'.css';
		$css_tmpl_path	= JPATH_SITE .'/templates/'. $doc->template .'/html/mod_wowprogress_ranks/css/'. $css_file;
		$css_mod_path	= JPATH_BASE .'/modules/mod_wowprogress_ranks/css/'. $css_file;
		
		// check for override file in template
		if (is_file($css_tmpl_path)) {
			if (!$css = JFile::read($css_tmpl_path)) {
				JError::raiseError('WoWProgress Ranks Module', JText::_('Houston we have a problem reading the css file. Please check if we have read access to the file.'));
			}
		}
		else {
			if (!$css = JFile::read($css_mod_path)) {
				JError::raiseError('WoWProgress Ranks Module', JText::_('Houston we have a problem reading the css file. Please check if we have read access to the file.'));
			}
		}

		// make a one liner for the <head>
		$pattern = array();	$replace = array();
		// remove comments
		$pattern[] = '!/\*[^*]*\*+([^/][^*]*\*+)*/!';	$replace[] = '';
		// convert all whitespaces to a single space, including lone \t and \n - maybe don`t working on Win...
		$pattern[] = '/\s+/';		$replace[] = ' ';
		// remove whitespaces arround { } , : ;
		$pattern[] = '/\s?\{\s?/';	$replace[] = '{';
		$pattern[] = '/\s?\}\s?/';	$replace[] = '}';
		$pattern[] = '/\s?\,\s?/';	$replace[] = ',';
		$pattern[] = '/\s?\:\s?/';	$replace[] = ':';
		$pattern[] = '/\s?\;\s?/';	$replace[] = ';';

		$css = preg_replace($pattern, $replace, $css);
		
		// dd percentages
		$dd_arr = array(1 => '60%', 2 => '30%', 3 => '20%');
		$css .= '.wp-ranking dd{width:'. $dd_arr[$dd] .';}';

		$doc->addStyleDeclaration($css);	
	}
}
