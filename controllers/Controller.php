<?php
class Controller {
    protected function render($view, $data = []) {
        extract($data);
        require ROOT . '/views/partials/header.php';
        require ROOT . "/views/{$view}.php";
        require ROOT . '/views/partials/footer.php';
    }

    protected function redirect($url) {
        header("Location: {$url}");
        exit;
    }

    protected function resolveMsg($key) {
        $messages = [
            'created' => 'Ajouté avec succès.',
            'updated' => 'Modifié avec succès.',
            'deleted' => 'Supprimé avec succès.',
        ];
        return $messages[$key] ?? '';
    }
}
