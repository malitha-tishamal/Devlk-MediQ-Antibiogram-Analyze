<?php
session_start();
date_default_timezone_set('Asia/Colombo');
require_once '../includes/db-conn.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../index.php");
    exit();
}

$user_id = $_SESSION['admin_id'];
$stmt = $conn->prepare("SELECT name, email, nic, mobile, profile_picture FROM admins WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();

// Get filters
$startMonth = $_POST['start_month'] ?? date('m');
$startYear = $_POST['start_year'] ?? date('Y');
$endMonth = $_POST['end_month'] ?? date('m');
$endYear = $_POST['end_year'] ?? date('Y');
$selectedAntibiotic = $_POST['antibiotic_name'] ?? '';

$startDate = date('Y-m-01', strtotime("$startYear-$startMonth-01"));
$endDate = date('Y-m-t', strtotime("$endYear-$endMonth-01"));

// Fetch antibiotic list
$antibioticList = [];
$antibioticRes = $conn->query("SELECT DISTINCT antibiotic_name FROM releases ORDER BY antibiotic_name ASC");
while ($a = $antibioticRes->fetch_assoc()) {
    $antibioticList[] = $a['antibiotic_name'];
}

/** Chart 1: Antibiotic-wise by Ward **/
$antibioticData = [];
$wards1 = [];
$hasChart1Data = false;

$query1 = "
    SELECT ward_name, antibiotic_name, dosage, SUM(item_count) AS usage_count
    FROM releases
    WHERE release_time BETWEEN ? AND ?
";
$params1 = [$startDate, $endDate];
$types1 = "ss";

if (!empty($selectedAntibiotic)) {
    $query1 .= " AND antibiotic_name = ?";
    $params1[] = $selectedAntibiotic;
    $types1 .= "s";
}

$query1 .= " GROUP BY ward_name, antibiotic_name, dosage ORDER BY ward_name";

$stmt = $conn->prepare($query1);
$stmt->bind_param($types1, ...$params1);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $hasChart1Data = true;
    $antibiotic = $row['antibiotic_name'];
    $ward = $row['ward_name'];
    $dosage = strtolower($row['dosage']);
    $count = $row['usage_count'];

    if (!in_array($ward, $wards1)) $wards1[] = $ward;

    $units = 0;
    if (preg_match('/(\d+)\s*mg/', $dosage, $matches)) {
        $units = ($matches[1] / 1000) * $count;
    } elseif (preg_match('/(\d+)\s*g/', $dosage, $matches)) {
        $units = $matches[1] * $count;
    }

    $antibioticData[$ward] = ($antibioticData[$ward] ?? 0) + $units;
}
sort($wards1);
$stmt->close();

/** Chart 2: Category-wise by Ward (unchanged) **/
$categoryColors = ['Access' => '#28a745', 'Watch' => '#0000ff', 'Reserve' => '#dc3545'];
$categories = [];
$dataMap = [];
$wards2 = [];
$hasChart2Data = false;

$catResult = $conn->query("SELECT DISTINCT category FROM releases WHERE category IS NOT NULL AND category != ''");
while ($catRow = $catResult->fetch_assoc()) {
    $categories[] = $catRow['category'];
}
sort($categories);
$colorList = array_map(fn($c) => $categoryColors[$c] ?? '#888', $categories);

$query2 = "
    SELECT ward_name, category, dosage, SUM(item_count) AS usage_count
    FROM releases
    WHERE release_time BETWEEN ? AND ?
    GROUP BY ward_name, category, dosage ORDER BY ward_name, category
";

$stmt = $conn->prepare($query2);
$stmt->bind_param("ss", $startDate, $endDate);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $hasChart2Data = true;
    $ward = $row['ward_name'];
    $category = $row['category'];
    $dosage = strtolower($row['dosage']);
    $count = $row['usage_count'];

    if (!in_array($ward, $wards2)) $wards2[] = $ward;

    $units = 0;
    if (preg_match('/(\d+)\s*mg/', $dosage, $matches)) {
        $units = ($matches[1] / 1000) * $count;
    } elseif (preg_match('/(\d+)\s*g/', $dosage, $matches)) {
        $units = $matches[1] * $count;
    }

    $dataMap[$ward][$category] = ($dataMap[$ward][$category] ?? 0) + $units;
}
sort($wards2);
$stmt->close();

$chart1Width = max(1200, count($wards1) * 100);
$chart2Width = max(1200, count($wards2) * 100);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Antibiotic Usage Dashboard</title>
    <?php include_once("../includes/css-links-inc.php"); ?>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script>
    google.charts.load("current", {packages: ['corechart']});
    google.charts.setOnLoadCallback(drawCharts);

    function drawCharts() {
        drawChart1();
        drawChart2();
    }

    function drawChart1() {
        var data = google.visualization.arrayToDataTable([
            ['Ward', '<?= addslashes($selectedAntibiotic ?: 'Usage') ?>'],
            <?php foreach ($wards1 as $ward): ?>
                ['<?= addslashes($ward) ?>', <?= round($antibioticData[$ward] ?? 0, 2) ?>],
            <?php endforeach; ?>
        ]);

        var options = {
            title: 'Usage by Ward (Antibiotic) - <?= "$startYear-$startMonth to $endYear-$endMonth" ?><?= $selectedAntibiotic ? " | Antibiotic: $selectedAntibiotic" : "" ?>',
            hAxis: { title: 'Ward' },
            vAxis: { title: 'Units (g)' },
            legend: { position: 'none' },
            height: 500
        };

        new google.visualization.ColumnChart(document.getElementById('chart1')).draw(data, options);
    }

    function drawChart2() {
        var data = google.visualization.arrayToDataTable([
            ['Ward', <?php foreach ($categories as $cat) echo "'".addslashes($cat)."',"; ?>],
            <?php foreach ($wards2 as $ward): ?>
                ['<?= addslashes($ward) ?>',
                    <?php foreach ($categories as $cat): ?>
                        <?= isset($dataMap[$ward][$cat]) ? round($dataMap[$ward][$cat], 2) : 0 ?>,
                    <?php endforeach; ?>
                ],
            <?php endforeach; ?>
        ]);

        var options = {
            title: 'Usage by Ward (Categories) - <?= "$startYear-$startMonth to $endYear-$endMonth" ?>',
            hAxis: { title: 'Ward' },
            vAxis: { title: 'Units (g)' },
            isStacked: true,
            legend: { position: 'top' },
            height: 500,
            bar: { groupWidth: '10%' },
            colors: <?= json_encode($colorList) ?>
        };

        new google.visualization.ColumnChart(document.getElementById('chart2')).draw(data, options);
    }
    </script>
    <style>
        #chart1.chart-container { width: <?= $chart1Width ?>px; margin: 10px auto; }
        #chart2.chart-container { width: <?= $chart2Width ?>px; margin: 10px auto; }
    </style>
</head>
<body>
<?php include_once("../includes/header.php"); ?>
<?php include_once("../includes/sadmin-sidebar.php"); ?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Antibiotic Usage Dashboard</h1>
    </div>

    <section class="section">
        <form method="POST" class="row g-3 mb-4">
            <div class="col-md-3">
                <label for="antibiotic_name" class="form-label">Antibiotic</label>
                <select name="antibiotic_name" id="antibiotic_name" class="form-select">
                    <option value="">-- All Antibiotics --</option>
                    <?php foreach ($antibioticList as $a): 
                        $sel = ($a == $selectedAntibiotic) ? 'selected' : '';
                    ?>
                        <option value="<?= htmlspecialchars($a) ?>" <?= $sel ?>><?= htmlspecialchars($a) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-3">
                <label for="start_year" class="form-label">Start Year</label>
                <select name="start_year" id="start_year" class="form-select">
                    <?php for ($y = 2020; $y <= date('Y'); $y++): ?>
                        <option value="<?= $y ?>" <?= $startYear == $y ? 'selected' : '' ?>><?= $y ?></option>
                    <?php endfor; ?>
                </select>
            </div>
            <div class="col-md-3">
                <label for="start_month" class="form-label">Start Month</label>
                <select name="start_month" id="start_month" class="form-select">
                    <?php for ($m = 1; $m <= 12; $m++): $val = str_pad($m, 2, '0', STR_PAD_LEFT); ?>
                        <option value="<?= $val ?>" <?= $startMonth == $val ? 'selected' : '' ?>>
                            <?= date('F', mktime(0, 0, 0, $m, 1)) ?>
                        </option>
                    <?php endfor; ?>
                </select>
            </div>
            <div class="col-md-3">
                <label for="end_year" class="form-label">End Year</label>
                <select name="end_year" id="end_year" class="form-select">
                    <?php for ($y = 2020; $y <= date('Y'); $y++): ?>
                        <option value="<?= $y ?>" <?= $endYear == $y ? 'selected' : '' ?>><?= $y ?></option>
                    <?php endfor; ?>
                </select>
            </div>
            <div class="col-md-3">
                <label for="end_month" class="form-label">End Month</label>
                <select name="end_month" id="end_month" class="form-select">
                    <?php for ($m = 1; $m <= 12; $m++): $val = str_pad($m, 2, '0', STR_PAD_LEFT); ?>
                        <option value="<?= $val ?>" <?= $endMonth == $val ? 'selected' : '' ?>>
                            <?= date('F', mktime(0, 0, 0, $m, 1)) ?>
                        </option>
                    <?php endfor; ?>
                </select>
            </div>

            <div class="col-12 d-flex">
                <button type="submit" class="btn btn-primary px-4">Filter</button>
                &nbsp;&nbsp;&nbsp;
                <button onclick="window.print()" type="button" class="btn btn-danger">Print</button>
            </div>
        </form>

        <div style="overflow-x: auto;">
            <h5 class="card-title text-center">Chart 1: Antibiotic Usage by Ward</h5>
            <div id="chart1" class="chart-container"></div>
        </div>

        <!--div style="overflow-x: auto;">
            <div class="card-body">
                <h5 class="card-title text-center">Chart 2: Usage by Ward (Stacked Categories)</h5>
                <div id="chart2" class="chart-container"></div>
            </div>
        </div-->
    </section>
</main>

<?php include_once("../includes/js-links-inc.php"); ?>
<?php include_once("../includes/footer.php"); ?>
</body>
</html>
