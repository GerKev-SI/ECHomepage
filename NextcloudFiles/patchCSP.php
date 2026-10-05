<?php
$file = '/home/lkghorme/domains/serverlkg-hormersdorf.de/lib/public/AppFramework/Http/ContentSecurityPolicy.php';

if (!file_exists($file)) {
    exit("File not found.\n");
}

$content = file_get_contents($file);

// Check if our domain is already patched into allowedFrameAncestors
if (!str_contains($content, 'https://lkg-hormersdorf.de')) {
    
    // 1. Target ONLY the $allowedFrameAncestors array
    $frameAncestorsPattern = '/(protected\s+\$allowedFrameAncestors\s*=\s*\[\s*\'\\\\\'self\\\\\'\',)/';
    $frameAncestorsInsert  = "$1\n\t\t'https://*.ec-hormersdorf.de',\n\t\t'https://*.lkg-hormersdorf.de',";
    $content = preg_replace($frameAncestorsPattern, $frameAncestorsInsert, $content);

    // 2. Target ONLY the $allowedMediaDomains array (optional)
    $mediaDomainsPattern   = '/(protected\s+\$allowedMediaDomains\s*=\s*\[\s*\'\\\\\'self\\\\\'\',)/';
    $mediaDomainsInsert    = "$1\n\t\t'https://*.ec-hormersdorf.de',\n\t\t'https://*.lkg-hormersdorf.de',";
    $content = preg_replace($mediaDomainsPattern, $mediaDomainsInsert, $content);

    file_put_contents($file, $content);
    echo "Targeted CSP patch successfully applied.\n";
}
