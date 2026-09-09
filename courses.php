<?php
require_once __DIR__ . '/includes/header.php';

$categories = db_get_all("SELECT * FROM course_categories WHERE status='active' ORDER BY name ASC");

$search = trim($_GET['search'] ?? '');
$where = "WHERE c.status='active'";
$params = [];

if ($search) {
    $where .= " AND (c.title LIKE ? OR c.description LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
}

$all_courses = db_get_all("SELECT c.*, cat.name as cat_name FROM courses c LEFT JOIN course_categories cat ON c.category_id = cat.id $where ORDER BY c.id DESC", $params);
?>
<div class="tail-container w-full max-w-[1400px] mx-auto px-6 md:px-10 w-full max-w-[1400px] mx-auto px-6 md:px-10 w-full max-w-[1400px] mx-auto px-6 md:px-8 w-full px-6 md:px-8 max-w-[1400px] mx-auto w-full max-w-full py-10">
    <div class="flex flex-col md:flex-row md:items-end gap-4 mb-9">
        <div>
            <span class="text-xs font-bold tracking-[1.5px] text-amber-600">PROGRAMS</span>
            <h1 class="text-4xl font-bold">Our Training Programs</h1>
            <p class="mt-1 max-w-xl">From beginner foundations to elite competition prep. Choose the perfect path for your child.</p>
        </div>
        <div class="md:ml-auto">
            <a href="admissions" class="btn-accent px-7 py-2.5">Start Free Trial</a>
        </div>
    </div>
    
    <!-- Categories -->
    <div class="flex flex-wrap gap-2 mb-8">
        <?php foreach ($categories as $cat): ?>
            <a href="#<?= htmlspecialchars($cat['slug']) ?>" class="px-4 py-1.5 text-sm bg-white border rounded-full hover:bg-amber-50"><?= htmlspecialchars($cat['name']) ?></a>
        <?php endforeach; ?>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach ($all_courses as $course): ?>
        <div id="<?= htmlspecialchars($course['slug']) ?>" class="course-card bg-white border rounded-3xl overflow-hidden flex flex-col">
            <div class="h-48 bg-slate-100 relative">
                <img src="<?= htmlspecialchars($course['thumbnail'] ?: 'assets/images/course-little.jpg') ?>" class="object-cover w-full h-full" alt="<?= htmlspecialchars($course['title']) ?>">
                <?php if ($course['fees'] == 0): ?>
                    <div class="absolute top-4 left-4 px-3.5 py-1 bg-emerald-600 text-white text-xs font-bold tracking-wider rounded">FREE</div>
                <?php endif; ?>
            </div>
            <div class="p-6 flex-1 flex flex-col">
                <div>
                    <span class="uppercase text-xs tracking-widest text-amber-700 font-semibold"><?= htmlspecialchars($course['cat_name'] ?: 'Program') ?></span>
                    <h3 class="font-bold text-2xl mt-1 leading-tight"><?= htmlspecialchars($course['title']) ?></h3>
                </div>
                
                <p class="mt-4 text-sm text-slate-600 flex-1"><?= htmlspecialchars($course['description']) ?></p>
                
                <div class="mt-4 pt-4 border-t text-sm flex items-center justify-between">
                    <div>
                        <span class="font-semibold text-xl"><?= format_currency($course['fees']) ?></span><br>
                        <span class="text-xs text-slate-500"><?= htmlspecialchars($course['duration']) ?></span>
                    </div>
                    
                    <a href="admissions?course=<?= $course['id'] ?>" class="btn-primary text-sm px-5 py-2">Enquire Now</a>
                </div>
                
                <?php if (!empty($course['syllabus'])): ?>
                <div class="mt-4 text-xs">
                    <details class="text-slate-500">
                        <summary class="cursor-pointer text-amber-700 font-semibold">View Syllabus</summary>
                        <div class="mt-2 text-xs whitespace-pre-line"><?= nl2br(htmlspecialchars($course['syllabus'])) ?></div>
                    </details>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>