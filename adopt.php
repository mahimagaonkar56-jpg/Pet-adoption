<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1"/>
  <title>Adopt — PAWSIndia</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header class="site-header">
    <div class="container header-inner">
      <div class="brand"><div class="logo">PAWS<span>India</span></div></div>
      <nav class="main-nav"><a href="index.php">Home</a><a href="adopt.php" class="active">Adopt</a></nav>
    </div>
  </header>

  <main class="container">
    <section class="card adopt-layout">
      <div class="adopt-left">
        <h1>Adoption Form</h1>
        <p class="lead">Please fill the form carefully. After submission a professional certificate will be downloaded automatically.</p>

        <form id="adoptForm">
          <label>Your full name
            <input id="name" type="text" required>
          </label>

          <label>Email
            <input id="email" type="email" required>
          </label>

          <label>Phone
            <input id="phone" type="tel" pattern="[0-9]{10}" placeholder="10 digits" required>
          </label>

          <label>Address
            <input id="address" type="text" required>
          </label>

          <label>Choose Pet
            <select id="petSelect" required>
              <option value="">-- Select a Pet --</option>
              <option>🐶 Rio</option>
              <option>🐱 Sundari</option>
              <option>🐕 Bruno</option>
              <option>🐈 Minnie</option>
            </select>
          </label>

          <label>Household members
            <input id="household" type="number" min="1" value="1" required>
          </label>

          <label>How much time per day can you give?
            <select id="timeDaily">
              <option>Less than 1 hour</option>
              <option>1 - 2 hours</option>
              <option>2 - 4 hours</option>
              <option>4+ hours</option>
            </select>
          </label>

          <label>Why do you want to adopt? <small>(tell us about your home & care plan)</small>
            <textarea id="reason" rows="4" required></textarea>
          </label>

          <label class="checkbox"><input id="confirm" type="checkbox" required> I confirm I will provide proper care.</label>

          <div class="form-actions">
            <button class="btn" id="submitAdopt" type="submit">✅ Submit Adoption</button>
            <a class="btn ghost" href="index.php">← Back</a>
          </div>
        </form>

        <div id="adoptResult" class="result-box" aria-live="polite"></div>
      </div>

      <aside class="adopt-right">
        <div class="pet-card-preview card" id="previewPanel">
          <div class="pet-emoji big">🐾</div>
          <h3 id="previewName">Select a pet</h3>
          <p class="meta" id="previewMeta">Gender • Color • Age</p>
          <p class="desc" id="previewDesc">Pet information will appear here when you choose a pet.</p>
        </div>

        <div class="card contact-mini">
          <h4>Need help?</h4>
          <p>☎️ +91-9876543210</p>
          <p>📧 support@pawsindia.gov.in</p>
        </div>
      </aside>
    </section>
  </main>

  <footer class="site-footer">
    <div class="container footer-grid">
      <div>© <?= date("Y") ?> PAWSIndia</div>
      <div>State Govt. Animal Welfare - Official</div>
    </div>
  </footer>

  <script src="script.js"></script>
  <script>
    // prefills and preview
    (function(){
      const params = new URLSearchParams(window.location.search);
      if(params.has('pet')) {
        const v = params.get('pet');
        const sel = document.getElementById('petSelect');
        if(sel) sel.value = v;
      }
      // preview on change
      const mapping = {
        '🐶 Rio': {meta:'Male • Brown • 2 years', desc:'Playful & loyal, loves walks.'},
        '🐱 Sundari': {meta:'Female • White • 1.5 years', desc:'Calm lap-cat, great for apartments.'},
        '🐕 Bruno': {meta:'Male • Black • 3 years', desc:'Protective & affectionate.'},
        '🐈 Minnie': {meta:'Female • Grey • 1 year', desc:'Curious & gentle.'}
      };
      const sel = document.getElementById('petSelect');
      function updatePreview(){
        const val = sel.value;
        const emoji = val.split(' ')[0] || '🐾';
        document.querySelector('#previewPanel .pet-emoji').textContent = emoji;
        document.getElementById('previewName').textContent = val || 'Select a pet';
        if(mapping[val]) {
          document.getElementById('previewMeta').textContent = mapping[val].meta;
          document.getElementById('previewDesc').textContent = mapping[val].desc;
        } else {
          document.getElementById('previewMeta').textContent = 'Gender • Color • Age';
          document.getElementById('previewDesc').textContent = 'Pet information will appear here when you choose a pet.';
        }
      }
      sel.addEventListener('change', updatePreview);
      updatePreview();
    })();
  </script>
</body>
</html>
