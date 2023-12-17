<?php
session_start();


if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["score"]) && isset($_POST["username"])) {
    $score = $_POST["score"];
    $username = $_POST["username"];

    $databasePath = '/var/www/html/sql/minions.db';
    try {
        $db = new PDO("sqlite:$databasePath");
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $db->prepare("INSERT INTO scores (score_value, username) VALUES (:score, :username)");
        $stmt->bindParam(':score', $score);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        echo "Score saved successfully for username: $username";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
