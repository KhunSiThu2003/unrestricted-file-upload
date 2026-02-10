<?php
?>
        <!-- Register panel -->
        <div id="panel-register" class="<?php echo $activeTab === 'register' ? '' : 'hidden'; ?> space-y-4">
            <form method="post" class="space-y-4">
                <input type="hidden" name="action" value="register">
                <div>
                    <label class="block text-sm mb-1 font-medium text-slate-700" for="name">Full name</label>
                    <input id="name" name="name" type="text"
                           class="w-full px-3 py-2 rounded-lg border border-slate-300 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                           required>
                </div>
                <div>
                    <label class="block text-sm mb-1 font-medium text-slate-700" for="email">Email</label>
                    <input id="email" name="email" type="email"
                           class="w-full px-3 py-2 rounded-lg border border-slate-300 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                           required>
                </div>
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm mb-1 font-medium text-slate-700" for="password">Password</label>
                        <input id="password" name="password" type="password"
                               class="w-full px-3 py-2 rounded-lg border border-slate-300 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                               required>
                    </div>
                    <div>
                        <label class="block text-sm mb-1 font-medium text-slate-700" for="confirm_password">Confirm Password</label>
                        <input id="confirm_password" name="confirm_password" type="password"
                               class="w-full px-3 py-2 rounded-lg border border-slate-300 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                               required>
                    </div>
                </div>
                <button type="submit"
                        class="w-full py-2.5 rounded-lg bg-emerald-600 hover:bg-emerald-500 text-sm font-medium text-white transition-colors">
                    Create Account
                </button>
            </form>
            <div class="mt-3 text-xs text-slate-500">
                <p><span class="font-semibold text-slate-700">Security Note:</span> A separate registration flow with
                    validation helps prevent account enumeration and encourages stronger passwords, which are common
                    weaknesses in authentication systems.</p>
            </div>
        </div>

