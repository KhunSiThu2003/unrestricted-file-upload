<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../auth.php';

require_login();

include __DIR__ . '/../components/header.php';
?>
<section class="w-full mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8 vuln-page">
    <div class="w-full glass-card rounded overflow-hidden border border-rose-500/30 bg-neutral-900/40 vuln-card animate-card-in">
                <!-- Panel Header -->
                <div class="px-6 py-4 sm:px-8 sm:py-6 border-b border-rose-500/10 bg-rose-900/10">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded bg-rose-600 flex items-center justify-center vuln-header-icon">
                                <i class="fas fa-bug text-white"></i>
                            </div>
                            <div>
                                <h2 class="text-xl font-bold text-rose-300">Insecure Upload Endpoint</h2>
                                <p class="text-xs text-rose-400/70">Multiple security vulnerabilities present</p>
                            </div>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            <span class="badge-pulse inline-flex items-center gap-1 px-3 py-1 rounded-full bg-rose-500/15 text-rose-300 border border-rose-500/30 text-sm font-medium">
                                <i class="fas fa-exclamation-triangle text-xs"></i>
                                High Risk
                            </span>
                            <span class="badge-pulse badge-pulse-delay inline-flex items-center gap-1 px-3 py-1 rounded-full bg-orange-500/15 text-orange-300 border border-orange-500/30 text-sm font-medium">
                                <i class="fas fa-radiation text-xs"></i>
                                Vulnerable
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Upload Form -->
                <div class="p-6 sm:p-8">
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-white mb-2">Upload Any File (No Restrictions)</h3>
                        <p class="text-sm text-gray-400">
                            This endpoint accepts <span class="font-bold text-rose-300">any file type</span> without validation.
                            Files are stored with original names in a web-accessible directory.
                        </p>
                    </div>

                    <form id="vuln-upload-form" class="space-y-6">
                        <!-- File Upload Area -->
                        <div class="drop-zone border-2 border-dashed border-rose-500/30 rounded p-6 sm:p-8 text-center hover:border-rose-500/50 transition-all duration-300 bg-neutral-900/30 hover:bg-rose-900/10">
                            <div class="mx-auto w-12 h-12 mb-4 rounded-full bg-rose-500/10 flex items-center justify-center drop-zone-icon">
                                <i class="fas fa-cloud-upload-alt text-rose-400 text-xl"></i>
                            </div>
                            
                            <input id="vuln_file" name="file" type="file" 
                                   class="hidden" onchange="updateFileName(this)">
                            
                            <label for="vuln_file" class="cursor-pointer block">
                                <h4 class="text-lg font-medium text-white mb-2">Upload any file type (dangerous)</h4>
                                <p class="text-sm text-gray-400 mb-4">No restrictions: .php, .exe, .sh, etc. (Max 10MB)</p>
                                <div class="btn-choose inline-flex items-center gap-2 px-4 py-2 rounded bg-rose-600 hover:bg-rose-500 text-white font-medium transition-all duration-300 border border-rose-500/30 active:scale-95">
                                    <i class="fas fa-file-upload btn-choose-icon"></i>
                                    <span>Choose File</span>
                                </div>
                            </label>
                            
                            <!-- Selected file display -->
                            <div id="selected-file" class="mt-4 hidden selected-file-wrap">
                                <div class="inline-flex items-center gap-3 px-4 py-2 rounded bg-rose-900/30 border border-rose-500/20 selected-file-inner">
                                    <i class="fas fa-file text-rose-400"></i>
                                    <span id="file-name" class="text-sm text-gray-300"></span>
                                    <button type="button" onclick="clearFileSelection()" class="text-gray-400 hover:text-white">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Vulnerability Indicators -->
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 vuln-indicators">
                            <div class="vuln-indicator bg-neutral-900/40 rounded p-3 text-center border border-rose-500/10">
                                <div class="w-8 h-8 mx-auto mb-2 rounded-full bg-rose-500/10 flex items-center justify-center">
                                    <i class="fas fa-times-circle text-rose-400 text-sm"></i>
                                </div>
                                <p class="text-xs font-medium text-white">No Type Check</p>
                                <p class="text-xs text-rose-400">All files accepted</p>
                            </div>
                            <div class="vuln-indicator vuln-indicator-2 bg-neutral-900/40 rounded p-3 text-center border border-rose-500/10">
                                <div class="w-8 h-8 mx-auto mb-2 rounded-full bg-rose-500/10 flex items-center justify-center">
                                    <i class="fas fa-expand-arrows-alt text-rose-400 text-sm"></i>
                                </div>
                                <p class="text-xs font-medium text-white">Large Files</p>
                                <p class="text-xs text-rose-400">Up to 10MB</p>
                            </div>
                            <div class="vuln-indicator vuln-indicator-3 bg-neutral-900/40 rounded p-3 text-center border border-rose-500/10">
                                <div class="w-8 h-8 mx-auto mb-2 rounded-full bg-rose-500/10 flex items-center justify-center">
                                    <i class="fas fa-file-code text-rose-400 text-sm"></i>
                                </div>
                                <p class="text-xs font-medium text-white">Executable Files</p>
                                <p class="text-xs text-rose-400">PHP, EXE allowed</p>
                            </div>
                            <div class="vuln-indicator vuln-indicator-4 bg-neutral-900/40 rounded p-3 text-center border border-rose-500/10">
                                <div class="w-8 h-8 mx-auto mb-2 rounded-full bg-rose-500/10 flex items-center justify-center">
                                    <i class="fas fa-folder-open text-rose-400 text-sm"></i>
                                </div>
                                <p class="text-xs font-medium text-white">Direct Access</p>
                                <p class="text-xs text-rose-400">Web-accessible</p>
                            </div>
                        </div>

                        <!-- Upload Button -->
                        <button type="submit" 
                                class="btn-upload w-full inline-flex items-center justify-center gap-2 px-6 py-3 rounded bg-rose-600 hover:bg-rose-500 text-white font-semibold transition-all duration-300 border border-rose-500/30 active:scale-[0.98]">
                            <i class="fas fa-radiation text-lg btn-upload-icon"></i>
                            <span>Upload (Vulnerable)</span>
                        </button>
                    </form>

                    <!-- Uploaded File URL -->
                    <div id="vuln-upload-link-wrapper" class="mt-6 hidden link-wrapper">
                        <div class="link-wrapper-inner bg-neutral-900/50 rounded p-4 border border-rose-500/20">
                            <div class="flex items-center gap-2 mb-2">
                                <i class="fas fa-link text-rose-400"></i>
                                <h4 class="font-medium text-white">Uploaded File URL (Direct Access)</h4>
                            </div>
                            <div class="flex items-center gap-2">
                                <code id="vuln-upload-link" class="flex-1 text-sm text-rose-300 bg-neutral-800/50 px-3 py-2 rounded break-all hover:text-rose-200 transition-colors"></code>
                                <button onclick="copyUrlToClipboard()" class="px-3 py-2 rounded bg-rose-500/20 hover:bg-rose-500/30 text-rose-300 border border-rose-500/30 transition-colors">
                                    <i class="fas fa-copy"></i>
                                </button>
                            </div>
                            <p class="text-xs text-gray-400 mt-2">
                                 This file is directly accessible from the web. Attackers could exploit this to execute malicious code.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
</section>

<!-- Toast Container -->
<div id="toast-container" class="fixed bottom-4 right-4 sm:top-4 sm:right-4 space-y-2 z-50 max-w-xs sm:max-w-sm"></div>

<!-- Upload Progress Modal -->
<div id="upload-progress" class="progress-overlay fixed inset-0 bg-black/70 flex items-center justify-center z-50 hidden">
    <div class="progress-modal glass-card rounded p-6 max-w-xs w-full mx-4 border border-rose-500/30">
        <div class="text-center">
            <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-rose-500/10 flex items-center justify-center progress-icon-wrap">
                <i class="fas fa-radiation text-rose-400 text-2xl progress-icon"></i>
            </div>
            <h3 class="text-lg font-bold text-white mb-2">Uploading (Vulnerable)</h3>
            <p class="text-sm text-rose-400 mb-4"> No security checks in progress...</p>
            
            <!-- Progress Bar -->
            <div class="w-full bg-neutral-800 rounded-full h-2 mb-4 overflow-hidden">
                <div id="progress-bar" class="progress-bar-fill bg-rose-500 h-2 rounded-full w-0"></div>
            </div>
            
            <p id="progress-text" class="text-xs text-rose-400 progress-text">Bypassing all security measures...</p>
        </div>
    </div>
</div>

<script>
    // File selection handlers
    function updateFileName(input) {
        const fileNameDisplay = document.getElementById('file-name');
        const selectedFileDiv = document.getElementById('selected-file');
        
        if (input.files.length > 0) {
            const file = input.files[0];
            fileNameDisplay.textContent = file.name;
            selectedFileDiv.classList.remove('hidden');
            requestAnimationFrame(() => selectedFileDiv.classList.add('selected-file-visible'));
        }
    }
    
    function clearFileSelection() {
        const selectedFileDiv = document.getElementById('selected-file');
        document.getElementById('vuln_file').value = '';
        selectedFileDiv.classList.remove('selected-file-visible');
        setTimeout(() => selectedFileDiv.classList.add('hidden'), 280);
    }
    
    // Copy URL to clipboard
    function copyUrlToClipboard() {
        const urlElement = document.getElementById('vuln-upload-link');
        if (urlElement) {
            const url = urlElement.textContent;
            navigator.clipboard.writeText(url).then(() => {
                showToast('URL copied to clipboard!', 'info');
            }).catch(err => {
                console.error('Failed to copy URL:', err);
            });
        }
    }
    
    // Drag and drop functionality
    const dropArea = document.querySelector('label[for="vuln_file"]');
    
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, preventDefaults, false);
    });
    
    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }
    
    ['dragenter', 'dragover'].forEach(eventName => {
        dropArea.addEventListener(eventName, () => {
            dropArea.parentElement.classList.add('border-rose-500/60', 'bg-rose-900/20');
        }, false);
    });
    
    ['dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, () => {
            dropArea.parentElement.classList.remove('border-rose-500/60', 'bg-rose-900/20');
        }, false);
    });
    
    dropArea.addEventListener('drop', (e) => {
        const dt = e.dataTransfer;
        const fileInput = document.getElementById('vuln_file');
        fileInput.files = dt.files;
        updateFileName(fileInput);
    });
    
    // Toast notification system
    function showToast(message, type = 'success') {
        const container = document.getElementById('toast-container');
        const toast = document.createElement('div');
        
        const icons = {
            success: 'fas fa-check-circle',
            error: 'fas fa-exclamation-circle',
            info: 'fas fa-info-circle',
            warning: 'fas fa-exclamation-triangle'
        };
        
        const base = 'glass-card toast-item px-4 py-3 rounded shadow-lg flex items-start gap-3 animate-slide-in ';
        if (type === 'success') {
            toast.className = base + 'border-emerald-500/30 bg-emerald-900/80';
        } else if (type === 'error') {
            toast.className = base + 'border-rose-500/30 bg-rose-900/80';
        } else if (type === 'warning') {
            toast.className = base + 'border-orange-500/30 bg-orange-900/80';
        } else {
            toast.className = base + 'border-blue-500/30 bg-blue-900/80';
        }
        
        toast.innerHTML = `
            <i class="${icons[type] || 'fas fa-info-circle'} text-lg ${type === 'success' ? 'text-emerald-400' : type === 'error' ? 'text-rose-400' : type === 'warning' ? 'text-orange-400' : 'text-blue-400'} mt-0.5"></i>
            <div class="flex-1">
                <p class="text-sm text-white">${message}</p>
            </div>
            <button onclick="this.parentElement.remove()" class="text-gray-400 hover:text-white">
                <i class="fas fa-times text-sm"></i>
            </button>
        `;
        
        container.appendChild(toast);
        
        // Auto-remove after 5 seconds with exit animation
        setTimeout(() => {
            toast.classList.add('toast-exit');
            toast.addEventListener('transitionend', () => toast.remove());
        }, 5000);
    }
    
    // Upload form handler
    (function () {
        const form = document.getElementById('vuln-upload-form');
        const progressModal = document.getElementById('upload-progress');
        const progressBar = document.getElementById('progress-bar');
        const progressText = document.getElementById('progress-text');
        const linkWrapper = document.getElementById('vuln-upload-link-wrapper');
        const linkElement = document.getElementById('vuln-upload-link');
        
        if (!form) return;
        
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const fileInput = form.querySelector('input[type="file"]');
            
            if (!fileInput.files.length) {
                showToast('Please choose a file first.', 'warning');
                return;
            }
            
            // Show progress modal with animation
            progressModal.classList.remove('hidden');
            progressModal.classList.add('progress-overlay-visible');
            requestAnimationFrame(() => {
                progressModal.classList.add('progress-overlay-show');
            });
            progressBar.style.width = '10%';
            progressText.textContent = 'Skipping security checks...';
            
            const formData = new FormData();
            formData.append('file', fileInput.files[0]);
            
            try {
                // Simulate progress (faster than secure upload)
                progressBar.style.width = '40%';
                progressText.textContent = 'Storing with original filename...';
                
                await new Promise(resolve => setTimeout(resolve, 300));
                
                progressBar.style.width = '70%';
                progressText.textContent = 'Making file web-accessible...';
                
                const res = await fetch('../upload_vulnerable.php', {
                    method: 'POST',
                    body: formData
                });
                
                progressBar.style.width = '90%';
                progressText.textContent = 'Generating direct URL...';
                
                const data = await res.json();
                
                // Close progress modal with exit animation
                progressModal.classList.remove('progress-overlay-show');
                setTimeout(() => {
                    progressModal.classList.remove('progress-overlay-visible');
                    progressModal.classList.add('hidden');
                    progressBar.style.width = '0%';
                }, 280);
                
                if (data.success) {
                    showToast('File uploaded (no security checks applied)', 'warning');
                    
                    if (data.storedAs) {
                        const origin = window.location.origin.replace(/\/$/, '');
                        const path = String(data.storedAs).replace(/^\//, '');
                        const fullUrl = origin + '/' + path;
                        
                        // Update URL display with animation
                        if (linkWrapper && linkElement) {
                            linkElement.textContent = fullUrl;
                            linkElement.href = fullUrl;
                            linkWrapper.classList.remove('hidden');
                            requestAnimationFrame(() => linkWrapper.classList.add('link-wrapper-visible'));
                        }
                        
                        // Show warning about vulnerable URL
                        showToast('File is directly accessible at: ' + fullUrl, 'warning');
                    }
                    
                    // Clear file input
                    clearFileSelection();
                } else {
                    showToast(data.error || 'Upload failed.', 'error');
                }
            } catch (err) {
                progressModal.classList.remove('progress-overlay-show');
                setTimeout(() => {
                    progressModal.classList.remove('progress-overlay-visible');
                    progressModal.classList.add('hidden');
                    progressBar.style.width = '0%';
                }, 280);
                showToast('Network error. Please try again.', 'error');
                console.error('Upload error:', err);
            }
        });
    })();
    
    // Add CSS animations
    const style = document.createElement('style');
    style.textContent = `
        .glass-card {
            background: rgba(38, 38, 38, 0.7);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
        
        /* Page & card entrance */
        @keyframes cardIn {
            from {
                opacity: 0;
                transform: translateY(16px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .animate-card-in {
            animation: cardIn 0.45s cubic-bezier(0.22, 1, 0.36, 1) forwards;
        }
        
        /* Header icon subtle pulse */
        @keyframes iconPulse {
            0%, 100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(190, 18, 60, 0.3); }
            50% { transform: scale(1.02); box-shadow: 0 0 0 6px rgba(190, 18, 60, 0); }
        }
        .vuln-header-icon {
            animation: iconPulse 2.5s ease-in-out infinite;
        }
        
        /* Risk badges pulse */
        @keyframes badgePulse {
            0%, 100% { opacity: 1; box-shadow: 0 0 0 0 rgba(244, 63, 94, 0.25); }
            50% { opacity: 0.9; box-shadow: 0 0 0 4px rgba(244, 63, 94, 0); }
        }
        .badge-pulse {
            animation: badgePulse 2s ease-in-out infinite;
        }
        .badge-pulse-delay {
            animation-delay: 0.5s;
        }
        
        /* Drop zone & icon */
        .drop-zone {
            transition: border-color 0.3s, background 0.3s, transform 0.25s ease;
        }
        .drop-zone:hover {
            transform: translateY(-1px);
        }
        @keyframes dropZoneIcon {
            0%, 100% { transform: translateY(0); opacity: 0.9; }
            50% { transform: translateY(-3px); opacity: 1; }
        }
        .drop-zone:hover .drop-zone-icon {
            animation: dropZoneIcon 1.2s ease-in-out infinite;
        }
        
        /* Choose file button */
        .btn-choose {
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .btn-choose:hover {
            transform: scale(1.02);
            box-shadow: 0 4px 12px rgba(190, 18, 60, 0.25);
        }
        .btn-choose:hover .btn-choose-icon {
            animation: uploadIconWiggle 0.5s ease;
        }
        @keyframes uploadIconWiggle {
            0%, 100% { transform: rotate(0deg); }
            25% { transform: rotate(-8deg); }
            75% { transform: rotate(8deg); }
        }
        
        /* Selected file in/out */
        .selected-file-wrap {
            overflow: hidden;
            transition: opacity 0.28s ease, max-height 0.32s ease, margin 0.28s ease;
            max-height: 0;
            opacity: 0;
        }
        .selected-file-wrap.selected-file-visible {
            max-height: 80px;
            opacity: 1;
        }
        .selected-file-wrap:not(.selected-file-visible) .selected-file-inner {
            opacity: 0;
            transform: translateY(-8px);
        }
        .selected-file-inner {
            transition: opacity 0.25s ease 0.06s, transform 0.25s ease 0.06s;
        }
        .selected-file-wrap.selected-file-visible .selected-file-inner {
            opacity: 1;
            transform: translateY(0);
        }
        
        /* Vulnerability indicator cards - staggered appear */
        .vuln-indicator {
            opacity: 0;
            transform: translateY(10px);
            animation: vulnIndicatorIn 0.4s cubic-bezier(0.22, 1, 0.36, 1) forwards;
            transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s;
        }
        .vuln-indicator-2 { animation-delay: 0.06s; }
        .vuln-indicator-3 { animation-delay: 0.12s; }
        .vuln-indicator-4 { animation-delay: 0.18s; }
        .vuln-indicator:hover {
            transform: translateY(-2px);
            border-color: rgba(244, 63, 94, 0.25);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }
        @keyframes vulnIndicatorIn {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Upload button */
        .btn-upload:hover .btn-upload-icon {
            animation: radiationSpin 1.2s linear infinite;
        }
        @keyframes radiationSpin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        
        /* Link wrapper (after upload) */
        .link-wrapper {
            opacity: 0;
            transform: translateY(-8px);
            transition: opacity 0.3s ease, transform 0.3s ease;
        }
        .link-wrapper.link-wrapper-visible {
            opacity: 1;
            transform: translateY(0);
        }
        .link-wrapper-inner {
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .link-wrapper-inner:hover {
            border-color: rgba(244, 63, 94, 0.4);
            box-shadow: 0 0 0 1px rgba(244, 63, 94, 0.15);
        }
        
        /* Progress overlay */
        .progress-overlay {
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.25s ease, visibility 0.25s;
        }
        .progress-overlay.progress-overlay-visible {
            visibility: visible;
        }
        .progress-overlay.progress-overlay-show {
            opacity: 1;
        }
        .progress-overlay.progress-overlay-show .progress-modal {
            animation: progressModalIn 0.3s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
        }
        .progress-overlay:not(.progress-overlay-show) .progress-modal {
            transform: scale(0.9);
            opacity: 0;
            transition: transform 0.22s ease, opacity 0.22s ease;
        }
        @keyframes progressModalIn {
            from {
                opacity: 0;
                transform: scale(0.92) translateY(10px);
            }
            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }
        .progress-icon-wrap {
            animation: progressIconPulse 1.5s ease-in-out infinite;
        }
        @keyframes progressIconPulse {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.05); opacity: 0.85; }
        }
        .progress-bar-fill {
            transition: width 0.4s cubic-bezier(0.22, 1, 0.36, 1);
        }
        
        /* Toast */
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(100%);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        @keyframes pulseWarning {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }
        .animate-slide-in {
            animation: slideIn 0.35s cubic-bezier(0.22, 1, 0.36, 1);
        }
        .animate-pulse-warning {
            animation: pulseWarning 2s infinite;
        }
        .toast-item {
            transition: opacity 0.25s ease, transform 0.25s ease;
        }
        .toast-item.toast-exit {
            opacity: 0;
            transform: translateX(100%);
        }
    `;
    document.head.appendChild(style);
</script>

<?php include __DIR__ . '/../components/footer.php'; ?>