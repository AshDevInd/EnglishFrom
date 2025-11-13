<!DOCTYPE html>
<html lang="en">
<head>
    <title>EnglishFrom.com</title>
    <link href="<?=base_url()?>front-assets/img/logo.jpeg" rel="icon" type="image/x-icon"/>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <!-- <link href="css/owl-carousel/owl.carousel.css" rel="stylesheet">
  <link href="css/owl-carousel/owl.theme.css" rel="stylesheet"> -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.css"/>
  <link href="<?=base_url()?>front-assets/css/owl-carousel/owl.transitions.css" rel="stylesheet">
  <link type="text/css" rel="stylesheet" href="<?=base_url()?>front-assets/css/sheet.css">
  <link href="<?=base_url()?>front-assets/css/style.css" rel="stylesheet">
   <link href="<?=base_url()?>front-assets/css/table.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <style>
    /* .modal-content{
      width: 800px !important;
      overflow: scroll;
    } */
  /* .drop-m {
    background-color: #fff;
    list-style: none;
    margin: 0;
    padding: 0;
    border-radius: 3px;
    display: none;
  }
  .drop-m li {
    padding: 6px 15px;
  }
  .drop-m li:hover {
    background-color: #31D2F2;
  } */
  </style>
</head>
<body>
    <nav class="navbar navbar-expand-md navbar-dark">
        <div class="container-fluid">
          <a class="navbar-brand " href="<?=base_url()?>">
            <img src="<?=base_url()?>front-assets/img/logo.png" alt="Logo" />
            
          </a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
            <ul class="navbar-nav ">
              <li class="nav-item">
                <a class="nav-link" aria-current="page" href="<?=base_url()?>">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="<?=base_url()?>about">About</a>
              </li>
              <li class="nav-item">
                <a class="nav-link dropdown" href="#">Category</a>
                
                 <ul class="dropdown-menu drop-m">
                  <?php foreach($cats as $cat): 
                    if (!empty($cat['sub'])): ?>
                      <li class="dropdown-submenu dropend">
                        <a class="dropdown-item dropdown-toggle" href="<?=base_url('category/'.$cat['id'])?>"><?=htmlspecialchars($cat['cat_name'])?></a>
                        <ul class="dropdown-menu drop-sm">
                          <?php foreach($cat['sub'] as $sub): ?>
                            <li><a class="dropdown-item" href="<?=base_url('category/'.$sub['id'])?>"><?=htmlspecialchars($sub['cat_name'])?></a></li>
                          <?php endforeach; ?>
                        </ul>
                      </li>
                    <?php else: ?>
                      <li><a class="dropdown-item" href="<?=base_url('category/'.$cat['id'])?>"><?=htmlspecialchars($cat['cat_name'])?></a></li>
                    <?php endif; ?>
                  <?php endforeach; ?>
                </ul>
              </li>	
              <li class="nav-item">
                <a class="nav-link" target="_blank" href="mailto:info@hindi2.com">Contact</a>
              </li>		
            </ul>	
               
        </div>
        <a href="<?=base_url()?>login/index" target="_blank" class="btn btn-sm btn-info" >Login</a>  
      </nav>
      
      
      <section>

      
<script>
  $(document).ready(function(){
    
    $(".dropdown").click(function(e) {
      // alert('ss');
        e.stopPropagation(); // Prevent the click event from bubbling up to document
        $('.drop-m').toggle(); // Toggle visibility of the dropdown
    });

    $(document).click(function(){
      $('.drop-m').hide();
    })
  })

  
  // enable opening nested dropdowns on click (Bootstrap 5)
document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('.dropdown-submenu .dropdown-toggle').forEach(function(toggle) {
    // Show the submenu on mouseenter
    toggle.addEventListener('mouseenter', function(e) {
      e.preventDefault();
      e.stopPropagation();

      var sub = this.nextElementSibling; // The submenu (dropdown menu)
      if (sub) sub.classList.add('show'); // Add 'show' class to display the submenu
    });

    // Hide the submenu on mouseleave (only if mouse leaves both the toggle and the submenu)
    toggle.addEventListener('mouseleave', function(e) {
      e.preventDefault();
      e.stopPropagation();

      var sub = this.nextElementSibling;
      if (sub) {
        sub.addEventListener('mouseleave', function() {
          sub.classList.remove('show'); // Hide the submenu when the mouse leaves the submenu
        });
      }
    });
  });

  // Close open submenus when parent dropdown is hidden
  document.querySelectorAll('.dropdown').forEach(function(dd) {
    dd.addEventListener('hidden.bs.dropdown', function () {
      dd.querySelectorAll('.dropdown-menu.show').forEach(function(sm) {
        sm.classList.remove('show'); // Hide any open submenu when parent dropdown closes
      });
    });
  });
});

</script>