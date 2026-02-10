<?php
?>
<div class="mb-6 text-center">
    <h1 class="text-3xl font-semibold tracking-tight text-slate-900">Auth & Upload Demo</h1>
    <p class="mt-2 text-sm text-slate-600">Log in or create an account to explore secure vs vulnerable file uploads.</p>
</div>

<div class="bg-white border border-slate-200 rounded-2xl shadow-sm">
    <div class="border-b border-slate-200 px-4 pt-4">
        <div class="inline-flex rounded-full bg-slate-100 p-1 text-xs font-medium">
            <button type="button"
                    id="tab-login"
                    class="tab-button flex-1 px-4 py-2 rounded-full <?php echo $activeTab === 'login' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-500'; ?>"
                    data-tab="login">
                Login
            </button>
            <button type="button"
                    id="tab-register"
                    class="tab-button flex-1 px-4 py-2 rounded-full <?php echo $activeTab === 'register' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-500'; ?>"
                    data-tab="register">
                Register
            </button>
        </div>
    </div>

    <div class="px-6 pb-6 pt-4">
        <?php if (!empty($errors)): ?>
            <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-3 py-2 text-xs text-red-700">
                <?php foreach ($errors as $error): ?>
                    <div><?php echo htmlspecialchars($error); ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-3 py-2 text-xs text-emerald-700">
                <?php echo htmlspecialchars($success); ?>
            </div>
        <?php endif; ?>

        <!-- Login panel -->
        <div id="panel-login" class="<?php echo $activeTab === 'login' ? '' : 'hidden'; ?> space-y-4">
            <form method="post" class="space-y-4">
                <input type="hidden" name="action" value="login">
                <div>
                    <label class="block text-sm mb-1 font-medium text-slate-700" for="login_email">Email</label>
                    <input id="login_email" name="login_email" type="email"
                           class="w-full px-3 py-2 rounded-lg border border-slate-300 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500"
                           required>
                </div>
                <div>
                    <label class="block text-sm mb-1 font-medium text-slate-700" for="login_password">Password</label>
                    <input id="login_password" name="login_password" type="password"
                           class="w-full px-3 py-2 rounded-lg border border-slate-300 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500"
                           required>
                </div>
                <button type="submit"
                        class="w-full py-2.5 rounded-lg bg-sky-600 hover:bg-sky-500 text-sm font-medium text-white transition-colors">
                    Sign In
                </button>
            </form>
            <div class="mt-3 text-xs text-slate-500"></div>
        </div>
