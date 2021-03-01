<?php include_once 'Config.php';
use Theatre\Config;
$config = new Config();
$symlink = $config->symlink;
$appName = $config->appName;
$baseUrl = getenv('APP_BASE_URL');

$requestedMovie = htmlspecialchars($_GET["v"]);
$string = file_get_contents($symlink."/" . $requestedMovie . "/index.json");
$movieInfo = json_decode($string, true);

if ($movieInfo['type'] != 'movie') {
    $requestedEpisode = intval(htmlspecialchars($_GET["e"])) - 1;
    $dummyIndex = 0;
}
$poster = $symlink."/".$requestedMovie . "/poster.jpg";
if (!file_exists($poster)){
    $poster = $movieInfo['poster'];
}

?>
<!DOCTYPE html>
<html>

<head>
    <title><?= $requestedMovie . " - " . $appName ?></title>
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
            <a href="#" onclick="goBack()" style="display:block" class="sidenav-trigger"><i class="material-icons">arrow_back</i></a>
        </div>
    </nav>

    <main>
        <video style="width: 100% !important;" class="responsive-video" controls preload="auto" autoplay controlsList="nodownload" poster="<?= $poster?>">
            <?php if ($movieInfo['type'] == 'movie') : ?>
                <source src="<?= $symlink."/".$requestedMovie . "/" . $movieInfo['filename'] ?>" type="<?= $movieInfo['format'] ?>" />
                <?php if (count($movieInfo['subtitles']) != 0) : ?>
                    <?php foreach ($movieInfo['subtitles'] as $subtitle) : ?>
                        <track label="<?= $subtitle['country'] ?>" kind="subtitles" srclang="en" src="<?= $symlink."/".$requestedMovie . "/" . $subtitle['src'] ?>" default>
                    <?php endforeach; ?>
                <?php endif; ?>

            <?php else : ?>
                <source src="<?= $symlink."/".$requestedMovie . "/" . $movieInfo['files'][$requestedEpisode]['filename'] ?>" type="<?= $movieInfo['files'][$requestedEpisode]['format'] ?>" />
                <?php if (count($movieInfo['files'][$requestedEpisode]['subtitles']) != 0) : ?>
                    <?php foreach ($movieInfo['files'][$requestedEpisode]['subtitles'] as $subtitle) : ?>
                        <track label="<?= $subtitle['country'] ?>" kind="subtitles" srclang="en" src="<?= $symlink."/".$requestedMovie . "/" . $subtitle['src'] ?>" default>
                    <?php endforeach; ?>
                <?php endif; ?>
            <?php endif; ?>

            <p class="vjs-no-js">
                To view this video please enable JavaScript, and consider upgrading to a
                web browser that
                <a href="https://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
            </p>
        </video>

        <br><br>

        <div class="container">
            <div class="row">
                <?php if ($movieInfo['type'] == 'movie') : ?>
                    <div class="col s12">
                        <h5><?= $movieInfo['title'] ?> (<?= $movieInfo['year'] ?>)</h5>
                        <p><?= $movieInfo['description'] ?></p>
                    </div>
                <?php else : ?>
                    <div class="col s12 m6 l8 xl8">
                        <h5><?= $movieInfo['title'] ?> (<?= $movieInfo['year'] ?>)</h5>
                        <h5><?= $movieInfo['files'][$requestedEpisode]['title']?></h5>
                        <p><?= $movieInfo['description'] ?></p>
                    </div>
                    <div class="col s12 m6 l4 xl 4">
                        <ul class="collection with-header grey">
                            <li class="collection-header grey darken-4" style="border: 1px solid #212121 !important;">
                                <h5>
                                    <?= $movieInfo['title'] ?> Playlist
                                </h5>
                            </li>

                            <?php foreach ($movieInfo['files'] as $episode) : ?>
                                <?php //$dummyIndex++ ?>
                                <?php if ($requestedEpisode == $dummyIndex) : ?>
                                    <li class="collection-item grey darken-3">
                                        <div><b><?= $episode['title'] ?></b><a href="#!" class="secondary-content disabled"><i class="material-icons blue-text">play_circle</i></a></div>
                                    </li>
                                <?php else : ?>
                                    <li class="collection-item grey darken-4">
                                        <div><?= $episode['title'] ?><a onclick="toEpisode('<?= $baseUrl . "watch.php?v=" . rawurlencode($requestedMovie) . "&e=" . ($dummyIndex + 1) ?>'); return false;" class="secondary-content"><i class="material-icons white-text">play_circle</i></a></div>
                                    </li>
                                <?php endif; ?>

                                <?php $dummyIndex++ ?>
                            <?php endforeach; ?>

                        </ul>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>
</body>

</html>