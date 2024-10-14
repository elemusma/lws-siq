$('.testimonial-carousel').owlCarousel({
    // center: true,
    loop: true,
    margin: 40,
    nav: false,
    dots: true,
    // autoHeight: false,
    // autoHeightClass: 'owl-height',
    // stagePadding:170,
    autoplay: false,
    autoplayTimeout: 3500,
    autoplaySpeed: 2000, // this seems to make it autoscroll
    autoplayHoverPause: false,
    animateIn: 'fadeIn',
    animateOut: 'fadeOut',
    navText : ["<img src='https://latinowebstudio.com/wp-content/uploads/2024/10/Arrow-within-Circle-Left-Gray.png' />","<img src='https://latinowebstudio.com/wp-content/uploads/2024/10/Arrow-within-Circle-Right-Gray.png' />"],
    responsive: {
        0: {
            items: 1,
            // slideBy: 2
        },
        600: {
            items: 1,
            // slideBy: 3
        },
        1000: {
            items: 2,
            slideBy: 1
        }
    }
});