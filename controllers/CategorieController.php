<?php
require_once ROOT . '/controllers/Controller.php';
require_once ROOT . '/models/Categorie.php';

class CategorieController extends Controller {
    private $categorieModel;

    public function __construct() {
        $this->categorieModel = new Categorie();
    }

    public function index() {
        $categories = $this->categorieModel->findAll();
        $msg        = $this->resolveMsg($_GET['success'] ?? '');
        $this->render('categories/index', compact('categories', 'msg'));
    }

    public function create() {
        $errors  = [];
        $libelle = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $libelle = trim($_POST['libelle'] ?? '');
            if (!$libelle)           $errors[] = 'Le libellé est obligatoire.';
            if (strlen($libelle) > 20) $errors[] = 'Max 20 caractères.';

            if (empty($errors)) {
                $this->categorieModel->create($libelle);
                $this->redirect('index.php?controller=categorie&action=index&success=created');
            }
        }

        $this->render('categories/create', compact('errors', 'libelle'));
    }

    public function edit() {
        $id        = (int)($_GET['id'] ?? 0);
        $categorie = $this->categorieModel->findById($id);
        if (!$categorie) $this->redirect('index.php?controller=categorie&action=index');

        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $categorie['libelle'] = trim($_POST['libelle'] ?? '');
            if (!$categorie['libelle'])           $errors[] = 'Le libellé est obligatoire.';
            if (strlen($categorie['libelle']) > 20) $errors[] = 'Max 20 caractères.';

            if (empty($errors)) {
                $this->categorieModel->update($id, $categorie['libelle']);
                $this->redirect('index.php?controller=categorie&action=index&success=updated');
            }
        }

        $this->render('categories/edit', compact('categorie', 'errors', 'id'));
    }

    public function delete() {
        $id = (int)($_GET['id'] ?? 0);
        if ($id > 0 && !$this->categorieModel->hasArticles($id)) {
            $this->categorieModel->delete($id);
        }
        $this->redirect('index.php?controller=categorie&action=index&success=deleted');
    }
}
