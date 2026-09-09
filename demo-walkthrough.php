<?php
require_once __DIR__ . '/includes/header.php';
?>
<div class="tail-container py-10">
    <div class="max-w-3xl mx-auto">
        <div class="text-center mb-8">
            <span class="text-amber-600 font-bold text-sm tracking-[2px]">INTERACTIVE DEMO</span>
            <h1 class="text-4xl font-extrabold mt-2">CMS Walkthrough</h1>
            <p class="mt-2 text-lg text-slate-600">Listen to the guided audio tour and explore how the system works.</p>
        </div>
        
        <!-- Audio Walkthrough Cards -->
        <div class="space-y-6">
            <!-- Step 1 -->
            <div class="bg-white border rounded-3xl p-6 flex flex-col md:flex-row gap-6">
                <div class="md:w-1/3">
                    <div class="text-xs font-semibold text-amber-600">STEP 01</div>
                    <h3 class="font-bold text-xl">Welcome &amp; Overview</h3>
                    <p class="text-sm mt-2 text-slate-600">Introduction to the Achievers Academy custom CMS.</p>
                    
                    <audio controls class="mt-4 w-full">
                        <source src="assets/audio/demo-intro.mp3" type="audio/mpeg">
                        Your browser does not support the audio element.
                    </audio>
                </div>
                <div class="flex-1 text-sm bg-slate-50 p-5 rounded-2xl">
                    <ul class="space-y-2 text-sm">
                        <li>✅ Full 10-module CMS built in Core PHP + MySQL + PDO</li>
                        <li>✅ Beautiful responsive public website</li>
                        <li>✅ Powerful lead capture system</li>
                        <li>✅ Complete admin control panel</li>
                    </ul>
                </div>
            </div>
            
            <!-- Step 2 -->
            <div class="bg-white border rounded-3xl p-6 flex flex-col md:flex-row gap-6">
                <div class="md:w-1/3">
                    <div class="text-xs font-semibold text-amber-600">STEP 02</div>
                    <h3 class="font-bold text-xl">Admin Dashboard</h3>
                    <p class="text-sm mt-2 text-slate-600">Real-time analytics and navigation of the entire CMS.</p>
                    
                    <audio controls class="mt-4 w-full">
                        <source src="assets/audio/demo-admin.mp3" type="audio/mpeg">
                        Your browser does not support the audio element.
                    </audio>
                </div>
                <div class="flex-1">
                    <div class="bg-slate-900 text-white text-xs rounded-xl p-4 font-mono">
                        <div>📊 Total Inquiries: <span class="font-bold text-emerald-300">187</span></div>
                        <div>📚 Active Courses: <span class="font-bold text-emerald-300">8</span></div>
                        <div>🏆 Gallery Items: 42</div>
                        <div class="mt-2 text-amber-400">Recent leads automatically appear here</div>
                    </div>
                    <a href="admin/index" class="mt-3 inline-block text-xs px-4 py-1 bg-amber-400 text-black rounded-full font-semibold">Go to Live Admin</a>
                </div>
            </div>
            
            <!-- Step 3 -->
            <div class="bg-white border rounded-3xl p-6 flex flex-col md:flex-row gap-6">
                <div class="md:w-1/3">
                    <div class="text-xs font-semibold text-amber-600">STEP 03</div>
                    <h3 class="font-bold text-xl">Lead Management</h3>
                    <p class="text-sm mt-2 text-slate-600">Capture, filter, update status and export all inquiries.</p>
                    
                    <audio controls class="mt-4 w-full">
                        <source src="assets/audio/demo-leads.mp3" type="audio/mpeg">
                        Your browser does not support the audio element.
                    </audio>
                </div>
                <div class="flex-1 text-sm">
                    <div class="border border-slate-200 p-3 rounded-xl text-xs">
                        <strong>Powerful features:</strong><br>
                        • Real-time status updates (Pending → Contacted → Enrolled)<br>
                        • Advanced search + filters<br>
                        • One-click CSV / Excel export<br>
                        • Direct call &amp; WhatsApp buttons
                    </div>
                    <a href="admin/inquiries" class="mt-3 inline-block text-xs px-4 py-1 bg-emerald-600 text-white rounded-full font-semibold">Open Leads Manager →</a>
                </div>
            </div>
        </div>
        
        <div class="mt-8 bg-gradient-to-r from-slate-900 to-slate-800 p-7 rounded-3xl text-white">
            <div class="flex flex-col md:flex-row items-center gap-5">
                <div class="flex-1">
                    <div class="font-bold">Ready to explore the full system?</div>
                    <div class="text-sm text-slate-300">Try the live website and admin panel.</div>
                </div>
                <div class="flex gap-2">
                    <a href="" class="btn-accent px-6 py-2 text-sm">View Website</a>
                    <a href="admin/login" class="px-6 py-2 text-sm border border-white/30 hover:bg-white/10 rounded-full">Login to Admin</a>
                </div>
            </div>
        </div>
        
        <div class="text-center text-xs text-slate-400 mt-7">
            Demo audio generated specifically for this walkthrough. All features shown are fully functional.
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>