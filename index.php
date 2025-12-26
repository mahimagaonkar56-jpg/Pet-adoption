<?php
// index.php - static list of pets (no external PHP data file)
$pets = [
  ['id'=>'rio','emoji'=>'🐶','name'=>'Rio','gender'=>'Male','color'=>'Brown','age'=>'2 years','desc'=>'Playful & loyal, loves walks.'],
  ['id'=>'sundari','emoji'=>'🐱','name'=>'Sundari','gender'=>'Female','color'=>'White','age'=>'1.5 years','desc'=>'Calm lap-cat, great for apartments.'],
  ['id'=>'bruno','emoji'=>'🐕','name'=>'Bruno','gender'=>'Male','color'=>'Black','age'=>'3 years','desc'=>'Protective & affectionate.'],
  ['id'=>'minnie','emoji'=>'🐈','name'=>'Minnie','gender'=>'Female','color'=>'Grey','age'=>'1 year','desc'=>'Curious & gentle.' ],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>PAWSIndia — Adopt a Friend 🐾</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header class="site-header">
    <div class="container header-inner">
      <div class="brand">
        <div class="logo">PAWS<span>India</span></div>
        <div class="tag">Government Recognized • Safe Adoptions</div>
      </div>

      <nav class="main-nav">
        <a href="index.php" class="active">Home</a>
        <a href="about.php">About</a>
        <a href="petcare.php">Pet Care</a>
        <a href="petmatch.php">Pet Match</a>
        <a href="adopt.php">Adopt</a>
        <a href="contact.php">Contact</a>
      </nav>
    </div>
  </header>

  <main class="container">
    <section class="hero card">
      <div class="hero-left">
        <h1>Find a forever friend ❤️🐾</h1>
        <p class="lead">PAWSIndia connects loving families with shelter pets. Government-recognized adoption process & official certificate.</p>
        <div class="hero-actions">
          <a class="btn" href="adopt.php">📋 Start Adoption</a>
          <a class="btn ghost" href="#available">🖤 See Available Pets</a>
        </div>
      </div>

      <div class="hero-right">
        <div class="hero-stats">
          <div><strong>15</strong><span>Shelters</span></div>
          <div><strong>4,582+</strong><span>Families Helped</span></div>
          <div><strong>Monthly</strong><span>Vaccination Drives</span></div>
        </div>
      </div>
    </section>

    <section id="available" class="card section-pets">
      <div class="section-header">
        <h2>Available Pets</h2>
        <p>Click a pet to open its adoption form (pre-filled) — emojis instead of photos 🐾</p>
      </div>

      <div class="pets-grid">
        <?php foreach($pets as $p): ?>
        <article class="pet-card" tabindex="0" role="button" aria-pressed="false">
          <div class="pet-emoji"><?= htmlspecialchars($p['emoji']) ?></div>
          <div class="pet-info">
            <h3><?= htmlspecialchars($p['name']) ?> <span class="pet-age"><?= htmlspecialchars($p['age']) ?></span></h3>
            <p class="meta"><?= htmlspecialchars($p['gender']) ?> • <?= htmlspecialchars($p['color']) ?></p>
            <p class="desc"><?= htmlspecialchars($p['desc']) ?></p>
          </div>
          <div class="pet-actions">
            <a class="btn small" href="adopt.php?pet=<?= urlencode($p['emoji'].' '.$p['name']) ?>">📋 Adopt</a>
            <button class="btn small ghost" onclick="copyAdoptLink('<?= htmlspecialchars($p['emoji'].' '.$p['name']) ?>')">🔗 Link</button>
          </div>
        </article>
        <?php endforeach; ?>
      </div>
    </section>

    <section class="card about-mini">
      <h2>Why adopt from PAWSIndia?</h2>
      <ul class="benefits">
        <li>✅ Government recognized and verified shelters</li>
        <li>🩺 Health checks & vaccinations done</li>
        <li>📄 Official adoption certificate with State Animal Welfare signature</li>
        <li>🤝 Post-adoption support & vet appointments</li>
      </ul>
    </section>
  </main>

  <footer class="site-footer">
    <div class="container footer-grid">
      <div class="footer-col">
        <h4>PAWSIndia</h4>
        <p>Connecting shelter pets with caring homes. Registered with State Animal Welfare.</p>
      </div>
      <div class="footer-col">
        <h4>Quick Links</h4>
        <a href="adopt.php">Adopt</a>
        <a href="petmatch.php">Pet Match</a>
        <a href="petcare.php">Pet Care</a>
      </div>
      <div class="footer-col">
        <h4>Contact</h4>
        <p>📧 support@pawsindia.gov.in</p>
        <p>📞 +91-9876543210</p>
        <p>🏢 Margao, Goa</p>
      </div>
      <div class="footer-col">
        <h4>Official</h4>
        <p>State Animal Welfare • Shelter Partners • Adoption Helpline</p>
      </div>
    </div>
    <div class="footer-bottom">© <?= date("Y") ?> PAWSIndia — State Govt. Animal Welfare recognized</div>
  </footer>

  <script src="script.js"></script>
</body>
</html>
