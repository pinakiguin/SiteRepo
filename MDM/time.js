
var i = 0;

function timedCount()
{
  var hours = new Date().getHours();
  var mid = 'am';
  if (hours >= 12)
    mid = 'pm';
  if (hours > 12)
    hours = hours % 12;
  var dt = new Date();
  var time = dt.getHours() + ":" + dt.getMinutes() + ":" + dt.getSeconds() + ":" + mid;
  postMessage(time);
  setTimeout("timedCount()", 500);
}

timedCount();