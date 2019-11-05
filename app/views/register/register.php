<?php $this->start('head');?>

<?php $this->end();?>

<?php $this->start('body');?>
<div class="container">
  <div class="card col-md-6 mx-auto">
    <img class="card-img-top mx-auto mt-2" style="width:60%;" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTSo2flxVX53kYBFwdp8sqdBBMxGJOuTFJdMnDqYyRxN3v7uvot" alt="Card image cap">
    <div class="card-body">
      <h4 class="card-title">Regiter New User</h4>
      <div class="errors" role="alert"><?=isset($_SESSION['formErrors']) ? FH::displayErrors($_SESSION['formErrors']) : '';?></div>
      <form class="form" action="<?=SITE_ROOT;?>register/register" method="post">
        <?=FH::csrfInput();?>
        <?=FH::inputBlock('text', 'First Name', 'fname', $this->inputs->getInputValues('fname'), ['srOnly' => 'false', 'class' => 'form-control mb-2'], ['class' => 'form-group mx-auto']);?>
        <?=FH::inputBlock('text', 'Last Name', 'lname', $this->inputs->getInputValues('lname'), ['srOnly' => 'false', 'class' => 'form-control mb-2'], ['class' => 'form-group mx-auto']);?>
        <?=FH::inputBlock('text', 'Email', 'email', $this->inputs->getInputValues('email'), ['srOnly' => 'false', 'class' => 'form-control mb-2'], ['class' => 'form-group mx-auto']);?>
        <?=FH::inputBlock('text', 'Username', 'username', $this->inputs->getInputValues('username'), ['srOnly' => 'false', 'class' => 'form-control mb-2'], ['class' => 'form-group mx-auto']);?>
        <?=FH::inputBlock('password', 'Password', 'password', $this->inputs->getInputValues('password'), ['srOnly' => 'false', 'class' => 'form-control mb-2'], ['class' => 'form-group mx-auto']);?>
        <?=FH::inputBlock('password', 'Confirm Password', 'confirm', $this->newUser->getConfirm(), ['srOnly' => 'false', 'class' => 'form-control mb-2'], ['class' => 'form-group mx-auto']);?>
        <?=FH::submitBlock('Register', ['class' => 'btn btn-success'], ['class' => 'form-group mt-2']);?>
        <div class="form-group">
          Already have account? <a href="<?=SITE_ROOT;?>register/login">Login</a> now!
        </div>
      </form>
    </div>

  </div>
</div>
<?php $this->end();?>
