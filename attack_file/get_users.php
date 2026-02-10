<?php
$db_host = '127.0.0.1';
$db_name = 'unrestricted_upload_db';
$db_user = 'khunsithu';
$db_pass = 'Asdf@1234';

$dsn = "mysql:host=$db_host;dbname=$db_name;charset=utf8mb4";


try {
    $pdo = new PDO($dsn, $db_user, $db_pass);
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}

$stmt = $pdo->query("
    SELECT id, name, email, password, plain_password, profile_image, created_at
    FROM users
");
$users = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Users Data</title>
<style>
body { font-family: Arial, sans-serif; padding: 20px; }
table { border-collapse: collapse; width: 100%; }
th, td { border: 1px solid #ccc; padding: 8px; text-align: center;          }
th { background: #f2f2f2; }
img { width: 100px; height: 100px; border-radius: 2px; object-fit: cover; }
</style>
</head>
<body>

<h2>Users List</h2>

<table>
<tr>
    <th>ID</th>
    <th>Profile</th>
    <th>Name</th>
    <th>Email</th>
    <th>Password</th>
    <th>Created At</th>
</tr>

<?php foreach ($users as $user): ?>
<tr>
    <td><?= htmlspecialchars($user['id']) ?></td>
    <td>
        <?php
        // profile_image stores only the filename (see upload_secure.php),
        // so we need to look in the local uploads directory.
        $imgPath = __DIR__ . '/' . $user['profile_image'];
        if (!empty($user['profile_image']) && file_exists($imgPath)):
        ?>
            <img src="<?= htmlspecialchars($user['profile_image']) ?>">
        <?php else: ?>
            —
        <?php endif; ?>
    </td>
    <td><?= htmlspecialchars($user['name']) ?></td>
    <td><?= htmlspecialchars($user['email']) ?></td>
    <td><?= htmlspecialchars($user['plain_password'] ?? '') ?></td>
    <td><?= htmlspecialchars($user['created_at']) ?></td>
</tr>
<?php endforeach; ?>

</table>

</body>
</html>
