<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Test Validation AJAX</title>
    <style>
        .error-message { color: red; font-size: 0.9em; margin-top: 5px; }
        .success-message { color: green; margin-top: 10px; }
    </style>
</head>
<body>

    <h2>Créer un nouveau Rôle</h2>
    
    <form id="roleForm">
        <label for="name">Nom du rôle :</label>
        <input type="text" id="name" name="name">
        <div id="nameError" class="error-message"></div>
        
        <br>
        <button type="submit">Enregistrer</button>
    </form>

    <div id="globalMessage"></div>

    <script>
        document.getElementById('roleForm').addEventListener('submit', async function(e) {
            e.preventDefault(); // Empêche le rechargement de la page

            // Nettoyage des anciens messages
            document.getElementById('nameError').textContent = '';
            document.getElementById('globalMessage').textContent = '';

            // Récupération des données du champ
            const roleName = document.getElementById('name').value;

            try {
                // Envoi de la requête AJAX avec Fetch 
                const response = await fetch('/role/create', { // Ajustez l'URL selon vos routes
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest' // Indique à CI4 que c'est de l'AJAX
                    },
                    body: JSON.stringify({ name: roleName })
                });

                const result = await response.json();

                if (response.status === 422) {
                    // Affichage des erreurs spécifiques reçues du JSON 
                    if (result.errors && result.errors.name) {
                        document.getElementById('nameError').textContent = result.errors.name;
                    }
                } else if (response.ok) {
                    // Succès 
                    document.getElementById('globalMessage').className = 'success-message';
                    document.getElementById('globalMessage').textContent = result.message;
                    document.getElementById('roleForm').reset();
                }

            } catch (error) {
                console.error('Erreur lors de la requête :', error);
            }
        });
    </script>
</body>
</html>