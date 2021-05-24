<?php
    if(isset($_GET["id"]) && !empty($_GET["id"])) {
        require_once 'config.php';

        $sql = "SELECT * FROM employees WHERE id = ?";

        if($stmt = mysqli_prepare($link,$sql)) {
            mysqli_stmt_bind_param($stmt,"i",$param_id);

            $param_id = trim($_GET["id"]);

            if(mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_get_result($stmt);

                if(mysqli_num_rows($result) == 1) {
                    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
                    
                    $name = $row["name"];
                    $addess = $row["addess"];
                    $salary = $row["salary"];

                } else {
                    header("Location: index.php");
                    exit();
                }
            } else {
                echo "Oops! something went wrong try again!";
            }
        }

        mysqli_stmt_close($stmt);

        mysqli_close($link);
    } else {
        header("Location: error.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Read Pege</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style>
        .wrapper {
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h1>View Record</h1>
                </div>
                <div class="form-group">
                    <label>Name</label>
                    <p class="form-control-static"><?php echo $row["name"]; ?></p>
                </div>
                <div class="form-group">
                    <label>Addess</label>
                    <p class="form-control-static"><?php echo $row["addess"]; ?></p>
                </div>
                <div class="form-group">
                    <label>Salary</label>
                    <p class="form-control-static"><?php echo $row["salary"]; ?></p>
                </div>
                <p><a href="index.php" class="btn btn-primary">Back</a></p>
            </div>
        </div>
    </div>
</body>
</html>