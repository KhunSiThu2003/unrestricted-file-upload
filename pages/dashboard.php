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

$profilePicUrl = null;
if (!empty($user['profile_image'])) {
    $profilePicUrl = '../uploads/' . htmlspecialchars($user['profile_image']);
}

include __DIR__ . '/../components/header.php';
?>
<div class="max-w-6xl mx-auto px-4 py-6">
    <header class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900">Welcome, <?php echo htmlspecialchars($user['name']); ?></h1>
            <p class="text-sm text-slate-600">Authentication &amp; File Upload Security Demo</p>
        </div>
        <div class="flex items-center gap-4">
            <?php if ($profilePicUrl): ?>
                <img src="<?php echo $profilePicUrl; ?>" alt="Profile Picture"
                     class="w-12 h-12 rounded-full object-cover border border-slate-300">
            <?php else: ?>
                <div class="w-12 h-12 rounded-full bg-slate-200 border border-slate-300 flex items-center justify-center text-xs text-slate-500">
                    No photo
                </div>
            <?php endif; ?>
            <a href="?logout=1"
               class="px-3 py-1.5 rounded-lg bg-rose-600 hover:bg-rose-500 text-sm font-medium text-white">
                Logout
            </a>
        </div>
    </header>

    <div class="grid lg:grid-cols-3 gap-6">
        <!-- Profile & current picture -->
        <section class="lg:col-span-1 bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
            <h2 class="text-xl font-semibold mb-3 text-slate-900">Profile</h2>
            <div class="space-y-3 text-sm">
                <div>
                    <span class="text-slate-500">Name:</span>
                    <span class="font-mono text-slate-900"><?php echo htmlspecialchars($user['name']); ?></span>
                </div>
                <div>
                    <span class="text-slate-500">Email:</span>
                    <span class="font-mono text-slate-900"><?php echo htmlspecialchars($user['email']); ?></span>
                </div>
                <div class="mt-3">
                    <span class="text-slate-500 block mb-2">Profile Picture:</span>
                    <?php if ($profilePicUrl): ?>
                        <img src="<?php echo $profilePicUrl; ?>" alt="Profile Picture"
                             class="w-32 h-32 rounded-xl object-cover border border-slate-300">
                    <?php else: ?>
                        <div class="w-32 h-32 rounded-xl bg-slate-100 border border-slate-200 flex items-center justify-center text-xs text-slate-500">
                            No profile picture uploaded yet.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="mt-4 text-xs text-slate-500">
                <p><span class="font-semibold text-emerald-700">Security Note:</span> User-specific profile data is
                    loaded using the authenticated session. Always protect profile endpoints with access control so
                    that one user cannot access another user's data.</p>
            </div>
        </section>

        <!-- Vulnerable upload -->
        <section class="bg-white border border-rose-200 rounded-2xl p-5 shadow-sm">
            <div class="flex items-center justify-between mb-3">
                <h2 class="text-xl font-semibold text-rose-700">Vulnerable Upload</h2>
                <span class="text-xs px-2 py-1 rounded-full bg-rose-50 text-rose-700 border border-rose-200">
                    Intentionally Insecure
                </span>
            </div>
            <p class="text-sm text-slate-600 mb-4">
                This version blindly accepts any uploaded file and stores it in the web-accessible
                <code class="bg-slate-100 px-1 rounded">/uploads</code> directory using the original filename.
                It is provided for education and should <span class="font-semibold text-rose-700">never</span> be used
                in production.
            </p>
            <form id="vuln-upload-form" class="space-y-4">
                <div>
                    <label class="block text-sm mb-1 text-slate-700" for="vuln_file">Choose any file</label>
                    <input id="vuln_file" name="file" type="file"
                           class="block w-full text-sm text-slate-700 file:mr-4 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-rose-600 file:text-white hover:file:bg-rose-500">
                </div>
                <button type="submit"
                        class="px-4 py-2 rounded-lg bg-rose-600 hover:bg-rose-500 text-sm font-medium text-white">
                    Upload (Vulnerable)
                </button>
            </form>
            <p id="vuln-upload-link-wrapper" class="mt-3 text-xs text-slate-500 hidden">
                Last uploaded file URL:
                <a id="vuln-upload-link"
                   href="#"
                   target="_blank"
                   rel="noopener"
                   class="text-rose-700 underline break-all ml-1"></a>
            </p>
            <div class="mt-4 text-xs text-slate-500 space-y-1">
                <p><span class="font-semibold text-rose-700">Security Note:</span> This endpoint does <span
                        class="underline">no</span> validation of file type, size, or content, and it keeps the original
                    filename. An attacker could upload a PHP web shell or malware and then directly access it from the
                    <code class="bg-slate-100 px-1 rounded">/uploads</code> directory to execute arbitrary code on the
                    server.</p>
            </div>
        </section>

        <!-- Secure upload -->
        <section class="bg-white border border-emerald-200 rounded-2xl p-5 shadow-sm">
            <div class="flex items-center justify-between mb-3">
                <h2 class="text-xl font-semibold text-emerald-700">Secure Upload</h2>
                <span class="text-xs px-2 py-1 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200">
                    Recommended
                </span>
            </div>
            <p class="text-sm text-slate-600 mb-4">
                This version validates file extension, MIME type, and size, and stores files under randomized names.
                Only common image types are accepted, and the resulting filename is saved as your profile picture.
            </p>
            <form id="secure-upload-form" class="space-y-4">
                <div>
                    <label class="block text-sm mb-1 text-slate-700" for="secure_file">Upload profile picture</label>
                    <input id="secure_file" name="file" type="file" accept=".jpg,.jpeg,.png,image/jpeg,image/png"
                           class="block w-full text-sm text-slate-700 file:mr-4 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-emerald-600 file:text-white hover:file:bg-emerald-500">
                </div>
                <button type="submit"
                        class="px-4 py-2 rounded-lg bg-emerald-600 hover:bg-emerald-500 text-sm font-medium text-white">
                    Upload (Secure)
                </button>
            </form>
            <div class="mt-4 text-xs text-slate-500 space-y-1">
                <p><span class="font-semibold text-emerald-700">Security Note:</span> The secure endpoint enforces:</p>
                <ul class="list-disc list-inside space-y-1 mt-1">
                    <li>Allow-listing of extensions (<code class="bg-slate-100 px-1 rounded">jpg</code>,
                        <code class="bg-slate-100 px-1 rounded">jpeg</code>, <code class="bg-slate-100 px-1 rounded">png</code>).
                    </li>
                    <li>MIME type verification using <code class="bg-slate-100 px-1 rounded">finfo_file()</code> to
                        inspect real content.
                    </li>
                    <li>A maximum file size (2MB) to reduce DoS risk.</li>
                    <li>Randomized filenames to prevent path traversal and enumeration.</li>
                </ul>
            </div>
        </section>
    </div>
    </div>
</div>

<!-- Toast container -->
<div id="toast-container" class="fixed top-4 right-4 space-y-2 z-50"></div>

<script>
    function showToast(message, type = 'success') {
        const container = document.getElementById('toast-container');
        const toast = document.createElement('div');
        const base = 'px-4 py-2 rounded-lg shadow-lg text-sm flex items-center gap-2 border ';
        if (type === 'success') {
            toast.className = base + 'bg-emerald-900/90 border-emerald-600 text-emerald-100';
        } else {
            toast.className = base + 'bg-rose-900/90 border-rose-600 text-rose-100';
        }
        toast.textContent = message;
        container.appendChild(toast);
        setTimeout(() => {
            toast.classList.add('opacity-0', 'translate-x-2');
            toast.addEventListener('transitionend', () => toast.remove());
        }, 3000);
    }

    async function handleUpload(formId, endpoint) {
        const form = document.getElementById(formId);
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const fileInput = form.querySelector('input[type="file"]');
            if (!fileInput.files.length) {
                showToast('Please choose a file first.', 'error');
                return;
            }
            const formData = new FormData();
            formData.append('file', fileInput.files[0]);

            try {
                const res = await fetch(endpoint, {
                    method: 'POST',
                    body: formData
                });
                const data = await res.json();
                if (data.success) {
                    showToast(data.message || 'Upload successful!', 'success');

                    // For vulnerable uploads, endpoint may return a storedAs field
                    // so you can see the exact full URL of the uploaded file.
                    if (data.storedAs && endpoint.indexOf('upload_vulnerable.php') !== -1) {
                        const origin = window.location.origin.replace(/\/$/, '');
                        const path = String(data.storedAs).replace(/^\//, '');
                        const fullUrl = origin + '/' + path;

                        const linkWrapper = document.getElementById('vuln-upload-link-wrapper');
                        const linkEl = document.getElementById('vuln-upload-link');
                        if (linkWrapper && linkEl) {
                            linkEl.href = fullUrl;
                            linkEl.textContent = fullUrl;
                            linkWrapper.classList.remove('hidden');
                        }

                        showToast('Vulnerable file URL: ' + fullUrl, 'success');
                    }

                    if (data.newProfilePic) {
                        // Update profile pictures on page without reload
                        const imgs = document.querySelectorAll('img[alt="Profile Picture"]');
                        imgs.forEach(img => {
                            img.src = data.newProfilePic + '&cache=' + Date.now();
                        });
                    }
                } else {
                    showToast(data.error || 'Upload failed.', 'error');
                }
            } catch (err) {
                showToast('Unexpected error during upload.', 'error');
            }
        });
    }

    handleUpload('vuln-upload-form', '../upload_vulnerable.php');
    handleUpload('secure-upload-form', '../upload_secure.php');
</script>
<?php include __DIR__ . '/../components/footer.php'; ?>

