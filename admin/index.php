<?php
require_once __DIR__ . '/includes/admin_header.php';

// Quick analytics
$total_inquiries = db_get_row("SELECT COUNT(*) as total FROM inquiries")['total'] ?? 0;
$pending_leads = db_get_row("SELECT COUNT(*) as total FROM inquiries WHERE status='Pending'")['total'] ?? 0;
$active_courses = db_get_row("SELECT COUNT(*) as total FROM courses WHERE status='active'")['total'] ?? 0;
$total_gallery = db_get_row("SELECT COUNT(*) as total FROM gallery WHERE status='active'")['total'] ?? 0;
$recent_leads = db_get_all("SELECT i.*, c.title as course_title FROM inquiries i LEFT JOIN courses c ON i.course_id = c.id ORDER BY i.created_at DESC LIMIT 6");
?>
<div>
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold">Dashboard Overview</h1>
            <p class="text-sm text-slate-500">Welcome back! Here's a quick summary of your academy.</p>
        </div>
        <div>
            <a href="inquiries.php" class="btn-primary text-sm px-5 py-2">Manage Leads</a>
        </div>
    </div>
    
    <!-- Stats -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="stat-card p-5">
            <div class="text-xs text-slate-500">TOTAL INQUIRIES</div>
            <div class="text-4xl font-bold mt-1"><?= $total_inquiries ?></div>
            <div class="text-emerald-600 text-xs font-semibold mt-1"><?= $pending_leads ?> pending</div>
        </div>
        <div class="stat-card p-5">
            <div class="text-xs text-slate-500">ACTIVE COURSES</div>
            <div class="text-4xl font-bold mt-1"><?= $active_courses ?></div>
            <div class="text-xs mt-1 text-slate-500">Published programs</div>
        </div>
        <div class="stat-card p-5">
            <div class="text-xs text-slate-500">GALLERY ITEMS</div>
            <div class="text-4xl font-bold mt-1"><?= $total_gallery ?></div>
            <div class="text-xs mt-1 text-slate-500">Active images</div>
        </div>
        <div class="stat-card p-5">
            <div class="text-xs text-slate-500">LEADS THIS MONTH</div>
            <div class="text-4xl font-bold mt-1"><?= $total_inquiries ?></div>
            <div class="text-xs mt-1 text-emerald-600">Strong pipeline</div>
        </div>
    </div>
    
    <!-- Recent Leads -->
    <div class="bg-white rounded-2xl shadow-sm border p-6">
        <div class="flex justify-between items-center mb-4">
            <div class="font-semibold">Recent Leads</div>
            <a href="inquiries.php" class="text-xs font-semibold text-amber-600">View All →</a>
        </div>
        
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b text-left text-slate-500 text-xs">
                    <th class="py-2">Name</th>
                    <th>Phone</th>
                    <th>Course</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($recent_leads as $lead): ?>
                <tr class="border-b last:border-none">
                    <td class="py-3 font-medium"><?= htmlspecialchars($lead['name']) ?></td>
                    <td class="text-sm"><?= htmlspecialchars($lead['phone']) ?></td>
                    <td class="text-xs text-slate-500"><?= htmlspecialchars($lead['course_title'] ?: 'General') ?></td>
                    <td><?= get_status_badge($lead['status']) ?></td>
                    <td class="text-xs text-slate-500"><?= date('d M', strtotime($lead['created_at'])) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>