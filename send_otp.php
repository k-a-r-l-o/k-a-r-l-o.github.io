<?php
session_start();
require 'vendor/autoload.php'; // Ensure this path is correct

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Set the desired timezone
date_default_timezone_set('Asia/Manila');

// Function to send OTP email
function sendOtpEmail($email, $otp)
{
    $mail = new PHPMailer(true);
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'tsccomelec@usep.edu.ph';
        $mail->Password = 'yhli ebrp gdbv lqet';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('tsccomelec@usep.edu.ph', 'U-vote Voting System');
        $mail->addAddress($email);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Your OTP Code';
        $mail->Body    = "
            <html>
            <head>
                <style>
                    .email-container {
                        font-family: Arial, sans-serif;
                        line-height: 1.6;
                        color: #333;
                    }
                    .email-header {
                        background-color: #f7f7f7;
                        padding: 20px;
                        text-align: center;
                        color: #4361EE;
                        font-weight: bolder;
                    }
                    .email-header {
                        background-color: #f7f7f7;
                        padding: 20px;
                        text-align: center;
                    }
                    .email-body {
                        padding: 20px;
                    }
                    .otp-code {
                        font-size: 24px;
                        font-weight: bold;
                        color: #ff6f61;
                        text-align: center;
                        margin: 20px 0;
                    }
                    .instructions {
                        margin-top: 20px;
                    }
                    .footer {
                        margin-top: 30px;
                        font-size: 12px;
                        color: #777;
                        text-align: center;
                    }
                </style>
            </head>
            <body>
                <div class='email-container'>
                    <div class='email-header'>
                        <h2>U-vote Voting System</h2>
                    </div>
                    <div class='email-body'>
                        <p>Dear USePians!</p>
                        <p>We have received a request to log in to the U-vote Voting System using your email address. Please use the following One-Time Password (OTP) to complete your login:</p>
                        <div class='otp-code'>$otp</div>
                        <p class='instructions'>For your security, this OTP is valid for the next 10 minutes. If you did not request this, please ignore this email or contact support.</p>
                        <p>Thank you for your participation in the voting process.</p>
                        <p>Best regards,</p>
                        <p>U-vote Voting System Team</p>
                    </div>
                    <div class='footer'>
                        <p>&copy; 2024 U-vote Voting System. All rights reserved.</p>
                    </div>
                </div>
            </body>
            </html>";

        $mail->send();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

// Function to generate OTP
function generateOtp()
{
    return rand(100000, 999999); // Generate a 6-digit random number
}

$email = $_SESSION["username"];
$usep_ID = $_SESSION["usep_ID"];
$otp = generateOtp();

// Establishing a connection to the database
$servername = "localhost"; // Replace with your server name
$username = "u753706103_uvote"; // Replace with your username
$password = "UV+;!!c#~p1"; // Replace with your password
$dbname = "u753706103_Voting_System"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$stmt = $conn->prepare("UPDATE voters SET VPassword = ? WHERE usep_ID = ?");
$stmt->bind_param("si", $otp, $usep_ID);
$stmt->execute();
$stmt->close();

sendOtpEmail($email, $otp);

$response = ['success' => true, 'message' => 'A new OTP has been sent to your email.'];
echo json_encode($response);
