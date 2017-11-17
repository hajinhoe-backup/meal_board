function submit_menu(form_element) {
    if(form_element.menu_name.value == "" || form_element.menu_price.value =="") {
        alert("올바른 입력이 아닙니다.");
        return false;
    }
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            if(this.responseText == true) {
                window.location.reload();
                //var content = document.createElement("p");
                //content.appendChild(document.createTextNode("메뉴명 : "+form_element.menu_name.value+" 가격 : "+form_element.menu_price.value+"원"));
                //document.getElementById("new_menu").appendChild(content);
                document.menu.reset();
            } else {
                alert("이미 등록된 메뉴거나, 다른 문제가 있는 것 같습니다.")
            }
        }
    }
    xhttp.open("POST", "php/new_menu.php", true);
    xhttp.send(new FormData(form_element));
    return false;
}
function submit_estimation(form_element) {
    if(form_element.user_name.value == "" || form_element.comment.value == "" || form_element.rating.value == "") {
        alert("올바른 입력이 아닙니다.");
        return false;
    }
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            if (this.responseText == true) {
                window.location.reload();
                //var content = document.createElement("p");
                //content.appendChild(document.createTextNode("이름 : " + form_element.user_name.value + " 평가 내용 : " + form_element.comment.value + " 별점 : " + form_element.rating.value));
                //document.getElementById("new_estimation").appendChild(content);
                document.comment.reset();
            } else {
                alert("평가를 이미 등록하셨거나, 다른 문제가 있는 것 같습니다.")
            }
        }
    }
    xhttp.open("POST", "php/new_estimation.php", true);
    xhttp.send(new FormData(form_element));
    return false;
}
function submit_edited_menu(form_element, re) {
    if(form_element.menu_name.value == "" || form_element.menu_price.value =="") {
        alert("올바른 입력이 아닙니다.");
        return false;
    }
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            if (this.responseText == true) { //reload 없이 추가할 방법이 생각이 안 나네...
                window.location.reload();
            } else {
                alert("입력한 내용에 문제가 있거나 다른 문제가 발생한 것 같습니다.")
            }
        }
    }
    xhttp.open("POST", "php/edit_menu.php", true);
    xhttp.send(new FormData(form_element));
    return false;
}
function submit_now(form_element) {
    if(form_element.comment.value == "") {
        alert("올바른 입력이 아닙니다.");
        return false;
    }
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            if (this.responseText == true) {
                window.location.reload();
                //var content = document.createElement("p");
                //content.appendChild(document.createTextNode("이름 : " + form_element.user_name.value + " 평가 내용 : " + form_element.comment.value + " 별점 : " + form_element.rating.value));
                //document.getElementById("new_estimation").appendChild(content);
                document.now_comment.reset();
            } else {
                alert("평가를 이미 등록하셨거나, 다른 문제가 있는 것 같습니다.")
            }
        }
    }
    xhttp.open("POST", "php/new_now.php", true);
    xhttp.send(new FormData(form_element));
    return false;
}
function edit_menu(selected_menu, shop_id) {
    selected_menu.parentElement.parentElement.innerHTML =
        "<form name=\"menu\" onsubmit=\"return submit_edited_menu(this);\">\n" +
        "<div>\n" +
        "<input type=\"text\" name=\"disabled_menu_name\" value=\""+selected_menu.parentElement.parentElement.getElementsByClassName("menu_name")[0].innerHTML+"\" disabled/>\n" +
        "<input type=\"text\" name=\"menu_price\" value="+selected_menu.parentElement.parentElement.getElementsByClassName("menu_price")[0].innerHTML+" size=\"6\"/>\n" +
        "<input type=\"hidden\" name=\"shop_id\" value=\""+shop_id+"\"/>\n" +
        "<input type=\"hidden\" name=\"menu_name\" value=\""+selected_menu.parentElement.parentElement.getElementsByClassName("menu_name")[0].innerHTML+"\"/>\n" +
        "<input type=\"submit\" value=\"저장\"/>\n" +
        "</div>\n" +
        "</form>";
}
function remove_menu(selected_menu, shop_id) {
    if (confirm("삭제 요청을 보내시겠습니까? 운영자가 확인후 삭제할 것입니다.")) {
        alert("감사합니다. 귀하의 요청이 관리자에게 전달되었습니다.")
    }
}
function avg_rating(avg) {
    var string = "";
    for (var i=1; i<=5; i++) {
        if(i <= avg) {
            string = string + "<i class=\"fa fa-star\" aria-hidden=\"true\"></i>";
        } else {
            string = string + "<i class=\"fa fa-star-o\" aria-hidden=\"true\"></i>";
        }

    }
    document.getElementById("avg_rating").innerHTML = string;
}
function star_click(id) {
    var i;
    for (i=1; i <= 5; i++) {
        if (i <= id.substring(4,5)) {
            document.getElementById("star" + i).innerHTML = "<i class=\"fa fa-star\" aria-hidden=\"true\"></i>";
        } else {
            document.getElementById("star" + i).innerHTML = "<i class=\"fa fa-star-o\" aria-hidden=\"true\"></i>";
        }
    }
    document.getElementById("rating_star").value = id.substring(4,5);

}

function view_img(selected_menu, name) {
    if (selected_menu.getElementsByTagName("img")[0] === undefined) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                var node = document.createElement("img");
                node.src = this.responseText;
                node.style.position = "absolute";
                node.style.top = "50px";
                node.style.left = "0";
                node.style.border = "3px solid black"
                node.style.zIndex = "5";
                selected_menu.appendChild(node);
            }
        };
    } else {
        var x = selected_menu.getElementsByTagName("img")[0]
        x.remove(x.selectedIndex);
    }

    xhttp.open("GET", "get_img.php?menu_name="+name,true);
    xhttp.send();
}