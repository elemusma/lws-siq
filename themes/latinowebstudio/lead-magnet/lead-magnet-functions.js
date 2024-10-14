leadCustomWidgetBtnOpen.addEventListener('click',function() {
    modal.classList.add('active');
    leadCustomWidget.classList.add('inactive');
});
leadCustomBtnCircle.addEventListener('click',function() {
    leadCustomBtnCircle.classList.add('inactive');
});
leadCustomBtnClose.addEventListener('click',function() {
    leadCustomWidget.classList.add('inactive');
});
closeCustomBtn.addEventListener('click',function() {
    modal.classList.remove('active');
    leadCustomWidget.classList.remove('inactive');
});

closeCustomNoThanks.addEventListener('click', function() {
    closeLeadMagnetModalSimple();
    leadCustomWidget.classList.remove('inactive');
});
leadCustomBtn.addEventListener('click', function() {
    showLeadMagnetModalSimple();
});

function closeLeadMagnetModalSimple() {
    // closeLeadMagnetModalSimple();
    modal.classList.remove('active'); // or use your desired method to show the modal
}
function showLeadMagnetModalSimple() {
    // showLeadMagnetModalSimple();
    modal.classList.add('active'); // or use your desired method to show the modal
}


// Function to show the modal
function showLeadMagnetModal() {
    // var modal = document.getElementById('leadMagnetModal');
    if (modal && !modalShown) {
        // modal.style.display = 'flex';
        modal.classList.add('active');
        modalShown = true; // Ensure it only shows once
        localStorage.setItem('leadMagnetModalLastShown', new Date().getTime());
    }
}

// // Check if the modal should be shown
// function checkModalDisplay() {
//     const lastShown = localStorage.getItem('leadMagnetModalLastShown');
//     const now = new Date().getTime();

//     // If lastShown is not set or it's been more than 60 days (60 * 24 * 60 * 60 * 1000 milliseconds)
//     if (!lastShown || (now - lastShown) > 60 * 24 * 60 * 60 * 1000) {
        
//         // Timeout to show modal after 15 seconds
//         const timeoutId = setTimeout(function() {
//             if (!modalShown) {
//                 showLeadMagnetModal();
//             }
//         }, 10000);
        
//         // Scroll listener to show modal if user scrolls 50% of the page
//         window.addEventListener('scroll', function() {
//             if (!modalShown) {
//                 var scrollPosition = window.scrollY || window.pageYOffset;
//                 var windowHeight = document.documentElement.scrollHeight - window.innerHeight;
//                 var scrollPercentage = (scrollPosition / windowHeight) * 100;

//                 if (scrollPercentage >= 50) {
//                     clearTimeout(timeoutId); // Cancel the 15-second timeout if the scroll triggers first
//                     showLeadMagnetModal();
//                 }
//             }
//         });

//         // Exit intent listener if neither 15-second timeout nor scroll has triggered it
//         document.addEventListener('mouseout', function(event) {
//             // If the modal hasn't been shown and the mouse is leaving towards the top (exit intent)
//             if (!modalShown && event.clientY < 0) {
//                 clearTimeout(timeoutId); // Cancel the 15-second timeout
//                 showLeadMagnetModal();
//             }
//         });
//     }
// }

// // Event listener for closing the modal
// function closeModal() {
//     // const modal = document.getElementById('leadMagnetModal');
//     if (modal) {
//         // modal.style.display = 'none';
//         closeLeadMagnetModalSimple();
//         // Store the current time as lastShown
//         localStorage.setItem('leadMagnetModalLastShown', new Date().getTime());
//         modalShown = true; // Ensure it doesn't show again during the session
//     }
// }

// // Close buttons event listener
// var closeBtnsCustom = document.getElementsByClassName("close-custom");
// Array.from(closeBtnsCustom).forEach(button => {
//     // alert('hellooo');
//     button.onclick = closeModal;
// });


// // Check modal display on page load
// window.onload = checkModalDisplay;
