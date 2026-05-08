// simpan.php
<?php
include 'koneksi.php';

$id = $_POST['id'];
$nim = $_POST['nim'];
$nama = $_POST['nama'];
$jurusan = $_POST['jurusan'];
$foto_lama = $_POST['foto_lama'];

$foto = $foto_lama;

if ($_FILES['foto']['name'] != "") {

    $namaFile = $_FILES['foto']['name'];
    $tmp = $_FILES['foto']['tmp_name'];

    $ext = strtolower(pathinfo($namaFile, PATHINFO_EXTENSION));

    $allowed = ['jpg', 'jpeg', 'png'];

    if (!in_array($ext, $allowed)) {
        die("Format file tidak didukung!");
    }

    if ($_FILES['foto']['size'] > 2 * 1024 * 1024) {
        die("Ukuran file terlalu besar!");
    }

    $foto = time() . '.' . $ext;

    move_uploaded_file($tmp, 'uploads/' . $foto);

    if ($foto_lama != "" && file_exists("uploads/" . $foto_lama)) {
        unlink("uploads/" . $foto_lama);
    }
}

if ($id == "") {

    mysqli_query($conn,
        "INSERT INTO mahasiswa
        (nim, nama, jurusan, foto)
        VALUES
        ('$nim', '$nama', '$jurusan', '$foto')"
    );

    echo "
    <script>
        alert('Data berhasil ditambahkan!');
        window.location='index.php';
    </script>
    ";

} else {

    mysqli_query($conn,
        "UPDATE mahasiswa SET
        nim='$nim',
        nama='$nama',
        jurusan='$jurusan',
        foto='$foto'
        WHERE id='$id'"
    );

    echo "
    <script>
        alert('Data berhasil diupdate!');
        window.location='index.php';
    </script>
    ";
}
?>