// Loading
window.addEventListener('load', () => {
    window.scrollTo(0, 0);
    setTimeout(() => {
        window.scrollTo(0, 0);
        document.querySelector(".loading .mainContainer img").style.animation = "reduceImg .85s ease-in-out forwards";
        var animationTimeLine = gsap.timeline({duration: .275, delay: .7,ease: "Power4.inOut"});
            animationTimeLine.fromTo("header div", {opacity: 0}, {opacity: 1,});
            animationTimeLine.fromTo(".build", {opacity: 0}, {opacity: 1,});
        setTimeout(() => {
            document.getElementsByClassName("mainContainer")[1].style.display = "block";
            document.querySelector("body").style.overflowY = "scroll";
        }, 850)
    }, 1000);
})

// Cards
document.addEventListener("mousemove", e => {
    AOS.init();
    AOS.refresh();
});