
<?php
    require_once("../baseurl.php");
?>
<!DOCTYPE html>
<html lang="en">

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>WorkPlace</title>
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
  <!-- Bootstrap core CSS -->
  <link href="<?php echo $baseUrl; ?>css/bootstrap.min.css" rel="stylesheet">
  <!-- Material Design Bootstrap -->
  <link href="<?php echo $baseUrl; ?>css/mdb.min.css" rel="stylesheet">
  <!-- Your custom styles (optional) -->
  <link href="<?php echo $baseUrl; ?>css/style.css" rel="stylesheet">
   <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>

  <style>
      .navbar {
        z-index: 1040;
      }
      .side-nav {
        margin-top: 57px !important;
      }

      @media (min-width: 1200px){
      .fixed-sn main {
          margin-left: 2% !important;
          margin-right: 2% !important;
        }
      }

  </style>
</head>

<body>
<?php
      //  $apclogin_my_avatar = '';
      // if ($_SESSION['apclogin_avatar']!='')
      // {
      //     $apclogin_my_avatar = "http://planloops.com/apc/img/avatar/".$_SESSION['apclogin_avatar'];
      // }
      // else if($_SESSION['apclogin_avatar']=='')
      // {
      //     $apclogin_my_avatar = "http://planloops.com/apc/img/avatar.jpg";
      // }
?>
