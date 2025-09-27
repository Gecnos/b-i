document.addEventListener('DOMContentLoaded', () => {
    
    const blocks = document.querySelectorAll('.sidebar-block');
    blocks.forEach(block => {
        block.addEventListener('mouseenter', () => {
        });
        block.addEventListener('mouseleave', () => {
        });
    });
});
document.addEventListener('DOMContentLoaded', () => {
    const liensDropdown = document.querySelectorAll('.dropdown-content a');
    const afficheur = document.getElementById('contenu-afficheur');
    liensDropdown.forEach(lien => {
        lien.addEventListener('click', (event) => {
            event.preventDefault(); 
            const contenuAffiche = event.target.getAttribute('data-content')
            afficheur.textContent = contenuAffiche;
        });
    });
});