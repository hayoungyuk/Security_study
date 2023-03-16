<?php
//삭제 필드가 get 메서드를 사용하여 요청을 수신하도록 php코드를 작성
//id를 포함하는지 먼저 확인
if( isset($_GET["id"]) ){
    $id = $_GET["id"];
    //id가 있으면 서버에 연결
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "school_db";

    // Create conntection
    $connection = new mysqli($servername, $username, $password, $database);

    //연결 후 삭제
    $sql = "DELETE FROM student WHERE id=$id";
    $connection->query($sql);
}

header("location: /school_proj/index.php");
exit;
?>