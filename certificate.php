<?php
$name = isset($_GET['name']) ? trim($_GET['name']) : 'Adopter Name';
$pet  = isset($_GET['pet']) ? trim($_GET['pet']) : 'Pet';
$date = date("d M Y");
function e($s){ return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width,initial-scale=1"/>
<title>Adoption Certificate — <?= e($name) ?></title>
<link rel="stylesheet" href="style.css">
</head>
<body class="certificate">
  <div class="certificate-print">
    <div style="display:flex; justify-content:space-between; align-items:center;">
      <div>
        <h1>PAWSIndia</h1>
        <div style="color:#666;">Government Authorized Adoption Certificate</div>
      </div>
      <div class="seal">PAWS</div>
    </div>

    <div style="text-align:center; margin-top:18px;">
      <p style="margin:6px 0;">This is to certify that</p>
      <h2><?= e($name) ?></h2>
      <p style="margin:6px 0;">has lovingly adopted</p>
      <h2><?= e($pet) ?></h2>
      <p style="margin-top:12px; color:#444;">and provided a forever home. We appreciate this adopter's commitment to animal welfare.</p>
      <p style="margin-top:10px; color:#666;">Date of adoption: <strong><?= e($date) ?></strong></p>
    </div>

    <div class="signature">
      <div class="sig-wrap">
        <div class="sig-line">Authorized Signatory</div>
      </div>
      <div class="sig-wrap">
        <div class="sig-line">State Govt. Animal Welfare</div>
      </div>
    </div>

    <div style="margin-top:20px; text-align:center;">
      <button class="btn no-print" onclick="window.print()">📄 Print / Save as PDF</button>
      <a class="btn ghost no-print" href="index.php">← Back to Home</a>
    </div>
  </div>
</body>
</html>
