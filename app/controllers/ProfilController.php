<?php
class ProfilController extends Controller {

    private const MIME_EXT = [
        'image/jpeg' => 'jpg',
        'image/png'  => 'png',
        'image/gif'  => 'gif',
        'image/webp' => 'webp',
    ];

    public function index(): void {
        $this->view('profil/index', [
            'user'    => $this->currentUser(),
            'error'   => flash('error'),
            'success' => flash('success'),
        ]);
    }

    public function upload(): void {
        $user = $this->currentUser();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !csrf_check($_POST['csrf'] ?? null)) {
            flash('error', 'Permintaan tidak valid.');
            $this->redirect('profil/index');
        }

        $file = $_FILES['foto'] ?? null;
        if (!$file || $file['error'] !== UPLOAD_ERR_OK) {
            flash('error', 'Pilih file foto terlebih dahulu (atau ukuran file melebihi batas server).');
            $this->redirect('profil/index');
        }
        if ($file['size'] > MAX_UPLOAD_SIZE) {
            flash('error', 'Ukuran foto maksimal 2 MB.');
            $this->redirect('profil/index');
        }

        // Validasi tipe berdasarkan isi file, bukan ekstensi dari user
        $mime = (new finfo(FILEINFO_MIME_TYPE))->file($file['tmp_name']);
        if (!isset(self::MIME_EXT[$mime]) || @getimagesize($file['tmp_name']) === false) {
            flash('error', 'Format harus gambar JPG, PNG, GIF, atau WEBP.');
            $this->redirect('profil/index');
        }

        $noKtp = $user->getNoKtp();                       // sudah tervalidasi oleh setNoKtp()
        $nama  = $noKtp . '.' . self::MIME_EXT[$mime];    // format: no_ktp.ekstensi

        // Hapus foto lama (bisa berbeda ekstensi)
        foreach (glob(UPLOAD_DIR . $noKtp . '.*') ?: [] as $lama) {
            @unlink($lama);
        }

        if (!move_uploaded_file($file['tmp_name'], UPLOAD_DIR . $nama)) {
            flash('error', 'Gagal menyimpan file. Pastikan folder profil_picture dapat ditulis.');
            $this->redirect('profil/index');
        }

        // Ubah lewat setter, lalu simpan lewat repository
        $user->setTautanFoto(UPLOAD_URL . $nama);
        (new AnggotaRepository())->updateFoto($user);

        flash('success', 'Foto profil berhasil diperbarui.');
        $this->redirect('profil/index');
    }
}
