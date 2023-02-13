jQuery(function ($) {
    (() => {
        "use strict";

        const toggleBtn = document.getElementById("toggle-theme");
        const moonIcon = toggleBtn.querySelector(".icon-moon");
        const sunIcon = toggleBtn.querySelector(".icon-sun");

        const getPreferredTheme = () => {
            return window.matchMedia("(prefers-color-scheme: dark)").matches
                ? "dark"
                : "light";
        };

        const setTheme = function (theme) {
            document.documentElement.setAttribute("data-bs-theme", theme);
            localStorage.setItem("theme", theme);
            $.ajax({
                url: "/save-theme",
                type: "POST",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },

                data: { theme: theme },
                success: function (data) {
                    console.log(data);
                },
            });
        };

        const showInactiveTheme = (theme) => {
            const inactiveIcon = theme === "dark" ? moonIcon : sunIcon;
            const activeIcon = theme === "dark" ? sunIcon : moonIcon;
            inactiveIcon.style.display = "none";
            activeIcon.style.display = "inline-block";
        };
        showInactiveTheme(
            document.documentElement.getAttribute("data-bs-theme")
        );

        toggleBtn.addEventListener("click", () => {
            const currentTheme =
                document.documentElement.getAttribute("data-bs-theme");
            const nextTheme = currentTheme === "dark" ? "light" : "dark";
            setTheme(nextTheme);
            showInactiveTheme(nextTheme);
        });

        window.addEventListener("load", () => {
            const themeFromLocalStorage = localStorage.getItem("theme");
            if (!themeFromLocalStorage) {
                const preferredTheme = getPreferredTheme();
                setTheme(preferredTheme);
                showInactiveTheme(preferredTheme);
            }
        });
    })();

    var url = window.location;
    $(".navbar-nav a").each(function () {
        if (url == this.href) {
            $(this).addClass("active");
            $(this).siblings().removeClass("active");
        }
    });
});
