<?php
include_once('register.html');
try {
    $user['e_mail'] = $_POST['e_mail'];
    $user['login'] = $_POST['login'];
    $user['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
    define(FILE_NAME,"users.json");

    $tempArray = [];
    if(file_exists(FILE_NAME))
    {
        $inp = file_get_contents(FILE_NAME);
        $tempArray = json_decode($inp);
    }

    $isContainsInputElem = true;
    foreach ($tempArray as $key => $value) {
        $tempObj = ((array)$value);
        if($tempObj['login'] == $user['login'] || $tempObj['e_mail'] == $user['e_mail'])
        {
           $isContainsInputElem = false;
           break;
        }
    }   
    if($isContainsInputElem)
    {
        array_push($tempArray, $user);
        $jsonData = json_encode($tempArray);
        file_put_contents(FILE_NAME, $jsonData);
    }
    $htmlPosts = "<div class='list-group'>";
        foreach ($tempArray as $key => $value) {
            $tempObj = ((array)$value);
            $htmlPosts .= "
            <div class='list-group-item'>
                <h3>Login: ".$tempObj['login']."</h3>
                <h3>E-mail: ".$tempObj['e_mail']."</h3>
            </div>";
        }
        $htmlPosts.='</div>';
    echo $htmlPosts;

} catch (\Throwable $th) {
    echo $th;
}
?>