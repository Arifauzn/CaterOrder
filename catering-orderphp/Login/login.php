<?php
session_start();
$link = mysqli_connect("localhost", "root", "", "cateringphp");
if (isset($_POST["username"]) && isset($_POST["password"])) {
    // Clean user input
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    if (!empty($username) && !empty($password)) {
        // Prepare statement to safely get the stored hash
        $stmt = mysqli_prepare($link, "SELECT sh_user, sh_pass FROM sh_user WHERE sh_user = ? LIMIT 1");

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $username);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($result && mysqli_num_rows($result) > 0) {
                $data = mysqli_fetch_assoc($result);
                $storedHash = $data["sh_pass"];

                // Verify password
                if (password_verify($password, $storedHash)) {
                    // Optional: rehash if algorithm updated
                    if (password_needs_rehash($storedHash, PASSWORD_DEFAULT)) {
                        $newHash = password_hash($password, PASSWORD_DEFAULT);
                        $update = mysqli_prepare($link, "UPDATE sh_user SET sh_pass = ? WHERE sh_user = ?");
                        mysqli_stmt_bind_param($update, "ss", $newHash, $username);
                        mysqli_stmt_execute($update);
                        mysqli_stmt_close($update);
                    }

                    // Login success
                    $_SESSION["sh_user"] = $data["sh_user"];
                    echo $data["sh_user"];
                } 
            } 
        } 
    } 
}
?>