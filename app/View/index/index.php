<div class="container">

    <div class="jumbotron">
        <h1> <?= $this->escapeHTML($this->title); ?></h1>
        <br>
        <p>
            <a class="btn btn-default btn-lg" href="<?= $this->makeUrl('login'); ?>" role="button">Login</a>
            <a class="btn btn-primary btn-lg" href="<?= $this->makeUrl('register'); ?>" role="button">Register</a>
        </p>
    </div>
</div>