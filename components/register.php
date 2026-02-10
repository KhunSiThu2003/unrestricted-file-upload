<?php
?>
        <!-- Register panel -->
        <div id="panel-register" class="<?php echo $activeTab === 'register' ? '' : 'hidden'; ?> space-y-6">
            <form method="post" class="space-y-5">
                <input type="hidden" name="action" value="register">
                
                <div class="space-y-1">
                    <label class="block text-sm font-medium text-gray-300" for="name">
                        <div class="flex items-center gap-2 mb-1">
                            <i class="fas fa-user text-emerald-400 text-sm"></i>
                            <span>Full Name</span>
                        </div>
                    </label>
                    <div class="relative">
                        <input id="name" name="name" type="text"
                               class="w-full px-4 py-3 rounded-xl border border-white/10 bg-neutral-800 text-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all"
                               placeholder="John Doe"
                               required>
                        <div class="absolute right-3 top-3">
                            <i class="fas fa-user-circle text-gray-500 text-sm"></i>
                        </div>
                    </div>
                </div>
                
                <div class="space-y-1">
                    <label class="block text-sm font-medium text-gray-300" for="email">
                        <div class="flex items-center gap-2 mb-1">
                            <i class="fas fa-envelope text-emerald-400 text-sm"></i>
                            <span>Email Address</span>
                        </div>
                    </label>
                    <div class="relative">
                        <input id="email" name="email" type="email"
                               class="w-full px-4 py-3 rounded-xl border border-white/10 bg-neutral-800 text-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all"
                               placeholder="you@example.com"
                               required>
                        <div class="absolute right-3 top-3">
                            <i class="fas fa-at text-gray-500 text-sm"></i>
                        </div>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="block text-sm font-medium text-gray-300" for="password">
                            <div class="flex items-center gap-2 mb-1">
                                <i class="fas fa-lock text-emerald-400 text-sm"></i>
                                <span>Password</span>
                            </div>
                        </label>
                        <div class="relative">
                            <input id="password" name="password" type="password"
                                   class="w-full px-4 py-3 rounded-xl border border-white/10 bg-neutral-800 text-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all pr-10"
                                   placeholder="Create a password"
                                   required>
                            <button type="button" 
                                    class="absolute right-3 top-3 text-gray-500 hover:text-gray-300 transition-colors"
                                    onclick="togglePasswordVisibility('password', this)">
                                <i class="fas fa-eye text-sm"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div class="space-y-1">
                        <label class="block text-sm font-medium text-gray-300" for="confirm_password">
                            <div class="flex items-center gap-2 mb-1">
                                <i class="fas fa-lock text-emerald-400 text-sm"></i>
                                <span>Confirm Password</span>
                            </div>
                        </label>
                        <div class="relative">
                            <input id="confirm_password" name="confirm_password" type="password"
                                   class="w-full px-4 py-3 rounded-xl border border-white/10 bg-neutral-800 text-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all pr-10"
                                   placeholder="Confirm password"
                                   required>
                            <button type="button" 
                                    class="absolute right-3 top-3 text-gray-500 hover:text-gray-300 transition-colors"
                                    onclick="togglePasswordVisibility('confirm_password', this)">
                                <i class="fas fa-eye text-sm"></i>
                            </button>
                        </div>
                    </div>
                </div>
                
                <button type="submit"
                        class="w-full group relative py-3.5 rounded-xl bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-500 hover:to-emerald-600 text-white font-medium transition-all duration-300 overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-r from-emerald-400/0 via-emerald-400/10 to-emerald-400/0 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-1000"></div>
                    <div class="relative z-10 flex items-center justify-center gap-2">
                        <i class="fas fa-user-plus"></i>
                        <span>Create Secure Account</span>
                    </div>
                </button>
            </form>
            
            <!-- Security Notes -->
            <div class="rounded-xl border border-emerald-500/20 bg-gradient-to-r from-emerald-900/10 to-emerald-900/5 p-4">
                <div class="flex items-start gap-3">
                    <div class="w-6 h-6 rounded-full bg-emerald-500/20 flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-shield-alt text-emerald-400 text-sm"></i>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-emerald-300 mb-1">Security Implementation</p>
                        <p class="text-xs text-gray-400 leading-relaxed">
                            This registration flow uses <code class="bg-neutral-800 px-1 py-0.5 rounded text-emerald-300">password_hash()</code> for secure password storage,
                            separate validation to prevent account enumeration, and encourages strong passwords.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function togglePasswordVisibility(fieldId, button) {
    const field = document.getElementById(fieldId);
    const icon = button.querySelector('i');
    
    if (field.type === 'password') {
        field.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
        button.setAttribute('aria-label', 'Hide password');
    } else {
        field.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
        button.setAttribute('aria-label', 'Show password');
    }
}
</script>