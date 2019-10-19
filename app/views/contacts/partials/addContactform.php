<div class="errors" role="alert"><?=$this->displayErrors;?></div>
<form class="" action="<?=$this->postAction;?>" method="post">
  <div class="row">
    <?=inputBlock('hidden', '', 'user_id', currentUser()->id, ['srOnly' => 'false', 'class' => ''], ['class' => 'd-none']);?>
    <?=inputBlock('hidden', '', 'deleted', 0, ['srOnly' => 'false', 'class' => ''], ['class' => 'd-none']);?>
    <?=inputBlock('text', 'First Name', 'fname', $this->post['fname'], ['srOnly' => 'false', 'class' => 'form-control mb-2'], ['class' => 'form-group col-md-4 mx-auto']);?>
    <?=inputBlock('text', 'Last Name', 'lname', $this->post['lname'], ['srOnly' => 'false', 'class' => 'form-control mb-2'], ['class' => 'form-group col-md-4 mx-auto']);?>
    <?=inputBlock('email', 'Email Address', 'email', $this->post['email'], ['srOnly' => 'false', 'class' => 'form-control mb-2'], ['class' => 'form-group col-md-4 mx-auto']);?>
    <?=inputBlock('text', 'Address', 'address', $this->post['address'], ['srOnly' => 'false', 'class' => 'form-control mb-2'], ['class' => 'form-group col-md-3 mx-auto']);?>
    <?=inputBlock('text', 'City', 'city', $this->post['city'], ['srOnly' => 'false', 'class' => 'form-control mb-2'], ['class' => 'form-group col-md-3 mx-auto']);?>
    <?=inputBlock('text', 'Zip Code', 'zip', $this->post['zip'], ['srOnly' => 'false', 'class' => 'form-control mb-2'], ['class' => 'form-group col-md-3 mx-auto']);?>
    <?=inputBlock('text', 'Phone', 'phone', $this->post['phone'], ['srOnly' => 'false', 'class' => 'form-control mb-2'], ['class' => 'form-group col-md-3 mx-auto']);?>
    <?=submitBlock('Add Contact', ['class' => 'btn btn-success'], ['class' => 'form-group col-md-4']);?>
  </div>
</form>
