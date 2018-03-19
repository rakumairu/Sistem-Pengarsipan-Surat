// Show the failed modal
$(window).on('load',function(){
   $('#failed').modal('show');
});

// Show the success modal
$(window).on('load',function(){
   $('#success').modal('show');
});

// Apply the data table
$(document).ready(function(){
  $('#table-utama').DataTable();
});

// Toggle Nav Button
function navButton() {
  var nav = document.getElementById('sideNav');
  var main = document.getElementById('main');
  var hamburger = document.getElementById('hamburger');
  nav.classList.toggle('close-nav');
  main.classList.toggle('close-main');
  hamburger.classList.toggle('open');
}
