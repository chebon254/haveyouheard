//verify if mobile is true
var width;
var body=document.getElementsByTagName('body')[0];
var modal=document.getElementsByClassName('modal')[0];
var modalContainer=document.getElementsByClassName('modal-container')[0];
var closeM=document.getElementsByClassName('close')[0];
var sendContact=document.getElementsByClassName('send-contact');
var dot1=document.getElementById('ratio1');
var dot2=document.getElementById('ratio2');
var dot3=document.getElementById('ratio3');
var manualBtnRatio1=document.getElementsByClassName('manual-btn-ratio1')[0];
var manualBtnRatio2=document.getElementsByClassName('manual-btn-ratio2')[0];
var manualBtnRatio3=document.getElementsByClassName('manual-btn-ratio3')[0];
var backgroundImageDesktop=document.getElementsByClassName('background-image-desktop')[0];
var backgroundImageMobile=document.getElementsByClassName('background-image-mobile')[0];
var backgroundImageTablete=document.getElementsByClassName('background-image-tablete')[0];
var imageSaly=document.getElementsByClassName('hidden-mobile')[0];
var reviewsCard=document.getElementsByClassName('reviews-card')[0];
var footerDesktopBackground=document.getElementsByClassName('footer-desktop')[0];
var footerMobileBackground=document.getElementsByClassName('footer-mobile')[0];
var strokeDesktop=document.getElementsByClassName('stroke-desktop');
var strokeMobile=document.getElementsByClassName('stroke-mobile');
var desktopText=document.getElementsByClassName('desktop-text');
var mobileText=document.getElementsByClassName('mobile-text');

// modal section for sending forms values
    //open modal
Array.from(sendContact).forEach((el)=>{
    el.addEventListener('click',()=>{
        modal.style.display='block'
        document.body.style.overflowY='hidden'
    })
})
    //close modal
closeM.addEventListener('click',()=>{
    modal.style.display='none'
    document.body.style.overflowY='auto'
})
    //outside close
modalContainer.addEventListener('click',(e)=>{
    if(e.target==modalContainer){
        modal.style.display='none'
        document.body.style.overflowY='auto'
    }
})

window.addEventListener('DOMContentLoaded',()=>{
    // width=window.innerWidth;
    width=document.documentElement.clientWidth
    height=document.documentElement.clientHeight
    console.log(width)
    console.log('hei:'+height)
    if(width<=1028){
        if(width>=431){
            changeBackgroundToTablete()
        }
        else{
            changeBackgroundToMobile()
            MobileScroll()
            // automaticScroll()
        }
    }
    else{
        changeBackgroundToDesktop()
    }
    window.addEventListener('resize',()=>{
        // width=window.innerWidth;
        width=document.documentElement.clientWidth
        height=document.documentElement.clientHeight
        console.log(width)
        console.log('hei:'+height)
        if(width<=1028){
            if(width>=431){
                changeBackgroundToTablete()
            }
            else{
                changeBackgroundToMobile()
                MobileScroll()
                // automaticScroll()
            }
        }
        else{
            changeBackgroundToDesktop()
        }
    })
})

function changeBackgroundToMobile(){
    backgroundImageMobile.style.display='block'
    backgroundImageDesktop.style.display='none'
    backgroundImageTablete.style.display='none'
    imageSaly.classList.add('hide');
    Array.from(strokeDesktop).forEach((el)=>{
        el.classList.add('hide')
    })
    Array.from(strokeMobile).forEach((el)=>{
        el.style.display='block'
    })
    footerDesktopBackground.classList.add('hide')
    footerMobileBackground.style.display='block'
    Array.from(mobileText).forEach((el)=>{
        el.style.display='block'
    })
    Array.from(desktopText).forEach((el)=>{
        el.style.display='none'
    })
}
function changeBackgroundToDesktop(){
    backgroundImageMobile.style.display='none'
    backgroundImageDesktop.style.display='block'
    backgroundImageTablete.style.display='none'
    imageSaly.classList.remove('hide');
    Array.from(strokeMobile).forEach((el)=>{
        el.style.display='none'
    })
    Array.from(strokeDesktop).forEach((el)=>{
        el.classList.remove('hide')
    })
    Array.from(mobileText).forEach((el)=>{
        el.style.display='none'
    })
    Array.from(desktopText).forEach((el)=>{
        el.style.display='block'
    })
    footerDesktopBackground.classList.remove('hide')
    footerMobileBackground.style.display='none'
}
function changeBackgroundToTablete(){
    backgroundImageMobile.style.display='none'
    backgroundImageDesktop.style.display='none'
    backgroundImageTablete.style.display='block'
    imageSaly.classList.remove('hide');
    Array.from(strokeDesktop).forEach((el)=>{
        el.classList.add('hide')
    })
    Array.from(strokeMobile).forEach((el)=>{
        el.style.display='block'
    })
    Array.from(mobileText).forEach((el)=>{
        el.style.display='none'
    })
    Array.from(desktopText).forEach((el)=>{
        el.style.display='block'
    })
    footerDesktopBackground.classList.remove('hide')
    footerMobileBackground.style.display='none'
}

//function for mobile review card automatic scroll
function MobileScroll(){

    let scrollW=(reviewsCard.scrollWidth)
    let endScroll=reviewsCard.scrollWidth-reviewsCard.clientWidth
    let middleScroll=(reviewsCard.scrollWidth-reviewsCard.clientWidth)/2
    // let enterScroll=reviewsCard.scrollLeft
    // let enterScroll=reviewsCard.scrollBy(0,0)
    //default
    reviewsCard.scroll(middleScroll,0)
    manualBtnRatio1.classList.remove('manual-defautl')
    manualBtnRatio2.classList.add('manual-defautl')
    manualBtnRatio3.classList.remove('manual-defautl')
        // let dot3bool=null;
        // let dot1bool=null;
    //on click
    dot1.addEventListener('click',(e)=>{
        reviewsCard.scroll(0,0)
        manualBtnRatio1.classList.add('manual-defautl')
        manualBtnRatio2.classList.remove('manual-defautl')
        manualBtnRatio3.classList.remove('manual-defautl')
        // dot1bool=true;
    })
    dot2.addEventListener('click',()=>{
        reviewsCard.scroll(middleScroll,0)
        manualBtnRatio1.classList.remove('manual-defautl')
        manualBtnRatio2.classList.add('manual-defautl')
        manualBtnRatio3.classList.remove('manual-defautl')
        // dot3bool=false;
        // dot1bool=false;
    })
    dot3.addEventListener('click',()=>{
        reviewsCard.scroll(endScroll,0)
        manualBtnRatio1.classList.remove('manual-defautl')
        manualBtnRatio2.classList.remove('manual-defautl')
        manualBtnRatio3.classList.add('manual-defautl')
        // dot3bool=true;
    })
}
// function automaticScroll(){
//     let scrollW=(reviewsCard.scrollWidth)
//     let endScroll=reviewsCard.scrollWidth-reviewsCard.clientWidth
//     let middleScroll=(reviewsCard.scrollWidth-reviewsCard.clientWidth)/2
//     let enterScroll=reviewsCard.scrollLeft
//     //default
//     reviewsCard.scroll(middleScroll,0)
//     // manualBtnRatio2.classList.add('manual-defautl')
//     let bool=true;
//     reviewsCard.addEventListener('mouseenter',(e)=>{
//         console.log(e)
//         reviewsCard.scroll(0,0)
//         if(bool){
//             let id=setInterval(() => {
//                 reviewsCard.scrollBy(2,0)
//                 enterScroll=enterScroll+2
//                 if(enterScroll>=endScroll){
//                     enterScroll=0
//                     reviewsCard.scroll(0,0)
//                 }
//             }, 30);
//             setTimeout(() => {
//                 bool=false;
//                 clearInterval(id)
//                 manualBtnRatio2.classList.add('manual-defautl')
//                 reviewsCard.scroll(middleScroll,0)
//             }, 5000);
//         }
//     },{once:true})
//     reviewsCard.addEventListener('touchstart',(e)=>{
//         console.log(e)
//         if(bool){
//             let id=setInterval(() => {
//                 reviewsCard.scrollBy(2,0)
//                 enterScroll=enterScroll+2
//                 if(enterScroll>=endScroll){
//                     enterScroll=0
//                     reviewsCard.scroll(0,0)
//                 }
//             }, 90);
//             setTimeout(() => {
//                 bool=false;
//                 clearInterval(id)
//                 manualBtnRatio2.classList.add('manual-defautl')
//                 reviewsCard.scroll(middleScroll,0)
//             }, 5000);
//         }
//     },{once:true})
// }


//submit form section
var submitForm=document.getElementsByClassName('submit-form')[0];
var Form=document.getElementsByClassName('form')[0];

submitForm.addEventListener('click',function(e){
    if(Form.checkValidity()){
        e.preventDefault();
        let email=document.getElementById('email').value;
        let name=document.getElementById('name').value;
        let message=document.getElementById('message').value;
        SendEmail(name,email, message)
    }
    // console.log('ml',email)
})
//submit on subscribe button
var Suscribe=document.getElementsByClassName('subscribe')[0];
var formS=document.getElementsByClassName('formS')[0];
Suscribe.addEventListener('click',(e)=>{
    if(formS.checkValidity()){
        e.preventDefault()
        let emailS=document.getElementsByClassName('emailS')[0].value;
        Email.send({
            Host:"smtp.gmail.com",
            Username:'moikdb1@gmail.com',
            Password:'marmite90',
            To:'moikdb1@gmail.com',
            From:'moikdb1@gmail.com',
            Subject:`email subscriber`,
            Body:`Email:${emailS}`
        })
            .then((message)=>{
                if(message=='OK'){
                    // alert('successful')
                    formS.reset();
                }
                else{
                    console.log('error:',message)
                }
            })
    }
})

//send email function

function SendEmail(name,email,message){
    Email.send({
        Host:"smtp.gmail.com",
        Username:'moikdb1@gmail.com',
        Password:'marmite90',
        To:'moikdb1@gmail.com',
        From:'moikdb1@gmail.com',
        Subject:`${name} send you a message`,
        Body:`Name:${name} <br>Email:${email} <br>Message:${message} `
    })
        .then((message)=>{
            if(message=='OK'){
                Form.reset()
                modal.style.display='none'
                document.body.style.overflowY='auto'
            }
            else{
                console.log('error:',message)
            }
        })
}