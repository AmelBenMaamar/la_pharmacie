<?php
class AdminController extends Controller {

    public function dashboard(): void {
        $this->requireAdmin();
        $db     = Database::getInstance();
        $counts = [
            'plantes'    => $db->query('SELECT COUNT(*) FROM plantes')->fetchColumn(),
            'composants' => $db->query('SELECT COUNT(*) FROM composants')->fetchColumn(),
            'vertus'     => $db->query('SELECT COUNT(*) FROM vertus')->fetchColumn(),
        ];
        $user = $_SESSION['user'];
        $this->view('admin/dashboard', [
            'counts' => $counts,
            'user'   => $user,
        ]);
    }

    public function plantes(): void {
        $this->requireAdmin();
        $plantes = (new Plante())->all();
        $this->view('admin/plantes', ['plantes' => $plantes, 'user' => $_SESSION['user']]);
    }

    public function planteCreer(): void {
        $this->requireAdmin();
        $categories = (new Plante())->all();
        $this->view('admin/plante_form', ['plante' => null, 'user' => $_SESSION['user']]);
    }

    public function planteStorer(): void {
        $this->requireAdmin();
        $this->verifyCsrf();
        $model = new Plante();
        $data  = $_POST;
        if (!empty($_FILES['image']['tmp_name'])) {
            $data['image'] = $this->uploadImage($_FILES['image'], 'plantes');
        }
        $id = $model->create($data);
        $this->flash('success', 'Plante créée avec succès.');
        $this->redirect('/admin/plantes/' . $id . '/liens');
    }

    public function planteEditer(string $id): void {
        $this->requireAdmin();
        $plante = (new Plante())->find((int)$id);
        $this->view('admin/plante_form', ['plante' => $plante, 'user' => $_SESSION['user']]);
    }

    public function planteUpdater(string $id): void {
        $this->requireAdmin();
        $this->verifyCsrf();
        $model = new Plante();
        $data  = $_POST;
        if (!empty($_FILES['image']['tmp_name'])) {
            $data['image'] = $this->uploadImage($_FILES['image'], 'plantes');
        } else {
            $plante = $model->find((int)$id);
            $data['image'] = $plante['image'];
        }
        $model->update((int)$id, $data);
        $this->flash('success', 'Plante mise à jour.');
        $this->redirect('/admin/plantes');
    }

    public function planteSupprimer(string $id): void {
        $this->requireAdmin();
        (new Plante())->delete((int)$id);
        $this->flash('success', 'Plante supprimée.');
        $this->redirect('/admin/plantes');
    }

    public function planteLiens(string $id): void {
        $this->requireAdmin();
        $model  = new Plante();
        /* Supporte slug ET id numerique */
        $plante = is_numeric($id) ? $model->find((int)$id) : $model->findBySlug($id);
        if (!$plante) { http_response_code(404); echo 'Plante introuvable'; return; }
        $realId     = $plante['id'];
        $composants = $model->composants($realId);
        $vertus     = $model->vertus($realId);
        $categories = $model->categories($realId);
        $all_composants = (new Composant())->all();
        $all_vertus     = (new Vertu())->all();
        $this->view('admin/plante_liens', [
            'plante'     => $plante,
            'composants' => $composants,
            'vertus'     => $vertus,
            'categories' => $categories,
            'all_composants' => $all_composants,
            'all_vertus'     => $all_vertus,
            'user'       => $_SESSION['user'],
            'token'      => $this->csrfToken(),
        ]);
    }

    public function planteLiensStorer(string $id): void {
        $this->requireAdmin();
        $this->verifyCsrf();
        $model = new Plante();
        $type  = $_POST['type'] ?? '';
        if ($type === 'composant') {
            $model->linkComposant((int)$id, (int)$_POST['composant_id'], $_POST['concentration'] ?? '', $_POST['notes'] ?? '');
        } elseif ($type === 'vertu') {
            $model->linkVertu((int)$id, (int)$_POST['vertu_id'], $_POST['source'] ?? '');
        } elseif ($type === 'categorie') {
            $model->linkCategorie((int)$id, (int)$_POST['categorie_id']);
        } elseif ($type === 'composant_vertu') {
            $model->linkComposantVertu((int)$_POST['composant_id'], (int)$_POST['vertu_id'], $_POST['niveau'] ?? 'modere');
        }
        $this->flash('success', 'Lien ajouté.');
        $this->redirect('/admin/plantes/' . $id . '/liens');
    }

    public function planteLiensSupprimer(string $id): void {
        $this->requireAdmin();
        $model = new Plante();
        $type  = $_POST['type'] ?? '';
        if ($type === 'composant') {
            $model->unlinkComposant((int)$id, (int)$_POST['composant_id']);
        } elseif ($type === 'vertu') {
            $model->unlinkVertu((int)$id, (int)$_POST['vertu_id']);
        } elseif ($type === 'categorie') {
            $model->unlinkCategorie((int)$id, (int)$_POST['categorie_id']);
        } elseif ($type === 'composant_vertu') {
            $model->unlinkComposantVertu((int)$_POST['composant_id'], (int)$_POST['vertu_id']);
        }
        $this->flash('success', 'Lien supprimé.');
        $this->redirect('/admin/plantes/' . $id . '/liens');
    }

    public function composants(): void {
        $this->requireAdmin();
        $db = Database::getInstance();
        $composants = $db->query(
            "SELECT c.*, COUNT(cv.vertu_id) AS nb_vertus
             FROM composants c
             LEFT JOIN composant_vertu cv ON cv.composant_id = c.id
             WHERE c.actif = 1
             GROUP BY c.id
             ORDER BY c.nom"
        )->fetchAll();
        $this->view('admin/composants', ['composants' => $composants, 'user' => $_SESSION['user']]);
    }

    public function composantCreer(): void {
        $this->requireAdmin();
        $this->view('admin/composant_form', ['composant' => null, 'user' => $_SESSION['user']]);
    }

    public function composantStorer(): void {
        $this->requireAdmin();
        $this->verifyCsrf();
        $id = (new Composant())->create($_POST);
        $this->flash('success', 'Composant créé.');
        $this->redirect('/admin/composants');
    }

    public function composantEditer(string $id): void {
        $this->requireAdmin();
        $composant = (new Composant())->find((int)$id);
        $this->view('admin/composant_form', ['composant' => $composant, 'user' => $_SESSION['user']]);
    }

    public function composantUpdater(string $id): void {
        $this->requireAdmin();
        $this->verifyCsrf();
        (new Composant())->update((int)$id, $_POST);
        $this->flash('success', 'Composant mis à jour.');
        $this->redirect('/admin/composants');
    }

    public function composantVertus(string $id): void {
        $this->requireAdmin();
        $model     = new Composant();
        $composant = $model->find((int)$id);
        if (!$composant) { http_response_code(404); echo 'Composant introuvable'; return; }
        $vertus_liees = $model->vertus((int)$id);
        $all_vertus   = (new Vertu())->all();
        $this->view('admin/composant_vertus', [
            'composant'    => $composant,
            'vertus_liees' => $vertus_liees,
            'all_vertus'   => $all_vertus,
            'user'         => $_SESSION['user'],
            'token'        => $this->csrfToken(),
        ]);
    }

    public function composantVertusStorer(string $id): void {
        $this->requireAdmin();
        $this->verifyCsrf();
        $composantId = (int)$id;
        $model       = new Composant();
        $db          = Database::getInstance();
        // On repart de zéro pour ce composant
        $db->prepare("DELETE FROM composant_vertu WHERE composant_id = ?")->execute([$composantId]);
        foreach ($_POST['vertus'] ?? [] as $vertuId => $data) {
            if (!empty($data['actif'])) {
                $model->linkVertu(
                    $composantId,
                    (int)$vertuId,
                    trim($data['niveau'] ?? 'modere'),
                    trim($data['notes'] ?? '')
                );
            }
        }
        $this->flash('success', 'Vertus du composant mises à jour.');
        $this->redirect('/admin/composants/' . $composantId . '/vertus');
    }

    public function composantSupprimer(string $id): void {
        $this->requireAdmin();
        (new Composant())->delete((int)$id);
        $this->flash('success', 'Composant supprimé.');
        $this->redirect('/admin/composants');
    }

    public function vertus(): void {
        $this->requireAdmin();
        $db = Database::getInstance();
        $vertus = $db->query(
            "SELECT v.*, COUNT(cv.composant_id) AS nb_composants
             FROM vertus v
             LEFT JOIN composant_vertu cv ON cv.vertu_id = v.id
             WHERE v.actif = 1
             GROUP BY v.id
             ORDER BY v.nom"
        )->fetchAll();
        $this->view('admin/vertus', ['vertus' => $vertus, 'user' => $_SESSION['user']]);
    }

    public function vertuComposants(string $id): void {
        $this->requireAdmin();
        $vertu = (new Vertu())->find((int)$id);
        if (!$vertu) { http_response_code(404); echo 'Vertu introuvable'; return; }
        $composants_lies = (new Vertu())->composants((int)$id);
        $all_composants  = (new Composant())->all();
        $this->view('admin/vertu_composants', [
            'vertu'           => $vertu,
            'composants_lies' => $composants_lies,
            'all_composants'  => $all_composants,
            'user'            => $_SESSION['user'],
            'token'           => $this->csrfToken(),
        ]);
    }

    public function vertuComposantsStorer(string $id): void {
        $this->requireAdmin();
        $this->verifyCsrf();
        $vertuId = (int)$id;
        $db      = Database::getInstance();
        $db->prepare("DELETE FROM composant_vertu WHERE vertu_id = ?")->execute([$vertuId]);
        foreach ($_POST['composants'] ?? [] as $composantId => $data) {
            if (!empty($data['actif'])) {
                (new Composant())->linkVertu((int)$composantId, $vertuId, 'modere', '');
            }
        }
        $this->flash('success', 'Composants liés à la vertu mis à jour.');
        $this->redirect('/admin/vertus/' . $vertuId . '/composants');
    }

    public function vertuCreer(): void {
        $this->requireAdmin();
        $this->view('admin/vertu_form', ['vertu' => null, 'user' => $_SESSION['user']]);
    }

    public function vertuStorer(): void {
        $this->requireAdmin();
        $this->verifyCsrf();
        (new Vertu())->create($_POST);
        $this->flash('success', 'Vertu créée.');
        $this->redirect('/admin/vertus');
    }

    public function vertuEditer(string $id): void {
        $this->requireAdmin();
        $vertu = (new Vertu())->find((int)$id);
        $this->view('admin/vertu_form', ['vertu' => $vertu, 'user' => $_SESSION['user']]);
    }

    public function vertuUpdater(string $id): void {
        $this->requireAdmin();
        $this->verifyCsrf();
        (new Vertu())->update((int)$id, $_POST);
        $this->flash('success', 'Vertu mise à jour.');
        $this->redirect('/admin/vertus');
    }

    public function vertuSupprimer(string $id): void {
        $this->requireAdmin();
        (new Vertu())->delete((int)$id);
        $this->flash('success', 'Vertu supprimée.');
        $this->redirect('/admin/vertus');
    }

    public function categories(): void {
        $this->requireAdmin();
        $db = Database::getInstance();
        $categories = $db->query("SELECT * FROM categories ORDER BY nom")->fetchAll();
        $this->view("admin/categories", ["categories" => $categories, "user" => $_SESSION["user"]]);
    }

    public function categorieCreer(): void {
        $this->requireAdmin();
        $this->view('admin/categorie_form', ['categorie' => null, 'user' => $_SESSION['user']]);
    }

    public function categorieStorer(): void {
        $this->requireAdmin();
        $this->verifyCsrf();
        $db = Database::getInstance();
        $s  = $db->prepare('INSERT INTO categories (nom, slug, description, couleur) VALUES (?,?,?,?)');
        $s->execute([$_POST['nom'], $this->slugify($_POST['nom']), $_POST['description'] ?? '', $_POST['couleur'] ?? '#4a7c59']);
        $this->flash('success', 'Catégorie créée.');
        $this->redirect('/admin/categories');
    }

    public function categorieEditer(string $id): void {
        $this->requireAdmin();
        $db       = Database::getInstance();
        $categorie = $db->prepare('SELECT * FROM categories WHERE id=?');
        $categorie->execute([$id]);
        $this->view('admin/categorie_form', ['categorie' => $categorie->fetch(), 'user' => $_SESSION['user']]);
    }

    public function categorieUpdater(string $id): void {
        $this->requireAdmin();
        $this->verifyCsrf();
        $db = Database::getInstance();
        $s  = $db->prepare('UPDATE categories SET nom=?, slug=?, description=?, couleur=? WHERE id=?');
        $s->execute([$_POST['nom'], $this->slugify($_POST['nom']), $_POST['description'] ?? '', $_POST['couleur'] ?? '#4a7c59', $id]);
        $this->flash('success', 'Catégorie mise à jour.');
        $this->redirect('/admin/categories');
    }

    public function categorieSupprimer(string $id): void {
        $this->requireAdmin();
        $db = Database::getInstance();
        $db->prepare('DELETE FROM categories WHERE id=?')->execute([$id]);
        $this->flash('success', 'Catégorie supprimée.');
        $this->redirect('/admin/categories');
    }

    // Upload image
    private function uploadImage(array $file, string $folder): ?string {
        if ($file['error'] !== UPLOAD_ERR_OK) return null;
        if ($file['size'] > UPLOAD_MAX_SIZE) return null;

        // Validation MIME réelle (pas l'extension déclarée)
        $finfo    = new finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->file($file['tmp_name']);
        if (!in_array($mimeType, UPLOAD_TYPES, true)) return null;

        // Extension basée sur le MIME, pas sur le nom du fichier
        $extMap   = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];
        $ext      = $extMap[$mimeType];
        $filename = uniqid('img_', true) . '.' . $ext;
        $dest     = UPLOAD_DIR . $folder . '/' . $filename;

        if (!move_uploaded_file($file['tmp_name'], $dest)) return null;
        return $folder . '/' . $filename;
    }

    private function slugify(string $str): string {
        $str = mb_strtolower(trim($str), 'UTF-8');
        $str = preg_replace('/[àáâãäå]/u', 'a', $str);
        $str = preg_replace('/[éèêë]/u',   'e', $str);
        $str = preg_replace('/[îï]/u',     'i', $str);
        $str = preg_replace('/[ôö]/u',     'o', $str);
        $str = preg_replace('/[ùûü]/u',    'u', $str);
        $str = preg_replace('/[ç]/u',      'c', $str);
        $str = preg_replace('/[^a-z0-9]+/', '-', $str);
        return trim($str, '-');
    }


    public function planteLiensBulk(string $id): void {
        $this->requireAdmin();
        $this->verifyCsrf();
        $planteId = (int)$id;
        $model    = new Plante();
        $section  = $_POST['section'] ?? '';
        $db       = Database::getInstance();

        if ($section === 'composants') {
            $db->prepare("DELETE FROM plante_composant WHERE plante_id = ?")->execute([$planteId]);
            foreach ($_POST['composants'] ?? [] as $composantId => $data) {
                if (!empty($data['actif'])) {
                    $model->linkComposant($planteId, (int)$composantId, trim($data['concentration'] ?? ''), '');
                }
            }
            $this->flash('success', 'Composants mis à jour.');

        } elseif ($section === 'vertus') {
            $db->prepare("DELETE FROM plante_vertu WHERE plante_id = ?")->execute([$planteId]);
            foreach ($_POST['vertus'] ?? [] as $vertuId) {
                $model->linkVertu($planteId, (int)$vertuId, '');
            }
            $this->flash('success', 'Vertus mises à jour.');

        } elseif ($section === 'categories') {
            $db->prepare("DELETE FROM plante_categorie WHERE plante_id = ?")->execute([$planteId]);
            foreach ($_POST['categories'] ?? [] as $catId) {
                $model->linkCategorie($planteId, (int)$catId);
            }
            $this->flash('success', 'Catégories mises à jour.');

        } elseif ($section === 'composant_vertu') {
            $composants = $model->composants($planteId);
            foreach ($composants as $comp) {
                $compId = $comp['id'];
                $db->prepare("DELETE FROM composant_vertu WHERE composant_id = ?")->execute([$compId]);
                foreach ($_POST['cv'][$compId] ?? [] as $vertuId) {
                    $model->linkComposantVertu($compId, (int)$vertuId, 'modere');
                }
            }
            $this->flash('success', 'Liens composant → vertu mis à jour.');

        } elseif ($section === 'all') {
            // 1. Composants
            $db->prepare("DELETE FROM plante_composant WHERE plante_id = ?")->execute([$planteId]);
            foreach ($_POST['composants'] ?? [] as $composantId => $data) {
                if (!empty($data['actif'])) {
                    $model->linkComposant($planteId, (int)$composantId, trim($data['concentration'] ?? ''), '');
                }
            }
            // 2. Graphe composant → vertu
            foreach (array_keys($_POST['cv'] ?? []) as $compId) {
                $db->prepare("DELETE FROM composant_vertu WHERE composant_id = ?")->execute([(int)$compId]);
                foreach ($_POST['cv'][(int)$compId] ?? [] as $vertuId) {
                    $model->linkComposantVertu((int)$compId, (int)$vertuId, 'modere');
                }
            }
            // 3. Catégories
            $db->prepare("DELETE FROM plante_categorie WHERE plante_id = ?")->execute([$planteId]);
            foreach ($_POST['categories'] ?? [] as $catId) {
                $model->linkCategorie($planteId, (int)$catId);
            }
            $this->flash('success', 'Tous les liens ont été enregistrés.');
        }

        $this->redirect('/admin/plantes/' . $planteId . '/liens');
    }
}
