<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

    <?php

    // File koneksi database
    require "files/functions.php";

    // Ambil data dari form register
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $password2 = mysqli_real_escape_string($conn, $_POST['password2']);
    $user_type = mysqli_real_escape_string($conn, $_POST['user_type']);
    //cek apakah username sudah digunakan
    $result = mysqli_query($conn, "SELECT username FROM users WHERE username = '$username'");
    if (mysqli_fetch_assoc($result)) {
        echo "<script>alert('username sudah digunakan');window.location.assign('auth.php');</script>";
        return false;
    }
    //cek konfirmasi password
    if ($password !== $password2) {
        echo "<script>alert('password tidak sama');window.location.assign('auth.php');</script>";
        return false;
    }
    //enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);
    // Query untuk memasukkan data ke database
    $query_sql = "INSERT INTO users (username,password,user_type )
   
    VALUES ('$username', '$password', '$user_type')";


    // Cek apakah data berhasil dimasukkan
    if (mysqli_query($conn, $query_sql)) {
        // Register berhasil
        // header("Location:index.php");
        echo "<script>
                 Swal.fire({
                title: 'Anda Berhasil registrasi!',
                text: 'Click login di bawah ini untuk melakukan login',
                icon: 'success',
                showCancelButton: false,
                confirmButtonText: 'Login',
                }).then((result) => {
                    if (result.isConfirmed) {
                    window.location.href = 'auth.php';
                    }
                });
                </script>";
    } else {
        // Register gagal
        echo "Registrasi gagal. Silakan coba lagi.";
    }
    ?>

</body>

</html>