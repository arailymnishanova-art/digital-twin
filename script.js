document.addEventListener("DOMContentLoaded", function () {
    console.log("Digital Twin жүйесі іске қосылды!");

    const buttons = document.querySelectorAll("button");

    buttons.forEach(function (button) {
        button.addEventListener("click", function () {
            console.log("Батырма басылды");
        });
    });
});
