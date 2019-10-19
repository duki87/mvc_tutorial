<?php $this->setSiteTitle(SITE_TITLE . ' | Contacts'); ?>
<?php $this->start('head'); ?>
  <!-- <meta content="test"> -->
<?php $this->end(); ?>

<?php $this->start('body'); ?>
<h1 class="text-center text-primary">Contacts</h1>
<div class="container">
  <div class="row">
    <table class="table table-striped table-condensed table-bordered">
      <thead>
        <tr>
          <th>No</th>
          <th>Name</th>
          <th>Email</th>
          <th>Address</th>
          <th>Phone</th>
        </tr>
      </thead>
      <tbody>
        <?php $no = 1; foreach($this->contacts as $contact):?>
          <tr>
            <td><?=$no;?></td>
            <td>
              <a href="<?=SITE_ROOT.'contacts/details/'.$contact->id;?>">
                <?=$contact->fname.' '.$contact->lname;?>
              </a>
            </td>
            <td><?=$contact->email;?></td>
            <td><?=$contact->address.', '.$contact->zip.', '.$contact->city;?></td>
            <td><?=$contact->phone; $no++;?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
<?php $this->end(); ?>
