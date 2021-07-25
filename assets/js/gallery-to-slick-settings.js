jQuery(document).ready(function($) {

    //Slick Slider settings
    $('.gtss-gallery-img').slick({

         arrows: true,
         dots: true,
         slidesToShow: 3,
         slidesToScroll: 3,
         lazyLoad: 'ondemand',
         responsive: [
             {
                 breakpoint: 992,
                 settings: {
                     slidesToShow: 2,
                     slidesToScroll: 2,

                 }
             },
             {
                 breakpoint: 768,
                 settings: {
                     slidesToShow: 1,
                     slidesToScroll: 1,
                 }
             }
         ]

     });
 
 });
