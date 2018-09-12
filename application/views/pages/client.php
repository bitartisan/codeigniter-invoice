<div class="row mx-lg-5">
    <div class="col">
        <h1>Client</h1>
        <a href="<?= base_url('/'); ?>index.php/client_form" class="btn btn-sm btn-primary float-right mb-2">
            <span class="fas fa-user-plus"></span>
            New Client
        </a>
        <div class="table-responsive">
            <?=$this->table->generate($app['client']);?>
        </div>
    </div>
</div>
