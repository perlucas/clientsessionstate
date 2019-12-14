<?php
include('./config.php');
$session = \ClientSessionState\ClientSession::instance();
$session->load($_POST['session_data']);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Third Page</title>
</head>
<body>
    <p>Here you can use the js SDK</p>
    <?=$session->output()->js()?>
    <form action="./FourthPage.php" onsubmit = "ClientSession.addToForm(this)" method='post'>
        <p>Submit the form for sending the session data to fourth page using the js SDK</p>
        <input type="submit" value="Submit">
    </form>
</body>
</html>