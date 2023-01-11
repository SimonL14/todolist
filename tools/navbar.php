<header>
    <nav class="navbar sticky-top navbar-expand-lg navbar-light bg-primary">
        <a class="navbar-brand text-white" style="margin-left:20px;" href="./accueil.php" paddinf-left="5%">Bonjour <?php echo $_SESSION["FirstName"]; ?>.</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav mr-auto">
            <li class="nav-item  active">
                <a class="btn btn-primary" style="margin-left:250px;" href="./TaskList.php" role="button">Liste Tâches</a>
            </li>
            <li class="nav-item  active">
                <a class="btn btn-primary" href="./AddTask.php">Ajout Tâches</a>
            </li>
            <li class="nav-item  active">
                <a class="btn btn-primary" href="./TeamTasks.php">Tâches par teams</a>
            </li>
            <li class="nav-item  active">
                <a class="btn btn-primary" href="./TeamMember.php">Membres teams</a>
            </li>
            <?php 
            if ($_SESSION["type"] == 'ADMIN'){ ?>
            <li class="nav-item  active">
                <a class="btn btn-primary" href="./AddUserTeam.php">Créer Utilisateur/Team</a>
            </li>
            <li class="nav-item  active">
                <a class="btn btn-primary" href="./UserList.php">Liste Utilisateurs</a>
            </li>
            <li class="nav-item  active">
                <a class="btn btn-primary" href="./TeamList.php">Liste Teams</a>
            </li>
            <li class="nav-item  active">
                <a class="btn btn-primary" href="./AttributeTask.php">Attribution Taches</a>
            </li>
            <li class="nav-item  active">
                <a class="btn btn-primary" style="margin-left: 250px;" href="../tools/logout.php">Déconnexion</a>
            </li>
            <?php } ?>
            </ul>
        </div>
        </nav>
    </header>