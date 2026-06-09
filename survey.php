<?php
session_start();
include 'db_connect.php';

$success = "";
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate required fields
    $required = ['buong_pangalan', 'edad', 'kasarian', 'bilang_ng_pamilya', 'address'];
    $missing = [];
    foreach ($required as $field) {
        if (empty($_POST[$field])) {
            $missing[] = $field;
        }
    }
    
    if (!empty($missing)) {
        $error = "Missing required fields: " . implode(", ", $missing);
    } else {
        function clean($data) {
            return htmlspecialchars(trim($data ?? ''), ENT_QUOTES, 'UTF-8');
        }

        // Process checkboxes (sakuna)
        $sakuna = [];
        if (isset($_POST['sakuna']) && is_array($_POST['sakuna'])) {
            $sakuna = $_POST['sakuna'];
        }
        $sakunaStr = implode(';', array_map('clean', $sakuna));

        // Prepare all data
        $buong_pangalan = clean($_POST['buong_pangalan']);
        $edad = (int) $_POST['edad'];
        $kasarian = clean($_POST['kasarian']);
        $bilang_ng_pamilya = (int) $_POST['bilang_ng_pamilya'];
        $address = clean($_POST['address']);
        $kaalaman_panganib = clean($_POST['kaalaman_panganib'] ?? '');
        $gobag = clean($_POST['gobag'] ?? '');
        $emergency_contacts = clean($_POST['emergency_contacts'] ?? '');
        $evacuation_ease = clean($_POST['evacuation_ease'] ?? '');
        $total_members = (int) ($_POST['total_members'] ?? 0);
        $family_head = clean($_POST['family_head'] ?? '');
        $bp = clean($_POST['bp'] ?? '');
        $existing_illness = clean($_POST['existing_illness'] ?? '');
        $disability = clean($_POST['disability'] ?? '');
        $disability_details = clean($_POST['disability_details'] ?? '');
        $medication = clean($_POST['medication'] ?? '');
        $mungkahi = clean($_POST['mungkahi'] ?? '');

        // Insert into database
        $stmt = $conn->prepare("INSERT INTO surveys (
            buong_pangalan, edad, kasarian, bilang_ng_pamilya, address,
            sakuna, kaalaman_panganib, gobag, emergency_contacts, evacuation_ease,
            total_members, family_head, bp, existing_illness, disability,
            disability_details, medication, mungkahi
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $stmt->bind_param("sissssssssisssssss",
            $buong_pangalan, $edad, $kasarian, $bilang_ng_pamilya, $address,
            $sakunaStr, $kaalaman_panganib, $gobag, $emergency_contacts, $evacuation_ease,
            $total_members, $family_head, $bp, $existing_illness, $disability,
            $disability_details, $medication, $mungkahi
        );

        if ($stmt->execute()) {
            $success = "Survey saved successfully! Total surveys: " . $conn->query("SELECT COUNT(*) FROM surveys")->fetch_row()[0];
        } else {
            $error = "Database error: " . $stmt->error;
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="tl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brgy 727 Disaster Preparedness Survey</title>
    <link rel="stylesheet" href="survey.css">
</head>
<body>
    <div class="container">
        <h1>Brgy 727 Disaster Preparedness Survey</h1>
        
        <?php if ($success): ?>
            <div class="alert success"><?php echo $success; ?></div>
        <?php endif; ?>
        
        <?php if ($error): ?>
            <div class="alert error"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST" action="survey.php">
            <!-- Required Fields -->
            <div class="form-group">
                <label>Buong Pangalan *</label>
                <input type="text" name="buong_pangalan" required>
            </div>

            <div class="form-group">
                <label>Edad *</label>
                <input type="number" name="edad" required>
            </div>

            <div class="form-group">
                <label>Kasarian *</label>
                <select name="kasarian" required>
                    <option value="">Pumili...</option>
                    <option value="Lalaki">Lalaki</option>
                    <option value="Babae">Babae</option>
                </select>
            </div>

            <div class="form-group">
                <label>Bilang ng Pamilya *</label>
                <input type="number" name="bilang_ng_pamilya" required>
            </div>

            <div class="form-group">
                <label>Address *</label>
                <textarea name="address" required></textarea>
            </div>

            <!-- Sakuna (Checkboxes) -->
            <div class="form-group">
                <label>Mga Sakunang Naranasan (Pumili ng lahat na naaangkop)</label>
                <div class="checkbox-group">
                    <label><input type="checkbox" name="sakuna[]" value="bagyo"> Bagyo</label>
                    <label><input type="checkbox" name="sakuna[]" value="baha"> Baha</label>
                    <label><input type="checkbox" name="sakuna[]" value="lindol"> Lindol</label>
                    <label><input type="checkbox" name="sakuna[]" value="sunog"> Sunog</label>
                    <label><input type="checkbox" name="sakuna[]" value="landslide"> Landslide</label>
                </div>
            </div>

            <!-- Yes/No Questions -->
            <div class="form-group">
                <label>May kaalaman sa mga panganib?</label>
                <select name="kaalaman_panganib">
                    <option value="">Pumili...</option>
                    <option value="oo">Oo</option>
                    <option value="hindi">Hindi</option>
                </select>
            </div>

            <div class="form-group">
                <label>May Go Bag?</label>
                <select name="gobag">
                    <option value="">Pumili...</option>
                    <option value="oo">Oo</option>
                    <option value="hindi">Hindi</option>
                </select>
            </div>

            <div class="form-group">
                <label>May Emergency Contacts?</label>
                <select name="emergency_contacts">
                    <option value="">Pumili...</option>
                    <option value="oo">Oo</option>
                    <option value="hindi">Hindi</option>
                </select>
            </div>

            <div class="form-group">
                <label>Madali makalabas sa evacuation?</label>
                <select name="evacuation_ease">
                    <option value="">Pumili...</option>
                    <option value="oo">Oo</option>
                    <option value="hindi">Hindi</option>
                </select>
            </div>

            <!-- Health Info -->
            <div class="form-group">
                <label>Total Members</label>
                <input type="number" name="total_members">
            </div>

            <div class="form-group">
                <label>Family Head</label>
                <input type="text" name="family_head">
            </div>

            <div class="form-group">
                <label>BP</label>
                <input type="text" name="bp">
            </div>

            <div class="form-group">
                <label>Existing Illness</label>
                <textarea name="existing_illness"></textarea>
            </div>

            <div class="form-group">
                <label>May Disability?</label>
                <select name="disability">
                    <option value="">Pumili...</option>
                    <option value="oo">Oo</option>
                    <option value="hindi">Hindi</option>
                </select>
            </div>

            <div class="form-group">
                <label>Disability Details</label>
                <textarea name="disability_details"></textarea>
            </div>

            <div class="form-group">
                <label>Medication</label>
                <textarea name="medication"></textarea>
            </div>

            <div class="form-group">
                <label>Mungkahi</label>
                <textarea name="mungkahi"></textarea>
            </div>

            <button type="submit" class="btn-submit">Isumite ang Survey</button>
        </form>
    </div>
</body>
</html>
