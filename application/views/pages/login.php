<div class="row p-5">
    <div class="col text-center">
        <?php
        // try approval_prompt=force for a new refresh_token ?
        ?>
        <a id="login" href="<?php echo str_replace('=auto', '=force', $app['loginurl']); ?>">Login With Google</a>
    </div>
</div>
