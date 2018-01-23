if (typeof g_ugFunctions != "undefined") g_ugFunctions.registerTheme("default"); else jQuery(document).ready(function() {
    g_ugFunctions.registerTheme("default");
});

function UGTheme_default() {
    var t = this;
    var g_gallery = new UniteGalleryMain(), g_objGallery, g_objects, g_objWrapper;
    var g_objButtonFullscreen, g_objButtonPlay, g_objButtonHidePanel;
    var g_objSlider, g_objPanel, g_objStripPanel, g_objTextPanel;
    var g_functions = new UGFunctions();
    var g_options = {
        theme_load_slider: true,
        theme_load_panel: true,
        theme_enable_fullscreen_button: true,
        theme_enable_play_button: true,
        theme_enable_hidepanel_button: true,
        theme_enable_text_panel: true,
        theme_text_padding_left: 20,
        theme_text_padding_right: 5,
        theme_text_align: "left",
        theme_text_type: "description",
        theme_hide_panel_under_width: 480
    };
    var g_defaults = {
        slider_controls_always_on: true,
        slider_zoompanel_align_vert: "top",
        slider_zoompanel_offset_vert: 12,
        slider_textpanel_padding_top: 0,
        slider_textpanel_enable_title: false,
        slider_textpanel_enable_description: true,
        slider_vertical_scroll_ondrag: true,
        strippanel_background_color: "#232323",
        strippanel_padding_top: 10
    };
    var g_mustOptions = {
        slider_enable_text_panel: false,
        slider_enable_play_button: false,
        slider_enable_fullscreen_button: false,
        slider_enable_text_panel: false,
        slider_textpanel_height: 50,
        slider_textpanel_align: "top"
    };
    var g_temp = {
        isPanelHidden: false
    };
    function initTheme(gallery, customOptions) {
        g_gallery = gallery;
        g_options = jQuery.extend(g_options, g_defaults);
        g_options = jQuery.extend(g_options, customOptions);
        g_options = jQuery.extend(g_options, g_mustOptions);
        modifyOptions();
        g_gallery.setOptions(g_options);
        if (g_options.theme_load_panel == true) {
            g_objStripPanel = new UGStripPanel();
            g_objStripPanel.init(gallery, g_options);
        }
        if (g_options.theme_load_slider == true) g_gallery.initSlider(g_options);
        g_objects = gallery.getObjects();
        g_objGallery = jQuery(gallery);
        g_objWrapper = g_objects.g_objWrapper;
        if (g_options.theme_load_slider == true) g_objSlider = g_objects.g_objSlider;
        if (g_options.theme_enable_text_panel == true) {
            g_objTextPanel = new UGTextPanel();
            g_objTextPanel.init(g_gallery, g_options, "slider");
        }
    }
    function runTheme() {
        setHtml();
        initAndPlaceElements();
        initEvents();
    }
    function modifyOptions() {
        var moreOptions = {
            slider_textpanel_css_title: {},
            slider_textpanel_css_description: {}
        };
        g_options = jQuery.extend(moreOptions, g_options);
        g_options.slider_textpanel_css_title["text-align"] = g_options.theme_text_align;
        g_options.slider_textpanel_css_description["text-align"] = g_options.theme_text_align;
        switch (g_options.theme_text_type) {
          case "title":
            g_options.slider_textpanel_enable_title = true;
            g_options.slider_textpanel_enable_description = false;
            break;

          case "both":
            g_options.slider_textpanel_enable_title = true;
            g_options.slider_textpanel_enable_description = true;
            break;

          default:
          case "description":
        }
    }
    function setHtml() {
        g_objWrapper.addClass("ug-theme-default");
        var htmlAdd = "";
        htmlAdd += "<div class='ug-theme-panel'>";
        var classButtonFullscreen = "ug-default-button-fullscreen";
        var classButtonPlay = "ug-default-button-play";
        var classCaptureButtonFullscreen = ".ug-default-button-fullscreen";
        var classCaptureButtonPlay = ".ug-default-button-play";
        if (!g_objTextPanel) {
            classButtonFullscreen = "ug-default-button-fullscreen-single";
            classButtonPlay = "ug-default-button-play-single";
            classCaptureButtonFullscreen = ".ug-default-button-fullscreen-single";
            classCaptureButtonPlay = ".ug-default-button-play-single";
        }
        if (g_options.theme_enable_fullscreen_button == true) htmlAdd += "<div class='" + classButtonFullscreen + "'></div>";
        if (g_options.theme_enable_play_button == true) htmlAdd += "<div class='" + classButtonPlay + "'></div>";
        if (g_options.theme_enable_hidepanel_button) htmlAdd += "<div class='ug-default-button-hidepanel'><div class='ug-default-button-hidepanel-bg'></div> <div class='ug-default-button-hidepanel-tip'></div></div>";
        htmlAdd += "</div>";
        g_objWrapper.append(htmlAdd);
        g_objPanel = g_objWrapper.children(".ug-theme-panel");
        if (g_options.theme_enable_fullscreen_button == true) g_objButtonFullscreen = g_objPanel.children(classCaptureButtonFullscreen);
        if (g_options.theme_enable_play_button == true) g_objButtonPlay = g_objPanel.children(classCaptureButtonPlay);
        if (g_options.theme_enable_hidepanel_button == true) g_objButtonHidePanel = g_objPanel.children(".ug-default-button-hidepanel");
        g_objStripPanel.setHtml(g_objPanel);
        if (g_objTextPanel) g_objTextPanel.appendHTML(g_objPanel);
        if (g_objSlider) g_objSlider.setHtml();
    }
    function initAndPlaceElements() {
        if (g_options.theme_load_panel) {
            initPanel();
            placePanel();
        }
        if (g_objSlider) {
            placeSlider();
            g_objSlider.run();
        }
    }
    function initPanel() {
        var objGallerySize = g_gallery.getSize();
        var galleryWidth = objGallerySize.width;
        g_objStripPanel.setOrientation("bottom");
        g_objStripPanel.setWidth(galleryWidth);
        g_objStripPanel.run();
        var objStripPanelSize = g_objStripPanel.getSize();
        var panelHeight = objStripPanelSize.height;
        if (g_objTextPanel) {
            panelHeight += g_mustOptions.slider_textpanel_height;
            if (g_objButtonHidePanel) {
                var hideButtonHeight = g_objButtonHidePanel.outerHeight();
                panelHeight += hideButtonHeight;
            }
        } else {
            var maxButtonsHeight = 0;
            if (g_objButtonHidePanel) maxButtonsHeight = Math.max(g_objButtonHidePanel.outerHeight(), maxButtonsHeight);
            if (g_objButtonFullscreen) maxButtonsHeight = Math.max(g_objButtonFullscreen.outerHeight(), maxButtonsHeight);
            if (g_objButtonPlay) maxButtonsHeight = Math.max(g_objButtonPlay.outerHeight(), maxButtonsHeight);
            panelHeight += maxButtonsHeight;
        }
        g_functions.setElementSize(g_objPanel, galleryWidth, panelHeight);
        var stripPanelElement = g_objStripPanel.getElement();
        g_functions.placeElement(stripPanelElement, "left", "bottom");
        if (g_objButtonHidePanel) {
            var buttonTip = g_objButtonHidePanel.children(".ug-default-button-hidepanel-tip");
            g_functions.placeElement(buttonTip, "center", "middle");
            if (g_objTextPanel) {
                var objHideButtonBG = g_objButtonHidePanel.children(".ug-default-button-hidepanel-bg");
                var hidePanelOpacity = g_objTextPanel.getOption("textpanel_bg_opacity");
                objHideButtonBG.fadeTo(0, hidePanelOpacity);
                var bgColor = g_objTextPanel.getOption("textpanel_bg_color");
                objHideButtonBG.css({
                    "background-color": bgColor
                });
            }
        }
        var paddingPlayButton = 0;
        var panelButtonsOffsetY = 0;
        if (g_objButtonHidePanel) {
            panelButtonsOffsetY = hideButtonHeight;
        }
        if (g_objButtonFullscreen) {
            g_functions.placeElement(g_objButtonFullscreen, "right", "top", 0, panelButtonsOffsetY);
            paddingPlayButton = g_objButtonFullscreen.outerWidth();
        }
        if (g_objButtonPlay) {
            var buttonPlayOffsetY = panelButtonsOffsetY;
            if (!g_objTextPanel) buttonPlayOffsetY++;
            g_functions.placeElement(g_objButtonPlay, "right", "top", paddingPlayButton, buttonPlayOffsetY);
            paddingPlayButton += g_objButtonPlay.outerWidth();
        }
        if (g_objTextPanel) {
            var textPanelOptions = {};
            textPanelOptions.slider_textpanel_padding_right = g_options.theme_text_padding_right + paddingPlayButton;
            textPanelOptions.slider_textpanel_padding_left = g_options.theme_text_padding_left;
            if (g_objButtonHidePanel) {
                textPanelOptions.slider_textpanel_margin = hideButtonHeight;
            }
            g_objTextPanel.setOptions(textPanelOptions);
            g_objTextPanel.positionPanel();
            g_objTextPanel.run();
        }
        if (g_objButtonHidePanel) {
            if (g_objTextPanel) g_functions.placeElement(g_objButtonHidePanel, "left", "top"); else {
                var stripPanelHeight = stripPanelElement.outerHeight();
                g_functions.placeElement(g_objButtonHidePanel, "left", "bottom", 0, stripPanelHeight);
            }
        }
    }
    function placePanel() {
        if (g_temp.isPanelHidden || isPanelNeedToHide() == true) {
            var newPanelPosY = getHiddenPanelPosition();
            g_functions.placeElement(g_objPanel, 0, newPanelPosY);
            g_temp.isPanelHidden = true;
        } else g_functions.placeElement(g_objPanel, 0, "bottom");
    }
    function placeSlider() {
        var sliderTop = 0;
        var sliderLeft = 0;
        var galleryHeight = g_gallery.getHeight();
        var sliderHeight = galleryHeight;
        if (g_objStripPanel && isPanelHidden() == false) {
            var panelSize = g_objStripPanel.getSize();
            sliderHeight = galleryHeight - panelSize.height;
        }
        var sliderWidth = g_gallery.getWidth();
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
        if (needToHide == true) hidePanel(true); else showPanel(true);
    }
    function onSizeChange() {
        initAndPlaceElements();
        checkHidePanel();
    }
    function isPanelHidden() {
        return g_temp.isPanelHidden;
    }
    function placePanelAnimation(panelY, functionOnComplete) {
        var objCss = {
            top: panelY + "px"
        };
        g_objPanel.stop(true).animate(objCss, {
            duration: 300,
            easing: "easeInOutQuad",
            queue: false,
            complete: function() {
                if (functionOnComplete) functionOnComplete();
            }
        });
    }
    function getHiddenPanelPosition() {
        var galleryHeight = g_objWrapper.height();
        var newPanelPosY = galleryHeight;
        if (g_objButtonHidePanel) {
            var objButtonSize = g_functions.getElementSize(g_objButtonHidePanel);
            newPanelPosY -= objButtonSize.bottom;
        }
        return newPanelPosY;
    }
    function hidePanel(noAnimation) {
        if (!noAnimation) var noAnimation = false;
        if (isPanelHidden() == true) return false;
        var newPanelPosY = getHiddenPanelPosition();
        if (noAnimation == true) g_functions.placeElement(g_objPanel, 0, newPanelPosY); else placePanelAnimation(newPanelPosY, placeSlider);
        if (g_objButtonHidePanel) g_objButtonHidePanel.addClass("ug-button-hidden-mode");
        g_temp.isPanelHidden = true;
    }
    function showPanel(noAnimation) {
        if (!noAnimation) var noAnimation = false;
        if (isPanelHidden() == false) return false;
        var galleryHeight = g_objWrapper.height();
        var panelHeight = g_objPanel.outerHeight();
        var newPanelPosY = galleryHeight - panelHeight;
        if (noAnimation == true) g_functions.placeElement(g_objPanel, 0, newPanelPosY); else placePanelAnimation(newPanelPosY, placeSlider);
        if (g_objButtonHidePanel) g_objButtonHidePanel.removeClass("ug-button-hidden-mode");
        g_temp.isPanelHidden = false;
    }
    function onHidePanelClick(event) {
        event.stopPropagation();
        event.stopImmediatePropagation();
        if (g_functions.validateClickTouchstartEvent(event.type) == false) return true;
        if (isPanelHidden() == true) showPanel(); else hidePanel();
    }
    function onBeforeReqestItems() {
        g_gallery.showDisabledOverlay();
    }
    function initEvents() {
        g_objGallery.on(g_gallery.events.SIZE_CHANGE, onSizeChange);
        g_objGallery.on(g_gallery.events.GALLERY_BEFORE_REQUEST_ITEMS, onBeforeReqestItems);
        if (g_objButtonPlay) {
            g_functions.addClassOnHover(g_objButtonPlay, "ug-button-hover");
            g_gallery.setPlayButton(g_objButtonPlay);
        }
        if (g_objButtonFullscreen) {
            g_functions.addClassOnHover(g_objButtonFullscreen, "ug-button-hover");
            g_gallery.setFullScreenToggleButton(g_objButtonFullscreen);
        }
        if (g_objButtonHidePanel) {
            g_functions.setButtonMobileReady(g_objButtonHidePanel);
            g_functions.addClassOnHover(g_objButtonHidePanel, "ug-button-hover");
            g_objButtonHidePanel.on("click touchstart", onHidePanelClick);
        }
        g_objGallery.on(g_gallery.events.SLIDER_ACTION_START, function() {
            g_objPanel.css("z-index", "1");
            g_objSlider.getElement().css("z-index", "11");
        });
        g_objGallery.on(g_gallery.events.SLIDER_ACTION_END, function() {
            g_objPanel.css("z-index", "11");
            g_objSlider.getElement().css("z-index", "1");
        });
    }
    this.destroy = function() {
        g_objGallery.off(g_gallery.events.SIZE_CHANGE);
        g_objGallery.off(g_gallery.events.GALLERY_BEFORE_REQUEST_ITEMS);
        if (g_objButtonPlay) g_gallery.destroyPlayButton(g_objButtonPlay);
        if (g_objButtonFullscreen) g_gallery.destroyFullscreenButton(g_objButtonFullscreen);
        if (g_objButtonHidePanel) g_functions.destroyButton(g_objButtonHidePanel);
        g_objGallery.off(g_gallery.events.SLIDER_ACTION_START);
        g_objGallery.off(g_gallery.events.SLIDER_ACTION_END);
        if (g_objSlider) g_objSlider.destroy();
        if (g_objStripPanel) g_objStripPanel.destroy();
        if (g_objTextPanel) g_objTextPanel.destroy();
    };
    this.run = function() {
        runTheme();
    };
    this.init = function(gallery, customOptions) {
        initTheme(gallery, customOptions);
    };
}
//# sourceMappingURL=unitegallery.default.js.map
