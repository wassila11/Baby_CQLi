<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["username"])) {
    $username = $_GET["username"];

    $databasePath = '/var/www/html/sql/minions.db';
    try {
        $db = new PDO("sqlite:$databasePath");
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $db->prepare("SELECT * FROM scores WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            echo json_encode(['exists' => true]);
        } else {
            echo json_encode(['exists' => false]);
        }
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Error checking username']);
    }
}
?>
