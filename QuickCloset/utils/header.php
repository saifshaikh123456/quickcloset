<?php 
//start the session if not started already
if(!isset($_SESSION)) { session_start(); } 
?>
  <?php require_once('links.php') ?>
  </head>
<body>

<nav class="navbar">
  <a href="index.php">
    <img style="width:140px;height:40px" src="./assets/logo.png" alt="QuickCloset"/>
  </a>

  <ul>
    <?php
      //if username is set that means user is logged in and let him see all links in navbar
      if(isset($_SESSION['username']) && !empty($_SESSION['username'])){
        echo "<li title=\"You\"><a href=\"index.php\"><i class=\"fa-solid fa-user\"></i>&nbsp;{$_SESSION['username']}</a></li>";
        echo "<li title=\"Cart\"><a href=\"cart.php\"><i class=\"fa-solid fa-cart-shopping\"></i>&nbsp;Cart</a></li>";
        echo "<li title=\"Sell your clothes\"><a href=\"sell.php\"><i class=\"fa-solid fa-sterling-sign\"></i>&nbsp;&nbsp;Sell</a></li>";
        echo "<li title=\"Your Products\"><a href=\"your_products.php\"><i class=\"fa-solid fa-shirt\"></i>&nbsp;Your Products</a></li>";
        echo "<li title=\"Explore Other Users\"><a href=\"explore.php\"><i class=\"fa-solid fa-globe\"></i>&nbsp;Explore</a></li>";
        echo "<li title=\"Users You Follow\"><a href=\"following.php\"><i class=\"fa-solid fa-users\"></i>&nbsp;Following</a></li>";
        echo "<li title=\"Logout\"><a href=\"logout.php\"><i class=\"fa-solid fa-right-from-bracket\"></i>&nbsp;Logout</a></li>";
      }
      //if not logged in then then show only these links
      else{
        echo "<li title=\"Home\"><a href=\"index.php\"><i class=\"fa-solid fa-home\"></i>&nbsp;Home</a></li>";
        echo "<li title=\"Login\"><a href=\"login.php\"><i class=\"fa-solid fa-right-to-bracket\"></i>&nbsp;Login</a></li>";
        echo "<li title=\"Register\"><a href=\"register.php\"><i class=\"fa-solid fa-user-plus\"></i>&nbsp;Register</a></li>";
      }
    ?>
    <!-- About and contact page will be there always  -->
    <li title="About"><a href="about.php"><i class="fa-solid fa-address-card"></i>&nbsp;About</a></li>
    <li title="Contact"><a href="contact.php"><i class="fa-solid fa-envelope"></i>&nbsp;Contact</a></li>
  </ul>
</nav>  