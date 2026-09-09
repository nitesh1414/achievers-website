<?php
require_once __DIR__ . '/includes/header.php';

$success = false;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitize($_POST['name'] ?? '');
    $phone = sanitize($_POST['phone'] ?? '');
    $email = sanitize($_POST['email'] ?? '');
    $course_id = intval($_POST['course_id'] ?? 0);
    $message = sanitize($_POST['message'] ?? '');
    
    if ($name && $phone) {
        db_query("INSERT INTO inquiries (name, phone, email, course_id, message, status) VALUES (?,?,?,?,?,'Pending')", 
            [$name, $phone, $email, $course_id ?: null, $message]);
        
        $success = true;
    } else {
        $error = "Please fill in name and phone number.";
    }
}

$courses = db_get_all("SELECT id, title FROM courses WHERE status='active' ORDER BY title");
?>
<div class="tail-container w-full max-w-[1400px] mx-auto px-6 md:px-10 w-full max-w-[1400px] mx-auto px-6 md:px-10 w-full max-w-[1400px] mx-auto px-6 md:px-8 w-full px-6 md:px-8 max-w-[1400px] mx-auto w-full max-w-full py-10 max-w-3xl">
    <div class="mb-7">
        <span class="px-3 py-1 text-xs font-semibold bg-amber-100 text-amber-800 rounded">ENROLLMENT</span>
        <h1 class="text-4xl font-bold mt-1">Start Your Journey</h1>
        <p class="mt-1">Book a FREE trial class or enquire about our programs today.</p>
    </div>
    
    <?php if ($success): ?>
        <div class="bg-emerald-100 p-6 rounded-2xl mb-8">
            <h3 class="font-bold text-emerald-700 text-lg">Thank you! Your inquiry has been received.</h3>
            <p class="mt-1 text-sm">Our team will contact you shortly. You can also reach us on WhatsApp.</p>
            <a href="https://wa.me/<?= get_setting('whatsapp') ?>" class="mt-4 inline-block btn-accent px-6 py-2 text-sm">Chat on WhatsApp</a>
        </div>
    <?php endif; ?>
    
    <div class="grid md:grid-cols-5 gap-8">
        <!-- Form -->
        <div class="md:col-span-3 bg-white border rounded-3xl p-6">
            <h3 class="font-bold mb-4">Enquiry / Admission Form</h3>
            
            <?php if ($error): ?>
                <div class="mb-4 bg-red-100 text-red-700 text-sm p-3 rounded"><?= $error ?></div>
            <?php endif; ?>
            
            <form method="POST" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-xs font-semibold block mb-1">Full Name *</label>
                        <input type="text" name="name" required class="w-full px-4 py-2.5 border border-slate-300 rounded-2xl">
                    </div>
                    <div>
                        <label class="text-xs font-semibold block mb-1">Phone Number *</label>
                        <input type="tel" name="phone" required class="w-full px-4 py-2.5 border border-slate-300 rounded-2xl">
                    </div>
                </div>
                
                <div>
                    <label class="text-xs font-semibold block mb-1">Email (optional)</label>
                    <input type="email" name="email" class="w-full px-4 py-2.5 border border-slate-300 rounded-2xl">
                </div>
                
                <div>
                    <label class="text-xs font-semibold block mb-1">Interested Program</label>
                    <select name="course_id" class="w-full px-4 py-2.5 border border-slate-300 rounded-2xl">
                        <option value="">Select a program (optional)</option>
                        <?php foreach ($courses as $c): ?>
                            <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['title']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div>
                    <label class="text-xs font-semibold block mb-1">Message / Questions</label>
                    <textarea name="message" rows="4" class="w-full px-4 py-2.5 border border-slate-300 rounded-2xl" placeholder="Tell us about your child or any specific requirements..."></textarea>
                </div>
                
                <button type="submit" class="btn-primary w-full py-3.5">Submit Enquiry</button>
                
                <p class="text-center text-xs text-slate-400">We will contact you within 24 hours.</p>
            </form>
        </div>
        
        <div class="md:col-span-2">
            <div class="bg-slate-900 text-white p-6 rounded-3xl">
                <div class="font-semibold mb-3">Contact Details</div>
                <div class="text-sm space-y-3">
                    <div><strong>Phone:</strong><br> <?= get_setting('phone') ?></div>
                    <div><strong>WhatsApp:</strong><br> <a href="https://wa.me/<?= get_setting('whatsapp') ?>" class="underline">Chat Now</a></div>
                    <div><strong>Email:</strong><br> <?= get_setting('email') ?></div>
                    <div><strong>Address:</strong><br> <?= get_setting('address') ?></div>
                </div>
                
                <div class="mt-6 pt-6 border-t border-white/30 text-sm">
                    <div class="font-semibold">Free Trial Class</div>
                    <p class="text-xs mt-1">One complimentary 60-min session.<br> Limited slots available every week.</p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>