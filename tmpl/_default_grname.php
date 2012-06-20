<?php
/**
 * @copyright	Copyright (C) 2011 - 2012 Sven Versteegen (http://joomworker.com)
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
*/

// no direct access
defined('_JEXEC') or die;

$link_guildname = (int) $params->get('linkGuildName');
?>
<?php if ($params->get('showGRinLine')) : ?>
	<p class="guildrealm">
	<?php if ($params->get('showGuildName')) : ?>
		<span class="guildname">
			<?php if ($link_guildname) : ?>
				<a href="<?php echo $ranks->guildlink; ?>" title="<?php echo $guild_name; ?> on WoWProgress">
			<?php endif; ?>
			<?php echo JText::_($guild_name.' '); ?>
			<?php if ($link_guildname) : ?>
				</a>
			<?php endif; ?>
		</span>
	<?php endif; ?>
	<?php if ($params->get('showRealmName')) : ?>
		<span class="realmname"><?php echo JText::_(' '.$realm_name .' ('. JString::strtoupper($guild_area) .')'); ?></span>
	<?php endif; ?>
	</p>
<?php else: ?>
	<?php if ($params->get('showGuildName')) : ?>
		<h4 class="guildname">
			<?php if ($link_guildname) : ?>
				<a href="<?php echo $ranks->guildlink; ?>" title="<?php echo $guild_name; ?> on WoWProgress">
			<?php endif; ?>
			<?php echo JText::_($guild_name); ?>
			<?php if ($link_guildname) : ?>
				</a>
			<?php endif; ?>
		</h4>
	<?php endif; ?>
	<?php if ($params->get('showRealmName')) : ?>
		<h5 class="realmname"><?php echo JText::_($realm_name .' ('. JString::strtoupper($guild_area) .')'); ?></h5>
	<?php endif; ?>
<?php endif; ?>