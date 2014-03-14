
var i = 0;

function timedCount()
{
  var hours = new Date().getHours();
  var Minute = new Date().getMinutes();
  if (Minute < 10)
    Minute = "0" + Minute;
  var mid = 'am';
  if (hours >= 12)
    mid = 'pm';
  if (hours > 12)
    hours = hours % 12;
  var dt = new Date();
  var time = hours + ":" + Minute + ":" + dt.getSeconds() + ":" + mid;
  postMessage(time);
  setTimeout("timedCount()", 500);
}

timedCount();