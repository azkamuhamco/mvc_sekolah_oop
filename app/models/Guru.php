<?php
class Guru extends Anggota {
    private string $nik = '';
    private string $spesialisasi = '';

    protected function hydrate(array $d): void {
        parent::hydrate($d);
        $this->setNik($d['nik'])->setSpesialisasi($d['spesialisasi']);
    }

    public function getNik(): string          { return $this->nik; }
    public function getSpesialisasi(): string { return $this->spesialisasi; }

    public function setNik(string $v): static {
        $v = trim($v);
        if ($v === '' || strlen($v) > 20) throw new InvalidArgumentException('NIK wajib diisi (maksimal 20 karakter).');
        $this->nik = $v;
        return $this;
    }

    public function setSpesialisasi(string $v): static {
        $v = trim($v);
        if ($v === '' || mb_strlen($v) > 100) throw new InvalidArgumentException('Spesialisasi wajib diisi (maksimal 100 karakter).');
        $this->spesialisasi = $v;
        return $this;
    }

    public function getPeran(): string { return 'Guru'; }

    public function getInfoKhusus(): array {
        return [
            'NIK'          => $this->nik,
            'Spesialisasi' => $this->spesialisasi,
        ];
    }
}
