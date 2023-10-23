
</div>
</div>

</div>

</div>
<div class="app-drawer-overlay d-none animated fadeIn"></div>
<script src="https://platform.linkedin.com/badges/js/profile.js" async defer type="text/javascript"></script>

<!-- LIBRERIA MODAL fancybox  -->
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
<!-- <script src="<?= $baseUrl ?>assets/jquery_ui/jquery-ui.min.js"></script> -->
<script>
Fancybox.bind('[data-fancybox]', {
});

/* SCRIPT PARA EL CARGADOR DE LA PAGINA */
var elemento = document.getElementById('cargadorLoading');
elemento.classList.add('show');
elemento.classList.add('loading');
setTimeout(function() {
    elemento.classList.remove('show');
    elemento.classList.remove('loading');
}, 200);
</script>

</body>
</html>