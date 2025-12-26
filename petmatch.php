<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width,initial-scale=1"/>
<title>Pet Match — PAWSIndia</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<header class="site-header">
  <div class="container header-inner">
    <div class="brand"><div class="logo">PAWS<span>India</span></div></div>
    <nav class="main-nav"><a href="index.php">Home</a><a href="petmatch.php" class="active">Pet Match</a></nav>
  </div>
</header>

<main class="container">
  <section class="card">
    <h1>Find Your Match</h1>
    <p class="lead">Tell us about your lifestyle and home — we suggest suitable pets from our shelter list.</p>

    <form id="matchForm">
      <label>Type of House
        <select id="m_home"><option>Apartment</option><option>Independent House</option><option>Farmhouse</option></select>
      </label>

      <label>House Size (sq.ft)
        <select id="m_size"><option>Under 500</option><option>500-1000</option><option>1000-2000</option><option>2000+</option></select>
      </label>

      <label>Experience with pets
        <select id="m_exp"><option>Beginner</option><option>Intermediate</option><option>Expert</option></select>
      </label>

      <label>How many hours/day you can give to pet
        <select id="m_time"><option>Less than 1 hour</option><option>1-2 hours</option><option>2-4 hours</option><option>4+ hours</option></select>
      </label>

      <label>Why do you want to adopt?
        <textarea id="m_reason" rows="3" required></textarea>
      </label>

      <div class="form-actions">
        <button class="btn" id="getMatch" type="button">🔎 Get Match</button>
        <button class="btn ghost" id="loadMatches" type="button">📂 View Saved Matches</button>
      </div>
    </form>

    <div id="matchResult" class="result-box" style="margin-top:12px;"></div>
    <div id="savedMatches" class="result-box" style="margin-top:12px;"></div>
  </section>
</main>

<footer class="site-footer"><div class="container footer-grid"><div>© <?= date("Y") ?> PAWSIndia</div></div></footer>

<script src="script.js"></script>
</body>
</html>

      