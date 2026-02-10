<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../auth.php';

require_login();

$user = get_authenticated_user($pdo);
if ($user === null) {
    session_destroy();
    header('Location: ../index.php');
    exit;
}

if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: ../index.php');
    exit;
}

include __DIR__ . '/../components/header.php';
?>

<style>
    
    .code-font {
        font-family: 'JetBrains Mono', 'Cascadia Code', 'Fira Code', monospace;
        font-variant-ligatures: common-ligatures;
        font-size: 13px;
        line-height: 1.6;
    }
    
    .scene-3d {
        perspective: 1200px;
        transform-style: preserve-3d;
    }
    
    .floor-3d {
        transform: rotateX(60deg) translateZ(-50px);
        background: rgba(38, 38, 38, 0.9);
    }
    
    /* Animation updates */
    @keyframes fileFloat {
        0%, 100% { transform: translateY(0) translateZ(40px) rotateY(0deg); }
        25% { transform: translateY(-8px) translateZ(45px) rotateY(5deg); }
        50% { transform: translateY(-12px) translateZ(50px) rotateY(0deg); }
        75% { transform: translateY(-8px) translateZ(45px) rotateY(-5deg); }
    }
    
    @keyframes moveToServer {
        0% { transform: translateX(0) translateZ(40px); opacity: 1; }
        100% { transform: translateX(200px) translateZ(20px); opacity: 0.8; }
    }
    
    @keyframes moveToServerSecure {
        0% { transform: translateX(0) translateZ(40px); opacity: 1; }
        40% { transform: translateX(80px) translateZ(60px); opacity: 1; }
        60% { transform: translateX(120px) translateZ(60px); opacity: 1; }
        100% { transform: translateX(200px) translateZ(20px); opacity: 0.8; }
    }
    
    @keyframes virusSpread {
        0% { transform: scale(0); opacity: 0; }
        50% { transform: scale(1.5); opacity: 0.8; }
        100% { transform: scale(2); opacity: 0; }
    }
    
    @keyframes shieldPulse {
        0%, 100% { box-shadow: 0 0 20px rgba(52, 211, 153, 0.3), inset 0 0 20px rgba(52, 211, 153, 0.1); }
        50% { box-shadow: 0 0 40px rgba(52, 211, 153, 0.6), inset 0 0 30px rgba(52, 211, 153, 0.2); }
    }
    
    @keyframes shieldBlock {
        0% { transform: scale(1); }
        50% { transform: scale(1.1); box-shadow: 0 0 60px rgba(244, 63, 94, 0.8); }
        100% { transform: scale(1); }
    }
    
    @keyframes checkMark {
        0% { transform: scale(0) rotate(-45deg); opacity: 0; }
        50% { transform: scale(1.2) rotate(0deg); opacity: 1; }
        100% { transform: scale(1) rotate(0deg); opacity: 1; }
    }
    
    @keyframes warningPulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.1); }
    }
    
    @keyframes serverDamage {
        0% { filter: hue-rotate(0deg) brightness(1); }
        25% { filter: hue-rotate(30deg) brightness(1.3); }
        50% { filter: hue-rotate(-30deg) brightness(0.8); }
        75% { filter: hue-rotate(20deg) brightness(1.2); }
        100% { filter: hue-rotate(0deg) brightness(1); }
    }
    
    @keyframes glitch {
        0%, 100% { transform: translate(0); }
        20% { transform: translate(-2px, 2px); }
        40% { transform: translate(2px, -2px); }
        60% { transform: translate(-2px, -2px); }
        80% { transform: translate(2px, 2px); }
    }
    
    @keyframes scanLine {
        0% { top: 0; }
        100% { top: 100%; }
    }
    
    @keyframes cursorBlink {
        0%, 100% { opacity: 1; }
        50% { opacity: 0; }
    }
    
    .file-floating {
        animation: fileFloat 3s ease-in-out infinite;
    }
    
    .file-moving-unsafe {
        animation: moveToServer 2s ease-in-out forwards;
    }
    
    .file-moving-secure {
        animation: moveToServerSecure 2.5s ease-in-out forwards;
    }
    
    .virus-effect {
        animation: virusSpread 1s ease-out forwards;
    }
    
    .shield-glow {
        animation: shieldPulse 2s ease-in-out infinite;
    }
    
    .shield-block {
        animation: shieldBlock 0.5s ease-out;
    }
    
    .check-animation {
        animation: checkMark 0.5s ease-out forwards;
    }
    
    .warning-animation {
        animation: warningPulse 0.5s ease-in-out 3;
    }
    
    .server-damaged {
        animation: serverDamage 0.5s ease-in-out 3;
    }
    
    .scan-effect::after {
        content: '';
        position: absolute;
        left: 0;
        width: 100%;
        height: 4px;
        background: rgba(52, 211, 153, 0.5);
        animation: scanLine 1s linear infinite;
    }
    
    .cursor-blink {
        animation: cursorBlink 1s infinite;
    }
    
    .gradient-danger {
        background: #e11d48;
    }
    
    .gradient-safe {
        background: #059669;
    }
    
    /* Match header glass and neutrals */
    .glass-panel {
        background: rgba(38, 38, 38, 0.85);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.08);
    }
    
    .section-title {
        color: #818cf8;
    }
    
    .control-btn {
        transition: all 0.3s ease;
    }
    
    .control-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
    }
    
    .info-badge {
        background: rgba(99, 102, 241, 0.2);
        border: 1px solid rgba(99, 102, 241, 0.3);
    }
    
    .warning-badge {
        background: rgba(244, 63, 94, 0.2);
        border: 1px solid rgba(244, 63, 94, 0.3);
    }
    
    .success-badge {
        background: rgba(52, 211, 153, 0.2);
        border: 1px solid rgba(52, 211, 153, 0.3);
    }
</style>

<section class="w-full mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-10 text-center">
        <h1 class="text-3xl font-bold text-indigo-400 mb-2">
            File Upload Security Lab
        </h1>
        <p class="text-gray-400">Compare vulnerable vs secure file upload behavior in real time.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
        <!-- UNSAFE UPLOAD CARD -->
        <div class="relative group">
            <div class="absolute -inset-1 bg-rose-600 rounded-2xl blur opacity-25 group-hover:opacity-40 transition duration-1000"></div>
            <div class="glass-panel relative rounded-2xl p-6">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-3">
                        <h2 class="text-2xl font-bold text-rose-400">Vulnerable Upload</h2>
                    </div>
                    <div class="warning-badge px-3 py-1 rounded-full text-rose-200 text-sm font-medium">
                        HIGH RISK
                    </div>
                </div>
                
                <!-- 3D Scene - Unsafe -->
                <div id="unsafe-scene" class="scene-3d relative h-72  rounded-xl overflow-hidden bg-neutral-900">
                    <!-- Floor -->
                    <div class="floor-3d absolute bottom-0 left-0 right-0 h-32 rounded-lg" style="background: rgba(244, 63, 94, 0.08);"></div>
                    
                    <!-- Upload Form -->
                    <div id="unsafe-form" class="upload-form-3d absolute left-4 top-1/2 -translate-y-1/2 w-24 h-32 rounded-lg bg-rose-900/30 border-2 border-rose-500/30 flex flex-col items-center justify-center gap-2 shadow-xl">
                        <div class="text-3xl text-rose-300"><i class="fas fa-cloud-upload-alt"></i></div>
                        <div class="text-xs text-rose-300">Upload</div>
                        <div class="w-16 h-1 bg-rose-500/50 rounded"></div>
                    </div>
                    
                    <!-- File Icons Container -->
                    <div id="unsafe-files" class="absolute z-50 left-32 top-1/2 -translate-y-1/2 flex flex-col gap-2">
                        <!-- Files will be animated here -->
                    </div>
                    
                    <!-- Server -->
                    <div id="unsafe-server" class="server-3d absolute right-4 top-1/2 -translate-y-1/2 w-28 h-40 rounded-lg bg-rose-900/20 border-2 border-rose-500/30 flex flex-col items-center justify-center shadow-xl transition-all duration-300">
                        <div class="text-4xl mb-2 text-rose-300"><i class="fas fa-server"></i></div>
                        <div class="text-xs text-rose-300 font-medium">Web Server</div>
                        <div class="flex gap-1 mt-2">
                            <div class="w-2 h-2 rounded-full bg-rose-500 animate-pulse"></div>
                            <div class="w-2 h-2 rounded-full bg-amber-500 animate-pulse" style="animation-delay: 0.2s;"></div>
                            <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse" style="animation-delay: 0.4s;"></div>
                        </div>
                        <!-- Virus effects container -->
                        <div id="virus-container" class="absolute z-50 inset-0 pointer-events-none"></div>
                    </div>
                    
                    <!-- Status indicator -->
                    <div id="unsafe-status" >
                        
                    </div>
                </div>
                <!-- Card action -->
                <div class="mt-4 pt-4 border-t border-white/5">
                    <a href="/pages/vulnerable_upload.php" 
                       class="inline-flex items-center justify-center gap-2 w-full px-4 py-3 rounded-lg text-rose-300 hover:text-rose-200 bg-rose-500/10 hover:bg-rose-500/20 border border-rose-500/30 transition-all duration-200 font-medium">
                        <i class="fas fa-bug"></i>
                        <span>Try Vulnerable Upload</span>
                    </a>
                </div>
            </div>
        </div>
        
        <!-- SECURE UPLOAD CARD -->
        <div class="relative group">
            <div class="absolute -inset-1 bg-emerald-600 rounded-2xl blur opacity-25 group-hover:opacity-40 transition duration-1000"></div>
            <div class="glass-panel relative rounded-2xl p-6">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-3">
                        <h2 class="text-2xl font-bold text-emerald-400">Secure Upload</h2>
                    </div>
                    <div class="success-badge px-3 py-1 rounded-full text-emerald-200 text-sm font-medium">
                        PROTECTED
                    </div>
                </div>
                
                <!-- 3D Scene - Secure -->
                <div id="secure-scene" class="scene-3d relative h-72  rounded-xl overflow-hidden bg-neutral-900">
                    <!-- Floor -->
                    <div class="floor-3d absolute bottom-0 left-0 right-0 h-32 rounded-lg" style="background: rgba(52, 211, 153, 0.12);"></div>
                    
                    <!-- Upload Form -->
                    <div class="upload-form-3d absolute left-4 top-1/2 -translate-y-1/2 w-24 h-32 rounded-lg bg-emerald-900/30 border-2 border-emerald-500/30 flex flex-col items-center justify-center gap-2 shadow-xl">
                        <div class="text-3xl text-emerald-300"><i class="fas fa-cloud-upload-alt"></i></div>
                        <div class="text-xs text-emerald-300">Upload</div>
                        <div class="w-16 h-1 bg-emerald-500/50 rounded"></div>
                    </div>
                    
                    <!-- File Icons Container -->
                    <div id="secure-files" class="absolute z-50 left-32 top-1/2 -translate-y-1/2 flex flex-col gap-2">
                        <!-- Files will be animated here -->
                    </div>
                    
                    <!-- Security Shield -->
                    <div id="security-shield" class="shield-glow absolute left-1/2 -translate-x-1/2 top-1/2 -translate-y-1/2 w-16 h-20 rounded-lg bg-emerald-500/30 border-2 border-emerald-400 flex items-center justify-center transition-all duration-300 relative overflow-hidden">
                        <div class="text-2xl text-emerald-400"><i class="fas fa-shield-alt"></i></div>
                        <div class="absolute inset-0 scan-effect opacity-50"></div>
                    </div>
                    
                    <!-- Validation Steps Floating -->
                    <div id="validation-steps" class="absolute top-2 left-1/2 -translate-x-1/2 flex gap-2 opacity-0 transition-opacity duration-500">
                        <span class="px-2 py-1 rounded text-xs bg-emerald-600/80 text-white"><i class="fas fa-check mr-1"></i>Type</span>
                        <span class="px-2 py-1 rounded text-xs bg-emerald-600/80 text-white"><i class="fas fa-check mr-1"></i>Size</span>
                        <span class="px-2 py-1 rounded text-xs bg-emerald-600/80 text-white"><i class="fas fa-check mr-1"></i>Rename</span>
                    </div>
                    
                    <!-- Server -->
                    <div id="secure-server" class="server-3d absolute right-4 top-1/2 -translate-y-1/2 w-28 h-40 rounded-lg bg-emerald-900/20 border-2 border-emerald-500/30 flex flex-col items-center justify-center shadow-xl">
                        <div class="text-4xl mb-2 text-emerald-300"><i class="fas fa-server"></i></div>
                        <div class="text-xs text-emerald-300 font-medium">Secure Server</div>
                        <div class="flex gap-1 mt-2">
                            <div class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></div>
                            <div class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse" style="animation-delay: 0.2s;"></div>
                            <div class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse" style="animation-delay: 0.4s;"></div>
                        </div>
                       
                    </div>
                    
                    <!-- Status indicator -->
                    <div id="secure-status">
                       
                    </div>
                </div>
                <!-- Card action -->
                <div class="mt-4 pt-4 border-t border-white/5">
                    <a href="/pages/secure_upload.php" 
                       class="inline-flex items-center justify-center gap-2 w-full px-4 py-3 rounded-lg text-emerald-300 hover:text-emerald-200 bg-emerald-500/10 hover:bg-emerald-500/20 border border-emerald-500/30 transition-all duration-200 font-medium">
                        <i class="fas fa-lock"></i>
                        <span>Try Secure Upload</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    // Configuration
    let isRunning = false;
    let autoPlay = false;
    let animationSpeed = 1;
    let animationTimeouts = [];

    // File definitions (Font Awesome icon classes)
    const unsafeFiles = [
        { name: 'shell.php', icon: 'fas fa-file-code', type: 'danger', ext: '.php' },
        { name: 'hack.phtml', icon: 'fas fa-file-code', type: 'danger', ext: '.phtml' },
        { name: 'malware.exe', icon: 'fas fa-cog', type: 'danger', ext: '.exe' }
    ];

    const secureFiles = [
        { name: 'document.pdf', icon: 'fas fa-file-pdf', type: 'safe', ext: '.pdf' },
        { name: 'photo.png', icon: 'fas fa-image', type: 'safe', ext: '.png' },
        { name: 'malware.php', icon: 'fas fa-file-code', type: 'danger', ext: '.php' }
    ];

    // Create file element
    function createFileElement(file, isSecure = false) {
        const el = document.createElement('div');
        el.className = `file-item flex items-center gap-2 px-3 py-2 rounded-lg transition-all duration-300 file-floating ${
            file.type === 'danger' ? 'bg-rose-900/80 border border-rose-500/50' : 'bg-neutral-800/80 border border-neutral-500/50'
        }`;
        el.innerHTML = `
            <span class="text-lg ${file.type === 'danger' ? 'text-rose-300' : 'text-gray-300'}"><i class="${file.icon}"></i></span>
            <span class="text-xs font-medium ${file.type === 'danger' ? 'text-rose-300' : 'text-gray-200'}">${file.name}</span>
            <span class="text-xs px-1.5 py-0.5 rounded ${
                file.type === 'danger' ? 'bg-rose-700 text-white' : 'bg-neutral-700 text-gray-200'
            }">${file.ext}</span>
        `;
        el.dataset.type = file.type;
        el.dataset.name = file.name;
        return el;
    }

    // Create virus effect
    function createVirusEffect(container) {
        const virus = document.createElement('div');
        virus.className = 'virus-effect absolute inset-0 rounded-lg';
        virus.style.background = 'rgba(244, 63, 94, 0.4)';
        container.appendChild(virus);
        
        const t = setTimeout(() => virus.remove(), 1000);
        animationTimeouts.push(t);
    }

    // Create check mark
    function createCheckMark(container) {
        const check = document.createElement('div');
        check.className = 'check-animation absolute text-4xl text-emerald-500';
        check.style.top = '50%';
        check.style.left = '50%';
        check.style.transform = 'translate(-50%, -50%)';
        check.innerHTML = '<i class="fas fa-check"></i>';
        container.appendChild(check);
        
        const t = setTimeout(() => check.remove(), 1500);
        animationTimeouts.push(t);
    }

    // Create warning X
    function createWarningX(container) {
        const warning = document.createElement('div');
        warning.className = 'warning-animation absolute text-4xl text-rose-500';
        warning.style.top = '50%';
        warning.style.left = '50%';
        warning.style.transform = 'translate(-50%, -50%)';
        warning.innerHTML = '<i class="fas fa-times"></i>';
        container.appendChild(warning);
        
        const t = setTimeout(() => warning.remove(), 1500);
        animationTimeouts.push(t);
    }

    // Clear animations
    function clearAllAnimations() {
        animationTimeouts.forEach(t => clearTimeout(t));
        animationTimeouts = [];
    }

    // Reset demo
    function resetDemo() {
        clearAllAnimations();
        isRunning = false;
        
        const unsafeFilesContainer = document.getElementById('unsafe-files');
        const secureFilesContainer = document.getElementById('secure-files');
        const unsafeServer = document.getElementById('unsafe-server');
        const virusContainer = document.getElementById('virus-container');
        const validationSteps = document.getElementById('validation-steps');
        const shield = document.getElementById('security-shield');
        const unsafeStatus = document.getElementById('unsafe-status');
        const secureStatus = document.getElementById('secure-status');
        const demoStatus = document.getElementById('demo-status');
        
        if (unsafeFilesContainer) unsafeFilesContainer.innerHTML = '';
        if (secureFilesContainer) secureFilesContainer.innerHTML = '';
        if (virusContainer) virusContainer.innerHTML = '';
        if (unsafeServer) {
            unsafeServer.classList.remove('server-damaged');
            unsafeServer.style.filter = 'none';
        }
        if (validationSteps) validationSteps.style.opacity = '0';
        if (shield) shield.classList.remove('shield-block');
        if (unsafeStatus) {
            unsafeStatus.textContent = 'Click "Start Demo" to begin';
            unsafeStatus.className = 'absolute bottom-2 left-1/2 -translate-x-1/2 px-3 py-1 text-xs font-medium text-rose-200';
        }
        if (secureStatus) {
            secureStatus.textContent = 'Click "Start Demo" to begin';
            secureStatus.className = 'absolute bottom-2 left-1/2 -translate-x-1/2 px-3 py-1 text-xs font-medium text-emerald-200';
        }
        if (demoStatus) {
            demoStatus.textContent = 'Demo ready - Click Start to begin';
        }
    }

    // Run unsafe demo
    async function runUnsafeDemo() {
        const container = document.getElementById('unsafe-files');
        const server = document.getElementById('unsafe-server');
        const virusContainer = document.getElementById('virus-container');
        const status = document.getElementById('unsafe-status');
        const demoStatus = document.getElementById('demo-status');
        
        for (let i = 0; i < unsafeFiles.length; i++) {
            if (!isRunning) return;
            
            const file = unsafeFiles[i];
            const el = createFileElement(file, false);
            container.appendChild(el);
            
            status.innerHTML = `<i class="fas fa-cloud-upload-alt mr-1"></i>Uploading ${file.name}...`;
            status.className = 'absolute bottom-2 left-1/2 -translate-x-1/2 px-3 py-1 text-xs font-medium text-amber-200';
            if (demoStatus) demoStatus.textContent = `Uploading ${file.name} to vulnerable server...`;
            
            await new Promise(r => {
                const t = setTimeout(r, 1000 / animationSpeed);
                animationTimeouts.push(t);
            });
            
            // Animate file moving to server
            el.classList.remove('file-floating');
            el.classList.add('file-moving-unsafe');
            
            await new Promise(r => {
                const t = setTimeout(r, 2000 / animationSpeed);
                animationTimeouts.push(t);
            });
            
            if (file.type === 'danger') {
                status.innerHTML = `<i class="fas fa-exclamation-triangle mr-1"></i>${file.name} executed - SERVER COMPROMISED!`;
                status.className = 'absolute bottom-2 left-1/2 -translate-x-1/2 px-3 py-1 text-xs font-medium text-rose-400';
                server.classList.add('server-damaged');
                if (demoStatus) demoStatus.textContent = `⚠️ ${file.name} compromised the server!`;
                
                createVirusEffect(virusContainer);
                
                // Add multiple virus effects
                for (let j = 0; j < 2; j++) {
                    setTimeout(() => createVirusEffect(virusContainer), j * 300);
                }
            } else {
                status.innerHTML = `<i class="fas fa-check mr-1"></i>${file.name} uploaded`;
                status.className = 'absolute bottom-2 left-1/2 -translate-x-1/2 px-3 py-1 text-xs font-medium text-emerald-200';
                if (demoStatus) demoStatus.textContent = `${file.name} uploaded without validation`;
            }
            
            el.remove();
            
            await new Promise(r => {
                const t = setTimeout(r, 1500 / animationSpeed);
                animationTimeouts.push(t);
            });
            
            server.classList.remove('server-damaged');
        }
        
        status.innerHTML = '<i class="fas fa-skull-crossbones mr-1"></i>Server fully compromised!';
        status.className = 'absolute bottom-2 left-1/2 -translate-x-1/2 px-3 py-1 text-xs font-medium text-rose-400';
        if (demoStatus) demoStatus.textContent = 'Vulnerable server has been compromised by malicious files';
    }

    // Run secure demo
    async function runSecureDemo() {
        const container = document.getElementById('secure-files');
        const shield = document.getElementById('security-shield');
        const validationSteps = document.getElementById('validation-steps');
        const status = document.getElementById('secure-status');
        const demoStatus = document.getElementById('demo-status');
        
        for (let i = 0; i < secureFiles.length; i++) {
            if (!isRunning) return;
            
            const file = secureFiles[i];
            const el = createFileElement(file, true);
            container.appendChild(el);
            
            status.innerHTML = `<i class="fas fa-search mr-1"></i>Validating ${file.name}...`;
            status.className = 'absolute bottom-2 left-1/2 -translate-x-1/2 px-3 py-1 text-xs font-medium text-amber-200';
            if (demoStatus) demoStatus.textContent = `Validating ${file.name} with secure checks...`;
            
            await new Promise(r => {
                const t = setTimeout(r, 800 / animationSpeed);
                animationTimeouts.push(t);
            });
            
            // Show validation steps
            validationSteps.style.opacity = '1';
            
            // Animate file moving toward shield
            el.classList.remove('file-floating');
            el.classList.add('file-moving-secure');
            
            await new Promise(r => {
                const t = setTimeout(r, 1500 / animationSpeed);
                animationTimeouts.push(t);
            });
            
            if (file.type === 'danger') {
                // Block malicious file
                status.innerHTML = `<i class="fas fa-shield-alt mr-1"></i>BLOCKED: ${file.name} - Invalid file type!`;
                status.className = 'absolute bottom-2 left-1/2 -translate-x-1/2 px-3 py-1 text-xs font-medium text-rose-400';
                shield.classList.add('shield-block');
                if (demoStatus) demoStatus.innerHTML = `<i class="fas fa-check mr-1"></i>Security shield blocked malicious file: ${file.name}`;
                createWarningX(shield);
                
                await new Promise(r => {
                    const t = setTimeout(r, 800 / animationSpeed);
                    animationTimeouts.push(t);
                });
                
                shield.classList.remove('shield-block');
            } else {
                // Allow safe file
                status.innerHTML = `<i class="fas fa-check mr-1"></i>${file.name} → Renamed & stored securely`;
                status.className = 'absolute bottom-2 left-1/2 -translate-x-1/2 px-3 py-1 text-xs font-medium text-emerald-400';
                if (demoStatus) demoStatus.innerHTML = `<i class="fas fa-check mr-1"></i>${file.name} passed all security checks and was stored safely`;
                createCheckMark(shield);
            }
            
            el.remove();
            validationSteps.style.opacity = '0';
            
            await new Promise(r => {
                const t = setTimeout(r, 1500 / animationSpeed);
                animationTimeouts.push(t);
            });
        }
        
        status.innerHTML = '<i class="fas fa-lock mr-1"></i>All files processed securely!';
        status.className = 'absolute bottom-2 left-1/2 -translate-x-1/2 px-3 py-1 text-xs font-medium text-emerald-400';
        if (demoStatus) demoStatus.textContent = 'Secure server processed all files safely - malicious files were blocked';
    }

    // Start demo
    async function startDemo() {
        if (isRunning) return;
        
        resetDemo();
        isRunning = true;
        
        const demoStatus = document.getElementById('demo-status');
        if (demoStatus) demoStatus.textContent = 'Demo started - observing file upload behaviors...';
        
        // Run both demos in parallel
        await Promise.all([
            runUnsafeDemo(),
            runSecureDemo()
        ]);
        
        isRunning = false;
        if (demoStatus) demoStatus.textContent = 'Demo completed - Compare the results above';
        
        // If autoplay is enabled, restart after delay
        if (autoPlay) {
            const t = setTimeout(() => {
                if (autoPlay) startDemo();
            }, 3000);
            animationTimeouts.push(t);
        }
    }

    // Toggle autoplay
    function toggleAutoPlay() {
        autoPlay = !autoPlay;
        const btn = document.getElementById('autoplay-btn');
        const demoStatus = document.getElementById('demo-status');
        
        if (autoPlay) {
            if (btn) {
                btn.innerHTML = '<span class="text-xl mr-2"><i class="fas fa-pause"></i></span><span class="font-medium">Disable Auto-Play</span>';
                btn.className = 'control-btn px-8 py-4 bg-indigo-600 hover:bg-indigo-500 text-white rounded-lg transition-all duration-300 shadow-lg flex items-center gap-3';
            }
            if (demoStatus) demoStatus.textContent = 'Auto-play enabled - demo will loop continuously';
            if (!isRunning) startDemo();
        } else {
            if (btn) {
                btn.innerHTML = '<span class="text-xl mr-2"><i class="fas fa-sync-alt"></i></span><span class="font-medium">Enable Auto-Play</span>';
                btn.className = 'control-btn px-8 py-4 bg-indigo-600 hover:bg-indigo-500 text-white rounded-lg transition-all duration-300 shadow-lg flex items-center gap-3';
            }
            if (demoStatus) demoStatus.textContent = 'Auto-play disabled - manual control only';
        }
    }

    // Speed control
    function speedUp() {
        const speeds = [1, 1.5, 2, 0.5];
        const speedLabels = ['Normal', 'Fast', 'Very Fast', 'Slow'];
        const currentIndex = speeds.indexOf(animationSpeed);
        const nextIndex = (currentIndex + 1) % speeds.length;
        
        animationSpeed = speeds[nextIndex];
        const btn = document.getElementById('speed-btn');
        if (btn) btn.innerHTML = `<span class="text-xl mr-2"><i class="fas fa-bolt"></i></span><span class="font-medium">Speed: ${speedLabels[nextIndex]}</span>`;
        
        const demoStatus = document.getElementById('demo-status');
        if (demoStatus) demoStatus.textContent = `Animation speed set to ${speedLabels[nextIndex]}`;
    }

    // Initialize
    document.addEventListener('DOMContentLoaded', function() {
        // Start demo automatically after a short delay
        const t = setTimeout(() => {
            startDemo();
            autoPlay = true;
            const autoplayBtn = document.getElementById('autoplay-btn');
            if (autoplayBtn) {
                autoplayBtn.innerHTML = '<span class="text-xl mr-2"><i class="fas fa-pause"></i></span><span class="font-medium">Disable Auto-Play</span>';
                autoplayBtn.className = 'control-btn px-8 py-4 bg-indigo-600 hover:bg-indigo-500 text-white rounded-lg transition-all duration-300 shadow-lg flex items-center gap-3';
            }
        }, 1000);
        animationTimeouts.push(t);
    });
</script>

<?php include __DIR__ . '/../components/footer.php'; ?>