var playing = false;

function toggleMusic() {
    var x = document.getElementById("audio"); 
    if (!playing) x.play(); 
    else  x.pause();

    playing = !playing;
}

function playSound(url) {
    const audio = new Audio(url);
    audio.play();
}
function playClick() {
    playSound("audio/click1.mp3");
}
function playHayya() {
    playSound("audio/hayyahayya.mp3");
}