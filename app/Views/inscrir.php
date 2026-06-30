<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Ajouter un utilisateur</title>

    <style>
        .error {
            color: red;
            font-size: 14px;
        }

        input,
        select {
            display: block;
            margin-bottom: 5px;
            width: 300px;
            padding: 8px;
        }

        button {
            padding: 8px 20px;
        }
    </style>
</head>

<body>

    <h2>Ajouter un utilisateur</h2>

    <form id="userForm">

        <label>Nom d'utilisateur</label>
        <input type="text" name="username">
        <div id="username_error" class="error"></div>

        <label>Email</label>
        <input type="email" name="email">
        <div id="email_error" class="error"></div>

        <label>Mot de passe</label>
        <input type="password" name="password">
        <div id="password_error" class="error"></div>

        <label>Rôle</label>
        <select name="role_id">
            <option value="">Sélectionner</option>
            <option value="1">Admin</option>
            <option value="2">RH</option>
            <option value="3">User</option>
        </select>
        <div id="role_id_error" class="error"></div>

        <br>

        <button type="submit">Enregistrer</button>

    </form>

    <script>
        const form = document.getElementById("userForm");

        // Validation d'un champ
        function validateField(field) {
            fetch("<?= site_url('users/validate') ?>", {
                method: "POST",
                body: new FormData(form)
            })
                .then(r => r.json())
                .then(data => {
                    document.getElementById(field.name + "_error").innerHTML =
                        data.errors?.[field.name] || "";
                });
        }

        form.querySelectorAll("input,select").forEach(el => {
            el.addEventListener(el.tagName === "SELECT" ? "change" : "input", () => validateField(el));
        });

        // Enregistrement
        form.onsubmit = e => {
            e.preventDefault();

            fetch("<?= site_url('users/save') ?>", {
                method: "POST",
                body: new FormData(form)
            })
                .then(r => r.json())
                .then(data => {

                    document.querySelectorAll(".error").forEach(e => e.innerHTML = "");

                    if (data.status) {
                        alert(data.message);
                        form.reset();
                        return;
                    }

                    for (let key in data.errors) {
                        document.getElementById(key + "_error").innerHTML = data.errors[key];
                    }
                });
        };
    </script>

</body>

</html>