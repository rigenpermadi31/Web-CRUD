<?php
include('koneksi.php'); // Include database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_siswa = $_POST["id_siswa"];
    $nama = $_POST["nama"]; // Assuming 'kelas' is a field in the database
    $jurusan = $_POST["jurusan"];
    $no_hp = $_POST["no_hp"];
    $alamat = $_POST["alamat"];

    // File handling for 'foto_diri'
    $file_dir = "uploads/";
    $file_name = $_FILES['foto_diri']['name'];
    $file_tmp = $_FILES['foto_diri']['tmp_name'];
    $file_path = $file_dir . $file_name;

    if (move_uploaded_file($file_tmp, $file_path)) {
        // File uploaded successfully, proceed to update the database
        $sql = "UPDATE mahasiswa SET nama='$nama', jurusan='$jurusan', no_hp='$no_hp', alamat='$alamat', foto_diri='$file_name' WHERE id_siswa=$id_siswa";

        if ($conn->query($sql) === TRUE) {
            header("Location: index.php"); // Redirect to the main page after successful data update
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Error uploading the file.";
    }
}

if (isset($_GET["id"])) {
    $id_siswa = $_GET["id"];

    // Fetch data of the student based on id_siswa
    $sql = "SELECT * FROM mahasiswa WHERE id_siswa=$id_siswa";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Data siswa tidak ditemukan.";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="styles.css">
    <meta charset="UTF-8">
    <title>Edit Mahasiswa</title>
</head>
<body>
    <h1>Edit Mahasiswa</h1>

    <form action="update.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id_siswa" value="<?php echo $row['id_siswa']; ?>">

        <label for="nama">Nama:</label>
        <input type="text" name="nama" value="<?php echo $row['nama']; ?>" required><br>

        <label for="jurusan">Jurusan:</label>
        <input type="text" name="jurusan" value="<?php echo $row['jurusan']; ?>" required><br>

        <label for="no_hp">No HP:</label>
        <input type="text" name="no_hp" value="<?php echo $row['no_hp']; ?>" required><br>

        <label for="alamat">Alamat:</label>
        <textarea name="alamat" rows="4" required><?php echo $row['alamat']; ?></textarea><br>

        <label for="foto_diri">Foto Diri:</label>
        <input type="file" name="foto_diri" accept="image/*"><br>

        <input type="submit" value="Simpan Perubahan">
    </form>

    <a href="index.php">Kembali ke Daftar Mahasiswa</a>
</body>
</html>
