<?php
// utility to create a ZIP archive of the project excluding storage and node_modules
$root = realpath(__DIR__);
$zipFile = $root.'/shadowmarket_build_'.date('Ymd_His').'.zip';
$zip = new ZipArchive();
if ($zip->open($zipFile, ZipArchive::CREATE) !== true) {
    echo "Cannot create ZIP file\n"; exit;
}
$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($root), RecursiveIteratorIterator::LEAVES_ONLY);
$exclude = ['.git','.gitignore','storage','node_modules','.env'];
foreach ($files as $name => $file) {
    if (!$file->isFile()) continue;
    $filePath = $file->getRealPath();
    $relative = substr($filePath, strlen($root)+1);
    $skip = false;
    foreach ($exclude as $e) { if (strpos($relative, $e) === 0) { $skip = true; break; } }
    if ($skip) continue;
    $zip->addFile($filePath, $relative);
}
$zip->close();
echo "Created ZIP: $zipFile\n";
