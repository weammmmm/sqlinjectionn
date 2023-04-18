b <?php
$host  = 'localhost';
$username = 'root';
$sqlpassword = '';
$dbname = 'web2';
$error = [];
$nameErr = '';
$emailErr = '';
$passwordErr = '';
$genderErr = '';
$imageErr = '';
$DBgender = '';
$male = '';
$female = '';

if (isset($_POST['submit'])) {
    $nameErr = $_POST['name'];
    $emailErr = $_POST['email'];
    $passwordErr = $_POST['password'];
    $hashpassword = hash('sha512', $passwordErr);
    $imageErr = $_FILES['image']['name'];

    if ($_POST['name'] < 6) {
        $error[] = 'name must be at least 7 charcter...';
    }

    if (!filter_var($emailErr, FILTER_VALIDATE_EMAIL)) {
        $error[] = 'contaion @ as we@we.com';
    }

    if ($_POST['password'] < 10) {
        $error[] = 'password must be at least 10 charcter...';
    }
    if (!isset($_POST['gender'])) {
        $error[] = 'choose gender';
    } else {

        $gender = $_POST['gender'];
        if ($_POST['gender'] == 'm') {
            $DBgender = '1';
            $male = 'm';
        } else {
            $DBgender = '2';
            $female = 'f';
        }
    }
    if ($_FILES['image']['size'] > 1024 * 1024) {
        $error[] = 'Image size must be less than 1 MB';
    }
    if (count($error) == 0) {
        $conn1 = new mysqli($host, $username, $sqlpassword, $dbname);
       
            if (!$conn1->connect_errno) {
                $stmt = $conn1->prepare("INSERT INTO users (name, email, password  , gender,image ) 
                VALUES (?, ?, ?,?,?)");
                $stmt->bind_param("sssss", $nameErr, $emailErr,$hashpassword,$DBgender,$imageErr);
                if($stmt->execute()){
                    echo'done';
                    $stmt->close();
           $nameErr='';
            $emailErr='';
            $passwordErr='';

                }

            }
        } else {
            die('Erorr' . mysqli_connect_error());
        }
    
    }



?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>

<body>
    <h1>login</h1>

    <div class="container">
        <?php if (count($error) > 0) { ?>
            <ul class="text-danger">
                <?php foreach ($error as $errors) { ?>
                    <li> <?php echo $errors;  ?></li>
                <?php  } ?>
            </ul>
        <?php  } ?>


        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Name </label>
                <input name="name" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Email address</label>
                <input name="email" value="<?php echo $emailErr    ?>" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Password</label>
                <input name="password" value="<?php echo $passwordErr    ?>" type="text" class="form-control" id="exampleInputPassword1">
            </div>
            <div class="mb-3 form-check">
                <input name='checkMe' type="checkbox" class="form-check-input" id="exampleCheck1">
                <label class="form-check-label" for="exampleCheck1">Check me out</label>
            </div>

            <div class="form-check">
                <input name="gender" value="1" class="form-check-input" type="radio" id="flexRadioDefault1">
                <label class="form-check-label" for="flexRadioDefault1">
                    Male
                </label>
            </div>
            <div class="form-check">
                <input name="gender" value="2" class="form-check-input" type="radio" id="flexRadioDefault2">
                <label class="form-check-label" for="flexRadioDefault2">
                    Female
                </label>
            </div>


            <div class="mb-3">

            </div>

            <div class="mb-3">
                <label for="formFileDisabled" class="form-label">Image</label>
                <input name="image" class="form-control" type="file" id="formFileDisabled">
            </div>

            <button name="submit" type="submit" class="btn btn-primary">Submit</button>
        </form>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>

</html>