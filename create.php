<?php
    require_once 'config.php';

    $name = $addess = $salary = "";
    $name_err = $addess_err = $salary_err = "";

    //Processing form data when form is submitted
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        // Validete name
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

        if(empty($name_err) && empty($addess_err) && empty($salary_err)) {
            // Prepare an insert statment
            $sql = "INSERT INTO employees (name,addess,salary) VALUES (?,?,?)";

            if($stmt = mysqli_prepare($link,$sql)) {
                mysqli_stmt_bind_param($stmt,"sss",$param_name,$param_addess,$param_salary);

                $param_name = $name;
                $param_addess = $addess;
                $param_salary = $salary;

                if(mysqli_stmt_execute($stmt)){
                    header("location: index.php");
                    exit();
                } else {
                    echo "Someting went wrong.";
                }
            }

            mysqli_stmt_close($stmt);
        }

        mysqli_close($link);
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
                        <h2>Create Record</h2>
                    </div>
                    <p>Please fill this from and submit to add employee to database</p>
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
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>