<?php
require_once ROOT . '/controllers/Controller.php';
require_once ROOT . '/models/Article.php';
require_once ROOT . '/models/Categorie.php';

class ArticleController extends Controller {
    private $articleModel;
    private $categorieModel;

    public function __construct() {
        $this->articleModel  = new Article();
        $this->categorieModel = new Categorie();
    }

    public function index() {
        $catId     = isset($_GET['cat']) ? (int)$_GET['cat'] : 0;
        $articles   = $this->articleModel->findAll($catId ?: null);
        $categories = $this->categorieModel->findAll();
        $this->render('articles/index', compact('articles', 'categories', 'catId'));
    }

    public function admin() {
        $articles = $this->articleModel->findAll();
        $msg      = $this->resolveMsg($_GET['success'] ?? '');
        $this->render('articles/admin', compact('articles', 'msg'));
    }

    public function create() {
        $categories = $this->categorieModel->findAll();
        $errors     = [];
        $data       = ['titre' => '', 'contenu' => '', 'categorie' => 0];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data['titre']    = trim($_POST['titre'] ?? '');
            $data['contenu']  = trim($_POST['contenu'] ?? '');
            $data['categorie'] = (int)($_POST['categorie'] ?? 0);

            if (!$data['titre'])    $errors[] = 'Le titre est obligatoire.';
            if (!$data['contenu'])  $errors[] = 'Le contenu est obligatoire.';
            if (!$data['categorie']) $errors[] = 'Choisissez une catégorie.';

            if (empty($errors)) {
                $this->articleModel->create($data['titre'], $data['contenu'], $data['categorie']);
                $this->redirect('index.php?controller=article&action=admin&success=created');
            }
        }

        $this->render('articles/create', compact('categories', 'errors', 'data'));
    }

    public function edit() {
        $id      = (int)($_GET['id'] ?? 0);
        $article = $this->articleModel->findById($id);
        if (!$article) $this->redirect('index.php?controller=article&action=admin');

        $categories = $this->categorieModel->findAll();
        $errors     = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $article['titre']    = trim($_POST['titre'] ?? '');
            $article['contenu']  = trim($_POST['contenu'] ?? '');
            $article['categorie'] = (int)($_POST['categorie'] ?? 0);

            if (!$article['titre'])    $errors[] = 'Le titre est obligatoire.';
            if (!$article['contenu'])  $errors[] = 'Le contenu est obligatoire.';
            if (!$article['categorie']) $errors[] = 'Choisissez une catégorie.';

            if (empty($errors)) {
                $this->articleModel->update($id, $article['titre'], $article['contenu'], $article['categorie']);
                $this->redirect('index.php?controller=article&action=admin&success=updated');
            }
        }

        $this->render('articles/edit', compact('article', 'categories', 'errors', 'id'));
    }

    public function delete() {
        $id  = (int)($_GET['id'] ?? 0);
        $ref = $_GET['ref'] ?? '';
        if ($id > 0) $this->articleModel->delete($id);

        $target = $ref === 'index'
            ? 'index.php?controller=article&action=index&success=deleted'
            : 'index.php?controller=article&action=admin&success=deleted';
        $this->redirect($target);
    }
}
