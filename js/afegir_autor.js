function afAutors() {
    var cont = document.getElementById("autors");
    var div = document.createElement("div");
    var span1 = document.createElement("span");
    var span2 = document.createElement("span");
    var input = document.createElement("input");
    div.classList.add("input-group");
    div.classList.add("autocomplete");
    span1.classList.add("input-group-addon");
    span1.id = "basic-addon2";
    span2.classList.add("glyphicon");
    span2.classList.add("glyphicon-tag");
    span2.setAttribute("aria-hidden", "true");
    input.type = "text";
    input.name = "autor";
    input.classList.add("form-control");
    input.id = "nom_aut";
    input.setAttribute("aria-describedby", "basic-addon2");
    span1.appendChild(span2);
    div.appendChild(span1);
    div.appendChild(input);
    cont.appendChild(div);
    cont.appendChild(document.createElement("br"));
}
