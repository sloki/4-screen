<!DOCTYPE html>
<html>
<head>
    <title><?= $this->escapeHTML($this->title); ?></title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <?= $this->getCSS(); ?>
</head>
<body>
<div id="wrapper">
    <div id="container">
        <div id="header"></div>
        <div id="content">
            <div id="feedback" class="container">
                <?php if (($danger = \App\Helpers\Flash::danger())): ?>
                    <div class="alert alert-danger" role="alert"><strong>Oh snap!</strong> <?= $this->escapeHTML($danger); ?></div>
                <?php
                endif;
                if (($info = \App\Helpers\Flash::info())):
                    ?>
                    <div class="alert alert-info" role="alert"><strong>Heads up!</strong> <?= $this->escapeHTML($info); ?></div>
                <?php
                endif;
                if (($success = \App\Helpers\Flash::success())):
                    ?>
                    <div class="alert alert-success" role="alert"><strong>Success!</strong> <?= $this->escapeHTML($success); ?></div>
                <?php
                endif;
                if (($warning = \App\Helpers\Flash::warning())):
                    ?>
                    <div class="alert alert-warning" role="alert"><strong>Warning!</strong> <?= $this->escapeHTML($warning); ?></div>
                <?php
                endif;
                if ($errors = \App\Helpers\Flash::session(\App\Helpers\Config::get("SESSION_ERRORS"))):
                    ?>
                    <div class="alert alert-danger" role="alert">
                        <h4>Errors:</h4>
                        <ul>
                            <?php foreach ($errors as $key => $values): ?>
                                <?php foreach ($values as $value): ?>
                                    <li><?= $this->escapeHTML($value); ?></li>
                                <?php endforeach; ?>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>