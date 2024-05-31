// const hamBurger = document.querySelector(".toggle-btn");

// hamBurger.addEventListener("click", function () {
//     document.querySelector("#sidebar").classList.toggle("expand");
// });

// document
//     .getElementById("navbarDropdown")
//     .addEventListener("click", function (event) {
//         event.preventDefault();
//         document.getElementById("dropdownToggle").classList.toggle("show");
//     });

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
