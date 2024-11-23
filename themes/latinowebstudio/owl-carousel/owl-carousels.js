$('.product-gallery-carousel').owlCarousel({
    // center: true,
    loop: false,
    margin: 10,
    nav: true,
    dots: false,
    // autoHeight: false,
    // autoHeightClass: 'owl-height',
    // stagePadding:170,
    autoplay: false,
    autoplayTimeout: 2500,
    autoplaySpeed: 5000, // this seems to make it autoscroll
    autoplayHoverPause: false,
    animateIn: 'fadeIn',
    animateOut: 'fadeOut',
    // navText : ["<img src='/wp-content/uploads/2021/07/Arrow-Left-Blair-ITC.png' />","<img src='/wp-content/uploads/2021/07/Arrow-Right-Blair-ITC.png' />"],
    items:1,
    // responsive: {
    //     0: {
    //         items: 2,
    //         // slideBy: 2
    //     },
    //     600: {
    //         items: 3,
    //         // slideBy: 3
    //     },
    //     1000: {
    //         items: 4,
    //         // slideBy: 4
    //     }
    // }
});

$('.background-carousel').owlCarousel({
    // center: true,
    loop: true,
    margin: 0,
    nav: false,
    dots: false,
    // autoHeight: false,
    // autoHeightClass: 'owl-height',
    // stagePadding:170,
    autoplay: true,
    autoplayTimeout: 2500,
    autoplaySpeed: 5000, // this seems to make it autoscroll
    autoplayHoverPause: false,
    animateIn: 'fadeIn',
    animateOut: 'fadeOut',
    // navText : ["<img src='/wp-content/uploads/2021/07/Arrow-Left-Blair-ITC.png' />","<img src='/wp-content/uploads/2021/07/Arrow-Right-Blair-ITC.png' />"],
    items:1,
    // responsive: {
    //     0: {
    //         items: 2,
    //         // slideBy: 2
    //     },
    //     600: {
    //         items: 3,
    //         // slideBy: 3
    //     },
    //     1000: {
    //         items: 4,
    //         // slideBy: 4
    //     }
    // }
});

$('.carousel-slider').owlCarousel({
    // center: true,
    loop: true,
    margin: 0,
    nav: true,
    dots: true,
    autoplay: true,
    autoplayTimeout: 3500,
    autoplaySpeed: 5000, // this seems to make it autoscroll
    autoplayHoverPause: false,
    animateIn: 'fadeIn',
    animateOut: 'fadeOut',
    navText : ["<img src='https://latinowebstudio.com/wp-content/uploads/2024/10/Arrow-Left-White-ITC.png' />","<img src='https://latinowebstudio.com/wp-content/uploads/2024/10/Arrow-Right-White-ITC.png' />"],
    items:1,
    // responsive: {
    //     0: {
    //         items: 2,
    //         // slideBy: 2
    //     },
    //     600: {
    //         items: 3,
    //         // slideBy: 3
    //     },
    //     1000: {
    //         items: 4,
    //         // slideBy: 4
    //     }
    // }
});
$('.carousel-view-our-work').owlCarousel({
    // center: true,
    loop: false,
    margin: 20,
    nav: true,
    dots: false,
    autoplay: true,
    autoplayTimeout: 3500,
    autoplaySpeed: 1000, // this seems to make it autoscroll
    autoplayHoverPause: false,
    animateIn: 'fadeIn',
    animateOut: 'fadeOut',
    navText : ["<img src='https://latinowebstudio.com/wp-content/uploads/2024/10/Arrow-Circle-Black-Solid-Left.png' />","<img src='https://latinowebstudio.com/wp-content/uploads/2024/10/Arrow-Circle-Black-Solid-Right.png' />"],
    // items:1,
    responsive: {
        0: {
            items: 1,
            // slideBy: 2
        },
        600: {
            items: 2,
            // slideBy: 3
        },
        1000: {
            items: 3,
            // slideBy: 4
        }
    }
});
$('.testimonial-carousel').owlCarousel({
    // center: true,
    loop: true,
    margin: 40,
    nav: true,
    dots: false,
    autoHeight: false,
    // autoHeightClass: 'owl-height',
    // stagePadding:170,
    autoplay: true,
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
            items: 2,
            // slideBy: 3
        },
        1000: {
            items: 3,
            slideBy: 1
        }
    }
});