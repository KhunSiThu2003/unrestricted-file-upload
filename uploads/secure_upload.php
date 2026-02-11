<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../auth.php';

require_login();

include __DIR__ . '/../components/header.php';
?>
<section class="w-full mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">

    <div class="w-full glass-card rounded overflow-hidden border border-emerald-500/20 bg-neutral-900/40">
                <!-- Panel Header -->
                <div class="px-6 py-4 sm:px-8 sm:py-6 border-b border-emerald-500/10 bg-emerald-900/10">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded bg-emerald-600 flex items-center justify-center">
                                <i class="fas fa-lock text-white"></i>
                            </div>
                            <div>
                                <h2 class="text-xl font-bold text-emerald-300">Hardened Upload Endpoint</h2>
                                <p class="text-xs text-emerald-400/70">Multiple security layers enabled</p>
                            </div>
                        </div>
                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-emerald-500/15 text-emerald-300 border border-emerald-500/30 text-sm font-medium">
                            <i class="fas fa-check-circle text-xs"></i>
                            Security Verified
                        </span>
                    </div>
                </div>

                <!-- Upload Form -->
                <div class="p-6 sm:p-8">
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-white mb-2">Upload Profile Picture</h3>
                        <p class="text-sm text-gray-400">
                            Select an image file (JPG or PNG) to securely upload as your profile picture.
                            The file will undergo multiple security checks before being stored.
                        </p>
                    </div>

                    <form id="secure-upload-form" class="space-y-6">
                        <!-- File Upload Area -->
                        <div class="border-2 border-dashed border-emerald-500/20 rounded p-6 sm:p-8 text-center hover:border-emerald-500/40 transition-colors duration-300 bg-neutral-900/30">
                            <div class="mx-auto w-12 h-12 mb-4 rounded-full bg-emerald-500/10 flex items-center justify-center">
                                <i class="fas fa-cloud-upload-alt text-emerald-400 text-xl"></i>
                            </div>
                            
                            <input id="secure_file" name="file" type="file" accept=".jpg,.jpeg,.png,image/jpeg,image/png" 
                                   class="hidden" onchange="updateFileName(this)">
                            
                            <label for="secure_file" class="cursor-pointer block">
                                <h4 class="text-lg font-medium text-white mb-2">Drop your file here or click to browse</h4>
                                <p class="text-sm text-gray-400 mb-4">Supported formats: JPG, PNG (Max 2MB)</p>
                                <div class="inline-flex items-center gap-2 px-4 py-2 rounded bg-emerald-600 hover:bg-emerald-500 text-white font-medium transition-all duration-300 border border-emerald-500/30">
                                    <i class="fas fa-folder-open"></i>
                                    <span>Choose File</span>
                                </div>
                            </label>
                            
                            <!-- Selected file display -->
                            <div id="selected-file" class="mt-4 hidden">
                                <div class="inline-flex items-center gap-3 px-4 py-2 rounded bg-emerald-900/30 border border-emerald-500/20">
                                    <i class="fas fa-file-image text-emerald-400"></i>
                                    <span id="file-name" class="text-sm text-gray-300"></span>
                                    <button type="button" onclick="clearFileSelection()" class="text-gray-400 hover:text-white">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Security Checks Preview -->
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                            <div class="bg-neutral-900/40 rounded p-3 text-center border border-emerald-500/10">
                                <div class="w-8 h-8 mx-auto mb-2 rounded-full bg-emerald-500/10 flex items-center justify-center">
                                    <i class="fas fa-expand-arrows-alt text-emerald-400 text-sm"></i>
                                </div>
                                <p class="text-xs font-medium text-white">Size Check</p>
                                <p class="text-xs text-gray-400">≤ 2MB</p>
                            </div>
                            <div class="bg-neutral-900/40 rounded p-3 text-center border border-emerald-500/10">
                                <div class="w-8 h-8 mx-auto mb-2 rounded-full bg-emerald-500/10 flex items-center justify-center">
                                    <i class="fas fa-file-signature text-emerald-400 text-sm"></i>
                                </div>
                                <p class="text-xs font-medium text-white">MIME Type</p>
                                <p class="text-xs text-gray-400">Verified</p>
                            </div>
                            <div class="bg-neutral-900/40 rounded p-3 text-center border border-emerald-500/10">
                                <div class="w-8 h-8 mx-auto mb-2 rounded-full bg-emerald-500/10 flex items-center justify-center">
                                    <i class="fas fa-shield-alt text-emerald-400 text-sm"></i>
                                </div>
                                <p class="text-xs font-medium text-white">Extension</p>
                                <p class="text-xs text-gray-400">Whitelisted</p>
                            </div>
                            <div class="bg-neutral-900/40 rounded p-3 text-center border border-emerald-500/10">
                                <div class="w-8 h-8 mx-auto mb-2 rounded-full bg-emerald-500/10 flex items-center justify-center">
                                    <i class="fas fa-random text-emerald-400 text-sm"></i>
                                </div>
                                <p class="text-xs font-medium text-white">File Name</p>
                                <p class="text-xs text-gray-400">Randomized</p>
                            </div>
                        </div>

                        <!-- Upload Button -->
                        <button type="submit" 
                                class="w-full inline-flex items-center justify-center gap-2 px-6 py-3 rounded bg-emerald-600 hover:bg-emerald-500 text-white font-semibold transition-all duration-300 border border-emerald-500/30">
                            <i class="fas fa-cloud-upload-alt text-lg"></i>
                            <span>Upload Securely</span>
                        </button>
                    </form>
                </div>
            </div>
</section>

<!-- Toast Container -->
<div id="toast-container" class="fixed bottom-4 right-4 sm:top-4 sm:right-4 space-y-2 z-50 max-w-xs sm:max-w-sm"></div>

<!-- Upload Progress Modal -->
<div id="upload-progress" class="fixed inset-0 bg-black/70 flex items-center justify-center z-50 hidden">
    <div class="glass-card rounded p-6 max-w-xs w-full mx-4 border border-emerald-500/30">
        <div class="text-center">
            <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-emerald-500/10 flex items-center justify-center">
                <i class="fas fa-cloud-upload-alt text-emerald-400 text-2xl"></i>
            </div>
            <h3 class="text-lg font-bold text-white mb-2">Uploading File</h3>
            <p class="text-sm text-gray-400 mb-4">Securely processing your image...</p>
            
            <!-- Progress Bar -->
            <div class="w-full bg-neutral-800 rounded-full h-2 mb-4">
                <div id="progress-bar" class="bg-emerald-500 h-2 rounded-full w-0 transition-all duration-300"></div>
            </div>
            
            <p id="progress-text" class="text-xs text-emerald-400">Initializing security checks...</p>
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
        document.getElementById('secure_file').value = '';
        document.getElementById('selected-file').classList.add('hidden');
    }
    
    // Drag and drop functionality
    const dropArea = document.querySelector('label[for="secure_file"]');
    
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, preventDefaults, false);
    });
    
    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }
    
    ['dragenter', 'dragover'].forEach(eventName => {
        dropArea.addEventListener(eventName, () => {
            dropArea.parentElement.classList.add('border-emerald-500/60', 'bg-emerald-900/20');
        }, false);
    });
    
    ['dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, () => {
            dropArea.parentElement.classList.remove('border-emerald-500/60', 'bg-emerald-900/20');
        }, false);
    });
    
    dropArea.addEventListener('drop', (e) => {
        const dt = e.dataTransfer;
        const fileInput = document.getElementById('secure_file');
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
            info: 'fas fa-info-circle'
        };
        
        const base = 'glass-card px-4 py-3 rounded shadow-lg flex items-start gap-3 animate-slide-in ';
        if (type === 'success') {
            toast.className = base + 'border-emerald-500/30 bg-emerald-900/80';
        } else if (type === 'error') {
            toast.className = base + 'border-rose-500/30 bg-rose-900/80';
        } else {
            toast.className = base + 'border-blue-500/30 bg-blue-900/80';
        }
        
        toast.innerHTML = `
            <i class="${icons[type]} text-lg ${type === 'success' ? 'text-emerald-400' : type === 'error' ? 'text-rose-400' : 'text-blue-400'} mt-0.5"></i>
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
        const form = document.getElementById('secure-upload-form');
        const progressModal = document.getElementById('upload-progress');
        const progressBar = document.getElementById('progress-bar');
        const progressText = document.getElementById('progress-text');
        
        if (!form) return;
        
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const fileInput = form.querySelector('input[type="file"]');
            
            if (!fileInput.files.length) {
                showToast('Please choose a file first.', 'error');
                return;
            }
            
            // Show progress modal
            progressModal.classList.remove('hidden');
            progressBar.style.width = '10%';
            progressText.textContent = 'Starting security checks...';
            
            const formData = new FormData();
            formData.append('file', fileInput.files[0]);
            
            try {
                // Simulate progress
                progressBar.style.width = '30%';
                progressText.textContent = 'Validating file extension...';
                
                await new Promise(resolve => setTimeout(resolve, 500));
                
                progressBar.style.width = '50%';
                progressText.textContent = 'Checking MIME type...';
                
                await new Promise(resolve => setTimeout(resolve, 500));
                
                progressBar.style.width = '70%';
                progressText.textContent = 'Verifying file size...';
                
                const res = await fetch('../upload_secure.php', {
                    method: 'POST',
                    body: formData
                });
                
                progressBar.style.width = '90%';
                progressText.textContent = 'Finalizing upload...';
                
                const data = await res.json();
                
                // Close progress modal
                setTimeout(() => {
                    progressModal.classList.add('hidden');
                    progressBar.style.width = '0%';
                }, 500);
                
                if (data.success) {
                    showToast(data.message || 'File uploaded securely!', 'success');
                    
                    // Clear file input
                    clearFileSelection();
                    
                    // Update profile picture if needed
                    if (data.newProfilePic) {
                        const imgs = document.querySelectorAll('img[alt="Profile Picture"]');
                        imgs.forEach(img => {
                            img.src = data.newProfilePic + '&cache=' + Date.now();
                        });
                    }
                } else {
                    showToast(data.error || 'Upload failed security checks.', 'error');
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
        
        .animate-slide-in {
            animation: slideIn 0.3s ease-out;
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