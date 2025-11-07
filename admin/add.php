<?php
include "../includes/db.php"; 

if (isset($_POST['submit'])) {
    $hall_id = $_POST['hall_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $capacity = $_POST['capacity'];
    $local = $_POST['local'];
    $price = $_POST['price'];
    $image = $_POST['image'];
    $arabic_title = $_POST['arabic_title'];
    $arabic_description = $_POST['arabic_description'];
    $arabic_local = $_POST['arabic_local'];
    $time = $_POST['time'];
    $arabic_time = $_POST['arabic_time'];

    try {
        $query = $pdo->prepare("INSERT INTO hall (
            hall_id, title, description, capacity, local, price, image, 
            arabic_title, arabic_description, arabic_local, time, arabic_time
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        
        $query->execute([
            $hall_id, $title, $description, $capacity, $local, $price, $image,
            $arabic_title, $arabic_description, $arabic_local, $time, $arabic_time
        ]);

        header("Location: dashbord.php");
        exit;
    } catch (PDOException $e) {
        echo "An error occurred while entering data: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New Hall</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 40px;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            position: relative;
        }

        .form-box {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            max-width: 700px;
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .form-box h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        label {
            font-weight: bold;
            color: #444;
        }

        input, textarea {
            padding: 12px;
            font-size: 15px;
            border-radius: 6px;
            border: 1px solid #ccc;
            width: 100%;
        }

        button {
            background-color: #3498db;
            color: white;
            padding: 12px;
            font-size: 16px;
            font-weight: bold;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

       
    </style>
</head>
<body>

<div class="container">
  

    <form class="form-box" method="POST">
        <h2>Add New Hall</h2>

        <label>Hall ID:</label>
        <input type="text" name="hall_id" required>

        <label>Title:</label>
        <input type="text" name="title" required>

        <label>Description:</label>
        <textarea name="description" required></textarea>

        <label>Capacity:</label>
        <input type="number" name="capacity" required>

        <label>Local:</label>
        <input type="text" name="local" required>

        <label>Price:</label>
        <input type="number" name="price" required>

        <label>Image (URL or filename):</label>
        <input type="text" name="image" required>

        <label>Arabic Title:</label>
        <input type="text" name="arabic_title" required>

        <label>Arabic Description:</label>
        <textarea name="arabic_description" required></textarea>

        <label>Arabic Local:</label>
        <input type="text" name="arabic_local" required>

        <label>Time:</label>
        <input type="text" name="time" required>

        <label>Arabic Time:</label>
        <input type="text" name="arabic_time" required>

        <button type="submit" name="submit">Add Hall</button>
    </form>
</div>

</body>
</html>
