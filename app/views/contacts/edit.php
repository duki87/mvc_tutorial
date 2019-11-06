<?php $this->setSiteTitle(SITE_TITLE . ' | Edit Contact: '.$this->post['fname'].' '.$this->post['lname']); ?>
<?php $this->start('head'); ?>
  <!-- <meta content="test"> -->
<?php $this->end(); ?>

<?php $this->start('body'); ?>
  <div class="container">
    <h1 class="text-center text-primary"><?php echo'Edit Contact: '.$this->post['fname'].' '.$this->post['lname'];?></h1>
      <?php $this->partial('contacts', 'editContactForm');?>
  </div>
<?php $this->end(); ?>
