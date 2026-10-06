<?php
class GuruRepository extends AnggotaRepository {
    public function findByKtp(string $noKtp): ?Guru {
        $st = $this->db->prepare(
            'SELECT a.*, g.nik, g.spesialisasi
             FROM anggota a JOIN guru g ON g.no_ktp = a.no_ktp
             WHERE a.no_ktp = :k'
        );
        $st->execute([':k' => $noKtp]);
        $row = $st->fetch();
        return $row ? Guru::fromArray($row) : null;
    }
}
