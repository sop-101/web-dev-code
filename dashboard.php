<?php
session_start();

// 🔒 LOGIN CHECK — PHP Session based (connected to login.php)
if (!isset($_SESSION['adminLoggedIn']) || $_SESSION['adminLoggedIn'] !== true) {
    header("Location: login.php");
    exit();
}

// Database connection
include 'db_connect.php';

// Handle Clear All Data (POST request)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['clear_all'])) {
    $conn->query("DELETE FROM surveys");
    header("Location: dashboard.php?cleared=1");
    exit();
}

// Handle CSV Export
if (isset($_GET['export']) && $_GET['export'] === 'csv') {
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="brgy727-surveys-' . date('Y-m-d') . '.csv"');

    $output = fopen('php://output', 'w');
    fprintf($output, chr(0xEF) . chr(0xBB) . chr(0xBF)); // BOM for UTF-8

    $headers = [
        "Date", "Name", "Age", "Gender", "Family", "Address", "Sakuna",
        "Kaalaman", "Go Bag", "Emergency Contacts", "Evacuation",
        "Total Members", "Family Head", "BP", "Existing Illness",
        "Disability", "Disability Details", "Medication",
        "Risk Score", "Risk Level", "Mungkahi"
    ];
    fputcsv($output, $headers);

    $result = $conn->query("SELECT * FROM surveys ORDER BY id DESC");
    while ($row = $result->fetch_assoc()) {
        $score = calculateRisk($row);
        $level = getRiskLevel($score);
        fputcsv($output, [
            $row['timestamp'],
            $row['buong_pangalan'],
            $row['edad'],
            $row['kasarian'],
            $row['bilang_ng_pamilya'],
            $row['address'],
            $row['sakuna'],
            $row['kaalaman_panganib'],
            $row['gobag'],
            $row['emergency_contacts'],
            $row['evacuation_ease'],
            $row['total_members'],
            $row['family_head'],
            $row['bp'],
            $row['existing_illness'],
            $row['disability'],
            $row['disability_details'],
            $row['medication'],
            $score,
            $level['label'],
            $row['mungkahi']
        ]);
    }
    fclose($output);
    exit();
}

// Fetch all surveys from database
$sql = "SELECT * FROM surveys ORDER BY id DESC";
$result = $conn->query($sql);
$data = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

// Calculate risk score for a respondent (0-100)
function calculateRisk($item) {
    $score = 0;
    $age = intval($item['edad'] ?? 0);
    $familyCount = intval($item['bilang_ng_pamilya'] ?? 0);

    if ($age >= 65) $score += 25;
    else if ($age >= 60) $score += 20;
    else if ($age <= 5) $score += 20;
    else if ($age <= 12) $score += 10;

    if ($familyCount >= 8) $score += 15;
    else if ($familyCount >= 5) $score += 10;
    else if ($familyCount >= 3) $score += 5;

    if (($item['gobag'] ?? '') !== 'oo') $score += 20;
    if (($item['emergency_contacts'] ?? '') !== 'oo') $score += 15;
    if (($item['evacuation_ease'] ?? '') !== 'oo') $score += 25;
    if (($item['kaalaman_panganib'] ?? '') !== 'oo') $score += 10;

    if (!empty($item['existing_illness']) && trim($item['existing_illness']) !== '') $score += 15;
    if (($item['disability'] ?? '') === 'oo') $score += 20;
    if (!empty($item['bp']) && trim($item['bp']) !== '') $score += 5;

    $sakuna = [];
    if (!empty($item['sakuna'])) {
        $sakuna = array_filter(explode(';', $item['sakuna']));
    }
    $sakunaCount = count($sakuna);
    if ($sakunaCount >= 3) $score += 10;
    else if ($sakunaCount >= 2) $score += 5;

    return min($score, 100);
}

// Get risk level label and class
function getRiskLevel($score) {
    if ($score >= 70) {
        return ['label' => 'High', 'class' => 'risk-high', 'barClass' => 'risk-bar-high'];
    }
    if ($score >= 40) {
        return ['label' => 'Medium', 'class' => 'risk-medium', 'barClass' => 'risk-bar-medium'];
    }
    return ['label' => 'Low', 'class' => 'risk-low', 'barClass' => 'risk-bar-low'];
}

// Calculate stats
$total = count($data);
$ages = array_filter(array_map(function($d) { return intval($d['edad'] ?? 0); }, $data), function($a) { return $a > 0; });
$avgAge = count($ages) > 0 ? round(array_sum($ages) / count($ages)) : 0;

$withBag = count(array_filter($data, function($d) { return ($d['gobag'] ?? '') === 'oo'; }));
$bagPct = $total > 0 ? round(($withBag / $total) * 100) : 0;

$knows = count(array_filter($data, function($d) { return ($d['kaalaman_panganib'] ?? '') === 'oo'; }));
$knowsPct = $total > 0 ? round(($knows / $total) * 100) : 0;

$withContacts = count(array_filter($data, function($d) { return ($d['emergency_contacts'] ?? '') === 'oo'; }));
$contactsPct = $total > 0 ? round(($withContacts / $total) * 100) : 0;

$canEvac = count(array_filter($data, function($d) { return ($d['evacuation_ease'] ?? '') === 'oo'; }));
$evacPct = $total > 0 ? round(($canEvac / $total) * 100) : 0;

// Helper functions for rendering
function renderSakuna($sakunaStr) {
    if (empty($sakunaStr)) return "-";
    $sakuna = array_filter(explode(';', $sakunaStr));
    if (empty($sakuna)) return "-";
    $out = "";
    foreach ($sakuna as $s) {
        $out .= '<span class="tag tag-' . htmlspecialchars($s) . '">' . htmlspecialchars($s) . '</span>';
    }
    return $out;
}

function renderStatus($value) {
    if (empty($value)) return "-";
    return $value === 'oo' 
        ? '<span class="status-yes">✓ Oo</span>' 
        : '<span class="status-no">✗ Hindi</span>';
}

function renderHealth($item) {
    $parts = [];
    if (!empty($item['total_members'])) $parts[] = $item['total_members'] . " members";
    if (!empty($item['family_head'])) $parts[] = "Head: " . $item['family_head'];
    if (!empty($item['bp'])) $parts[] = "BP: " . $item['bp'];
    if (!empty($item['existing_illness'])) $parts[] = "Illness: " . $item['existing_illness'];
    if (($item['disability'] ?? '') === 'oo') $parts[] = "Disability: " . ($item['disability_details'] ?: "Yes");
    if (!empty($item['medication'])) $parts[] = "Meds: " . $item['medication'];
    return count($parts) > 0 ? implode("<br>", $parts) : "-";
}

function renderRisk($item) {
    $score = calculateRisk($item);
    $level = getRiskLevel($score);
    return '
        <div style="min-width: 120px;">
            <span class="risk-badge ' . $level['class'] . '">' . $level['label'] . '</span>
            <div class="risk-bar-container">
                <div class="risk-bar ' . $level['barClass'] . '" style="width: ' . $score . '%;"></div>
            </div>
            <div class="risk-score-text">Score: ' . $score . '/100</div>
        </div>
    ';
}

function formatDate($timestamp) {
    if (empty($timestamp)) return "-";
    try {
        return date("M j, Y g:i A", strtotime($timestamp));
    } catch (Exception $e) {
        return "-";
    }
}

// Sort data by risk score descending
usort($data, function($a, $b) {
    $riskA = calculateRisk($a);
    $riskB = calculateRisk($b);
    return $riskB - $riskA;
});
?>
<!DOCTYPE html>
<html lang="tl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard - Brgy 727</title>
    <link rel="stylesheet" href="dashboard.css" />
    <base target="_blank" />
</head>

<body>
    <!-- HEADER -->
    <div class="header">
        <h1>Brgy 727 Survey Dashboard</h1>
        <div class="header-actions">
            <a href="homepage.php" class="btn home-btn">Back to Homepage</a>
            <button class="btn logout-btn" onclick="logout()">Logout</button>
        </div>
    </div>

    <!-- STATS -->
    <div class="stats-container">
        <div class="stat-card">
            <div class="stat-number"><?php echo $total; ?></div>
            <div class="stat-label">Total Surveys</div>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?php echo $avgAge; ?></div>
            <div class="stat-label">Average Age</div>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?php echo $bagPct; ?>%</div>
            <div class="stat-label">May Go Bag</div>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?php echo $knowsPct; ?>%</div>
            <div class="stat-label">Alam ang Panganib</div>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?php echo $contactsPct; ?>%</div>
            <div class="stat-label">May Emergency Contacts</div>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?php echo $evacPct; ?>%</div>
            <div class="stat-label">Madali Makalabas</div>
        </div>
    </div>

    <!-- TABLE -->
    <div class="table-section">
        <div class="section-header">
            <h3 class="section-title">Survey Records</h3>
            <a href="?export=csv" class="btn export-btn">Export CSV</a>
        </div>

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Name</th>
                        <th>Age</th>
                        <th>Gender</th>
                        <th>Family</th>
                        <th>Address</th>
                        <th>Sakuna</th>
                        <th>Kaalaman</th>
                        <th>Go Bag</th>
                        <th>Emergency Contacts</th>
                        <th>Evacuation</th>
                        <th>Health Records</th>
                        <th>Risk Level</th>
                        <th>Mungkahi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($data)): ?>
                        <tr>
                            <td colspan="14">
                                <div class="empty-state">
                                    <div class="empty-state-icon">📭</div>
                                    <div class="empty-state-text">Walang survey data na available.</div>
                                </div>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($data as $item): ?>
                            <tr>
                                <td><?php echo formatDate($item['timestamp']); ?></td>
                                <td><strong><?php echo htmlspecialchars($item['buong_pangalan'] ?? '-'); ?></strong></td>
                                <td><?php echo htmlspecialchars($item['edad'] ?? '-'); ?></td>
                                <td><?php echo htmlspecialchars($item['kasarian'] ?? '-'); ?></td>
                                <td><?php echo htmlspecialchars($item['bilang_ng_pamilya'] ?? '-'); ?></td>
                                <td><?php echo htmlspecialchars($item['address'] ?? '-'); ?></td>
                                <td><?php echo renderSakuna($item['sakuna'] ?? ''); ?></td>
                                <td><?php echo renderStatus($item['kaalaman_panganib'] ?? ''); ?></td>
                                <td><?php echo renderStatus($item['gobag'] ?? ''); ?></td>
                                <td><?php echo renderStatus($item['emergency_contacts'] ?? ''); ?></td>
                                <td><?php echo renderStatus($item['evacuation_ease'] ?? ''); ?></td>
                                <td><?php echo renderHealth($item); ?></td>
                                <td><?php echo renderRisk($item); ?></td>
                                <td><?php echo !empty($item['mungkahi']) ? htmlspecialchars(substr($item['mungkahi'], 0, 50)) . '...' : '-'; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- CLEAR DATA SECTION -->
    <div class="clear-section">
        <button class="btn clear-btn" onclick="showClearModal()">
            Clear All Data
        </button>
    </div>

    <!-- CONFIRMATION MODAL -->
    <div class="modal-overlay" id="clearModal">
        <div class="modal-box">
            <div class="modal-icon"></div>
            <div class="modal-title">Clear All Data?</div>
            <div class="modal-text">
                This will permanently delete all
                <strong><?php echo $total; ?></strong> survey records from the database.
                This action cannot be undone.
            </div>
            <div class="modal-actions">
                <button class="modal-btn modal-btn-cancel" onclick="hideClearModal()">
                    Cancel
                </button>
                <form method="POST" style="display: inline;">
                    <input type="hidden" name="clear_all" value="1">
                    <button type="submit" class="modal-btn modal-btn-confirm">
                        Yes, Delete All
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- TOAST NOTIFICATION -->
    <div class="toast" id="toast">
        <span>✅</span>
        <span id="toastMessage">All data has been cleared successfully!</span>
    </div>

    <div class="footer">Brgy 727 Disaster Preparedness Survey System</div>

    <script>
        <?php if (isset($_GET['cleared'])): ?>
            showToast("All data has been cleared successfully!");
        <?php endif; ?>

        function showClearModal() {
            document.getElementById("clearModal").classList.add("active");
        }

        function hideClearModal() {
            document.getElementById("clearModal").classList.remove("active");
        }

        function showToast(message) {
            const toast = document.getElementById("toast");
            document.getElementById("toastMessage").textContent = message;
            toast.classList.add("active");
            setTimeout(() => {
                toast.classList.remove("active");
            }, 3000);
        }

        // Close modal when clicking outside
        document.getElementById("clearModal").addEventListener("click", function(e) {
            if (e.target === this) {
                hideClearModal();
            }
        });

        // LOGOUT — connected to login.php session
        function logout() {
            window.location.href = "logout.php";
        }
    </script>
</body>
</html>
