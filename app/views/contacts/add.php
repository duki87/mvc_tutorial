<?php $this->setSiteTitle(SITE_TITLE . ' | Add Contact'); ?>
<?php $this->start('head'); ?>
  <!-- <meta content="test"> -->
<?php $this->end(); ?>

<?php $this->start('body'); ?>
  <div class="container">
    <h1 class="text-center text-primary">Add New Contact</h1>
      <?php $this->partial('contacts', 'addContactForm');?>
  </div>
<?php $this->end(); ?>
