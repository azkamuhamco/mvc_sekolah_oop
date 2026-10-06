<?php
class AuthController extends Controller {

    /** Satu halaman login untuk semua anggota; peran ditentukan otomatis setelah login. */
    public function login(): void {
        if (!empty($_SESSION['no_ktp'])) $this->redirect('dashboard/index');

        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email    = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            if (!csrf_check($_POST['csrf'] ?? null)) {
                $error = 'Sesi tidak valid, silakan coba lagi.';
            } elseif ($email === '' || $password === '') {
                $error = 'Email dan password wajib diisi.';
            } else {
                // 1) Cek kredensial pada entity Anggota
                $anggota = (new AnggotaRepository())->findByEmail($email);

                if (!$anggota || !$anggota->cekPassword($password)) {
                    $error = 'Email atau password salah.';
                } else {
                    // 2) Tentukan peran otomatis dari tabel siswa / guru
                    $peran = $this->temukanPeran($anggota->getNoKtp());

                    if (count($peran) === 0) {
                        $error = 'Akun Anda belum memiliki akses (belum terdaftar sebagai siswa/guru, atau status siswa tidak aktif).';
                    } elseif (count($peran) > 1) {
                        // Satu anggota seharusnya hanya punya satu peran
                        $error = 'Data akun tidak konsisten (terdaftar sebagai siswa sekaligus guru). Hubungi administrator.';
                    } else {
                        session_regenerate_id(true);
                        $_SESSION['no_ktp'] = $anggota->getNoKtp();
                        $_SESSION['peran']  = $peran[0];
                        $this->redirect('dashboard/index');
                    }
                }
            }
        }

        $this->view('auth/login', ['error' => $error]);
    }

    public function logout(): void {
        $_SESSION = [];
        session_destroy();
        header('Location: index.php?r=auth/login');
        exit;
    }

    /** Daftar peran aktif milik seorang anggota (normalnya hanya satu). */
    private function temukanPeran(string $noKtp): array {
        $hasil = [];
        foreach (['Siswa', 'Guru'] as $peran) {
            $user = $this->repositoryByRole($peran)->findByKtp($noKtp);
            if ($user === null) continue;
            if ($user instanceof Siswa && !$user->isAktif()) continue;
            $hasil[] = $peran;
        }
        return $hasil;
    }
}
