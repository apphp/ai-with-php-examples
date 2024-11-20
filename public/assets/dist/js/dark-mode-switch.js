
window.addEventListener("load", function () {
    if (document.getElementById("darkSwitch")) {

        var darkThemeSelected = getCookie("darkSwitch") !== null && getCookie("darkSwitch") === "dark";
        darkSwitch.checked = darkThemeSelected;

        darkSwitch.addEventListener("change", function () {
            if (darkSwitch.checked) {
                document.body.setAttribute("data-theme", "dark");
                setCookie("darkSwitch", "dark", 7);
            } else {
                document.body.removeAttribute("data-theme");
                setCookie("darkSwitch", null, -1);
            }
        });
    }
});

