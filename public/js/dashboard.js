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
