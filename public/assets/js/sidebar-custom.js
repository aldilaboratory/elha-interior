/* Custom JavaScript untuk sidebar dengan sub menu yang selalu terlihat */

$(document).ready(function () {
    "use strict";

    var $sidebarToggle = $(".menu-toggle");
    var $sidebarLeft = $(".sidebar-left");
    var $sidebarLeftSecondary = $(".sidebar-left-secondary");
    var $mainContentWrap = $(".main-content-wrap");
    var $sideNavItem = $(".nav-item");

    function openSidebar() {
        $sidebarLeft.addClass("open");
        $mainContentWrap.addClass("sidenav-open");
    }

    function closeSidebar() {
        $sidebarLeft.removeClass("open");
        $mainContentWrap.removeClass("sidenav-open");
    }

    function initLayout() {
        // Tampilkan semua sub menu secara default
        $sidebarLeftSecondary.find(".childNav").show();
        
        // Tambahkan class open ke sidebar secondary
        $sidebarLeftSecondary.addClass("open");
        
        // Set active menu berdasarkan route saat ini
        $sideNavItem.each(function (index) {
            var $item = $(this);
            if ($item.hasClass("active")) {
                var dataItem = $item.data("item");
                // Highlight sub menu yang sesuai
                if (dataItem) {
                    $sidebarLeftSecondary.find("[data-parent=\"" + dataItem + "\"] li.nav-item a").each(function() {
                        var href = $(this).attr('href');
                        if (href && window.location.href.indexOf(href) > -1) {
                            $(this).addClass('active');
                        }
                    });
                }
            }
        });

        // Untuk mobile, tutup sidebar secara default
        if (gullUtils.isMobile()) {
            closeSidebar();
        }
    }

    // Handle window resize
    $(window).on("resize", function (event) {
        if (gullUtils.isMobile()) {
            closeSidebar();
        }
    });

    // Handle menu toggle click
    $sidebarToggle.on("click", function (event) {
        var isSidebarOpen = $sidebarLeft.hasClass("open");
        
        if (isSidebarOpen) {
            closeSidebar();
        } else {
            openSidebar();
        }
    });

    // Handle main menu item click
    $sidebarLeft.find(".nav-item").on("click", function (e) {
        var $navItem = $(this);
        var dataItem = $navItem.data("item");
        
        // Jika item memiliki sub menu, highlight item tersebut
        if (dataItem) {
            e.preventDefault();
            
            // Remove active class from all nav items
            $sidebarLeft.find(".nav-item").removeClass("active");
            
            // Add active class to clicked item
            $navItem.addClass("active");
            
            // Highlight corresponding sub menu items
            $sidebarLeftSecondary.find(".childNav li.nav-item a").removeClass('active');
            $sidebarLeftSecondary.find("[data-parent=\"" + dataItem + "\"] li.nav-item a").first().addClass('active');
        }
    });

    // Handle sub menu item click
    $sidebarLeftSecondary.find(".childNav li.nav-item a").on("click", function(e) {
        // Remove active class from all sub menu items
        $sidebarLeftSecondary.find(".childNav li.nav-item a").removeClass('active');
        
        // Add active class to clicked item
        $(this).addClass('active');
    });

    // Initialize layout
    initLayout();

    // Override original sidebar script behavior
    // Remove hover events from original script
    $sidebarLeft.find(".nav-item").off("mouseenter");
    
    // Prevent original overlay click behavior
    $(".sidebar-overlay").off("click");
});

// Function to set active menu programmatically
function setActiveMenu(parentMenu, subMenu) {
    // Remove all active classes
    $(".sidebar-left .nav-item").removeClass("active");
    $(".sidebar-left-secondary .childNav li.nav-item a").removeClass("active");
    
    // Set parent menu active
    $(".sidebar-left .nav-item[data-item='" + parentMenu + "']").addClass("active");
    
    // Set sub menu active
    if (subMenu) {
        $(".sidebar-left-secondary [data-parent='" + parentMenu + "'] li.nav-item a[href*='" + subMenu + "']").addClass("active");
    }
}

// Export function for global use
window.setActiveMenu = setActiveMenu;