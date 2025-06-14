<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Assets/Css/base.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title><?php $title ?></title>
</head>
<body>
    <header>
    <?php require_once("Views/Components/navBar.php")   ?>
    </header>
    <main>
        <?php require_once("$template"); ?>
    </main>
    <footer>
     <?php require_once("Views/Components/footer.php")   ?>
    </footer>
</body>
</html>