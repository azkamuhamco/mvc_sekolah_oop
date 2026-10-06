<?php
/**
 * Entity Anggota (superclass).
 * Semua properti private -> hanya bisa diubah lewat setter yang memvalidasi nilainya.
 */
class Anggota {
    private string  $noKtp = '';
    private string  $nama = '';
    private string  $jenisKelamin = 'L';
    private string  $email = '';
    private string  $passwordHash = '';
    private string  $hp = '';
    private ?string $tautanFoto = null;

    /** Membuat objek dari satu baris hasil query. `static` => Siswa::fromArray() menghasilkan Siswa. */
    public static function fromArray(array $d): static {
        $obj = new static();
        $obj->hydrate($d);
        return $obj;
    }

    /** Subclass meng-override method ini untuk mengisi atribut tambahannya. */
    protected function hydrate(array $d): void {
        $this->setNoKtp($d['no_ktp'])
             ->setNama($d['nama_anggota'])
             ->setJenisKelamin($d['jenis_kelamin'])
             ->setEmail($d['email'])
             ->setHp($d['hp'])
             ->setTautanFoto($d['tautan_foto'] ?? null);
        $this->passwordHash = $d['password']; // sudah berupa hash dari database
    }

    // ---------- Getter ----------
    public function getNoKtp(): string         { return $this->noKtp; }
    public function getNama(): string          { return $this->nama; }
    public function getJenisKelamin(): string  { return $this->jenisKelamin; }
    public function getEmail(): string         { return $this->email; }
    public function getHp(): string            { return $this->hp; }
    public function getTautanFoto(): ?string   { return $this->tautanFoto; }
    public function getPasswordHash(): string  { return $this->passwordHash; }

    public function getLabelJenisKelamin(): string {
        return $this->jenisKelamin === 'L' ? 'Laki-laki' : 'Perempuan';
    }

    // ---------- Setter (fluent + validasi) ----------
    public function setNoKtp(string $v): static {
        $v = trim($v);
        // Karakter dibatasi karena no_ktp dipakai sebagai nama file foto
        if (!preg_match('/^[A-Za-z0-9_-]{1,20}$/', $v)) {
            throw new InvalidArgumentException('No. KTP harus 1-20 karakter (huruf, angka, _ atau -).');
        }
        $this->noKtp = $v;
        return $this;
    }

    public function setNama(string $v): static {
        $v = trim($v);
        if ($v === '' || mb_strlen($v) > 100) {
            throw new InvalidArgumentException('Nama wajib diisi (maksimal 100 karakter).');
        }
        $this->nama = $v;
        return $this;
    }

    public function setJenisKelamin(string $v): static {
        if (!in_array($v, ['L', 'P'], true)) {
            throw new InvalidArgumentException('Jenis kelamin harus L atau P.');
        }
        $this->jenisKelamin = $v;
        return $this;
    }

    public function setEmail(string $v): static {
        $v = trim($v);
        if (!filter_var($v, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Format email tidak valid.');
        }
        $this->email = $v;
        return $this;
    }

    /** Menerima password polos, lalu menyimpannya dalam bentuk MD5. */
    public function setPassword(string $plain): static {
        if (strlen($plain) < 6) {
            throw new InvalidArgumentException('Password minimal 6 karakter.');
        }
        $this->passwordHash = md5($plain);
        return $this;
    }

    public function setHp(string $v): static {
        $v = trim($v);
        if (!preg_match('/^\+?[0-9]{8,19}$/', $v)) {
            throw new InvalidArgumentException('Nomor HP tidak valid.');
        }
        $this->hp = $v;
        return $this;
    }

    public function setTautanFoto(?string $v): static {
        $this->tautanFoto = ($v === null || $v === '') ? null : $v;
        return $this;
    }

    // ---------- Perilaku ----------
    public function cekPassword(string $plain): bool {
        return hash_equals($this->passwordHash, md5($plain));
    }

    /** Polymorphism: tiap subclass menyebut perannya sendiri. */
    public function getPeran(): string { return 'Anggota'; }

    /** Polymorphism: atribut khusus peran, dipakai view tanpa if/else per peran. */
    public function getInfoKhusus(): array { return []; }
}
