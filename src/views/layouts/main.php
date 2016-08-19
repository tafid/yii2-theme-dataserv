<?php

/* @var $this \yii\web\View */
/* @var $content string */

use hiqdev\pnotify\Alert;
use hiqdev\yii2\cart\widgets\PanelTopCart;
use hiqdev\yii2\language\widgets\LanguageMenu;
use hisite\modules\news\widgets\NewsRotatorWidget;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Menu;

$menuItems = [
    ['label' => Yii::t('hisite', 'Domains'), 'url' => '#', 'items' => [
        ['label' => Yii::t('hisite', 'Prices'), 'url' => ['/domain/prices']],
        ['label' => Yii::t('hisite', 'Advantages'), 'url' => ['/domain/advantages']],
        ['label' => Yii::t('hisite', 'Transfer'), 'url' => ['/domainchecker/transfer/index']],
        ['label' => Yii::t('hisite', 'Premium Package'), 'url' => ['/domain/premium-package']],
//        ['label' => Yii::t('hisite', 'Whois lookup'), 'url' => ['/domain/whois-lookup']],
    ]],
    ['label' => Yii::t('hisite', 'Hosting'), 'url' => '#', 'items' => [
        ['label' => Yii::t('hisite', 'XEN SSD'), 'url' => ['/hosting/xen-ssd']],
        ['label' => Yii::t('hisite', 'OpenVZ'), 'url' => ['/hosting/open-vz']],
        ['label' => Yii::t('hisite', 'Tariffs details'), 'url' => ['/hosting/tariffs-details']],
        ['label' => Yii::t('hisite', 'Advantages'), 'url' => ['/hosting/advantages']],
        ['label' => Yii::t('hisite', 'What is VDS'), 'url' => ['/hosting/what-is-vds']],
    ]],
    ['label' => Yii::t('hisite', 'For resellers'), 'url' => '#', 'items' => [
        ['label' => Yii::t('hisite', 'Prices'), 'url' => ['/reseller/prices']],
        ['label' => Yii::t('hisite', 'Advantages'), 'url' => ['/reseller/advantages']],
        ['label' => Yii::t('hisite', 'API'), 'url' => ['/reseller/api']],
    ]],
    ['label' => Yii::t('hisite', 'News'), 'url' => '/news/article/index'],
    ['label' => Yii::t('hisite', 'Help'), 'url' => '#', 'items' => [
        ['label' => Yii::t('hisite', 'FAQ'), 'url' => ['/help/faq']],
    ]],
];

Yii::$app->get('themeManager')->registerAssets();

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<?= Alert::widget() ?>
<!-- TOP NAV -->
<div class="topmenu">
    <div class="row">
        <div class="col-sm-3">
            <ul class="top left">
                <li><i class="fa fa-envelope-o"></i> 24/7 <?= Yii::t('hisite', 'tech support') ?> <?= Html::mailto('support@ahnames.com', 'support@ahnames.com') ?></li>
            </ul>
        </div>
        <div class="col-sm-9">
            <ul class="topright">
                <?= PanelTopCart::widget() ?>
                <?php if (Yii::$app->user->isGuest) : ?>
                    <li><i class="fa fa-unlock-alt"></i> <a href="#" data-toggle="modal" data-target="#LoginModal">CLIENT AREA</a></li>
                <?php else : ?>
                    <li><?= Html::a(Yii::t('hisite', 'PANEL'), '#'); ?></li>
                <?php endif; ?>
                <!--li><i class="fa fa-commenting-o"></i> <a href="#"><?= Yii::t('hisite', 'ONLINE CHAT') ?></a></li-->
                <?= LanguageMenu::widget() ?>
            </ul>
        </div>
    </div>
</div>
<!-- END OF TOP NAV -->

<!-- HEADER -->
<div class="header">
    <div class="row">
        <div class="col-sm-3">
            <div class="logo">
                <a href="/"><?= Html::img(Yii::$app->assetManager->publish('@hiqdev/themes/dataserv/assets/images/logo.png')[1]) ?></a>
            </div>
        </div>
        <div class="col-sm-9">

            <nav id="desktop-menu">
                <?= Yii::$app->menuManager->main->render([
                    'class' => Menu::class,
                    'options' => ['class' => 'sf-menu', 'id' => 'navigation'],
                    'activeCssClass' => 'current',
                ]) ?>
            </nav>
        </div>
    </div>
</div>
<!-- END OF HEADER -->

<?php if (!Yii::$app->get('themeManager')->isHomePage()) : ?>
    <?php if ($this->blocks['subHeaderClass'] != 'domainavailability') : ?>
        <div id="subheader" class="<?= $this->blocks['subHeaderClass'] ? : 'blog' ?>">
            <div class="subheader-text">
                <?= Html::tag('h1', $this->title) ?>
                <?= Html::tag('h2', $this->blocks['subTitle']) ?>
            </div>

            <?php if ($this->context->id == 'news' && $this->context->action->id == 'view') : ?>
                <a href="#" rel="shared-popover" data-popover-content="#shared-btn-Popover" title="Share" data-placement="bottom" class="mtr-btn button-circle button-fab ripple"><i class="fa fa-share-alt"></i></a>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <div class="domainavailability">
            <div class="row">
                <div class="col-sm-12 col-md-9 center-block">
                    <?= Html::tag('h1', $this->title, ['class' => 'text-center']) ?>
                    <div class="domain-form-container">
                        <?= \app\widgets\DomainSearchForm::widget([
                            'dropDownZonesOptions' => !empty($this->blocks['dropDownZonesOptions']) ? $this->blocks['dropDownZonesOptions'] : null
                        ]) ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif ?>
<?php endif ?>

<?= $content ?>

<!-- FOOTER -->
<div class="footer">
    <div class="row">
        <?php foreach (Yii::$app->menuManager->footer->getItems() as $item) : ?>
            <div class="col-sm-3">
                <?php if ($item['url']==='#') : ?>
                    <h4><?= $item['label'] ?></h4>
                <?php else : ?>
                    <h4><a href="<?= Url::to($item['url']) ?>"><?= $item['label'] ?></a></h4>
                <?php endif ?>
                <?php if (isset($item['items'])) : ?>
                    <?= Menu::widget([
                        'items' => $menuItems[0]['items'],
                    ]) ?>
                <?php endif ?>
            </div>
        <?php endforeach ?>
    </div>
</div>
<!-- END FOOTER -->

<!-- SOCIAL & COPYRIGHT -->
<div class="social">
    <div class="row">
        <div class="col-sm-12">
            <ul class="social-links">
            <?php foreach (['twitter', 'facebook', 'vk', 'youtube', 'instagram', 'pinterest', 'github'] as $name) : ?>
                <?php $icon = $name === 'github' ? 'github-alt' : $name ?>
                <?php $link = $name . '_link' ?>
                <?php if (isset(Yii::$app->params[$link]) && Yii::$app->params[$link]) : ?>
                    <li><a href="<?= Yii::$app->params[$link] ?>" title="<?= ucfirst($name) ?>"><i class="fa fa-<?= $icon ?>"></i></a></li>
                <?php endif ?>
            <?php endforeach ?>
            </ul>
            <p class="text-center">© <?= date('Y') ?> <?= Yii::$app->params['orgName'] ?>. All rights reserved.</p>
        </div>
    </div>
</div>
<!-- END OF SOCIAL & COPYRIGHT -->

<!-- LOGIN MODAL -->
<div class="modal fade" id="LoginModal" tabindex="-1" role="dialog" aria-labelledby="LoginModal">
    <div class="modal-dialog" role="document">
        <form method="post" action="http://whmcs.audemedia.com/dologin.php?systpl=dataservwhmcs" class="material">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel"><i class="fa fa-lock"></i>LOGIN TO YOUR ACCOUNT</h4>
                </div>
                <div class="modal-body">
                    <input type="text" name="username" placeholder="E-mail Address">
                    <input type="password" name="password" placeholder="Password">
                    <button type="submit" class="mtr-btn button-fab">LOGIN</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- END OF LOGIN MODAL -->
<a href="#top" id="back-to-top" class="ripple"><i class="fa fa-angle-up"></i></a>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
