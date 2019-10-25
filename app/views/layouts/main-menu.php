<?php
  $menu = Router::getMenu('menu_acl');
  $currentPage = H::currentPage();
  $userMenu = [];
?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">Navbar</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="main_menu">
    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
      <?php foreach($menu as $key => $value) {
        $active = '';
      ?>
        <?php if(is_array($value)) { ?>
          <?php if($key == 'Profile') {
            foreach ($value as $userKey => $userValue) {
              $userMenu[$userKey] = $userValue;
            }
            continue;
          }
          ?>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <?=$key;?>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
              <?php foreach($value as $subKey => $subValue) {
                $active = ($subValue == $currentPage) ? 'active' : '';
              ?>
                <?php if($subKey == 'separator') { ?>
                  <div class="dropdown-divider"></div>
                <?php } else { ?>
                  <a class="dropdown-item <?=$active;?>" href="<?=$subValue;?>"><?=$subKey;?></a>
                <?php } ?>
              <?php } ?>
            </div>
          </li>
        <?php } else { ?>
          <?php $active = ($value == $currentPage) ? 'active' : '';?>
            <li class="nav-item <?=$active;?>">
              <a class="nav-link <?=$active;?>" href="<?=$value;?>"><?=$key;?></a>
            </li>
        <?php } ?>
      <?php } ?>
    </ul>

    <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
      <?php if(Users::currentUser()->id): ?>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?php echo Users::currentUser()->fname; ?>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
            <?php foreach($userMenu as $userKey => $userValue): ?>
              <?php if($userKey == 'separator'): ?>
                <div class="dropdown-divider"></div>
              <?php else: ?>
                <a class="dropdown-item" href="<?=$userValue;?>"><?=$userKey;?></a>
              <?php endif; ?>
            <?php endforeach; ?>
          </div>
        </li>
      <?php endif; ?>
    </ul>
  </div>
</nav>
