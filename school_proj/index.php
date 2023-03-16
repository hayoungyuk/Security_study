<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>동덕여대 Ping! 구성원</title> <!-- 1. 그냥 웹페이지 제목-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container my-5">
        
        <h2>Ping! 학생 리스트</h2> <!-- 2. 웹 페이지에 뜰 큰 제목-->
        <a class="btn btn-primary" href="/school_proj/create.php" role="button">동아리원 추가</a> 
        <!-- 3. 기본 화면에는 새로운 동아리원을 추가할 즉, create.php와 연결되어야 하는 버튼이 필요하니까 추가
                이 때, /파일이름/create.php와 이어지도록 연결해두고
        -->
        <br>

        <table class="table"> <!-- -->
            
            <thead>
                <tr>
                    <th>ID</th>
                    <th>이름</th>
                    <th>이메일</th>
                    <th>전화번호</th>
                    <th>주소</th>
                    <th>CREATED AT</th>
                    <th>ACTIONS</th>
                </tr>
            </thead>

            <tbody>
                <!--4. 데이터베이스에서 읽어와야하므로 이제 php코드가 필요합니다-->
                <?php
                /*servername, username, password, database변수를 적어주고, */ 
                $servername = "localhost";
                $username = "root";
                $password = "";
                $database = "school_db";

                // Create conntection 연결을 해줍니다
                $connection = new mysqli($servername, $username, $password, $database);

                // Check connection 연결 체크를 위해
                if($connection->connect_error){
                    die("Connection failed: " . $connection->connect_error);
                } //만약 에러가 있다면 바로 에러 메세지를 띄워주고

                // read all row from database table sql서버에 있는 모든 데이터를 읽어서
                $sql = "SELECT * FROM student";
                $result = $connection->query($sql); // 이 쿼리를 읽어서 결과를 보여줍니다.
                
                if(!$result){
                    die("Invalid query: " . $connection->error);
                } // 만약 쿼리 실행중에 오류가 난다면 에러메세지를 띄우고
                

                //그렇지않다면 while 루프를 사용해서 db에 있는 데이터베이스를 읽습니다.
                //row 즉, 열에서 데이터를 읽고 db에서 읽은 각행은 html의 테이블에 표시되어야 하기때문에
                //while안에 echo를 사용합니다. 여기서 echo는 html테이블에서 한행을 인쇄할 수 있습니다.
                while($row = $result->fetch_assoc()){
                    echo"
                    <tr>
                        <td>$row[id]</td>
                        <td>$row[name]</td>
                        <td>$row[email]</td>
                        <td>$row[phone]</td>
                        <td>$row[address]</td>
                        <td>$row[created_at]</td>
                        <td>
                            <a class='btn btn-primary btn-sm' href='/school_proj/edit.php?id=$row[id]'>Edit</a>
                            <a class='btn btn-danger btn-sm' href='/school_proj/delete.php?id=$row[id]'>Delete</a>
                        </td>
                    </tr>
                    "; #edit버튼, delete버튼 -- 클라이언트의 id를 제공하기 떄문에
                    // 물음표를 추가한다음 매개변수의 이름을 추가해야합니다.
                    // 만약 id 1번 학생의 정보를 수정하고 싶다면 id 1번에 해당하는 학생을 선택해야 하므로
                    // id = 그 열에 해당하는 id 해서 배열에 담아서 파라미터를 넘겨줍니다
                    // 삭제도 같은 방식으로 진행합니다.
                    //그리고 배열을 사용해서 각각의 행에 해당하는 값을 보여줌
                }
                
                ?>

                <!--
                <tr>
                    <td>10</td>
                    <td>bill gates</td>
                    <td>billgateswhy@miscrosoft.com</td>
                    <td>01078788787</td>
                    <td>seoul</td>
                    <td>2023.03.13</td>
                    <td>
                        <a class='btn btn-primary btn-sm' href='/school_proj/edit.php'>Edit</a>
                        <a class='btn btn-danger btn-sm' href='/school_proj/delete.php'>Delete</a>
                    </td>
                </tr>
                -->

            </tbody>

        </table>

    </div>
</body>
</html>