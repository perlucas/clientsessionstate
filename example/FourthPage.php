<?php
include('./config.php');
$session = \ClientSessionState\ClientSession::instance();
$session->load($_POST['session']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Fourth Page</title>
</head>
<body>
    <h1>Session data:</h1>
    <p>User id: <?=$session->get('user_id')?></p>
    <p>Another value: <?=implode(',', $session->get('another_value'))?></p>
    <p>Phrase: <?=$session->get('phrase')?></p>
</body>
</html>