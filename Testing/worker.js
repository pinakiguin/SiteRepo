
var i = 0;

function timedCount()
{
  //i = i + 1;
  var hours = new Date().getHours();
  var hours = (hours + 24 - 2) % 24;
  var mid = 'am';
  if (hours == 0) { //At 00 hours we need to show 12 am
    hours = 12;
  }
  else
  if (hours > 12) {
    hours = hours % 12;
    mid = 'pm';
  }
  var dt = new Date();
  var time = dt.getHours() + ":" + dt.getMinutes() + ":" + dt.getSeconds() + ":"
  mid;
          postMessage(time);
  setTimeout("timedCount()", 500);
}

timedCount();