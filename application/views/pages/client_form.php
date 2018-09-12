<div class="row mx-lg-5">
    <div class="col">
        <h1>Add Client</h1>

        <?php
        $form_attr = [
            'name' => 'client',
            'id' => 'frm_client',
            'class' => 'form-data',
        ];
        ?>

        <?=form_open('form/save_client', $form_attr);?>
            <?php foreach($app['client_form']['hidden_values'] as $hidden_field): ?>
                <?= $hidden_field; ?>
            <?php endforeach; ?>

            <?php foreach($app['client_form']['display_values'] as $label => $field): ?>
                <div class="row my-3">
                    <div class="col-sm-1">
                        <?= $label; ?>
                    </div>
                    <div class="col-sm-4">
                        <?= $field; ?>
                    </div>
                </div>
            <?php endforeach; ?>

            <div class="row my-3">
                <div class="offset-sm-1 col-sm-4">
                    <button type="submit" name="submit_form" class="btn btn-sm btn-success">
                        <span class="fas fa-save"></span> Save Client
                    </button>
                </div>
            </div>

        <?=form_close(); ?>
    </div>
</div>
