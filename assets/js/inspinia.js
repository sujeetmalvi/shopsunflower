/*
 *
 *   INSPINIA - Responsive Admin Theme
 *   version 2.6
 *
 */

    var valid_alpha = /^[A-Za-z ]{3,80}$/;
    var valid_alphanumeric = /^[A-Za-z0-9. ]{1,80}$/;
    var valid_numeric = /^[0-9]{1,20}$/;
    var valid_amount_numeric = /^[0-9.]{1,20}$/;
    var valid_phone_numeric = /^[0-9+]{6,10}$/;
    var valid_mobile_numeric = /^[0-9+]{10,10}$/;
    var valid_emailid = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
    var valid_password = /^[A-Za-z0-9!@#$%^&*()_]{6,20}$/;
    var valid_datetime = /^(\d{2})\-(\d{2})\-(\d{4}) (\d{2}):(\d{2}):(\d{2})$/;
    var valid_date = /^(\d{2})\-(\d{2})\-(\d{4})$/;



$(document).ready(function () {


    // Add body-small class if window less than 768px
    if ($(this).width() < 769) {
        $('body').addClass('body-small')
    } else {
        $('body').removeClass('body-small')
    }

    // MetsiMenu
    $('#side-menu').metisMenu();

    // Collapse ibox function
    $('.collapse-link').on('click', function () {
        var ibox = $(this).closest('div.ibox');
        var button = $(this).find('i');
        var content = ibox.find('div.ibox-content');
        content.slideToggle(200);
        button.toggleClass('fa-chevron-up').toggleClass('fa-chevron-down');
        ibox.toggleClass('').toggleClass('border-bottom');
        setTimeout(function () {
            ibox.resize();
            ibox.find('[id^=map-]').resize();
        }, 50);
    });

    // Close ibox function
    $('.close-link').on('click', function () {
        var content = $(this).closest('div.ibox');
        content.remove();
    });

    // Fullscreen ibox function
    $('.fullscreen-link').on('click', function () {
        var ibox = $(this).closest('div.ibox');
        var button = $(this).find('i');
        $('body').toggleClass('fullscreen-ibox-mode');
        button.toggleClass('fa-expand').toggleClass('fa-compress');
        ibox.toggleClass('fullscreen');
        setTimeout(function () {
            $(window).trigger('resize');
        }, 100);
    });

    // Close menu in canvas mode
    $('.close-canvas-menu').on('click', function () {
        $("body").toggleClass("mini-navbar");
        SmoothlyMenu();
    });

    // Run menu of canvas
    $('body.canvas-menu .sidebar-collapse').slimScroll({
        height: '100%',
        railOpacity: 0.9
    });

    // Open close right sidebar
    $('.right-sidebar-toggle').on('click', function () {
        $('#right-sidebar').toggleClass('sidebar-open');
    });

    // Initialize slimscroll for right sidebar
    $('.sidebar-container').slimScroll({
        height: '100%',
        railOpacity: 0.4,
        wheelStep: 10
    });

    // Open close small chat
    $('.open-small-chat').on('click', function () {
        $(this).children().toggleClass('fa-comments').toggleClass('fa-remove');
        $('.small-chat-box').toggleClass('active');
    });

    // Initialize slimscroll for small chat
    $('.small-chat-box .content').slimScroll({
        height: '234px',
        railOpacity: 0.4
    });

    // Small todo handler
    $('.check-link').on('click', function () {
        var button = $(this).find('i');
        var label = $(this).next('span');
        button.toggleClass('fa-check-square').toggleClass('fa-square-o');
        label.toggleClass('todo-completed');
        return false;
    });

    // Append config box / Only for demo purpose
    // Uncomment on server mode to enable XHR calls
    // $.get("skin-config.html", function (data) {
    //     if (!$('body').hasClass('no-skin-config'))
    //         $('body').append(data);
    // });

    // Minimalize menu
    $('.navbar-minimalize').on('click', function () {
        $("body").toggleClass("mini-navbar");
        SmoothlyMenu();

    });

    // Tooltips demo
    $('.tooltip-demo').tooltip({
        selector: "[data-toggle=tooltip]",
        container: "body"
    });


    // Full height of sidebar
    function fix_height() {
        var heightWithoutNavbar = $("body > #wrapper").height() - 61;
        $(".sidebard-panel").css("min-height", heightWithoutNavbar + "px");

        var navbarHeigh = $('nav.navbar-default').height();
        var wrapperHeigh = $('#page-wrapper').height();

        if (navbarHeigh > wrapperHeigh) {
            $('#page-wrapper').css("min-height", navbarHeigh + "px");
        }

        if (navbarHeigh < wrapperHeigh) {
            $('#page-wrapper').css("min-height", $(window).height() + "px");
        }

        if ($('body').hasClass('fixed-nav')) {
            if (navbarHeigh > wrapperHeigh) {
                $('#page-wrapper').css("min-height", navbarHeigh - 60 + "px");
            } else {
                $('#page-wrapper').css("min-height", $(window).height() - 60 + "px");
            }
        }

    }

    fix_height();

    // Fixed Sidebar
    $(window).bind("load", function () {
        if ($("body").hasClass('fixed-sidebar')) {
            $('.sidebar-collapse').slimScroll({
                height: '100%',
                railOpacity: 0.9
            });
        }
    });

    // Move right sidebar top after scroll
    $(window).scroll(function () {
        if ($(window).scrollTop() > 0 && !$('body').hasClass('fixed-nav')) {
            $('#right-sidebar').addClass('sidebar-top');
        } else {
            $('#right-sidebar').removeClass('sidebar-top');
        }
    });

    $(window).bind("load resize scroll", function () {
        if (!$("body").hasClass('body-small')) {
            fix_height();
        }
    });

    $("[data-toggle=popover]")
        .popover();

    // Add slimscroll to element
    $('.full-height-scroll').slimscroll({
        height: '100%'
    })
});


// Minimalize menu when screen is less than 768px
$(window).bind("resize", function () {
    if ($(this).width() < 769) {
        $('body').addClass('body-small')
    } else {
        $('body').removeClass('body-small')
    }
});

// Local Storage functions
// Set proper body class and plugins based on user configuration
$(document).ready(function () {
    if (localStorageSupport()) {

        var collapse = localStorage.getItem("collapse_menu");
        var fixedsidebar = localStorage.getItem("fixedsidebar");
        var fixednavbar = localStorage.getItem("fixednavbar");
        var boxedlayout = localStorage.getItem("boxedlayout");
        var fixedfooter = localStorage.getItem("fixedfooter");

        var body = $('body');

        if (fixedsidebar == 'on') {
            body.addClass('fixed-sidebar');
            $('.sidebar-collapse').slimScroll({
                height: '100%',
                railOpacity: 0.9
            });
        }

        if (collapse == 'on') {
            if (body.hasClass('fixed-sidebar')) {
                if (!body.hasClass('body-small')) {
                    body.addClass('mini-navbar');
                }
            } else {
                if (!body.hasClass('body-small')) {
                    body.addClass('mini-navbar');
                }

            }
        }

        if (fixednavbar == 'on') {
            $(".navbar-static-top").removeClass('navbar-static-top').addClass('navbar-fixed-top');
            body.addClass('fixed-nav');
        }

        if (boxedlayout == 'on') {
            body.addClass('boxed-layout');
        }

        if (fixedfooter == 'on') {
            $(".footer").addClass('fixed');
        }
    }
});

// check if browser support HTML5 local storage
function localStorageSupport() {
    return (('localStorage' in window) && window['localStorage'] !== null)
}

// For demo purpose - animation css script
function animationHover(element, animation) {
    element = $(element);
    element.hover(
        function () {
            element.addClass('animated ' + animation);
        },
        function () {
            //wait for animation to finish before removing classes
            window.setTimeout(function () {
                element.removeClass('animated ' + animation);
            }, 2000);
        });
}

function SmoothlyMenu() {
    if (!$('body').hasClass('mini-navbar') || $('body').hasClass('body-small')) {
        // Hide menu in order to smoothly turn on when maximize menu
        $('#side-menu').hide();
        // For smoothly turn on menu
        setTimeout(
            function () {
                $('#side-menu').fadeIn(400);
            }, 200);
    } else if ($('body').hasClass('fixed-sidebar')) {
        $('#side-menu').hide();
        setTimeout(
            function () {
                $('#side-menu').fadeIn(400);
            }, 100);
    } else {
        // Remove all inline style from jquery fadeIn function to reset menu state
        $('#side-menu').removeAttr('style');
    }
}

// Dragable panels
function WinMove() {
    var element = "[class*=col]";
    var handle = ".ibox-title";
    var connect = "[class*=col]";
    $(element).sortable(
        {
            handle: handle,
            connectWith: connect,
            tolerance: 'pointer',
            forcePlaceholderSize: true,
            opacity: 0.8
        })
        .disableSelection();
}

//********** AUTO COMPLETE JS *************** //

// $( function() {
//     $.widget( "custom.combobox", {
//       _create: function() {
//         this.wrapper = $( "<span>" )
//           .addClass( "custom-combobox" )
//           .insertAfter( this.element );
 
//         this.element.hide();
//         this._createAutocomplete();
//         this._createShowAllButton();
//       },
 
//       _createAutocomplete: function() {
//         var selected = this.element.children( ":selected" ),
//           value = selected.val() ? selected.text() : "";
 
//         this.input = $( "<input>" )
//           .appendTo( this.wrapper )
//           .val( value )
//           .attr( "title", "" )
//           .addClass( "custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left" )
//           .autocomplete({
//             delay: 0,
//             minLength: 0,
//             source: $.proxy( this, "_source" )
//           })
//           .tooltip({
//             classes: {
//               "ui-tooltip": "ui-state-highlight"
//             }
//           });
 
//         this._on( this.input, {
//           autocompleteselect: function( event, ui ) {
//             ui.item.option.selected = true;
//             this._trigger( "select", event, {
//               item: ui.item.option
//             });
//           },
 
//           autocompletechange: "_removeIfInvalid"
//         });
//         console.log(item);
//       },
 
//       _createShowAllButton: function() {
//         var input = this.input,
//           wasOpen = false
 
//         $( "<a>" )
//           .attr( "tabIndex", -1 )
//           .attr( "title", "Show All Items" )
//           .attr( "height", "" )
//           .tooltip()
//           .appendTo( this.wrapper )
//           .button({
//             icons: {
//               primary: "ui-icon-triangle-1-s"
//             },
//             text: "false"
//           })
//           .removeClass( "ui-corner-all" )
//           .addClass( "custom-combobox-toggle ui-corner-right" )
//           .on( "mousedown", function() {
//             wasOpen = input.autocomplete( "widget" ).is( ":visible" );
//           })
//           .on( "click", function() {
//             input.trigger( "focus" );
 
//             // Close if already visible
//             if ( wasOpen ) {
//               return;
//             }
 
//             // Pass empty string as value to search for, displaying all results
//             input.autocomplete( "search", "" );
//           });
//       },
 
//       _source: function( request, response ) {
//         var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
//         response( this.element.children( "option" ).map(function() {
//           var text = $( this ).text();
//           if ( this.value && ( !request.term || matcher.test(text) ) )
//             return {
//               label: text,
//               value: text,
//               option: this
//             };
//         }) );
//       },
 
//       _removeIfInvalid: function( event, ui ) {
 
//         // Selected an item, nothing to do
//         if ( ui.item ) {
//           return;
//         }
 
//         // Search for a match (case-insensitive)
//         var value = this.input.val(),
//           valueLowerCase = value.toLowerCase(),
//           valid = false;
//         this.element.children( "option" ).each(function() {
//           if ( $( this ).text().toLowerCase() === valueLowerCase ) {
//             this.selected = valid = true;
//             return false;
//           }
//         });
 
//         // Found a match, nothing to do
//         if ( valid ) {
//           return;
//         }
 
//         // Remove invalid value
//         this.input
//           .val( "" )
//           .attr( "title", value + " didn't match any item" )
//           .tooltip( "open" );
//         this.element.val( "" );
//         this._delay(function() {
//           this.input.tooltip( "close" ).attr( "title", "" );
//         }, 2500 );
//         this.input.autocomplete( "instance" ).term = "";
//       },
 
//       _destroy: function() {
//         this.wrapper.remove();
//         this.element.show();
//       }
//     });
 
//     $( "#combobox" ).combobox();
//     $( "#toggle" ).on( "click", function() {
//       $( "#combobox" ).toggle();
//     });
//   } );

/************ AUTO COMPLETE JS ****************/



function deleterow(id,rowid,url){
    var waaskey = $("#waaskey").val();
        alertify.confirm("Do you want to delete ?", function (e) {
        if (e) {
           $('#'+rowid).hide('slow');
            $.post(url, { id:id,waaskey:waaskey },
              function(responsedata,status){
                responsedata = responsedata.trim();
                var response = JSON.parse(responsedata);

                if (response.status== true) {
                  alertify.alert(response.msg);
                  window.location.reload();
                }else{
                  alertify.alert(response.msg);
                }
              });
        } else {
          return false;    
        }
      });
      return false;
}