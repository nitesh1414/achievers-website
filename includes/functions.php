<?php
// Common Helper Functions

function slugify($text) {
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    $text = preg_replace('~[^-\w]+~', '', $text);
    $text = trim($text, '-');
    $text = preg_replace('~-+~', '-', $text);
    return strtolower($text) ?: 'n-a';
}

function sanitize($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

function upload_image($file, $folder = 'uploads', $max_size = 5242880) {
    if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
        return ['success' => false, 'error' => 'No file uploaded or upload error.'];
    }
    
    $allowed = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
    if (!in_array($file['type'], $allowed)) {
        return ['success' => false, 'error' => 'Invalid file type. Only JPG, PNG, WEBP allowed.'];
    }
    
    if ($file['size'] > $max_size) {
        return ['success' => false, 'error' => 'File too large. Max 5MB.'];
    }
    
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $filename = uniqid('img_') . '.' . $ext;
    $targetDir = __DIR__ . '/../public/' . $folder . '/';
    
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true);
    }
    
    $targetPath = $targetDir . $filename;
    
    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
        // Automatically create a thumbnail
        $thumbResult = create_thumbnail($targetPath, $targetDir, $filename);
        
        return [
            'success' => true, 
            'filename' => $folder . '/' . $filename,
            'thumbnail' => $thumbResult['success'] ? $folder . '/' . $thumbResult['filename'] : null
        ];
    }
    
    return ['success' => false, 'error' => 'Failed to save file.'];
}

/**
 * Create thumbnail using PHP GD (improved image handling)
 */
function create_thumbnail($sourcePath, $targetDir, $originalFilename, $maxWidth = 400, $maxHeight = 300) {
    $info = getimagesize($sourcePath);
    if (!$info) return ['success' => false];
    
    $width = $info[0];
    $height = $info[1];
    $type = $info[2];
    
    // Calculate new dimensions
    $ratio = min($maxWidth / $width, $maxHeight / $height);
    $newWidth = round($width * $ratio);
    $newHeight = round($height * $ratio);
    
    $thumbFilename = 'thumb_' . $originalFilename;
    $thumbPath = $targetDir . $thumbFilename;
    
    // Create image from source
    switch ($type) {
        case IMAGETYPE_JPEG: $src = imagecreatefromjpeg($sourcePath); break;
        case IMAGETYPE_PNG:  $src = imagecreatefrompng($sourcePath); break;
        case IMAGETYPE_WEBP: $src = imagecreatefromwebp($sourcePath); break;
        case IMAGETYPE_GIF:  $src = imagecreatefromgif($sourcePath); break;
        default: return ['success' => false];
    }
    
    $thumb = imagecreatetruecolor($newWidth, $newHeight);
    
    // Preserve transparency
    if ($type == IMAGETYPE_PNG || $type == IMAGETYPE_GIF) {
        imagecolortransparent($thumb, imagecolorallocate($thumb, 0, 0, 0));
        imagealphablending($thumb, false);
        imagesavealpha($thumb, true);
    }
    
    imagecopyresampled($thumb, $src, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
    
    $saved = false;
    switch ($type) {
        case IMAGETYPE_JPEG: $saved = imagejpeg($thumb, $thumbPath, 85); break;
        case IMAGETYPE_PNG:  $saved = imagepng($thumb, $thumbPath); break;
        case IMAGETYPE_WEBP: $saved = imagewebp($thumb, $thumbPath, 80); break;
        case IMAGETYPE_GIF:  $saved = imagegif($thumb, $thumbPath); break;
    }
    
    imagedestroy($src);
    imagedestroy($thumb);
    
    return ['success' => $saved, 'filename' => $thumbFilename];
}

/**
 * Safe image display with fallback (improved handling)
 */
function safe_image($path, $alt = '', $class = '', $fallback = 'assets/images/hero-main.jpg') {
    $fullPath = __DIR__ . '/../public/' . ltrim($path, '/');
    $displayPath = '/' . ltrim($path, '/');
    
    if (!file_exists($fullPath) || !is_file($fullPath)) {
        $displayPath = '/' . $fallback;
    }
    
    return '<img src="' . htmlspecialchars($displayPath) . '" alt="' . htmlspecialchars($alt) . '" class="' . htmlspecialchars($class) . '" loading="lazy">';
}

function get_status_badge($status) {
    $colors = [
        'active' => 'bg-green-100 text-green-800',
        'inactive' => 'bg-gray-100 text-gray-800',
        'Pending' => 'bg-yellow-100 text-yellow-800',
        'Contacted' => 'bg-blue-100 text-blue-800',
        'Enrolled' => 'bg-green-100 text-green-800',
        'Closed' => 'bg-gray-200 text-gray-700',
        'published' => 'bg-green-100 text-green-800',
        'unpublished' => 'bg-red-100 text-red-800',
    ];
    $class = $colors[$status] ?? 'bg-gray-100 text-gray-800';
    return "<span class='px-3 py-1 rounded-full text-xs font-semibold $class'>$status</span>";
}

function format_currency($amount) {
    return '₹' . number_format($amount, 0);
}
?>