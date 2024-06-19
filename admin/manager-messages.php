<?php
require_once('settings.php');

// Start the session at the beginning of your script if it's not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is not identified, redirect to login page
if (!isset($_SESSION['IDENTIFY']) || !$_SESSION['IDENTIFY']) {
    header('Location: login.php');
    exit();
}

$msg = null;
$result = null;
$execute = false;

// Check the database connection
if (!is_object($conn)) {
    $msg = getMessage($conn, 'error');
} else {
    // Fetch all messages from the database
    $result = getAllMessagesDB($conn);

    // Check if messages exist
    if (is_array($result) && !empty($result)) {
        $execute = true;

        // Check if message ID is provided in the URL for deletion
        if (isset($_GET['idContact']) && is_numeric($_GET['idContact'])) {

            $messageIdToDelete = $_GET['idContact'];

            if ($_SESSION['user_permission'] == 1) {

                // Delete the message from the database
                $deleteResult = deleteMessageDB($conn, $messageIdToDelete);

                // Check deletion result and display appropriate message
                if ($deleteResult === true) {
                    $_SESSION['message'] = getMessage('Message successfully deleted.', 'success');

                    // Refresh the page to reflect the changes after deletion
                    header('Location: manager-messages.php');
                    exit();
                } else {
                    $_SESSION['message'] = getMessage('Error when deleting message.' . $deleteResult, 'error');
                }
            } else {
                $_SESSION['message'] = getMessage('You are not allowed to delete the message.', 'error');
            }
        }
    } else {
        $_SESSION['message'] = getMessage('There is no message to display at the moment.', 'error');
    }
}

// Refresh the redirected page (manager-messages.php), add this code to display the message
if (isset($_SESSION['message'])) {
    $msg = $_SESSION['message'];
    unset($_SESSION['message']); 
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    // Include the head section
    displayHeadSection('My messages');
    displayJSSection();
    ?>
</head>

<body>

    <!-----------------------------------------------------------------
							   Header
	------------------------------------------------------------------>
    <header>
        <!-----------------------------------------------------------------
							   Navigation
	    ------------------------------------------------------------------>
        <?php displayNavigation(); ?>
        <!-----------------------------------------------------------------
							Navigation end
	    ------------------------------------------------------------------>
    </header>
    <!-----------------------------------------------------------------
							   Header end
	------------------------------------------------------------------>
    <div class="table-messages container">
        <h1 class="title">Mes messages</h1>
        <div id="message">
            <?= isset($msg) ? $msg : ''; ?>
        </div>

        <div id="content" class="container">
            <?php
            // If messages exist, display them in a table
            if ($execute) {
                displayMessagesAsTable($result);
            }
            ?>
        </div>
    </div>

    <!-----------------------------------------------------------------
                               Footer
    ------------------------------------------------------------------>
    <footer>
        <?php displayFooter(); ?>
    </footer>
    <!-----------------------------------------------------------------
                                   Footer end
    ------------------------------------------------------------------>

    <script>
        function deleteMessage(messageId) {
            // Confirm message deletion
            if (confirm('Are you sure you want to delete the message below?')) {
                // Redirect to manager-message.php with the message ID for deletion
                window.location.href = 'manager-messages.php?idContact=' + messageId;
            }
        }
    </script>

    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/js/all.min.js" integrity="sha512-u3fPA7V8qQmhBPNT5quvaXVa1mnnLSXUep5PS1qo5NRzHwG19aHmNJnj1Q8hpA/nBWZtZD4r4AX6YOt5ynLN2g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- Main Js -->
    <script src="../js/functions.js"></script>
</body>

</html>