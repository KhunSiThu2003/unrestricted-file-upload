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
<section class="w-full mx-auto px-4 py-8 auth-fade-in">

    <div class="max-w-md mx-auto">
        <?php include __DIR__ . '/../components/login.php'; ?>
        <?php include __DIR__ . '/../components/register.php'; ?>
    </div>
</section>

<script>
(function () {
    const tabLinks = document.querySelectorAll('.tab-link');
    const loginPanel = document.getElementById('panel-login');
    const registerPanel = document.getElementById('panel-register');

    function switchTab(tabName) {
        const url = new URL(window.location);
        url.searchParams.set('tab', tabName);
        window.history.replaceState({}, '', url);

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

    tabLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            switchTab(link.dataset.tab);
        });
    });

    const urlParams = new URLSearchParams(window.location.search);
    const tabParam = urlParams.get('tab');
    if (tabParam && (tabParam === 'login' || tabParam === 'register')) {
        switchTab(tabParam);
    }

    document.addEventListener('DOMContentLoaded', () => {
        if (<?php echo $activeTab === 'login' ? 'true' : 'false'; ?>) {
            document.getElementById('login_email')?.focus();
        } else {
            document.getElementById('name')?.focus();
        }
    });
})();
</script>

<style>
@keyframes authFadeIn {
    from {
        opacity: 0;
        transform: translateY(12px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.auth-fade-in {
    animation: authFadeIn 0.5s ease-out forwards;
}

.password-strength {
    height: 4px;
    border-radius: 2px;
    margin-top: 4px;
    transition: all 0.3s ease;
}

.strength-weak { 
    width: 25%; 
    background: #ef4444;
}
.strength-fair { 
    width: 50%; 
    background: #f97316;
}
.strength-good { 
    width: 75%; 
    background: #eab308;
}
.strength-strong { 
    width: 100%; 
    background: #22c55e;
}

.glass-card {
    background: rgba(38, 38, 38, 0.7);
    backdrop-filter: blur(12px);
    border: 1px solid rgba(255, 255, 255, 0.08);
}

.info-badge {
    background: rgba(99, 102, 241, 0.2);
    border: 1px solid rgba(99, 102, 241, 0.3);
}

.warning-badge {
    background: rgba(244, 63, 94, 0.2);
    border: 1px solid rgba(244, 63, 94, 0.3);
}

.success-badge {
    background: rgba(52, 211, 153, 0.2);
    border: 1px solid rgba(52, 211, 153, 0.3);
}
</style>

</main>

</body>
</html>