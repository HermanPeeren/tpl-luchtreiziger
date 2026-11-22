<?php

/**
 * mod_menu with the Joomla 3 HTML of luchtreiziger2014 (Bootstrap 3 navbar classes).
 * A menu in the "menu" position gets "navbar-nav"; its parents get "dropdown",
 * their submenus "dropdown-menu" and the link a caret. The dropdowns open on hover (CSS).
 *
 * @copyright   (C) 2014 Joostrap, (C) 2014-2026 Herman Peeren
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Helper\ModuleHelper;

/** @var \Joomla\Registry\Registry $params */
/** @var \stdClass $module */
/** @var array $list */
/** @var array $path */
/** @var int $active_id */
/** @var string $class_sfx */

$classSfx = trim($class_sfx);

// For modules in the menu navigation we add the Bootstrap class for navbars
if ($module->position === 'menu') {
    $classSfx = trim($classSfx . ' navbar-nav');
}

$isNavbarNav = stripos($classSfx, 'navbar-nav') !== false;
$tagId       = $params->get('tag_id', '');
?>
<ul class="nav menu<?php echo $classSfx !== '' ? ' ' . $classSfx : ''; ?>"<?php echo $tagId ? ' id="' . htmlspecialchars($tagId, ENT_QUOTES, 'UTF-8') . '"' : ''; ?>>
<?php foreach ($list as $i => &$item) {
    $itemParams           = $item->getParams();
    $item->isNavbarNav    = $isNavbarNav;
    $item->isParentAnchor = false;

    $class = 'item-' . $item->id;

    if ($item->id == $active_id) {
        $class .= ' current';
    }

    if (in_array($item->id, $path)) {
        $class .= ' active';
    } elseif ($item->type === 'alias') {
        $aliasToId = $itemParams->get('aliasoptions');

        if (count($path) > 0 && $aliasToId == $path[count($path) - 1]) {
            $class .= ' active';
        } elseif (in_array($aliasToId, $path)) {
            $class .= ' alias-parent-active';
        }
    }

    if ($item->type === 'separator') {
        $class .= ' divider';
    }

    if ($item->deeper) {
        $class .= ' deeper';
    }

    if ($item->parent) {
        $class .= ' parent';
        $item->isParentAnchor = true;

        if ($isNavbarNav) {
            $class .= ' dropdown';

            if ($item->level > 1) {
                $class .= ' dropdown-submenu';
            }
        }
    }

    echo '<li class="' . $class . '">';

    switch ($item->type) :
        case 'separator':
        case 'url':
        case 'component':
        case 'heading':
            require ModuleHelper::getLayoutPath('mod_menu', 'default_' . $item->type);
            break;

        default:
            require ModuleHelper::getLayoutPath('mod_menu', 'default_url');
            break;
    endswitch;

    if ($item->deeper) {
        // The next item is deeper.
        echo '<ul class="nav-child unstyled small' . ($isNavbarNav ? ' dropdown-menu' : '') . '">';
    } elseif ($item->shallower) {
        // The next item is shallower.
        echo '</li>';
        echo str_repeat('</ul></li>', $item->level_diff);
    } else {
        // The next item is on the same level.
        echo '</li>';
    }
}
?></ul>
