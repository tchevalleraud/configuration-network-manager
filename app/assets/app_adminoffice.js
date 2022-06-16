import 'bootstrap';
import * as bootstrap from 'bootstrap';

var securityIdle;
var securityIdleShow = false;
var securityIdleReload = false;
var securityIdleTimer = 0;
var toastSecurityIdle = document.getElementById('securityIdle')
var toastSecurityIdleRemaining = document.getElementById('securityIdleRemaining')

function checkSecurityIdle(){
    securityIdleTimer++;
    if(securityIdleTimer >= (toastSecurityIdle.dataset.idle - 60)){
        if(securityIdleShow == false){
            var toast = new bootstrap.Toast(toastSecurityIdle, {
                'delay' : 60000
            })
            toast.show()
            securityIdleShow = true;
        }
    }

    if(securityIdleTimer > toastSecurityIdle.dataset.idle){
        if(securityIdleReload == false){
            return document.location.reload();
        }
    }

    toastSecurityIdleRemaining.innerHTML = toastSecurityIdle.dataset.idle - securityIdleTimer;

    securityIdle = setTimeout(checkSecurityIdle, 1000);
}

checkSecurityIdle();