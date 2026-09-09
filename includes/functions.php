<?php
// Common Helper Functions

function slugify($text)
{
    $text = preg_replace("~[^\pL\d]+~u", "-", $text);
    $text = iconv("utf-8", "us-ascii//TRANSLIT", $text);
    $text = preg_replace("~[^-\w]+~", "", $text);
    $text = trim($text, "-");
    $text = preg_replace("~-+~", "-", $text);
    return strtolower($text) ?: "n-a";
}

function sanitize($data)
{
    return htmlspecialchars(trim((string) $data), ENT_QUOTES, "UTF-8");
}

/** Escape output once. New content is deliberately stored as plain text. */
function e($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, "UTF-8");
}

/**
 * Get the CMS content registry. It contains each editable page field and its
 * template-safe text limit, used by the Content Manager and public templates.
 */
function content_registry()
{
    static $registry = null;
    if ($registry === null) {
        $registry = require __DIR__ . "/content_registry.php";
    }
    return $registry;
}

function content_field($key)
{
    foreach (content_registry() as $section) {
        foreach ($section["fields"] as $field) {
            if ($field["key"] === $key) {
                return $field;
            }
        }
    }
    return null;
}

/**
 * Returns saved page content, with the registry's polished template copy as a
 * fallback. This lets a deployed site work before an administrator saves the
 * Content Manager for the first time.
 */
function content_value($key, $fallback = "")
{
    $field = content_field($key);
    $default = $field["default"] ?? $fallback;
    return get_setting($key, $default);
}

function content_limit($value, $max)
{
    $value = trim((string) $value);
    if ($max && function_exists("mb_substr")) {
        return mb_substr($value, 0, $max, "UTF-8");
    }
    return $max ? substr($value, 0, $max) : $value;
}

/** Keep only digits for WhatsApp's wa.me address. */
function whatsapp_number($number)
{
    return preg_replace("/\D+/", "", (string) $number);
}

/**
 * Central image upload helper. It accepts legacy '../uploads' values but
 * always stores public paths relative to the project root (uploads/file.jpg).
 */
function upload_image($file, $folder = "uploads", $max_size = 5242880)
{
    if (
        !isset($file) ||
        ($file["error"] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK
    ) {
        return [
            "success" => false,
            "error" => "No file uploaded or upload error.",
        ];
    }

    if (($file["size"] ?? 0) > $max_size) {
        return [
            "success" => false,
            "error" => "File too large. Maximum size is 5 MB.",
        ];
    }

    $imageInfo = @getimagesize($file["tmp_name"]);
    $allowed = [
        IMAGETYPE_JPEG => "jpg",
        IMAGETYPE_PNG => "png",
        IMAGETYPE_WEBP => "webp",
        IMAGETYPE_GIF => "gif",
    ];
    if (!$imageInfo || !isset($allowed[$imageInfo[2]])) {
        return [
            "success" => false,
            "error" => "Invalid image. Please upload JPG, PNG, WEBP or GIF.",
        ];
    }

    $ext = $allowed[$imageInfo[2]];
    $filename = str_replace('.', '_', uniqid('img_', true)) . '.' . $ext;

    $safeFolder = trim(
        str_replace("..", "", str_replace("\\", "/", $folder)),
        "/"
    );
    $safeFolder = $safeFolder ?: "uploads";
    $targetDir = dirname(__DIR__) . "/" . $safeFolder . "/";

    if (
        !is_dir($targetDir) &&
        !mkdir($targetDir, 0755, true) &&
        !is_dir($targetDir)
    ) {
        return [
            "success" => false,
            "error" => "Could not create the upload directory.",
        ];
    }

    $targetPath = $targetDir . $filename;
    if (move_uploaded_file($file["tmp_name"], $targetPath)) {
        $thumbResult = create_thumbnail($targetPath, $targetDir, $filename);
        return [
            "success" => true,
            "filename" => $safeFolder . "/" . $filename,
            "thumbnail" => $thumbResult["success"]
                ? $safeFolder . "/" . $thumbResult["filename"]
                : null,
        ];
    }

    return ["success" => false, "error" => "Failed to save image file."];
}

/** Create an image thumbnail with PHP GD when it is available. */
function create_thumbnail(
    $sourcePath,
    $targetDir,
    $originalFilename,
    $maxWidth = 400,
    $maxHeight = 300
) {
    if (!function_exists("imagecreatefromjpeg")) {
        return ["success" => false];
    }

    $info = @getimagesize($sourcePath);
    if (!$info) {
        return ["success" => false];
    }

    $width = $info[0];
    $height = $info[1];
    $type = $info[2];
    $ratio = min($maxWidth / $width, $maxHeight / $height, 1);
    $newWidth = max(1, (int) round($width * $ratio));
    $newHeight = max(1, (int) round($height * $ratio));
    $thumbFilename = "thumb_" . $originalFilename;
    $thumbPath = $targetDir . $thumbFilename;

    switch ($type) {
        case IMAGETYPE_JPEG:
            $src = imagecreatefromjpeg($sourcePath);
            break;
        case IMAGETYPE_PNG:
            $src = imagecreatefrompng($sourcePath);
            break;
        case IMAGETYPE_WEBP:
            $src = function_exists("imagecreatefromwebp")
                ? imagecreatefromwebp($sourcePath)
                : false;
            break;
        case IMAGETYPE_GIF:
            $src = imagecreatefromgif($sourcePath);
            break;
        default:
            return ["success" => false];
    }
    if (!$src) {
        return ["success" => false];
    }

    $thumb = imagecreatetruecolor($newWidth, $newHeight);
    if ($type === IMAGETYPE_PNG || $type === IMAGETYPE_GIF) {
        imagealphablending($thumb, false);
        imagesavealpha($thumb, true);
        $transparent = imagecolorallocatealpha($thumb, 0, 0, 0, 127);
        imagefilledrectangle($thumb, 0, 0, $newWidth, $newHeight, $transparent);
    }
    imagecopyresampled(
        $thumb,
        $src,
        0,
        0,
        0,
        0,
        $newWidth,
        $newHeight,
        $width,
        $height
    );

    $saved = false;
    switch ($type) {
        case IMAGETYPE_JPEG:
            $saved = imagejpeg($thumb, $thumbPath, 85);
            break;
        case IMAGETYPE_PNG:
            $saved = imagepng($thumb, $thumbPath);
            break;
        case IMAGETYPE_WEBP:
            $saved =
                function_exists("imagewebp") &&
                imagewebp($thumb, $thumbPath, 80);
            break;
        case IMAGETYPE_GIF:
            $saved = imagegif($thumb, $thumbPath);
            break;
    }
    imagedestroy($src);
    imagedestroy($thumb);
    return ["success" => $saved, "filename" => $thumbFilename];
}

/** Safe image display with a graceful fallback. */
function safe_image(
    $path,
    $alt = "",
    $class = "",
    $fallback = "assets/images/hero-main.jpg"
) {
    $projectRoot = dirname(__DIR__);
    $path = ltrim((string) $path, "/");
    $displayPath =
        file_exists($projectRoot . "/" . $path) &&
        is_file($projectRoot . "/" . $path)
            ? $path
            : $fallback;
    return '<img src="' .
        e($displayPath) .
        '" alt="' .
        e($alt) .
        '" class="' .
        e($class) .
        '" loading="lazy">';
}

/** Active social links are managed from Admin → Social Media. */
function get_social_links()
{
    static $links = null;
    if ($links !== null) {
        return $links;
    }

    try {
        $links = db_get_all(
            "SELECT * FROM social_links WHERE is_active = 1 ORDER BY sort_order ASC, id ASC"
        );
    } catch (Throwable $e) {
        $links = [];
    }

    // Backward-compatible fallback for installations which have not yet seeded
    // the social_links table.
    if (!$links) {
        foreach (
            ["facebook", "instagram", "linkedin", "youtube"]
            as $platform
        ) {
            $url = get_setting($platform, "");
            if ($url) {
                $links[] = [
                    "platform" => ucfirst($platform),
                    "url" => $url,
                    "icon" => $platform,
                ];
            }
        }
        $whatsapp = whatsapp_number(get_setting("whatsapp", ""));
        if ($whatsapp) {
            $links[] = [
                "platform" => "WhatsApp",
                "url" => "https://wa.me/" . $whatsapp,
                "icon" => "whatsapp",
            ];
        }
    }
    return $links;
}

/** Font Awesome brand icon whitelist used for public social links. */
function social_icon_class($icon, $platform = "")
{
    $key = strtolower(trim($icon ?: $platform));
    $map = [
        "facebook" => "fa-facebook-f",
        "fb" => "fa-facebook-f",
        "instagram" => "fa-instagram",
        "ig" => "fa-instagram",
        "linkedin" => "fa-linkedin-in",
        "in" => "fa-linkedin-in",
        "whatsapp" => "fa-whatsapp",
        "wa" => "fa-whatsapp",
        "youtube" => "fa-youtube",
        "yt" => "fa-youtube",
        "x" => "fa-x-twitter",
        "twitter" => "fa-x-twitter",
        "telegram" => "fa-telegram",
        "pinterest" => "fa-pinterest-p",
    ];
    return $map[$key] ?? "fa-globe";
}

function social_icon_family($icon, $platform = "")
{
    return social_icon_class($icon, $platform) === "fa-globe"
        ? "fa-solid"
        : "fa-brands";
}

function get_status_badge($status)
{
    $colors = [
        "active" => "bg-green-100 text-green-800",
        "inactive" => "bg-gray-100 text-gray-800",
        "Pending" => "bg-yellow-100 text-yellow-800",
        "Contacted" => "bg-blue-100 text-blue-800",
        "Enrolled" => "bg-green-100 text-green-800",
        "Closed" => "bg-gray-200 text-gray-700",
        "published" => "bg-green-100 text-green-800",
        "unpublished" => "bg-red-100 text-red-800",
    ];
    $class = $colors[$status] ?? "bg-gray-100 text-gray-800";
    return "<span class='px-3 py-1 rounded-full text-xs font-semibold $class'>" .
        e($status) .
        "</span>";
}
?>
