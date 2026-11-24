<?php

/**
 * Luchtreiziger site template for Joomla 6, a Cassiopeia child template.
 *
 * The HTML below follows index.php of the Joomla 3 template luchtreiziger2014
 * (Joostrap Portfolio), so the ported CSS keeps working.
 *
 * @copyright   (C) 2014 Joostrap, (C) 2014-2026 Herman Peeren
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Multilanguage;
use Joomla\CMS\Uri\Uri;

/** @var \Joomla\CMS\Document\HtmlDocument $this */

$app    = Factory::getApplication();
$input  = $app->getInput();
$lang   = $app->getLanguage();
$wa     = $this->getWebAssetManager();
$menu   = $app->getMenu();
$active = $menu->getActive();

$view     = $input->getCmd('view', '');
$itemid   = $input->getCmd('Itemid', '');
$sitename = htmlspecialchars($app->get('sitename'), ENT_QUOTES, 'UTF-8');
$htmlLang = explode('-', $this->language)[0];

// Template parameters
$logoImage     = $this->params->get('logoFile', '');
$siteTitle     = $this->params->get('sitetitle', '');
$siteDesc      = $this->params->get('sitedescription', '');
$ogImage       = $this->params->get('ogImage', '');
$left          = (int) $this->params->get('sidebarLeftWidth', 4);
$right         = (int) $this->params->get('sidebarRightWidth', 3);
$frontpageshow = (int) $this->params->get('frontpageshow', 1);
$menuslide     = $this->params->get('menuslide', 'right');
$totop         = (int) $this->params->get('toTop', 0);
$copytext      = $this->params->get('copyrightsText', '');

// Frontpage check
$default     = Multilanguage::isEnabled() ? $menu->getDefault($lang->getTag()) : $menu->getDefault();
$isFrontpage = $active && $default && (int) $active->id === (int) $default->id;
$frontpage   = $isFrontpage ? 'frontpage' : '';

// Width of the main column
$hasLeft  = (bool) $this->countModules('left');
$hasRight = (bool) $this->countModules('right');
$span     = 12 - ($hasLeft ? $left : 0) - ($hasRight ? $right : 0);

// Body classes, the same as luchtreiziger2014
$bodyclass = $this->params->get('bodyclass', '');
$pageclass = $active ? $active->getParams()->get('pageclass_sfx', '') : '';
$parentId  = ($active && !empty($active->tree)) ? $active->tree[0] : '';
$alias     = $active ? $active->alias : '';
$loggedin  = $app->getIdentity()->guest ? 'loggedout' : 'loggedin';
$rtl       = $lang->isRtl() ? 'rtl' : 'no-rtl';

$bodyClasses = htmlspecialchars(
    implode(' ', [$bodyclass, $pageclass, 'parentid-' . $parentId, $alias, 'view-' . $view, $frontpage, 'itemid-' . $itemid, $loggedin, $rtl]),
    ENT_QUOTES,
    'UTF-8'
);

// Logo
if ($logoImage) {
    $logoUrl = Uri::root() . HTMLHelper::_('cleanImageURL', $logoImage)->url;
    $logo    = '<a href="' . $this->baseurl . '/" class="navbar-brand"><img src="' . htmlspecialchars($logoUrl, ENT_QUOTES, 'UTF-8') . '" alt="' . $sitename . '" /></a>';
} elseif ($siteTitle) {
    $logo = '<a href="' . $this->baseurl . '/" class="navbar-brand">' . htmlspecialchars($siteTitle, ENT_QUOTES, 'UTF-8')
        . ($siteDesc ? '<span class="site-description">' . htmlspecialchars($siteDesc, ENT_QUOTES, 'UTF-8') . '</span>' : '')
        . '</a>';
} else {
    $logo = '<a href="' . $this->baseurl . '/" class="navbar-brand">' . $sitename . '</a>';
}

// Open Graph image on the frontpage
if ($isFrontpage && $ogImage) {
    $this->setMetaData('og:image', Uri::root() . HTMLHelper::_('cleanImageURL', $ogImage)->url, 'property');
}

$this->setMetaData('viewport', 'width=device-width, initial-scale=1.0');
$this->addHeadLink(HTMLHelper::_('image', 'favicon.ico', '', [], true, 1), 'icon', 'rel', ['type' => 'image/vnd.microsoft.icon']);

// Styles, in the order of luchtreiziger2014 (Bootstrap 3 base, theme, icons, fonts)
$wa->registerAndUseStyle('luchtreiziger.bootstrap3', 'bootstrap3.min.css', ['version' => 'auto'], ['media' => 'screen'])
    ->registerAndUseStyle('luchtreiziger.style', 'style.css', ['version' => 'auto'], ['media' => 'screen'], ['luchtreiziger.bootstrap3'])
    ->registerAndUseStyle('luchtreiziger.backbone', 'j-backbone.css', ['version' => 'auto'], ['media' => 'screen'], ['luchtreiziger.style'])
    ->registerAndUseStyle('luchtreiziger.fontawesome4', 'font-awesome.min.css', ['version' => 'auto'], [], ['luchtreiziger.backbone'])
    ->registerAndUseStyle('luchtreiziger.font.roboto', 'https://fonts.googleapis.com/css?family=Roboto:400,400italic,500,500italic,700italic,700,900,900italic,300italic,300,100italic,100', [], [], ['luchtreiziger.fontawesome4'])
    ->registerAndUseStyle('luchtreiziger.font.robotocondensed', 'https://fonts.googleapis.com/css?family=Roboto+Condensed:300italic,400italic,700italic,400,700,300', [], [], ['luchtreiziger.font.roboto'])
    ->registerAndUseStyle('luchtreiziger.font.robotoslab', 'https://fonts.googleapis.com/css?family=Roboto+Slab:400,700,300,100', [], [], ['luchtreiziger.font.robotocondensed'])
    ->registerAndUseStyle('luchtreiziger.fontello', 'fontello.css', ['version' => 'auto'], ['media' => 'screen'], ['luchtreiziger.font.robotoslab'])
    ->registerAndUseStyle('luchtreiziger.compat', 'joomla6-compat.css', ['version' => 'auto'], [], ['luchtreiziger.fontello']);

// Scripts: jQuery from Joomla core, the mmenu off-canvas menu and a small template script
$wa->useScript('jquery-noconflict')
    ->useScript('jquery-migrate')
    ->registerAndUseScript('luchtreiziger.mmenu', 'jquery.mmenu.min.all.js', ['version' => 'auto'], ['defer' => true], ['jquery'])
    ->registerAndUseScript('luchtreiziger.template', 'template.js', ['version' => 'auto'], ['defer' => true], ['core', 'jquery', 'luchtreiziger.mmenu']);

$this->addScriptOptions('tpl_luchtreiziger', ['menuslide' => $menuslide]);

// mmenu CSS and custom.css come after the extension styles, as in luchtreiziger2014. Before them
// the CSS of the RSForm legacy layouts (inline, 2lines), which the plugin RSForm Pro Legacy
// Layouts loaded on Joomla 3; that plugin does not install on Joomla 6.
$mmenuCss  = HTMLHelper::_('stylesheet', 'jquery.mmenu.all.css', ['relative' => true, 'pathOnly' => true, 'version' => 'auto']);
$rsformCss = HTMLHelper::_('stylesheet', 'rsform-legacy.css', ['relative' => true, 'pathOnly' => true, 'version' => 'auto']);
$customCss = HTMLHelper::_('stylesheet', 'custom.css', ['relative' => true, 'pathOnly' => true, 'version' => 'auto']);
?>
<!DOCTYPE html>
<html class="no-js" lang="<?php echo $htmlLang; ?>" dir="<?php echo $this->direction; ?>">
<head>
    <jdoc:include type="metas" />
    <jdoc:include type="styles" />
    <jdoc:include type="scripts" />
    <link rel="stylesheet" href="<?php echo $rsformCss; ?>">
    <link rel="stylesheet" href="<?php echo $mmenuCss; ?>">
    <link rel="stylesheet" href="<?php echo $customCss; ?>" media="screen">
</head>
<body class="<?php echo $bodyClasses; ?>">
<div class="body-wrapper">
    <div class="navbar">
        <div class="navbar-header">
            <div class="container">
                <div class="basic-wrapper">
                    <div class="navbar-brand">
                        <?php echo $logo; ?></div>
                </div>
                <a href="#sidebar">
                    <div type="button" class="navbar-toggle visible-xs">
                        <i class='icon-menu-1'></i>
                        Menu
                    </div>
                </a>
                <nav class="collapse navbar-collapse pull-right" id="sidebar">
                    <?php if ($this->countModules('menu')) : ?>
                        <jdoc:include type="modules" name="menu" style="none" />
                    <?php endif; ?>
                </nav>
            </div>
        </div>
    </div>
    <?php if ($this->countModules('carousel')) : ?>
        <div class="fullscreenbanner-container revolution">
            <div class="fullscreenbanner revslider-initialised tp-simpleresponsive">
                <jdoc:include type="modules" name="carousel" style="standard" />
            </div>
        </div>
    <?php endif; ?>
    <?php if ($this->countModules('strapline')) : ?>
        <div class="strapline">
            <div class="strapline">
                <jdoc:include type="modules" name="strapline" style="standard" />
            </div>
        </div>
    <?php endif; ?>
    <?php if ($this->countModules('top')) : ?>
        <div class="light-wrapper">
            <div class="container inner">
                <jdoc:include type="modules" name="top" style="none" />
            </div>
        </div>
    <?php endif; ?>
    <div class="container inner">
        <div class="row">
            <?php if ($hasLeft) : ?>
                <aside class="col-md-<?php echo $left; ?>">
                    <section class="sidebar left-sidebar">
                        <jdoc:include type="modules" name="left" style="standard" />
                    </section>
                </aside>
            <?php endif; ?>
            <?php if (!$isFrontpage || $frontpageshow) : ?>
                <div class="col-md-<?php echo $span; ?>">
                    <jdoc:include type="modules" name="top-article" style="xhtml" />
                    <jdoc:include type="message" />
                    <?php if ($this instanceof \Joomla\CMS\Document\ErrorDocument) : ?>
                        <?php require __DIR__ . '/error-content.php'; ?>
                    <?php else : ?>
                        <jdoc:include type="component" />
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            <?php if ($hasRight) : ?>
                <aside class="col-md-<?php echo $right; ?>">
                    <section class="sidebar right-sidebar">
                        <jdoc:include type="modules" name="right" style="standard" />
                    </section>
                </aside>
            <?php endif; ?>
        </div>
    </div>
    <?php if ($this->countModules('middle')) : ?>
        <div class="black-wrapper inner">
            <div class="container">
                <jdoc:include type="modules" name="middle" style="none" />
            </div>
        </div>
    <?php endif; ?>
    <?php if ($this->countModules('bottom1')) : ?>
        <div class="light-wrapper">
            <div class="container inner">
                <jdoc:include type="modules" name="bottom1" style="none" />
            </div>
        </div>
    <?php endif; ?>
    <?php if ($this->countModules('bottom2')) : ?>
        <div class="black-wrapper">
            <div class="inner">
                <jdoc:include type="modules" name="bottom2" style="none" />
            </div>
        </div>
    <?php endif; ?>
    <?php if ($this->countModules('footer1')) : ?>
        <div class="light-wrapper">
            <div class="container inner">
                <jdoc:include type="modules" name="footer1" style="none" />
            </div>
        </div>
        <div class="clear"></div>
    <?php endif; ?>

    <!-- footer menu -->
    <div class="light-wrapper">
        <div class="container inner ondermenu">
            <div class="col-xs-6 col-md-3">
                <jdoc:include type="modules" name="ondermenu1" style="none" />
            </div>
            <div class="col-xs-6 col-md-3">
                <jdoc:include type="modules" name="ondermenu2" style="none" />
            </div>
            <div class="col-xs-6 col-md-3">
                <jdoc:include type="modules" name="ondermenu3" style="none" />
            </div>
            <div class="col-xs-6 col-md-3">
                <jdoc:include type="modules" name="ondermenu4" style="none" />
            </div>
        </div>
    </div>

    <div class="clear"></div>
    <?php if ($this->countModules('footer2')) : ?>
        <footer class="footer black-wrapper">
            <div class="container inner">
                <jdoc:include type="modules" name="footer2" style="none" />
            </div>
            <?php if ($copytext) : ?>
                <div class="container">
                    <?php echo $copytext; ?>
                </div>
            <?php endif; ?>
        </footer>
    <?php endif; ?>
    <?php if ($totop) : ?>
        <a href="#" class="go-top">naar boven <i class="fa fa-arrow-circle-up"></i></a>
    <?php endif; ?>
</div>
<div id="sidebar">
    <div id="panel-overview">
        <?php if ($this->countModules('mob-menu-above')) : ?>
            <div class="mob-menu-above">
                <jdoc:include type="modules" name="mob-menu-above" style="standard" />
            </div>
        <?php endif; ?>
        <?php if ($this->countModules('menu')) : ?>
            <jdoc:include type="modules" name="menu" style="none" />
        <?php endif; ?>
        <?php if ($this->countModules('mob-menu-below')) : ?>
            <div class="mob-menu-below">
                <jdoc:include type="modules" name="mob-menu-below" style="standard" />
            </div>
        <?php endif; ?>
    </div>
</div>
<?php if ($this->countModules('debug')) : ?>
    <jdoc:include type="modules" name="debug" style="none" />
<?php endif; ?>
</body>
</html>
