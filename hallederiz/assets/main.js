document.addEventListener("mousemove", (e) => {

    const glow = document.querySelector(".mouse-glow");

    glow.style.left = e.clientX + "px";
    glow.style.top = e.clientY + "px";

});