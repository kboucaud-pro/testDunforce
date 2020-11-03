$(document).ready(function () {
    //Before Submit
    //Add all the users and settings encoded into JSON into a hidden field
    $('#organizationForm').submit(function () {
        var users = [];
        var roleList;
        $('.organizationUser').each((id, user) => {
            var userTab = {
                "name": null,
                "role": [],
                "password": null
            };
            for (var i = 0; i < user.childNodes.length; i++) {
                if (user.childNodes[i].className == "roleList"){
                    roleList = user.childNodes[i];
                    for (var j = 0; j < roleList.childNodes.length; j++){
                        if (roleList.childNodes[j].className == "roleName")
                            userTab.role.push(roleList.childNodes[j].firstChild.textContent)
                    }
                }
                else if (user.childNodes[i].className == "userName")
                    userTab.name = user.childNodes[i].value;
                else if (user.childNodes[i].className == "userPassword")
                    userTab.password = user.childNodes[i].value;
            }
            users.push(userTab);
        })
        $("<input />").attr("type", "hidden").attr("name", "users").attr("value", JSON.stringify(users)).appendTo("#organizationForm");
        $('#organizationForm').attr('action', '/organization/' + $('#organizationName')[0].value)
        return true;
    });


    //Add a user, create all fields needed to get the datas
    $('#addUserButton').on('click', function () {
        if ($('#addUserInput')[0].value == "")
            return;
        $('#organizationUserList').append(`<div class="organizationUser">
        Name: <input type="text" value=${$('#addUserInput')[0].value} class="userName"/>
        Password: <input type="text" class="userPassword" />
        Roles: <div class="roleList"></div>
        <input type="text" class="addRoleInput" /><button type="button" class="addRoleButton">Add role</button>
        <button type="button" class="deleteUserButton">Delete User</button></div><br>`);
    })

    //Add a role
    //Do nothing if text field empty
    $('body').on('click', '.addRoleButton', function () {
        var inputField = this.previousSibling;
        if (inputField.value == "")
            return;
        var roleName = inputField.value.toUpperCase();
        var roleList = this.parentNode.childNodes;
        for (var i = 0; i < roleList.length; i++) {
            if (roleList[i].className == "roleList") {
                roleList[i].innerHTML += `<span class="roleName">${roleName}<button type="button" class="deleteRole">X</button></span>`;
                inputField.value = "";
            }
        }
    })

    //Delete the role
    $('body').on('click', '.deleteRole', function(){
        this.parentNode.remove();
    })

    //delete the user
    $('body').on('click', '.deleteUserButton', function () {
        this.parentNode.remove();
    })
})