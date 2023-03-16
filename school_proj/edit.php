<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "school_db";

// Create conntection
$connection = new mysqli($servername, $username, $password, $database);


$id ="";
$name = "";
$email = "";
$phone = "";
$address = "";

$errorMessage = "";
$successMessage = "";

//get method로 읽은 경우 요청받은 클라이언트의 id 를 읽어야합니다.
//따라서 사용자의 id가 존재하는지 먼저 읽어야합니다.
if( $_SERVER['REQUEST_METHOD'] == 'GET') {
    // GET method : Show the data of the client

    //id가 존재하지 않는다면
    if( !isset($_GET["id"]) ){
        header("location: /school_proj/index.php");
        exit;
    } // 실행종료

    //id가 존재하면 id를 읽습니다.
    $id = $_GET["id"];

    // read the row of the selected client from database table
    $sql = "SELECT * FROM student WHERE id=$id";
    $result = $connection->query($sql);
    $row = $result->fetch_assoc();

    if(!$row){
        header("location: /school_proj/index.php");
        exit;
    } // 만약 읽을 데이터가 없으면 종료

    //여기에서 db에서 읽은 값을 네가지 변수에 각각 저장합니다.
    $name = $row["name"];
    $email = $row["email"];
    $phone = $row["phone"];
    $address = $row["address"];
}

else{
    // POST method: Update the data of the client
    
    $id = $_POST["id"];
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $address = $_POST["address"];

    do{
        if( empty($id) || empty($name) || empty($email) || empty($phone) || empty($address) ){
            $errorMessage = "모든 항목을 채워야 합니다.(All the fields are required)";
            break;
        }//빈 필드가 없는지 확인

        $sql = "UPDATE student " .
               "SET name = '$name', email = '$email', phone = '$phone', address = '$address' " .
               "WHERE id = $id"; //꼭 string으로 처리 해야함.
        //sql에 연결
        $result = $connection->query($sql); //sql 쿼리를 결과에 담고

        if(!$result){
            $errorMessage = "Invalid query: " . $connection->error;
            break;
        } // 만약 오류가 있다면 오류 메세지를 보내고 

        //성공하면 성공하는 페이지로 보내고
        $successMessage = "회원정보가 정상적으로 수정되었습니다(Client Updated correctly)";

        header("location: /school_proj/index.php");
        exit;

    }while(true);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>동덕여대 Ping! 구성원</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

    <div class="container my-5">
        <h2>기존 동아리 부원 수정</h2>

        <!--실패시-->
        <?php
        if( !empty($errorMessage) ){
            echo"
            <div class = 'alert alert-warning alert-dismissible fade show' role= 'alert'>
                <strong>$errorMessage</strong>
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>
            ";
        }
        ?>

        <!--post 방식-->
        <form method="post">
            <!--사용자에게는 보이지 않는 숨겨진 입력 필드-->
            <!--양식이 아이디를 포함하므로 name="id"를 적어야한다.-->
            <input type="hidden" name="id" value="<?php echo $id; ?>">

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">이름</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="name" value="<?php echo $name; ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">이메일</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="email" value="<?php echo $email; ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">전화번호</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="phone" value="<?php echo $phone; ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">주소</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="address" value="<?php echo $address; ?>">
                </div>
            </div>

            <!--성공시-->
            <?php
            if( !empty($successMessage) ){
                echo"
                <div class='row mb-3'>
                    <div class = 'offset-sm-3 col-sm-6'>
                        <div class='alert alert-success alert-dismissible fade show' role='alert'>
                            <strong>$successMessage</strong>
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>
                    </div>
                </div>
                ";
            }
            ?>

            <div class="row mb-3">
                <div class="offset-sm-3 col-sm-3 d-grid">
                    <button type="submit" class="btn btn-primary">제출</button>
                </div>
                <div class="col-sm-3 d-grid">
                    <a class="btn btn-outline-primary" href="/school_proj/index.php" role="button">취소</a>
                </div>
            </div>
        </form>
    </div>

</body>
</html>