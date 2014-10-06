<?php $error = $this->Session->flash(); ?>

<?php if (strcmp(strip_tags($error),'')) { ?>
    <div class="alert alert-error"><?php echo $error; ?></div>
<?php } ?>

<?php if (isset($success_message) && strcmp($success_message,'')) { ?>
    <div class="alert alert-success"><?php echo $success_message; ?></div>
<?php } ?>