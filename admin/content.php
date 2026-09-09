<?php
require_once __DIR__ . "/includes/admin_header.php";

$registry = content_registry();
$section_key = $_GET["section"] ?? "mission_vision";
if (!isset($registry[$section_key])) {
    $section_key = "mission_vision";
}
$section = $registry[$section_key];
$message = "";
$errors = [];

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["save_content"])) {
    $submitted_section = $_POST["section"] ?? $section_key;
    if (isset($registry[$submitted_section])) {
        $section_key = $submitted_section;
        $section = $registry[$section_key];
    }

    foreach ($section["fields"] as $field) {
        $key = $field["key"];
        $value = trim((string) ($_POST["content"][$key] ?? ""));

        if ($field["type"] === "image") {
            $value =
                $_POST["existing_images"][$key] ?? ($field["default"] ?? "");
            if (!empty($_FILES["content_images"]["name"][$key])) {
                $file = [
                    "name" => $_FILES["content_images"]["name"][$key],
                    "type" => $_FILES["content_images"]["type"][$key],
                    "tmp_name" => $_FILES["content_images"]["tmp_name"][$key],
                    "error" => $_FILES["content_images"]["error"][$key],
                    "size" => $_FILES["content_images"]["size"][$key],
                ];
                $upload = upload_image($file, "uploads");
                if ($upload["success"]) {
                    $value = $upload["filename"];
                } else {
                    $errors[] = $field["label"] . ": " . $upload["error"];
                    continue;
                }
            }
        } else {
            $value = content_limit($value, $field["max"] ?? 0);
            if (
                $field["type"] === "url" &&
                $value !== "" &&
                !filter_var($value, FILTER_VALIDATE_URL)
            ) {
                $errors[] = $field["label"] . " must be a valid full URL.";
                continue;
            }
        }

        db_query(
            "INSERT INTO settings (setting_key, setting_value) VALUES (?, ?) ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)",
            [$key, $value]
        );
    }
    $message = $errors
        ? "Some fields could not be saved. Please check the notes below."
        : "Content updated successfully.";
}
?>
<div class="max-w-5xl content-manager">
    <div class="mb-6">
        <h1 class="text-2xl font-bold">Page Content</h1>
        <p class="text-sm text-slate-500">Edit the copy and images used throughout the website. Field limits protect the layout on all screen sizes.</p>
    </div>

    <nav class="content-manager__nav" aria-label="Content sections">
        <?php foreach ($registry as $key => $item): ?><a href="?section=<?= e(
    $key
) ?>" class="<?= $key === $section_key ? "is-active" : "" ?>"><?= e(
    $item["label"]
) ?></a><?php endforeach; ?>
    </nav>

    <?php if ($message): ?><div class="mb-4 px-4 py-3 rounded-xl <?= $errors
    ? "bg-amber-100 text-amber-800"
    : "bg-emerald-100 text-emerald-700" ?> text-sm"><?= e(
     $message
 ) ?></div><?php endif; ?>
    <?php if (
        $errors
    ): ?><ul class="mb-4 rounded-xl bg-red-50 px-5 py-3 text-sm text-red-700 list-disc list-inside"><?php foreach (
    $errors
    as $error
): ?><li><?= e($error) ?></li><?php endforeach; ?></ul><?php endif; ?>

    <form method="POST" enctype="multipart/form-data" class="bg-white border rounded-2xl p-6 space-y-5">
        <input type="hidden" name="save_content" value="1">
        <input type="hidden" name="section" value="<?= e($section_key) ?>">
        <div class="border-b pb-4"><h2 class="font-bold text-xl"><?= e(
            $section["label"]
        ) ?></h2><p class="text-sm text-slate-500 mt-1"><?= e(
    $section["description"]
) ?></p></div>

        <?php foreach ($section["fields"] as $field): ?>
            <?php $value = content_value(
                $field["key"],
                $field["default"] ?? ""
            ); ?>
            <div class="content-manager__field">
                <label class="block text-sm font-semibold text-slate-700 mb-1" for="content-<?= e(
                    $field["key"]
                ) ?>"><?= e($field["label"]) ?></label>
                <?php if ($field["type"] === "textarea"): ?>
                    <textarea id="content-<?= e(
                        $field["key"]
                    ) ?>" name="content[<?= e(
    $field["key"]
) ?>]" rows="<?= (int) ($field["rows"] ?? 3) ?>" maxlength="<?= (int) ($field[
    "max"
] ?? 0) ?>" class="w-full border px-3 py-2 rounded-xl"><?= e(
    $value
) ?></textarea>
                <?php elseif ($field["type"] === "image"): ?>
                    <input type="hidden" name="existing_images[<?= e(
                        $field["key"]
                    ) ?>]" value="<?= e($value) ?>">
                    <input id="content-<?= e(
                        $field["key"]
                    ) ?>" type="file" name="content_images[<?= e(
    $field["key"]
) ?>]" accept="image/jpeg,image/png,image/webp,image/gif" class="w-full text-sm">
                    <?php if ($value): ?><img src="../<?= e(
    $value
) ?>" class="content-manager__preview" alt="Current <?= e(
    $field["label"]
) ?>"><?php endif; ?>
                <?php else: ?>
                    <input id="content-<?= e(
                        $field["key"]
                    ) ?>" type="<?= $field["type"] === "url"
    ? "url"
    : "text" ?>" name="content[<?= e($field["key"]) ?>]" value="<?= e(
    $value
) ?>" maxlength="<?= (int) ($field["max"] ??
    255) ?>" class="w-full border px-3 py-2 rounded-xl">
                <?php endif; ?>
                <?php if (
                    !empty($field["max"]) &&
                    $field["type"] !== "image"
                ): ?><p class="content-manager__hint">Maximum <?= (int) $field[
    "max"
] ?> characters. Longer copy is trimmed automatically when saved.</p><?php endif; ?>
                <?php if (
                    $field["type"] === "image"
                ): ?><p class="content-manager__hint">JPG, PNG, WEBP or GIF; maximum 5 MB. A landscape image is recommended.</p><?php endif; ?>
            </div>
        <?php endforeach; ?>

        <div class="pt-2 flex gap-3"><button type="submit" class="btn-primary px-7 py-2.5 text-sm">Save <?= e(
            $section["label"]
        ) ?></button><a href="?section=<?= e(
    $section_key
) ?>" class="px-5 py-2 text-sm border rounded-xl">Reset unsaved changes</a></div>
    </form>
</div>
<?php require_once __DIR__ . "/includes/admin_footer.php"; ?>
