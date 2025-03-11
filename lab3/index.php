<?php  
$dir = 'images/';
$files = scandir($dir);

if ($files === false) {
    echo "Ошибка: не удалось открыть папку с изображениями!";
    $files = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=Б, initial-scale=1.0">
    <title>SpongeBob</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Sponge Bob Gallery</h1>
        <p>About | News | Series</p>
    </header>
    <main>
        <div class="gallery">
            <?php
            for ($i = 0; $i < count($files); $i++) {
                if ($files[$i] !== "." && $files[$i] !== ".." && preg_match('/\.(jpg|jpeg|png|gif)$/i', $files[$i])) {
                    $path = $dir . $files[$i];
            ?>
            <div class="image">
                <img src="<?php echo $path ?>" alt="Изображение">
            </div>
                    <?php
                }
            }
            ?>
        </div>
    </main>
    <footer>
        <p>© 2025</p>
    </footer>
</body>
</html>
