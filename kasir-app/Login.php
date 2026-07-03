<?php
session_start();
require_once 'config.php';

if (isset($_POST['login'])) {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    $stmt = mysqli_prepare($conn, "SELECT * FROM user WHERE username=?");
    mysqli_stmt_bind_param($stmt, "s", $user);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $cek = mysqli_num_rows($result);

    if ($cek > 0) {
        $d = mysqli_fetch_assoc($result);

        if (password_verify($pass, $d['password'])) {
            $_SESSION['login'] = true;
            $_SESSION['nama'] = $d['nama'];
            $_SESSION['role'] = $d['role'];

            header("Location: dashboard.php");
            exit;
        } elseif ($d['password'] === $pass) {
            $hashed = password_hash($pass, PASSWORD_DEFAULT);
            $update = mysqli_prepare($conn, "UPDATE user SET password=? WHERE id_user=?");
            mysqli_stmt_bind_param($update, "si", $hashed, $d['id_user']);
            mysqli_stmt_execute($update);

            $_SESSION['login'] = true;
            $_SESSION['nama'] = $d['nama'];
            $_SESSION['role'] = $d['role'];

            header("Location: dashboard.php");
            exit;
        } else {
            $error = "Username / Password salah!";
        }
    } else {
        $error = "Username / Password salah!";
    }

    mysqli_stmt_close($stmt);
}
?>

<style>
body {
    font-family: Arial;
    background: linear-gradient(135deg, #74ebd5, #ACB6E5);
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.login-box {
    background: white;
    padding: 30px;
    border-radius: 15px;
    width: 320px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.2);
    text-align: center;
    animation: fadeIn 0.5s ease-in-out;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.login-box h2 {
    margin-bottom: 5px;
    color: #2c3e50;
}

.login-box h3 {
    margin-bottom: 20px;
    color: #7f8c8d;
    font-weight: normal;
}

input {
    width: 100%;
    padding: 10px;
    margin: 10px 0;
    border-radius: 8px;
    border: 1px solid #ccc;
    outline: none;
    transition: 0.3s;
}

input:focus {
    border-color: #3498db;
    box-shadow: 0 0 5px rgba(52,152,219,0.5);
}

button {
    width: 100%;
    padding: 10px;
    background: linear-gradient(135deg, #3498db, #2980b9);
    color: white;
    border: none;
    border-radius: 8px;
    margin-top: 10px;
    font-weight: bold;
    cursor: pointer;
    transition: 0.3s;
}

button:hover {
    transform: scale(1.05);
    background: linear-gradient(135deg, #2980b9, #1f6391);
}

.error {
    color: red;
    margin-bottom: 10px;
}
</style>

<div class="login-box">
    <h3>TB. Jaya Santosa</h3>
    <h2>🔐 Login Sistem Kasir</h2>

    <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>

    <form method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button name="login">Login</button>
    </form>
</div>
