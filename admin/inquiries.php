<?php
require_once __DIR__ . '/includes/admin_header.php';

$msg = '';
$filter_status = $_GET['status'] ?? '';
$search = trim($_GET['search'] ?? '');

// Handle actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_status'])) {
        $inq_id = intval($_POST['inq_id']);
        $new_status = $_POST['new_status'];
        db_query("UPDATE inquiries SET status = ? WHERE id = ?", [$new_status, $inq_id]);
        $msg = "Status updated.";
    }
    
    if (isset($_POST['delete'])) {
        db_query("DELETE FROM inquiries WHERE id = ?", [intval($_POST['delete'])]);
        $msg = "Lead deleted.";
    }
    
    // Export CSV
    if (isset($_POST['export'])) {
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="leads_export_' . date('Y-m-d') . '.csv"');
        
        $where = '';
        $params = [];
        if ($filter_status) {
            $where = "WHERE status = ?";
            $params[] = $filter_status;
        }
        if ($search) {
            $where .= $where ? " AND " : "WHERE ";
            $where .= "(name LIKE ? OR phone LIKE ? OR email LIKE ?)";
            $params = array_merge($params, ["%$search%", "%$search%", "%$search%"]);
        }
        
        $leads = db_get_all("SELECT i.*, c.title as course_title FROM inquiries i LEFT JOIN courses c ON i.course_id = c.id $where ORDER BY i.created_at DESC", $params);
        
        $output = fopen('php://output', 'w');
        fputcsv($output, ['ID', 'Name', 'Phone', 'Email', 'Course', 'Message', 'Status', 'Date']);
        
        foreach ($leads as $lead) {
            fputcsv($output, [
                $lead['id'], $lead['name'], $lead['phone'], $lead['email'],
                $lead['course_title'] ?: 'General', $lead['message'], $lead['status'], $lead['created_at']
            ]);
        }
        fclose($output);
        exit;
    }
}

// Build query
$where = '';
$params = [];
if ($filter_status) {
    $where = "WHERE i.status = ?";
    $params[] = $filter_status;
}
if ($search) {
    $where .= $where ? " AND " : "WHERE ";
    $where .= "(i.name LIKE ? OR i.phone LIKE ? OR i.email LIKE ?)";
    $params = array_merge($params, ["%$search%", "%$search%", "%$search%"]);
}

$inquiries = db_get_all("SELECT i.*, c.title as course_title FROM inquiries i LEFT JOIN courses c ON i.course_id = c.id $where ORDER BY i.created_at DESC", $params);
?>
<div>
    <div class="flex justify-between items-center mb-5">
        <div>
            <h2 class="text-2xl font-bold">Inquiries &amp; Leads Manager</h2>
            <p class="text-sm text-slate-500">Total: <?= count($inquiries) ?> leads</p>
        </div>
        
        <form method="POST" class="inline">
            <button type="submit" name="export" class="bg-emerald-600 text-white px-5 py-2 rounded-xl text-sm font-semibold">Export to CSV</button>
        </form>
    </div>
    
    <?php if ($msg): ?>
        <div class="bg-emerald-100 px-4 py-2 rounded mb-4 text-sm"><?= $msg ?></div>
    <?php endif; ?>
    
    <!-- Filters -->
    <form method="GET" class="mb-5 flex flex-wrap gap-3 items-end bg-white p-4 rounded-2xl border">
        <div>
            <label class="text-xs block">Status</label>
            <select name="status" class="border px-3 py-2 rounded-lg text-sm">
                <option value="">All</option>
                <option value="Pending" <?= $filter_status=='Pending' ? 'selected' : '' ?>>Pending</option>
                <option value="Contacted" <?= $filter_status=='Contacted' ? 'selected' : '' ?>>Contacted</option>
                <option value="Enrolled" <?= $filter_status=='Enrolled' ? 'selected' : '' ?>>Enrolled</option>
                <option value="Closed" <?= $filter_status=='Closed' ? 'selected' : '' ?>>Closed</option>
            </select>
        </div>
        <div class="flex-1 min-w-[200px]">
            <label class="text-xs block">Search name/phone/email</label>
            <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" class="border px-3 py-2 w-full rounded-lg text-sm" placeholder="Search leads...">
        </div>
        <button type="submit" class="btn-primary px-6 py-[9px] text-sm">Filter</button>
        <a href="inquiries.php" class="px-5 py-[9px] text-sm bg-slate-100 rounded-lg">Reset</a>
    </form>
    
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden border">
        <table class="admin-table w-full text-sm">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Contact</th>
                    <th>Interested In</th>
                    <th>Message</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th class="text-right w-44">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($inquiries) === 0): ?>
                    <tr><td colspan="7" class="text-center py-7 text-slate-400">No leads found.</td></tr>
                <?php endif; ?>
                
                <?php foreach ($inquiries as $inq): ?>
                <tr>
                    <td class="font-semibold"><?= htmlspecialchars($inq['name']) ?></td>
                    <td>
                        <div><?= htmlspecialchars($inq['phone']) ?></div>
                        <?php if ($inq['email']): ?>
                            <div class="text-xs text-slate-500"><?= htmlspecialchars($inq['email']) ?></div>
                        <?php endif; ?>
                    </td>
                    <td class="text-xs"><?= htmlspecialchars($inq['course_title'] ?? 'General Inquiry') ?></td>
                    <td class="text-xs max-w-[220px]">
                        <div class="line-clamp-2"><?= htmlspecialchars(substr($inq['message'], 0, 120)) ?>...</div>
                    </td>
                    <td>
                        <form method="POST" class="flex gap-1 items-center">
                            <input type="hidden" name="inq_id" value="<?= $inq['id'] ?>">
                            <select name="new_status" class="text-xs border px-2 py-1 rounded">
                                <option value="Pending" <?= $inq['status']=='Pending' ? 'selected' : '' ?>>Pending</option>
                                <option value="Contacted" <?= $inq['status']=='Contacted' ? 'selected' : '' ?>>Contacted</option>
                                <option value="Enrolled" <?= $inq['status']=='Enrolled' ? 'selected' : '' ?>>Enrolled</option>
                                <option value="Closed" <?= $inq['status']=='Closed' ? 'selected' : '' ?>>Closed</option>
                            </select>
                            <button type="submit" name="update_status" class="px-3 py-1 text-xs bg-blue-600 text-white rounded">Update</button>
                        </form>
                    </td>
                    <td class="text-xs text-slate-500"><?= date('d M Y', strtotime($inq['created_at'])) ?></td>
                    <td class="text-right">
                        <a href="tel:<?= $inq['phone'] ?>" class="text-xs px-2.5 py-1 bg-emerald-100 text-emerald-700 rounded">Call</a>
                        <form method="POST" class="inline ml-1" onsubmit="event.preventDefault(); confirmDelete(this.id, 'Delete this lead?')">
                            <input type="hidden" name="delete" value="<?= $inq['id'] ?>">
                            <button type="submit" class="px-2.5 py-1 text-xs bg-red-100 text-red-700 rounded">×</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>