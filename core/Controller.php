<?php
abstract class Controller {
    protected function view(string $view, array $data = []): void {
        extract($data);
        require BASE_PATH . '/app/views/' . $view . '.php';
    }

    protected function redirect(string $route): void {
        header('Location: index.php?r=' . $route);
        exit;
    }

    protected function requireLogin(): void {
        if (empty($_SESSION['no_ktp']) || empty($_SESSION['peran'])) {
            $this->redirect('auth/login');
        }
    }

    protected function repositoryByRole(string $peran): ?AnggotaRepository {
        return match ($peran) {
            'Siswa' => new SiswaRepository(),
            'Guru'  => new GuruRepository(),
            default => null,
        };
    }

    /** Objek Siswa/Guru milik user yang sedang login. */
    protected function currentUser(): Anggota {
        $this->requireLogin();
        $user = $this->repositoryByRole($_SESSION['peran'])->findByKtp($_SESSION['no_ktp']);
        if (!$user) {
            $this->redirect('auth/logout');
        }
        return $user;
    }
}
