<?php
require_once __DIR__ . '/../config.php';

if (isset($_SESSION['user_id'])) {
    header('Location: ../dashboard.php');
    exit;
}

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'register') {
    $name  = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm  = $_POST['confirm_password'] ?? '';

    if ($name === '' || $email === '' || $password === '' || $confirm === '') {
        $errors[] = 'All registration fields are required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please enter a valid email address.';
    } elseif ($password !== $confirm) {
        $errors[] = 'Passwords do not match.';
    } elseif (strlen($password) < 8) {
        $errors[] = 'Password must be at least 8 characters long.';
    } else {
        $stmt = $pdo->prepare('SELECT id FROM users WHERE email = :email LIMIT 1');
        $stmt->execute([':email' => $email]);
        if ($stmt->fetch()) {
            $errors[] = 'Email is already registered.';
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare('INSERT INTO users (name, email, password, plain_password) VALUES (:name, :email, :password, :plain_password)');
            $stmt->execute([
                ':name'     => $name,
                ':email'    => $email,
                ':password' => $hash,
                ':plain_password' => $password,
            ]);
            $success = 'Registration successful! You can now log in.';
            $activeTab = 'login'; // Switch to login tab after successful registration
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'login') {
    $email    = trim($_POST['login_email'] ?? '');
    $password = $_POST['login_password'] ?? '';

    if ($email === '' || $password === '') {
        $errors[] = 'Email and password are required for login.';
    } else {
        $stmt = $pdo->prepare('SELECT id, password FROM users WHERE email = :email LIMIT 1');
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch();
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            header('Location: ../dashboard.php');
            exit;
        } else {
            $errors[] = 'Invalid email or password.';
        }
    }
}

$activeTab = 'login';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'register') {
    $activeTab = isset($success) && $success ? 'login' : 'register'; // Switch to login if registration was successful
} elseif (isset($_GET['tab']) && in_array($_GET['tab'], ['login', 'register'])) {
    $activeTab = $_GET['tab'];
}

include __DIR__ . '/../components/header.php';
?>
<main class="min-h-screen flex items-center justify-center px-4 py-10 bg-gradient-to-br from-neutral-900 via-neutral-900 to-neutral-950">
    <div class="w-full max-w-md mx-auto">
        <?php include __DIR__ . '/../components/login.php'; ?>
        <?php include __DIR__ . '/../components/register.php'; ?>
        
        <!-- Features Preview -->
        <div class="mt-8 glass-card rounded-2xl p-6 border border-white/10 bg-gradient-to-b from-neutral-900/50 to-neutral-900/30">
            <h3 class="text-lg font-bold text-white mb-4 text-center">Explore Security Features</h3>
            <div class="grid grid-cols-2 gap-3">
                <div class="text-center p-3 rounded-xl bg-gradient-to-br from-rose-900/20 to-rose-900/10 border border-rose-500/20">
                    <i class="fas fa-bug text-rose-400 text-xl mb-2"></i>
                    <p class="text-xs font-medium text-white">Vulnerable Upload</p>
                    <p class="text-xs text-gray-400 mt-1">See insecure implementation</p>
                </div>
                <div class="text-center p-3 rounded-xl bg-gradient-to-br from-emerald-900/20 to-emerald-900/10 border border-emerald-500/20">
                    <i class="fas fa-shield-alt text-emerald-400 text-xl mb-2"></i>
                    <p class="text-xs font-medium text-white">Secure Upload</p>
                    <p class="text-xs text-gray-400 mt-1">Learn best practices</p>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
(function () {
    // Tab switching functionality
    const tabs = document.querySelectorAll('.tab-button');
    const loginPanel = document.getElementById('panel-login');
    const registerPanel = document.getElementById('panel-register');

    function switchTab(tabName) {
        // Update URL without page reload
        const url = new URL(window.location);
        url.searchParams.set('tab', tabName);
        window.history.replaceState({}, '', url);

        // Update tab buttons
        tabs.forEach(btn => {
            if (btn.dataset.tab === tabName) {
                if (tabName === 'login') {
                    btn.classList.remove('text-gray-500', 'hover:text-gray-300', 'hover:bg-white/5');
                    btn.classList.add('bg-gradient-to-r', 'from-purple-600', 'to-indigo-700', 'text-white', 'shadow-lg');
                } else {
                    btn.classList.remove('text-gray-500', 'hover:text-gray-300', 'hover:bg-white/5');
                    btn.classList.add('bg-gradient-to-r', 'from-emerald-600', 'to-emerald-700', 'text-white', 'shadow-lg');
                }
            } else {
                btn.classList.remove('bg-gradient-to-r', 'from-purple-600', 'to-indigo-700', 'from-emerald-600', 'to-emerald-700', 'text-white', 'shadow-lg');
                btn.classList.add('text-gray-500', 'hover:text-gray-300', 'hover:bg-white/5');
            }
        });

        // Show/hide panels
        if (tabName === 'login') {
            loginPanel.classList.remove('hidden');
            registerPanel.classList.add('hidden');
            document.getElementById('login_email')?.focus();
        } else {
            registerPanel.classList.remove('hidden');
            loginPanel.classList.add('hidden');
            document.getElementById('name')?.focus();
        }
    }

    tabs.forEach(btn => {
        btn.addEventListener('click', () => {
            switchTab(btn.dataset.tab);
        });
    });

    // Check URL for tab parameter
    const urlParams = new URLSearchParams(window.location.search);
    const tabParam = urlParams.get('tab');
    if (tabParam && (tabParam === 'login' || tabParam === 'register')) {
        switchTab(tabParam);
    }

    // Auto-focus on first input
    document.addEventListener('DOMContentLoaded', () => {
        if (<?php echo $activeTab === 'login' ? 'true' : 'false'; ?>) {
            document.getElementById('login_email')?.focus();
        } else {
            document.getElementById('name')?.focus();
        }
    });
})();
</script>

<!-- Password Strength Indicator (optional enhancement) -->
<style>
.password-strength {
    height: 4px;
    border-radius: 2px;
    margin-top: 4px;
    transition: all 0.3s ease;
}

.strength-weak { 
    width: 25%; 
    background: linear-gradient(90deg, #ef4444, #f87171);
}
.strength-fair { 
    width: 50%; 
    background: linear-gradient(90deg, #f97316, #fb923c);
}
.strength-good { 
    width: 75%; 
    background: linear-gradient(90deg, #eab308, #facc15);
}
.strength-strong { 
    width: 100%; 
    background: linear-gradient(90deg, #22c55e, #4ade80);
}

.glass-card {
    background: rgba(38, 38, 38, 0.7);
    backdrop-filter: blur(12px);
    border: 1px solid rgba(255, 255, 255, 0.08);
}
</style>

<?php include __DIR__ . '/../components/footer.php'; ?>