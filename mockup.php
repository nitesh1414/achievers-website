<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mockup • Achievers Academy CMS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .mockup-frame { box-shadow: 0 25px 50px -12px rgb(0 0 0 / 0.4); border: 14px solid #0f172a; border-radius: 2.5rem; overflow: hidden; }
        .device { background: #0f172a; padding: 12px; border-radius: 3rem; }
        .tab-active { border-bottom: 3px solid #f59e0b; color: #0f172a; }
    </style>
</head>
<body class="bg-slate-100 py-12">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-10">
            <h1 class="text-5xl font-extrabold">Achievers Academy — Design Mockups</h1>
            <p class="text-xl text-slate-600 mt-2">High-fidelity mockups of the public website &amp; CMS Admin Panel</p>
            <div class="mt-4 flex justify-center gap-3">
                <a href="" class="text-sm px-5 py-2 border rounded-full">← Live Site</a>
                <a href="admin/login.php" class="text-sm px-5 py-2 bg-slate-900 text-white rounded-full">Open Admin CMS</a>
            </div>
        </div>

        <!-- Website Mockup -->
        <div class="mb-16">
            <div class="flex items-center justify-between mb-4 px-1">
                <div>
                    <span class="text-xs font-bold px-3 py-1 bg-white rounded-full border">PUBLIC WEBSITE</span>
                    <span class="ml-2 font-semibold text-xl">Homepage Mockup</span>
                </div>
                <div class="text-xs text-slate-500">Desktop + Mobile responsive</div>
            </div>
            
            <div class="grid lg:grid-cols-12 gap-5">
                <!-- Desktop -->
                <div class="lg:col-span-8">
                    <div class="device mx-auto max-w-[920px]">
                        <div class="mockup-frame bg-white">
                            <!-- Browser chrome -->
                            <div class="bg-slate-800 px-4 py-2 flex items-center text-white text-xs">
                                <div class="flex gap-1.5 mr-3">
                                    <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                                    <div class="w-3 h-3 bg-yellow-500 rounded-full"></div>
                                    <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                                </div>
                                <div class="bg-slate-700 px-3 py-0.5 rounded flex-1 text-center text-[10px]">https://achieversacademy.com</div>
                            </div>
                            
                            <!-- Hero preview -->
                            <div class="bg-gradient-to-r from-slate-900 to-slate-800 text-white p-8" style="background-image: linear-gradient(rgba(15,23,42,.75), rgba(15,23,42,.65)), url('/assets/images/hero-main.jpg'); background-size: cover; background-position: center; min-height: 320px;">
                                <div class="max-w-md">
                                    <div class="inline px-4 py-1 bg-amber-400 text-slate-900 text-xs font-bold rounded-full">NAGPUR'S #1</div>
                                    <h1 class="text-[42px] leading-[1.05] font-extrabold mt-3">TRAIN LIKE A<br>CHAMPION</h1>
                                    <p class="mt-2 text-sm">Under International Coach Pankaj Kunde</p>
                                    
                                    <div class="mt-5 flex gap-2">
                                        <button class="bg-amber-400 text-slate-900 px-5 py-2 rounded-full text-sm font-bold">Enroll Now</button>
                                        <button class="border border-white/40 px-5 py-2 rounded-full text-sm">View Achievements</button>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="p-6">
                                <div class="flex justify-between mb-4">
                                    <div class="text-sm font-semibold">Our Training Programs</div>
                                    <div class="text-xs text-amber-600">See all →</div>
                                </div>
                                
                                <div class="grid grid-cols-3 gap-3">
                                    <div class="border rounded-xl overflow-hidden">
                                        <div class="h-20 bg-cover" style="background-image:url('/assets/images/course-little.jpg')"></div>
                                        <div class="p-3 text-xs">
                                            <div class="font-semibold">Little Champions</div>
                                            <div class="text-emerald-600">₹4,500</div>
                                        </div>
                                    </div>
                                    <div class="border rounded-xl overflow-hidden">
                                        <div class="h-20 bg-cover" style="background-image:url('/assets/images/course-rising.jpg')"></div>
                                        <div class="p-3 text-xs">
                                            <div class="font-semibold">Rising Stars</div>
                                            <div class="text-emerald-600">₹6,500</div>
                                        </div>
                                    </div>
                                    <div class="border rounded-xl overflow-hidden">
                                        <div class="h-20 bg-cover" style="background-image:url('/assets/images/course-national.jpg')"></div>
                                        <div class="p-3 text-xs">
                                            <div class="font-semibold">National Prep</div>
                                            <div class="text-emerald-600">₹12,500</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Mobile -->
                <div class="lg:col-span-4">
                    <div class="device mx-auto w-[260px]">
                        <div class="mockup-frame bg-white" style="border-radius: 3rem; padding-top: 32px;">
                            <div class="bg-gradient-to-br from-slate-900 to-black text-white p-4" style="min-height: 480px; background-image: linear-gradient(rgba(15,23,42,.75), rgba(15,23,42,.65)), url('/assets/images/hero-main.jpg'); background-size: cover;">
                                <div class="text-xs px-3 py-0.5 bg-amber-400 text-black inline-block rounded-full mb-1">NAGPUR #1</div>
                                <div class="text-[21px] font-extrabold leading-none">TRAIN LIKE A CHAMPION</div>
                                <div class="text-[10px] mt-2">Pankaj Kunde • 18+ years</div>
                                
                                <div class="mt-5">
                                    <button class="bg-amber-400 px-4 py-1 text-xs font-bold text-black rounded-full">Enroll Free Trial</button>
                                </div>
                            </div>
                            
                            <div class="p-3 text-xs bg-white">
                                <div class="font-bold mb-1">Our Programs</div>
                                <div class="space-y-1 text-[10px]">
                                    <div class="flex justify-between"><span>Little Champions</span> <span class="font-semibold">₹4,500</span></div>
                                    <div class="flex justify-between"><span>Rising Stars</span> <span class="font-semibold">₹6,500</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Admin Dashboard Mockup -->
        <div>
            <div class="flex items-center justify-between mb-4 px-1">
                <div>
                    <span class="text-xs font-bold px-3 py-1 bg-white rounded-full border">CMS ADMIN</span>
                    <span class="ml-2 font-semibold text-xl">Admin Dashboard Mockup</span>
                </div>
            </div>
            
            <div class="bg-white border shadow-xl rounded-3xl overflow-hidden max-w-[1050px]">
                <!-- Admin header -->
                <div class="bg-slate-900 text-white px-6 py-3 flex items-center">
                    <div class="flex items-center gap-2">
                        <div class="w-7 h-7 bg-amber-400 text-slate-900 flex items-center justify-center text-sm font-extrabold rounded">A</div>
                        <span class="font-bold">Achievers CMS</span>
                    </div>
                    <div class="flex-1"></div>
                    <div class="text-xs px-3 py-1 bg-slate-800 rounded-full">admin</div>
                </div>
                
                <div class="flex">
                    <!-- Sidebar -->
                    <div class="w-52 bg-slate-800 text-slate-300 p-2 text-xs">
                        <div class="px-3 py-2 text-amber-300 text-[10px] font-bold">ADMIN PANEL</div>
                        <div class="space-y-1">
                            <div class="px-3 py-1.5 bg-slate-700 rounded text-white">📊 Dashboard</div>
                            <div class="px-3 py-1.5">🖼️ Banners</div>
                            <div class="px-3 py-1.5">📚 Courses</div>
                            <div class="px-3 py-1.5">📩 Inquiries <span class="text-[10px] bg-red-500 px-1.5 rounded">28</span></div>
                            <div class="px-3 py-1.5">👨‍🏫 Mentor</div>
                            <div class="px-3 py-1.5">🏅 Competitions</div>
                            <div class="px-3 py-1.5">🏆 Toppers</div>
                            <div class="px-3 py-1.5">⚙️ Settings</div>
                        </div>
                    </div>
                    
                    <!-- Main content -->
                    <div class="flex-1 p-6">
                        <div class="flex justify-between mb-4">
                            <div>
                                <span class="font-bold">Dashboard Overview</span>
                            </div>
                            <div class="text-xs text-emerald-600">Last updated just now</div>
                        </div>
                        
                        <!-- Stats -->
                        <div class="grid grid-cols-4 gap-3 mb-6">
                            <div class="bg-slate-50 border p-3 rounded-2xl">
                                <div class="text-xs">Total Inquiries</div>
                                <div class="text-3xl font-bold">187</div>
                                <div class="text-emerald-600 text-xs">+34 this month</div>
                            </div>
                            <div class="bg-slate-50 border p-3 rounded-2xl">
                                <div class="text-xs">Active Courses</div>
                                <div class="text-3xl font-bold">8</div>
                            </div>
                            <div class="bg-slate-50 border p-3 rounded-2xl">
                                <div class="text-xs">Gallery Items</div>
                                <div class="text-3xl font-bold">42</div>
                            </div>
                            <div class="bg-slate-50 border p-3 rounded-2xl">
                                <div class="text-xs">Pending Leads</div>
                                <div class="text-3xl font-bold text-amber-600">19</div>
                            </div>
                        </div>
                        
                        <div class="font-semibold mb-2 text-sm">Recent Leads</div>
                        <table class="w-full text-xs">
                            <tr class="border-b text-left text-slate-400">
                                <th class="py-1.5">Name</th>
                                <th>Course</th>
                                <th>Status</th>
                            </tr>
                            <tr class="border-b">
                                <td class="py-2">Aarav Sharma</td>
                                <td class="text-xs">Little Champions</td>
                                <td><span class="px-2 py-px bg-emerald-100 text-emerald-700 rounded text-[10px]">Enrolled</span></td>
                            </tr>
                            <tr>
                                <td class="py-2">Riya Deshmukh</td>
                                <td class="text-xs">Elite Program</td>
                                <td><span class="px-2 py-px bg-blue-100 text-blue-700 rounded text-[10px]">Contacted</span></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="text-center mt-12 text-xs text-slate-400">These are high-fidelity visual mockups of the live system. All modules are fully functional in the real CMS.</div>
    </div>
</body>
</html>