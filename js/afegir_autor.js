// 29-08-2018
// alex
// afegir_autor.js

function afAutors() {
    var cont = document.getElementById("autors");
    var div = document.createElement("div");
    var span1 = document.createElement("span");
    var span2 = document.createElement("span");
    var input = document.createElement("input");
    var num = parseInt(cont.getAttribute("data-nombredautors"));
    num = num + 1;
    cont.setAttribute("data-nombredautors", num);
    div.classList.add("input-group");
    div.classList.add("autocomplete");
    span1.classList.add("input-group-addon");
    span1.id = "basic-addon" + num;
    span2.classList.add("glyphicon");
    span2.classList.add("glyphicon-tag");
    span2.setAttribute("aria-hidden", "true");
    input.type = "text";
    input.name = "autor[]";
    input.classList.add("autoc");
    input.classList.add("form-control");
    input.id = "nom_aut" + num;
    input.setAttribute("aria-describedby", "basic-addon" + num);
    span1.appendChild(span2);
    div.appendChild(span1);
    div.appendChild(input);
    cont.appendChild(document.createElement("br"));
    cont.appendChild(div);
    autoco();
}
autoco();
