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
            $success = 'Registration successful. You can now log in.';
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
    $activeTab = 'register';
}

include __DIR__ . '/../components/header.php';
?>
<div class="min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md px-4 py-10">
        <?php include __DIR__ . '/../components/login.php'; ?>
        <?php include __DIR__ . '/../components/register.php'; ?>
    </div>
</div>

<script>
    (function () {
        const tabs = document.querySelectorAll('.tab-button');
        const loginPanel = document.getElementById('panel-login');
        const registerPanel = document.getElementById('panel-register');

        tabs.forEach(btn => {
            btn.addEventListener('click', () => {
                const tab = btn.dataset.tab;

                tabs.forEach(b => {
                    b.classList.remove('bg-white', 'text-slate-900', 'shadow-sm');
                    b.classList.add('text-slate-500');
                });
                btn.classList.add('bg-white', 'text-slate-900', 'shadow-sm');
                btn.classList.remove('text-slate-500');

                if (tab === 'login') {
                    loginPanel.classList.remove('hidden');
                    registerPanel.classList.add('hidden');
                    document.getElementById('login_email')?.focus();
                } else {
                    registerPanel.classList.remove('hidden');
                    loginPanel.classList.add('hidden');
                    document.getElementById('name')?.focus();
                }
            });
        });
    })();
</script>
<?php include __DIR__ . '/../components/footer.php'; ?>

