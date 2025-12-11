<?php
    session_start();
    if($_SESSION["utype"]!="ADMIN"){
        header("location: ../restricted.php");
        exit(1);
    }
    include('../conn_db.php');
    $s_id = $_GET["s_id"];

    $delete_query = "DELETE FROM tournament WHERE s_id = '{$s_id}';";
    $delete_result = $mysqli -> query($delete_query);

    if($delete_result){
        header("location: admin_Tournament_list.php?del_shp=1");
    }else{
        header("location: admin_Tournament_list.php?del_shp=0");
    }

?>