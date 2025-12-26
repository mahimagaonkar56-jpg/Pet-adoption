<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width,initial-scale=1"/>
<title>Pet Care — PAWSIndia</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
  <header class="site-header">
    <div class="container header-inner">
      <div class="brand"><div class="logo">PAWS<span>India</span></div></div>
      <nav class="main-nav"><a href="index.php">Home</a><a href="petcare.php" class="active">Pet Care</a></nav>
    </div>
  </header>

  <main class="container">
    <section class="card">
      <h1>Pet Care Dashboard</h1>
      <p class="lead">Track vaccinations, birthdays and schedule vet appointments. Data is saved locally in your browser (no DB).</p>

      <form id="careForm" class="form-grid">
        <label>Pet (emoji + name)
          <input id="pc_pet" list="petList" placeholder="e.g. 🐶 Rio" required>
          <datalist id="petList">
            <option>🐶 Rio</option><option>🐱 Sundari</option><option>🐕 Bruno</option><option>🐈 Minnie</option>
          </datalist>
        </label>

        <label>Last Vaccination Date
          <input id="pc_vacc" type="date" required>
        </label>

        <label>Next Vaccination
          <input id="pc_next" type="date" required>
        </label>

        <label>Birthday
          <input id="pc_bday" type="date" required>
        </label>

        <label>Last Vet Name
          <input id="pc_vet" type="text" placeholder="Dr. Sharma">
        </label>

        <label>Notes (diet, meds)
          <textarea id="pc_notes" rows="2" placeholder="Feeding, meds, observations"></textarea>
        </label>

        <div class="form-actions" style="grid-column:1 / -1;">
          <button class="btn" id="savePc" type="button">💾 Save Pet Care</button>
          <button class="btn ghost" id="loadPc" type="button">📂 Load Saved</button>
        </div>
      </form>

      <div id="careOutput" class="result-box"></div>

      <hr style="margin:18px 0;">

      <section>
        <h3>Appointments</h3>
        <form id="apptForm" onsubmit="event.preventDefault(); bookAppointment();">
          <label>Your name <input id="ownerName" type="text" required></label>
          <label>Pet name <input id="ownerPet" type="text" required></label>
          <label>Date <input id="apptDate" type="date" required></label>
          <div class="form-actions"><button class="btn" type="submit">📅 Book Appointment</button></div>
        </form>
        <div id="apptResult" class="result-box"></div>
        <div id="apptList" class="result-box" style="margin-top:12px;"></div>
      </section>
    </section>
  </main>

  <footer class="site-footer"><div class="container footer-grid"><div>© <?= date("Y") ?> PAWSIndia</div></div></footer>

<script src="script.js"></script>
</body>
</html>

