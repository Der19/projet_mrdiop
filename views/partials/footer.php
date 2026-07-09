<div class="modal-overlay" id="deleteModal">
    <div class="modal">
        <h3>Confirmer la suppression</h3>
        <p id="deleteMsg"></p>
        <div class="modal-actions">
            <button class="btn btn-secondary" onclick="closeModal()">Annuler</button>
            <a href="#" id="deleteLink" class="btn btn-danger">Supprimer</a>
        </div>
    </div>
</div>

<footer>
    <p>&copy; 2024 MGLSI News — Tous droits réservés</p>
</footer>

<script>
function confirmDelete(url, msg) {
    document.getElementById('deleteMsg').textContent = msg;
    document.getElementById('deleteLink').href = url;
    document.getElementById('deleteModal').classList.add('active');
}
function closeModal() {
    document.getElementById('deleteModal').classList.remove('active');
}
document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) closeModal();
});
</script>
</body>
</html>
