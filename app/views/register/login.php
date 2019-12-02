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
      <h4 class="card-title">Login</h4>
      <div class="errors" role="alert"><?=Validate::displayErrors();?></div>
      <form class="form" action="<?=SITE_ROOT;?>register/login" method="post">
        <?=FH::csrfInput();?>
        <?=FH::inputBlock('text', 'Username', 'username', Input::getPreviousValues('username'), ['srOnly' => 'false', 'class' => 'form-control'], ['class' => 'form-group']);?>
        <?=FH::inputBlock('password', 'Password', 'password', Input::getPreviousValues('password'), ['srOnly' => 'false', 'class' => 'form-control'], ['class' => 'form-group']);?>
        <?php //FH::inputBlock('checkbox', 'Password', 'remember_me', $this->newUser->username, ['srOnly' => 'false', 'class' => 'form-control'], ['class' => 'form-group']);?>
        <div class="form-check">
          <input type="checkbox" class="form-check-input" id="remember_me" name="remember_me" value="on">
          <label class="form-check-label" for="remember_me">Remember me</label>
        </div>
        <?=FH::submitBlock('Sign In', ['class' => 'btn btn-success'], ['class' => 'form-group mt-2']);?>
        <div class="form-group">
          Don' t have account? <a href="<?=SITE_ROOT;?>register/register">Register</a> now!
        </div>
      </form>
    </div>

  </div>
</div>

<?php $this->end();?>
