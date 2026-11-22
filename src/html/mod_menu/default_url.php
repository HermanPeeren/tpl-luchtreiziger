<?php

/**
 * Menu link as in luchtreiziger2014: Bootstrap 3 caret on parent items.
 *
 * @copyright   (C) 2014 Joostrap, (C) 2014-2026 Herman Peeren
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\Filter\OutputFilter;

/** @var \Joomla\CMS\Menu\MenuItem $item */
/** @var \Joomla\Registry\Registry $itemParams */
/** @var \Joomla\Registry\Registry $params */

$attributes = [];

if ($item->anchor_css) {
    $attributes['class'] = $item->anchor_css;
}

if ($item->anchor_title) {
    $attributes['title'] = $item->anchor_title;
}

if ($item->anchor_rel) {
    $attributes['rel'] = $item->anchor_rel;
}

if ($item->menu_image) {
    $linktype = HTMLHelper::_('image', $item->menu_image, $item->title);

    if ($itemParams->get('menu_text', 1)) {
        $linktype .= '<span class="image-title">' . $item->title . '</span> ';
    }
} else {
    $linktype = $item->title;

    // Add Bootstrap caret
    if (!empty($item->isParentAnchor)) {
        $linktype .= ' <span class="caret"></span>';
    }
}

if ($item->browserNav == 1) {
    $attributes['target'] = '_blank';
} elseif ($item->browserNav == 2) {
    $options = 'toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,' . $params->get('window_open');

    $attributes['onclick'] = "window.open(this.href,'targetWindow','" . $options . "');return false;";
}

echo HTMLHelper::_('link', OutputFilter::ampReplace(htmlspecialchars($item->flink, ENT_COMPAT, 'UTF-8', false)), $linktype, $attributes);
