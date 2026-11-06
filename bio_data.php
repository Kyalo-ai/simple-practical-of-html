<?php
// Database connection parameters
$host = 'localhost';
$dbname = 'gfh_bank';
$username = 'root'; // Default XAMPP username
$password = '';     // Default XAMPP password

$message = '';

// Task 2 viii: PHP code to connect and insert data using prepared statements
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect data
    $firstName = trim($_POST['first_name']);
    $lastName = trim($_POST['last_name']);
    $address = trim($_POST['address']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $gender = $_POST['gender'] ?? '';
    $membership = $_POST['membership'];

    // Task 2 xi: Server-side validation
    $errors = [];
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid Email ID format.";
    }
    
    // Validate phone number (assuming 10 digits based on sample data)
    if (!preg_match('/^[0-9]{10}$/', $phone)) {
        $errors[] = "Invalid Phone Number format. It must be 10 digits.";
    }

    if (empty($errors)) {
        try {
            $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Prepared statement to prevent SQL injection
            $sql = "INSERT INTO EmployeeTable (first_name, last_name, address, email, phone, gender, membership_duration) 
                    VALUES (:first_name, :last_name, :address, :email, :phone, :gender, :membership)";
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':first_name' => $firstName,
                ':last_name' => $lastName,
                ':address' => $address,
                ':email' => $email,
                ':phone' => $phone,
                ':gender' => $gender,
                ':membership' => $membership
            ]);

            $message = "<p style='color: green; text-align:center;'>Data saved successfully!</p>";
        } catch (PDOException $e) {
            $message = "<p style='color: red; text-align:center;'>Database Error: " . $e->getMessage() . "</p>";
        }
    } else {
        $message = "<p style='color: red; text-align:center;'>" . implode("<br>", $errors) . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Bio-Data Form</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main>
        <?php echo $message; ?>
        
        <div class="bio-form-container">
            <!-- Task 2 ii: Display heading -->
            <h2 style="text-align: center;">Employee Bio-Data Form</h2>
            
            <!-- Task 3 iii: ARIA labels/roles and Task 2 x: HTML5 validation (required) -->
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" role="form" aria-label="Employee Bio-Data Form">
                
                <label for="first_name" id="lbl_fname">First Name:</label>
                <input type="text" id="first_name" name="first_name" required aria-required="true">

                <label for="last_name" id="lbl_lname">Last Name:</label>
                <input type="text" id="last_name" name="last_name" required aria-required="true">

                <label for="address" id="lbl_address">Address:</label>
                <input type="text" id="address" name="address" required aria-required="true">

                <label for="email" id="lbl_email">Email ID:</label>
                <input type="email" id="email" name="email" required aria-required="true">

                <label for="phone" id="lbl_phone">Phone Number:</label>
                <input type="tel" id="phone" name="phone" pattern="[0-9]{10}" required aria-required="true" title="10 digit phone number">

                <!-- Task 2 iv: Radio buttons -->
                <div class="radio-group" role="radiogroup" aria-labelledby="gender-label">
                    <span id="gender-label">Gender:</span><br>
                    <input type="radio" id="male" name="gender" value="Male" required aria-required="true">
                    <label for="male">Male</label>
                    
                    <input type="radio" id="female" name="gender" value="Female">
                    <label for="female">Female</label>
                </div>

                <!-- Task 2 iii: Dropdown list -->
                <label for="membership" id="lbl_membership">Membership Duration:</label>
                <select id="membership" name="membership" required aria-required="true">
                    <option value="">-- Select Duration --</option>
                    <option value="1 Year">1 Year</option>
                    <option value="2 Years">2 Years</option>
                    <option value="5 Years">5 Years</option>
                </select>

                <!-- Task 2 vi: Submit and Reset -->
                <button type="submit">Submit</button>
                <button type="reset">Reset</button>
            </form>
        </div>
    </main>
</body>
</html>