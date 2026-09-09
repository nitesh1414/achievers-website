<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';
$video_whatsapp = whatsapp_number(get_setting('whatsapp', ''));
$video_whatsapp_message = rawurlencode(content_value('whatsapp_message', 'Hi Achievers Academy, I would like to know more.'));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video Walkthrough • Achievers Academy CMS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="assets/css/style.css?v=20260909">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>
<body class="bg-slate-900 text-white">
    <?php if ($video_whatsapp): ?><a class="whatsapp-float" href="https://wa.me/<?= e($video_whatsapp) ?>?text=<?= e($video_whatsapp_message) ?>" target="_blank" rel="noopener noreferrer" aria-label="<?= e(content_value('whatsapp_float_label', 'Chat on WhatsApp')) ?>"><i class="fa-brands fa-whatsapp" aria-hidden="true"></i><span>WhatsApp</span></a><?php endif; ?>
    <div class="max-w-5xl mx-auto pt-8 pb-12 px-5">
        <div class="flex justify-between items-center mb-6">
            <div>
                <div class="flex items-center gap-x-2">
                    <div class="w-8 h-8 bg-amber-400 text-slate-900 rounded flex items-center justify-center font-extrabold">A</div>
                    <span class="font-bold text-2xl">Achievers Academy</span>
                </div>
                <div class="text-sm text-amber-300">CMS Video Walkthrough</div>
            </div>
            <div>
                <a href="" class="px-4 py-1.5 text-sm bg-white text-slate-900 font-semibold rounded-full">← Back to Website</a>
                <a href="admin/login.php" class="ml-2 px-4 py-1.5 text-sm bg-amber-400 text-slate-900 font-semibold rounded-full">Open Live CMS</a>
            </div>
        </div>
        
        <h1 class="text-4xl font-extrabold mb-1">Quick Demo Video Walkthrough</h1>
        <p class="text-slate-300 mb-8">Interactive 90-second guided tour of the full system. Click any scene or use controls.</p>
        
        <!-- VIDEO PLAYER -->
        <div class="video-container mb-3">
            <!-- Video visual area -->
            <div id="video-screen" class="relative h-[420px] flex items-center justify-center bg-slate-950 overflow-hidden">
                
                <!-- Scene 1: Homepage -->
                <div id="scene-1" class="scene scene--hero absolute inset-0 bg-cover bg-center flex items-center p-10">
                    <div class="max-w-md">
                        <div class="text-xs px-3 py-1 bg-white/90 text-slate-900 rounded w-fit">LIVE WEBSITE</div>
                        <h2 class="text-white text-5xl font-extrabold mt-2 leading-none">Train Like a Champion</h2>
                        <p class="text-white/90 mt-2">Beautiful responsive homepage with hero banners, courses and lead forms.</p>
                    </div>
                </div>
                
                <!-- Scene 2: Admin Dashboard -->
                <div id="scene-2" class="scene hidden absolute inset-0 bg-slate-900 p-8">
                    <div class="bg-white text-slate-900 w-full rounded-xl p-5 shadow">
                        <div class="text-sm font-bold mb-4 flex justify-between">
                            <span>Dashboard Overview</span> 
                            <span class="text-emerald-600 text-xs">187 Leads</span>
                        </div>
                        <div class="grid grid-cols-4 gap-4 text-center">
                            <div><div class="text-3xl font-bold">187</div><div class="text-xs text-slate-400">Inquiries</div></div>
                            <div><div class="text-3xl font-bold">8</div><div class="text-xs text-slate-400">Courses</div></div>
                            <div><div class="text-3xl font-bold">42</div><div class="text-xs text-slate-400">Gallery</div></div>
                            <div><div class="text-3xl font-bold text-amber-600">19</div><div class="text-xs text-slate-400">Pending</div></div>
                        </div>
                    </div>
                </div>
                
                <!-- Scene 3: Leads Manager -->
                <div id="scene-3" class="scene hidden absolute inset-0 bg-white p-8 text-slate-900">
                    <div>
                        <div class="font-bold text-lg">Inquiries &amp; Leads</div>
                        <div class="mt-3 text-sm">
                            <div class="flex gap-2 text-xs mb-1">
                                <div class="px-2 py-0.5 bg-yellow-100 rounded text-yellow-700">Pending</div>
                                <div class="px-2 py-0.5 bg-blue-100 rounded text-blue-700">Contacted</div>
                                <div class="px-2 py-0.5 bg-emerald-100 rounded text-emerald-700">Enrolled</div>
                            </div>
                            <div class="border-t pt-3 text-xs">Export to CSV • Status updates • Call buttons</div>
                        </div>
                    </div>
                </div>
                
                <!-- Scene 4: Courses CRUD -->
                <div id="scene-4" class="scene hidden absolute inset-0 bg-slate-100 p-8 text-slate-900">
                    <div class="font-bold mb-3">Course Manager</div>
                    <div class="bg-white rounded p-4 text-xs">
                        <div class="flex justify-between mb-2">
                            <span class="font-semibold">Little Champions</span>
                            <span class="text-emerald-600">Active</span>
                        </div>
                        <div class="h-2 bg-slate-200 rounded mb-4">
                            <div class="h-2 bg-emerald-400 w-[75%] rounded"></div>
                        </div>
                        <div class="text-[10px]">Full CRUD • Slug URLs • Syllabus • Thumbnail uploads</div>
                    </div>
                </div>
                
                <!-- Overlay text -->
                <div id="video-overlay" class="absolute bottom-4 left-4 right-4 bg-black/60 text-xs px-3 py-1 rounded text-white/90">
                    Scene <span id="scene-num">1</span>/4 — Click timeline or use controls below
                </div>
            </div>
            
            <!-- Controls -->
            <div class="bg-slate-800 px-5 py-4">
                <div class="flex items-center gap-x-4 mb-2">
                    <button onclick="togglePlay()" id="play-btn" class="bg-white text-black w-8 h-8 flex items-center justify-center rounded-full text-xl leading-none">▶</button>
                    
                    <div class="flex-1">
                        <div onclick="seekTo(event)" class="timeline rounded-full">
                            <div id="progress-bar" class="progress rounded-full"></div>
                        </div>
                    </div>
                    
                    <div class="text-xs font-mono w-11 text-right text-slate-400" id="time-display">00:00</div>
                </div>
                
                <div class="flex justify-between items-center text-xs">
                    <div class="flex gap-x-5">
                        <button onclick="goToScene(1)" class="hover:text-amber-300">01 • Homepage</button>
                        <button onclick="goToScene(2)" class="hover:text-amber-300">02 • Dashboard</button>
                        <button onclick="goToScene(3)" class="hover:text-amber-300">03 • Leads</button>
                        <button onclick="goToScene(4)" class="hover:text-amber-300">04 • Courses</button>
                    </div>
                    <div class="text-amber-300 font-semibold text-xs">90 sec demo</div>
                </div>
            </div>
        </div>
        
        <div class="text-center mt-4">
            <a href="demo-walkthrough" class="text-sm underline text-amber-300">Or listen to the full audio-only walkthrough</a>
        </div>
    </div>
    
    <script>
        let currentScene = 1;
        let isPlaying = false;
        let progressInterval;
        let progress = 0;
        
        function showScene(sceneNum) {
            // Hide all scenes
            for (let i = 1; i <= 4; i++) {
                document.getElementById('scene-' + i).classList.add('hidden');
            }
            // Show target
            const target = document.getElementById('scene-' + sceneNum);
            target.classList.remove('hidden');
            
            currentScene = sceneNum;
            document.getElementById('scene-num').innerText = sceneNum;
            
            // Reset progress when switching manually
            if (!isPlaying) {
                progress = (sceneNum - 1) * 25;
                updateProgress();
            }
        }
        
        function goToScene(sceneNum) {
            showScene(sceneNum);
            if (isPlaying) {
                clearInterval(progressInterval);
                startProgress();
            }
        }
        
        function updateProgress() {
            const bar = document.getElementById('progress-bar');
            bar.style.width = progress + '%';
            
            const seconds = Math.floor((progress / 100) * 90);
            document.getElementById('time-display').innerText = 
                '0' + Math.floor(seconds / 60) + ':' + (seconds % 60 < 10 ? '0' : '') + (seconds % 60);
        }
        
        function startProgress() {
            if (progressInterval) clearInterval(progressInterval);
            
            progressInterval = setInterval(() => {
                if (!isPlaying) return;
                
                progress += 0.6; // ~90 seconds
                
                if (progress >= 100) {
                    progress = 100;
                    stopPlayback();
                    return;
                }
                
                updateProgress();
                
                // Auto advance scenes
                const newScene = Math.min(4, Math.ceil((progress / 100) * 4));
                if (newScene !== currentScene) {
                    showScene(newScene);
                }
            }, 100);
        }
        
        function togglePlay() {
            const btn = document.getElementById('play-btn');
            
            if (isPlaying) {
                stopPlayback();
            } else {
                isPlaying = true;
                btn.innerHTML = '⏸';
                startProgress();
                
                // Start from scene 1 if at end
                if (progress >= 95) {
                    progress = 0;
                    showScene(1);
                }
            }
        }
        
        function stopPlayback() {
            isPlaying = false;
            document.getElementById('play-btn').innerHTML = '▶';
            if (progressInterval) clearInterval(progressInterval);
        }
        
        function seekTo(e) {
            const rect = e.currentTarget.getBoundingClientRect();
            const percent = ((e.clientX - rect.left) / rect.width) * 100;
            
            progress = Math.max(0, Math.min(100, percent));
            updateProgress();
            
            const targetScene = Math.min(4, Math.ceil((progress / 100) * 4));
            showScene(targetScene);
            
            if (isPlaying) {
                clearInterval(progressInterval);
                startProgress();
            }
        }
        
        // Keyboard support
        document.addEventListener('keydown', function(e) {
            if (e.key === " " || e.key === "Spacebar") {
                e.preventDefault();
                togglePlay();
            }
            if (e.key === "ArrowRight") {
                const next = Math.min(4, currentScene + 1);
                goToScene(next);
            }
            if (e.key === "ArrowLeft") {
                const prev = Math.max(1, currentScene - 1);
                goToScene(prev);
            }
        });
        
        // Init
        window.onload = function() {
            showScene(1);
            progress = 0;
            updateProgress();
            
            // Auto-play hint
            setTimeout(() => {
                const hint = document.createElement('div');
                hint.style.cssText = 'position:absolute;bottom:16px;right:16px;font-size:10px;color:#64748b;';
                hint.innerHTML = 'Click ▶ to play';
                document.getElementById('video-screen').appendChild(hint);
                
                setTimeout(() => hint.remove(), 3400);
            }, 1400);
        }
        
        // Click anywhere on screen to play
        document.getElementById('video-screen').addEventListener('click', function() {
            togglePlay();
        });
    </script>
</body>
</html>