<?php

include('./config.php');
$session = \ClientSessionState\ClientSession::instance();
$session->set('user_id', rand());
$session->set('another_value', array(11, 22, 33, 44));
$session->set('phrase', 'This is my session phrase');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>First Page</title>
</head>
<body>
    <a href="./SecondPage.php?session=<?=$session->output()->string()?>">
        Go to Second Page sending the session on the query string
    </a>
</body>
</html>
