<?php

/** @var yii\web\View $this */
/** @var string $content */

use admin\components\Auth\Models\AdminIdentity;
use admin\components\Theme\Assets\DefaultAsset;
use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap4\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use yii\helpers\Url;

DefaultAsset::register($this);

/** @var AdminIdentity $identity */
$identity = \Yii::$app->user->getIdentity();
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<header>
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar navbar-expand-md navbar-dark bg-dark fixed-top',
        ],
        'collapseOptions' => [
                'class' => 'collapse flex-row-reverse navbar-collapse',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav justify-content-end'],
        'items' => [
            ['label' => 'Home', 'url' => Url::toRoute("/root/index")],
            $identity ? (
                ['label' => "Logout [{$identity->username}]", "url" => Url::toRoute("/auth/logout")]
            ) : (
                ['label' => "Login", "url" => Url::toRoute("/auth/login")]
            ),
        ],
    ]);
    NavBar::end();
    ?>
</header>

<main role="main" class="flex-shrink-0">
    <div class="container">
        <?php if ($this->title): ?>
            <div class="row">
                <div class="col">
                    <h2><?= $this->title ?></h2>
                </div>
                <div class="col">
                    <?= $this->params['title-right'] ?? null ?>
                </div>
            </div>
            <hr>
        <?php endif; ?>
        <?= $content ?>
    </div>
</main>

<footer class="footer mt-auto py-3 text-muted">
    <div class="container">
        <p class="float-left">&copy; My Company <?= date('Y') ?></p>
        <p class="float-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
