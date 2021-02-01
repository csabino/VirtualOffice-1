<?php

  if (!isset($_GET['c']) || $_GET['c']==''){
    header("location:meetings.php");
  }

  if (!isset($_GET['t']) || $_GET['t']==''){
    header("location:meetings.php");
  }

  require_once("../../interface/DBInterface.php");
  require_once("../../abstract/Database.php");
  require_once("../../classes/PDODriver.php");
  require_once("../../classes/PDO_QueryExecutor.php");
  require_once("../../interface/MeetingInterface.php");
  require_once("../../classes/Meeting.php");
  //require_once("../../nav/staff_nav.php");
  //require_once("../includes/staff_header.php");

  $_GET_URL_meeting_code = explode("-",htmlspecialchars(strip_tags($_GET['c'])));
  $_GET_URL_meeting_code = $_GET_URL_meeting_code[1];

  $_GET_URL_meeting_title = explode("-",htmlspecialchars(strip_tags($_GET['t'])));
  $_GET_URL_meeting_title = $_GET_URL_meeting_title[1];



  $meeting = new Meeting();
  $result = $meeting->get_meeting_by_code_and_title($_GET_URL_meeting_code, $_GET_URL_meeting_title);

  if (!$result->rowCount())
  {
      header("location: meetings.php");
  }


 ?>

<html>
<head>
  <title>Live Meeting</title>
</head>
<body>
<iframe id="video" allow="camera; microphone; fullscreen; display-capture"
src="" style="height: 100%; width: 100%; border: 0px;"></iframe>



<input type="hidden" id='code' value="<?php echo $_GET_URL_meeting_code; ?>" >
<input type="hidden" id="title" value="<?php echo $_GET_URL_meeting_title; ?>" >


<script>

  var code = document.getElementById("code").value;
  var title  = document.getElementById("title").value;
  var meeting_room = code + "/" + title;
  document.getElementById("video").src = "https://meet.jit.si/" + meeting_room;

</script>
</body>
</html>
