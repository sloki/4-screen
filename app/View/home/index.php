<div class="container">
    <div class="row">
        <div class="col-md-offset-4 col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title text-center"><?= $this->welcome ?></h3>
                </div>
                <div class="panel-body">
                    <form action="<?= $this->makeUrl("home/search"); ?>" method="post">
                        <div class="form-group">
                            <label for="email-input">Text <span class="text-danger">*</span></label>
                            <input type="text" id="email-input" class="form-control" name="term" />
                        </div>
                        <input type="hidden" name="csrf_token" value="<?= \App\Helpers\Token::generate(); ?>" />
                        <button type="submit" class="btn btn-primary">Search</button>
                        <a href="<?= $this->makeUrl("login/logout"); ?>" class="btn btn-link">Logout</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>