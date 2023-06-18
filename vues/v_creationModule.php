<form class="needs-validation" method="post" action="index.php?uc=creationModule&action=validationModule" novalidate>
    <div class="mx-4 my-2">
        <label for="" class="form-label">Nom du module</label>
        <input type="text" name="nom" class="form-control" placeholder="Montre" required>
    </div>
    <div class="mx-4 my-2">
        <label for="description" class="form-label">Description</label>
        <textarea class="form-control" name="description" id="description" rows="3" placeholder="Description du module" required></textarea>
    </div>
    <select class="mx-4 my-2 border border-black form-select form-select-lg" name="etat" aria-label="form-select-lg example" required>
        <option selected disabled>Séléctionner un état</option>
        <option value="Actif">Actif</option>
        <option value="Inactif">Inactif</option>
    </select>
    <div class="mx-4 my-2">
        <button class="btn btn-primary" name="valider" type="submit">Valider</button>
    </div>
</form>