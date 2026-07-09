<?php
require_once ROOT . '/config/Database.php';

class Article {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function findAll($categorieId = null) {
        if ($categorieId) {
            $stmt = $this->db->prepare("
                SELECT a.*, c.libelle AS categorie_nom
                FROM Article a JOIN Categorie c ON a.categorie = c.id
                WHERE a.categorie = ?
                ORDER BY a.dateCreation DESC
            ");
            $stmt->execute([$categorieId]);
        } else {
            $stmt = $this->db->query("
                SELECT a.*, c.libelle AS categorie_nom
                FROM Article a JOIN Categorie c ON a.categorie = c.id
                ORDER BY a.dateCreation DESC
            ");
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById($id) {
        $stmt = $this->db->prepare("SELECT * FROM Article WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($titre, $contenu, $categorie) {
        $stmt = $this->db->prepare("INSERT INTO Article (titre, contenu, categorie) VALUES (?, ?, ?)");
        return $stmt->execute([$titre, $contenu, $categorie]);
    }

    public function update($id, $titre, $contenu, $categorie) {
        $stmt = $this->db->prepare("
            UPDATE Article SET titre=?, contenu=?, categorie=?, dateModification=NOW()
            WHERE id=?
        ");
        return $stmt->execute([$titre, $contenu, $categorie, $id]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM Article WHERE id=?");
        return $stmt->execute([$id]);
    }
}
