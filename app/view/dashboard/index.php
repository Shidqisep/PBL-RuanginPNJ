<?php Flasher::Flash() ?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.8">
    <title>Dashboard</title>
    <link href="/css/output.css" rel="stylesheet">
</head>
<body>
    <h1>Halo, <?= $data['user']['username']?></h1>
    <a href="/Auth/handleLogout">Logout</a>

    <img src="/File/showBukti/<?= $data['user']['fotobukti']?>" alt="Foto <?= $data['user']['username']?>">
</body>
</html>     