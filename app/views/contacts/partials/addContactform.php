<?php
  use App\Models\Users;
  use Core\Input;
  use Core\Validate;
  use Core\FH;
?>
<div class="errors" role="alert"><?=Validate::displayErrors();?></div>
<form class="" action="<?=SITE_ROOT;?>contacts/add" method="post">
  <?=FH::csrfInput();?>
  <div class="row">
    <?=FH::inputBlock('hidden', '', 'user_id', Users::currentUser()->id, ['srOnly' => 'false', 'class' => ''], ['class' => 'd-none']);?>
    <?=FH::inputBlock('hidden', '', 'deleted', Input::getPreviousValues('deleted'), ['srOnly' => 'false', 'class' => ''], ['class' => 'd-none']);?>
    <?=FH::inputBlock('text', 'First Name', 'fname', Input::getPreviousValues('fname'), ['srOnly' => 'false', 'class' => 'form-control mb-2'], ['class' => 'form-group col-md-4 mx-auto']);?>
    <?=FH::inputBlock('text', 'Last Name', 'lname', Input::getPreviousValues('lname'), ['srOnly' => 'false', 'class' => 'form-control mb-2'], ['class' => 'form-group col-md-4 mx-auto']);?>
    <?=FH::inputBlock('email', 'Email Address', 'email', Input::getPreviousValues('email'), ['srOnly' => 'false', 'class' => 'form-control mb-2'], ['class' => 'form-group col-md-4 mx-auto']);?>
    <?=FH::inputBlock('text', 'Address', 'address', Input::getPreviousValues('address'), ['srOnly' => 'false', 'class' => 'form-control mb-2'], ['class' => 'form-group col-md-3 mx-auto']);?>
    <?=FH::inputBlock('text', 'City', 'city',Input::getPreviousValues('city'), ['srOnly' => 'false', 'class' => 'form-control mb-2'], ['class' => 'form-group col-md-3 mx-auto']);?>
    <?=FH::inputBlock('text', 'Zip Code', 'zip', Input::getPreviousValues('zip'), ['srOnly' => 'false', 'class' => 'form-control mb-2'], ['class' => 'form-group col-md-3 mx-auto']);?>
    <?=FH::inputBlock('text', 'Phone', 'phone', Input::getPreviousValues('phone'), ['srOnly' => 'false', 'class' => 'form-control mb-2'], ['class' => 'form-group col-md-3 mx-auto']);?>
    <?=FH::submitBlock('Add Contact', ['class' => 'btn btn-success'], ['class' => 'form-group col-md-4']);?>
  </div>
</form>
