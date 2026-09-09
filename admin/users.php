<?php
require_once __DIR__ . '/includes/admin_header.php';

$msg = '';
$error = '';
$current_admin_id = $_SESSION['admin_id'] ?? 0;

// Handle POST actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['save'])) {
        $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
        $username = trim($_POST['username'] ?? '');
        $full_name = trim($_POST['full_name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if (empty($username)) {
            $error = "Username is required.";
        } else {
            // Check duplicate username (exclude self on edit)
            $check_sql = "SELECT id FROM admins WHERE username = ? AND id != ?";
            $exists = db_get_row($check_sql, [$username, $id]);
            if ($exists) {
                $error = "Username already exists.";
            } else {
                if ($id > 0) {
                    // Update
                    if (!empty($password)) {
                        $hashed = password_hash($password, PASSWORD_DEFAULT);
                        db_query(
                            "UPDATE admins SET username=?, full_name=?, email=?, password=? WHERE id=?",
                            [$username, $full_name, $email, $hashed, $id]
                        );
                    } else {
                        db_query(
                            "UPDATE admins SET username=?, full_name=?, email=? WHERE id=?",
                            [$username, $full_name, $email, $id]
                        );
                    }
                    $msg = "Admin user updated successfully.";
                } else {
                    // Create new
                    if (empty($password)) {
                        $error = "Password is required for new users.";
                    } else {
                        $hashed = password_hash($password, PASSWORD_DEFAULT);
                        db_query(
                            "INSERT INTO admins (username, password, email, full_name) VALUES (?,?,?,?)",
                            [$username, $hashed, $email, $full_name]
                        );
                        $msg = "New admin user created successfully.";
                    }
                }
            }
        }
    } elseif (isset($_POST['delete'])) {
        $del_id = intval($_POST['delete']);
        if ($del_id == $current_admin_id) {
            $error = "You cannot delete your own account.";
        } else {
            // Prevent deleting the last admin
            $count = db_get_row("SELECT COUNT(*) as c FROM admins")['c'] ?? 1;
            if ($count <= 1) {
                $error = "Cannot delete the last admin account.";
            } else {
                db_query("DELETE FROM admins WHERE id=?", [$del_id]);
                $msg = "Admin user deleted.";
            }
        }
    } elseif (isset($_POST['change_password'])) {
        // Dedicated self password change
        $old_pass = trim($_POST['old_password'] ?? '');
        $new_pass = trim($_POST['new_password'] ?? '');
        $confirm_pass = trim($_POST['confirm_password'] ?? '');

        if (empty($old_pass) || empty($new_pass)) {
            $error = "All password fields are required.";
        } elseif ($new_pass !== $confirm_pass) {
            $error = "New passwords do not match.";
        } elseif (strlen($new_pass) < 6) {
            $error = "New password must be at least 6 characters.";
        } else {
            // Verify old password
            $admin = db_get_row("SELECT * FROM admins WHERE id = ?", [$current_admin_id]);
            if ($admin && password_verify($old_pass, $admin['password'])) {
                $hashed = password_hash($new_pass, PASSWORD_DEFAULT);
                db_query("UPDATE admins SET password = ? WHERE id = ?", [$hashed, $current_admin_id]);
                $msg = "Your password has been changed successfully.";
            } else {
                $error = "Current password is incorrect.";
            }
        }
    }
}

// Fetch all admins
$admins = db_get_all("SELECT * FROM admins ORDER BY created_at DESC");

// Current user data
$current_user = db_get_row("SELECT * FROM admins WHERE id = ?", [$current_admin_id]);

// Edit mode
$edit = null;
if (isset($_GET['edit'])) {
    $edit_id = intval($_GET['edit']);
    $edit = db_get_row("SELECT * FROM admins WHERE id = ?", [$edit_id]);
}
?>

<div class="max-w-5xl">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold">Admin Users</h1>
            <p class="text-sm text-slate-500 mt-1">Manage administrator accounts and passwords</p>
        </div>
        <a href="?action=add" class="btn-primary px-5 py-2.5 text-sm flex items-center gap-2">
            + Add New Admin
        </a>
    </div>

    <?php if ($msg): ?>
        <div class="mb-4 px-4 py-3 bg-emerald-100 text-emerald-700 rounded-2xl text-sm"><?= htmlspecialchars($msg) ?></div>
    <?php endif; ?>
    <?php if ($error): ?>
        <div class="mb-4 px-4 py-3 bg-red-100 text-red-700 rounded-2xl text-sm"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <!-- Change My Password -->
    <div class="bg-white border border-slate-200 rounded-2xl p-6 mb-8 shadow-sm">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-8 h-8 bg-amber-100 text-amber-600 rounded-xl flex items-center justify-center">🔑</div>
            <div>
                <div class="font-semibold text-lg">Change My Password</div>
                <div class="text-xs text-slate-500">Update password for <?= htmlspecialchars($current_user['username'] ?? 'current user') ?></div>
            </div>
        </div>

        <form method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <input type="hidden" name="change_password" value="1">

            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Current Password</label>
                <input type="password" name="old_password" class="w-full border border-slate-300 px-3 py-2.5 rounded-xl text-sm" required placeholder="••••••••">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">New Password</label>
                <input type="password" name="new_password" class="w-full border border-slate-300 px-3 py-2.5 rounded-xl text-sm" required placeholder="Min 6 characters">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Confirm New Password</label>
                <input type="password" name="confirm_password" class="w-full border border-slate-300 px-3 py-2.5 rounded-xl text-sm" required>
            </div>

            <div class="md:col-span-3">
                <button type="submit" class="btn-primary px-6 py-2 text-sm">Update My Password</button>
                <span class="text-xs text-slate-500 ml-3">Password must be at least 6 characters</span>
            </div>
        </form>
    </div>

    <!-- Add / Edit Form -->
    <?php if (isset($_GET['action']) || $edit): ?>
        <div class="bg-white border border-slate-200 p-6 rounded-2xl mb-8 max-w-2xl">
            <h3 class="font-semibold mb-4"><?= $edit ? 'Edit Admin User' : 'Create New Admin User' ?></h3>

            <form method="POST" class="space-y-4">
                <input type="hidden" name="save" value="1">
                <?php if ($edit): ?>
                    <input type="hidden" name="id" value="<?= $edit['id'] ?>">
                <?php endif; ?>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Username *</label>
                        <input type="text" name="username" value="<?= htmlspecialchars($edit['username'] ?? '') ?>" required
                            class="w-full border border-slate-300 px-4 py-2.5 rounded-xl text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Full Name</label>
                        <input type="text" name="full_name" value="<?= htmlspecialchars($edit['full_name'] ?? '') ?>"
                            class="w-full border border-slate-300 px-4 py-2.5 rounded-xl text-sm">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Email Address</label>
                    <input type="email" name="email" value="<?= htmlspecialchars($edit['email'] ?? '') ?>"
                        class="w-full border border-slate-300 px-4 py-2.5 rounded-xl text-sm">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">
                        <?= $edit ? 'New Password (leave blank to keep current)' : 'Password *' ?>
                    </label>
                    <input type="password" name="password" class="w-full border border-slate-300 px-4 py-2.5 rounded-xl text-sm"
                        <?= $edit ? '' : 'required' ?> placeholder="<?= $edit ? 'Leave blank to keep existing password' : 'Enter password (min 6 chars)' ?>">
                    <?php if ($edit): ?>
                        <p class="text-[10px] text-amber-600 mt-1">Only fill if you want to reset this user's password.</p>
                    <?php endif; ?>
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="submit" class="btn-primary px-6 py-2 text-sm">Save Admin User</button>
                    <a href="users" class="px-5 py-2 text-sm border border-slate-300 hover:bg-slate-50 rounded-xl">Cancel</a>
                </div>
            </form>
        </div>
    <?php endif; ?>

    <!-- Admin Users List -->
    <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden">
        <div class="px-5 py-3 border-b bg-slate-50 flex items-center justify-between">
            <div class="font-semibold text-sm">All Admin Accounts (<?= count($admins) ?>)</div>
            <div class="text-xs text-slate-500">Only active admins can log in</div>
        </div>

        <table class="admin-table w-full text-sm">
            <thead>
                <tr>
                    <th class="w-12">ID</th>
                    <th>Username</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Created</th>
                    <th class="w-36 text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($admins as $admin): ?>
                    <tr class="<?= $admin['id'] == $current_admin_id ? 'bg-amber-50/60' : '' ?>">
                        <td class="font-mono text-xs text-slate-400"><?= $admin['id'] ?></td>
                        <td>
                            <div class="font-semibold flex items-center gap-2">
                                <?= htmlspecialchars($admin['username']) ?>
                                <?php if ($admin['id'] == $current_admin_id): ?>
                                    <span class="text-[10px] px-1.5 py-px bg-amber-400 text-amber-900 rounded font-bold">YOU</span>
                                <?php endif; ?>
                            </div>
                        </td>
                        <td><?= htmlspecialchars($admin['full_name'] ?: '—') ?></td>
                        <td class="text-slate-500 text-xs"><?= htmlspecialchars($admin['email'] ?: '—') ?></td>
                        <td class="text-xs text-slate-400"><?= date('d M Y', strtotime($admin['created_at'])) ?></td>
                        <td class="text-center">
                            <div class="flex items-center justify-center gap-1">
                                <a href="?edit=<?= $admin['id'] ?>"
                                    class="inline-flex items-center px-3 py-1 text-xs bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-lg transition">Edit</a>

                                <?php if ($admin['id'] != $current_admin_id): ?>
                                    <form method="POST" class="inline" onsubmit="return confirm('Delete this admin account permanently?');">
                                        <input type="hidden" name="delete" value="<?= $admin['id'] ?>">
                                        <button type="submit" class="inline-flex items-center px-3 py-1 text-xs bg-red-100 hover:bg-red-200 text-red-700 rounded-lg transition">Delete</button>
                                    </form>
                                <?php else: ?>
                                    <span class="text-[10px] text-slate-400 px-2">—</span>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="mt-5 text-xs text-slate-500 px-1">
        • New admins will be able to log in immediately using the username + password you set.<br>
        • For security, always change default passwords after creation.<br>
        • You cannot delete your own account or the last remaining admin.
    </div>
</div>

<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>