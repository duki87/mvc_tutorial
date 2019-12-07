<?php
  use Core\FH;
  use Core\Input;
  use App\Models\Users;
?>
<?php $this->setSiteTitle(SITE_TITLE . ' | Tools'); ?>
<?php $this->start('head'); ?>
  <!-- <meta content="test"> -->
<?php $this->end(); ?>

<?php $this->start('body'); ?>
<h1 class="text-center text-primary">Your Profile</h1>
<div class="container">
  <form class="" action="<?=SITE_ROOT;?>profile/update" method="post">
    <?=FH::csrfInput();?>
    <div class="row">
      <?=FH::inputBlock('hidden', '', 'user_id', Users::currentUser()->id, ['srOnly' => 'false', 'class' => ''], ['class' => 'd-none']);?>
      <?=FH::inputBlock('hidden', '', 'deleted', Input::getPreviousValues('deleted'), ['srOnly' => 'false', 'class' => ''], ['class' => 'd-none']);?>
      <?=FH::inputBlock('text', 'First Name', 'fname', Input::getPreviousValues('fname'), ['srOnly' => 'false', 'class' => 'form-control mb-2'], ['class' => 'form-group col-md-6']);?>
      <?=FH::inputBlock('text', 'Last Name', 'lname', Input::getPreviousValues('lname'), ['srOnly' => 'false', 'class' => 'form-control mb-2'], ['class' => 'form-group col-md-6']);?>
      <?=FH::inputBlock('email', 'Email Address', 'email', Input::getPreviousValues('email'), ['srOnly' => 'false', 'class' => 'form-control mb-2'], ['class' => 'form-group col-md-4']);?>
      <?=FH::inputBlock('text', 'Username', 'username', Input::getPreviousValues('username'), ['srOnly' => 'false', 'class' => 'form-control mb-2'], ['class' => 'form-group col-md-4']);?>
      <?=FH::inputBlock('text', 'Password', 'password', Input::getPreviousValues(''), ['srOnly' => 'false', 'class' => 'form-control mb-2'], ['class' => 'form-group col-md-4']);?>
      <?=FH::inputBlock('file', 'Profile Image', 'image', Input::getPreviousValues(''), ['srOnly' => 'false', 'class' => 'form-control mb-2'], ['class' => 'form-group col-md-4']);?>
      <?=FH::submitBlock('Edit Data', ['class' => 'btn btn-success'], ['class' => 'form-group col-md-12']);?>
    </div>
  </form>
</div>

<?php $this->end(); ?>
