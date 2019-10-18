<?php $this->setSiteTitle(SITE_TITLE . ' | Home'); ?>
<?php $this->start('head'); ?>
  <!-- <meta content="test"> -->
<?php $this->end(); ?>

<?php $this->start('body'); ?>
<h1 class="text-center text-primary">Welcome to Framework Tutorial</h1>
<?php echo inputBlock('text', 'Your Name', 'your_name', 'Dusan', ['srOnly' => 'false', 'class' => 'form-control mb-2'], ['data-id' => 'yourName', 'class' => 'form-group col-md-6']);?>
<?php echo submitBlock('Submit', ['class' => 'btn btn-success btn-sm float-right '], ['class' => 'col-md-6 mt-2']);?>
<?php $this->end(); ?>
