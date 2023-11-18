let X, Y;
let R1, R2, R3, R4, R5;
const GRAPH_WIDTH = 300;
const GRAPH_HEIGHT = 300

document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("submit-button").addEventListener("click", submit);
    document.getElementById("clear-button").addEventListener("click", clearButton);
});

function checkY() {
    let Y_text = document.getElementById("Y-text");
    Y = Y_text.value.replace(",", ".");
    if (Y.trim() === "") {
        Y_text.setCustomValidity("Заполните поле");
        return false;
    } else if (!isFinite(Y)) {
        Y_text.setCustomValidity("Должно быть число!");
        return false;
    } else if (Y >= 3 || Y <= -5) {
        Y_text.setCustomValidity("Вы вышли за диапазон (-5; 3)!");
        return false;
    }
    Y_text.setCustomValidity("");
    return true;
}

function checkRs() {

    let R_text = document.getElementById("r1");
    let checkCount = 0;
    for (let i = 1; i < 6; i++) {
        if (document.getElementById("r" + i).checked) {
            checkCount++;
            window["R" + i] = i;
        } else window["R" + i] = 0;
    }
    if (checkCount <= 0) {
        R_text.setCustomValidity("Вы не выбрали радиус");
        return false;
    }
    return true;
}

function setX() {
    for (let i = -3; i < 6; i++) {
        if (document.getElementById("x" + i).checked) {
            X = i;
            break;
        }
    }
}

const submit = function (e) {
    if (!checkY()) return;
    if (!checkRs()) return;
    setX();
    e.preventDefault();


    for (let i = 1; i < 6; i++) {
        if (window["R" + i] > 0) {
            let point = $("#point");
            let request = ("?x=" + X + "&y=" + Y + "&r=" + window["R" + i]);
            const xGraph = calculateX(X, window["R" + i]), yGraph = calculateY(Y, window["R" + i]);

            point.attr({
                cx: xGraph,
                cy: yGraph,
                visibility: "visible"
            });

            fetch("php/check.php" + request)
                .then(response => response.text())
                .then(response => document.getElementById("check").innerHTML = response);
        }
    }

};

const clearButton = function (e) {
    e.preventDefault();
    fetch("php/clear_table.php")
        .then(response => response.text())
        .then(response => document.getElementById("check").innerHTML = response)
};


$("input:checkbox").click(function () {
    let group = "input:checkbox[name='" + $(this).prop("name") + "']";
    $(group).prop("checked", false);
    $(this).prop("checked", true);
}).on("change", e => {
    changePoint();
})

function calculateX(x, r) {
    return x / r * 100 + GRAPH_WIDTH / 2;
}

function calculateY(y, r) {
    return GRAPH_HEIGHT / 2 - y / r * 100;
}