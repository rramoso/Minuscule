</div><!-- </#container> -->
</div><!-- </#wrapper> -->
</main>
<?php if ($message = $this->session->flashdata('message')): ?>
    <script>
        noty({text: "<?= $message['text']; ?>", type: "<?= $message['type']; ?>", timeout: false});
    </script>
<?php endif; ?>
<footer>
    <p class="right footer-copyright">Copyright &copy; <?= date('Y'); ?> Joseph Schultz</p>
</footer>
</body>
</html>