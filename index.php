<?php include_once 'Config.php';
use Theatre\Config;
$config = new Config();
$symlink = $config->symlink;
$appName = $config->appName;
$baseUrl = getenv('APP_BASE_URL');

$movies = [];
if(is_dir($symlink)){
    if ($handle = opendir($symlink)) {
        $blacklist = array('.', '..', 'somedir', 'somefile.php');
        while (false !== ($folder = readdir($handle))) {
            if (!in_array($folder, $blacklist)) {
                $index = count($movies);
                $json = file_get_contents($symlink . "/" . $folder . "/index.json");
                if (file_exists($symlink . "/" . $folder . "/poster.jpg")) {
                    $movies[$index]['poster'] = $symlink . "/" . $folder . "/poster.jpg";
                }
                $movies[$index]['folder'] = $folder;
                $movies[$index]['info'] = json_decode($json, true);
            }
        }
        closedir($handle);
    }
} else {
    echo "<center><h4>can't open symlink, check your symlink configuration.</h4></center>";
    // echo "<style>body {display: none;}center {display: block;}</style>";
}

?>
<!DOCTYPE html>
<html lang="id">

<head>
    <title><?= $appName ?></title>
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <link href="https://vjs.zencdn.net/7.8.4/video-js.css" rel="stylesheet" />

    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="theme-color" content="#5e35b1">

    <link href="style.css" rel="stylesheet">
    <script src="app.js"></script>
</head>

<body class="grey darken-4 grey-text text-lighten-4">
    <nav>
        <div class="nav-wrapper deep-purple">
            <a href="<?= $baseUrl ?>" class="brand-logo center"><?= $appName ?></a>

            <a href="#" data-target="slide-out" class="sidenav-trigger hide"><i class="material-icons show-on-med-and-down-only">menu</i></a>
        </div>
    </nav>

    <main>
        <div class="section no-pad-bot" id="index-banner">

            <div class="container">
                <div class="row">
                    <?php foreach ($movies as $movie) : ?>
                        <div class="col s12 m6 l4 xl3">

                            <div class="card large grey darken-3">
                                <div class="card-image large waves-effect waves-block waves-light">
                                    <?php if (array_key_exists('poster', $movie)) : ?>
                                        <img class="activator center-cropped" src="<?= $movie['poster'] ?>">
                                        <span class="card-title activator"><?= $movie['info']['title'] ?></span>
                                    <?php else : ?>
                                        <img class="activator" src="<?= $movie['info']['poster'] ?>">
                                        <span class="card-title activator"><?= $movie['info']['title'] ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="card-content grey darken-3">
                                    <span class="activator grey-text text-lighten-4"><i class="material-icons right">more_vert</i></span>
                                    <p><?= htmlentities(json_encode($movie['info']['description'])) ?></p>
                                    <div class="card-action">
                                        <?php if ($movie['info']['type'] == 'movie') : ?>
                                            <a href="<?= $baseUrl . "watch.php?v=" . rawurlencode($movie['folder']) ?>" class="blue-text">Tonton</a>
                                        <?php else : ?>
                                            <a href="<?= $baseUrl . "watch.php?v=" . rawurlencode($movie['folder']) ?>&e=1" class="blue-text">Tonton</a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="card-reveal grey darken-3">
                                    <span class="card-title grey-text text-lighten-4"><?= $movie['info']['title'] ?><i class="material-icons right">close</i></span>
                                    <h6><?= $movie['info']['year'] ?></h6>
                                    <p><?= htmlentities(json_encode($movie['info']['description'])) ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>

                </div>
            </div>
        </div>
    </main>
</body>

</html>