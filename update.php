<?php
    require_once 'config.php';

    $name = $addess = $salary = "";
    $name_err = $addess_err = $salary_err = "";

    if(isset($_POST["id"]) && !empty($_POST["id"])) {
        // gat hidden input value
        $id = $_POST["id"];

        // validate name
        $input_name = trim($_POST["name"]);
        if(empty($input_name)) {
            $name_err = "Please enter a name.";
        } elseif(!filter_var(trim($_POST["name"]), FILTER_VALIDATE_REGEXP,array("options"=>array("regexp"=>"/^[a-zA-Z'-.\s]+$/")))){
            $name_err = "Please enter a valid name.";
        } else {
            $name = $input_name;
        }
        // Validete addess
        $input_addess = trim($_POST["addess"]);
        if(empty($input_addess)) {
            $addess_err = "Please enter an addess.";
        } else {
            $addess = $input_addess;
        }

        // Validete salary
        $input_salary = trim($_POST["salary"]);
        if(empty($input_salary)) {
            $salary_err = "Please enter a salary amout.";
        } else {
            $salary = $input_salary;
        }
        
        // Check input error before insert into database
        if(empty($name_err) && empty($addess_err) && empty($salary_err)) {
            // Prepare an update statment
            $sql = "UPDATE employees SET name=?,addess=?,salary=? WHERE id=?";

            if($stmt = mysqli_prepare($link,$sql)) {
                mysqli_stmt_bind_param($stmt,"sssi",$param_name,$param_addess,$param_salary,$param_id);

                $param_name = $name;
                $param_addess = $addess;
                $param_salary = $salary;
                $param_id = $id;

                if(mysqli_stmt_execute($stmt)){
                    header("location: index.php");
                    exit();
                } else {
                    echo "Someting went wrong try again.";
                }
            }

            mysqli_stmt_close($stmt);
        }

        mysqli_close($link);
    } else {
        // Check exist id before proscessing
        if(isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
            // Get url parameter
            $id = trim($_GET["id"]);

            // Prepare a select statement
            $sql = "SELECT * FROM employees WHERE id = ?";
            if($stmt = mysqli_prepare($link,$sql)) {
                mysqli_stmt_bind_param($stmt,"i",$param_id);

                // Set param
                $param_id = $id;

                if(mysqli_stmt_execute($stmt)) {
                    $result = mysqli_stmt_get_result($stmt);

                    if(mysqli_num_rows($result) == 1) {
                        $row = mysqli_fetch_array($result,MYSQLI_ASSOC);

                        $name = $row["name"];
                        $addess = $row["addess"];
                        $salary = $row["salary"];
                    } else {
                        // URL doesn't contain valid id redirect to error page.
                        header("location: error.php");
                        exit();
                    }
                } else {
                    echo "Oops! something went wrong try again.";
                }
            }

            // Close statement
            mysqli_stmt_close($stmt);

            mysqli_close($link);
        } else {
            // URL doesn't contain id parameter redirect to error page.
            header("location: error.php");
            exit();
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper {
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="contaner-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Update Page</h2>
                    </div>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                        <div class="form-group <?php echo(!empty($name_err)) ? 'has-error' : ''; ?>">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
                            <span class="help-block"><?php echo $name_err; ?></span>
                        </div>
                        <div class="form-group <?php echo(!empty($addess_err)) ? 'has-error' : ''; ?>">
                            <label>Address</label>
                            <textarea type="text" name="addess" class="form-control"><?php echo $addess; ?></textarea>
                            <span class="help-block"><?php echo $addess_err; ?></span>
                        </div>
                        <div class="form-group <?php echo(!empty($salary_err)) ? 'has-error' : ''; ?>">
                            <label>Salary</label>
                            <input type="text" name="salary" class="form-control" value="<?php echo $salary; ?>">
                            <span class="help-block"><?php echo $salary_err; ?></span>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"> 
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>