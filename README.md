# Luchtreiziger template for Joomla 6

Site template of De Luchtreiziger Ballonvaarten (luchtreiziger.nl), for Joomla 6.

It reproduces the look of the Joomla 3 template `luchtreiziger2014` (based on the
Joostrap Portfolio template, Bootstrap 3) as a **child template of Cassiopeia**. The goal of
this first version: get the site running on Joomla 6 as soon as possible, looking as unchanged
as possible. Cleaning up comes later.

- Template name: `luchtreiziger2026` (a new name, so it does not clash with the old
  `luchtreiziger2014` or the other old `luchtreiziger` template during the migration)
- Parent: `cassiopeia`
- Requires: Joomla 6

## Build and install

```
php build.php
```

This creates `dist/tpl_luchtreiziger2026-<version>.zip`. Install it via
System → Install → Extensions, then make the style `luchtreiziger2026 - Default` the default site style.

**Before building:** copy the Gosmick Sans webfont files
(`gosmicksans-webfont.*` and `gosmicksansbold-webfont.*`) from
`templates/luchtreiziger2014/fonts/` of the old site to `src/media/fonts/`.
They are not in this repository: the font says "Copyright (c) Graham Meade, 2003. All rights
reserved.", so it may not be redistributed publicly. `build.php` warns when they are missing.
Without them headings and the menu fall back to another font.

## Layout of this repository

```
src/
  templateDetails.xml     manifest, <parent>cassiopeia</parent>
  index.php               the HTML of luchtreiziger2014/index.php, on Joomla 6 APIs
  html/layouts/chromes/   module chromes: standard, xhtml, basic
  html/mod_menu/          menu with the Joomla 3 / Bootstrap 3 HTML (navbar-nav, dropdown, caret)
  html/mod_custom/        custom module with <div class="custom{module class}">
  language/en-GB/
  media/                  installed to media/templates/site/luchtreiziger2026/
    css/  fonts/  images/  js/
build.php
```

## Module positions

The same names as `luchtreiziger2014`, so the module assignments survive the migration:

`mob-menu-above`, `menu`, `mob-menu-below`, `carousel`, `strapline`, `top`, `middle`,
`top-article`, `left`, `left_menu`, `right`, `bottom1`, `bottom2`, `footer1`,
`ondermenu1` … `ondermenu4`, `footer2`, `debug`.

`ondermenu1`–`ondermenu4` (the footer menu columns) were used by the old `index.php` but
missing from its manifest; they are now listed. `left_menu` was in the old manifest but never
rendered; that has not changed.

The module chromes are the same as before: `standard` for `left`, `right`, `carousel`,
`strapline`, `mob-menu-above/below` (`<div class="module"><div class="headline"><h4>`),
`xhtml` for `top-article` (`<div class="moduletable">`, removed from core in Joomla 4, so
added here), `none` for the rest.

## What was ported

- **HTML of `index.php`**: navbar with logo and menu, mobile menu toggle, the
  `light-wrapper` / `black-wrapper` / `container inner` structure, the column widths, the four
  footer menu columns, `footer2`, the hidden `#sidebar` for the mobile menu, and the body
  classes (`parentid-…`, menu alias, `view-…`, `frontpage`, `itemid-…`, `loggedin/loggedout`,
  `no-rtl`, page class).
- **CSS**, unchanged and in the same order: Bootstrap 3.0 (`bootstrap3.min.css`),
  `style.css` (Joostrap theme), `j-backbone.css`, Font Awesome 4.0, Google fonts Roboto /
  Roboto Condensed / Roboto Slab, `fontello.css`; after the extension styles:
  `jquery.mmenu.all.css` and `custom.css` (the Luchtreiziger colours, fonts and headings).
  Only the font paths in `fontello.css` were adjusted to the new folder.
- **Menu dropdowns** open on hover, as before; this was already CSS only.
- **Mobile menu**: jQuery mmenu 4.2.5 (MIT), started from `media/js/template.js` with the
  same options (`mm-dark`, slides in from the right, header).
- **"Naar boven" (back to top) link**, behind the template option (it was off on the live site).
- **Layout overrides** only where the HTML must stay the same for the CSS:
  `mod_menu` (Bootstrap 3 navbar classes and caret, `nav menu` classes, `nav-header` headings)
  and `mod_custom` (`.custom.headermodule` in the header banner).
- **Template options** that the site used: logo (default `images/Mascotte100.png`),
  site title/description as fallback, sidebar widths (left 4, right 3), show component on
  the homepage, extra body class, side of the mobile menu, back-to-top link, text below the
  footer, and the `og:image` on the homepage (was hard-coded, now an option with the same image).
- **jQuery** now comes from Joomla core (`jquery`, `jquery-noconflict`, `jquery-migrate`)
  instead of the copy in the template.

## Known quirk: `<h3>` as a button

On this site an `<h3>` with a link inside acts as a button ("Lees meer over ons",
"Ballonvaart reserveren", …): `custom.css` styles **every** `h3` as an orange rounded
button with `margin-left: 30%`. This is kept exactly as it was for now. A later round turns
these into real `<button>`/link buttons in the content and removes the `h3` rule.

Side effect to keep in mind: any `<h3>` that a Joomla 6 core layout writes (for example
on contact, search or category pages, or a module title with header tag `h3`) also looks
like an orange button, just as in Joomla 3.

## What differs from luchtreiziger2014

Left out on purpose:

- Google Analytics (Universal Analytics `ga.js`): Universal Analytics stopped in 2023, so the
  hard-coded snippet did nothing anymore. Add GA4 or another tool separately if wanted.
- Scripts of the Joostrap demo features that the site does not use: Bootstrap 3 JavaScript,
  hover-dropdown plugin, fancybox, isotope, easytabs, swiper, sticky, prettify, instafeed,
  Flickr feed, retina.js, classie, the "mode-xs/sm/md/lg" body classes. With their CSS
  (`settings.css` of Revolution Slider, `prettify.css`, fancybox CSS) and the Budicons font.
- The LESS compiler, colour pickers, Google-fonts pickers, custom CSS field, jQuery/Bootstrap
  loading options and the generator tag option of the old template.
- IE8 conditional comments, `html5shiv` and `respond.js`.
- The two empty icon links at the top of the mobile menu (`$icon1`/`$icon6` were never set).
- JCE, Regular Labs and AcyMailing styles: those extensions do not come back.
- The old overrides for `com_content`, `com_contact`, `com_users` and `mod_search` were not
  ported: those were Joomla 3 layouts that do not work on Joomla 6 (`mod_search` no longer
  exists). The Joomla 6 core layouts are used instead; `joomla6-compat.css` adds the few
  Bootstrap 5 utility classes they use (`visually-hidden`, `float-end`, …).

Different because of Joomla 6:

- Error page, offline page and `component.php` (print/popup) come from Cassiopeia, so they
  look like Cassiopeia, not like the site.
- Joomla 6 writes `<meta>`, styles and scripts itself (`<jdoc:include type="metas|styles|scripts">`),
  so the order and attributes of the `<head>` differ somewhat.
- System messages are Joomla 6 `<joomla-alert>` elements instead of Bootstrap alerts.
- Article, category and form pages use the Joomla 6 core HTML (Bootstrap 5 class names) inside
  the old Bootstrap 3 page. The selectors that `custom.css` uses (`.item-page`, `.page-header`,
  `h1`–`h4`, `.btn`, `blockquote`, tables) still exist.

## Licence

GNU General Public License version 2 or later, see `LICENSE.txt`. Based on the Joostrap
Portfolio template (GPL). Included third-party files: Bootstrap 3.0 CSS (MIT),
Font Awesome 4.0 (font: SIL OFL 1.1, CSS: MIT), Fontello icon fonts, jQuery mmenu 4.2.5 (MIT/GPL).
