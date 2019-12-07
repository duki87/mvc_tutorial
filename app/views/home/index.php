<?php
  use Core\Storage; 
  use Core\H;
?>
<?php $this->setSiteTitle(SITE_TITLE . ' | Home'); ?>
<?php $this->start('head'); ?>
  <!-- <meta content="test"> -->
<?php $this->end(); ?>

<?php $this->start('body'); ?>
<h1 class="text-center text-primary">Welcome to Framework Tutorial</h1>
<?php //$file = Storage::disk('public')->read('img/user.jpg');?>
<?php //Storage::disk('public')->put($file, 'img/files/user23.jpg');?>
<?php //Storage::disk('public')->delete('img/user2.jpg');?>
<?php //Storage::disk('public')->mkdir('img/files');?>
<?php //H:dnd(Storage::disk('public')->exists('img/user.jpg'));?>
<?php //Storage::disk('public')->rmdir('img/files');?>
<?php //Storage::disk('public')->move('img/user2.jpg', 'img/files/user2.jpg');?>
<?php //Storage::disk('public')->copy('img/user.jpg', 'img/files/user2.jpg');?>
<?php //$scan = Storage::disk('public')->scan('img/files'); H::dnd($scan);?>
<?php //echo inputBlock('text', 'Your Name', 'your_name', 'Dusan', ['srOnly' => 'false', 'class' => 'form-control mb-2'], ['data-id' => 'yourName', 'class' => 'form-group col-md-6']);?>
<?php //echo submitBlock('Submit', ['class' => 'btn btn-success btn-sm float-right '], ['class' => 'col-md-6 mt-2']);?>
<?php $this->end(); ?>
