<?php
require_once ROOT . '/config/Database.php';

class Categorie {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function findAll() {
        return $this->db->query("
            SELECT c.*, COUNT(a.id) AS nb_articles
            FROM Categorie c LEFT JOIN Article a ON a.categorie = c.id
            GROUP BY c.id ORDER BY c.libelle
        ")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById($id) {
        $stmt = $this->db->prepare("SELECT * FROM Categorie WHERE id=?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($libelle) {
        $stmt = $this->db->prepare("INSERT INTO Categorie (libelle) VALUES (?)");
        return $stmt->execute([$libelle]);
    }

    public function update($id, $libelle) {
        $stmt = $this->db->prepare("UPDATE Categorie SET libelle=? WHERE id=?");
        return $stmt->execute([$libelle, $id]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM Categorie WHERE id=?");
        return $stmt->execute([$id]);
    }

    public function hasArticles($id) {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM Article WHERE categorie=?");
        $stmt->execute([$id]);
        return $stmt->fetchColumn() > 0;
    }
}
