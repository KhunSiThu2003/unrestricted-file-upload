<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../auth.php';

require_login();

if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: ../index.php');
    exit;
}

$user = get_authenticated_user($pdo);
if ($user === null) {
    session_destroy();
    header('Location: ../index.php');
    exit;
}

$profilePicUrl = null;
if (!empty($user['profile_image'])) {
    $profilePicUrl = '../uploads/' . htmlspecialchars($user['profile_image']);
}

// Format creation date if available
$createdAt = isset($user['created_at']) ? date('F j, Y', strtotime($user['created_at'])) : 'Unknown';

include __DIR__ . '/../components/header.php';
?>
<section class="w-full mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">
    <!-- Page Header -->
    <div class="mb-8 sm:mb-12">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded bg-indigo-600 flex items-center justify-center">
                    <i class="fas fa-user-circle text-white text-xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-white">User Profile</h1>
                    <p class="text-sm text-gray-400">Manage your account and security settings</p>
                </div>
            </div>
            
            <a href="?logout=1"
               class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded bg-rose-600 hover:bg-rose-500 text-white font-medium transition-all duration-300 border border-rose-500/30">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout Session</span>
            </a>
        </div>
        
    </div>

    <div class="w-full glass-card rounded overflow-hidden border border-indigo-500/20 bg-neutral-900/40">
                <!-- Card Header -->
                <div class="px-6 py-4 sm:px-8 sm:py-6 border-b border-indigo-500/10 bg-indigo-900/10">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded bg-indigo-600 flex items-center justify-center">
                            <i class="fas fa-id-card text-white"></i>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-white">Profile Information</h2>
                            <p class="text-xs text-indigo-400/70">Personal details and account data</p>
                        </div>
                    </div>
                </div>

                <!-- Profile Content -->
                <div class="p-6 sm:p-8">
                    <div class="flex flex-col md:flex-row gap-6 md:gap-8">
                        <!-- Profile Picture -->
                        <div class="md:w-1/3">
                            <div class="relative group">
                                <div class="relative">
                                    <?php if ($profilePicUrl): ?>
                                        <img src="<?php echo $profilePicUrl . '?cache=' . time(); ?>" 
                                             alt="Profile Picture"
                                             class="w-full aspect-square rounded object-cover border-2 border-indigo-500/30 shadow-lg group-hover:border-indigo-400/50 transition-all duration-300">
                                    <?php else: ?>
                                        <div class="w-full aspect-square rounded bg-neutral-800 border-2 border-indigo-500/30 flex items-center justify-center shadow-lg group-hover:border-indigo-400/50 transition-all duration-300">
                                            <i class="fas fa-user-circle text-6xl text-gray-400"></i>
                                        </div>
                                    <?php endif; ?>
                                    <div class="absolute inset-0 rounded bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                </div>
                                
                                <div class="mt-4 text-center">
                                    <a href="secure_upload.php"
                                       class="inline-flex items-center gap-2 px-4 py-2 rounded bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-medium transition-all duration-300 border border-indigo-500/30">
                                        <i class="fas fa-camera"></i>
                                        <span>Change Picture</span>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Profile Details -->
                        <div class="md:w-2/3">
                            <div class="space-y-6">
                                <!-- User Info Card -->
                                <div class="bg-neutral-900/40 rounded p-5 border border-white/5">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div class="space-y-1">
                                            <div class="flex items-center gap-2 mb-2">
                                                <i class="fas fa-user text-indigo-400 text-sm"></i>
                                                <span class="text-xs font-medium text-gray-400 uppercase tracking-wider">Full Name</span>
                                            </div>
                                            <p class="text-lg font-semibold text-white"><?php echo htmlspecialchars($user['name']); ?></p>
                                        </div>
                                        
                                        <div class="space-y-1">
                                            <div class="flex items-center gap-2 mb-2">
                                                <i class="fas fa-envelope text-indigo-400 text-sm"></i>
                                                <span class="text-xs font-medium text-gray-400 uppercase tracking-wider">Email Address</span>
                                            </div>
                                            <p class="text-lg font-semibold text-white break-all"><?php echo htmlspecialchars($user['email']); ?></p>
                                        </div>
                                        
                                        <div class="space-y-1">
                                            <div class="flex items-center gap-2 mb-2">
                                                <i class="fas fa-calendar-alt text-indigo-400 text-sm"></i>
                                                <span class="text-xs font-medium text-gray-400 uppercase tracking-wider">Member Since</span>
                                            </div>
                                            <p class="text-lg font-semibold text-white"><?php echo $createdAt; ?></p>
                                        </div>
                                        
                                        <div class="space-y-1">
                                            <div class="flex items-center gap-2 mb-2">
                                                <i class="fas fa-shield-alt text-indigo-400 text-sm"></i>
                                                <span class="text-xs font-medium text-gray-400 uppercase tracking-wider">Account Type</span>
                                            </div>
                                            <p class="text-lg font-semibold text-white">
                                                <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-indigo-500/15 text-indigo-300 text-xs font-medium">
                                                    Security Demo User
                                                </span>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Security Notes -->
                                <div class="bg-emerald-900/10 rounded p-5 border border-emerald-500/20">
                                    <div class="flex items-start gap-3">
                                        <div class="w-8 h-8 rounded-full bg-emerald-500/20 flex items-center justify-center flex-shrink-0">
                                            <i class="fas fa-shield-check text-emerald-400"></i>
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-emerald-300 mb-2">Security Implementation Notes</h4>
                                            <ul class="space-y-2 text-sm text-gray-300">
                                                <li class="flex items-start gap-2">
                                                    <i class="fas fa-check-circle text-emerald-400 text-xs mt-1"></i>
                                                    <span>Session-based authentication prevents unauthorized access</span>
                                                </li>
                                                <li class="flex items-start gap-2">
                                                    <i class="fas fa-check-circle text-emerald-400 text-xs mt-1"></i>
                                                    <span>User data loaded from database using session ID only</span>
                                                </li>
                                                <li class="flex items-start gap-2">
                                                    <i class="fas fa-check-circle text-emerald-400 text-xs mt-1"></i>
                                                    <span>All user inputs are properly escaped for display</span>
                                                </li>
                                                <li class="flex items-start gap-2">
                                                    <i class="fas fa-check-circle text-emerald-400 text-xs mt-1"></i>
                                                    <span>Profile pictures are stored with secure randomized names</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
</section>

<script>
    // Add hover effect to profile picture
    document.addEventListener('DOMContentLoaded', function() {
        const profilePic = document.querySelector('img[alt="Profile Picture"]');
        if (profilePic) {
            profilePic.addEventListener('mouseenter', function() {
                this.style.transform = 'scale(1.02)';
                this.style.transition = 'transform 0.3s ease';
            });
            
            profilePic.addEventListener('mouseleave', function() {
                this.style.transform = 'scale(1)';
            });
        }
        
        // Add cache busting to profile picture URL
        const updateProfilePic = function() {
            const img = document.querySelector('img[alt="Profile Picture"]');
            if (img) {
                const src = img.src.split('?')[0];
                img.src = src + '?cache=' + Date.now();
            }
        };
        
        // Listen for custom event from upload pages
        window.addEventListener('profilePictureUpdated', updateProfilePic);
    });
</script>

<?php include __DIR__ . '/../components/footer.php'; ?>