<?php

/**
 * Module chrome "xhtml" as it was in Joomla 3 (removed from core in Joomla 4).
 * Used by the top-article position.
 *
 * @copyright   (C) 2014 Joostrap, (C) 2014-2026 Herman Peeren
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

$module  = $displayData['module'];
$params  = $displayData['params'];

if ((string) $module->content === '') {
    return;
}

$headerTag   = htmlspecialchars($params->get('header_tag', 'h3'), ENT_QUOTES, 'UTF-8');
$headerClass = htmlspecialchars($params->get('header_class', ''), ENT_QUOTES, 'UTF-8');
$modClassSfx = htmlspecialchars($params->get('moduleclass_sfx', ''), ENT_QUOTES, 'UTF-8');
$modClassSfx = $modClassSfx !== '' ? ' ' . trim($modClassSfx) : '';
?>
<div class="moduletable<?php echo $modClassSfx; ?>">
    <?php if ((bool) $module->showtitle) : ?>
        <<?php echo $headerTag; ?><?php echo $headerClass !== '' ? ' class="' . $headerClass . '"' : ''; ?>><?php echo $module->title; ?></<?php echo $headerTag; ?>>
    <?php endif; ?>
    <?php echo $module->content; ?>
</div>
