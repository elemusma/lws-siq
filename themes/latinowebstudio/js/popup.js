// Get all buttons that open modals
var modalBtnsCustom = document.getElementsByClassName("openModalBtnCustom");

// Add click event listener for modal buttons
Array.from(modalBtnsCustom).forEach(button => {
  button.onclick = function() {
    var modalId = this.getAttribute('data-modal-id');
    var modal = document.getElementById(modalId);
    modal.style.display = "flex";
    // modal.classList.add('active');
  }
});

// Get all elements with class="close-custom" (close buttons)
var closeBtnsCustom = document.getElementsByClassName("close-custom");

// Function to close modals
function closeModal(modal) {
  modal.style.display = "none";
}

// Add click event listener for close buttons
Array.from(closeBtnsCustom).forEach(button => {
  button.onclick = function() {
    var modal = this.closest('.modal-custom');
    closeModal(modal);
  }
});


// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target.classList.contains('modal-custom')) {
    event.target.style.display = "none";
  }
}







// Get all buttons that open modals
var modalBtns = document.getElementsByClassName("openModalBtn");

// Loop through all buttons and add click event listeners
for (var i = 0; i < modalBtns.length; i++) {
  modalBtns[i].onclick = function() {
    var modalId = this.getAttribute('data-modal-id');
    var modal = document.getElementById(modalId);
    // modal.style.display = "block";
    console.log(modal);
    modal.classList.add('active');
  }
}

// Get all elements with class="close" (close buttons)
var closeBtns = document.getElementsByClassName("close");

// Loop through all close buttons and add click event listeners
for (var i = 0; i < closeBtns.length; i++) {
  closeBtns[i].onclick = function() {
    var modal = this.parentElement.parentElement;
    // modal.style.display = "none";
    // modal.style.opacity = 0;
    console.log(modal);
    modal.classList.remove('active');
  }
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  
  console.log(event.target);
  if (event.target.tagName === 'A') {
    // Your code here for handling clicks on <a> elements
    // console.log('hello');
    document.querySelector('#mobileMenu').classList.remove('active');
}
  if (event.target.classList.contains('modal') || event.target.classList.contains('modal-content-menu')) {
    event.target.classList.remove('active');
    document.querySelector('#mobileMenu').classList.remove('active');
    
  }
  // if () {
  //   event.target.classList.remove('active');
  // }
}