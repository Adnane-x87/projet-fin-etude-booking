<?php
include '../includes/db.php';

if (isset($_GET['hall_id'])) {
    $id = (int) $_GET['hall_id'];

    try {
        $query = "DELETE FROM hall WHERE hall_id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            header("Location: dashbord.php");
            exit();
        } else {
            echo "Error: Could not delete the record.";
        }
    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
    }
} else {
    echo "Error: ID is missing.";
}
?>
