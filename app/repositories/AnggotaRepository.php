<?php
class AnggotaRepository {
    protected PDO $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function findByEmail(string $email): ?Anggota {
        $st = $this->db->prepare('SELECT * FROM anggota WHERE email = :e LIMIT 1');
        $st->execute([':e' => $email]);
        $row = $st->fetch();
        return $row ? Anggota::fromArray($row) : null;
    }

    public function findByKtp(string $noKtp): ?Anggota {
        $st = $this->db->prepare('SELECT * FROM anggota WHERE no_ktp = :k');
        $st->execute([':k' => $noKtp]);
        $row = $st->fetch();
        return $row ? Anggota::fromArray($row) : null;
    }

    /** Menyimpan tautan foto dari objek entity. */
    public function updateFoto(Anggota $anggota): bool {
        $st = $this->db->prepare('UPDATE anggota SET tautan_foto = :f WHERE no_ktp = :k');
        return $st->execute([':f' => $anggota->getTautanFoto(), ':k' => $anggota->getNoKtp()]);
    }
}
