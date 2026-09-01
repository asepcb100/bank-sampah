<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Bumi Indramayu Lestari — Profil Komunitas</title>
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400;0,9..144,600;1,9..144,500&family=Work+Sans:wght@400;500;600;700&display=swap" rel="stylesheet" />
<style>
  :root{
    --cream:#f6f1e2;
    --paper:#fbf8ef;
    --ink:#2b2417;
    --moss-dark:#2c3821;
    --moss:#4c5c31;
    --moss-light:#93a869;
    --ochre:#c1852c;
    --ochre-light:#e9c688;
    --line: rgba(43,36,23,0.16);
    --radius: 3px;
  }
  *{box-sizing:border-box;}
  html{scroll-behavior:smooth;}
  body{
    margin:0;
    background:var(--cream);
    color:var(--ink);
    font-family:'Work Sans', sans-serif;
    font-size:16px;
    line-height:1.6;
  }
  h1,h2,h3,.display{
    font-family:'Fraunces', serif;
    font-weight:600;
    color:var(--moss-dark);
    line-height:1.08;
    margin:0;
  }
  a{color:inherit;}
  img{max-width:100%;display:block;}
  .wrap{max-width:1180px;margin:0 auto;padding:0 28px;}
  .leaf{
    display:inline-block;width:1em;height:1em;vertical-align:-0.12em;
  }

  /* ---------- NAV ---------- */
  header.site-nav{
    position:sticky;top:0;z-index:50;
    background:rgba(246,241,226,0.92);
    backdrop-filter:blur(6px);
    border-bottom:1px solid var(--line);
  }
  .nav-inner{
    display:flex;align-items:center;justify-content:space-between;
    padding:16px 0;
  }
  .brand{
    display:flex;align-items:center;gap:10px;
    font-family:'Fraunces', serif;font-weight:600;font-size:1.15rem;
    color:var(--moss-dark);text-decoration:none;
  }
  .brand svg{width:26px;height:26px;}
  nav.links{display:flex;gap:28px;font-size:0.94rem;}
  nav.links a{
    text-decoration:none;color:var(--ink);position:relative;padding-bottom:3px;
  }
  nav.links a::after{
    content:"";position:absolute;left:0;bottom:0;width:0;height:1px;background:var(--ochre);
    transition:width .25s ease;
  }
  nav.links a:hover::after{width:100%;}
  .nav-cta{
    background:var(--moss-dark);color:var(--paper);text-decoration:none;
    padding:9px 18px;border-radius:20px;font-size:0.9rem;
  }
  .menu-btn{display:none;background:none;border:0;cursor:pointer;}
  @media (max-width: 860px){
    nav.links{display:none;}
    .menu-btn{display:block;}
  }

  /* ---------- HERO ---------- */
  section.hero{padding:72px 0 60px;position:relative;overflow:hidden;}
  .hero-grid{
    display:grid;grid-template-columns: 1.1fr 0.9fr;gap:48px;align-items:center;
  }
  .eyebrow{
    color:var(--ochre);font-weight:600;font-size:0.92rem;margin-bottom:14px;
  }
  .hero h1{font-size:clamp(2.6rem, 5vw, 4rem);}
  .hero h1 .accent{
    background:var(--ochre-light);padding:0 8px;border-radius:2px;
  }
  .hero p.lead{
    max-width:46ch;margin-top:20px;font-size:1.08rem;color:#4a4030;
  }
  .hero-actions{display:flex;gap:14px;margin-top:30px;flex-wrap:wrap;}
  .btn{
    display:inline-block;padding:13px 24px;border-radius:var(--radius);
    text-decoration:none;font-weight:600;font-size:0.95rem;
  }
  .btn-primary{background:var(--ochre);color:var(--paper);}
  .btn-outline{border:1.5px solid var(--moss-dark);color:var(--moss-dark);}
  .hero-photo{
    position:relative;
    aspect-ratio: 4/5;
    background:linear-gradient(160deg, var(--moss) 0%, var(--moss-dark) 100%);
    border-radius: 2px;
    display:flex;align-items:center;justify-content:center;
    color:var(--cream);text-align:center;padding:24px;
    clip-path: polygon(6% 0, 100% 0, 100% 92%, 94% 100%, 0 100%, 0 8%);
  }
  .hero-photo span{font-size:0.85rem;opacity:0.75;}
  .hero-tag{
    position:absolute;bottom:-18px;left:-18px;background:var(--paper);
    border:1px solid var(--line);padding:14px 18px;border-radius:2px;
    font-size:0.85rem;box-shadow:0 6px 18px rgba(43,36,23,0.08);
  }
  .hero-tag strong{display:block;font-family:'Fraunces',serif;font-size:1.3rem;color:var(--moss-dark);}

  /* ---------- SECTION SHELL ---------- */
  section{padding:80px 0;}
  .section-head{max-width:56ch;margin-bottom:44px;}
  .section-head h2{font-size:clamp(1.9rem, 3vw, 2.5rem);}
  .section-head p{color:#5a5040;margin-top:12px;}
  .section-alt{background:var(--paper);border-top:1px solid var(--line);border-bottom:1px solid var(--line);}

  /* ---------- LATAR BELAKANG ---------- */
  .latar-grid{display:grid;grid-template-columns: 1fr 1fr;gap:56px;align-items:start;}
  .latar-list{list-style:none;margin:22px 0 0;padding:0;display:flex;flex-direction:column;gap:16px;}
  .latar-list li{display:flex;gap:12px;align-items:flex-start;font-size:0.98rem;}
  .latar-list svg{flex:none;width:20px;height:20px;margin-top:2px;color:var(--moss);}
  .quote-card{
    background:var(--moss-dark);color:var(--cream);padding:34px 30px;
    border-radius:2px;position:relative;
  }
  .quote-card p{
    font-family:'Fraunces',serif;font-style:italic;font-size:1.25rem;line-height:1.5;margin:0;
  }
  .quote-card .mark{position:absolute;top:14px;left:20px;font-size:3rem;font-family:'Fraunces',serif;color:var(--moss-light);opacity:0.5;}

  /* ---------- VISI MISI ---------- */
  .vm-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:0;border:1px solid var(--line);}
  .vm-cell{padding:32px 26px;border-right:1px solid var(--line);}
  .vm-cell:last-child{border-right:none;}
  .vm-cell:nth-child(odd){background:var(--paper);}
  .vm-cell .kicker{font-size:0.8rem;letter-spacing:0.02em;color:var(--ochre);font-weight:600;margin-bottom:10px;}
  .vm-cell h3{font-size:1.15rem;margin-bottom:10px;}
  .vm-cell p{font-size:0.92rem;color:#54493a;margin:0;}
  @media (max-width:900px){
    .vm-grid{grid-template-columns:1fr 1fr;}
    .vm-cell:nth-child(2n){border-right:none;}
  }

  /* ---------- MOTTO ---------- */
  section.motto{
    background:var(--moss-dark);color:var(--cream);text-align:left;position:relative;
    padding:96px 0;
  }
  .motto blockquote{
    margin:0;font-family:'Fraunces',serif;font-style:italic;font-weight:500;
    font-size:clamp(1.8rem,3.4vw,2.8rem);max-width:18ch;line-height:1.25;
  }
  .motto .leaf-mark{position:absolute;right:6%;top:50%;transform:translateY(-50%);width:120px;height:120px;opacity:0.15;}

  /* ---------- STRUKTUR ---------- */
  .org{display:flex;flex-direction:column;align-items:center;gap:0;}
  .org-row{display:flex;gap:18px;justify-content:center;flex-wrap:wrap;position:relative;padding:22px 0;}
  .org-row::before{
    content:"";position:absolute;top:0;left:50%;width:1px;height:22px;background:var(--line);
  }
  .org-row:first-child::before{display:none;}
  .org-card{
    background:var(--paper);border:1px solid var(--line);padding:16px 20px;border-radius:12px;
    min-width:190px;text-align:left;
  }
  .org-card .role{font-size:0.78rem;color:var(--ochre);font-weight:600;margin-bottom:6px;}
  .org-card .name{font-size:0.94rem;line-height:1.4;}
  .org-divisions{display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-top:36px;}
  @media (max-width:800px){.org-divisions{grid-template-columns:1fr;}}

  /* ---------- PROGRAM KERJA ---------- */
  .tabs{display:flex;gap:8px;margin-bottom:28px;flex-wrap:wrap;}
  .tab-btn{
    padding:10px 18px;border:1px solid var(--line);background:var(--paper);
    border-radius:20px;font-size:0.88rem;cursor:pointer;color:var(--ink);
  }
  .tab-btn.active{background:var(--moss-dark);color:var(--cream);border-color:var(--moss-dark);}
  .tab-panel{display:none;}
  .tab-panel.active{display:block;}
  .pill-list{display:flex;flex-wrap:wrap;gap:10px;}
  .pill{
    border:1px solid var(--line);padding:8px 14px;border-radius:20px;font-size:0.88rem;background:var(--cream);
  }

  /* ---------- HIGHLIGHT ---------- */
  .stat-collage{display:grid;grid-template-columns:repeat(4,1fr);gap:20px;}
  .stat-card{
    background:var(--paper);border:1px solid var(--line);padding:26px 20px;text-align:left;border-radius:2px;
  }
  .stat-card .num{font-family:'Fraunces',serif;font-size:2.6rem;color:var(--ochre);}
  .stat-card .label{font-size:0.88rem;color:#5a5040;margin-top:6px;}
  @media (max-width:900px){.stat-collage{grid-template-columns:repeat(2,1fr);}}

  /* ---------- GALERI ---------- */
  .gallery-grid{columns:4 220px;column-gap:16px;}
  .gallery-item{
    break-inside:avoid;margin-bottom:16px;border:1px solid var(--line);background:var(--moss);
    border-radius:12px;overflow:hidden;cursor:pointer;
    transition:transform .25s ease, box-shadow .25s ease;
  }
  .gallery-item:hover{
    transform:translateY(-4px);
    box-shadow:0 10px 24px rgba(43,36,23,0.14);
  }
  .gallery-item .ph{
    aspect-ratio: var(--r, 1);display:flex;align-items:center;justify-content:center;
    color:var(--cream);font-size:0.78rem;text-align:center;padding:10px;background:
      linear-gradient(160deg, var(--moss-light) 0%, var(--moss-dark) 100%);
  }
  .gallery-item .ph .zoom-hint{
    position:absolute;top:10px;right:10px;width:28px;height:28px;border-radius:50%;
    background:rgba(43,36,23,0.55);color:var(--cream);
    display:flex;align-items:center;justify-content:center;font-size:0.8rem;
    opacity:0;transition:opacity .25s ease;
  }
  .gallery-item:hover .zoom-hint{opacity:1;}
  .gallery-item figcaption{padding:10px 12px;font-size:0.8rem;background:var(--paper);}

  /* ---------- GALERI LIGHTBOX ---------- */
  .lightbox{
    position:fixed;inset:0;z-index:100;display:none;
    align-items:center;justify-content:center;
    background:rgba(20,16,8,0.86);padding:24px;
  }
  .lightbox.open{display:flex;}
  .lightbox-inner{
    max-width:min(860px, 92vw);max-height:88vh;
    position:relative;border-radius:12px;overflow:hidden;
    box-shadow:0 20px 60px rgba(0,0,0,0.5);
  }
  .lightbox-img{
    width:100%;height:100%;object-fit:contain;
    display:flex;align-items:center;justify-content:center;
    aspect-ratio:4/3;color:var(--cream);font-size:1rem;text-align:center;padding:40px;
    background:linear-gradient(160deg, var(--moss-light) 0%, var(--moss-dark) 100%);
  }
  .lightbox-caption{
    background:var(--paper);color:var(--ink);padding:14px 18px;font-size:0.95rem;
    text-align:center;border-top:1px solid var(--line);
  }
  .lightbox-close{
    position:absolute;top:12px;right:12px;z-index:2;
    width:36px;height:36px;border-radius:50%;border:0;cursor:pointer;
    background:rgba(20,16,8,0.6);color:var(--cream);font-size:1.3rem;line-height:1;
  }
  .lightbox-close:hover{background:rgba(20,16,8,0.85);}

  /* ---------- KATALOG ---------- */
  .produk-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:24px;}
  .produk-card{border:1px solid var(--line);background:var(--paper);border-radius:12px;overflow:hidden;}
  .produk-thumb{
    aspect-ratio:4/3;background:linear-gradient(160deg, var(--ochre-light), var(--ochre));
    display:flex;align-items:center;justify-content:center;color:var(--ink);font-size:0.82rem;
    position:relative;
  }
  .produk-tag{
    position:absolute;top:10px;left:10px;background:var(--moss-dark);color:var(--cream);
    font-size:0.72rem;padding:4px 9px;border-radius:12px;
  }
  .produk-body{padding:18px 18px 20px;}
  .produk-body h3{font-size:1.05rem;margin-bottom:6px;}
  .produk-body p{font-size:0.88rem;color:#54493a;margin:0 0 14px;}
  .produk-price{font-weight:600;color:var(--ochre);}
  .produk-cta{
    display:flex;justify-content:space-between;align-items:center;margin-top:14px;
  }
  .produk-cta a{font-size:0.85rem;text-decoration:underline;}
  @media (max-width:900px){.produk-grid{grid-template-columns:1fr 1fr;}}

  /* ---------- KONTAK ---------- */
  .kontak-grid{display:grid;grid-template-columns:1fr 1fr;gap:0;border:1px solid var(--line);}
  .kontak-info{padding:40px;background:var(--moss-dark);color:var(--cream);}
  .kontak-info h2{color:var(--cream);}
  .kontak-info .item{margin-top:22px;font-size:0.95rem;}
  .kontak-info .item .k{display:block;color:var(--moss-light);font-size:0.78rem;margin-bottom:4px;}
  .kontak-map{
    background:repeating-linear-gradient(45deg, var(--paper), var(--paper) 10px, #efe8d6 10px, #efe8d6 20px);
    display:flex;align-items:center;justify-content:center;color:#6b6150;font-size:0.85rem;
  }
  @media (max-width:800px){.kontak-grid{grid-template-columns:1fr;}}

  /* ---------- FOOTER ---------- */
  footer{padding:40px 0;border-top:1px solid var(--line);}
  .footer-inner{display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:14px;font-size:0.85rem;color:#6b6150;}
  .footer-inner a{text-decoration:none;margin-left:16px;}

  @media (max-width:900px){
    .hero-grid{grid-template-columns:1fr;}
    .latar-grid{grid-template-columns:1fr;}
    .kontak-info,.kontak-map{padding:32px;}
  }
</style>
</head>
<body>

<header class="site-nav">
  <div class="wrap nav-inner">
    <a href="#beranda" class="brand">
      <svg viewBox="0 0 24 24" fill="none"><path d="M4 20c8-1 12-7 12-15 0 0-12 1-12 15Z" fill="currentColor"/></svg>
      Bumi Indramayu Lestari
    </a>
    <nav class="links">
      <a href="#latar-belakang">Tentang</a>
      <a href="#visi-misi">Visi & Misi</a>
      <a href="#struktur">Struktur</a>
      <a href="#program-kerja">Program</a>
      <a href="#galeri">Galeri</a>
      <a href="#katalog">Katalog</a>
    </nav>
    <a href="#kontak" class="nav-cta">Hubungi Kami</a>
    <button class="menu-btn" aria-label="Menu">☰</button>
  </div>
</header>

<!-- HERO -->
<section class="hero" id="beranda">
  <div class="wrap hero-grid">
    <div>
      <p class="eyebrow">Komunitas peduli lingkungan · Kabupaten Indramayu</p>
      <h1>Berkontribusi memberi <span class="accent">solusi</span> untuk bumi lestari.</h1>
      <p class="lead">Sejak 2021, kami mengajak warga Indramayu menjalani hidup ramah lingkungan lewat langkah sederhana — dari memilah sampah di rumah sampai membangun ekonomi sirkular bersama.</p>
      <div class="hero-actions">
        <a href="#latar-belakang" class="btn btn-primary">Kenali Komunitas</a>
        <a href="#kontak" class="btn btn-outline">Hubungi Kami</a>
      </div>
    </div>
    <div class="hero-photo">
      <span>[ Foto tim pengurus Bumi Indramayu Lestari ]</span>
      <div class="hero-tag"><strong>2021</strong>tahun berdiri</div>
    </div>
  </div>
</section>

<!-- LATAR BELAKANG -->
<section id="latar-belakang">
  <div class="wrap">
    <div class="section-head">
      <h2>Kenapa komunitas ini berdiri</h2>
    </div>
    <div class="latar-grid">
      <div>
        <p>Kami adalah komunitas peduli lingkungan yang beraktivitas di Kabupaten Indramayu. Pendirian komunitas ini dilandasi oleh tiga hal:</p>
        <ul class="latar-list">
          <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 13l4 4L19 7"/></svg> Keprihatinan terhadap kualitas alam dan lingkungan akibat perilaku manusia</li>
          <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 13l4 4L19 7"/></svg> Kepedulian masyarakat yang masih rendah terhadap kelestarian lingkungan</li>
          <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 13l4 4L19 7"/></svg> Pola pikir dan perilaku masyarakat yang belum sesuai dengan cara hidup ramah lingkungan</li>
        </ul>
      </div>
      <div class="quote-card">
        <div class="mark">"</div>
        <p>Cara hidup ramah lingkungan yang dilakukan oleh banyak orang dengan cara sederhana, lebih baik daripada dilakukan oleh segelintir orang dengan cara yang sempurna.</p>
      </div>
    </div>
  </div>
</section>

<!-- VISI MISI -->
<section class="section-alt" id="visi-misi">
  <div class="wrap">
    <div class="section-head">
      <h2>Visi & misi kami</h2>
      <p>Dua arah yang berjalan beriringan: kelestarian lingkungan dan pemberdayaan ekonomi warga.</p>
    </div>
    <div class="vm-grid">
      <div class="vm-cell">
        <div class="kicker">Visi Lingkungan</div>
        <h3>Bumi yang bersih & lestari</h3>
        <p>Mewujudkan komunitas yang berkontribusi bagi terciptanya lingkungan hidup yang bersih, sehat, dan lestari (sustainable).</p>
      </div>
      <div class="vm-cell">
        <div class="kicker">Visi Ekonomi</div>
        <h3>Ekonomi warga yang berdaya</h3>
        <p>Mengembangkan peran komunitas dalam pemberdayaan ekonomi masyarakat.</p>
      </div>
      <div class="vm-cell">
        <div class="kicker">Misi Edukasi</div>
        <h3>Sustainable living untuk semua</h3>
        <p>Memberikan edukasi kepada masyarakat tentang cara hidup ramah lingkungan.</p>
      </div>
      <div class="vm-cell">
        <div class="kicker">Misi Ekonomi</div>
        <h3>Sampah jadi berkah</h3>
        <p>Pemberdayaan ekonomi lewat Bank Sampah, sedekah sampah, pemanfaatan minyak jelantah, dan produk kreatif.</p>
      </div>
    </div>
  </div>
</section>

<!-- MOTTO -->
<section class="motto">
  <div class="wrap">
    <blockquote>"Berkontribusi memberi solusi untuk bumi lestari."</blockquote>
  </div>
  <svg class="leaf-mark" viewBox="0 0 24 24" fill="currentColor"><path d="M4 20c8-1 12-7 12-15 0 0-12 1-12 15Z"/></svg>
</section>

<!-- STRUKTUR -->
<section id="struktur">
  <div class="wrap">
    <div class="section-head">
      <h2>Struktur kepengurusan</h2>
    </div>
    <div class="org">
      <div class="org-row">
        <div class="org-card"><div class="role">Konsultan</div><div class="name">Titan Listiani, S.Si., MMG., MT., Ph.D<br>Dr. Rahma Dewi Nasution, S.T., M.I.L</div></div>
      </div>
      <div class="org-row">
        <div class="org-card"><div class="role">Ketua</div><div class="name">Atin Indriawati, S.Pi</div></div>
        <div class="org-card"><div class="role">Sekretaris</div><div class="name">Ine Nuraini, S.T</div></div>
        <div class="org-card"><div class="role">Bendahara</div><div class="name">Ayu Amanah, S.Pd</div></div>
      </div>
      <div class="org-divisions">
        <div class="org-card"><div class="role">Divisi Pendidikan & Pelatihan</div><div class="name">Atin Indriawati, S.Pi<br>Ine Nuraini, S.T</div></div>
        <div class="org-card"><div class="role">Divisi Pemberdayaan Ekonomi</div><div class="name">Diannopi<br>Ayu Amanah, S.Pd</div></div>
        <div class="org-card"><div class="role">Divisi Humas & Sosial Media</div><div class="name">Rina Safitri, S.Pd</div></div>
      </div>
    </div>
  </div>
</section>

<!-- PROGRAM KERJA -->
<section class="section-alt" id="program-kerja">
  <div class="wrap">
    <div class="section-head">
      <h2>Lingkup program kerja</h2>
    </div>
    <div class="tabs">
      <button class="tab-btn active" data-tab="pendidikan">Pendidikan & Pelatihan</button>
      <button class="tab-btn" data-tab="ekonomi">Pemberdayaan Ekonomi</button>
      <button class="tab-btn" data-tab="humas">Humas & Sosial Media</button>
    </div>
    <div class="tab-panel active" id="pendidikan">
      <div class="pill-list">
        <span class="pill">Zero waste</span><span class="pill">Komposting</span><span class="pill">EcoEnzym</span>
        <span class="pill">Sedekah sampah</span><span class="pill">Bank sampah</span><span class="pill">Ecobrick</span>
        <span class="pill">Sabun minyak jelantah</span><span class="pill">Berkebun organik</span><span class="pill">Menanam pohon</span>
      </div>
    </div>
    <div class="tab-panel" id="ekonomi">
      <div class="pill-list">
        <span class="pill">Produk kreatif dari plastik kemasan</span><span class="pill">Bank sampah & sedekah sampah</span>
        <span class="pill">Sabun & sedekah minyak jelantah</span><span class="pill">Ecobrick, ecoenzym, kompos</span>
        <span class="pill">Kertas daur ulang</span><span class="pill">Kreasi limbah kain perca</span>
      </div>
    </div>
    <div class="tab-panel" id="humas">
      <div class="pill-list">
        <span class="pill">Komunikasi & kemitraan strategis</span><span class="pill">Kelola akun sosial media</span>
        <span class="pill">Sebar program via flyer & pamflet</span><span class="pill">Dokumentasi kegiatan</span>
        <span class="pill">Fasilitasi kegiatan online</span>
      </div>
    </div>
  </div>
</section>

<!-- HIGHLIGHT -->
<section id="highlight">
  <div class="wrap">
    <div class="section-head">
      <h2>Highlight 2024</h2>
    </div>
    <div class="stat-collage">
      <div class="stat-card"><div class="num">2×</div><div class="label">Edukasi bersama Komunitas Ibu di Bumi Patra</div></div>
      <div class="stat-card"><div class="num">1×</div><div class="label">Kolaborasi bersama PKK Margadadi</div></div>
      <div class="stat-card"><div class="num">1×</div><div class="label">Kolaborasi bersama Puskesmas Bangodua</div></div>
      <div class="stat-card"><div class="num">1×</div><div class="label">Kolaborasi dalam rangka Hari Santri</div></div>
      <div class="stat-card"><div class="num">5×</div><div class="label">Pengumpulan minyak jelantah</div></div>
      <div class="stat-card"><div class="num">3×</div><div class="label">Kelas BERGISI bersama Disarpus Kab. Indramayu</div></div>
      <div class="stat-card"><div class="num">7×</div><div class="label">Rapat internal komunitas</div></div>
    </div>
  </div>
</section>

<!-- GALERI -->
<section class="section-alt" id="galeri">
  <div class="wrap">
    <div class="section-head">
      <h2>Galeri kegiatan</h2>
      <p>Dokumentasi program, produk, dan kolaborasi bersama mitra.</p>
    </div>
    <div class="gallery-grid">
      <figure class="gallery-item" data-title="Sabun minyak jelantah — Produk portofolio"><div class="ph" style="--r:1.2">Sabun minyak jelantah<span class="zoom-hint">⤢</span></div><figcaption>Produk portofolio</figcaption></figure>
      <figure class="gallery-item" data-title="Kelas BERGISI — olah sampah anorganik — Perpusda Indramayu"><div class="ph" style="--r:0.8">Kelas BERGISI — olah sampah anorganik<span class="zoom-hint">⤢</span></div><figcaption>Perpusda Indramayu</figcaption></figure>
      <figure class="gallery-item" data-title="Studi banding Bank Sampah BERSINAR — Bandung"><div class="ph" style="--r:1">Studi banding Bank Sampah BERSINAR<span class="zoom-hint">⤢</span></div><figcaption>Bandung</figcaption></figure>
      <figure class="gallery-item" data-title="Edukasi mengompos & ecoenzym — Komplek Bumi Patra"><div class="ph" style="--r:0.7">Edukasi mengompos & ecoenzym<span class="zoom-hint">⤢</span></div><figcaption>Komplek Bumi Patra</figcaption></figure>
      <figure class="gallery-item" data-title="Kolaborasi PKK Margadadi — Kec. Indramayu"><div class="ph" style="--r:1.1">Kolaborasi PKK Margadadi<span class="zoom-hint">⤢</span></div><figcaption>Kec. Indramayu</figcaption></figure>
      <figure class="gallery-item" data-title="Audiensi Dinas Lingkungan Hidup — Kab. Indramayu"><div class="ph" style="--r:0.9">Audiensi Dinas Lingkungan Hidup<span class="zoom-hint">⤢</span></div><figcaption>Kab. Indramayu</figcaption></figure>
      <figure class="gallery-item" data-title="Edukasi pemanfaatan minyak jelantah — Desa Longok, Sliyeg"><div class="ph" style="--r:1">Edukasi pemanfaatan minyak jelantah<span class="zoom-hint">⤢</span></div><figcaption>Desa Longok, Sliyeg</figcaption></figure>
      <figure class="gallery-item" data-title="Penimbangan Bank Sampah — April 2026"><div class="ph" style="--r:0.8">Penimbangan Bank Sampah<span class="zoom-hint">⤢</span></div><figcaption>April 2026</figcaption></figure>
    </div>
  </div>
</section>

<!-- GALERI LIGHTBOX -->
<div class="lightbox" id="lightbox">
  <div class="lightbox-inner">
    <button class="lightbox-close" id="lightboxClose" aria-label="Tutup">×</button>
    <div class="lightbox-img" id="lightboxImg"></div>
    <div class="lightbox-caption" id="lightboxCaption"></div>
  </div>
</div>

<!-- KATALOG -->
<section id="katalog">
  <div class="wrap">
    <div class="section-head">
      <h2>Katalog produk</h2>
      <p>Hasil ekonomi sirkular komunitas — dari minyak jelantah, sampah anorganik, hingga kain perca.</p>
    </div>
    <div class="produk-grid">
      <div class="produk-card">
        <div class="produk-thumb"><span class="produk-tag">Perawatan</span>Sabun Minyak Jelantah</div>
        <div class="produk-body">
          <h3>Sabun Minyak Jelantah</h3>
          <p>Sabun batang hasil olahan minyak jelantah dari program sedekah minyak jelantah.</p>
          <div class="produk-cta"><span class="produk-price">Hubungi kami</span><a href="#kontak">Pesan →</a></div>
        </div>
      </div>
      <div class="produk-card">
        <div class="produk-thumb"><span class="produk-tag">Kerajinan</span>Ecobrick</div>
        <div class="produk-body">
          <h3>Ecobrick</h3>
          <p>Botol plastik padat berisi sampah anorganik, bahan dasar furnitur ramah lingkungan.</p>
          <div class="produk-cta"><span class="produk-price">Hubungi kami</span><a href="#kontak">Pesan →</a></div>
        </div>
      </div>
      <div class="produk-card">
        <div class="produk-thumb"><span class="produk-tag">Kerajinan</span>Bantal Jarum</div>
        <div class="produk-body">
          <h3>Bantal Jarum Kain Perca</h3>
          <p>Kerajinan bantal jarum dari sisa kain perca, hasil Kelas BERGISI.</p>
          <div class="produk-cta"><span class="produk-price">Rp 15.000</span><a href="#kontak">Pesan →</a></div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- KONTAK -->
<section id="kontak">
  <div class="wrap">
    <div class="kontak-grid">
      <div class="kontak-info">
        <h2>Mari terhubung</h2>
        <p style="margin-top:10px;opacity:0.85;">Terbuka untuk kolaborasi edukasi lingkungan, sedekah sampah, maupun sedekah minyak jelantah.</p>
        <div class="item"><span class="k">Kantor</span>Ruko Komplek Masjid Abdurrahman Basuri, Jl. MT Haryono, Sindang – Indramayu</div>
        <div class="item"><span class="k">Telepon / WhatsApp</span>0811-2442-322</div>
        <div class="item"><span class="k">Facebook</span>Bumi Indramayu Lestari</div>
        <div class="item"><span class="k">Instagram</span>@bumiindramayulestari</div>
      </div>
      <div class="kontak-map">[ Peta lokasi kantor ]</div>
    </div>
  </div>
</section>

<footer>
  <div class="wrap footer-inner">
    <div>© 2026 Bumi Indramayu Lestari — Berkontribusi memberi solusi untuk bumi lestari.</div>
    <div>
      <a href="#beranda">Kembali ke atas ↑</a>
    </div>
  </div>
</footer>

<script>
  document.querySelectorAll('.tab-btn').forEach(btn=>{
    btn.addEventListener('click', ()=>{
      document.querySelectorAll('.tab-btn').forEach(b=>b.classList.remove('active'));
      document.querySelectorAll('.tab-panel').forEach(p=>p.classList.remove('active'));
      btn.classList.add('active');
      document.getElementById(btn.dataset.tab).classList.add('active');
    });
  });

  // Galeri lightbox (zoom saat diklik)
  const lightbox = document.getElementById('lightbox');
  const lightboxImg = document.getElementById('lightboxImg');
  const lightboxCaption = document.getElementById('lightboxCaption');
  const lightboxClose = document.getElementById('lightboxClose');

  document.querySelectorAll('.gallery-item').forEach(item=>{
    item.addEventListener('click', ()=>{
      const text = item.querySelector('.ph').textContent.replace('⤢','').trim();
      lightboxImg.textContent = text;
      lightboxCaption.textContent = item.dataset.title || text;
      lightbox.classList.add('open');
      document.body.style.overflow = 'hidden';
    });
  });

  function closeLightbox(){
    lightbox.classList.remove('open');
    document.body.style.overflow = '';
  }
  lightboxClose.addEventListener('click', closeLightbox);
  lightbox.addEventListener('click', e=>{ if(e.target === lightbox) closeLightbox(); });
  document.addEventListener('keydown', e=>{ if(e.key === 'Escape') closeLightbox(); });
</script>

</body>
</html>
