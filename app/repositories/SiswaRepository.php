<?php
class SiswaRepository extends AnggotaRepository {
    public function findByKtp(string $noKtp): ?Siswa {
        $st = $this->db->prepare(
            'SELECT a.*, s.nim, s.kelas, s.status
             FROM anggota a JOIN siswa s ON s.no_ktp = a.no_ktp
             WHERE a.no_ktp = :k'
        );
        $st->execute([':k' => $noKtp]);
        $row = $st->fetch();
        return $row ? Siswa::fromArray($row) : null;
    }
}
