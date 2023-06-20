/**
 * fonction qui éxécute le script tout les 1 minutes
 */
function executeScript() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'include/script.php', true);
    xhr.send();
}
setInterval(executeScript, 60000); // 60000 représente 1 minute en millisecondes