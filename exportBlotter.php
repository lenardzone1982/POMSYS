<?php

include("../config.php");
include("XLSXLibrary.php");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require_once '../dompdf/autoload.inc.php';
use Dompdf\Dompdf;
use Dompdf\Options;

$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled', true); 
$dompdf = new Dompdf($options);


  if (isset($_GET['exportPDF']) && !empty($_GET['exportPDF'])) {

    $case_no = mysqli_real_escape_string($conn, $_GET['exportPDF']);

    $sql = "SELECT * FROM blotter WHERE case_no = '$case_no'";
    $res = mysqli_query($conn, $sql);

    if (!$res || mysqli_num_rows($res) === 0) {
        header("Location: ../Admin/norecordfound.php");
        exit;
    }

    $rows = [];
    while ($row = mysqli_fetch_assoc($res)) {
        $rows[] = $row;
    }

    ob_start();
    $row = $rows[0];

    $status = ($row['blotter_status'] == 0) ? 'Open' :
              (($row['blotter_status'] == 1) ? 'Closed' : 'Under Investigation');

    $complainant = ucwords(trim($row['c_lastname'] . ' ' . $row['c_suffix'] . ', ' . $row['c_firstname'] . ' ' . $row['c_middlename']));
    $accused = ucwords(trim($row['acc_lastname'] . ' ' . $row['acc_suffix'] . ', ' . $row['acc_firstname'] . ' ' . $row['acc_middlename']));

    ?>
    <html>
    <head>
        <style>
            body { font-family: Arial, sans-serif; font-size: 12px; line-height: 1.5; padding: 30px; }
            .title { text-align: center; font-size: 20px; font-weight: bold; margin-bottom: 30px; }
            .section-title { font-weight: bold; margin-top: 20px; font-size: 14px;}
            .field-label { font-weight: bold; display: inline-block; width: 200px; }
            .checkbox { display: inline-block; width: 14px; height: 14px; border: 1px solid #000; margin-right: 5px; vertical-align: middle; }
            .line { border-bottom: 1px solid #000; display: inline-block; width: 300px; }
            .textarea { border: 1px solid #000; min-height: 60px; padding: 5px; margin-top: 5px; }
            .checkbox {
                display: inline-block;
                width: 12px;
                height: 12px;
                border: 1px solid #000;
                margin-right: 5px;
                vertical-align: middle;
            }
            .checkbox.checked {
                background-color: black;
            }
            .line {
              border-bottom: 1px solid grey;
              width: 100%;
              margin: 10px 0;
            }
        </style>
    </head>
    <body>

    <div class="title">BLOTTER INCIDENT REPORT CASE NO: <?= htmlspecialchars($row['case_no']) ?></div>

    <p>This is to certify that an incident was officially recorded in the Barangay Calapacuan, Subic, Zambales with the following details:</p>

    <div class="section-title">Complainant</div>
    <p><span class="field-label">Name:</span> <?= htmlspecialchars($complainant) ?></p>
    <p><span class="field-label">Address:</span> <?= htmlspecialchars(ucwords($row['c_address'])) ?></p>
    <p><span class="field-label">Contact Number:</span> +63 <?= htmlspecialchars($row['c_contact']) ?></p>
    <div class="line"></div>


    <div class="section-title">Witness</div>
    <p><span class="field-label">Name:</span> <?= htmlspecialchars($row['witnesses']) ?></p>
    <p><span class="field-label">Contact:</span> +63 <?= htmlspecialchars($row['witnessesContact']) ?></p>
    <div class="line"></div>


    <div class="section-title">Suspect</div>
    <p><span class="field-label">Name (if known):</span> <?= htmlspecialchars($accused) ?></p>
    <p><span class="field-label">Address / Last Known Location:</span> <?= htmlspecialchars(ucwords($row['acc_address'])) ?></p>
    <div class="line"></div>


    <div class="section-title">Incident Information</div>
    <p><span class="field-label">Type of Incident:</span> <?= htmlspecialchars(ucwords($row['incidentNature'])) ?></p>
    <p><span class="field-label">Date and Time of Incident:</span> <?= date("F d, Y", strtotime($row['incidentDate'])) . ' ' . $row['incidentTime'] ?></p>
    <p><span class="field-label">Location:</span> <?= htmlspecialchars(ucwords($row['incidentAddress'])) ?></p>

    <p><span class="field-label">Brief Statement of the Incident:</span></p>
    <div class="textarea">
        <?= nl2br(htmlspecialchars(ucwords($row['incidentDescription']))) ?>
    </div>

    <p><strong>Action Taken:</strong></p>
    <div class="textarea">
        <?= nl2br(htmlspecialchars($row['actionTaken'])) ?>
    </div>

    </body>
    </html>
    <?php
    $html = ob_get_clean();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait'); 
    $dompdf->render();
    $dompdf->stream("Blotter_Report_" . $case_no . "_" . date("Ymd_His") . ".pdf", ["Attachment" => true]);
    exit;


  } elseif (isset($_GET['exportResident']) && !empty($_GET['exportResident'])) {
    $residentId = mysqli_real_escape_string($conn, $_GET['exportResident']);

    $sql = "SELECT * FROM residence WHERE residenceId = '$residentId'";
    $res = mysqli_query($conn, $sql);

    if (!$res || mysqli_num_rows($res) === 0) {
        header("Location: ../Admin/norecordfound.php");
        exit;
    }
    ob_start();
    $row = mysqli_fetch_assoc($res);

    $fullName = $row['lastname'] . ', ' . $row['firstname'] . ' ' . $row['middlename'] . ' ' . $row['suffix'];
    $dob = date('m/d/Y', strtotime($row['dob']));
    $age = $row['age'];
    $birthplace = $row['birthplace'];
    $gender = $row['gender'];
    $civilstatus = $row['civilstatus'];
    $citizenship = $row['citizenship'];
    $religion = $row['religion'];
    $contact = $row['contact'];
    $occupation = $row['occupation'];
    $house_no = $row['house_no'];
    $street_name = $row['street_name'];
    $purok = $row['purok'];
    $barangay = 'Calapacuan';
    $municipality = 'Subic';
    $province = 'Zambales';
    $region = 'III';
    $history = $row['familyIndicator'];

    function getBase64Image($path) {
        if (file_exists($path)) {
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);
            return 'data:image/' . $type . ';base64,' . base64_encode($data);
        }
        return '';
    }

    $imagePath = !empty($row['image']) ? getBase64Image('../images-residence/' . $row['image']) : '';
    $signaturePath = !empty($row['digital_signature']) ? getBase64Image('../images-signature/' . $row['digital_signature']) : '';
    $documentsPath = !empty($row['personalDocuments']) ? getBase64Image('../images-certificates/' . $row['personalDocuments']) : '';

    // $documentsPath = !empty($row['personalDocuments']) ? '../images-certificates/' . $row['personalDocuments'] : 'Not provided';
    $dateToday = date('jS \of F, Y');
?>

<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.5;
        }
        .header {
            text-align: center;
        }
        .image-top-right {
            position: absolute;
            top: 30px;
            right: 30px;
            width: 120px;
            height: 120px;
            border: 1px solid #000;
        }
        .content {
            margin-top: 50px;
        }
        .title {
            text-align: center;
        }
        .section-title {
            font-weight: bold;
            margin-top: 20px;
            margin-bottom: 5px;
        }
        .indent {
            margin-left: 20px;
        }
    </style>
</head>
<body>
    <!-- Image on upper right -->
    <?php if ($imagePath): ?>
        <img src="<?= $imagePath ?>" alt="Resident Image" class="image-top-right">
    <?php endif; ?>

    <div class="header">
        <p>Republic of the Philippines<br>
        Province of Zambales<br>
        Municipality of Subic<br>
        Barangay Calapacuan</p>
        
    </div>

    <div class="content">
        <h3 class="title">CERTIFICATION OF ACCUSED RECORD</h3>
        <p>This is to certify that the following individual has been recorded in the official Barangay Peace and Order Monitoring System (POMSYS) for purposes of documentation, investigation, and reference.</p>

        <div class="section-title">I. BASIC INFORMATION</div>
        <div class="indent">
            • Name: <?= $fullName ?><br>
            • Date of Birth: <?= $dob ?><br>
            • Age: <?= $age ?><br>
            • Place of Birth: <?= $birthplace ?><br>
            • Sex: <?= $gender ?><br>
            • Civil Status: <?= $civilstatus ?><br>
            • Citizenship: <?= $citizenship ?><br>
            • Religion: <?= $religion ?><br>
            • Contact Number: <?= $contact ?><br>
            • Profession/Occupation: <?= $occupation ?><br>
        </div>

        <div class="section-title">II. ACCUSED ADDRESS</div>
        <div class="indent">
            • House No.: <?= $house_no ?><br>
            • Street Name: <?= $street_name ?><br>
            • Sitio/Purok: <?= $purok ?><br>
            • Barangay: <?= $barangay ?><br>
            • Municipality: <?= $municipality ?><br>
            • Province: <?= $province ?><br>
            • Region: <?= $region ?><br>
        </div>

        <div class="section-title">III. CRIME RECORDS</div>
        <div class="indent">
            • History/Content: <?= $history ?><br><br>
            • Digital Signature:<br>
            <?php if ($signaturePath): ?>
                <img src="<?= $signaturePath ?>" alt="Signature" style="width:150px;height:auto;border:1px solid #000;">
            <?php else: ?>
                Not provided
            <?php endif; ?>
            <br><br>
            • Scanned Personal Documents:<br>
            <?php if ($documentsPath): ?>
                <img src="<?= $documentsPath ?>" alt="Documents" style="width:200px;height:auto;border:1px solid #000;">
            <?php else: ?>
                Not provided
            <?php endif; ?>
        </div>

        <br><br>
        <p>Prepared this <?= date('jS') ?> day of <?= date('F, Y') ?> at Barangay Calapacuan, Subic, Zambales.</p>

        <br><br>
        <p>Prepared by:<br>
        _________________________<br>
        Barangay Secretary</p>

        <br><br>
        <p>Certified by:<br>
        _________________________<br>
        Punong Barangay</p>
    </div>
</body>
</html>

    <?php
    $html = ob_get_clean();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    $dompdf->stream("Resident_Info_" . $residentId . "_" . date("Ymd_His") . ".pdf", ["Attachment" => true]);
    exit;

  } else {

  }


