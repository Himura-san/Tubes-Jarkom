<?php
    class Proses {
        private $pdo;
// =============================================================
        public function __construct() {
            $host = "localhost";
            $user = "root";
            $pass = "";
            $db   = "db_jarkom";

            try {
                $this->pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
                $this->pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch(PDOException $e){
                print("Koneksi bermasalah : " . $e -> getMessage() . "<br>");
            }
        }

        public function tambah_guest($nama, $email) {
            $nama = $this->pdo -> quote($nama);
            $email = $this->pdo -> quote($email);
            
            $query = $this->pdo -> prepare("INSERT INTO tb_guest(nama, email) VALUES ($nama, $email);");
            $query -> execute();

            if ($query) {
                ?>
                <script>
                    alert("Tambah Data berhasil..");
                    location = "index.php";
                </script>
                <?php
            } else {
                ?>
                <script>
                    alert("Tambah Data gagal..!");
                    location = "index.php";
                </script>
                <?php
            }
        }

        public function view_guest() {
            $query = $this->pdo -> prepare("SELECT * FROM tb_guest");
            $query -> execute();

            return $query;
        }

        public function paged_guest($posisi, $batas) {
            $query = $this->pdo -> prepare("SELECT * FROM tb_guest LIMIT $posisi, $batas");
            $query -> execute();

            return $query;
        }
    }

    $proses = new Proses();

    if (isset($_GET['tambah'])) {
        $proses -> tambah_guest($_POST['nama'], $_POST['email']);
    }
?>