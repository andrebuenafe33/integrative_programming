document.addEventListener("DOMContentLoaded", function () {
    const usersLink = document.getElementById("users-link");
    const aboutLink = document.getElementById("about-link");
    const profileLink = document.getElementById("profile-link");
    const settingsLink = document.getElementById("settings-link");
    const logoutLink = document.getElementById("logout-link");
    const pageTitle = document.getElementById("page-title");
    const content = document.getElementById("content");

    usersLink.addEventListener("click", function (event) {
        event.preventDefault();
        pageTitle.textContent = "Users";
        content.textContent = "Users content goes here...";
    });

    aboutLink.addEventListener("click", function (event) {
        event.preventDefault();
        pageTitle.textContent = "About";
        content.textContent = "About content goes here...";
    });

    profileLink.addEventListener("click", function (event) {
        event.preventDefault();
        pageTitle.textContent = "Profile";
        content.textContent = "Profile content goes here...";
    });

    settingsLink.addEventListener("click", function (event) {
        event.preventDefault();
        pageTitle.textContent = "Settings";
        content.textContent = "Settings content goes here...";
    });

    logoutLink.addEventListener("click", function (event) {
        event.preventDefault();
    });
});

const hamBurger = document.querySelector(".toggle-btn");

hamBurger.addEventListener("click", function () {
    document.querySelector("#sidebar").classList.toggle("expand");
});

document
    .getElementById("navbarDropdown")
    .addEventListener("click", function (event) {
        event.preventDefault();
        document.getElementById("dropdownToggle").classList.toggle("show");
    });

$(document).ready(function () {
    $("#logout-form").submit(function (event) {
        event.preventDefault();

        $.ajax({
            url: $(this).attr("action"),
            method: $(this).attr("method"),
            data: $(this).serialize(),
            success: function (response) {
                window.location.href = "/";
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
                console.error(status.responseText);
                console.error(error.responseText);
            },
        });
    });
});
