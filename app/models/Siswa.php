<?php
class Siswa extends Anggota {
    private string $nim = '';
    private string $kelas = '';
    private string $status = 'A';

    protected function hydrate(array $d): void {
        parent::hydrate($d);
        $this->setNim($d['nim'])->setKelas($d['kelas'])->setStatus($d['status']);
    }

    public function getNim(): string    { return $this->nim; }
    public function getKelas(): string  { return $this->kelas; }
    public function getStatus(): string { return $this->status; }

    public function setNim(string $v): static {
        $v = trim($v);
        if ($v === '' || strlen($v) > 20) throw new InvalidArgumentException('NIM wajib diisi (maksimal 20 karakter).');
        $this->nim = $v;
        return $this;
    }

    public function setKelas(string $v): static {
        $v = trim($v);
        if ($v === '' || strlen($v) > 20) throw new InvalidArgumentException('Kelas wajib diisi (maksimal 20 karakter).');
        $this->kelas = $v;
        return $this;
    }

    public function setStatus(string $v): static {
        if (!in_array($v, ['A', 'TA'], true)) throw new InvalidArgumentException('Status harus A atau TA.');
        $this->status = $v;
        return $this;
    }

    public function isAktif(): bool { return $this->status === 'A'; }

    public function getPeran(): string { return 'Siswa'; }

    public function getInfoKhusus(): array {
        return [
            'NIM'    => $this->nim,
            'Kelas'  => $this->kelas,
            'Status' => $this->isAktif() ? 'Aktif' : 'Tidak Aktif',
        ];
    }
}
