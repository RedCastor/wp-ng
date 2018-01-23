if (typeof g_ugFunctions != "undefined") g_ugFunctions.registerTheme("carousel"); else jQuery(document).ready(function() {
    g_ugFunctions.registerTheme("carousel");
});

function UGTheme_carousel() {
    var t = this;
    var g_gallery = new UniteGalleryMain(), g_objGallery, g_objects, g_objWrapper;
    var g_lightbox = new UGLightbox(), g_carousel = new UGCarousel();
    var g_functions = new UGFunctions(), g_objTileDesign = new UGTileDesign();
    var g_objNavWrapper, g_objButtonLeft, g_objButtonRight, g_objButtonPlay, g_objPreloader;
    var g_apiDefine = new UG_API();
    var g_options = {
        theme_gallery_padding: 0,
        theme_carousel_align: "center",
        theme_carousel_offset: 0,
        theme_enable_navigation: true,
        theme_navigation_position: "bottom",
        theme_navigation_enable_play: true,
        theme_navigation_align: "center",
        theme_navigation_offset_hor: 0,
        theme_navigation_margin: 20,
        theme_space_between_arrows: 5
    };
    var g_defaults = {
        gallery_width: "100%",
        tile_width: 160,
        tile_height: 160,
        tile_enable_border: true,
        tile_enable_outline: true,
        carousel_vertical_scroll_ondrag: true
    };
    var g_temp = {};
    function initTheme(gallery, customOptions) {
        g_gallery = gallery;
        g_options = jQuery.extend(g_options, g_defaults);
        g_options = jQuery.extend(g_options, customOptions);
        g_gallery.setOptions(g_options);
        g_gallery.setFreestyleMode();
        g_objects = gallery.getObjects();
        g_objGallery = jQuery(gallery);
        g_objWrapper = g_objects.g_objWrapper;
        g_lightbox.init(gallery, g_options);
        g_carousel.init(gallery, g_options);
        g_objTileDesign = g_carousel.getObjTileDesign();
    }
    function setHtml() {
        g_objWrapper.addClass("ug-theme-carousel");
        g_carousel.setHtml(g_objWrapper);
        if (g_options.theme_enable_navigation == true) {
            var htmlAdd = "<div class='ug-tile-navigation-wrapper' style='position:absolute'>";
            htmlAdd += "<div class='ug-button-tile-navigation ug-button-tile-left'></div>";
            if (g_options.theme_navigation_enable_play == true) htmlAdd += "<div class='ug-button-tile-navigation ug-button-tile-play'></div>";
            htmlAdd += "<div class='ug-button-tile-navigation ug-button-tile-right'></div>";
            htmlAdd += "</div>";
            g_objWrapper.append(htmlAdd);
            g_objNavWrapper = g_objWrapper.children(".ug-tile-navigation-wrapper");
            g_objButtonLeft = g_objNavWrapper.children(".ug-button-tile-left");
            g_objButtonRight = g_objNavWrapper.children(".ug-button-tile-right");
            g_objButtonLeft.css("margin-right", g_options.theme_space_between_arrows + "px");
            if (g_options.theme_navigation_enable_play == true) {
                g_objButtonPlay = g_objNavWrapper.children(".ug-button-tile-play");
                g_objButtonPlay.css("margin-right", g_options.theme_space_between_arrows + "px");
            }
        }
        g_lightbox.putHtml();
        g_objWrapper.append("<div class='ug-tiles-preloader ug-preloader-trans'></div>");
        g_objPreloader = g_objWrapper.children(".ug-tiles-preloader");
        g_objPreloader.fadeTo(0, 0);
    }
    function getGalleryWidth() {
        var galleryWidth = g_gallery.getSize().width;
        galleryWidth -= g_options.theme_gallery_padding * 2;
        return galleryWidth;
    }
    function getEstimatedHeight() {
        var height = g_carousel.getEstimatedHeight();
        if (g_objNavWrapper) {
            var navHeight = g_objNavWrapper.height();
            height += navHeight + g_options.theme_navigation_margin;
        }
        return height;
    }
    function actualRun() {
        var galleryHeight = getEstimatedHeight();
        g_objWrapper.height(galleryHeight);
        var galleryWidth = getGalleryWidth();
        initEvents();
        g_carousel.setMaxWidth(galleryWidth);
        g_carousel.run();
        g_lightbox.run();
        positionElements();
    }
    function runTheme() {
        setHtml();
        actualRun();
    }
    function positionElements() {
        var carouselElement = g_carousel.getElement();
        var sizeCar = g_functions.getElementSize(carouselElement);
        var navHeight = 0;
        if (g_objNavWrapper) {
            var sizeNav = g_functions.getElementSize(g_objNavWrapper);
            navHeight = sizeNav.height;
        }
        var galleryHeight = sizeCar.height;
        if (navHeight > 0) galleryHeight += g_options.theme_navigation_margin + navHeight;
        var carouselTop = 0;
        if (g_objNavWrapper) {
            var navTop = sizeCar.height + g_options.theme_navigation_margin;
            if (g_options.theme_navigation_position == "top") {
                carouselTop = sizeNav.height + g_options.theme_navigation_margin;
                navTop = 0;
            }
        }
        g_functions.placeElement(carouselElement, g_options.theme_carousel_align, carouselTop, g_options.theme_carousel_offset, 0);
        var sizeCar = g_functions.getElementSize(carouselElement);
        if (g_objNavWrapper) {
            var navX = sizeCar.left + g_functions.getElementRelativePos(g_objNavWrapper, g_options.theme_navigation_align, g_options.theme_navigation_offset_hor, carouselElement);
            g_functions.placeElement(g_objNavWrapper, navX, navTop);
        }
        g_objWrapper.height(galleryHeight);
        g_functions.placeElement(g_objPreloader, "center", 50);
    }
    function onTileClick(data, objTile) {
        objTile = jQuery(objTile);
        var objItem = g_objTileDesign.getItemByTile(objTile);
        var index = objItem.index;
        g_lightbox.open(index);
    }
    function onSizeChange() {
        var galleryWidth = getGalleryWidth();
        g_carousel.setMaxWidth(galleryWidth);
        g_carousel.run();
        positionElements();
    }
    function onBeforeReqestItems() {
        g_carousel.stopAutoplay();
        g_carousel.getElement().hide();
        if (g_objNavWrapper) g_objNavWrapper.hide();
        g_objPreloader.fadeTo(0, 1);
    }
    function initAPIFunctions(event, api) {
        api.carouselStartAutoplay = function() {
            g_carousel.startAutoplay();
        };
        api.carouselStopAutoplay = function() {
            g_carousel.stopAutoplay();
        };
        api.carouselPause = function() {
            g_carousel.pauseAutoplay();
        };
        api.carouselUnpause = function() {
            g_carousel.unpauseAutoplay();
        };
        api.scrollLeft = function(numTiles) {
            g_carousel.scrollLeft(numTiles);
        };
        api.scrollRight = function(numTiles) {
            g_carousel.scrollRight(numTiles);
        };
    }
    function initEvents() {
        if (g_objNavWrapper) {
            g_carousel.setScrollLeftButton(g_objButtonRight);
            g_carousel.setScrollRightButton(g_objButtonLeft);
            if (g_objButtonPlay) g_carousel.setPlayPauseButton(g_objButtonPlay);
        }
        g_objGallery.on(g_gallery.events.SIZE_CHANGE, onSizeChange);
        g_objGallery.on(g_gallery.events.GALLERY_BEFORE_REQUEST_ITEMS, onBeforeReqestItems);
        jQuery(g_objTileDesign).on(g_objTileDesign.events.TILE_CLICK, onTileClick);
        g_objGallery.on(g_apiDefine.events.API_INIT_FUNCTIONS, initAPIFunctions);
    }
    this.destroy = function() {
        if (g_objNavWrapper) {
            g_functions.destroyButton(g_objButtonRight);
            g_functions.destroyButton(g_objButtonLeft);
            if (g_objButtonPlay) g_functions.destroyButton(g_objButtonPlay);
        }
        g_objGallery.off(g_gallery.events.SIZE_CHANGE);
        jQuery(g_objTileDesign).off(g_objTileDesign.events.TILE_CLICK);
        g_objGallery.off(g_gallery.events.GALLERY_BEFORE_REQUEST_ITEMS);
        g_carousel.destroy();
        g_lightbox.destroy();
    };
    this.run = function() {
        runTheme();
    };
    this.init = function(gallery, customOptions) {
        initTheme(gallery, customOptions);
    };
}
//# sourceMappingURL=unitegallery.carousel.js.map
