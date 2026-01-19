<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include 'version.php'; ?>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo $page_title ?? 'Insight Research | Premium Content Writing & Business Consultancy'; ?></title>
    <?php if (isset($meta_description)): ?>
    <meta name="description" content="<?php echo htmlspecialchars($meta_description); ?>" />
    <?php else: ?>
    <meta
      name="description"
      content="Transform your ideas into compelling content. Insight Research delivers pro-level writing, research, and consulting services tailored to your needs."
    />
    <?php endif; ?>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="styles.css?v=<?php echo $version ?? ''; ?>" />
    <link rel="icon" type="image/png" href="images/insight-res-logo-144x144.png" />
  </head>
   <body>
    <div class="bg-gradient"></div>
    <div class="bg-grid"></div>

    <header class="header">
      <nav class="nav container">
        <a href="index.php" class="logo">
          <img src="images/insight-res-logo-300x300.png" alt="Insight Research Logo" width="48" height="48" class="logo-image">
        </a>
        <button class="menu-toggle" aria-label="Toggle menu">
          <span></span>
          <span></span>
          <span></span>
        </button>
        <ul class="nav-links">
          <li><a href="index.php" class="<?php echo ($current_page ?? '') === 'home' ? 'active' : ''; ?>">Home</a></li>
          <li><a href="blog.php" class="<?php echo ($current_page ?? '') === 'blog' ? 'active' : ''; ?>">Blog</a></li>
          <li><a href="case-studies.php" class="<?php echo ($current_page ?? '') === 'case-studies' ? 'active' : ''; ?>">Case Studies</a></li>
          <li><a href="faq.php" class="<?php echo ($current_page ?? '') === 'faq' ? 'active' : ''; ?>">FAQ</a></li>
          <li>
            <a href="index.php#contact" class="btn btn-primary btn-nav">Get Started</a>
          </li>
        </ul>
      </nav>
    </header>

    <main>
