<?php
    $page_title = 'My Dashboard';

    require_once('../baseurl.php');
    require_once("../includes/logged_in_header.php");
    require_once("../nav/staff_nav.php");
    //require_once("../includes/staff_header.php");
  ?>
<div class="container">

  <form class="border border-light p-5">

    <label for="textInput">Text input Label</label>
    <input type="text" id="textInput" class="form-control mb-4" placeholder="Text input">

    

    <label for="select">Default select</label>
    <select class="browser-default custom-select mb-4" id="select">
        <option value="" disabled="" selected="">Choose your option</option>
        <option value="1">Option 1</option>
        <option value="2">Option 2</option>
        <option value="3">Option 3</option>
    </select>

    <label for="textarea">Textarea Label</label>
    <textarea id="textarea" class="form-control mb-4" placeholder="Textarea"></textarea>

    <button class="btn btn-info btn-block" type="submit">Save</button>
</form>

</div>


<?php

    //footer.php
    require('../includes/footer.php');
 ?>
