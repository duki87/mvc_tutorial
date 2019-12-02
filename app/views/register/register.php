<?php
  use Core\Validate;
  use Core\Input;
  use Core\FH;
?>
<?php $this->start('head');?>

<?php $this->end();?>

<?php $this->start('body');?>
<div class="container">
  <div class="card col-md-6 mx-auto">
    <img class="card-img-top mx-auto mt-2" style="width:60%;" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTSo2flxVX53kYBFwdp8sqdBBMxGJOuTFJdMnDqYyRxN3v7uvot" alt="Card image cap">
    <div class="card-body">
      <h4 class="card-title">Regiter New User</h4>
      <div class="errors" role="alert"><?=Validate::displayErrors();?></div>
      <form class="form" action="<?=SITE_ROOT;?>register/register" method="post">
        <?=FH::csrfInput();?>
        <?=FH::inputBlock('text', 'First Name', 'fname', Input::getPreviousValues('fname'), ['srOnly' => 'false', 'class' => 'form-control mb-2'], ['class' => 'form-group mx-auto']);?>
        <?=FH::inputBlock('text', 'Last Name', 'lname', Input::getPreviousValues('lname'), ['srOnly' => 'false', 'class' => 'form-control mb-2'], ['class' => 'form-group mx-auto']);?>
        <?=FH::inputBlock('text', 'Email', 'email', Input::getPreviousValues('email'), ['srOnly' => 'false', 'class' => 'form-control mb-2'], ['class' => 'form-group mx-auto']);?>
        <?=FH::inputBlock('text', 'Username', 'username', Input::getPreviousValues('username'), ['srOnly' => 'false', 'class' => 'form-control mb-2'], ['class' => 'form-group mx-auto']);?>
        <?=FH::inputBlock('password', 'Password', 'password', Input::getPreviousValues('password'), ['srOnly' => 'false', 'class' => 'form-control mb-2'], ['class' => 'form-group mx-auto']);?>
        <?=FH::inputBlock('password', 'Confirm Password', 'confirm', Input::getPreviousValues('confirm'), ['srOnly' => 'false', 'class' => 'form-control mb-2'], ['class' => 'form-group mx-auto']);?>
        <?=FH::submitBlock('Register', ['class' => 'btn btn-success'], ['class' => 'form-group mt-2']);?>
        <div class="form-group">
          Already have account? <a href="<?=SITE_ROOT;?>register/login">Login</a> now!
        </div>
      </form>
    </div>

  </div>
</div>
<?php $this->end();?>
