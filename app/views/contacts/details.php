<?php $this->setSiteTitle(SITE_TITLE . ' | Contact Details: '.$this->contact->fname.' '.$this->contact->lname); ?>
<?php $this->start('head'); ?>
  <!-- <meta content="test"> -->
<?php $this->end(); ?>

<?php $this->start('body'); ?>
<h1 class="text-center text-primary">Contact Details: <?=$this->contact->fname.' '.$this->contact->lname;?></h1>
<div class="text-center">
  <a href="<?=SITE_ROOT.'contacts';?>" class="">Back to Contacts</a>
</div>

<div class="container">
  <div class="row">
    <div class="card mx-auto" style="width: 25rem;">
      <div class="card-header background-primary">
        <img src="<?=SITE_ROOT.'public/img/user.jpg';?>" class="card-img-top" alt="...">
      </div>
      <ul class="list-group list-group-flush">
        <li class="list-group-item">
          <span class="float-left">First Name:</span>
          <span class="float-right text-primary"><?=$this->contact->fname;?></span>
        </li>

        <li class="list-group-item">
          <span class="float-left">Last Name:</span>
          <span class="float-right text-primary"><?=$this->contact->lname;?></span>
        </li>

        <li class="list-group-item">
          <span class="float-left">Email:</span>
          <span class="float-right text-primary"><?=$this->contact->email;?></span>
        </li>

        <li class="list-group-item">
          <span class="float-left">Address:</span>
          <span class="float-right text-primary"><?=$this->contact->address;?></span>
        </li>

        <li class="list-group-item">
          <span class="float-left">City:</span>
          <span class="float-right text-primary"><?=$this->contact->city;?></span>
        </li>

        <li class="list-group-item">
          <span class="float-left">Zip Code:</span>
          <span class="float-right text-primary"><?=$this->contact->zip;?></span>
        </li>

        <li class="list-group-item">
          <span class="float-left">Phone:</span>
          <span class="float-right text-primary"><?=$this->contact->phone;?></span>
        </li>
      </ul>
    </div>
  </div>
</div>
<?php $this->end(); ?>
