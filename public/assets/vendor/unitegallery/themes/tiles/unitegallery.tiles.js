if (typeof g_ugFunctions != "undefined") g_ugFunctions.registerTheme("tiles"); else jQuery(document).ready(function() {
    g_ugFunctions.registerTheme("tiles");
});

function UGTheme_tiles() {
    var t = this;
    var g_gallery = new UniteGalleryMain(), g_objGallery, g_objects, g_objWrapper;
    var g_tiles = new UGTiles(), g_lightbox = new UGLightbox(), g_objPreloader, g_objTilesWrapper;
    var g_functions = new UGFunctions(), g_objTileDesign = new UGTileDesign();
    var g_options = {
        theme_enable_preloader: true,
        theme_preloading_height: 200,
        theme_preloader_vertpos: 100,
        theme_gallery_padding: 0,
        theme_appearance_order: "normal",
        theme_auto_open: null
    };
    var g_defaults = {
        gallery_width: "100%"
    };
    var g_temp = {
        showPreloader: false
    };
    function initTheme(gallery, customOptions) {
        g_gallery = gallery;
        g_options = jQuery.extend(g_options, g_defaults);
        g_options = jQuery.extend(g_options, customOptions);
        modifyOptions();
        g_gallery.setOptions(g_options);
        g_gallery.setFreestyleMode();
        g_objects = gallery.getObjects();
        g_objGallery = jQuery(gallery);
        g_objWrapper = g_objects.g_objWrapper;
        g_tiles.init(gallery, g_options);
        g_lightbox.init(gallery, g_options);
        g_objTileDesign = g_tiles.getObjTileDesign();
    }
    function modifyOptions() {
        if (g_options.theme_enable_preloader == true) g_temp.showPreloader = true;
        switch (g_options.theme_appearance_order) {
          default:
          case "normal":
            break;

          case "shuffle":
            g_gallery.shuffleItems();
            break;

          case "keep":
            g_options.tiles_keep_order = true;
            break;
        }
    }
    function setHtml() {
        g_objWrapper.addClass("ug-theme-tiles");
        g_objWrapper.append("<div class='ug-tiles-wrapper' style='position:relative'></div>");
        if (g_temp.showPreloader == true) {
            g_objWrapper.append("<div class='ug-tiles-preloader ug-preloader-trans'></div>");
            g_objPreloader = g_objWrapper.children(".ug-tiles-preloader");
            g_objPreloader.fadeTo(0, 0);
        }
        g_objTilesWrapper = g_objWrapper.children(".ug-tiles-wrapper");
        if (g_options.theme_gallery_padding) g_objWrapper.css({
            "padding-left": g_options.theme_gallery_padding + "px",
            "padding-right": g_options.theme_gallery_padding + "px"
        });
        g_tiles.setHtml(g_objTilesWrapper);
        g_lightbox.putHtml();
    }
    function actualRun() {
        if (g_objPreloader) {
            g_objPreloader.fadeTo(0, 1);
            g_objWrapper.height(g_options.theme_preloading_height);
            g_functions.placeElement(g_objPreloader, "center", g_options.theme_preloader_vertpos);
        }
        initEvents();
        g_tiles.run();
        g_lightbox.run();
    }
    function runTheme() {
        setHtml();
        actualRun();
    }
    function initThumbsPanel() {
        var objGallerySize = g_gallery.getSize();
        if (g_temp.isVertical == false) g_objPanel.setWidth(objGallerySize.width); else g_objPanel.setHeight(objGallerySize.height);
        g_objPanel.run();
    }
    function onTileClick(data, objTile) {
        objTile = jQuery(objTile);
        var objItem = g_objTileDesign.getItemByTile(objTile);
        var index = objItem.index;
        g_lightbox.open(index);
    }
    function onBeforeReqestItems() {
        g_objTilesWrapper.hide();
        if (g_objPreloader) {
            g_objPreloader.show();
            var preloaderSize = g_functions.getElementSize(g_objPreloader);
            var galleryHeight = preloaderSize.bottom + 30;
            g_objWrapper.height(galleryHeight);
        }
    }
    function onLightboxInit() {
        if (g_options.theme_auto_open !== null) {
            g_lightbox.open(g_options.theme_auto_open);
            g_options.theme_auto_open = null;
        }
    }
    function initEvents() {
        if (g_objPreloader) {
            g_gallery.onEvent(g_tiles.events.TILES_FIRST_PLACED, function() {
                g_objWrapper.height("auto");
                g_objPreloader.hide();
            });
        }
        jQuery(g_objTileDesign).on(g_objTileDesign.events.TILE_CLICK, onTileClick);
        g_objGallery.on(g_gallery.events.GALLERY_BEFORE_REQUEST_ITEMS, onBeforeReqestItems);
        jQuery(g_lightbox).on(g_lightbox.events.LIGHTBOX_INIT, onLightboxInit);
    }
    this.destroy = function() {
        jQuery(g_objTileDesign).off(g_objTileDesign.events.TILE_CLICK);
        g_gallery.destroyEvent(g_tiles.events.TILES_FIRST_PLACED);
        g_objGallery.off(g_gallery.events.GALLERY_BEFORE_REQUEST_ITEMS);
        jQuery(g_lightbox).off(g_lightbox.events.LIGHTBOX_INIT);
        g_tiles.destroy();
        g_lightbox.destroy();
    };
    this.run = function() {
        runTheme();
    };
    this.addItems = function() {
        g_tiles.runNewItems();
    };
    this.init = function(gallery, customOptions) {
        initTheme(gallery, customOptions);
    };
}
//# sourceMappingURL=unitegallery.tiles.js.map
