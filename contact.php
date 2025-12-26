<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width,initial-scale=1"/>
<title>Contact — PAWSIndia</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<header class="site-header">
  <div class="container header-inner">
    <div class="brand"><div class="logo">PAWS<span>India</span></div></div>
    <nav class="main-nav"><a href="index.php">Home</a><a href="contact.php" class="active">Contact</a></nav>
  </div>
</header>

<main class="container">
  <section class="card">
    <h1>Contact & Helpline</h1>
    <p class="lead">All channels below are for adoption support, shelter coordination, and emergencies.</p>

    <div class="contact-grid">
      <div class="contact-card">
        <h3>General</h3>
        <p>📧 support@pawsindia.gov.in</p>
        <p>☎️ +91-98765-43210</p>
      </div>

      <div class="contact-card">
        <h3>Adoption Helpline</h3>
        <p>📧 adopt@pawsindia.gov.in</p>
        <p>☎️ +91-80000-11111</p>
      </div>

      <div class="contact-card">
        <h3>Emergency / Vet</h3>
        <p>📧 vetsupport@pawsindia.gov.in</p>
        <p>☎️ +91-80000-22222</p>
      </div>
    </div>

    <hr style="margin:18px 0;">

    <h3>Send us a message</h3>
    <form id="contactForm">
      <label>Your name <input id="cname" type="text" required></label>
      <label>Email <input id="cemail" type="email" required></label>
      <label>Message <textarea id="cmsg" rows="4" required></textarea></label>
      <div class="form-actions"><button class="btn" id="sendContact" type="button">✉️ Send</button></div>
    </form>
    <div id="contactResult" class="result-box" style="margin-top:12px;"></div>
  </section>
</main>

<footer class="site-footer"><div class="container footer-grid"><div>© <?= date("Y") ?> PAWSIndia</div></div></footer>

<script src="script.js"></script>
</body>
</html>
