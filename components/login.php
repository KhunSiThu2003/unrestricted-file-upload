<?php
?>
<div class="relative group">
    <div class="absolute -inset-1 bg-indigo-600 rounded blur opacity-25 group-hover:opacity-40 transition duration-1000"></div>
    <div class="glass-panel relative rounded p-6 overflow-hidden backdrop-blur-xl">

        <!-- Error/Success Messages (dashboard badge style) -->
        <?php if (!empty($errors)): ?>
            <div class="mb-6 warning-badge rounded p-4">
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
            <div class="mb-6 info-badge rounded p-4">
                <div class="flex items-start gap-3">
                    <div class="w-6 h-6 rounded-full bg-indigo-500/20 flex items-center justify-center flex-shrink-0 mt-0.5">
                        <i class="fas fa-check-circle text-indigo-400 text-sm"></i>
                    </div>
                    <p class="text-sm text-indigo-300"><?php echo htmlspecialchars($success); ?></p>
                </div>
            </div>
        <?php endif; ?>

        <!-- Login panel -->
        <div id="panel-login" class="<?php echo $activeTab === 'login' ? '' : 'hidden'; ?> space-y-5">
            <h2 class="text-xl font-bold text-indigo-300 mb-6">Sign in</h2>
            <form method="post" class="space-y-5">
                <input type="hidden" name="action" value="login">

                <div class="space-y-1">
                    <label class="block text-sm font-medium text-gray-300" for="login_email">
                        <div class="flex items-center gap-2 mb-1">
                            <i class="fas fa-envelope text-indigo-400 text-sm"></i>
                            <span>Email Address</span>
                        </div>
                    </label>
                    <input id="login_email" name="login_email" type="email"
                           class="w-full px-4 py-3 rounded border border-white/10 bg-neutral-800/80 text-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
                           placeholder="you@example.com"
                           required>
                </div>

                <div class="space-y-1">
                    <label class="block text-sm font-medium text-gray-300" for="login_password">
                        <div class="flex items-center gap-2 mb-1">
                            <i class="fas fa-lock text-indigo-400 text-sm"></i>
                            <span>Password</span>
                        </div>
                    </label>
                    <div class="relative">
                        <input id="login_password" name="login_password" type="password"
                               class="w-full px-4 py-3 rounded border border-white/10 bg-neutral-800/80 text-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all pr-10"
                               placeholder="Enter your password"
                               required>
                        <button type="button"
                                class="absolute right-3 top-3 text-gray-500 hover:text-gray-300 transition-colors"
                                onclick="togglePasswordVisibility('login_password', this)">
                            <i class="fas fa-eye text-sm"></i>
                        </button>
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit"
                            class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 rounded text-indigo-300 hover:text-indigo-200 bg-indigo-500/10 hover:bg-indigo-500/20 border border-indigo-500/30 transition-all duration-200 font-medium">
                        <i class="fas fa-sign-in-alt"></i>
                        <span>Sign In</span>
                    </button>
                </div>
                <p class="text-center text-sm text-gray-400 pt-2">
                    Don't have an account? <a href="#" class="tab-link text-indigo-400 hover:text-indigo-300 underline underline-offset-2" data-tab="register">Register</a>
                </p>
            </form>

        </div>