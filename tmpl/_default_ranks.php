<?php
/**
 * @copyright	Copyright (C) 2011 - 2012 Sven Versteegen (http://joomworker.com)
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
*/

// no direct access
defined('_JEXEC') or die;
?>
<dl class="wp-ranking">
	<dt class="tierset-label"><?php echo JText::sprintf('MOD_WOWPROGRESS_RANKS_TIERSET', $tier_ranks_num, $rankBy); ?></dt>
		<?php if ($ranksdef) : ?>
		<dd class="rank-def"><?php echo JText::_('MOD_WOWPROGRESS_RANKS_RANKDEF'); ?></dd>
		<?php endif; ?>
		<?php if ($ranks10) : ?>
		<dd class="rank-10"><?php echo JText::_('MOD_WOWPROGRESS_RANKS_RANK10'); ?></dd>
		<?php endif; ?>
		<?php if ($ranks25) : ?>
		<dd class="rank-25"><?php echo JText::_('MOD_WOWPROGRESS_RANKS_RANK25'); ?></dd>
		<?php endif; ?>

	<?php if ($params->get('showWorldRank')) : ?>
	<dt class="world-rank-label"><?php echo JText::_('MOD_WOWPROGRESS_RANKS_WORLDRANK'); ?></dt>
		<?php if ($ranksdef) : ?>
		<dd class="world-rank-def"><?php echo JText::_($ranks->ranksdef['world_rank']); ?></dd>
		<?php endif; ?>
		<?php if ($ranks10) : ?>
		<dd class="world-rank-10"><?php echo JText::_($ranks->ranks10['world_rank']); ?></dd>
		<?php endif; ?>
		<?php if ($ranks25) : ?>
		<dd class="world-rank-25"><?php echo JText::_($ranks->ranks25['world_rank']); ?></dd>
		<?php endif; ?>
	<?php endif; ?>

	<?php if ($params->get('showAreaRank')) : ?>
	<dt class="area-rank-label"><?php echo JText::sprintf('MOD_WOWPROGRESS_RANKS_AREARANK', JString::strtoupper($guild_area)); ?></dt>
		<?php if ($ranksdef) : ?>
		<dd class="area-rank-def"><?php echo JText::_($ranks->ranksdef['area_rank']); ?></dd>
		<?php endif; ?>
		<?php if ($ranks10) : ?>
		<dd class="area-rank-10"><?php echo JText::_($ranks->ranks10['area_rank']); ?></dd>
		<?php endif; ?>
		<?php if ($ranks25) : ?>
		<dd class="area-rank-25"><?php echo JText::_($ranks->ranks25['area_rank']); ?></dd>
		<?php endif; ?>
	<?php endif; ?>

	<?php if ($params->get('showRealmRank')) : ?>
	<dt class="realm-rank-label"><?php echo JText::_('MOD_WOWPROGRESS_RANKS_REALMRANK'); ?></dt>
		<?php if ($ranksdef) : ?>
		<dd class="realm-rank-def"><?php echo JText::_($ranks->ranksdef['realm_rank']); ?></dd>
		<?php endif; ?>
		<?php if ($ranks10) : ?>
		<dd class="realm-rank-10"><?php echo JText::_($ranks->ranks10['realm_rank']); ?></dd>
		<?php endif; ?>
		<?php if ($ranks25) : ?>
		<dd class="realm-rank-25"><?php echo JText::_($ranks->ranks25['realm_rank']); ?></dd>
		<?php endif; ?>
	<?php endif; ?>

	<?php if ($params->get('showScore')) : ?>
	<dt class="score-rank-label"><?php echo JText::_('MOD_WOWPROGRESS_RANKS_SCORE'); ?></dt>
		<?php if ($ranksdef) : ?>
		<dd class="score-rank-def"><?php echo JText::_($ranks->ranksdef['score']); ?></dd>
		<?php endif; ?>
		<?php if ($ranks10) : ?>
		<dd class="score-rank-10"><?php echo JText::_($ranks->ranks10['score']); ?></dd>
		<?php endif; ?>
		<?php if ($ranks25) : ?>
		<dd class="score-rank-25"><?php echo JText::_($ranks->ranks25['score']); ?></dd>
		<?php endif; ?>
	<?php endif; ?>
</dl>