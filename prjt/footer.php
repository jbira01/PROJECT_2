<footer class="bg-dark text-white text-center py-3 mt-5">
  <p class="mb-0">&copy; <?php echo date('Y'); ?> <?php echo SITE_NAME; ?> - Tous droits réservés.</p>
</footer>

<!-- Bootstrap JS Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Page-specific JS -->
<?php if (isset($js_file)): ?>
<script src="assets/js/<?php echo $js_file; ?>index.js"></script>
<?php endif; ?>


</body>
</html>