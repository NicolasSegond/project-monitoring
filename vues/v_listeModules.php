<div class="table-responsive">
    <div class="bs-example" data-example-id="striped-table">
      <table class="mx-4 my-4 w-auto table table-striped table-bordered table-hover">
        <thead class="thead-white">
          <tr>
            <th>Id</th>
            <th>Nom</th>
            <th>Descriptif</th>
            <th>Date d'installation</th>
            <th>Dernière mise à jour</th>
            <th>Etat</th>
            <th>Consulter les statistiques</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($lesModules->rowCOunt() > 0) {
            while ($modules = $lesModules->fetch()) { ?>
              <tr>
                <th scope="row"> <?php echo $modules['id'] ?> </th>
                <td><?php echo $modules['Nom'] ?> </td>
                <td><?php echo $modules['Description'] ?> </td>
                <td><?php echo $modules['DateInstallation'] ?></td>
                <td><?php echo $modules['DerniereMiseAJour'] ?></td>
                <td><?php echo $modules['Etat'] ?></td>
                <td>
                  <form method="POST"  action="http://localhost/projet-monitoring/index.php?uc=listeModule&action=detailsModule&id=<?php echo $modules['id'] ?>">
                    <input type="submit" name="maj" class="btn btn-primary" value="Consulter les statistiques"/>
                  </form>
                </td>
              </tr>

          <?php }
          } else {
            echo "<h4> Il n'y a pas de modules enregistrés </h4>";
          }
          ?>
        </tbody>
      </table>
    </div>
</div>