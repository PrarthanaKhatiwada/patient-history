<?php
session_start();
session_regenerate_id();
?>
<!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Josefin+Sans&display=swap" rel="stylesheet">
</head>
<?php
$message = null;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['Login']) && $_POST['Login'] === 'Login') {
    // Collect form data
    $patient_id = $_POST['patient_id'];
    $password = $_POST['password'];

    // Create connection
    $conn = mysqli_connect("localhost", "root", "", "project");

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    //prepare select sql stmt
    $sql = "SELECT id, patient_id FROM patient WHERE patient_id = ? AND password = ? ORDER BY id ASC LIMIT 0, 1";
    $stmt = mysqli_prepare($conn, $sql);

    // Bind parameters
    mysqli_stmt_bind_param($stmt, "ss", $patient_id, $password);
    if (mysqli_stmt_execute($stmt)) {
    mysqli_stmt_bind_result($stmt, $id, $patient_id);
    mysqli_stmt_fetch($stmt);

    //storing patient data into session
    $_SESSION['loggedin'] = true;
    $_SESSION['loggedin_id'] = $id;
    $_SESSION['patient_id'] = $patient_id;

    //redirecting to patient's history page
    header('Location:history.php');
    exit;
    } else {
        $message = "This patient does not exist in our record!";
    }

    $_SESSION['message'] = $message;

    header('Location:index.php');

    // Close statement and connection
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['Register']) && $_POST['Register'] === 'Register') {
    // Collect form data
    $patient_id = $_POST['PatId'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Create connection
    $conn = mysqli_connect("localhost", "root", "", "project");

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    
    // Prepare SQL statement
    $sql = "INSERT INTO patient (Patient_Id, email, password) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);

    // Bind parameters
    mysqli_stmt_bind_param($stmt, "iss", $patient_id, $email, $password);

    // Execute statement
    if (mysqli_stmt_execute($stmt)) {
        $message = "Data inserted successfully";
    } else {
        $message = "Error inserting data: " . mysqli_error($conn);
    }

    $_SESSION['message'] = $message;

    header('Location:index.php');

    // Close statement and connection
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>

<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <a class="navbar-brand" href="#">YouHeal</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
                <a class="nav-link" href="index.php">Home<span class="sr-only">(current)</span></a>
            </li>
            <!-- <li class="nav-item">
                <a class="nav-link" href="#"></a>
            </li> -->
            <li class="nav-item">
                <a class="nav-link" href="about.php">About</a>

            </li>

        
            <li class="nav-item">
                <a class="nav-link" href="history.php">History</a>
            </li>

        </ul>
        <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form>
    </div>
</nav>

<div id="demo" class="carousel slide" data-ride="carousel">

    <!-- Indicators -->
    <ul class="carousel-indicators">
        <li data-target="#demo" data-slide-to="0" class="active"></li>
        <li data-target="#demo" data-slide-to="1"></li>
        <li data-target="#demo" data-slide-to="2"></li>
    </ul>

    <!-- The slideshow -->
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="lol.jpg" alt = "Doctors" width="1100" height="450">
        </div>
        <div class="carousel-item">
            <img src="doct.jpg" alt="Our group of doctors" width="1100" height="450">
        </div>
        <div class="carousel-item">
            <img src="gd.jpg" alt="We will heal you" width="1100" height="450">
        </div>
    </div>

    <!-- Left and right controls -->
    <a class="carousel-control-prev" href="#demo" data-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </a>
    <a class="carousel-control-next" href="#demo" data-slide="next">
        <span class="carousel-control-next-icon"></span>
    </a>
</div>
<section class="my-5">
    <div class="py-5">
        <h2 class="text-center">About Us</h2>
    </div>
    <div class="container-fluid">
    <div class="row">
        <div class="col-lg-6 col-md-6 col-12">
            <img src="haha.jpg" class="img-fluid aboutimg">
        </div>
        <div class="col-lg-6 col-md-6 col-12">
            <h2 class="display-4">Heal with US</h2>
            <p class="py-3">
                You heal is the hospital where a team of our specialized doctors try their very best to heal you. We have a huge team of specialized doctors in their own departments.
                We have services including private wards,emergency services,etc.
            </p>
            <a href="about.php" class="btn btn-success">LEARN MORE ABOUT US</a>
        </div>
    </div>
    </div>
</section>

<section class="my-5">
    <div class="py-5">
        <h2 class="text-center">Our Services</h2>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-12">
                <div class="card">
                    <img class="you" src="download (2).jpg" alt="Card image">
                    <div class="card-body">
                        <h4 class="card-title">Cardiology</h4>
                    </div>
                </div>

            </div>

            <div class="col-lg-4 col-md-4 col-12">
                <div class="card">
                    <img class="you" src="download (3).jpg" alt="Card image" width=" 475 px" height= "300 px">
                    <div class="card-body">
                        <h4 class="card-title">Surgery</h4>
                    </div>
                </div>

            </div>

            <div class="col-lg-4 col-md-4 col-12">
                <div class="card">
                    <img class="card-img-top" src="download (4).jpg" alt="Card image">
                    <div class="card-body">
                        <h4 class="card-title">Emergency services</h4>
                        
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
<section class="my-5">
    <div class="row">
    <div class="col-6">
        <!-- login -->
        <div class="py-5">
        <h2 class="text-center">Login</h2>
        <p class="text-center">Enter your Email Id and password provided by our hospital</p>
        <?php if(isset($_SESSION['message'])) { ?>
            <p><?php echo $_SESSION['message'] ?></p>
        <?php } ?>
    </div>
    <div class="w-50 m-auto">
        <form action="" method="post">
            <div class="form-group">
                <label>Patient ID</label>
                <input type="number" name="patient_id" autocomplete="off" class="form-control">
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" autocomplete="off" class="form-control">
            </div>

            <button type="submit" name="Login" value="Login" class="btn btn-success">Login</button>
        </form>
    </div>
    </div>

    <div class="col-6">
        <!-- register -->
        <div class="py-5">
        <h2 class="text-center">Register</h2>
        <p class="text-center">Enter your Patient Id , Email Id and password provided by our hospital</p>
        <?php if(isset($_SESSION['message'])) { ?>
            <p><?php echo $_SESSION['message'] ?></p>
        <?php } ?>
    </div>
    <div class="w-50 m-auto">
        <form action="" method="post">
            <div class="form-group">
                <label>Patient Id</label>
                <input type="number" name="PatId" autocomplete="off" class="form-control">
            </div>
            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" autocomplete="off" class="form-control">
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" autocomplete="off" class="form-control">
            </div>

            <button type="submit" name="Register" value="Register" class="btn btn-success">Register</button>
        </form>
    </div>
    </div>
    </div>
</section>
<footer>
    <p class="p-3 bg-dark text-white text-center">@YouHeal</p>
</footer>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.3/dist/jquery.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>




<?php
// if(isset($_SESSION['message'])){
//     unset($_SESSION['message']);
// }
?>
