<?php
if (isset($_FILES["file"])) {

    $out = array();
    $out = array_merge($_GET, $_FILES, $_POST);

    unset($out["file"]["tmp_name"]);

    sleep(1);

    echo var_dump($out);
}