<div class="errors" role="alert"><?=$this->displayErrors;?></div>
<form class="" action="<?=$this->postAction;?>" method="post">
  <div class="row">
    <input type="hidden" name="user_id" value="<?=currentUser()->id;?>">
    <?=inputBlock('text', 'First Name', 'fname', $this->contact->fname, ['srOnly' => 'false', 'class' => 'form-control mb-2'], ['class' => 'form-group col-md-4 mx-auto']);?>
    <?=inputBlock('text', 'Last Name', 'lname', $this->contact->lname, ['srOnly' => 'false', 'class' => 'form-control mb-2'], ['class' => 'form-group col-md-4 mx-auto']);?>
    <?=inputBlock('text', 'Email Address', 'email', $this->contact->email, ['srOnly' => 'false', 'class' => 'form-control mb-2'], ['class' => 'form-group col-md-4 mx-auto']);?>
    <?=inputBlock('text', 'Address', 'address', $this->contact->address, ['srOnly' => 'false', 'class' => 'form-control mb-2'], ['class' => 'form-group col-md-3 mx-auto']);?>
    <?=inputBlock('text', 'City', 'city', $this->contact->city, ['srOnly' => 'false', 'class' => 'form-control mb-2'], ['class' => 'form-group col-md-3 mx-auto']);?>
    <?=inputBlock('text', 'Zip Code', 'zip', $this->contact->zip, ['srOnly' => 'false', 'class' => 'form-control mb-2'], ['class' => 'form-group col-md-3 mx-auto']);?>
    <?=inputBlock('text', 'Phone', 'phone', $this->contact->phone, ['srOnly' => 'false', 'class' => 'form-control mb-2'], ['class' => 'form-group col-md-3 mx-auto']);?>
    <?=submitBlock('Add Contact', ['class' => 'btn btn-success'], ['class' => 'form-group col-md-4']);?>
  </div>
</form>
