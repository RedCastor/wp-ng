if (typeof g_ugFunctions != "undefined") g_ugFunctions.registerTheme("sliderfull"); else jQuery(document).ready(function() {
    g_ugFunctions.registerTheme("sliderfull");
});

function UGTheme_sliderfull() {
    var t = this;
    var g_gallery = new UniteGalleryMain(), g_objGallery, g_objects, g_objWrapper;
    var g_objThumbs, g_objSlider;
    var g_lightbox = new UGLightbox();
    var g_functions = new UGFunctions();
    var g_options = {};
    var g_defaults = {
        gallery_autoplay: true,
        slider_scale_mode: "fill",
        slider_controls_always_on: true,
        slider_enable_text_panel: false,
        slider_controls_appear_ontap: true,
        slider_enable_bullets: true,
        slider_enable_arrows: true,
        slider_enable_play_button: false,
        slider_enable_fullscreen_button: false,
        slider_enable_zoom_panel: false,
        slider_vertical_scroll_ondrag: true
    };
    this.init = function(gallery, customOptions) {
        g_gallery = gallery;
        g_options = jQuery.extend(g_options, g_defaults);
        g_options = jQuery.extend(g_options, customOptions);
        g_gallery.setOptions(g_options);
        g_gallery.initSlider(g_options);
        g_objects = gallery.getObjects();
        g_objGallery = jQuery(gallery);
        g_objWrapper = g_objects.g_objWrapper;
        g_lightbox.init(gallery, g_options);
        g_objSlider = g_objects.g_objSlider;
    };
    function setHtml() {
        g_objWrapper.addClass("ug-theme-slider");
        if (g_objSlider) {
            g_objSlider.setHtml();
            g_lightbox.putHtml();
        }
    }
    function placeSlider() {
        var sliderHeight = g_gallery.getHeight();
        var sliderWidth = g_gallery.getWidth();
        g_objSlider.setSize(sliderWidth, sliderHeight);
        g_objSlider.setPosition(0, 0);
    }
    function onSizeChange() {
        placeSlider();
    }
    function onSlideClick(data, objSlide) {
        var objSlide = jQuery(objSlide);
        var index = g_objSlider.getCurrentItemIndex();
        g_lightbox.open(index);
    }
    function initEvents() {
        g_objGallery.on(g_gallery.events.SIZE_CHANGE, onSizeChange);
        jQuery(g_objSlider).on(g_objSlider.events.CLICK, onSlideClick);
    }
    function initAndPlaceElements() {
        placeSlider();
        g_objSlider.run();
        g_lightbox.run();
    }
    function actualRun() {
        initAndPlaceElements();
        initEvents();
        var sliderElement = g_objSlider.getElement();
        jQuery(sliderElement).find(".ug-button-videoplay").each(function(index) {
            jQuery(this).off();
        });
        jQuery(sliderElement).find(".ug-videoplayer").remove();
    }
    this.run = function() {
        setHtml();
        actualRun();
    };
    this.destroy = function() {
        jQuery(g_objSlider).off(g_objSlider.events.CLICK);
        g_lightbox.destroy();
    };
}
//# sourceMappingURL=unitegallery.sliderfull.js.map
