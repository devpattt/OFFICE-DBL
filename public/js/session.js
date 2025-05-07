let idleTime = 0;
let warningShown = false;
let countdownInterval;

function resetIdleTimer() {
    idleTime = 0;
    if (warningShown) {
        clearInterval(countdownInterval);
        document.getElementById('logout-warning').style.display = 'none';
        warningShown = false;
    }
}

window.onload = resetIdleTimer;
document.onmousemove = resetIdleTimer;
document.onkeydown = resetIdleTimer;
document.onclick = resetIdleTimer;
document.onscroll = resetIdleTimer;

setInterval(() => {
    idleTime++;

    if (idleTime === 1) {
        warningShown = true;
        let countdown = 10;
        document.getElementById('logout-warning').style.display = 'block';
        document.getElementById('countdown').innerText = countdown;

        countdownInterval = setInterval(() => {
            countdown--;
            document.getElementById('countdown').innerText = countdown;

            if (countdown <= 0) {
                clearInterval(countdownInterval);
                document.getElementById('logout-warning').style.display = 'none';
                document.getElementById('session-expired-modal').style.display = 'flex';
            }
        }, 1000);
    }
}, 60000); 

document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("logout-confirm-btn").addEventListener("click", function () {
        window.location.href = '../logout.php';
    });
})