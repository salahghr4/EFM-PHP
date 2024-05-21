<?php
require_once 'config.php';

if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    try {

        $sql = "DELETE FROM stagiaire WHERE idStagiaire = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$_GET['id']]);
        header("Location: espaceprivee.php");
        
    } catch(PDOException $e) {
        $e->getMessage();
    }
}