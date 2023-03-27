var downloadlink = ie_down_vars.dllink;
var downloadbutton = ie_down_vars.dlbutton;
const para = document.getElementById("download");
function myMessage() {
    para.innerHTML = "<a class='download-link' href='" + downloadlink + "' rel='nofollow'>" + downloadbutton + "</a>";
}
setTimeout(myMessage, 11000);

const el = document.getElementById('numDiv');
var timeleft = 10;
var downloadTimer = setInterval(function(){
    if(timeleft <= 0){
        clearInterval(downloadTimer);
    } else {
        el.innerHTML = timeleft ;}
    timeleft -= 1;
}, 1000);

const detect = document.querySelector(".ads-wrapper");
const warning = document.querySelector("#download-loading");
let adClasses = ["ad", "ads", "adsbox", "doubleclick", "ad-placement", "ad-placeholder", "adbadge", "BannerAd"];
    for(let item of adClasses){
      detect.classList.add(item);
    }
var downloadwarning = ie_down_vars.admessage;
let getProperty = window.getComputedStyle(detect).getPropertyValue("display");
if(getProperty == "none"){
    warning.innerHTML = downloadwarning;
    warning.classList.add('adblock-warning');
};