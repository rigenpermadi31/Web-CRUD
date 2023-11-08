<?php
include('koneksi.php'); // Include database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assuming you have established a database connection in koneksi.php
    $conn = mysqli_connect($servername, $username, $password, $dbname); // Replace with your actual connection parameters
    
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $nama = $_POST["nama"];
    $jurusan = $_POST["jurusan"];
    $no_hp = $_POST["no_hp"];
    $alamat = $_POST["alamat"];

    // Handle file upload for 'foto_diri'
    $uploadDir = 'uploads/';
    $uploadPath = $uploadDir . basename($_FILES["foto_diri"]["name"]);

    if (move_uploaded_file($_FILES["foto_diri"]["tmp_name"], $uploadPath)) {
        // File uploaded successfully, proceed to insert into the database
        $foto_diri = $uploadPath;

        // Use prepared statement to prevent SQL injection
        $sql = "INSERT INTO mahasiswa (nama, jurusan, no_hp, alamat, foto_diri) VALUES ('$nama', '$jurusan', '$no_hp', '$alamat', '$foto_diri')";

        if ($conn->query($sql)) {
            header("Location: index.php"); // Redirect to the main page after successful data insertion
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

    } else { 
        echo "Error uploading the file.";
    }

    // Close the database connection
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="styles.css">
    <meta charset="UTF-8">
    <title>Tambah Mahasiswa</title>
</head>
<body>
    <h1>Tambah Mahasiswa</h1>

    <form action="create.php" method="POST" enctype="multipart/form-data">
        <label for="nama">Nama:</label>
        <input type="text" name="nama"  required><br>
        
        <label for="jurusan">Jurusan:</label>
        <input type="text" name="jurusan"  required><br>

        <label for="no_hp">No HP:</label>
        <input type="text" name="no_hp"  required><br>

        <label for="alamat">Alamat:</label>
        <textarea name="alamat" rows="4" required></textarea><br>

        <label for="foto_diri">Foto Diri:</label>
        <input type="file" name="foto_diri" accept="image/*"><br>

        <input type="submit" value="Unggah dan Tambah">
    </form>

    <a href="index.php">Kembali ke Daftar Mahasiswa</a>
</body>
</html>

<!-- Rest of your HTML remains the same -->
