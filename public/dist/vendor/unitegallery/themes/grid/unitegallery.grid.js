if (typeof g_ugFunctions != "undefined") g_ugFunctions.registerTheme("grid"); else jQuery(document).ready(function() {
    g_ugFunctions.registerTheme("grid");
});

function UGTheme_grid() {
    var t = this;
    var g_gallery = new UniteGalleryMain(), g_objGallery, g_objects, g_objWrapper;
    var g_objSlider;
    var g_functions = new UGFunctions();
    var g_objPanel = new UGGridPanel();
    var g_options = {
        theme_load_slider: true,
        theme_load_panel: true,
        theme_panel_position: "right",
        theme_hide_panel_under_width: 480
    };
    var g_defaults = {
        slider_controls_always_on: true,
        slider_vertical_scroll_ondrag: true
    };
    var g_defaults_left = {
        slider_zoompanel_align_hor: "right",
        slider_fullscreen_button_align_hor: "right",
        slider_play_button_align_hor: "right",
        slider_zoompanel_offset_vert: 9,
        slider_zoompanel_offset_hor: 11,
        slider_play_button_offset_hor: 88,
        slider_play_button_offset_vert: 8,
        slider_fullscreen_button_offset_hor: 52,
        slider_fullscreen_button_offset_vert: 9
    };
    var g_defaults_right = {
        slider_zoompanel_offset_vert: 9,
        slider_zoompanel_offset_hor: 11,
        slider_play_button_offset_hor: 88,
        slider_play_button_offset_vert: 8,
        slider_fullscreen_button_offset_hor: 52,
        slider_fullscreen_button_offset_vert: 9
    };
    var g_defaults_bottom = {
        slider_enable_text_panel: false,
        slider_zoompanel_align_hor: "right",
        slider_zoompanel_offset_vert: 10,
        slider_progress_indicator_align_hor: "left",
        slider_progress_indicator_offset_vert: 36,
        slider_progress_indicator_offset_hor: 16
    };
    var g_defaults_top = {
        slider_enable_text_panel: false,
        slider_zoompanel_align_vert: "bottom",
        slider_zoompanel_offset_vert: 10,
        slider_play_button_align_hor: "right",
        slider_play_button_align_vert: "bottom",
        slider_fullscreen_button_align_vert: "bottom",
        slider_fullscreen_button_align_hor: "right",
        slider_progress_indicator_align_vert: "bottom",
        slider_progress_indicator_offset_vert: 40,
        gridpanel_padding_border_top: 4,
        gridpanel_padding_border_bottom: 10
    };
    var g_temp = {
        isMobileModeWasEnabled: false,
        isHorPos: false
    };
    function initTheme(gallery, customOptions) {
        g_gallery = gallery;
        g_options = jQuery.extend(g_options, g_defaults);
        g_options = jQuery.extend(g_options, customOptions);
        switch (g_options.theme_panel_position) {
          case "left":
            g_options = jQuery.extend(g_options, g_defaults_left);
            break;

          case "right":
            g_options = jQuery.extend(g_options, g_defaults_right);
            break;

          case "top":
            g_options = jQuery.extend(g_options, g_defaults_top);
            break;

          case "bottom":
            g_options = jQuery.extend(g_options, g_defaults_bottom);
            break;
        }
        g_options = jQuery.extend(g_options, customOptions);
        modifyOptions();
        g_gallery.setOptions(g_options);
        if (g_options.theme_load_panel == true) {
            if (g_options.theme_panel_position == "top" || g_options.theme_panel_position == "bottom") g_temp.isHorPos = true;
            g_objPanel.setOrientation(g_options.theme_panel_position);
            g_objPanel.init(gallery, g_options);
        } else g_objPanel = null;
        if (g_options.theme_load_slider == true) g_gallery.initSlider(g_options);
        g_objects = gallery.getObjects();
        g_objGallery = jQuery(gallery);
        g_objWrapper = g_objects.g_objWrapper;
        if (g_options.theme_load_slider == true) g_objSlider = g_objects.g_objSlider;
    }
    function modifyOptions() {
        if (g_options.theme_load_panel == true && g_options.theme_panel_position == "left") {
            g_options.gridpanel_handle_position = "right";
        }
    }
    function initAndPlaceElements() {
        if (g_objPanel) {
            initThumbsPanel();
            placeThumbsPanel();
        }
        if (g_objSlider) {
            g_objSlider.run();
            placeSlider();
        }
    }
    function runTheme() {
        setHtml();
        initAndPlaceElements();
        initEvents();
    }
    function setHtml() {
        g_objWrapper.addClass("ug-theme-grid");
        if (g_objPanel) g_objPanel.setHtml();
        if (g_objSlider) g_objSlider.setHtml();
    }
    function initThumbsPanel() {
        var objGallerySize = g_gallery.getSize();
        if (g_temp.isHorPos == true) g_objPanel.setWidth(objGallerySize.width); else g_objPanel.setHeight(objGallerySize.height);
        g_objPanel.run();
    }
    function placeThumbsPanel() {
        var objPanelElement = g_objPanel.getElement();
        var isNeedToHide = isPanelNeedToHide();
        var isHidden = g_objPanel.isPanelClosed();
        var showClosed = isNeedToHide || isHidden;
        var pos = g_options.theme_panel_position;
        if (showClosed) {
            var hiddenDest = g_objPanel.getClosedPanelDest();
            var originalPos = g_functions.getElementRelativePos(objPanelElement, g_options.theme_panel_position);
            g_objPanel.setClosedState(originalPos);
            pos = hiddenDest;
        } else {
            g_objPanel.setOpenedState();
        }
        if (g_temp.isHorPos == true) g_functions.placeElement(objPanelElement, "left", pos); else g_functions.placeElement(objPanelElement, pos, "top");
    }
    function placeSlider() {
        var gallerySize = g_functions.getElementSize(g_objWrapper);
        var sliderWidth = gallerySize.width;
        var sliderHeight = gallerySize.height;
        var sliderTop = 0;
        var sliderLeft = 0;
        if (g_objPanel) {
            var panelSize = g_objPanel.getSize();
            switch (g_options.theme_panel_position) {
              case "left":
                sliderLeft = panelSize.right;
                sliderWidth = gallerySize.width - panelSize.right;
                break;

              case "right":
                sliderWidth = panelSize.left;
                break;

              case "top":
                sliderHeight = gallerySize.height - panelSize.bottom;
                sliderTop = panelSize.bottom;
                break;

              case "bottom":
                sliderHeight = panelSize.top;
                break;
            }
        }
        g_objSlider.setSize(sliderWidth, sliderHeight);
        g_objSlider.setPosition(sliderLeft, sliderTop);
    }
    function isPanelNeedToHide() {
        if (!g_options.theme_hide_panel_under_width) return false;
        var windowWidth = jQuery(window).width();
        var hidePanelValue = g_options.theme_hide_panel_under_width;
        if (windowWidth <= hidePanelValue) return true;
        return false;
    }
    function checkHidePanel() {
        if (!g_options.theme_hide_panel_under_width) return false;
        var needToHide = isPanelNeedToHide();
        if (needToHide == true) {
            g_objPanel.closePanel(true);
            g_temp.isMobileModeWasEnabled = true;
        } else {
            if (g_temp.isMobileModeWasEnabled == true) {
                g_objPanel.openPanel(true);
                g_temp.isMobileModeWasEnabled = false;
            }
        }
    }
    function onSizeChange() {
        initAndPlaceElements();
        if (g_objPanel) checkHidePanel();
    }
    function onPanelMove() {
        placeSlider();
    }
    function onBeforeReqestItems() {
        g_gallery.showDisabledOverlay();
    }
    function initEvents() {
        g_objGallery.on(g_gallery.events.SIZE_CHANGE, onSizeChange);
        g_objGallery.on(g_gallery.events.GALLERY_BEFORE_REQUEST_ITEMS, onBeforeReqestItems);
        if (g_objPanel) {
            jQuery(g_objPanel).on(g_objPanel.events.FINISH_MOVE, onPanelMove);
        }
    }
    this.destroy = function() {
        g_objGallery.off(g_gallery.events.SIZE_CHANGE, onSizeChange);
        g_objGallery.off(g_gallery.events.GALLERY_BEFORE_REQUEST_ITEMS);
        if (g_objPanel) jQuery(g_objPanel).off(g_objPanel.events.FINISH_MOVE);
        g_objPanel.destroy();
        g_objSlider.destroy();
    };
    this.run = function() {
        runTheme();
    };
    this.init = function(gallery, customOptions) {
        initTheme(gallery, customOptions);
    };
}
//# sourceMappingURL=unitegallery.grid.js.map
