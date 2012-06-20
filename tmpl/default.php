<?php
/**
 * @copyright	Copyright (C) 2009 - 2012 Sven Versteegen (http://joomworker.com)
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
*/

// no direct access
defined('_JEXEC') or die;
?>
<!-- start mod_wowprogress_ranks -->
<div class="wow-progress">
	<?php if ($ranks->error) : ?>
		<?php foreach ($ranks->errormsg as $emsg) : ?>
			<p class="wp_error"><?php echo htmlspecialchars(JText::_($emsg)); ?></p>
		<?php endforeach; ?>
	<?php else: ?>
	<div class="wp-content">
		<?php
		if ($params->get('showGuildName') or $params->get('showRealmName')) :
			require JModuleHelper::getLayoutPath('mod_wowprogress_ranks', '_default_grname');
		endif;
			require JModuleHelper::getLayoutPath('mod_wowprogress_ranks', '_default_ranks');
		?>
	</div>
		<?php if ($params->get('showWPlink')) : ?>
			<p class="wplink">
				<a href="http://www.wowprogress.com" title="<?php echo JText::_('MOD_WOWPROGRESS_RANKS_WPLINK_TITLE'); ?>"><?php echo JText::_('MOD_WOWPROGRESS_RANKS_WPLINK_TEXT'); ?></a>
			</p>
		<?php endif; ?>
	<?php endif; ?>
</div>
<!-- end mod_wowprogress_ranks -->
