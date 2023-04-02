let currentSquare = null;

function resetGame()
{
    fetch("controller/init.php", {
        method: 'post'
    }).then((response) => {
        return response.text();
    }).then((res) => {
        if (res === 'OK') {
            alert("Partie remise à 0.");
            if (currentSquare !== null) {
                currentSquare.style.background = "";
                currentSquare = null;
            }
            refreshBoard();
        } else {
            console.log('Erreur :' + res);
        }
    }).catch((error) => {
        console.log(error);
    });

    clearPreview();
}

function refreshBoard()
{
    fetch("controller/board.php", {
        method: 'get',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    }).then((response) => {
        return response.json();
    }).then((res) => {
        for (var x in res){
            let row = res[x];
            for (var y in row) {
                let square = document.getElementsByClassName("x"+x+" y"+y)[0];
                if (square !== undefined) {
                    square.innerText = "";
                    let piece = res[x][y];
                    if (piece !== null) {
                        square.innerText = piece.char;
                    }
                } else {
                    console.log("Case introuvable.");
                }
            }
        }
    }).catch((error) => {
        console.log(error);
    });

    resetInfos();
    refreshInfos();
}

function clearPreview()
{
    let squares = document.getElementsByTagName("td");

    for (let i = 0; i < squares.length; i++) {
        squares[i].classList.remove("preview");
    }
}

function refreshInfos()
{
    fetch("controller/infos.php", {
        method: 'get',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    }).then((response) => {
        return response.json();
    }).then((res) => {
        if (res.turn === 0) {
            document.getElementById("player-turn").innerText = "Au joueur blanc de jouer.";
        } else if (res.turn === 1) {
            document.getElementById("player-turn").innerText = "Au joueur noir de jouer.";
        } else {
            document.getElementById("player-turn").innerText = "Partie terminée.";
        }

        document.getElementById("white-points").innerText = "Valeur du plateau du joueur blanc : " + res.white_points;
        document.getElementById("black-points").innerText = "Valeur du plateau du joueur noir : " + res.black_points;

        let elem = document.getElementById("white-graveyard");
        elem.innerText = "Prises du joueur blanc : ";
        if (res.white_graveyard.length > 0) {
            for (let i = 0; i < res.white_graveyard.length; i++) {
                elem.innerText += res.white_graveyard[i].char;
                if (i < res.white_graveyard.length - 1) {
                    elem.innerText += " , ";
                }
            }
        } else {
            elem.innerText += "aucune";
        }

        elem = document.getElementById("black-graveyard");
        elem.innerText = "Prises du joueur noir : ";
        if (res.black_graveyard.length > 0) {
            for (let i = 0; i < res.black_graveyard.length; i++) {
                elem.innerText += res.black_graveyard[i].char;
                if (i < res.black_graveyard.length - 1) {
                    elem.innerText += " , ";
                }
            }
        } else {
            elem.innerText += "aucune";
        }

        elem = document.getElementById("historic");
        elem.innerHTML = "Historique : ";
        if (res.historic.length > 0) {
            elem.innerHTML += "<ul>";
            for (let i = 0; i < res.historic.length; i++) {
                elem.innerHTML += ("<li>" + res.historic[i] + "</li>");
            }
            elem.innerHTML += "</ul>";
        } else {
            elem.innerHTML += "/";
        }
    }).catch((error) => {
        console.log(error);
    });
}

function resetInfos()
{
    document.getElementById("player-turn").innerText = "";
    document.getElementById("white-points").innerText = "";
    document.getElementById("black-points").innerText = "";
    document.getElementById("white-graveyard").innerText = "";
    document.getElementById("black-graveyard").innerText = "";
    document.getElementById("historic").innerHTML = "";
}

document.addEventListener("DOMContentLoaded", function(event) { 
    refreshBoard();

    let squares = document.getElementsByTagName("td");

    for (let i = 0; i < squares.length; i++) {
        let square = squares[i];
        // gestion frontend du mouvement des pièces
        square.addEventListener('click', event => {
            clearPreview();

            let clickedSquare = event.target;
            if (currentSquare === null && clickedSquare.innerHTML.trim().length > 0) {
                currentSquare = clickedSquare;
                clickedSquare.style.background = "red";

                let fromClasses = currentSquare.className.split(" ");

                for (let j = 0; j < fromClasses.length; j++) {
                    if (fromClasses[j][0] === "x") {
                        fromX = fromClasses[j][1];
                    } else if (fromClasses[j][0] === "y") {
                        fromY = fromClasses[j][1];
                    }
                }

                fetch("controller/move_preview.php?" + new URLSearchParams({
                    fromX: fromX,
                    fromY: fromY,
                }), {
                    method: 'get',
                }).then((response) => {
                    return response.json();
                }).then((res) => {
                    for (var x in res){
                        let row = res[x];
                        for (var y in row) {
                            if (row[y]) {
                                let square = document.getElementsByClassName("x"+x+" y"+y)[0];
                                if (square !== undefined) {
                                    square.classList.add("preview");
                                } else {
                                    console.log("Case introuvable.");
                                }
                            }
                        }
                    }
                }).catch((error) => {
                    console.log(error);
                });
            } else if (currentSquare !== null && currentSquare !== clickedSquare) {
                let fromClasses = currentSquare.className.split(" ");
                let toClasses = clickedSquare.className.split(" ");

                let fromX = null;
                let fromY = null;
                let toX = null;
                let toY = null;

                for (let j = 0; j < fromClasses.length; j++) {
                    if (fromClasses[j][0] === "x") {
                        fromX = fromClasses[j][1];
                    } else if (fromClasses[j][0] === "y") {
                        fromY = fromClasses[j][1];
                    }
                }

                for (let j = 0; j < toClasses.length; j++) {
                    if (toClasses[j][0] === "x") {
                        toX = toClasses[j][1];
                    } else if (toClasses[j][0] === "y") {
                        toY = toClasses[j][1];
                    }
                }

                let data = new FormData();
                data.append("fromX", fromX);
                data.append("fromY", fromY);
                data.append("toX", toX);
                data.append("toY", toY);

                fetch("controller/move.php", {
                    method: 'post',
                    body: data,
                }).then((response) => {
                    return response.text();
                }).then((res) => {
                    if (res === 'OK') {
                        refreshBoard();
                    } else {
                        console.log('Erreur :' + res);
                        alert(res);
                    }
                }).catch((error) => {
                    console.log(error);
                });

                currentSquare.style.background = "";
                currentSquare = null;
            } else if (currentSquare !== null && currentSquare === clickedSquare) {
                currentSquare.style.background = "";
                currentSquare = null;
            }
        });
    }
});