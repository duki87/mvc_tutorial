<?php $this->start('head');?>

<?php $this->end();?>

<?php $this->start('body');?>
<div class="container">
  <div class="card col-md-6 mx-auto">
    <img class="card-img-top mx-auto mt-2" style="width:60%;" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTSo2flxVX53kYBFwdp8sqdBBMxGJOuTFJdMnDqYyRxN3v7uvot" alt="Card image cap">
    <div class="card-body">
      <h4 class="card-title">Regiter New User</h4>
      <div class="errors" role="alert"><?=$this->displayErrors;?></div>
      <form class="form" action="<?=SITE_ROOT;?>register/register" method="post">
        <?=FH::csrfInput();?>
        <div class="form-group">
          <label for="fname">First Name</label>
          <input type="text" name="fname" id="fname" class="form-control" value="<?=$this->post['fname'];?>">
        </div>
        <div class="form-group">
          <label for="lname">Last Name</label>
          <input type="text" name="lname" id="lname" class="form-control" value="<?=$this->post['lname'];?>">
        </div>
        <div class="form-group">
          <label for="email">Email</label>
          <input type="text" name="email" id="email" class="form-control" value="<?=$this->post['email'];?>">
        </div>
        <div class="form-group">
          <label for="">Username</label>
          <input type="text" name="username" id="username" class="form-control" value="<?=$this->post['username'];?>">
        </div>
        <div class="form-group">
          <label for="">Password</label>
          <input type="password" name="password" id="password" class="form-control" value="<?=$this->post['password'];?>">
        </div>
        <div class="form-group">
          <label for="confirm">Confirm Password</label>
          <input type="password" name="confirm" id="confirm" class="form-control" value="<?=$this->post['confirm'];?>">
        </div>
        <div class="form-group mt-2">
          <button style="width:100%" type="submit" class="btn btn-primary">Register</button>
        </div>
        <div class="form-group">
          Already have account? <a href="<?=SITE_ROOT;?>register/login">Login</a> now!
        </div>
      </form>
    </div>

  </div>
</div>
<?php $this->end();?>
