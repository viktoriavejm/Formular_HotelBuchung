<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buchungsanmeldung</title>
    <link rel="stylesheet" href="./index.css">
</head>
<body>

    <?php
    // INIT VARIABLES
    $errors = [];
    $first_name = $last_name = $email = $roomType = $checkIn = $checkOut = $guests = $extras = $specialRequests = "";

    // CHECK POST DATA
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Validate First Name
        if (empty($_POST["first_name"])) {
            $errors[] = "Vorname ist erforderlich.";
        } else {
            $first_name = htmlspecialchars($_POST["first_name"]);
        }

        // Validate Last Name
        if (empty($_POST["last_name"])) {
            $errors[] = "Nachname ist erforderlich.";
        } else {
            $last_name = htmlspecialchars($_POST["last_name"]);
        }

        // Validate Email
        if (empty($_POST["email"])) {
            $errors[] = "E-Mail ist erforderlich.";
        } else {
            $email = htmlspecialchars($_POST["email"]);
        }

        // Validate Room Type
        if (empty($_POST["room-type"])) {
            $errors[] = "Zimmertyp ist erforderlich.";
        } else {
            $roomType = htmlspecialchars($_POST["room-type"]);
        }

        // Validate Check-in and Check-out Dates
        if (empty($_POST["check-in"])) {
            $errors[] = "Check-in-Datum ist erforderlich.";
        } else {
            $checkIn = htmlspecialchars($_POST["check-in"]);
        }

        if (empty($_POST["check-out"])) {
            $errors[] = "Check-out-Datum ist erforderlich.";
        } else {
            $checkOut = htmlspecialchars($_POST["check-out"]);
        }

        // Validate Guests
        if (empty($_POST["guests"])) {
            $errors[] = "Die Anzahl der Gäste ist erforderlich.";
        } else {
            $guests = htmlspecialchars($_POST["guests"]);
        }

        // Validate Extras
        if (!empty($_POST["extras"])) {
            $extras = implode(", ", array_map('htmlspecialchars', $_POST["extras"]));
        } else {
            $extras = "Keine Extras ausgewählt.";
        }

        // Special Requests
        if (!empty($_POST["special-requests"])) {
            $specialRequests = htmlspecialchars($_POST["special-requests"]);
        }

        // Check for at least one extra
        if (empty($_POST["extras"])) {
            $errors[] = "Mindestens eine Zusatzoption ist erforderlich.";
        }

        // CHECK SUCCESS
        if (empty($errors)) {
            echo "<div class='success'>";
            echo "<h1>Vielen Dank für Ihre Buchung!</h1>";
            echo "<p>Wir werden uns in den nächsten Wochen bei Ihnen melden.</p>";
            echo "<ul>
                    <li><strong>Vorname:</strong> " . htmlspecialchars($first_name) . "</li>
                    <li><strong>Nachname:</strong> " . htmlspecialchars($last_name) . "</li>
                    <li><strong>E-Mail:</strong> " . htmlspecialchars($email) . "</li>
                    <li><strong>Zimmertyp:</strong> " . htmlspecialchars($roomType) . "</li>
                    <li><strong>Check-in:</strong> " . htmlspecialchars($checkIn) . "</li>
                    <li><strong>Check-out:</strong> " . htmlspecialchars($checkOut) . "</li>
                    <li><strong>Gäste:</strong> " . htmlspecialchars($guests) . "</li>
                    <li><strong>Extras:</strong> " . htmlspecialchars($extras) . "</li>
                    <li><strong>Besondere Wünsche:</strong> " . htmlspecialchars($specialRequests) . "</li>
                </ul>";
            echo "<a href='./index.php'>Zurück zum Formular</a>";
            echo "</div>";  
            exit;
        }
    }
    ?>

    <!-- FORM OUTPUT -->
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <h1>Buchung</h1>

        <label for="first_name">Vorname:</label>
        <input type="text" id="first_name" name="first_name" value="<?php echo $first_name; ?>"><br>

        <label for="last_name">Nachname:</label>
        <input type="text" id="last_name" name="last_name" value="<?php echo $last_name; ?>"><br>

        <label for="email">E-Mail:</label>
        <input type="email" id="email" name="email" value="<?php echo $email; ?>"><br>

        <label for="room-type">Zimmertyp:</label>
        <select id="room-type" name="room-type">
            <option value="single" <?php echo ($roomType === "single") ? "selected" : ""; ?>>Einzelzimmer</option>
            <option value="double" <?php echo ($roomType === "double") ? "selected" : ""; ?>>Doppelzimmer</option>
            <option value="suite" <?php echo ($roomType === "suite") ? "selected" : ""; ?>>Suite</option>
        </select><br>

        <label for="check-in">Check-in Datum:</label>
        <input type="date" id="check-in" name="check-in" value="<?php echo $checkIn; ?>"><br>

        <label for="check-out">Check-out Datum:</label>
        <input type="date" id="check-out" name="check-out" value="<?php echo $checkOut; ?>"><br>

        <label for="guests">Anzahl der Gäste:</label>
        <input type="number" id="guests" name="guests" min="1" max="10" value="<?php echo $guests; ?>"><br>

        <label for="extras">Zusatzoptionen:</label><br>
        <input type="checkbox" id="breakfast" name="extras[]" value="breakfast" <?php echo (strpos($extras, "breakfast") !== false) ? "checked" : ""; ?>>
        <label for="breakfast">Frühstück</label>
        <input type="checkbox" id="parking" name="extras[]" value="parking" <?php echo (strpos($extras, "parking") !== false) ? "checked" : ""; ?>>
        <label for="parking">Parkplatz</label>
        <input type="checkbox" id="spa" name="extras[]" value="spa" <?php echo (strpos($extras, "spa") !== false) ? "checked" : ""; ?>>
        <label for="spa">Spa</label><br>

        <label for="special-requests">Besondere Wünsche:</label><br>
        <textarea id="special-requests" name="special-requests" rows="4" cols="50"><?php echo $specialRequests; ?></textarea><br>

        <?php
          if (!empty($errors)) {
            echo "<div style='color: red;'><ul>";
            foreach ($errors as $error) {
                echo "<li>$error</li>";
            }
            echo "</ul></div>";
        }
        ?>

        <input id="submit" type="submit" value="Buchung abschicken">
    </form>
</body>
</html>
