function executeScript() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'include/script.php', true);
    xhr.send();
}
console.log('fonction éxécuté2');
setInterval(executeScript, 60000); // 60000 représente 1 minute en millisecondes