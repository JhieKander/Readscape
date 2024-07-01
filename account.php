<?php

require_once("function/book-class.php");
require_once("function/user-session.php");
require_once("assets/parts/user-head.php"); 
require_once("assets/inc/navbar.php"); 

$user_id = $_SESSION['user_id'];
$book = new mybookShop();

$firstname = '';
$middle_name = '';
$lastname = '';
$birthday = '';
$phone_number = '';
$email = '';
$user_image = '';
$userdata = null; // Initialize $userdata

if ($user_id) {
    $userdata = $book->getUserData($user_id);

    if ($userdata !== null) {
        $firstname = isset($userdata['firstname']) ? $userdata['firstname'] : '';
        $middle_name = isset($userdata['middle_name']) ? $userdata['middle_name'] : '';
        $lastname = isset($userdata['lastname']) ? $userdata['lastname'] : '';
        $birthday = isset($userdata['birthdate']) ? $userdata['birthdate'] : '';
        $phone_number = isset($userdata['phone_number']) ? $userdata['phone_number'] : '';
        $email = isset($userdata['email']) ? $userdata['email'] : '';
        $user_image = isset($userdata['user_image']) ? $userdata['user_image'] : '';

        if (!empty($birthday)) {
            $date = new DateTime($birthday);
            $formatted_birthday = $date->format('F d, Y'); // Example: January 01, 2000
        } else {
            $formatted_birthday = '';
        }
    } else {
        // Handle case where user data could not be retrieved
        echo "<script>alert('User data not found.');</script>";
    }
} else {
    echo "<script>alert('User ID not found.');</script>";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle file upload if form submitted
    if (isset($_FILES["profile_picture"]) && $_FILES["profile_picture"]["error"] == 0) {
        $target_dir = "assets/images/profile/"; // Directory where you want to store uploaded images
        $target_file = $target_dir . basename($_FILES["profile_picture"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is a valid image
        $check = getimagesize($_FILES["profile_picture"]["tmp_name"]);
        if ($check === false) {
            echo "<script>alert('File is not an image.');</script>";
            $uploadOk = 0;
        }

        // Check file size (max 5MB)
        if ($_FILES["profile_picture"]["size"] > 5000000) {
            echo "<script>alert('Sorry, your file is too large.');</script>";
            $uploadOk = 0;
        }

        // Allow certain file formats
        $allowed_formats = ["jpg", "jpeg", "png", "gif"];
        if (!in_array($imageFileType, $allowed_formats)) {
            echo "<script>alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.');</script>";
            $uploadOk = 0;
        }

        // If all checks passed, attempt to upload file
        if ($uploadOk == 1) {
            if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file)) {
                // Update user_image column in database
                $image_name = basename($_FILES["profile_picture"]["name"]);
                $connection = $book->openConnection();
                $stmt = $connection->prepare("UPDATE tbl_users SET user_image = ? WHERE user_id = ?");
                $stmt->execute([$image_name, $user_id]);
                $book->closeConnection();

                echo "<script>alert('Uploading your profile picture is successful!'); window.location.href='account.php';</script>";
            } else {
                echo "<script>alert('Sorry, there was an error uploading your file.');</script>";
            }
        }
    } else {
        echo "<script>alert('No file uploaded.');</script>";
    }
}
?>

<style type="text/css">
.content {
    width: 75%;
    margin-left: 5%;
}

.addresses-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

h1 {
    font-size: 24px;
}

.add-address-button {
    background-color: #d3b185;
    color: #fff;
    border: none;
    padding: 10px 20px;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
}

.address-form {
    background-color: #fff;
    padding: 20px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.form-group {
    margin-bottom: 15px;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
}

.form-group input {
    width: 100%;
    padding: 8px;
    border: 1px solid #e0e0e0;
    border-radius: 4px;
}

button[type="submit"] {
    background-color: #d3b185;
    color: #fff;
    border: none;
    padding: 10px 20px;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
}

.modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0,0,0,0.4);
}

.modal-content {
    background-color: #fefefe;
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
}

.address-item {
    margin-bottom: 20px;
    padding: 15px;
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color: #f9f9f9;
}

.address-item h4 {
    margin-bottom: 10px;
}

.actions {
    margin-top: 10px;
}

.actions a {
    margin-right: 10px;
}
</style>

<body>

<div class="container" id="my-account">
    <div id="mini_user_nav">
        <span class="d-flex">
            <a href="index.php" class="me-1 text-dark home"> Home / </a>
            <a href="#" class="account"> My Account Information</a>
        </span> 
    </div>

    <div class="row mt-5">
        <div class="col-md-4">
            <?php require_once("assets/inc/user_sidebar.php"); ?>
        </div>

        <div class="col-md-8 mt-5">
            <h5 style="margin-top: -25px;">My Account Information</h5>
            <br>  

            <div class="row" style="box-shadow: 5px 5px #BF9270; border-radius: 10px; border: 2px solid lightgray; padding: 5px 10px;">
                <div class="col-md-6">
                    <form>
                        <div class="form-group">
                            <label for="firstname">First Name</label>
                            <input type="text" class="form-control" id="firstname" name="firstname" value="<?php echo htmlspecialchars($firstname); ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="middlename">Middle Name</label>
                            <input type="text" class="form-control" id="middlename" name="middlename" value="<?php echo htmlspecialchars($middle_name); ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="lastname">Last Name</label>
                            <input type="text" class="form-control" id="lastname" name="lastname" value="<?php echo htmlspecialchars($lastname); ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="birthday">Birthday</label>
                            <input type="text" class="form-control" id="birthday" name="birthday" value="<?php echo htmlspecialchars($formatted_birthday); ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($phone_number); ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" readonly>
                        </div>
                        <button type="button" class="btn btn-primary" style="margin-left: 40px; width: 275px;" data-toggle="modal" data-target="#editDetailsModal">Edit Details</button>
                    </form>
                </div>
                <div class="col-md-6">
                    <form method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="profile-picture">Profile Picture</label>
                            <div class="profile-picture-container">
                                <?php if (!empty($user_image)): ?>
                                    <img src="assets/images/profile/<?php echo htmlspecialchars($user_image); ?>" class="profile-picture" alt="Profile Picture" style="width: 200px; height: 200px;">
                                <?php else: ?>
                                    <p style="margin-left: 50px;">No profile picture uploaded yet.</p>
                                <?php endif; ?>
                            </div>
                            <input type="file" class="form-control-file" id="profile-picture" name="profile_picture">
                        </div>
                        <button type="submit" class="btn btn-primary">Upload Profile Picture</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Details Modal -->
<div class="modal" id="editDetailsModal">
    <div class="modal-content" style="background-color: #FEF8F2; width: 550px; margin-top: 25px;">
        <h1 style="display: flex; color: #BF9270;">Edit Account Information <span style="padding: 2px 5px; margin-left: 200px;" class="close">&times;</span></h1>
        <h6 style="margin-left: 50px; margin-top: -5px;">Update your account details.</h6>
        <hr style="margin-top: -5px; border: 2px solid #BF9270; color: #BF9270;">
        <form method="post" action="update_details.php">
            <div class="form-group">
                <label for="edit_firstname">First Name</label>
                <input type="text" class="form-control" id="edit_firstname" name="firstname" value="<?php echo htmlspecialchars($firstname); ?>">
            </div>
            <div class="form-group">
                <label for="edit_middlename">Middle Name</label>
                <input type="text" class="form-control" id="edit_middlename" name="middle_name" value="<?php echo htmlspecialchars($middle_name); ?>">
            </div>
            <div class="form-group">
                <label for="edit_lastname">Last Name</label>
                <input type="text" class="form-control" id="edit_lastname" name="lastname" value="<?php echo htmlspecialchars($lastname); ?>">
            </div>
            <div class="form-group">
                <label for="edit_birthday">Birthday</label>
                <input type="text" class="form-control" id="edit_birthday" name="birthday" value="<?php echo htmlspecialchars($formatted_birthday); ?>">
            </div>
            <div class="form-group">
                <label for="edit_phone">Phone Number</label>
                <input type="text" class="form-control" id="edit_phone" name="phone_number" value="<?php echo htmlspecialchars($phone_number); ?>">
            </div>
            <div class="form-group">
                <label for="edit_email">Email</label>
                <input type="email" class="form-control" id="edit_email" name="email" value="<?php echo htmlspecialchars($email); ?>" readonly>
            </div>
            <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>
</div>
</div>

<?php 
require_once("assets/inc/footer.php");
require_once("assets/parts/user-bottom.php");
?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var modal = document.getElementById('editDetailsModal');
    var btn = document.querySelector('button[data-toggle="modal"]');
    var closeBtn = document.querySelector('.modal-content .close');

    btn.onclick = function() {
        modal.style.display = "block";
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    if (closeBtn) {
        closeBtn.onclick = function() {
            modal.style.display = "none";
        }
    }
});
</script>


</body>
</html>
