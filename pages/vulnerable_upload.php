<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../auth.php';

require_login();

include __DIR__ . '/../components/header.php';
?>
<section class="w-full mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">


    <div class="w-full glass-card rounded-2xl overflow-hidden border border-rose-500/30 bg-gradient-to-b from-neutral-900/50 to-neutral-900/30">
                <!-- Panel Header -->
                <div class="px-6 py-4 sm:px-8 sm:py-6 border-b border-rose-500/10 bg-gradient-to-r from-rose-900/10 to-rose-900/5">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-rose-600 to-rose-700 flex items-center justify-center">
                                <i class="fas fa-bug text-white"></i>
                            </div>
                            <div>
                                <h2 class="text-xl font-bold text-rose-300">Insecure Upload Endpoint</h2>
                                <p class="text-xs text-rose-400/70">Multiple security vulnerabilities present</p>
                            </div>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-rose-500/15 text-rose-300 border border-rose-500/30 text-sm font-medium">
                                <i class="fas fa-exclamation-triangle text-xs"></i>
                                High Risk
                            </span>
                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-orange-500/15 text-orange-300 border border-orange-500/30 text-sm font-medium">
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
                        <div class="border-2 border-dashed border-rose-500/30 rounded-2xl p-6 sm:p-8 text-center hover:border-rose-500/50 transition-colors duration-300 bg-neutral-900/30">
                            <div class="mx-auto w-12 h-12 mb-4 rounded-full bg-rose-500/10 flex items-center justify-center">
                                <i class="fas fa-cloud-upload-alt text-rose-400 text-xl"></i>
                            </div>
                            
                            <input id="vuln_file" name="file" type="file" 
                                   class="hidden" onchange="updateFileName(this)">
                            
                            <label for="vuln_file" class="cursor-pointer block">
                                <h4 class="text-lg font-medium text-white mb-2">Upload any file type (dangerous)</h4>
                                <p class="text-sm text-gray-400 mb-4">No restrictions: .php, .exe, .sh, etc. (Max 10MB)</p>
                                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-rose-600 hover:bg-rose-500 text-white font-medium transition-all duration-300 border border-rose-500/30">
                                    <i class="fas fa-file-upload"></i>
                                    <span>Choose File</span>
                                </div>
                            </label>
                            
                            <!-- Selected file display -->
                            <div id="selected-file" class="mt-4 hidden">
                                <div class="inline-flex items-center gap-3 px-4 py-2 rounded-lg bg-rose-900/30 border border-rose-500/20">
                                    <i class="fas fa-file text-rose-400"></i>
                                    <span id="file-name" class="text-sm text-gray-300"></span>
                                    <button type="button" onclick="clearFileSelection()" class="text-gray-400 hover:text-white">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Vulnerability Indicators -->
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                            <div class="bg-neutral-900/40 rounded-xl p-3 text-center border border-rose-500/10">
                                <div class="w-8 h-8 mx-auto mb-2 rounded-full bg-rose-500/10 flex items-center justify-center">
                                    <i class="fas fa-times-circle text-rose-400 text-sm"></i>
                                </div>
                                <p class="text-xs font-medium text-white">No Type Check</p>
                                <p class="text-xs text-rose-400">All files accepted</p>
                            </div>
                            <div class="bg-neutral-900/40 rounded-xl p-3 text-center border border-rose-500/10">
                                <div class="w-8 h-8 mx-auto mb-2 rounded-full bg-rose-500/10 flex items-center justify-center">
                                    <i class="fas fa-expand-arrows-alt text-rose-400 text-sm"></i>
                                </div>
                                <p class="text-xs font-medium text-white">Large Files</p>
                                <p class="text-xs text-rose-400">Up to 10MB</p>
                            </div>
                            <div class="bg-neutral-900/40 rounded-xl p-3 text-center border border-rose-500/10">
                                <div class="w-8 h-8 mx-auto mb-2 rounded-full bg-rose-500/10 flex items-center justify-center">
                                    <i class="fas fa-file-code text-rose-400 text-sm"></i>
                                </div>
                                <p class="text-xs font-medium text-white">Executable Files</p>
                                <p class="text-xs text-rose-400">PHP, EXE allowed</p>
                            </div>
                            <div class="bg-neutral-900/40 rounded-xl p-3 text-center border border-rose-500/10">
                                <div class="w-8 h-8 mx-auto mb-2 rounded-full bg-rose-500/10 flex items-center justify-center">
                                    <i class="fas fa-folder-open text-rose-400 text-sm"></i>
                                </div>
                                <p class="text-xs font-medium text-white">Direct Access</p>
                                <p class="text-xs text-rose-400">Web-accessible</p>
                            </div>
                        </div>

                        <!-- Upload Button -->
                        <button type="submit" 
                                class="w-full group relative inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl bg-gradient-to-r from-rose-600 to-rose-700 hover:from-rose-500 hover:to-rose-600 text-white font-semibold transition-all duration-300 border border-rose-500/30 overflow-hidden">
                            <div class="absolute inset-0 bg-gradient-to-r from-rose-400/0 via-rose-400/10 to-rose-400/0 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-1000"></div>
                            <i class="fas fa-radiation text-lg relative z-10"></i>
                            <span class="relative z-10">Upload (Vulnerable)</span>
                        </button>
                    </form>

                    <!-- Uploaded File URL -->
                    <div id="vuln-upload-link-wrapper" class="mt-6 hidden">
                        <div class="bg-neutral-900/50 rounded-xl p-4 border border-rose-500/20">
                            <div class="flex items-center gap-2 mb-2">
                                <i class="fas fa-link text-rose-400"></i>
                                <h4 class="font-medium text-white">Uploaded File URL (Direct Access)</h4>
                            </div>
                            <div class="flex items-center gap-2">
                                <code id="vuln-upload-link" class="flex-1 text-sm text-rose-300 bg-neutral-800/50 px-3 py-2 rounded-lg break-all hover:text-rose-200 transition-colors"></code>
                                <button onclick="copyUrlToClipboard()" class="px-3 py-2 rounded-lg bg-rose-500/20 hover:bg-rose-500/30 text-rose-300 border border-rose-500/30 transition-colors">
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
<div id="upload-progress" class="fixed inset-0 bg-black/70 flex items-center justify-center z-50 hidden">
    <div class="glass-card rounded-2xl p-6 max-w-xs w-full mx-4 border border-rose-500/30">
        <div class="text-center">
            <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-rose-500/10 flex items-center justify-center">
                <i class="fas fa-radiation text-rose-400 text-2xl"></i>
            </div>
            <h3 class="text-lg font-bold text-white mb-2">Uploading (Vulnerable)</h3>
            <p class="text-sm text-rose-400 mb-4"> No security checks in progress...</p>
            
            <!-- Progress Bar -->
            <div class="w-full bg-neutral-800 rounded-full h-2 mb-4">
                <div id="progress-bar" class="bg-gradient-to-r from-rose-500 to-rose-400 h-2 rounded-full w-0 transition-all duration-300"></div>
            </div>
            
            <p id="progress-text" class="text-xs text-rose-400">Bypassing all security measures...</p>
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
        }
    }
    
    function clearFileSelection() {
        document.getElementById('vuln_file').value = '';
        document.getElementById('selected-file').classList.add('hidden');
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
        
        const base = 'glass-card px-4 py-3 rounded-xl shadow-lg flex items-start gap-3 animate-slide-in ';
        if (type === 'success') {
            toast.className = base + 'border-emerald-500/30 bg-gradient-to-r from-emerald-900/90 to-emerald-900/50';
        } else if (type === 'error') {
            toast.className = base + 'border-rose-500/30 bg-gradient-to-r from-rose-900/90 to-rose-900/50';
        } else if (type === 'warning') {
            toast.className = base + 'border-orange-500/30 bg-gradient-to-r from-orange-900/90 to-orange-900/50';
        } else {
            toast.className = base + 'border-blue-500/30 bg-gradient-to-r from-blue-900/90 to-blue-900/50';
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
        
        // Auto-remove after 5 seconds
        setTimeout(() => {
            toast.classList.add('opacity-0', 'translate-x-2');
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
            
            // Show progress modal
            progressModal.classList.remove('hidden');
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
                
                // Close progress modal
                setTimeout(() => {
                    progressModal.classList.add('hidden');
                    progressBar.style.width = '0%';
                }, 300);
                
                if (data.success) {
                    showToast('File uploaded (no security checks applied)', 'warning');
                    
                    if (data.storedAs) {
                        const origin = window.location.origin.replace(/\/$/, '');
                        const path = String(data.storedAs).replace(/^\//, '');
                        const fullUrl = origin + '/' + path;
                        
                        // Update URL display
                        if (linkWrapper && linkElement) {
                            linkElement.textContent = fullUrl;
                            linkElement.href = fullUrl;
                            linkWrapper.classList.remove('hidden');
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
                progressModal.classList.add('hidden');
                progressBar.style.width = '0%';
                showToast('Network error. Please try again.', 'error');
                console.error('Upload error:', err);
            }
        });
    })();
    
    // Add CSS animation for toast
    const style = document.createElement('style');
    style.textContent = `
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
            animation: slideIn 0.3s ease-out;
        }
        
        .animate-pulse-warning {
            animation: pulseWarning 2s infinite;
        }
        
        .glass-card {
            background: rgba(38, 38, 38, 0.7);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
    `;
    document.head.appendChild(style);
</script>

<?php include __DIR__ . '/../components/footer.php'; ?>