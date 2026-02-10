<?php
?>
<div class="mb-8 text-center">
    <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-br from-purple-500/20 to-indigo-600/20 border border-purple-500/30 mb-4">
        <i class="fas fa-shield-alt text-2xl text-purple-400"></i>
    </div>
    <h1 class="text-3xl sm:text-4xl font-bold bg-gradient-to-r from-purple-400 to-blue-400 bg-clip-text text-transparent mb-2">
        Secure Auth Lab
    </h1>
    <p class="text-gray-400 max-w-sm mx-auto text-sm leading-relaxed">
        Log in or create an account to explore secure vs vulnerable file upload implementations.
    </p>
</div>

<div class="glass-card rounded-2xl overflow-hidden border border-white/10 bg-gradient-to-b from-neutral-900/50 to-neutral-900/30 shadow-xl">
    <!-- Tab Navigation -->
    <div class="border-b border-white/5">
        <div class="flex p-1">
            <button type="button"
                    id="tab-login"
                    class="tab-button flex-1 px-4 py-3 rounded-lg text-sm font-medium transition-all duration-300 <?php echo $activeTab === 'login' ? 'bg-gradient-to-r from-purple-600 to-indigo-700 text-white shadow-lg' : 'text-gray-500 hover:text-gray-300 hover:bg-white/5'; ?>"
                    data-tab="login">
                <div class="flex items-center justify-center gap-2">
                    <i class="fas fa-sign-in-alt text-sm"></i>
                    <span>Login</span>
                </div>
            </button>
            <button type="button"
                    id="tab-register"
                    class="tab-button flex-1 px-4 py-3 rounded-lg text-sm font-medium transition-all duration-300 <?php echo $activeTab === 'register' ? 'bg-gradient-to-r from-emerald-600 to-emerald-700 text-white shadow-lg' : 'text-gray-500 hover:text-gray-300 hover:bg-white/5'; ?>"
                    data-tab="register">
                <div class="flex items-center justify-center gap-2">
                    <i class="fas fa-user-plus text-sm"></i>
                    <span>Register</span>
                </div>
            </button>
        </div>
    </div>

    <div class="p-6 sm:p-8">
        <!-- Error/Success Messages -->
        <?php if (!empty($errors)): ?>
            <div class="mb-6 rounded-xl border border-rose-500/30 bg-gradient-to-r from-rose-900/20 to-rose-900/10 p-4">
                <div class="flex items-start gap-3">
                    <div class="w-6 h-6 rounded-full bg-rose-500/20 flex items-center justify-center flex-shrink-0 mt-0.5">
                        <i class="fas fa-exclamation-circle text-rose-400 text-sm"></i>
                    </div>
                    <div class="space-y-1">
                        <?php foreach ($errors as $error): ?>
                            <p class="text-sm text-rose-300"><?php echo htmlspecialchars($error); ?></p>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div class="mb-6 rounded-xl border border-emerald-500/30 bg-gradient-to-r from-emerald-900/20 to-emerald-900/10 p-4">
                <div class="flex items-start gap-3">
                    <div class="w-6 h-6 rounded-full bg-emerald-500/20 flex items-center justify-center flex-shrink-0 mt-0.5">
                        <i class="fas fa-check-circle text-emerald-400 text-sm"></i>
                    </div>
                    <p class="text-sm text-emerald-300"><?php echo htmlspecialchars($success); ?></p>
                </div>
            </div>
        <?php endif; ?>

        <!-- Login panel -->
        <div id="panel-login" class="<?php echo $activeTab === 'login' ? '' : 'hidden'; ?> space-y-6">
            <form method="post" class="space-y-5">
                <input type="hidden" name="action" value="login">
                
                <div class="space-y-1">
                    <label class="block text-sm font-medium text-gray-300" for="login_email">
                        <div class="flex items-center gap-2 mb-1">
                            <i class="fas fa-envelope text-purple-400 text-sm"></i>
                            <span>Email Address</span>
                        </div>
                    </label>
                    <div class="relative">
                        <input id="login_email" name="login_email" type="email"
                               class="w-full px-4 py-3 rounded-xl border border-white/10 bg-neutral-800 text-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all"
                               placeholder="you@example.com"
                               required>
                        <div class="absolute right-3 top-3">
                            <i class="fas fa-at text-gray-500 text-sm"></i>
                        </div>
                    </div>
                </div>
                
                <div class="space-y-1">
                    <label class="block text-sm font-medium text-gray-300" for="login_password">
                        <div class="flex items-center gap-2 mb-1">
                            <i class="fas fa-lock text-purple-400 text-sm"></i>
                            <span>Password</span>
                        </div>
                    </label>
                    <div class="relative">
                        <input id="login_password" name="login_password" type="password"
                               class="w-full px-4 py-3 rounded-xl border border-white/10 bg-neutral-800 text-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all pr-10"
                               placeholder="Enter your password"
                               required>
                        <button type="button" 
                                class="absolute right-3 top-3 text-gray-500 hover:text-gray-300 transition-colors"
                                onclick="togglePasswordVisibility('login_password', this)">
                            <i class="fas fa-eye text-sm"></i>
                        </button>
                    </div>
                </div>
                
                <button type="submit"
                        class="w-full group relative py-3.5 rounded-xl bg-gradient-to-r from-purple-600 to-indigo-700 hover:from-purple-500 hover:to-indigo-600 text-white font-medium transition-all duration-300 overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-r from-purple-400/0 via-purple-400/10 to-purple-400/0 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-1000"></div>
                    <div class="relative z-10 flex items-center justify-center gap-2">
                        <i class="fas fa-sign-in-alt"></i>
                        <span>Sign In to Dashboard</span>
                    </div>
                </button>
            </form>
            
            <!-- Demo Credentials -->
            <div class="rounded-xl border border-blue-500/20 bg-gradient-to-r from-blue-900/10 to-blue-900/5 p-4">
                <div class="flex items-start gap-3">
                    <div class="w-6 h-6 rounded-full bg-blue-500/20 flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-info-circle text-blue-400 text-sm"></i>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-white mb-1">Demo Credentials</p>
                        <p class="text-xs text-gray-400">Use any registered email/password. Demo data resets periodically.</p>
                    </div>
                </div>
            </div>
        </div>