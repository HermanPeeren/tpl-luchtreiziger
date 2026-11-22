<?php

/**
 * mod_custom with the Joomla 3 HTML: <div class="custom{moduleclass_sfx}">.
 * The CSS relies on it, e.g. .custom.headermodule in the top position.
 *
 * @copyright   (C) 2014 Joostrap, (C) 2014-2026 Herman Peeren
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Uri\Uri;

/** @var \Joomla\Registry\Registry $params */
/** @var \stdClass $module */

$moduleclassSfx = htmlspecialchars($params->get('moduleclass_sfx', ''), ENT_QUOTES, 'UTF-8');
$moduleclassSfx = $moduleclassSfx !== '' ? ' ' . trim($moduleclassSfx) : '';
$style          = '';

if ($params->get('backgroundimage')) {
    $image = Uri::root(true) . '/' . HTMLHelper::_('cleanImageURL', $params->get('backgroundimage'))->url;
    $style = ' style="background-image:url(' . htmlspecialchars($image, ENT_QUOTES, 'UTF-8') . ')"';
}
?>


<div class="custom<?php echo $moduleclassSfx; ?>"<?php echo $style; ?> >
    <?php echo $module->content; ?>
</div>
