document.addEventListener('DOMContentLoaded', function() {
    M.AutoInit();
    document.documentElement.classList.remove('unload');
}, false);

function goBack() {
    window.history.back();
}

function toEpisode(e) {
    let stateObj = { foo: "bar" }
    window.history.replaceState(stateObj, '', e)
    window.location.reload()
}