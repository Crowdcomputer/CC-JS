//This is the broker, check if it's inside Turk or not to decide what library has to be load.

function gup(name) {
    var regexS = "[\\?&]" + name + "=([^&#]*)";
    var regex = new RegExp(regexS);
    var tmpURL = window.location.href;
    var results = regex.exec(tmpURL);
    if (results == null) return null;
    return results[1];
}

var turk=gup("turkSubmitTo");
console.log("turk + " + turk)
if (turk == undefined)
	$.getScript('https://raw.github.com/esseti/CC-JS/master/croco4CC.js');

else
	$.getScript('https://raw.github.com/esseti/CC-JS/master/croco4TurkAndCC.js');

