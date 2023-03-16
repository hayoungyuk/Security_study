<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "school_db";

// create.php의 마지막!!!! 1번 연결 Create conntection
$connection = new mysqli($servername, $username, $password, $database);

// 변수 초기화
$name = "";
$email = "";
$phone = "";
$address = "";

$errorMessage = "";
$successMessage = "";
//여기까지

//데이터가 post로 전송된 경우
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $address = $_POST["address"];

    //값을 다 읽은 후 종료 될 수 있도록 do while문을 사용합니다.
    do{
        if( empty($name) || empty($email) || empty($phone) || empty($address) ){
            $errorMessage = "모든 항목을 채워야 합니다.(All the fields are required)";
            break;
        }

        // create.php의 마지막!!!! 2번 sql에 추가를 해준다 add new client to database
        $sql = "INSERT INTO student(name, email, phone, address)" . 
                "VALUES('$name', '$email', '$phone', '$address')";
        $result = $connection->query($sql);

        if(!$result){
            $errorMessage = "Invalid query: " . $connection->error;
            break;
        }

        // 새 클라이언트를 db에 추가한 후 다른 필드를 빈 값으로 초기화 하고 성공 메세지를 보내줍니다
        $name = "";
        $email = "";
        $phone = "";
        $address = "";
        
        $successMessage = "회원이 정상적으로 추가되었습니다(Client added correctly)";

        header("location: /school_proj/index.php");
        exit;

    }while(false);
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
        <h2>새 동아리 부원</h2>

        <!--실패시 실패 메세지-
        변수가 다 비워져 있지 않으면, 즉 초기화 되어 있지 않으면 실패메세지를 보여주고->
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

        <!-- 작성한 양식을 create.php인 동일한 페이지에 제출하기 때문에
        form action=""의 방식을 사용하는게 아니라 method="post"의 http post메소드 방식을 사용합니다 -->
        <form method="post">
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">이름</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="name" value="<?php echo $name; ?>">
                    <!--여기서 name="name"에서 name은 서버에 제출될 매개변수의 이름 입니다
                         그리고 value안에 있는 값은 내가 쓴 이름을 php가 읽는 값입니다.-->
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

            <!--성공시 성공 메세지
            초기화에 성공을 하면 성공 메세지를 보여줍니다 -->
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
                    <!-- 제출버튼을 누르면 제출파일의 양식의 데이터가 보내집니다.
                    -->
                </div>
                <!-- 취소버튼 -->
                <div class="col-sm-3 d-grid">
                    <a class="btn btn-outline-primary" href="/school_proj/index.php" role="button">취소</a>
                </div>
            </div>

        </form>

    </div>
</body>

</html>