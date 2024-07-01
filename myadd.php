<!DOCTYPE html>
<html>
<?php 
require_once("function/book-class.php");
require_once("function/user-session.php");
require_once("assets/parts/user-head.php"); 
?>

<?php
$book = new mybookShop();

$userdata = $book->getUserData($userinfo['user_id']);

$fullName = isset($userdata['firstname']) && isset($userdata['middle_name']) && isset($userdata['lastname']) 
            ? $userdata['firstname'] . ' ' . $userdata['middle_name'] . '' . $userdata['lastname'] 
            : '';

$phone_number = isset($userdata['phone_number']) 
            ? $userdata['phone_number'] 
            : '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Adding a new address
    if (isset($_POST['save-add'])) {
        // Retrieve customer_id from the form
        $customer_id = $_POST['customer_id'];

        // Other form fields
        $fullname = $_POST['fullname']; // Assuming this is populated correctly
        $phone_number = $_POST['phone-number']; // Assuming this is populated correctly
        $block_lot = $_POST['block_lot'];
        $street = $_POST['street'];
        $barangay = $_POST['barangay'];
        $city = $_POST['city'];
        $province = $_POST['province'];
        $country = $_POST['country'];
        $postal_code = $_POST['postal-code'];

        // Debugging statement to check retrieved customer_id
        echo "Customer ID: $customer_id";

        // Call your method to add the address, passing all necessary data
        $result = $book->addAddress($customer_id, $fullname, $phone_number, $block_lot, $street, $barangay, $city, $province, $country, $postal_code);

        if ($result) {
            echo "<script>alert('Address successfully added!'); window.location.href='myadd.php';</script>";
        } else {
            echo "<script>alert('Failed to add address. Please try again.');</script>";
        }
    }

    // Editing an address
    if (isset($_POST['edit-address'])) {
        $address_id = $_POST['address_id'];
        $fullname = $_POST['edit-fullname'];
        $phone_number = $_POST['edit-phone-number'];
        $country = $_POST['edit-country'];
        $province = $_POST['edit-province'];
        $city = $_POST['edit-city'];
        $barangay = $_POST['edit-barangay'];
        $street = $_POST['edit-street'];
        $block_lot = $_POST['edit-block_lot'];
        $postal_code = $_POST['edit-postal-code'];

        // Debugging statements
        echo "Address ID: $address_id, Country: $country, Province: $province, City: $city, Barangay: $barangay, Street: $street, Block_Lot: $block_lot, Postal_Code: $postal_code";

        // Assuming $book is an instance of mybookShop
        $result = $book->editAddress($address_id, $fullname, $phone_number, $country, $province, $city, $barangay, $street, $block_lot, $postal_code);

        if ($result) {
            echo "<script>alert('Address successfully updated!'); window.location.href='myadd.php';</script>";
        } else {
            echo "<script>alert('No changes detected or Failed to update address. Please try again.');</script>";
        }
    }

    // Deleting an address
    if (isset($_POST['delete-address'])) {
        $address_id = $_POST['address_id'];
        // Debugging statement
        echo "Attempting to delete address with ID: $address_id";
        $result = $book->deleteAddress($address_id);

        if ($result) {
            echo "<script>alert('Address successfully deleted!'); window.location.href='myadd.php';</script>";
        } else {
            echo "<script>alert('Failed to delete address. Please try again.');</script>";
        }
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
<?php 
require_once("assets/inc/navbar.php"); 
?>

<div class="container" id="my-order">
    <div id="mini_user_nav">
        <span class="d-flex">
            <a href="index.php" class="me-1 text-dark home"> Home / </a>
            <a href="#" class="account"> My Addresses</a>
        </span> 
    </div>

    <div class="row mt-5">
        <div class="col-md-4">
            <?php require_once("assets/inc/user_sidebar.php"); ?>
        </div>

        <div class="col-md-8 mt-5">
            <h5>My Addresses</h5>
            <br>  

            <div class="addresses-header">
                <button style="margin-top: -25px; background-color: #BF9270; margin-left: 550px; font-size: 12px;" class="add-address-button" id="addAddressBtn">ADD NEW ADDRESS</button>
            </div>

            <div class="row" style="margin-left: -50px;">
                <div>

                    <section class="content">
                        <?php 
                        $customer_id = $userinfo['user_id'];
                        $addresses = $book->getAddresses($customer_id);
                        $userdata = $book->usersLogin();

                        if (empty($addresses)) {
                            echo '<p style="text-align: center;">No address available.</p>';
                        } else {
                            foreach ($addresses as $address) {
                                echo '<div class="address-item" style="box-shadow: 5px 5px #BF9270; width: 650px;">';
                                echo "<p><b>Customer's Name: </b>{$address['customer_name']} | <b>Phone Number: </b> {$address['phone_number']}</p>";
                                echo "<p><b>Shipping Address: </b>{$address['block_lot']} {$address['street']}, {$address['barangay']}, {$address['city']}, {$address['province']}, {$address['country']}, {$address['postal_code']}</p>";
                                echo '<div class="actions">';
                                echo "<button style='margin-right: 5px;' type='button' class='btn btn-primary edit-address-btn' id='editAddress'>Edit</button>";
                                echo "<button type='button' class='btn btn-danger delete-address-btn' id='delAddress'>Delete</button>";
                                echo '</div>';
                                echo '</div>';
                            }
                        }
                        ?>
                    </section>


                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div id="addressModal" class="modal">
    <div class="modal-content"  style="background-color: #FEF8F2; width: 550px; margin-top: 25px;">
        <h1 style="display: flex; color: #BF9270;">ADD NEW ADDRESS <span style="padding: 2px 5px; margin-left: 250px;" class="close">&times;</span></h1>
        <h6 style="margin-left: 50px; margin-top: -5px;">Insert your address here.</h6>
        <hr style="margin-top: -5px; border: 2px solid #BF9270; color: #BF9270;">
        <form style="background-color: #FEF8F2; width: 500px;" class="address-form" method="POST">
            <input type="hidden" id="customer_id" name="customer_id" value="<?php echo htmlspecialchars($customer_id); ?>">
            <div class="form-group">
                <label for="fullname">Full Name</label>
                <input type="text" id="fullname" name="fullname" value="<?php echo htmlspecialchars($fullName); ?>" required> 
            </div>
            <div class="form-group">
                <label for="phone-number">Phone Number</label>
                <input type="text" id="phone-number" name="phone-number" value="<?php echo htmlspecialchars($phone_number); ?>" required>
            </div>
            <div class="form-group">
                <label for="block_lot">House No./Block and Lot No./Building Name</label>
                <input type="text" id="block_lot" name="block_lot" required>
            </div>
            <div class="form-group">
                <label for="street">Street</label>
                <input type="text" id="street" name="street" required>
            </div>
            <div class="form-group">
                <label for="barangay">Barangay</label>
                <input type="text" id="barangay" name="barangay" required>
            </div>
            <div class="form-group">
                <label for="city">City</label>
                <input type="text" id="city" name="city" required>
            </div>
            <div class="form-group">
                <label for="province">Province</label>
                <input type="text" id="province" name="province" required>
            </div>
            <div class="form-group">
                <label for="country">Country</label>
                <input type="text" id="country" name="country" required>
            </div>
            <div class="form-group">
                <label for="postal-code">Postal Code</label>
                <input type="number" id="postal-code" name="postal-code" min="1000" max="9999" required>
            </div>
            <button name="save-add" type="submit">Save</button>
        </form>
    </div>
</div>

<div id="editModal" class="modal">
    <div class="modal-content" style="background-color: #FEF8F2; width: 550px; margin-top: 25px;">
        <h1 style="display: flex; color: #BF9270;">Edit Address <span style="padding: 2px 5px; margin-left: 325px;" class="close">&times;</span></h1>
        <h6 style="margin-left: 50px; margin-top: -5px;">Update your address details.</h6>
        <hr style="margin-top: -5px; border: 2px solid #BF9270; color: #BF9270;">
        <form class="address-form" method="POST">
            <!-- Input fields populated with PHP from tbl_address -->
            <input type="hidden" id="address_id" name="address_id" value="<?php echo isset($address['address_id']) ? htmlspecialchars($address['address_id']) : ''; ?>">

            <div class="form-group">
                <label for="edit-fullname">Full Name</label>
                <input type="text" id="edit-fullname" name="edit-fullname" value="<?php echo htmlspecialchars($fullName); ?>" required>
            </div>

            <div class="form-group">
                <label for="edit-phone-number">Phone Number</label>
                <input type="text" id="edit-phone-number" name="edit-phone-number" value="<?php echo htmlspecialchars($phone_number); ?>" required>
            </div>

            <div class="form-group">
                <label for="edit-block_lot">House No./Block and Lot No./Building Name</label>
                <input type="text" id="edit-block_lot" name="edit-block_lot" value="<?php echo htmlspecialchars($address['block_lot']); ?>" required>
            </div>

            <div class="form-group">
                <label for="edit-street">Street</label>
                <input type="text" id="edit-street" name="edit-street" value="<?php echo htmlspecialchars($address['street']); ?>" required>
            </div>

            <div class="form-group">
                <label for="edit-barangay">Barangay</label>
                <input type="text" id="edit-barangay" name="edit-barangay" value="<?php echo htmlspecialchars($address['barangay']); ?>" required>
            </div>

            <div class="form-group">
                <label for="edit-city">City</label>
                <input type="text" id="edit-city" name="edit-city" value="<?php echo htmlspecialchars($address['city']); ?>" required>
            </div>

            <div class="form-group">
                <label for="edit-province">Province</label>
                <input type="text" id="edit-province" name="edit-province" value="<?php echo htmlspecialchars($address['province']); ?>" required>
            </div>     
                   
            <div class="form-group">
                <label for="edit-country">Country</label>
                <input type="text" id="edit-country" name="edit-country" value="<?php echo htmlspecialchars($address['country']); ?>" required>
            </div>

            <div class="form-group">
                <label for="edit-postal-code">Postal Code</label>
                <input type="text" id="edit-postal-code" name="edit-postal-code" value="<?php echo htmlspecialchars($address['postal_code']); ?>" required>
            </div>

            <button type="submit" class="btn btn-primary" name="edit-address">Save Changes</button>
        </form>
    </div>
</div>


<div id="deleteModal" class="modal">
    <div class="modal-content" style="width: 500px;">
        <h1>Confirm Delete</h1>
        <p>Are you sure you want to delete this address?</p>
        <form method="POST">
            <input type="hidden" id="address_id" name="address_id" value="<?php echo isset($address['address_id']) ? htmlspecialchars($address['address_id']) : ''; ?>">
            <button type="submit" class="btn btn-danger" name="delete-address">Delete</button>
        </form>
    </div>
</div>



<?php 
require_once("assets/inc/footer.php");
require_once("assets/parts/user-bottom.php");
?>

<script>
// Get the modal elements
var modal = document.getElementById("addressModal");
var editModal = document.getElementById("editModal");
var deleteModal = document.getElementById("deleteModal");

// Get the buttons that open the modals
var btn = document.getElementById("addAddressBtn");

// Get the close buttons (span elements)
var span = document.getElementsByClassName("close");

// Get all edit and delete buttons inside each address item
var editButtons = document.querySelectorAll(".edit-address-btn");
var deleteButtons = document.querySelectorAll(".delete-address-btn");

// Function to open the edit modal
function openEditModal(addressId) {
    editModal.style.display = "block";
    // Example: Load existing data into the form fields based on addressId
    document.getElementById("edit-address-id").value = addressId;
    // Fetch existing data and populate form fields for editing
}

// Function to open the delete modal
function openDeleteModal(addressId) {
    var modal = document.getElementById("deleteModal");
    modal.style.display = "block";
    document.getElementById("delete-address-id").value = addressId;
}

// When the user clicks on the button, open the add address modal
btn.onclick = function() {
    modal.style.display = "block";
}

// When the user clicks on <span> (x) or outside of the modal, close it
for (var i = 0; i < span.length; i++) {
    span[i].onclick = function() {
        modal.style.display = "none";
        editModal.style.display = "none";
        deleteModal.style.display = "none";
    }
}

// When the user clicks on edit buttons, open the edit modal for respective address
editButtons.forEach(function(button) {
    button.onclick = function(event) {
        var addressId = button.dataset.addressId; // Example: Assuming dataset contains address ID
        openEditModal(addressId);
    }
});

// When the user clicks on delete buttons, open the delete modal for respective address
deleteButtons.forEach(button => {
    button.addEventListener("click", () => {
        var addressId = button.dataset.addressId;
        openDeleteModal(addressId);
    });
});

document.getElementById('postal-code').addEventListener('input', function() {
        let postalCode = this.value.trim();
        if (!/^\d{4}$/.test(postalCode)) {
            this.setCustomValidity('Postal code must be a 4-digit number');
        } else {
            this.setCustomValidity('');
        }
    });

// When the user clicks anywhere outside of the modals, close them
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
    if (event.target == editModal) {
        editModal.style.display = "none";
    }
    if (event.target == deleteModal) {
        deleteModal.style.display = "none";
    }
}

</script>
</body>
</html>
