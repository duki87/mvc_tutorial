<?php $this->setSiteTitle(SITE_TITLE . ' | Contacts'); ?>
<?php $this->start('head'); ?>
  <!-- <meta content="test"> -->
<?php $this->end(); ?>

<?php $this->start('body'); ?>
<h1 class="text-center text-primary">Contacts</h1>
<?php //echo inputBlock('text', 'Your Name', 'your_name', 'Dusan', ['srOnly' => 'false', 'class' => 'form-control mb-2'], ['data-id' => 'yourName', 'class' => 'form-group col-md-6']);?>
<?php //echo submitBlock('Submit', ['class' => 'btn btn-success btn-sm float-right '], ['class' => 'col-md-6 mt-2']);?>
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
            <td><?=$contact->fname.' '.$contact->lname;?></td>
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
