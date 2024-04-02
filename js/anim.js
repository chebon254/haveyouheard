//lottiefiles animation
window.addEventListener('DOMContentLoaded',lottieAnim())

function lottieAnim(){
    //contact form lottiefiles animation

    const contactAnimContainer=document.getElementsByClassName('contact-svg-container')[0];

    const contactAnim=bodymovin.loadAnimation({
        wrapper:contactAnimContainer,
        animType:'svg',
        loop:true,
        autoplay:true,
        path:"https://assets2.lottiefiles.com/packages/lf20_kf0ycibw.json"
    });

    //rocket lottiefiles animation

    const rocketAnimContainer=document.getElementsByClassName('rocket-container')[0];

    const rocketAnim=bodymovin.loadAnimation({
        wrapper:rocketAnimContainer,
        animType:'svg',
        loop:true,
        autoplay:true,
        path:"https://assets3.lottiefiles.com/packages/lf20_fok1irtr.json"
    });

    //saly lottiefiles animation

    const salyAnimContainer=document.getElementsByClassName('saly-anim-container')[0];

    const salyAnim=bodymovin.loadAnimation({
        wrapper:salyAnimContainer,
        animType:'svg',
        loop:true,
        autoplay:true,
        path:"https://assets3.lottiefiles.com/packages/lf20_mjhfdfno.json"
    });
}
