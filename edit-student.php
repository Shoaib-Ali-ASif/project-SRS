<?php require_once('./database/connection.php'); ?>

<?php
if(isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];
} else {
    header('location: ./show-students.php');
}

$sql = "SELECT * FROM `students` WHERE `id` = $id";
$result = $conn->query($sql);
$student = $result->fetch_assoc();

$name = $student['name'];
$email = $student['email'];

if (isset($_POST['submit'])) {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);

    if (empty($name)) {
        $error = "Enter student name!";
    } elseif (empty($email)) {
        $error = "Enter student email!";
    } else {

        $sql = "SELECT * FROM `students` WHERE `email` = '$email' AND `id` = $id";
        $result = $conn->query($sql);
        if($result->num_rows === 0) {
            $sql = "UPDATE `students` SET `name` = '$name', `email` = '$email' WHERE `id` = $id";
            if ($conn->query($sql)) {
                $success = "successfully updated!";
            } else {
                $error = "failed!";
            }
        } else {
            $error = "Email already exists!";
        }

        
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<?php require_once('./includes/head.php'); ?>

<body>
    <div class="wrapper">
        <?php require_once('./includes/sidenavbar.php'); ?>
        <div class="main">
            <?php require_once('./includes/topnavbar.php'); ?>
            <div class="card-body mt-5 mx-5">
                <div class="row mx-5">
                    <div class="col-6">
                        <h1 class="h1 mb-3">Edit Student</h1>
                    </div>
                    <div class="col-6 text-end">
                        <a href="./show-students.php" class="btn btn-outline-primary">Back</a>
                    </div>
                </div>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>?id=<?php echo $id; ?>" method="post">
                    <?php require_once('./includes/flash-messages.php'); ?>
                    <div class="mb-3">
                        <label for="name" class="form-label h4">Name</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Enter your name!" value="<?php echo $name; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label h4">Email</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="Enter your email!" value="<?php echo $email; ?>">
                    </div>
                    <div>
                        <input type="submit" name="submit" value="Submit" class="btn btn-primary">

                    </div>
                </form>
            </div>
            <?php require_once('./includes/footer.php'); ?>
        </div>
    </div>
    <script src="assets/js/app.js"></script>
</body>

</html>