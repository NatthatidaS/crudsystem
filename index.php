<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    
    <style>
        .wrapper {
            width: 650px;
            margin: 0 auto;
        }
        .pape-header h2 {
            margin-top: 0;
        }
        table tr td:last-child a {
            margin-right: 15px;
        }
    </style>
    
    <script>
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
</head>
<body>

        <div class="wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="pape-header clearfix">
                            <h2 class="pull-left">Employees Details</h2>

                            <a href="create.php" class="btn btn-success pull-right">
                                Add New employee
                            </a>
                        </div>
                        <?php
                            require_once 'config.php';
                            
                            $sql = "SELECT * FROM employees";
                            if($result = mysqli_query($link,$sql)) {
                                if(mysqli_num_rows($result) > 0) {
                                    echo "<table class='table table-bordered table-striped'>";
                                        echo "<thead>";
                                            echo "<tr>";
                                                echo "<th>#</th>";
                                                echo "<th>Name</th>";
                                                echo "<th>Address</th>";
                                                echo "<th>Salary</th>";
                                                echo "<th>Action</th>";
                                            echo "</tr>";
                                        echo "<thead>";
                                        echo "<tbody >";
                                        while($row = mysqli_fetch_array($result)){
                                            echo "<tr>";
                                                echo "<td>" . $row['id'] . "</td>";
                                                echo "<td>" . $row['name'] . "</td>";
                                                echo "<td>" . $row['addess'] . "</td>";
                                                echo "<td>" . $row['salary'] . "</td>";
                                                echo "<td>";
                                                    echo "<a href='read.php?id=" . $row['id'] . " title='View Record'
                                                    data-toggle='tooltip'><span class='glyphicon glyphicon-eye-open'></span></a>";
                                                    echo "<a href='update.php?id=" . $row['id'] . "' title='Update Record'
                                                    data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
                                                    echo "<a href='delete.php?id=" . $row['id'] . "' title='Delete Record'
                                                    data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";
                                                echo "</td>";
                                            echo "</tr>";
                                        }
                                        echo "</tbody>";
                                    echo "</table>";
                                    mysqli_free_result($result);
                                }else{
                                    echo "<p class='lead'><em>No records were found.</em></p>";
                                }   
                            }
                            mysqli_close($link);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    
</body>
</html>