<?php

/**
 * Module chrome "standard" of luchtreiziger2014 (Joostrap), ported to a Joomla 6 layout.
 * Output: <div class="module{sfx}"><div class="headline"><h4>title</h4></div><div class="module-content">...</div></div>
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

$moduleTag   = htmlspecialchars($params->get('module_tag', 'div'), ENT_QUOTES, 'UTF-8');
$modClassSfx = $params->get('moduleclass_sfx', '');
$modClassSfx = $modClassSfx !== '' ? ' ' . trim(htmlspecialchars($modClassSfx, ENT_QUOTES, 'UTF-8')) : '';
?>
<<?php echo $moduleTag; ?> class="module<?php echo $modClassSfx; ?>">

    <?php if ((bool) $module->showtitle) : ?>
        <div class="headline">
            <h4><?php echo $module->title; ?></h4>
        </div>
    <?php endif; ?>
    <div class="module-content">
        <?php echo $module->content; ?>
    </div>
</<?php echo $moduleTag; ?>>
