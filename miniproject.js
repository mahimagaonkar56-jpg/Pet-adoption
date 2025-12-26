/* script.js - All interactions, persistence, certificate image generation */

/* ---------------- Utilities ---------------- */
function copyAdoptLink(pet){
  const base = window.location.origin + window.location.pathname.replace(/\/[^/]*$/, '/');
  const url = `${base}adopt.php?pet=${encodeURIComponent(pet)}`;
  if(navigator.clipboard) navigator.clipboard.writeText(url).then(()=>alert('Link copied to clipboard!'));
  else alert('Copy this link: ' + url);
}

/* ---------------- Adoption form and automatic certificate PNG ---------------- */
document.addEventListener('DOMContentLoaded', ()=>{
  const adoptForm = document.getElementById('adoptForm');
  if(adoptForm){
    adoptForm.addEventListener('submit', function(e){
      e.preventDefault();
      handleAdoptionSubmit();
    });
  }

  // Pet preview on adopt page done inline in adopt.php; other pages:
  const sendContact = document.getElementById('sendContact');
  if(sendContact) sendContact.addEventListener('click', handleContactSend);

  const savePc = document.getElementById('savePc');
  if(savePc) savePc.addEventListener('click', savePetCare);

  const loadPc = document.getElementById('loadPc');
  if(loadPc) loadPc.addEventListener('click', loadAllPetCare);

  const getMatch = document.getElementById('getMatch');
  if(getMatch) getMatch.addEventListener('click', function(){ saveMatch(); });

  const loadMatchesBtn = document.getElementById('loadMatches');
  if(loadMatchesBtn) loadMatchesBtn.addEventListener('click', loadMatches);

  // prefill pet if ?pet=...
  const params = new URLSearchParams(window.location.search);
  if(params.has('pet')){
    const sel = document.getElementById('petSelect');
    if(sel) sel.value = params.get('pet');
    const pc = document.getElementById('pc_pet');
    if(pc) pc.value = params.get('pet');
  }
});

/* Adoption submission handling */
function handleAdoptionSubmit(){
  const name = document.getElementById('name').value.trim();
  const email = document.getElementById('email').value.trim();
  const phone = document.getElementById('phone').value.trim();
  const address = document.getElementById('address').value.trim();
  const pet = document.getElementById('petSelect').value;
  const household = document.getElementById('household').value;
  const timeDaily = document.getElementById('timeDaily').value;
  const reason = document.getElementById('reason').value.trim();
  const confirmed = document.getElementById('confirm').checked;

  if(!name || !email || !phone || !address || !pet || !reason || !confirmed){
    alert('Please complete the form and confirm.');
    return;
  }

  // save adoption locally
  const adoptions = JSON.parse(localStorage.getItem('adoptions')||'[]');
  adoptions.push({ id: Date.now(), name, email, phone, address, pet, household, timeDaily, reason });
  localStorage.setItem('adoptions', JSON.stringify(adoptions));

  document.getElementById('adoptResult').innerHTML = `🎉 Thank you <strong>${name}</strong>! Your adoption for <strong>${pet}</strong> is recorded. Certificate will download automatically.`;

  // generate certificate image and download automatically
  generateCertificatePNG({ name, pet, date: new Date().toLocaleDateString() });
}

/* Generate certificate as PNG (drawn on canvas) and trigger download */
function generateCertificatePNG({ name, pet, date }){
  // canvas size (A4-like at 300dpi would be big — we'll use 2480x3508 for good print quality)
  const width = 2480, height = 3508;
  const c = document.createElement('canvas');
  c.width = width; c.height = height;
  const ctx = c.getContext('2d');

  // background
  ctx.fillStyle = '#fffef5';
  ctx.fillRect(0,0,width,height);

  // decorative gold border
  ctx.strokeStyle = '#d4af37';
  ctx.lineWidth = 28;
  ctx.strokeRect(60,60,width-120,height-120);

  // inner thin line
  ctx.strokeStyle = '#f0e7c2';
  ctx.lineWidth = 6;
  ctx.strokeRect(110,110,width-220,height-220);

  // header: PAWSIndia and title
  ctx.fillStyle = '#1b5966';
  ctx.font = 'bold 96px Poppins, sans-serif';
  ctx.textAlign = 'left';
  ctx.fillText('PAWSIndia', 180, 300);

  ctx.fillStyle = '#444';
  ctx.font = '600 44px Poppins, sans-serif';
  ctx.fillText('Government Authorized Adoption Certificate', 180, 360);

  // seal circle (drawn)
  const sealX = width - 240;
  ctx.beginPath();
  ctx.fillStyle = '#fff';
  ctx.arc(sealX, 220, 92, 0, Math.PI*2);
  ctx.fill();
  ctx.lineWidth = 12;
  ctx.strokeStyle = '#d4af37';
  ctx.stroke();
  ctx.fillStyle = '#1b5966';
  ctx.font = 'bold 42px Poppins, sans-serif';
  ctx.textAlign = 'center';
  ctx.fillText('PAWS', sealX, 230);

  // certificate body text
  ctx.textAlign = 'center';
  ctx.fillStyle = '#333';
  ctx.font = '600 48px Poppins, sans-serif';
  ctx.fillText('This is to certify that', width/2, 720);

  ctx.font = 'bold 84px Poppins, sans-serif';
  ctx.fillStyle = '#0d3b3f';
  ctx.fillText(name, width/2, 840);

  ctx.font = '600 48px Poppins, sans-serif';
  ctx.fillStyle = '#333';
  ctx.fillText('has officially adopted', width/2, 940);

  ctx.font = 'bold 72px Poppins, sans-serif';
  ctx.fillStyle = '#0d3b3f';
  ctx.fillText(pet, width/2, 1040);

  // paragraph
  const para = "PAWSIndia recognizes and thanks the adopter for providing a loving and safe home. This adoption is recorded under the guidelines of the State Animal Welfare Authority, ensuring medical checks, sterilization and responsible ownership.";
  wrapText(ctx, para, width/2, 1180, width - 520, 36);

  // date
  ctx.font = '500 36px Poppins, sans-serif';
  ctx.fillStyle = '#444';
  ctx.fillText('Date of adoption: ' + date, width/2, 1460);

  // signatures: create placeholder signature SVG image and draw it
  const sigSvg = `
  <svg xmlns='http://www.w3.org/2000/svg' width='520' height='160'>
    <rect width='100%' height='100%' fill='none'/>
    <text x='10' y='60' font-family='Brush Script MT, cursive' font-size='48' fill='#222'>Dr. S. K. Menon</text>
    <text x='10' y='110' font-family='Poppins, sans-serif' font-size='18' fill='#222'>Director, State Animal Welfare</text>
  </svg>`;
  const sigImg = new Image();
  sigImg.onload = function(){
    // left signature
    ctx.drawImage(sigImg, 360, 1580, 520, 160);
    // right signature (authority)
    ctx.drawImage(sigImg, width - 360 - 520, 1580, 520, 160);

    // signature labels
    ctx.font = '600 24px Poppins, sans-serif';
    ctx.fillStyle = '#222';
    ctx.textAlign = 'center';
    ctx.fillText('Authorized Signatory', 360 + 260, 1800);
    ctx.fillText('State Animal Welfare Authority', width - 360 - 260, 1800);

    // footer small text
    ctx.font = '400 28px Poppins, sans-serif';
    ctx.fillStyle = '#666';
    ctx.textAlign = 'center';
    ctx.fillText('PAWSIndia — Registered Shelter Network • www.pawsindia.gov.in', width/2, height - 140);

    // convert to blob and download
    c.toBlob(function(blob){
      const a = document.createElement('a');
      const safeName = name.replace(/[^a-z0-9_\- ]/gi,'_');
      a.download = `Adoption_Certificate_${safeName}.png`;
      a.href = URL.createObjectURL(blob);
      document.body.appendChild(a);
      a.click();
      a.remove();
      URL.revokeObjectURL(a.href);
      // show link in UI
      const out = document.getElementById('adoptResult');
      if(out) out.innerHTML += `<div style="margin-top:10px;">✅ Certificate downloaded. You can print/save it. <a href="certificate.php?name=${encodeURIComponent(name)}&pet=${encodeURIComponent(pet)}" target="_blank" class="btn small">Open Printable Certificate</a></div>`;
    }, 'image/png', 1.0);
  };
  sigImg.onerror = function(){
    // fallback: still proceed without signature image
    ctx.font = '600 24px Poppins, sans-serif';
    ctx.fillStyle = '#222';
    ctx.textAlign = 'center';
    ctx.fillText('Authorized Signatory', width/2 - 460, 1800);
    ctx.fillText('State Animal Welfare Authority', width/2 + 460, 1800);
    c.toBlob(function(blob){
      const a = document.createElement('a');
      const safeName = name.replace(/[^a-z0-9_\- ]/gi,'_');
      a.download = `Adoption_Certificate_${safeName}.png`;
      a.href = URL.createObjectURL(blob);
      document.body.appendChild(a);
      a.click();
      a.remove();
      URL.revokeObjectURL(a.href);
      const out = document.getElementById('adoptResult');
      if(out) out.innerHTML += `<div style="margin-top:10px;">✅ Certificate downloaded. <a href="certificate.php?name=${encodeURIComponent(name)}&pet=${encodeURIComponent(pet)}" target="_blank" class="btn small">Open Printable Certificate</a></div>`;
    }, 'image/png', 1.0);
  };
  // set src after handlers so onload triggers
  sigImg.src = 'data:image/svg+xml;utf8,' + encodeURIComponent(sigSvg);
}

/* helper: wrap text centered */
function wrapText(ctx, text, x, y, maxWidth, lineHeight){
  const words = text.split(' ');
  let line = '';
  const lines = [];
  for(let n=0;n<words.length;n++){
    const testLine = line + words[n] + ' ';
    const metrics = ctx.measureText(testLine);
    if(metrics.width > maxWidth && n > 0){
      lines.push(line);
      line = words[n] + ' ';
    } else {
      line = testLine;
    }
  }
  lines.push(line);
  for(let i=0;i<lines.length;i++){
    ctx.fillText(lines[i].trim(), x, y + (i * lineHeight));
  }
}

/* ---------------- PetCare (localStorage) ---------------- */
function savePetCare(){
  const pet = document.getElementById('pc_pet').value.trim();
  const vacc = document.getElementById('pc_vacc').value;
  const next = document.getElementById('pc_next').value;
  const bday = document.getElementById('pc_bday').value;
  const vet = document.getElementById('pc_vet').value.trim();
  const notes = document.getElementById('pc_notes').value.trim();

  if(!pet || !vacc || !next || !bday){ alert('Please fill pet name/vaccination/birthday fields.'); return; }

  const key = 'pc_' + pet.toLowerCase().replace(/\s+/g,'_');
  const data = { pet, vacc, next, bday, vet, notes, savedAt: new Date().toISOString() };
  localStorage.setItem(key, JSON.stringify(data));

  const out = document.getElementById('careOutput');
  out.innerHTML = `✅ Saved: ${pet}. Last vacc: ${vacc}. Next: ${next}. Birthday: ${bday}. Vet: ${vet || '—'}.`;
}

function loadAllPetCare(){
  const out = document.getElementById('careOutput');
  out.innerHTML = '';
  const items = [];
  for(let i=0;i<localStorage.length;i++){
    const k = localStorage.key(i);
    if(k && k.startsWith('pc_')){
      try { items.push(JSON.parse(localStorage.getItem(k))); } catch(e){}
    }
  }
  if(items.length===0){ out.innerHTML = 'No saved pet care entries.'; return; }
  const html = items.map(it => `<div style="margin-bottom:10px;"><strong>${it.pet}</strong> — Last vacc: ${it.vacc} • Next: ${it.next} • Bday: ${it.bday} • Vet: ${it.vet || '—'}</div>`).join('');
  out.innerHTML = html;
}

/* Book appointment */
function bookAppointment(){
  const owner = document.getElementById('ownerName').value.trim();
  const pet = document.getElementById('ownerPet').value.trim();
  const date = document.getElementById('apptDate').value;
  if(!owner || !pet || !date){ alert('Please fill appointment fields.'); return; }
  const appts = JSON.parse(localStorage.getItem('appointments')||'[]');
  appts.push({ owner, pet, date, id: Date.now() });
  localStorage.setItem('appointments', JSON.stringify(appts));
  document.getElementById('apptResult').innerHTML = `✅ Appointment booked for <strong>${pet}</strong> on ${date}.`;
  renderAppointments();
}

function renderAppointments(){
  const list = document.getElementById('apptList');
  const appts = JSON.parse(localStorage.getItem('appointments')||'[]');
  if(!appts.length){ if(list) list.innerHTML = 'No upcoming appointments.'; return; }
  const rows = appts.map(a => `<div><strong>${a.pet}</strong> — ${a.date} (owner: ${a.owner})</div>`).join('');
  if(list) list.innerHTML = rows;
}
window.addEventListener('load', ()=>{ if(document.getElementById('apptList')) renderAppointments(); });

/* ---------------- PetMatch ---------------- */
function saveMatch(){
  const home = document.getElementById('m_home').value;
  const size = document.getElementById('m_size').value;
  const exp = document.getElementById('m_exp').value;
  const time = document.getElementById('m_time').value;
  const reason = document.getElementById('m_reason').value.trim();
  if(!reason){ alert('Please tell us why you want to adopt.'); return; }
  const matches = JSON.parse(localStorage.getItem('matches')||'[]');
  const item = { id: Date.now(), home, size, exp, time, reason };
  matches.push(item);
  localStorage.setItem('matches', JSON.stringify(matches));
  displayMatchSuggestion(item);
  document.getElementById('matchResult').scrollIntoView({behavior:'smooth'});
}

function displayMatchSuggestion(item){
  const box = document.getElementById('matchResult');
  let suggested = '';
  if(item.home==='Apartment' && item.exp==='Beginner' && item.time.indexOf('Less')!==-1) suggested = '🐱 Sundari (calm adult cat) — low maintenance, apartment-friendly.';
  else if(item.home==='Farmhouse' && item.exp!=='Beginner') suggested = '🐶 Bruno — loves space & activity.';
  else suggested = '🐶 Rio or 🐈 Minnie — friendly & adaptable.';
  box.innerHTML = `<strong>Suggested match:</strong> ${suggested} <br><small>Saved your preferences.</small>`;
}

function loadMatches(){
  const container = document.getElementById('savedMatches');
  const matches = JSON.parse(localStorage.getItem('matches')||'[]');
  if(!matches.length){ container.innerHTML = 'No saved matches.'; return; }
  const rows = matches.map(m => `<div style="margin-bottom:8px;"><strong>${m.home}</strong> • ${m.size} • ${m.exp} • ${m.time}<div style="color:#555; margin-top:4px;">${m.reason}</div></div>`).join('');
  container.innerHTML = rows;
}

/* ---------------- Contact ---------------- */
function handleContactSend(){
  const name = document.getElementById('cname').value.trim();
  const email = document.getElementById('cemail').value.trim();
  const msg = document.getElementById('cmsg').value.trim();
  if(!name || !email || !msg){ alert('Please fill all fields.'); return; }
  const sent = JSON.parse(localStorage.getItem('contactMessages')||'[]');
  sent.push({ id: Date.now(), name, email, msg });
  localStorage.setItem('contactMessages', JSON.stringify(sent));
  document.getElementById('contactResult').innerHTML = '💌 Message saved locally. We will contact you soon.';
}
