<?php

  session_start();

// if we choose to reset the contents of the chat
  if ( isset($_POST['reset']) ) {

    // empty the array and redirect to same page
    $_SESSION['chats'] = Array();
    header("Location: index.php");
    return;
  }

  if ( isset($_POST['message']) ) {

    // if we have post data, we create an array and send post data to it using post-redirect-get
    if ( !isset ($_SESSION['chats']) ) $_SESSION['chats'] = Array();
    $_SESSION['chats'] [] = array($_POST['message'], date(DATE_RFC2822));
    header("Location: index.php");
    return;
  }

?>

<html>
<head>
  <title>Week 4 - JSON Chat</title>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
</head>
<body>

      <h1>Chat</h1>

      <form method="post" action="index.php">
      <p>
      <input type="text" name="message" size="60"/>
      <input type="submit" value="Chat"/>
      <input type="submit" name="reset" value="Reset"/>
      <a href="chatlist.php" target="_blank">chatlist.php</a>
      </p>
      </form>

      <div id="chatcontent">
          <img src="img/spinner.gif" alt="Loading..."/>
      </div>

<script type="text/javascript">

function updateMsg() {

  window.console && console.log('Requesting JSON');

  $.getJSON('chatlist.php', function(data){

      window.console && console.log('JSON Received');
      window.console && console.log(data);

      $('#chatcontent').empty();

      for (var i = 0; i < data.length; i++) {

        row = data[i];
        $('#chatcontent').append('<p>'+row[0] +
            '<br/>&nbsp;&nbsp;'+row[1]+"</p>\n");
      }

      setTimeout('updateMsg()', 1000);
  });
}

// Make sure JSON requests are not cached
$(document).ready(function() {

  $.ajaxSetup({ cache: false });
  updateMsg();

});

</script>
</body>
