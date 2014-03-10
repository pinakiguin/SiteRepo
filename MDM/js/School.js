/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(function() {

  $('#Msg').html('Loaded Successfully');
//  var m = new Date();
  $('#startWorker').click(function()
  {
    var m;
    startWorker(m);
  });
  $('#stopWorker').click(function()
  {
    var m;
    stopWorker(m);
  });


});


function startWorker(m)

{
  var w = m;

  if (typeof (Worker) !== "undefined")

  {
    if (typeof (w) === "undefined")
    {
      w = new Worker("School.js");
    }
    w.onmessage = function(event) {
      document.getElementById("result").innerHTML = event.data;
    };
  }
  else
  {
    document.getElementById("result").innerHTML = "Sorry, your browser does not support Web Workers...";
  }
}

function stopWorker(m)
{
  var w = m;
  w.terminate();
}