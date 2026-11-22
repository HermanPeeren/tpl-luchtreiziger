<?php

/**
 * Builds the installable template zip: php build.php
 *
 * Output: dist/tpl_luchtreiziger2026-<version>.zip, with templateDetails.xml at the root.
 *
 * @copyright   (C) 2026 Herman Peeren
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

$src      = __DIR__ . '/src';
$manifest = simplexml_load_file($src . '/templateDetails.xml');
$version  = (string) $manifest->version;
$dist     = __DIR__ . '/dist';
$zipFile  = $dist . '/tpl_luchtreiziger2026-' . $version . '.zip';

if (!glob($src . '/media/fonts/gosmicksansbold-webfont.*')) {
    fwrite(STDERR, "Warning: the Gosmick Sans webfont is missing in src/media/fonts/ (see README); headings fall back to another font.\n");
}

if (!is_dir($dist)) {
    mkdir($dist, 0755, true);
}

$zip = new ZipArchive();

if ($zip->open($zipFile, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
    fwrite(STDERR, "Cannot create $zipFile\n");
    exit(1);
}

$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($src, FilesystemIterator::SKIP_DOTS));

foreach ($files as $file) {
    $relative = str_replace(DIRECTORY_SEPARATOR, '/', substr($file->getPathname(), strlen($src) + 1));
    $zip->addFile($file->getPathname(), $relative);
}

$zip->close();

echo "Built $zipFile\n";
