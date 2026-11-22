<?php

/**
 * Menu separator as in luchtreiziger2014.
 *
 * @copyright   (C) 2014 Joostrap, (C) 2014-2026 Herman Peeren
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;

/** @var \Joomla\CMS\Menu\MenuItem $item */
/** @var \Joomla\Registry\Registry $itemParams */

$title    = $item->anchor_title ? ' title="' . htmlspecialchars($item->anchor_title, ENT_QUOTES, 'UTF-8') . '"' : '';
$linktype = $item->title;

if ($item->menu_image) {
    $linktype = HTMLHelper::_('image', $item->menu_image, $item->title);

    if ($itemParams->get('menu_text', 1)) {
        $linktype .= '<span class="image-title">' . $item->title . '</span> ';
    }
}
?><span class="separator"<?php echo $title; ?>><?php echo $linktype; ?></span>
