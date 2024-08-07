<?php
session_start();
header('Content-Type: application/json');

// Function to verify the password against the database
function verifyPassword($username, $password)
{
    // Database connection
    $servername = "localhost"; // Replace with your server name
    $db_username = "u753706103_uvote"; // Replace with your username
    $db_password = "UV+;!!c#~p1"; // Replace with your password
    $dbname = "u753706103_Voting_System"; // Replace with your database name

    $conn = new mysqli($servername, $db_username, $db_password, $dbname);

    if ($conn->connect_error) {
        return ["status" => "error", "message" => "Connection failed: " . $conn->connect_error];
    }

    // Prepare SQL statement to retrieve user from database
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        return ["status" => "error", "message" => "Error preparing statement: " . $conn->error];
    }
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // User exists, fetch details
        $row = $result->fetch_assoc();
        // Verify the password
        if (password_verify($password, $row["userpass"]) && $_SESSION["usertype"] === $row["usertype"]) {
            $stmt->close();
            $conn->close();
            return ["status" => "success"];
        }
    }

    $stmt->close();
    $conn->close();
    return ["status" => "error", "message" => "Incorrect Password"];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);

    if (isset($input['password']) && isset($input['username'])) {
        $username = $input['username'];
        $password = $input['password'];

        // Verify password
        $verification = verifyPassword($username, $password);
        if ($verification["status"] === "success") {
            // Database connection
            $servername = "localhost"; // Replace with your server name
            $db_username = "u753706103_uvote"; // Replace with your username
            $db_password = "UV+;!!c#~p1"; // Replace with your password
            $dbname = "u753706103_Voting_System"; // Replace with your database name

            $conn = new mysqli($servername, $db_username, $db_password, $dbname);

            if ($conn->connect_error) {
                echo json_encode(["status" => "error", "message" => "Connection failed: " . $conn->connect_error]);
                exit();
            }

            // SQL statement to truncate the table
            $sqlClear = "TRUNCATE TABLE voting_schedule";

            // Execute the statement and check if the truncation was successful
            if ($conn->query($sqlClear) === TRUE) {
                // Log the login activity
                $usepID = $_SESSION["usep_ID"];
                $logAction = 'Cleared Schedule';
                date_default_timezone_set('Asia/Manila');
                $date = date("Y-m-d");
                $time = date("H:i:s");
                $sqlInsertLog = "INSERT INTO activity_logs (usep_ID, logs_date, logs_time, logs_action) VALUES (?, ?, ?, ?)";
                $stmt = $conn->prepare($sqlInsertLog);
                if ($stmt) {
                    $stmt->bind_param("ssss", $usepID, $date, $time, $logAction);
                    $stmt->execute();
                    $stmt->close();
                } else {
                    echo json_encode(["status" => "error", "message" => "Error preparing statement: " . $conn->error]);
                    exit();
                }
                echo json_encode(["status" => "success", "message" => "Voting schedule cleared successfully"]);
            } else {
                echo json_encode(["status" => "error", "message" => "Error clearing voting schedule: " . $conn->error]);
            }
            $conn->close();
            exit();
        } else {
            echo json_encode($verification);
            exit();
        }
    }
}
echo json_encode(["status" => "error", "message" => "Invalid request"]);
