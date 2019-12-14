<?php
include('./config.php');
$session = \ClientSessionState\ClientSession::instance();
$session->load($_GET['session']);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Second Page</title>
</head>
<body>
    <h2>Session data</h2>
    <p>User id is: <?=$session->get('user_id')?></p>
    <p>Another value is: <?=implode(',', $session->get('another_value'))?></p>
    <p>Phrase is: <?=$session->get('phrase')?></p>
    <form action="./ThirdPage.php" method = 'post'>
        <?=$session->output()->input()?>
        <p>Submit this form to send the session data to the Third Page on an input</p>
        <input type="submit" value="Submit">
    </form>
</body>
</html>