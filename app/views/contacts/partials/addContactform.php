<div class="errors" role="alert"><?=$this->displayErrors;?></div>
<form class="" action="<?=$this->postAction;?>" method="post">
  <?=FH::csrfInput();?>
  <div class="row">
    <?=FH::inputBlock('hidden', '', 'user_id', Users::currentUser()->id, ['srOnly' => 'false', 'class' => ''], ['class' => 'd-none']);?>
    <?=FH::inputBlock('hidden', '', 'deleted', 0, ['srOnly' => 'false', 'class' => ''], ['class' => 'd-none']);?>
    <?=FH::inputBlock('text', 'First Name', 'fname', $this->post['fname'], ['srOnly' => 'false', 'class' => 'form-control mb-2'], ['class' => 'form-group col-md-4 mx-auto']);?>
    <?=FH::inputBlock('text', 'Last Name', 'lname', $this->post['lname'], ['srOnly' => 'false', 'class' => 'form-control mb-2'], ['class' => 'form-group col-md-4 mx-auto']);?>
    <?=FH::inputBlock('email', 'Email Address', 'email', $this->post['email'], ['srOnly' => 'false', 'class' => 'form-control mb-2'], ['class' => 'form-group col-md-4 mx-auto']);?>
    <?=FH::inputBlock('text', 'Address', 'address', $this->post['address'], ['srOnly' => 'false', 'class' => 'form-control mb-2'], ['class' => 'form-group col-md-3 mx-auto']);?>
    <?=FH::inputBlock('text', 'City', 'city', $this->post['city'], ['srOnly' => 'false', 'class' => 'form-control mb-2'], ['class' => 'form-group col-md-3 mx-auto']);?>
    <?=FH::inputBlock('text', 'Zip Code', 'zip', $this->post['zip'], ['srOnly' => 'false', 'class' => 'form-control mb-2'], ['class' => 'form-group col-md-3 mx-auto']);?>
    <?=FH::inputBlock('text', 'Phone', 'phone', $this->post['phone'], ['srOnly' => 'false', 'class' => 'form-control mb-2'], ['class' => 'form-group col-md-3 mx-auto']);?>
    <?=FH::submitBlock('Add Contact', ['class' => 'btn btn-success'], ['class' => 'form-group col-md-4']);?>
  </div>
</form>
