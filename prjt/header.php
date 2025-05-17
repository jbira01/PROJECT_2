<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?php echo SITE_NAME; ?> - <?php echo $page_title ?? 'Accueil'; ?></title>
  
  <!-- Bootstrap & FontAwesome -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
  
  <!-- Page-specific CSS -->
  <?php if (isset($css_file)): ?>
  <link href="assets/css/<?php echo $css_file; ?>index.css" rel="stylesheet">
  <?php endif; ?>
</head>
<body>