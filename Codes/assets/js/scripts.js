document.addEventListener("DOMContentLoaded", function () {
    // Get all the book buttons
    var bookButtons = document.querySelectorAll(".book-btn");
  
    // Attach a click event listener to each book button
    bookButtons.forEach(function (button) {
      button.addEventListener("click", function () {
        // Get the dayCounter value associated with the button's parent cell
        var dayCounter = button.parentNode.dataset.dayCounter;
        
        // Handle the booking logic here
        alert("Booking appointment for day: " + dayCounter);
      });
    });
  });
  