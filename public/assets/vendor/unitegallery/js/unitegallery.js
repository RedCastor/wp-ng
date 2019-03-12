function debugLine(html, addRandom, addHtml) {
    if (html === true) html = "true";
    if (html === false) html = "false";
    var output = html;
    if (typeof html == "object") {
        output = "";
        for (name in html) {
            var value = html[name];
            output += " " + name + ": " + value;
        }
    }
    if (addRandom == true && !addHtml) output += " " + Math.random();
    if (addHtml == true) {
        var objLine = jQuery("#debug_line");
        objLine.width(200);
        if (objLine.height() >= 500) objLine.html("");
        var currentHtml = objLine.html();
        output = currentHtml + "<br> -------------- <br>" + output;
    }
    jQuery("#debug_line").show().html(output);
}

function debugSide(obj) {
    var html = "";
    for (name in obj) {
        var value = obj[name];
        html += name + " : " + value + "<br>";
    }
    jQuery("#debug_side").show().html(html);
}

function trace(str) {
    if (typeof console != "undefined") console.log(str);
}

function UGFunctions() {
    var g_browserPrefix = null;
    var t = this;
    var g_temp = {
        starTime: 0,
        arrThemes: [],
        isTouchDevice: -1,
        isRgbaSupported: -1,
        timeCache: {},
        dataCache: {},
        lastEventType: "",
        lastEventTime: 0,
        lastTouchStartElement: null,
        touchThreshold: 700,
        handle: null
    };
    this.debugVar = "";
    this.z__________FULL_SCREEN___________ = function() {};
    this.toFullscreen = function(element, fullscreenID) {
        if (element.requestFullscreen) {
            element.requestFullscreen();
        } else if (element.mozRequestFullScreen) {
            element.mozRequestFullScreen();
        } else if (element.webkitRequestFullscreen) {
            element.webkitRequestFullscreen();
        } else if (element.msRequestFullscreen) {
            element.msRequestFullscreen();
        } else {
            return false;
        }
        return true;
    };
    this.exitFullscreen = function() {
        if (t.isFullScreen() == false) return false;
        if (document.exitFullscreen) {
            document.exitFullscreen();
        } else if (document.cancelFullScreen) {
            document.cancelFullScreen();
        } else if (document.mozCancelFullScreen) {
            document.mozCancelFullScreen();
        } else if (document.webkitExitFullscreen) {
            document.webkitExitFullscreen();
        } else if (document.msExitFullscreen) {
            document.msExitFullscreen();
        } else {
            return false;
        }
        return true;
    };
    function addEvent(evnt, elem, func) {
        if (elem.addEventListener) elem.addEventListener(evnt, func, false); else if (elem.attachEvent) {
            elem.attachEvent("on" + evnt, func);
        } else {
            elem[evnt] = func;
        }
    }
    this.addFullScreenChangeEvent = function(func) {
        if (document["webkitCancelFullScreen"]) addEvent("webkitfullscreenchange", document, func); else if (document["msExitFullscreen"]) addEvent("MSFullscreenChange", document, func); else if (document["mozCancelFullScreen"]) addEvent("mozfullscreenchange", document, func); else addEvent("fullscreenchange", document, func);
    };
    this.destroyFullScreenChangeEvent = function() {
        jQuery(document).unbind("fullscreenChange");
        jQuery(document).unbind("mozfullscreenchange");
        jQuery(document).unbind("webkitfullscreenchange");
        jQuery(document).unbind("MSFullscreenChange");
    };
    this.getFullScreenElement = function() {
        var fullscreenElement = document.fullscreenElement || document.mozFullScreenElement || document.webkitFullscreenElement || document.msFullscreenElement;
        return fullscreenElement;
    };
    this.isFullScreen = function() {
        var isFullScreen = document.fullscreen || document.mozFullScreen || document.webkitIsFullScreen || document.msFullscreenElement;
        if (!isFullScreen) isFullScreen = false; else isFullScreen = true;
        return isFullScreen;
    };
    this.z__________GET_PROPS___________ = function() {};
    this.getBrowserPrefix = function() {
        if (g_browserPrefix !== null) return g_browserPrefix;
        var arrayOfPrefixes = [ "webkit", "Moz", "ms", "O" ];
        var div = document.createElement("div");
        for (var index in arrayOfPrefixes) {
            var prefix = arrayOfPrefixes[index];
            if (prefix + "Transform" in div.style) {
                prefix = prefix.toLowerCase();
                g_browserPrefix = prefix;
                return prefix;
            }
        }
        g_browserPrefix = "";
        return "";
    };
    this.getImageInsideParentDataByImage = function(objImage, scaleMode, objPadding) {
        var objParent = objImage.parent();
        var objOrgSize = t.getImageOriginalSize(objImage);
        var objData = t.getImageInsideParentData(objParent, objOrgSize.width, objOrgSize.height, scaleMode, objPadding);
        return objData;
    };
    this.getImageInsideParentData = function(objParent, originalWidth, originalHeight, scaleMode, objPadding, maxWidth, maxHeight) {
        if (!objPadding) var objPadding = {};
        var objOutput = {};
        if (typeof maxWidth === "undefined") var maxWidth = objParent.width();
        if (typeof maxHeight === "undefined") var maxHeight = objParent.height();
        if (objPadding.padding_left) maxWidth -= objPadding.padding_left;
        if (objPadding.padding_right) maxWidth -= objPadding.padding_right;
        if (objPadding.padding_top) maxHeight -= objPadding.padding_top;
        if (objPadding.padding_bottom) maxHeight -= objPadding.padding_bottom;
        var imageWidth = null;
        var imageHeight = "100%";
        var imageTop = null;
        var imageLeft = null;
        var style = "display:block;margin:0px auto;";
        if (originalWidth > 0 && originalHeight > 0) {
            if (scaleMode == "down" && originalWidth < maxWidth && originalHeight < maxHeight) {
                imageHeight = originalHeight;
                imageWidth = originalWidth;
                imageLeft = (maxWidth - imageWidth) / 2;
                imageTop = (maxHeight - imageHeight) / 2;
            } else if (scaleMode == "fill") {
                var ratio = originalWidth / originalHeight;
                imageHeight = maxHeight;
                imageWidth = imageHeight * ratio;
                if (imageWidth < maxWidth) {
                    imageWidth = maxWidth;
                    imageHeight = imageWidth / ratio;
                    imageLeft = 0;
                    imageTop = Math.round((imageHeight - maxHeight) / 2 * -1);
                } else {
                    imageTop = 0;
                    imageLeft = Math.round((imageWidth - maxWidth) / 2 * -1);
                }
            } else {
                var ratio = originalWidth / originalHeight;
                imageHeight = maxHeight;
                imageWidth = imageHeight * ratio;
                imageTop = 0;
                imageLeft = (maxWidth - imageWidth) / 2;
                if (scaleMode != "fitvert" && imageWidth > maxWidth) {
                    imageWidth = maxWidth;
                    imageHeight = imageWidth / ratio;
                    imageLeft = 0;
                    imageTop = (maxHeight - imageHeight) / 2;
                }
            }
            imageWidth = Math.floor(imageWidth);
            imageHeight = Math.floor(imageHeight);
            imageTop = Math.floor(imageTop);
            imageLeft = Math.floor(imageLeft);
            style = "position:absolute;";
        }
        if (objPadding.padding_top) imageTop += objPadding.padding_top;
        if (objPadding.padding_left) imageLeft += objPadding.padding_left;
        objOutput.imageWidth = imageWidth;
        objOutput.imageHeight = imageHeight;
        objOutput.imageTop = imageTop;
        objOutput.imageLeft = imageLeft;
        objOutput.imageRight = imageLeft + imageWidth;
        if (imageTop == 0 || imageHeight == "100%") objOutput.imageBottom = null; else objOutput.imageBottom = imageTop + imageHeight;
        objOutput.style = style;
        return objOutput;
    };
    this.getElementCenterPosition = function(element, objPadding) {
        var parent = element.parent();
        var objSize = t.getElementSize(element);
        var objSizeParent = t.getElementSize(parent);
        var parentWidth = objSizeParent.width;
        var parentHeight = objSizeParent.height;
        if (objPadding && objPadding.padding_top !== undefined) parentHeight -= objPadding.padding_top;
        if (objPadding && objPadding.padding_bottom !== undefined) parentHeight -= objPadding.padding_bottom;
        if (objPadding && objPadding.padding_left !== undefined) parentWidth -= objPadding.padding_left;
        if (objPadding && objPadding.padding_right !== undefined) parentWidth -= objPadding.padding_right;
        var output = {};
        output.left = Math.round((parentWidth - objSize.width) / 2);
        output.top = Math.round((parentHeight - objSize.height) / 2);
        if (objPadding && objPadding.padding_top !== undefined) output.top += objPadding.padding_top;
        if (objPadding && objPadding.padding_left !== undefined) output.left += objPadding.padding_left;
        return output;
    };
    this.getElementCenterPoint = function(element, includeParent) {
        if (!includeParent) var includeParent = false;
        var objSize = t.getElementSize(element);
        var output = {};
        output.x = objSize.width / 2;
        output.y = objSize.height / 2;
        if (includeParent == true) {
            output.x += objSize.left;
            output.y += objSize.top;
        }
        output.x = Math.round(output.x);
        output.y = Math.round(output.y);
        return output;
    };
    this.getMousePosition = function(event, element) {
        var output = {
            pageX: event.pageX,
            pageY: event.pageY,
            clientX: event.clientX,
            clientY: event.clientY
        };
        if (event.originalEvent && event.originalEvent.touches && event.originalEvent.touches.length > 0) {
            output.pageX = event.originalEvent.touches[0].pageX;
            output.pageY = event.originalEvent.touches[0].pageY;
            output.clientX = event.originalEvent.touches[0].clientX;
            output.clientY = event.originalEvent.touches[0].clientY;
        }
        if (element) {
            var elementPos = element.offset();
            output.mouseX = output.pageX - elementPos.left;
            output.mouseY = output.pageY - elementPos.top;
        }
        return output;
    };
    this.getMouseElementPoint = function(point, element) {
        var newPoint = {
            x: point.pageX,
            y: point.pageY
        };
        var elementPoint = t.getElementLocalPoint(newPoint, element);
        return elementPoint;
    };
    this.getElementLocalPoint = function(point, element) {
        var elementPoint = {};
        var elementPos = element.offset();
        elementPoint.x = Math.round(point.x - elementPos.left);
        elementPoint.y = Math.round(point.y - elementPos.top);
        return elementPoint;
    };
    this.getImageOriginalSize = function(objImage, originalWidth, originalHeight) {
        if (typeof originalWidth != "undefined" && typeof originalHeight != "undefined") return {
            width: originalWidth,
            height: originalHeight
        };
        var htmlImage = objImage[0];
        if (typeof htmlImage == "undefined") throw new Error("getImageOriginalSize error - Image not found");
        var output = {};
        if (typeof htmlImage.naturalWidth == "undefined") {
            if (typeof objImage.data("naturalWidth") == "number") {
                var output = {};
                output.width = objImage.data("naturalWidth");
                output.height = objImage.data("naturalHeight");
                return output;
            }
            var newImg = new Image();
            newImg.src = htmlImage.src;
            if (newImg.complete) {
                output.width = newImg.width;
                output.height = newImg.height;
                objImage.data("naturalWidth", output.width);
                objImage.data("naturalHeight", output.height);
                return output;
            }
            return {
                width: 0,
                height: 0
            };
        } else {
            output.width = htmlImage.naturalWidth;
            output.height = htmlImage.naturalHeight;
            return output;
        }
    };
    this.getimageRatio = function(objImage) {
        var originalSize = t.getImageOriginalSize(objImage);
        var size = t.getElementSize(objImage);
        var ratio = size.width / originalSize.width;
        return ratio;
    };
    this.isImageFitParent = function(objImage) {
        var objParent = objImage.parent();
        var sizeImage = t.getElementSize(objImage);
        var sizeParent = t.getElementSize(objParent);
        if (sizeImage.width <= sizeParent.width && sizeImage.height <= sizeParent.height) return true;
        return false;
    };
    this.getElementSize = function(element) {
        if (element === undefined) {
            throw new Error("Can't get size, empty element");
        }
        var obj = element.position();
        obj.height = element.outerHeight();
        obj.width = element.outerWidth();
        obj.left = Math.round(obj.left);
        obj.top = Math.round(obj.top);
        obj.right = obj.left + obj.width;
        obj.bottom = obj.top + obj.height;
        return obj;
    };
    this.isElementBiggerThenParent = function(element) {
        var objParent = element.parent();
        var objSizeElement = t.getElementSize(element);
        var objSizeParent = t.getElementSize(objParent);
        if (objSizeElement.width > objSizeParent.width || objSizeElement.height > objSizeParent.height) return true;
        return false;
    };
    this.isPointInsideElement = function(point, objSize) {
        var isMouseXInside = point.x >= 0 && point.x < objSize.width;
        if (isMouseXInside == false) return false;
        var isMouseYInside = point.y >= 0 && point.y < objSize.height;
        if (isMouseYInside == false) return false;
        return true;
    };
    this.getElementRelativePos = function(element, pos, offset, objParent) {
        if (!objParent) var objParent = element.parent();
        if (typeof element == "number") {
            var elementSize = {
                width: element,
                height: element
            };
        } else var elementSize = t.getElementSize(element);
        var parentSize = t.getElementSize(objParent);
        switch (pos) {
          case "top":
          case "left":
            pos = 0;
            if (offset) pos += offset;
            break;

          case "center":
            pos = Math.round((parentSize.width - elementSize.width) / 2);
            if (offset) pos += offset;
            break;

          case "right":
            pos = parentSize.width - elementSize.width;
            if (offset) pos -= offset;
            break;

          case "middle":
            pos = Math.round((parentSize.height - elementSize.height) / 2);
            if (offset) pos += offset;
            break;

          case "bottom":
            pos = parentSize.height - elementSize.height;
            if (offset) pos -= offset;
            break;
        }
        return pos;
    };
    this.z_________SET_ELEMENT_PROPS_______ = function() {};
    this.zoomImageInsideParent = function(objImage, zoomIn, step, point, scaleMode, maxZoomRatio, objPadding) {
        if (!step) var step = 1.2;
        if (!scaleMode) var scaleMode = "fit";
        var zoomRatio = step;
        var objParent = objImage.parent();
        var objSize = t.getElementSize(objImage);
        var objOriginalSize = t.getImageOriginalSize(objImage);
        var isMouseInside = false;
        var newHeight, newWidth, panX = 0, panY = 0, newX, newY, panOrientX = 0, panOrientY = 0;
        if (!point) {
            isMouseInside = false;
        } else {
            var pointImg = t.getMouseElementPoint(point, objImage);
            isMouseInside = t.isPointInsideElement(pointImg, objSize);
            panOrientX = pointImg.x;
            panOrientY = pointImg.y;
        }
        if (isMouseInside == false) {
            var imgCenterPoint = t.getElementCenterPoint(objImage);
            panOrientX = imgCenterPoint.x;
            panOrientY = imgCenterPoint.y;
        }
        if (zoomIn == true) {
            newHeight = objSize.height * zoomRatio;
            newWidth = objSize.width * zoomRatio;
            if (panOrientX != 0) panX = -(panOrientX * zoomRatio - panOrientX);
            if (panOrientY != 0) panY = -(panOrientY * zoomRatio - panOrientY);
        } else {
            newHeight = objSize.height / zoomRatio;
            newWidth = objSize.width / zoomRatio;
            var objScaleData = t.getImageInsideParentData(objParent, objOriginalSize.width, objOriginalSize.height, scaleMode, objPadding);
            if (newWidth < objScaleData.imageWidth) {
                t.scaleImageFitParent(objImage, objOriginalSize.width, objOriginalSize.height, scaleMode, objPadding);
                return true;
            }
            if (isMouseInside == true) {
                if (panOrientX != 0) panX = -(panOrientX / zoomRatio - panOrientX);
                if (panOrientY != 0) panY = -(panOrientY / zoomRatio - panOrientY);
            }
        }
        if (maxZoomRatio) {
            var expectedZoomRatio = 1;
            if (objOriginalSize.width != 0) expectedZoomRatio = newWidth / objOriginalSize.width;
            if (expectedZoomRatio > maxZoomRatio) return false;
        }
        t.setElementSize(objImage, newWidth, newHeight);
        if (zoomIn == false && isMouseInside == false) {
            var posCenter = t.getElementCenterPosition(objImage);
            newX = posCenter.left;
            newY = posCenter.top;
        } else {
            newX = objSize.left + panX;
            newY = objSize.top + panY;
        }
        t.placeElement(objImage, newX, newY);
        return true;
    };
    this.placeElement = function(element, left, top, offsetLeft, offsetTop, objParent) {
        if (jQuery.isNumeric(left) == false || jQuery.isNumeric(top) == false) {
            if (!objParent) var objParent = element.parent();
            var elementSize = t.getElementSize(element);
            var parentSize = t.getElementSize(objParent);
        }
        if (jQuery.isNumeric(left) == false) {
            switch (left) {
              case "left":
                left = 0;
                if (offsetLeft) left += offsetLeft;
                break;

              case "center":
                left = Math.round((parentSize.width - elementSize.width) / 2);
                if (offsetLeft) left += offsetLeft;
                break;

              case "right":
                left = parentSize.width - elementSize.width;
                if (offsetLeft) left -= offsetLeft;
                break;
            }
        }
        if (jQuery.isNumeric(top) == false) {
            switch (top) {
              case "top":
                top = 0;
                if (offsetTop) top += offsetTop;
                break;

              case "middle":
              case "center":
                top = Math.round((parentSize.height - elementSize.height) / 2);
                if (offsetTop) top += offsetTop;
                break;

              case "bottom":
                top = parentSize.height - elementSize.height;
                if (offsetTop) top -= offsetTop;
                break;
            }
        }
        var objCss = {
            position: "absolute",
            margin: "0px"
        };
        if (left !== null) objCss.left = left;
        if (top !== null) objCss.top = top;
        element.css(objCss);
    };
    this.placeElementInParentCenter = function(element) {
        t.placeElement(element, "center", "middle");
    };
    this.setElementSizeAndPosition = function(element, left, top, width, height) {
        var objCss = {
            width: width + "px",
            height: height + "px",
            left: left + "px",
            top: top + "px",
            position: "absolute",
            margin: "0px"
        };
        element.css(objCss);
    };
    this.setElementSize = function(element, width, height) {
        var objCss = {
            width: width + "px"
        };
        if (height !== null && typeof height != "undefined") objCss["height"] = height + "px";
        element.css(objCss);
    };
    this.cloneElementSizeAndPos = function(objSource, objTarget, isOuter, offsetX, offsetY) {
        var objSize = objSource.position();
        if (objSize == undefined) {
            throw new Error("Can't get size, empty element");
        }
        if (isOuter === true) {
            objSize.height = objSource.outerHeight();
            objSize.width = objSource.outerWidth();
        } else {
            objSize.height = objSource.height();
            objSize.width = objSource.width();
        }
        objSize.left = Math.round(objSize.left);
        objSize.top = Math.round(objSize.top);
        if (offsetX) objSize.left += offsetX;
        if (offsetY) objSize.top += offsetY;
        t.setElementSizeAndPosition(objTarget, objSize.left, objSize.top, objSize.width, objSize.height);
    };
    this.placeImageInsideParent = function(urlImage, objParent, originalWidth, originalHeight, scaleMode, objPadding) {
        var obj = t.getImageInsideParentData(objParent, originalWidth, originalHeight, scaleMode, objPadding);
        var htmlImage = "<img";
        if (obj.imageWidth !== null) {
            htmlImage += " width = '" + obj.imageWidth + "'";
            obj.style += "width:" + obj.imageWidth + ";";
        }
        if (obj.imageHeight != null) {
            if (obj.imageHeight == "100%") {
                htmlImage += " height = '" + obj.imageHeight + "'";
                obj.style += "height:" + obj.imageHeight + ";";
            } else {
                htmlImage += " height = '" + obj.imageHeight + "'";
                obj.style += "height:" + obj.imageHeight + "px;";
            }
        }
        if (obj.imageTop !== null) obj.style += "top:" + obj.imageTop + "px;";
        if (obj.imageLeft !== null) {
            obj.style += "left:" + obj.imageLeft + "px;";
        }
        urlImage = t.escapeDoubleSlash(urlImage);
        htmlImage += " style='" + obj.style + "'";
        htmlImage += ' src="' + urlImage + '"';
        htmlImage += ">";
        objParent.html(htmlImage);
        var objImage = objParent.children("img");
        return objImage;
    };
    this.scaleImageCoverParent = function(objImage, objParent, pHeight) {
        if (typeof objParent == "number") {
            var parentWidth = objParent;
            var parentHeight = pHeight;
        } else {
            var parentWidth = objParent.outerWidth();
            var parentHeight = objParent.outerHeight();
        }
        var objOriginalSize = t.getImageOriginalSize(objImage);
        var imageWidth = objOriginalSize.width;
        var imageHeight = objOriginalSize.height;
        var ratio = imageWidth / imageHeight;
        var fitHeight = parentHeight;
        var fitWidth = fitHeight * ratio;
        var posy = 0, posx = 0;
        if (fitWidth < parentWidth) {
            fitWidth = parentWidth;
            fitHeight = fitWidth / ratio;
            posx = 0;
            posy = Math.round((fitHeight - parentHeight) / 2 * -1);
        } else {
            posy = 0;
            posx = Math.round((fitWidth - parentWidth) / 2 * -1);
        }
        fitWidth = Math.round(fitWidth);
        fitHeight = Math.round(fitHeight);
        objImage.css({
            width: fitWidth + "px",
            height: fitHeight + "px",
            left: posx + "px",
            top: posy + "px"
        });
    };
    this.scaleImageFitParent = function(objImage, originalWidth, originalHeight, scaleMode, objPadding) {
        var objParent = objImage.parent();
        var obj = t.getImageInsideParentData(objParent, originalWidth, originalHeight, scaleMode, objPadding);
        var updateCss = false;
        var objCss = {};
        if (obj.imageWidth !== null) {
            updateCss = true;
            objImage.removeAttr("width");
            objCss["width"] = obj.imageWidth + "px";
        }
        if (obj.imageHeight != null) {
            updateCss = true;
            objImage.removeAttr("height");
            objCss["height"] = obj.imageHeight + "px";
        }
        if (obj.imageTop !== null) {
            updateCss = true;
            objCss.top = obj.imageTop + "px";
        }
        if (obj.imageLeft !== null) {
            updateCss = true;
            objCss.left = obj.imageLeft + "px";
        }
        if (updateCss == true) {
            objCss.position = "absolute";
            objCss.margin = "0px 0px";
            objImage.css(objCss);
        }
        return obj;
    };
    this.scaleImageByHeight = function(objImage, height, originalWidth, originalHeight) {
        var objOriginalSize = t.getImageOriginalSize(objImage, originalWidth, originalHeight);
        var ratio = objOriginalSize.width / objOriginalSize.height;
        var width = Math.round(height * ratio);
        height = Math.round(height);
        t.setElementSize(objImage, width, height);
    };
    this.scaleImageByWidth = function(objImage, width, originalWidth, originalHeight) {
        var objOriginalSize = t.getImageOriginalSize(objImage, originalWidth, originalHeight);
        var ratio = objOriginalSize.width / objOriginalSize.height;
        var height = Math.round(width / ratio);
        width = Math.round(width);
        t.setElementSize(objImage, width, height);
    };
    this.scaleImageExactSizeInParent = function(objImage, originalWidth, originalHeight, exactWidth, exactHeight, scaleMode) {
        var objParent = objImage.parent();
        var parentSize = t.getElementSize(objParent);
        if (parentSize.width < exactWidth) exactWidth = parentSize.width;
        if (parentSize.height < exactHeight) exactHeight = parentSize.height;
        var obj = t.getImageInsideParentData(null, originalWidth, originalHeight, scaleMode, null, exactWidth, exactHeight);
        var imageWidth = exactWidth;
        var imageHeight = exactHeight;
        var paddingLeft = obj.imageLeft;
        var paddingRight = obj.imageLeft;
        var paddingTop = obj.imageTop;
        var paddingBottom = obj.imageTop;
        var imageLeft = Math.round((parentSize.width - exactWidth) / 2);
        var imageTop = Math.round((parentSize.height - exactHeight) / 2);
        var totalWidth = obj.imageWidth + paddingLeft + paddingRight;
        var diff = exactWidth - totalWidth;
        if (diff != 0) paddingRight += diff;
        var totalHeight = obj.imageHeight + paddingTop + paddingBottom;
        var diff = exactHeight - totalHeight;
        if (diff != 0) paddingBottom += diff;
        objImage.removeAttr("width");
        objImage.removeAttr("height");
        var objCss = {
            position: "absolute",
            margin: "0px 0px"
        };
        objCss["width"] = imageWidth + "px";
        objCss["height"] = imageHeight + "px";
        objCss["left"] = imageLeft + "px";
        objCss["top"] = imageTop + "px";
        objCss["padding-left"] = paddingLeft + "px";
        objCss["padding-top"] = paddingTop + "px";
        objCss["padding-right"] = paddingRight + "px";
        objCss["padding-bottom"] = paddingBottom + "px";
        objImage.css(objCss);
        var objReturn = {};
        objReturn["imageWidth"] = imageWidth;
        objReturn["imageHeight"] = imageHeight;
        return objReturn;
    };
    this.showElement = function(element, element2, element3) {
        element.show().fadeTo(0, 1);
        if (element2) element2.show().fadeTo(0, 1);
        if (element3) element3.show().fadeTo(0, 1);
    };
    this.z_________GALLERY_RELATED_FUNCTIONS_______ = function() {};
    this.disableButton = function(objButton, className) {
        if (!className) var className = "ug-button-disabled";
        if (t.isButtonDisabled(objButton, className) == false) objButton.addClass(className);
    };
    this.convertCustomPrefixOptions = function(objOptions, prefix, base) {
        if (!prefix) return objOptions;
        var modifiedOptions = {};
        jQuery.each(objOptions, function(key, option) {
            if (key.indexOf(prefix + "_" + base + "_") === 0) {
                var newKey = key.replace(prefix + "_" + base + "_", base + "_");
                modifiedOptions[newKey] = option;
            } else {
                modifiedOptions[key] = option;
            }
        });
        return modifiedOptions;
    };
    this.enableButton = function(objButton, className) {
        if (!className) var className = "ug-button-disabled";
        if (t.isButtonDisabled(objButton, className) == true) objButton.removeClass(className);
    };
    this.isButtonDisabled = function(objButton, className) {
        if (!className) var className = "ug-button-disabled";
        if (objButton.hasClass(className)) return true;
        return false;
    };
    this.z_________MATH_FUNCTIONS_______ = function() {};
    this.normalizeSetting = function(realMin, realMax, settingMin, settingMax, value, fixBounds) {
        if (!fixBounds) var fixBounds = false;
        var ratio = (value - settingMin) / (settingMax - settingMin);
        value = realMin + (realMax - realMin) * ratio;
        if (fixBounds == true) {
            if (value < realMin) value = realMin;
            if (value > realMax) value = realMax;
        }
        return value;
    };
    this.getNormalizedValue = function(realMin, realMax, settingMin, settingMax, realValue) {
        var ratio = (realValue - realMin) / (realMax - realMin);
        realValue = realMin + (settingMax - settingMin) * ratio;
        return realValue;
    };
    this.getDistance = function(x1, y1, x2, y2) {
        var distance = Math.round(Math.sqrt(Math.abs((x2 - x1) * (x2 - x1) + (y2 - y1) * (y2 - y1))));
        return distance;
    };
    this.getMiddlePoint = function(x1, y1, x2, y2) {
        var output = {};
        output.x = x1 + Math.round((x2 - x1) / 2);
        output.y = y1 + Math.round((y2 - y1) / 2);
        return output;
    };
    this.getNumItemsInSpace = function(spaceSize, itemsSize, gapSize) {
        var numItems = Math.floor((spaceSize + gapSize) / (itemsSize + gapSize));
        return numItems;
    };
    this.getNumItemsInSpaceRound = function(spaceSize, itemsSize, gapSize) {
        var numItems = Math.round((spaceSize + gapSize) / (itemsSize + gapSize));
        return numItems;
    };
    this.getSpaceByNumItems = function(numItems, itemSize, gapSize) {
        var space = numItems * itemSize + (numItems - 1) * gapSize;
        return space;
    };
    this.getItemSizeInSpace = function(spaceSize, numItems, gapSize) {
        var itemSize = Math.floor((spaceSize - (numItems - 1) * gapSize) / numItems);
        return itemSize;
    };
    this.getColX = function(col, colWidth, colGap) {
        var posx = col * (colWidth + colGap);
        return posx;
    };
    this.getColByIndex = function(numCols, index) {
        var col = index % numCols;
        return col;
    };
    this.getColRowByIndex = function(index, numCols) {
        var row = Math.floor(index / numCols);
        var col = Math.floor(index % numCols);
        return {
            col: col,
            row: row
        };
    };
    this.getIndexByRowCol = function(row, col, numCols) {
        if (row < 0) return -1;
        if (col < 0) return -1;
        var index = row * numCols + col;
        return index;
    };
    this.getPrevRowSameColIndex = function(index, numCols) {
        var obj = t.getColRowByIndex(index, numCols);
        var prevIndex = t.getIndexByRowCol(obj.row - 1, obj.col, numCols);
        return prevIndex;
    };
    this.getNextRowSameColIndex = function(index, numCols) {
        var obj = t.getColRowByIndex(index, numCols);
        var nextIndex = t.getIndexByRowCol(obj.row + 1, obj.col, numCols);
        return nextIndex;
    };
    this.z_________DATA_FUNCTIONS_______ = function() {};
    this.setGlobalData = function(key, value) {
        jQuery.data(document.body, key, value);
    };
    this.getGlobalData = function(key) {
        var value = jQuery.data(document.body, key);
        return value;
    };
    this.z_________EVENT_DATA_FUNCTIONS_______ = function() {};
    this.handleScrollTop = function(storedEventID) {
        if (t.isTouchDevice() == false) return null;
        var objData = t.getStoredEventData(storedEventID);
        var horPass = 15;
        var vertPass = 15;
        if (objData.scrollDir === null) {
            if (Math.abs(objData.diffMouseX) > horPass) objData.scrollDir = "hor"; else if (Math.abs(objData.diffMouseY) > vertPass && Math.abs(objData.diffMouseY) > Math.abs(objData.diffMouseX)) {
                objData.scrollDir = "vert";
                objData.scrollStartY = objData.lastMouseClientY;
                objData.scrollOrigin = jQuery(document).scrollTop();
                g_temp.dataCache[storedEventID].scrollStartY = objData.lastMouseClientY;
                g_temp.dataCache[storedEventID].scrollOrigin = objData.scrollOrigin;
            }
            g_temp.dataCache[storedEventID].scrollDir = objData.scrollDir;
        }
        if (objData.scrollDir !== "vert") return objData.scrollDir;
        var currentScroll = jQuery(document).scrollTop();
        var scrollPos = objData.scrollOrigin - (objData.lastMouseClientY - objData.scrollStartY);
        if (scrollPos >= 0) jQuery(document).scrollTop(scrollPos);
        return objData.scrollDir;
    };
    this.wasVerticalScroll = function(storedEventID) {
        var objData = t.getStoredEventData(storedEventID);
        if (objData.scrollDir === "vert") return true;
        return false;
    };
    this.storeEventData = function(event, id, addData) {
        var mousePos = t.getMousePosition(event);
        var time = jQuery.now();
        var obj = {
            startTime: time,
            lastTime: time,
            startMouseX: mousePos.pageX,
            startMouseY: mousePos.pageY,
            lastMouseX: mousePos.pageX,
            lastMouseY: mousePos.pageY,
            startMouseClientY: mousePos.clientY,
            lastMouseClientY: mousePos.clientY,
            scrollTop: jQuery(document).scrollTop(),
            scrollDir: null
        };
        if (addData) obj = jQuery.extend(obj, addData);
        g_temp.dataCache[id] = obj;
    };
    this.updateStoredEventData = function(event, id, addData) {
        if (!g_temp.dataCache[id]) throw new Error("updateEventData error: must have stored cache object");
        var obj = g_temp.dataCache[id];
        var mousePos = t.getMousePosition(event);
        obj.lastTime = jQuery.now();
        if (mousePos.pageX !== undefined) {
            obj.lastMouseX = mousePos.pageX;
            obj.lastMouseY = mousePos.pageY;
            obj.lastMouseClientY = mousePos.clientY;
        }
        if (addData) obj = jQuery.extend(obj, addData);
        g_temp.dataCache[id] = obj;
    };
    this.getStoredEventData = function(id, isVertical) {
        if (!g_temp.dataCache[id]) throw new Error("updateEventData error: must have stored cache object");
        var obj = g_temp.dataCache[id];
        obj.diffMouseX = obj.lastMouseX - obj.startMouseX;
        obj.diffMouseY = obj.lastMouseY - obj.startMouseY;
        obj.diffMouseClientY = obj.lastMouseClientY - obj.startMouseClientY;
        obj.diffTime = obj.lastTime - obj.startTime;
        if (isVertical === true) {
            obj.startMousePos = obj.lastMouseY;
            obj.lastMousePos = obj.lastMouseY;
            obj.diffMousePos = obj.diffMouseY;
        } else {
            obj.startMousePos = obj.lastMouseX;
            obj.lastMousePos = obj.lastMouseX;
            obj.diffMousePos = obj.diffMouseX;
        }
        return obj;
    };
    this.isApproveStoredEventClick = function(id, isVertical) {
        if (!g_temp.dataCache[id]) return true;
        var objData = t.getStoredEventData(id, isVertical);
        var passedDistanceAbs = Math.abs(objData.diffMousePos);
        if (objData.diffTime > 400) return false;
        if (passedDistanceAbs > 30) return false;
        return true;
    };
    this.clearStoredEventData = function(id) {
        g_temp.dataCache[id] = null;
    };
    this.z_________CHECK_SUPPORT_FUNCTIONS_______ = function() {};
    this.isCanvasExists = function() {
        var canvas = jQuery('<canvas width="500" height="500" > </canvas>')[0];
        if (typeof canvas.getContext == "function") return true;
        return false;
    };
    this.isScrollbarExists = function() {
        var hasScrollbar = window.innerWidth > document.documentElement.clientWidth;
        return hasScrollbar;
    };
    this.isTouchDevice = function() {
        if (g_temp.isTouchDevice !== -1) return g_temp.isTouchDevice;
        try {
            document.createEvent("TouchEvent");
            g_temp.isTouchDevice = true;
        } catch (e) {
            g_temp.isTouchDevice = false;
        }
        return g_temp.isTouchDevice;
    };
    this.isRgbaSupported = function() {
        if (g_temp.isRgbaSupported !== -1) return g_temp.isRgbaSupported;
        var scriptElement = document.getElementsByTagName("script")[0];
        var prevColor = scriptElement.style.color;
        try {
            scriptElement.style.color = "rgba(1,5,13,0.44)";
        } catch (e) {}
        var result = scriptElement.style.color != prevColor;
        scriptElement.style.color = prevColor;
        g_temp.isRgbaSupported = result;
        return result;
    };
    this.z_________GENERAL_FUNCTIONS_______ = function() {};
    this.checkMinJqueryVersion = function(version) {
        var arrCurrent = jQuery.fn.jquery.split(".");
        var arrMin = version.split(".");
        for (var i = 0, len = arrCurrent.length; i < len; i++) {
            var numCurrent = parseInt(arrCurrent[i]);
            var numMin = parseInt(arrMin[i]);
            if (typeof arrMin[i] == "undefined") return true;
            if (numMin > numCurrent) return false;
            if (numCurrent > numMin) return true;
        }
        return true;
    };
    this.getCssSizeParam = function(sizeParam) {
        if (jQuery.isNumeric(sizeParam)) return sizeParam + "px";
        return sizeParam;
    };
    this.convertHexToRGB = function(hexInput, opacity) {
        var hex = hexInput.replace("#", "");
        if (hex === hexInput) return hexInput;
        r = parseInt(hex.substring(0, 2), 16);
        g = parseInt(hex.substring(2, 4), 16);
        b = parseInt(hex.substring(4, 6), 16);
        result = "rgba(" + r + "," + g + "," + b + "," + opacity + ")";
        return result;
    };
    this.timestampToString = function(stamp) {
        var d = new Date(stamp);
        var str = d.getDate() + "/" + d.getMonth();
        str += " " + d.getHours() + ":" + d.getMinutes() + ":" + d.getSeconds() + ":" + d.getMilliseconds();
        return str;
    };
    this.getArrTouches = function(event) {
        var arrTouches = [];
        if (event.originalEvent && event.originalEvent.touches && event.originalEvent.touches.length > 0) {
            arrTouches = event.originalEvent.touches;
        }
        return arrTouches;
    };
    this.getArrTouchPositions = function(arrTouches) {
        var arrOutput = [];
        for (var i = 0; i < arrTouches.length; i++) {
            var point = {
                pageX: arrTouches[i].pageX,
                pageY: arrTouches[i].pageY
            };
            arrOutput.push(point);
        }
        return arrOutput;
    };
    this.startTimeDebug = function() {
        g_temp.starTime = jQuery.now();
    };
    this.showTimeDebug = function() {
        var endTime = jQuery.now();
        var diffTime = endTime - g_temp.starTime;
        debugLine({
            "Time Passed": diffTime
        }, true);
    };
    this.initProgressIndicator = function(type, options, objParent) {
        if (type != "bar" && t.isCanvasExists() == false) type = "bar";
        switch (type) {
          case "bar":
            var g_objProgress = new UGProgressBar();
            g_objProgress.putHidden(objParent, options);
            break;

          default:
          case "pie":
            var g_objProgress = new UGProgressPie();
            g_objProgress.putHidden(objParent, options);
            break;

          case "pie2":
            options.type_fill = true;
            var g_objProgress = new UGProgressPie();
            g_objProgress.putHidden(objParent, options);
            break;
        }
        return g_objProgress;
    };
    this.setButtonMobileReady = function(objButton) {
        objButton.on("touchstart", function(event) {
            jQuery(this).addClass("ug-nohover");
        });
        objButton.on("mousedown touchend", function(event) {
            event.stopPropagation();
            event.stopImmediatePropagation();
            return false;
        });
    };
    this.registerTheme = function(themeName) {
        g_temp.arrThemes.push(themeName);
    };
    this.getArrThemes = function() {
        return g_temp.arrThemes;
    };
    this.isThemeRegistered = function(theme) {
        if (jQuery.inArray(theme, g_temp.arrThemes) !== -1) return true;
        return false;
    };
    this.getFirstRegisteredTheme = function() {
        if (g_temp.arrThemes.length == 0) return "";
        var themeName = g_temp.arrThemes[0];
        return themeName;
    };
    this.isTimePassed = function(handlerName, timeLimit) {
        if (!timeLimit) var timeLimit = 100;
        var currentTime = jQuery.now();
        if (g_temp.timeCache.hasOwnProperty(handlerName) == false) lastTime = 0; else lastTime = g_temp.timeCache[handlerName];
        var diffTime = currentTime - lastTime;
        g_temp.timeCache[handlerName] = currentTime;
        if (diffTime <= timeLimit) return false;
        return true;
    };
    this.whenContiniousEventOver = function(handlerName, onEventOver, timeLimit) {
        if (!timeLimit) var timeLimit = 300;
        if (g_temp.timeCache.hasOwnProperty(handlerName) == true && g_temp.timeCache[handlerName] != null) {
            clearTimeout(g_temp.timeCache[handlerName]);
            g_temp.timeCache[handlerName] = null;
        }
        g_temp.timeCache[handlerName] = setTimeout(onEventOver, timeLimit);
    };
    this.validateClickTouchstartEvent = function(eventType) {
        var returnVal = true;
        var diff = jQuery.now() - g_temp.lastEventTime;
        if (eventType == "click" && g_temp.lastEventType == "touchstart" && diff < 1e3) returnVal = false;
        g_temp.lastEventTime = jQuery.now();
        g_temp.lastEventType = eventType;
        return returnVal;
    };
    this.addClassOnHover = function(element, className) {
        if (!className) var className = "ug-button-hover";
        element.hover(function() {
            jQuery(this).addClass(className);
        }, function() {
            jQuery(this).removeClass(className);
        });
    };
    this.destroyButton = function(element) {
        element.off("mouseenter");
        element.off("mouseleave");
        element.off("click");
        element.off("touchstart");
        element.off("touchend");
        element.off("mousedown");
        element.off("tap");
    };
    this.setButtonOnClick = function(objButton, onClickFunction) {
        t.setButtonMobileReady(objButton);
        objButton.on("click touchstart", function(event) {
            objThis = jQuery(this);
            event.stopPropagation();
            event.stopImmediatePropagation();
            if (t.validateClickTouchstartEvent(event.type) == false) return true;
            onClickFunction(objThis, event);
        });
    };
    this.setButtonOnTap = function(objButton, onClickFunction) {
        objButton.on("tap", onClickFunction);
        if (t.isTouchDevice() == false) {
            objButton.on("click", function(event) {
                var objElement = jQuery(this);
                if (t.validateClickTouchstartEvent(event.type) == false) return true;
                objElement.trigger("tap");
            });
        } else {
            objButton.on("touchstart", function(event) {
                var objElement = jQuery(this);
                objElement.addClass("ug-nohover");
                g_temp.lastTouchStartElement = jQuery(this);
                g_temp.lastEventTime = jQuery.now();
            });
            objButton.on("touchend", function(event) {
                var objElement = jQuery(this);
                if (objElement.is(g_temp.lastTouchStartElement) == false) return true;
                if (!g_temp.lastEventTime) return true;
                var timePassed = jQuery.now() - g_temp.lastEventTime;
                if (timePassed > g_temp.touchThreshold) return true;
                objElement.trigger("tap");
            });
        }
    };
    this.loadJs = function(url, addProtocol) {
        if (addProtocol === true) url = location.protocol + "//" + url;
        var tag = document.createElement("script");
        tag.src = url;
        var firstScriptTag = document.getElementsByTagName("script")[0];
        firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
    };
    this.loadCss = function(url, addProtocol) {
        if (addProtocol === true) url = location.protocol + "//" + url;
        var tag = document.createElement("link");
        tag.setAttribute("rel", "stylesheet");
        tag.setAttribute("type", "text/css");
        tag.setAttribute("href", url);
        document.getElementsByTagName("head")[0].appendChild(tag);
    };
    this.addEvent = function(elem, event, func) {
        if (typeof elem.addEventListener != "undefined") {
            elem.addEventListener(event, func, false);
        } else if (elem.attachEvent) {
            elem.attachEvent("on" + event, func);
        }
    };
    this.checkImagesLoaded = function(objImages, onComplete, onProgress) {
        var arrImages = [];
        var counter = 0;
        var numImages = objImages.length;
        if (numImages == 0 && onComplete) {
            onComplete();
            return false;
        }
        function checkComplete(image, isError) {
            counter++;
            if (typeof onProgress == "function") {
                setTimeout(function() {
                    onProgress(image, isError);
                });
            }
            if (counter == numImages && typeof onComplete == "function") {
                setTimeout(function() {
                    onComplete();
                });
            }
        }
        setTimeout(function() {
            for (var index = 0; index < numImages; index++) {
                var image = objImages[index];
                if (image.naturalWidth !== undefined && image.naturalWidth !== 0) {
                    checkComplete(objImages[index], false);
                } else {
                    var proxyImage = jQuery("<img/>");
                    proxyImage.data("index", index);
                    proxyImage.on("load", function() {
                        var index = jQuery(this).data("index");
                        checkComplete(objImages[index], false);
                    });
                    proxyImage.on("error", function() {
                        var index = jQuery(this).data("index");
                        checkComplete(objImages[index], true);
                    });
                    proxyImage.attr("src", image.src);
                }
            }
        });
    };
    this.waitForWidth = function(element, func) {
        var width = element.width();
        if (width != 0) {
            func();
            return false;
        }
        g_temp.handle = setInterval(function() {
            width = element.width();
            if (width != 0) {
                clearInterval(g_temp.handle);
                func();
            }
        }, 300);
    };
    this.arrayShuffle = function(arr) {
        if (typeof arr != "object") return arr;
        for (var j, x, i = arr.length; i; j = parseInt(Math.random() * i), x = arr[--i], 
        arr[i] = arr[j], arr[j] = x) ;
        return arr;
    };
    this.getObjectLength = function(object) {
        var num = 0;
        for (var item in object) num++;
        return num;
    };
    this.normalizePercent = function(percent) {
        if (percent < 0) percent = 0;
        if (percent > 1) percent = 1;
        return percent;
    };
    this.stripTags = function(html) {
        var text = html.replace(/(<([^>]+)>)/gi, "");
        return text;
    };
    this.escapeDoubleSlash = function(str) {
        return str.replace('"', '"');
    };
    this.htmlentitles = function(html) {
        var text = jQuery("<div/>").text(html).html();
        return text;
    };
    this.z_________END_GENERAL_FUNCTIONS_______ = function() {};
}

var g_ugFunctions = new UGFunctions();

!function(e) {
    "function" == typeof define && define.amd ? define([ "jquery" ], e) : "object" == typeof exports ? module.exports = e : e(jQuery);
}(function(e) {
    function t(t) {
        var s = t || window.event, a = h.call(arguments, 1), u = 0, r = 0, d = 0, f = 0;
        if (t = e.event.fix(s), t.type = "mousewheel", "detail" in s && (d = -1 * s.detail), 
        "wheelDelta" in s && (d = s.wheelDelta), "wheelDeltaY" in s && (d = s.wheelDeltaY), 
        "wheelDeltaX" in s && (r = -1 * s.wheelDeltaX), "axis" in s && s.axis === s.HORIZONTAL_AXIS && (r = -1 * d, 
        d = 0), u = 0 === d ? r : d, "deltaY" in s && (d = -1 * s.deltaY, u = d), "deltaX" in s && (r = s.deltaX, 
        0 === d && (u = -1 * r)), 0 !== d || 0 !== r) {
            if (1 === s.deltaMode) {
                var c = e.data(this, "mousewheel-line-height");
                u *= c, d *= c, r *= c;
            } else if (2 === s.deltaMode) {
                var m = e.data(this, "mousewheel-page-height");
                u *= m, d *= m, r *= m;
            }
            return f = Math.max(Math.abs(d), Math.abs(r)), (!l || l > f) && (l = f, i(s, f) && (l /= 40)), 
            i(s, f) && (u /= 40, r /= 40, d /= 40), u = Math[u >= 1 ? "floor" : "ceil"](u / l), 
            r = Math[r >= 1 ? "floor" : "ceil"](r / l), d = Math[d >= 1 ? "floor" : "ceil"](d / l), 
            t.deltaX = r, t.deltaY = d, t.deltaFactor = l, t.deltaMode = 0, a.unshift(t, u, r, d), 
            o && clearTimeout(o), o = setTimeout(n, 200), (e.event.dispatch || e.event.handle).apply(this, a);
        }
    }
    function n() {
        l = null;
    }
    function i(e, t) {
        return r.settings.adjustOldDeltas && "mousewheel" === e.type && t % 120 === 0;
    }
    var o, l, s = [ "wheel", "mousewheel", "DOMMouseScroll", "MozMousePixelScroll" ], a = "onwheel" in document || document.documentMode >= 9 ? [ "wheel" ] : [ "mousewheel", "DomMouseScroll", "MozMousePixelScroll" ], h = Array.prototype.slice;
    if (e.event.fixHooks) for (var u = s.length; u; ) e.event.fixHooks[s[--u]] = e.event.mouseHooks;
    var r = e.event.special.mousewheel = {
        version: "3.1.9",
        setup: function() {
            if (this.addEventListener) for (var n = a.length; n; ) this.addEventListener(a[--n], t, !1); else this.onmousewheel = t;
            e.data(this, "mousewheel-line-height", r.getLineHeight(this)), e.data(this, "mousewheel-page-height", r.getPageHeight(this));
        },
        teardown: function() {
            if (this.removeEventListener) for (var e = a.length; e; ) this.removeEventListener(a[--e], t, !1); else this.onmousewheel = null;
        },
        getLineHeight: function(t) {
            return parseInt(e(t)["offsetParent" in e.fn ? "offsetParent" : "parent"]().css("fontSize"), 10);
        },
        getPageHeight: function(t) {
            return e(t).height();
        },
        settings: {
            adjustOldDeltas: !0
        }
    };
    e.fn.extend({
        mousewheel: function(e) {
            return e ? this.bind("mousewheel", e) : this.trigger("mousewheel");
        },
        unmousewheel: function(e) {
            return this.unbind("mousewheel", e);
        }
    });
});

(function(factory) {
    if (typeof define === "function" && define.amd) {
        define([ "jquery" ], function($) {
            return factory($);
        });
    } else if (typeof module === "object" && typeof module.exports === "object") {
        exports = factory(require("jquery"));
    } else {
        factory(jQuery);
    }
})(function($) {
    $.easing["jswing"] = $.easing["swing"];
    var pow = Math.pow, sqrt = Math.sqrt, sin = Math.sin, cos = Math.cos, PI = Math.PI, c1 = 1.70158, c2 = c1 * 1.525, c3 = c1 + 1, c4 = 2 * PI / 3, c5 = 2 * PI / 4.5;
    function bounceOut(x) {
        var n1 = 7.5625, d1 = 2.75;
        if (x < 1 / d1) {
            return n1 * x * x;
        } else if (x < 2 / d1) {
            return n1 * (x -= 1.5 / d1) * x + .75;
        } else if (x < 2.5 / d1) {
            return n1 * (x -= 2.25 / d1) * x + .9375;
        } else {
            return n1 * (x -= 2.625 / d1) * x + .984375;
        }
    }
    $.extend($.easing, {
        def: "easeOutQuad",
        swing: function(x) {
            return $.easing[$.easing.def](x);
        },
        easeInQuad: function(x) {
            return x * x;
        },
        easeOutQuad: function(x) {
            return 1 - (1 - x) * (1 - x);
        },
        easeInOutQuad: function(x) {
            return x < .5 ? 2 * x * x : 1 - pow(-2 * x + 2, 2) / 2;
        },
        easeInCubic: function(x) {
            return x * x * x;
        },
        easeOutCubic: function(x) {
            return 1 - pow(1 - x, 3);
        },
        easeInOutCubic: function(x) {
            return x < .5 ? 4 * x * x * x : 1 - pow(-2 * x + 2, 3) / 2;
        },
        easeInQuart: function(x) {
            return x * x * x * x;
        },
        easeOutQuart: function(x) {
            return 1 - pow(1 - x, 4);
        },
        easeInOutQuart: function(x) {
            return x < .5 ? 8 * x * x * x * x : 1 - pow(-2 * x + 2, 4) / 2;
        },
        easeInQuint: function(x) {
            return x * x * x * x * x;
        },
        easeOutQuint: function(x) {
            return 1 - pow(1 - x, 5);
        },
        easeInOutQuint: function(x) {
            return x < .5 ? 16 * x * x * x * x * x : 1 - pow(-2 * x + 2, 5) / 2;
        },
        easeInSine: function(x) {
            return 1 - cos(x * PI / 2);
        },
        easeOutSine: function(x) {
            return sin(x * PI / 2);
        },
        easeInOutSine: function(x) {
            return -(cos(PI * x) - 1) / 2;
        },
        easeInExpo: function(x) {
            return x === 0 ? 0 : pow(2, 10 * x - 10);
        },
        easeOutExpo: function(x) {
            return x === 1 ? 1 : 1 - pow(2, -10 * x);
        },
        easeInOutExpo: function(x) {
            return x === 0 ? 0 : x === 1 ? 1 : x < .5 ? pow(2, 20 * x - 10) / 2 : (2 - pow(2, -20 * x + 10)) / 2;
        },
        easeInCirc: function(x) {
            return 1 - sqrt(1 - pow(x, 2));
        },
        easeOutCirc: function(x) {
            return sqrt(1 - pow(x - 1, 2));
        },
        easeInOutCirc: function(x) {
            return x < .5 ? (1 - sqrt(1 - pow(2 * x, 2))) / 2 : (sqrt(1 - pow(-2 * x + 2, 2)) + 1) / 2;
        },
        easeInElastic: function(x) {
            return x === 0 ? 0 : x === 1 ? 1 : -pow(2, 10 * x - 10) * sin((x * 10 - 10.75) * c4);
        },
        easeOutElastic: function(x) {
            return x === 0 ? 0 : x === 1 ? 1 : pow(2, -10 * x) * sin((x * 10 - .75) * c4) + 1;
        },
        easeInOutElastic: function(x) {
            return x === 0 ? 0 : x === 1 ? 1 : x < .5 ? -(pow(2, 20 * x - 10) * sin((20 * x - 11.125) * c5)) / 2 : pow(2, -20 * x + 10) * sin((20 * x - 11.125) * c5) / 2 + 1;
        },
        easeInBack: function(x) {
            return c3 * x * x * x - c1 * x * x;
        },
        easeOutBack: function(x) {
            return 1 + c3 * pow(x - 1, 3) + c1 * pow(x - 1, 2);
        },
        easeInOutBack: function(x) {
            return x < .5 ? pow(2 * x, 2) * ((c2 + 1) * 2 * x - c2) / 2 : (pow(2 * x - 2, 2) * ((c2 + 1) * (x * 2 - 2) + c2) + 2) / 2;
        },
        easeInBounce: function(x) {
            return 1 - bounceOut(1 - x);
        },
        easeOutBounce: bounceOut,
        easeInOutBounce: function(x) {
            return x < .5 ? (1 - bounceOut(1 - 2 * x)) / 2 : (1 + bounceOut(2 * x - 1)) / 2;
        }
    });
});

!function(r, n) {
    if (typeof r.cssHooks == "undefined") return false;
    function t(r, n, t) {
        var e = f[n.type] || {};
        return null == r ? t || !n.def ? null : n.def : (r = e.floor ? ~~r : parseFloat(r), 
        isNaN(r) ? n.def : e.mod ? (r + e.mod) % e.mod : 0 > r ? 0 : e.max < r ? e.max : r);
    }
    function e(n) {
        var t = l(), e = t._rgba = [];
        return n = n.toLowerCase(), h(u, function(r, o) {
            var a, s = o.re.exec(n), i = s && o.parse(s), u = o.space || "rgba";
            return i ? (a = t[u](i), t[c[u].cache] = a[c[u].cache], e = t._rgba = a._rgba, !1) : void 0;
        }), e.length ? ("0,0,0,0" === e.join() && r.extend(e, a.transparent), t) : a[n];
    }
    function o(r, n, t) {
        return t = (t + 1) % 1, 1 > 6 * t ? r + (n - r) * t * 6 : 1 > 2 * t ? n : 2 > 3 * t ? r + (n - r) * (2 / 3 - t) * 6 : r;
    }
    var a, s = "backgroundColor borderBottomColor borderLeftColor borderRightColor borderTopColor color columnRuleColor outlineColor textDecorationColor textEmphasisColor", i = /^([\-+])=\s*(\d+\.?\d*)/, u = [ {
        re: /rgba?\(\s*(\d{1,3})\s*,\s*(\d{1,3})\s*,\s*(\d{1,3})\s*(?:,\s*(\d?(?:\.\d+)?)\s*)?\)/,
        parse: function(r) {
            return [ r[1], r[2], r[3], r[4] ];
        }
    }, {
        re: /rgba?\(\s*(\d+(?:\.\d+)?)\%\s*,\s*(\d+(?:\.\d+)?)\%\s*,\s*(\d+(?:\.\d+)?)\%\s*(?:,\s*(\d?(?:\.\d+)?)\s*)?\)/,
        parse: function(r) {
            return [ 2.55 * r[1], 2.55 * r[2], 2.55 * r[3], r[4] ];
        }
    }, {
        re: /#([a-f0-9]{2})([a-f0-9]{2})([a-f0-9]{2})/,
        parse: function(r) {
            return [ parseInt(r[1], 16), parseInt(r[2], 16), parseInt(r[3], 16) ];
        }
    }, {
        re: /#([a-f0-9])([a-f0-9])([a-f0-9])/,
        parse: function(r) {
            return [ parseInt(r[1] + r[1], 16), parseInt(r[2] + r[2], 16), parseInt(r[3] + r[3], 16) ];
        }
    }, {
        re: /hsla?\(\s*(\d+(?:\.\d+)?)\s*,\s*(\d+(?:\.\d+)?)\%\s*,\s*(\d+(?:\.\d+)?)\%\s*(?:,\s*(\d?(?:\.\d+)?)\s*)?\)/,
        space: "hsla",
        parse: function(r) {
            return [ r[1], r[2] / 100, r[3] / 100, r[4] ];
        }
    } ], l = r.Color = function(n, t, e, o) {
        return new r.Color.fn.parse(n, t, e, o);
    }, c = {
        rgba: {
            props: {
                red: {
                    idx: 0,
                    type: "byte"
                },
                green: {
                    idx: 1,
                    type: "byte"
                },
                blue: {
                    idx: 2,
                    type: "byte"
                }
            }
        },
        hsla: {
            props: {
                hue: {
                    idx: 0,
                    type: "degrees"
                },
                saturation: {
                    idx: 1,
                    type: "percent"
                },
                lightness: {
                    idx: 2,
                    type: "percent"
                }
            }
        }
    }, f = {
        byte: {
            floor: !0,
            max: 255
        },
        percent: {
            max: 1
        },
        degrees: {
            mod: 360,
            floor: !0
        }
    }, p = l.support = {}, d = r("<p>")[0], h = r.each;
    d.style.cssText = "background-color:rgba(1,1,1,.5)", p.rgba = d.style.backgroundColor.indexOf("rgba") > -1, 
    h(c, function(r, n) {
        n.cache = "_" + r, n.props.alpha = {
            idx: 3,
            type: "percent",
            def: 1
        };
    }), l.fn = r.extend(l.prototype, {
        parse: function(o, s, i, u) {
            if (o === n) return this._rgba = [ null, null, null, null ], this;
            (o.jquery || o.nodeType) && (o = r(o).css(s), s = n);
            var f = this, p = r.type(o), d = this._rgba = [];
            return s !== n && (o = [ o, s, i, u ], p = "array"), "string" === p ? this.parse(e(o) || a._default) : "array" === p ? (h(c.rgba.props, function(r, n) {
                d[n.idx] = t(o[n.idx], n);
            }), this) : "object" === p ? (o instanceof l ? h(c, function(r, n) {
                o[n.cache] && (f[n.cache] = o[n.cache].slice());
            }) : h(c, function(n, e) {
                var a = e.cache;
                h(e.props, function(r, n) {
                    if (!f[a] && e.to) {
                        if ("alpha" === r || null == o[r]) return;
                        f[a] = e.to(f._rgba);
                    }
                    f[a][n.idx] = t(o[r], n, !0);
                }), f[a] && r.inArray(null, f[a].slice(0, 3)) < 0 && (f[a][3] = 1, e.from && (f._rgba = e.from(f[a])));
            }), this) : void 0;
        },
        is: function(r) {
            var n = l(r), t = !0, e = this;
            return h(c, function(r, o) {
                var a, s = n[o.cache];
                return s && (a = e[o.cache] || o.to && o.to(e._rgba) || [], h(o.props, function(r, n) {
                    return null != s[n.idx] ? t = s[n.idx] === a[n.idx] : void 0;
                })), t;
            }), t;
        },
        _space: function() {
            var r = [], n = this;
            return h(c, function(t, e) {
                n[e.cache] && r.push(t);
            }), r.pop();
        },
        transition: function(r, n) {
            var e = l(r), o = e._space(), a = c[o], s = 0 === this.alpha() ? l("transparent") : this, i = s[a.cache] || a.to(s._rgba), u = i.slice();
            return e = e[a.cache], h(a.props, function(r, o) {
                var a = o.idx, s = i[a], l = e[a], c = f[o.type] || {};
                null !== l && (null === s ? u[a] = l : (c.mod && (l - s > c.mod / 2 ? s += c.mod : s - l > c.mod / 2 && (s -= c.mod)), 
                u[a] = t((l - s) * n + s, o)));
            }), this[o](u);
        },
        blend: function(n) {
            if (1 === this._rgba[3]) return this;
            var t = this._rgba.slice(), e = t.pop(), o = l(n)._rgba;
            return l(r.map(t, function(r, n) {
                return (1 - e) * o[n] + e * r;
            }));
        },
        toRgbaString: function() {
            var n = "rgba(", t = r.map(this._rgba, function(r, n) {
                return null == r ? n > 2 ? 1 : 0 : r;
            });
            return 1 === t[3] && (t.pop(), n = "rgb("), n + t.join() + ")";
        },
        toHslaString: function() {
            var n = "hsla(", t = r.map(this.hsla(), function(r, n) {
                return null == r && (r = n > 2 ? 1 : 0), n && 3 > n && (r = Math.round(100 * r) + "%"), 
                r;
            });
            return 1 === t[3] && (t.pop(), n = "hsl("), n + t.join() + ")";
        },
        toHexString: function(n) {
            var t = this._rgba.slice(), e = t.pop();
            return n && t.push(~~(255 * e)), "#" + r.map(t, function(r) {
                return r = (r || 0).toString(16), 1 === r.length ? "0" + r : r;
            }).join("");
        },
        toString: function() {
            return 0 === this._rgba[3] ? "transparent" : this.toRgbaString();
        }
    }), l.fn.parse.prototype = l.fn, c.hsla.to = function(r) {
        if (null == r[0] || null == r[1] || null == r[2]) return [ null, null, null, r[3] ];
        var n, t, e = r[0] / 255, o = r[1] / 255, a = r[2] / 255, s = r[3], i = Math.max(e, o, a), u = Math.min(e, o, a), l = i - u, c = i + u, f = .5 * c;
        return n = u === i ? 0 : e === i ? 60 * (o - a) / l + 360 : o === i ? 60 * (a - e) / l + 120 : 60 * (e - o) / l + 240, 
        t = 0 === l ? 0 : .5 >= f ? l / c : l / (2 - c), [ Math.round(n) % 360, t, f, null == s ? 1 : s ];
    }, c.hsla.from = function(r) {
        if (null == r[0] || null == r[1] || null == r[2]) return [ null, null, null, r[3] ];
        var n = r[0] / 360, t = r[1], e = r[2], a = r[3], s = .5 >= e ? e * (1 + t) : e + t - e * t, i = 2 * e - s;
        return [ Math.round(255 * o(i, s, n + 1 / 3)), Math.round(255 * o(i, s, n)), Math.round(255 * o(i, s, n - 1 / 3)), a ];
    }, h(c, function(e, o) {
        var a = o.props, s = o.cache, u = o.to, c = o.from;
        l.fn[e] = function(e) {
            if (u && !this[s] && (this[s] = u(this._rgba)), e === n) return this[s].slice();
            var o, i = r.type(e), f = "array" === i || "object" === i ? e : arguments, p = this[s].slice();
            return h(a, function(r, n) {
                var e = f["object" === i ? r : n.idx];
                null == e && (e = p[n.idx]), p[n.idx] = t(e, n);
            }), c ? (o = l(c(p)), o[s] = p, o) : l(p);
        }, h(a, function(n, t) {
            l.fn[n] || (l.fn[n] = function(o) {
                var a, s = r.type(o), u = "alpha" === n ? this._hsla ? "hsla" : "rgba" : e, l = this[u](), c = l[t.idx];
                return "undefined" === s ? c : ("function" === s && (o = o.call(this, c), s = r.type(o)), 
                null == o && t.empty ? this : ("string" === s && (a = i.exec(o), a && (o = c + parseFloat(a[2]) * ("+" === a[1] ? 1 : -1))), 
                l[t.idx] = o, this[u](l)));
            });
        });
    }), l.hook = function(n) {
        var t = n.split(" ");
        h(t, function(n, t) {
            r.cssHooks[t] = {
                set: function(n, o) {
                    var a, s, i = "";
                    if ("transparent" !== o && ("string" !== r.type(o) || (a = e(o)))) {
                        if (o = l(a || o), !p.rgba && 1 !== o._rgba[3]) {
                            for (s = "backgroundColor" === t ? n.parentNode : n; ("" === i || "transparent" === i) && s && s.style; ) try {
                                i = r.css(s, "backgroundColor"), s = s.parentNode;
                            } catch (u) {}
                            o = o.blend(i && "transparent" !== i ? i : "_default");
                        }
                        o = o.toRgbaString();
                    }
                    try {
                        n.style[t] = o;
                    } catch (u) {}
                }
            }, r.fx.step[t] = function(n) {
                n.colorInit || (n.start = l(n.elem, t), n.end = l(n.end), n.colorInit = !0), r.cssHooks[t].set(n.elem, n.start.transition(n.end, n.pos));
            };
        });
    }, l.hook(s), r.cssHooks.borderColor = {
        expand: function(r) {
            var n = {};
            return h([ "Top", "Right", "Bottom", "Left" ], function(t, e) {
                n["border" + e + "Color"] = r;
            }), n;
        }
    }, a = r.Color.names = {
        aqua: "#00ffff",
        black: "#000000",
        blue: "#0000ff",
        fuchsia: "#ff00ff",
        gray: "#808080",
        green: "#008000",
        lime: "#00ff00",
        maroon: "#800000",
        navy: "#000080",
        olive: "#808000",
        purple: "#800080",
        red: "#ff0000",
        silver: "#c0c0c0",
        teal: "#008080",
        white: "#ffffff",
        yellow: "#ffff00",
        transparent: [ null, null, null, 0 ],
        _default: "#ffffff"
    };
}(jQuery);

!function(t) {
    function e() {
        try {
            var i = this === document ? t(this) : t(this).contents();
        } catch (error) {
            return false;
        }
        i.mousemove(function(e) {
            t.mlp = {
                x: e.pageX,
                y: e.pageY
            };
        }), i.find("iframe").on("load", e);
    }
    t.mlp = {
        x: 0,
        y: 0
    }, t(e), t.fn.ismouseover = function() {
        var e = !1;
        return this.eq(0).each(function() {
            var i = t(this).is("iframe") ? t(this).contents().find("body") : t(this), n = i.offset();
            e = n.left <= t.mlp.x && n.left + i.outerWidth() > t.mlp.x && n.top <= t.mlp.y && n.top + i.outerHeight() > t.mlp.y;
        }), e;
    };
}(jQuery);

function UGThumbsGeneral() {
    var t = this, g_objThis = jQuery(t);
    var g_gallery = new UniteGalleryMain(), g_objGallery, g_objects, g_objWrapper;
    var g_arrItems, g_objStrip, g_objParent;
    var g_functions = new UGFunctions();
    var g_strip;
    var outer_options;
    this.type = {
        GET_THUMBS_ALL: "all",
        GET_THUMBS_RATIO: "ratio",
        GET_THUMBS_NO_RATIO: "no_ratio",
        GET_THUMBS_NEW: "new"
    };
    this.events = {
        SETOVERSTYLE: "thumbmouseover",
        SETNORMALSTYLE: "thumbmouseout",
        SETSELECTEDSTYLE: "thumbsetselected",
        PLACEIMAGE: "thumbplaceimage",
        AFTERPLACEIMAGE: "thumb_after_place_image",
        IMAGELOADERROR: "thumbimageloaderror",
        THUMB_IMAGE_LOADED: "thumb_image_loaded"
    };
    var g_options = {
        thumb_width: 88,
        thumb_height: 50,
        thumb_fixed_size: true,
        thumb_resize_by: "height",
        thumb_border_effect: true,
        thumb_border_width: 0,
        thumb_border_color: "#000000",
        thumb_over_border_width: 0,
        thumb_over_border_color: "#d9d9d9",
        thumb_selected_border_width: 1,
        thumb_selected_border_color: "#d9d9d9",
        thumb_round_corners_radius: 0,
        thumb_color_overlay_effect: true,
        thumb_overlay_color: "#000000",
        thumb_overlay_opacity: .4,
        thumb_overlay_reverse: false,
        thumb_image_overlay_effect: false,
        thumb_image_overlay_type: "bw",
        thumb_transition_duration: 200,
        thumb_transition_easing: "easeOutQuad",
        thumb_show_loader: true,
        thumb_loader_type: "dark",
        thumb_wrapper_as_link: false,
        thumb_link_newpage: false
    };
    var g_temp = {
        touchEnabled: false,
        num_thumbs_checking: 0,
        customThumbs: false,
        funcSetCustomThumbHtml: null,
        isEffectBorder: false,
        isEffectOverlay: false,
        isEffectImage: false,
        colorOverlayOpacity: 1,
        thumbInnerReduce: 0,
        allowOnResize: true,
        classNewThumb: "ug-new-thumb"
    };
    var g_serviceParams = {
        timeout_thumb_check: 100,
        thumb_max_check_times: 600,
        eventSizeChange: "thumb_size_change"
    };
    this.init = function(gallery, customOptions) {
        g_objects = gallery.getObjects();
        g_gallery = gallery;
        g_objGallery = jQuery(gallery);
        g_objWrapper = g_objects.g_objWrapper;
        g_arrItems = g_objects.g_arrItems;
        g_options = jQuery.extend(g_options, customOptions);
        g_temp.isEffectBorder = g_options.thumb_border_effect;
        g_temp.isEffectOverlay = g_options.thumb_color_overlay_effect;
        g_temp.isEffectImage = g_options.thumb_image_overlay_effect;
    };
    this._____________EXTERNAL_SETTERS__________ = function() {};
    function appendHtmlThumbFromItem(itemIndex, imageEffectClass) {
        var objItem = g_arrItems[itemIndex];
        var classAddition = "";
        if (g_temp.customThumbs == false) classAddition = " ug-thumb-generated";
        var zIndex = objItem.index + 1;
        var thumbStyle = "style='z-index:" + zIndex + ";'";
        var htmlThumb = "<div class='ug-thumb-wrapper" + classAddition + "' " + thumbStyle + "></div>";
        if (g_options.thumb_wrapper_as_link == true) {
            var urlLink = objItem.link;
            if (objItem.link == "") urlLink = "javascript:void(0)";
            var linkTarget = "";
            if (g_options.thumb_link_newpage == true && objItem.link) linkTarget = " target='_blank'";
            var htmlThumb = "<a href='" + urlLink + "'" + linkTarget + " class='ug-thumb-wrapper" + classAddition + "'></a>";
        }
        var objThumbWrapper = jQuery(htmlThumb);
        var objImage = objItem.objThumbImage;
        if (g_temp.customThumbs == false) {
            if (g_options.thumb_show_loader == true && objImage) {
                var loaderClass = "ug-thumb-loader-dark";
                if (g_options.thumb_loader_type == "bright") loaderClass = "ug-thumb-loader-bright";
                objThumbWrapper.append("<div class='ug-thumb-loader " + loaderClass + "'></div>");
                objThumbWrapper.append("<div class='ug-thumb-error' style='display:none'></div>");
            }
            if (objImage) {
                objImage.addClass("ug-thumb-image");
                if (g_options.thumb_image_overlay_effect == true) {
                    var objImageOverlay = objImage.clone().appendTo(objThumbWrapper);
                    objImageOverlay.addClass("ug-thumb-image-overlay " + imageEffectClass).removeClass("ug-thumb-image");
                    objImageOverlay.fadeTo(0, 0);
                    objItem.objImageOverlay = objImageOverlay;
                }
                objThumbWrapper.append(objImage);
            }
        }
        if (g_temp.isEffectBorder) objThumbWrapper.append("<div class='ug-thumb-border-overlay'></div>");
        if (g_temp.isEffectOverlay) objThumbWrapper.append("<div class='ug-thumb-overlay'></div>");
        g_objParent.append(objThumbWrapper);
        if (g_temp.customThumbs) {
            g_temp.funcSetCustomThumbHtml(objThumbWrapper, objItem);
        }
        g_arrItems[itemIndex].objThumbWrapper = objThumbWrapper;
        return objThumbWrapper;
    }
    this.setHtmlThumbs = function(objParent, isAppend) {
        g_objParent = objParent;
        if (g_temp.isEffectImage == true) {
            var imageEffectClass = getImageEffectsClass();
        }
        if (isAppend !== true) {
            var numItems = g_gallery.getNumItems();
            for (var i = 0; i < numItems; i++) {
                appendHtmlThumbFromItem(i, imageEffectClass);
            }
        } else {
            var objThumbs = t.getThumbs();
            objThumbs.removeClass(g_temp.classNewThumb);
            var arrNewIndexes = g_gallery.getNewAddedItemsIndexes();
            jQuery.each(arrNewIndexes, function(i, itemIndex) {
                var objThumbWrapper = appendHtmlThumbFromItem(itemIndex, imageEffectClass);
                objThumbWrapper.addClass(g_temp.classNewThumb);
            });
        }
    };
    function _______________SETTERS______________() {}
    function setThumbSize(width, height, objThumb, innerOnly) {
        var objCss = {
            width: width + "px",
            height: height + "px"
        };
        var objCssInner = {
            width: width - g_temp.thumbInnerReduce + "px",
            height: height - g_temp.thumbInnerReduce + "px"
        };
        var selectorsString = ".ug-thumb-loader, .ug-thumb-error, .ug-thumb-border-overlay, .ug-thumb-overlay";
        if (objThumb) {
            if (innerOnly !== true) objThumb.css(objCss);
            objThumb.find(selectorsString).css(objCssInner);
        } else {
            g_objParent.children(".ug-thumb-wrapper").css(objCss);
            g_objParent.find(selectorsString).css(objCssInner);
        }
    }
    function setThumbBorderEffect(objThumb, borderWidth, borderColor, noAnimation) {
        if (!noAnimation) var noAnimation = false;
        if (g_gallery.isFakeFullscreen()) noAnimation = true;
        var objBorderOverlay = objThumb.children(".ug-thumb-border-overlay");
        var objCss = {};
        objCss["border-width"] = borderWidth + "px";
        if (borderWidth != 0) objCss["border-color"] = borderColor;
        if (noAnimation && noAnimation === true) {
            objBorderOverlay.css(objCss);
            if (borderWidth == 0) objBorderOverlay.hide(); else objBorderOverlay.show();
        } else {
            if (borderWidth == 0) objBorderOverlay.stop().fadeOut(g_options.thumb_transition_duration); else objBorderOverlay.show().stop().fadeIn(g_options.thumb_transition_duration);
            animateThumb(objBorderOverlay, objCss);
        }
    }
    function setThumbColorOverlayEffect(objThumb, isActive, noAnimation) {
        var objOverlay = objThumb.children(".ug-thumb-overlay");
        var animationDuration = g_options.thumb_transition_duration;
        if (noAnimation && noAnimation === true) animationDuration = 0;
        if (isActive) {
            objOverlay.stop(true).fadeTo(animationDuration, g_temp.colorOverlayOpacity);
        } else {
            objOverlay.stop(true).fadeTo(animationDuration, 0);
        }
    }
    function setThumbImageOverlayEffect(objThumb, isActive, noAnimation) {
        var objImage = objThumb.children("img.ug-thumb-image");
        var objImageOverlay = objThumb.children("img.ug-thumb-image-overlay");
        var animationDuration = g_options.thumb_transition_duration;
        if (noAnimation && noAnimation === true) animationDuration = 0;
        if (isActive) {
            objImageOverlay.stop(true).fadeTo(animationDuration, 1);
        } else {
            objImage.fadeTo(0, 1);
            objImageOverlay.stop(true).fadeTo(animationDuration, 0);
        }
    }
    this.setThumbNormalStyle = function(objThumb, noAnimation, fromWhere) {
        if (g_temp.customThumbs == true) {
            objThumb.removeClass("ug-thumb-over");
        }
        if (g_temp.isEffectBorder) setThumbBorderEffect(objThumb, g_options.thumb_border_width, g_options.thumb_border_color, noAnimation);
        if (g_temp.isEffectOverlay) {
            var isSet = g_options.thumb_overlay_reverse == true ? false : true;
            setThumbColorOverlayEffect(objThumb, isSet, noAnimation);
        }
        if (g_temp.isEffectImage) {
            setThumbImageOverlayEffect(objThumb, true, noAnimation);
        }
        g_objThis.trigger(t.events.SETNORMALSTYLE, objThumb);
    };
    this.setThumbOverStyle = function(objThumb) {
        if (g_temp.customThumbs == true) {
            objThumb.addClass("ug-thumb-over");
        }
        if (g_temp.isEffectBorder) setThumbBorderEffect(objThumb, g_options.thumb_over_border_width, g_options.thumb_over_border_color);
        if (g_temp.isEffectOverlay) {
            var isSet = g_options.thumb_overlay_reverse == true ? true : false;
            setThumbColorOverlayEffect(objThumb, isSet);
        }
        if (g_temp.isEffectImage == true) {
            setThumbImageOverlayEffect(objThumb, false);
        }
        g_objThis.trigger(t.events.SETOVERSTYLE, objThumb);
    };
    function setThumbSelectedStyle(objThumb, noAnimation) {
        if (g_temp.isEffectBorder) setThumbBorderEffect(objThumb, g_options.thumb_selected_border_width, g_options.thumb_selected_border_color, noAnimation);
        if (g_temp.isEffectOverlay) {
            var isSet = g_options.thumb_overlay_reverse == true ? true : false;
            setThumbColorOverlayEffect(objThumb, isSet, noAnimation);
        }
        if (g_temp.isEffectImage) setThumbImageOverlayEffect(objThumb, false, noAnimation);
        g_objThis.trigger(t.events.SETSELECTEDSTYLE, objThumb);
    }
    function setItemThumbLoadedError(objThumb) {
        var objItem = t.getItemByThumb(objThumb);
        objItem.isLoaded = true;
        objItem.isThumbImageLoaded = false;
        if (g_temp.customThumbs == true) {
            g_objThis.trigger(t.events.IMAGELOADERROR, objThumb);
            return true;
        }
        objThumb.children(".ug-thumb-loader").hide();
        objThumb.children(".ug-thumb-error").show();
    }
    function setThumbsBorderRadius(objThumbs) {
        if (g_options.thumb_round_corners_radius <= 0) return false;
        var objCss = {
            "border-radius": g_options.thumb_round_corners_radius + "px"
        };
        if (objThumbs) {
            objThumbs.css(objCss);
            objThumbs.find(".ug-thumb-border-overlay").css(objCss);
        } else {
            g_objParent.find(".ug-thumb-wrapper, .ug-thumb-wrapper .ug-thumb-border-overlay").css(objCss);
        }
    }
    function animateThumb(objThumb, objThumbCss) {
        objThumb.stop(true).animate(objThumbCss, {
            duration: g_options.thumb_transition_duration,
            easing: g_options.thumb_transition_easing,
            queue: false
        });
    }
    function redrawThumbStyle(objThumb) {
        if (isThumbSelected(objThumb) == true) setThumbSelectedStyle(objThumb, true, "redraw"); else t.setThumbNormalStyle(objThumb, true, "redraw");
    }
    function placeThumbImage(objThumb, objImage, objItem) {
        if (g_options.thumb_fixed_size == true) {
            g_functions.scaleImageCoverParent(objImage, objThumb);
        } else {
            if (g_options.thumb_resize_by == "height") g_functions.scaleImageByHeight(objImage, g_options.thumb_height); else g_functions.scaleImageByWidth(objImage, g_options.thumb_width);
            var imageSize = g_functions.getElementSize(objImage);
            g_functions.placeElement(objImage, 0, 0);
            setThumbSize(imageSize.width, imageSize.height, objThumb);
        }
        objThumb.children(".ug-thumb-loader").hide();
        objImage.show();
        if (g_options.thumb_image_overlay_effect == false) {
            objImage.fadeTo(0, 1);
        } else {
            if (g_options.thumb_image_overlay_effect == true) {
                copyPositionToThumbOverlayImage(objImage);
            }
            objImage.fadeTo(0, 0);
            redrawThumbStyle(objThumb);
        }
        g_objThis.trigger(t.events.AFTERPLACEIMAGE, objThumb);
    }
    function copyPositionToThumbOverlayImage(objImage) {
        var objImageBW = objImage.siblings(".ug-thumb-image-overlay");
        if (objImageBW.length == 0) return false;
        var objSize = g_functions.getElementSize(objImage);
        var objCss = {
            width: objSize.width + "px",
            height: objSize.height + "px",
            left: objSize.left + "px",
            top: objSize.top + "px"
        };
        objImageBW.css(objCss);
        if (g_temp.customThumbs == false) objImageBW.fadeTo(0, 1);
    }
    function _______________GETTERS______________() {}
    function getImageEffectsClass() {
        var imageEffectClass = "";
        var arrEffects = g_options.thumb_image_overlay_type.split(",");
        for (var index in arrEffects) {
            var effect = arrEffects[index];
            switch (effect) {
              case "bw":
                imageEffectClass += " ug-bw-effect";
                break;

              case "blur":
                imageEffectClass += " ug-blur-effect";
                break;

              case "sepia":
                imageEffectClass += " ug-sepia-effect";
                break;
            }
        }
        return imageEffectClass;
    }
    function isThumbSelected(objThumbWrapper) {
        if (objThumbWrapper.hasClass("ug-thumb-selected")) return true;
        return false;
    }
    function _______________EVENTS______________() {}
    function onThumbSizeChange(temp, objThumb) {
        objThumb = jQuery(objThumb);
        var objItem = t.getItemByThumb(objThumb);
        var objSize = g_functions.getElementSize(objThumb);
        setThumbSize(objSize.width, objSize.height, objThumb, true);
        redrawThumbStyle(objThumb);
    }
    function onMouseOver(objThumb) {
        if (g_temp.touchEnabled == true) {
            objThumbs.off("mouseenter").off("mouseleave");
            return true;
        }
        if (isThumbSelected(objThumb) == false) t.setThumbOverStyle(objThumb);
    }
    function onMouseOut(objThumb) {
        if (g_temp.touchEnabled == true) return true;
        if (isThumbSelected(objThumb) == false) t.setThumbNormalStyle(objThumb, false);
    }
    function onImageLoaded(image, isForce) {
        if (!isForce) var isForce = false;
        var objImage = jQuery(image);
        var objThumb = objImage.parents(".ug-thumb-wrapper");
        if (objThumb.parent().length == 0) return false;
        objItem = t.getItemByThumb(objThumb);
        if (objItem.isLoaded == true && isForce === false) return false;
        t.triggerImageLoadedEvent(objThumb, objImage);
        if (g_temp.customThumbs == true) {
            g_objThis.trigger(t.events.PLACEIMAGE, [ objThumb, objImage ]);
        } else {
            placeThumbImage(objThumb, objImage, objItem);
        }
    }
    function onThumbImageLoaded(data, objThumb, objImage) {
        objItem = t.getItemByThumb(objThumb);
        objItem.isLoaded = true;
        objItem.isThumbImageLoaded = true;
        var objSize = g_functions.getImageOriginalSize(objImage);
        objItem.thumbWidth = objSize.width;
        objItem.thumbHeight = objSize.height;
        objItem.thumbRatioByWidth = objSize.width / objSize.height;
        objItem.thumbRatioByHeight = objSize.height / objSize.width;
        objThumb.addClass("ug-thumb-ratio-set");
    }
    this.setHtmlProperties = function(objThumbs) {
        if (!objThumbs) var objThumbs = t.getThumbs();
        if (g_temp.customThumbs == false) {
            var objThumbCss = {};
            if (g_options.thumb_fixed_size == true) setThumbSize(g_options.thumb_width, g_options.thumb_height, objThumbs);
            setThumbsBorderRadius(objThumbs);
        }
        objThumbs.each(function() {
            var objThumb = jQuery(this);
            redrawThumbStyle(objThumb);
        });
        if (g_temp.isEffectOverlay) {
            if (g_options.thumb_overlay_color) {
                var objCss = {};
                if (g_functions.isRgbaSupported()) {
                    var colorRGB = g_functions.convertHexToRGB(g_options.thumb_overlay_color, g_options.thumb_overlay_opacity);
                    objCss["background-color"] = colorRGB;
                } else {
                    objCss["background-color"] = g_options.thumb_overlay_color;
                    g_temp.colorOverlayOpacity = g_options.thumb_overlay_opacity;
                }
                objThumbs.find(".ug-thumb-overlay").css(objCss);
            }
        }
    };
    this.setThumbSelected = function(objThumbWrapper) {
        if (g_temp.customThumbs == true) objThumbWrapper.removeClass("ug-thumb-over");
        if (isThumbSelected(objThumbWrapper) == true) return true;
        objThumbWrapper.addClass("ug-thumb-selected");
        setThumbSelectedStyle(objThumbWrapper);
    };
    this.setThumbUnselected = function(objThumbWrapper) {
        objThumbWrapper.removeClass("ug-thumb-selected");
        t.setThumbNormalStyle(objThumbWrapper, false, "set unselected");
    };
    this.setOptions = function(objOptions) {
        g_options = jQuery.extend(g_options, objOptions);
    };
    this.setThumbInnerReduce = function(innerReduce) {
        g_temp.thumbInnerReduce = innerReduce;
    };
    this.setCustomThumbs = function(funcSetHtml, arrAlowedEffects, customOptions) {
        g_temp.customThumbs = true;
        if (typeof funcSetHtml != "function") throw new Error("The argument should be function");
        g_temp.funcSetCustomThumbHtml = funcSetHtml;
        if (jQuery.inArray("overlay", arrAlowedEffects) == -1) g_temp.isEffectOverlay = false;
        if (jQuery.inArray("border", arrAlowedEffects) == -1) g_temp.isEffectBorder = false;
        g_temp.isEffectImage = false;
        if (customOptions && customOptions.allow_onresize === false) {
            g_temp.allowOnResize = false;
        }
    };
    this._____________EXTERNAL_GETTERS__________ = function() {};
    this.getOptions = function() {
        return g_options;
    };
    this.getNumThumbs = function() {
        var numThumbs = g_arrItems.length;
        return numThumbs;
    };
    this.getThumbImage = function(objThumb) {
        var objImage = objThumb.find(".ug-thumb-image");
        return objImage;
    };
    this.getThumbByIndex = function(index) {
        var objThumbs = t.getThumbs();
        if (index >= objThumbs.length || index < 0) throw new Error("Wrong thumb index");
        var objThumb = jQuery(objThumbs[index]);
        return objThumb;
    };
    this.getThumbs = function(mode) {
        var thumbClass = ".ug-thumb-wrapper";
        var classRatio = ".ug-thumb-ratio-set";
        switch (mode) {
          default:
          case t.type.GET_THUMBS_ALL:
            var objThumbs = g_objParent.children(thumbClass);
            break;

          case t.type.GET_THUMBS_NO_RATIO:
            var objThumbs = g_objParent.children(thumbClass).not(classRatio);
            break;

          case t.type.GET_THUMBS_RATIO:
            var objThumbs = g_objParent.children(thumbClass + classRatio);
            break;

          case t.type.GET_THUMBS_NEW:
            var objThumbs = g_objParent.children("." + g_temp.classNewThumb);
            break;
        }
        return objThumbs;
    };
    this.getItemByThumb = function(objThumb) {
        var index = objThumb.data("index");
        if (index === undefined) index = objThumb.index();
        var arrItem = g_arrItems[index];
        return arrItem;
    };
    this.isThumbLoaded = function(objThumb) {
        var objItem = t.getItemByThumb(objThumb);
        return objItem.isLoaded;
    };
    this.getGlobalThumbSize = function() {
        var objSize = {
            width: g_options.thumb_width,
            height: g_options.thumb_height
        };
        return objSize;
    };
    this._____________EXTERNAL_OTHERS__________ = function() {};
    this.initEvents = function() {
        var selectorThumb = ".ug-thumb-wrapper";
        if (g_temp.allowOnResize == true) g_objWrapper.on(g_serviceParams.eventSizeChange, onThumbSizeChange);
        g_objThis.on(t.events.THUMB_IMAGE_LOADED, onThumbImageLoaded);
        g_objParent.on("touchstart", selectorThumb, function() {
            g_temp.touchEnabled = true;
            g_objParent.off("mouseenter").off("mouseleave");
        });
        g_objParent.on("mouseenter", selectorThumb, function(event) {
            var objThumb = jQuery(this);
            onMouseOver(objThumb);
        });
        g_objParent.on("mouseleave", selectorThumb, function(event) {
            var objThumb = jQuery(this);
            onMouseOut(objThumb);
        });
    };
    this.destroy = function() {
        var selectorThumb = ".ug-thumb-wrapper";
        g_objParent.off("touchstart", selectorThumb);
        g_objWrapper.off(g_serviceParams.eventSizeChange);
        g_objParent.off("mouseenter", selectorThumb);
        g_objParent.off("mouseleave", selectorThumb);
        g_objThis.off(t.events.THUMB_IMAGE_LOADED);
    };
    this.loadThumbsImages = function() {
        var objImages = g_objParent.find(".ug-thumb-image");
        g_functions.checkImagesLoaded(objImages, null, function(objImage, isError) {
            if (isError == false) {
                onImageLoaded(objImage, true);
            } else {
                var objItem = jQuery(objImage).parent();
                setItemThumbLoadedError(objItem);
            }
        });
    };
    this.triggerImageLoadedEvent = function(objThumb, objImage) {
        g_objThis.trigger(t.events.THUMB_IMAGE_LOADED, [ objThumb, objImage ]);
    };
    this.hideThumbs = function() {
        g_objParent.find(".ug-thumb-wrapper").hide();
    };
}

function UGThumbsStrip() {
    var t = this;
    var g_gallery = new UniteGalleryMain(), g_objGallery, g_objects, g_objWrapper;
    var g_arrItems, g_objStrip, g_objStripInner;
    var g_aviaControl, g_touchThumbsControl, g_functions = new UGFunctions();
    var g_isVertical = false, g_thumbs = new UGThumbsGeneral();
    var g_functions = new UGFunctions();
    var g_options = {
        strip_vertical_type: false,
        strip_thumbs_align: "left",
        strip_space_between_thumbs: 6,
        strip_thumb_touch_sensetivity: 15,
        strip_scroll_to_thumb_duration: 500,
        strip_scroll_to_thumb_easing: "easeOutCubic",
        strip_control_avia: true,
        strip_control_touch: true,
        strip_padding_top: 0,
        strip_padding_bottom: 0,
        strip_padding_left: 0,
        strip_padding_right: 0
    };
    var g_temp = {
        isRunOnce: false,
        is_placed: false,
        isNotFixedThumbs: false,
        handle: null
    };
    var g_sizes = {
        stripSize: 0,
        stripActiveSize: 0,
        stripInnerSize: 0,
        thumbSize: 0,
        thumbSecondSize: 0
    };
    this.events = {
        STRIP_MOVE: "stripmove",
        INNER_SIZE_CHANGE: "size_change"
    };
    var g_defaultsVertical = {
        strip_thumbs_align: "top",
        thumb_resize_by: "width"
    };
    this.setHtml = function(objParent) {
        if (!objParent) {
            var objParent = g_objWrapper;
            if (g_options.parent_container != null) objParent = g_options.parent_container;
        }
        objParent.append("<div class='ug-thumbs-strip'><div class='ug-thumbs-strip-inner'></div></div>");
        g_objStrip = objParent.children(".ug-thumbs-strip");
        g_objStripInner = g_objStrip.children(".ug-thumbs-strip-inner");
        g_thumbs.setHtmlThumbs(g_objStripInner);
        if (g_temp.isNotFixedThumbs == true) g_thumbs.hideThumbs();
    };
    function ___________GENERAL___________() {}
    function initStrip(gallery, customOptions) {
        g_objects = gallery.getObjects();
        g_gallery = gallery;
        g_gallery.attachThumbsPanel("strip", t);
        g_objGallery = jQuery(gallery);
        g_objWrapper = g_objects.g_objWrapper;
        g_arrItems = g_objects.g_arrItems;
        g_options = jQuery.extend(g_options, customOptions);
        g_isVertical = g_options.strip_vertical_type;
        if (g_isVertical == true) {
            g_options = jQuery.extend(g_options, g_defaultsVertical);
            g_options = jQuery.extend(g_options, customOptions);
            customOptions.thumb_resize_by = "width";
        }
        g_thumbs.init(gallery, customOptions);
        onAfterSetOptions();
    }
    function onAfterSetOptions() {
        var thumbsOptions = g_thumbs.getOptions();
        g_temp.isNotFixedThumbs = thumbsOptions.thumb_fixed_size === false;
        g_isVertical = g_options.strip_vertical_type;
    }
    function runStrip() {
        g_thumbs.setHtmlProperties();
        initSizeParams();
        fixSize();
        positionThumbs();
        if (g_temp.isRunOnce == false) {
            if (g_options.strip_control_touch == true) {
                g_touchThumbsControl = new UGTouchThumbsControl();
                g_touchThumbsControl.init(t);
            }
            if (g_options.strip_control_avia == true) {
                g_aviaControl = new UGAviaControl();
                g_aviaControl.init(t);
            }
            checkControlsEnableDisable();
            g_thumbs.loadThumbsImages();
            initEvents();
        }
        g_temp.isRunOnce = true;
    }
    function storeStripSize(size) {
        g_sizes.stripSize = size;
        if (g_isVertical == false) g_sizes.stripActiveSize = g_sizes.stripSize - g_options.strip_padding_left - g_options.strip_padding_right; else g_sizes.stripActiveSize = g_sizes.stripSize - g_options.strip_padding_top - g_options.strip_padding_bottom;
        if (g_sizes.stripActiveSize < 0) g_sizes.stripActiveSize = 0;
    }
    function initSizeParams() {
        var arrThumbs = g_objStripInner.children(".ug-thumb-wrapper");
        var firstThumb = jQuery(arrThumbs[0]);
        var thumbsRealWidth = firstThumb.outerWidth();
        var thumbsRealHeight = firstThumb.outerHeight();
        var thumbs_options = g_thumbs.getOptions();
        if (g_isVertical == false) {
            g_sizes.thumbSize = thumbsRealWidth;
            if (thumbs_options.thumb_fixed_size == true) {
                g_sizes.thumbSecondSize = thumbsRealHeight;
            } else {
                g_sizes.thumbSecondSize = thumbs_options.thumb_height;
            }
            storeStripSize(g_objStrip.width());
            g_sizes.stripInnerSize = g_objStripInner.width();
        } else {
            g_sizes.thumbSize = thumbsRealHeight;
            if (thumbs_options.thumb_fixed_size == true) {
                g_sizes.thumbSecondSize = thumbsRealWidth;
            } else {
                g_sizes.thumbSecondSize = thumbs_options.thumb_width;
            }
            storeStripSize(g_objStrip.height());
            g_sizes.stripInnerSize = g_objStripInner.height();
        }
    }
    function setInnerStripSize(innerSize) {
        if (g_isVertical == false) g_objStripInner.width(innerSize); else g_objStripInner.height(innerSize);
        g_sizes.stripInnerSize = innerSize;
        checkControlsEnableDisable();
        jQuery(t).trigger(t.events.INNER_SIZE_CHANGE);
    }
    function positionThumbs() {
        var arrThumbs = g_objStripInner.children(".ug-thumb-wrapper");
        var posx = 0;
        var posy = 0;
        if (g_isVertical == false) posy = g_options.strip_padding_top;
        for (i = 0; i < arrThumbs.length; i++) {
            var objThumb = jQuery(arrThumbs[i]);
            if (g_temp.isNotFixedThumbs == true) {
                objItem = g_thumbs.getItemByThumb(objThumb);
                if (objItem.isLoaded == false) continue;
                objThumb.show();
            }
            g_functions.placeElement(objThumb, posx, posy);
            if (g_isVertical == false) posx += objThumb.outerWidth() + g_options.strip_space_between_thumbs; else posy += objThumb.outerHeight() + g_options.strip_space_between_thumbs;
        }
        if (g_isVertical == false) var innerStripSize = posx - g_options.strip_space_between_thumbs; else var innerStripSize = posy - g_options.strip_space_between_thumbs;
        setInnerStripSize(innerStripSize);
    }
    function fixSize() {
        if (g_isVertical == false) {
            var height = g_sizes.thumbSecondSize;
            var objCssStrip = {};
            objCssStrip["height"] = height + "px";
            var objCssInner = {};
            objCssInner["height"] = height + "px";
        } else {
            var width = g_sizes.thumbSecondSize;
            var objCssStrip = {};
            objCssStrip["width"] = width + "px";
            var objCssInner = {};
            objCssInner["width"] = width + "px";
        }
        g_objStrip.css(objCssStrip);
        g_objStripInner.css(objCssInner);
    }
    function scrollBy(scrollStep) {
        var innerPos = t.getInnerStripPos();
        var finalPos = innerPos + scrollStep;
        finalPos = t.fixInnerStripLimits(finalPos);
        t.positionInnerStrip(finalPos, true);
    }
    function scrollToThumbMin(objThumb) {
        var objThumbPos = getThumbPos(objThumb);
        var scrollPos = objThumbPos.min * -1;
        scrollPos = t.fixInnerStripLimits(scrollPos);
        t.positionInnerStrip(scrollPos, true);
    }
    function scrollToThumbMax(objThumb) {
        var objThumbPos = getThumbPos(objThumb);
        var scrollPos = objThumbPos.max * -1 + g_sizes.stripSize;
        scrollPos = t.fixInnerStripLimits(scrollPos);
        t.positionInnerStrip(scrollPos, true);
    }
    function scrollToThumb(objThumb) {
        if (isStripMovingEnabled() == false) return false;
        var objBounds = getThumbsInsideBounds();
        var objThumbPos = getThumbPos(objThumb);
        if (objThumbPos.min < objBounds.minPosThumbs) {
            var prevThumb = objThumb.prev();
            if (prevThumb.length) scrollToThumbMin(prevThumb); else scrollToThumbMin(objThumb);
        } else if (objThumbPos.max > objBounds.maxPosThumbs) {
            var nextThumb = objThumb.next();
            if (nextThumb.length) scrollToThumbMax(nextThumb); else scrollToThumbMax(objThumb);
        }
    }
    function scrollToSelectedThumb() {
        var selectedItem = g_gallery.getSelectedItem();
        if (selectedItem == null) return true;
        var objThumb = selectedItem.objThumbWrapper;
        if (objThumb) scrollToThumb(objThumb);
    }
    function checkAndRepositionInnerStrip() {
        if (isStripMovingEnabled() == false) return false;
        var pos = t.getInnerStripPos();
        var posFixed = t.fixInnerStripLimits(pos);
        if (pos != posFixed) t.positionInnerStrip(posFixed, true);
    }
    function checkControlsEnableDisable() {
        var isMovingEndbled = isStripMovingEnabled();
        if (isMovingEndbled == true) {
            if (g_aviaControl) g_aviaControl.enable();
            if (g_touchThumbsControl) g_touchThumbsControl.enable();
        } else {
            if (g_aviaControl) g_aviaControl.disable();
            if (g_touchThumbsControl) g_touchThumbsControl.disable();
        }
    }
    function alignInnerStrip() {
        if (isStripMovingEnabled()) return false;
        if (g_isVertical == false) g_functions.placeElement(g_objStripInner, g_options.strip_thumbs_align, 0); else g_functions.placeElement(g_objStripInner, 0, g_options.strip_thumbs_align);
    }
    function ___________EVENTS___________() {}
    function onThumbClick(objThumb) {
        if (t.isTouchMotionActive()) {
            var isSignificantPassed = g_touchThumbsControl.isSignificantPassed();
            if (isSignificantPassed == true) return true;
        }
        var objItem = g_thumbs.getItemByThumb(objThumb);
        g_gallery.selectItem(objItem);
    }
    function onThumbPlaced() {
        clearTimeout(g_temp.handle);
        g_temp.handle = setTimeout(function() {
            positionThumbs();
        }, 50);
    }
    function onItemChange() {
        var objItem = g_gallery.getSelectedItem();
        g_thumbs.setThumbSelected(objItem.objThumbWrapper);
        scrollToThumb(objItem.objThumbWrapper);
    }
    function initEvents() {
        g_thumbs.initEvents();
        var objThumbs = g_objStrip.find(".ug-thumb-wrapper");
        objThumbs.on("click touchend", function(event) {
            var clickedThumb = jQuery(this);
            onThumbClick(clickedThumb);
        });
        g_objGallery.on(g_gallery.events.ITEM_CHANGE, onItemChange);
        if (g_temp.isNotFixedThumbs) {
            jQuery(g_thumbs).on(g_thumbs.events.AFTERPLACEIMAGE, onThumbPlaced);
        }
    }
    this.destroy = function() {
        var objThumbs = g_objStrip.find(".ug-thumb-wrapper");
        objThumbs.off("click");
        objThumbs.off("touchend");
        g_objGallery.off(g_gallery.events.ITEM_CHANGE);
        jQuery(g_thumbs).off(g_thumbs.events.AFTERPLACEIMAGE);
        if (g_touchThumbsControl) g_touchThumbsControl.destroy();
        if (g_aviaControl) g_aviaControl.destroy();
        g_thumbs.destroy();
    };
    function ____________GETTERS___________() {}
    function isStripMovingEnabled() {
        if (g_sizes.stripInnerSize > g_sizes.stripActiveSize) return true; else return false;
    }
    function getThumbsInsideBounds() {
        var obj = {};
        var innerPos = t.getInnerStripPos();
        obj.minPosThumbs = innerPos * -1 + 1;
        obj.maxPosThumbs = innerPos * -1 + g_sizes.stripSize - 1;
        return obj;
    }
    function getThumbPos(objThumb) {
        var objReturn = {};
        var objPos = objThumb.position();
        if (g_isVertical == false) {
            objReturn.min = objPos.left;
            objReturn.max = objPos.left + g_sizes.thumbSize;
        } else {
            objReturn.min = objPos.top;
            objReturn.max = objPos.top + g_sizes.thumbSize;
        }
        return objReturn;
    }
    this.________EXTERNAL_GENERAL___________ = function() {};
    this.init = function(gallery, customOptions) {
        initStrip(gallery, customOptions);
    };
    this.run = function() {
        runStrip();
    };
    this.positionInnerStrip = function(pos, isAnimate) {
        if (isAnimate === undefined) var isAnimate = false;
        if (g_isVertical == false) var objPosition = {
            left: pos + "px"
        }; else var objPosition = {
            top: pos + "px"
        };
        if (isAnimate == false) {
            g_objStripInner.css(objPosition);
            t.triggerStripMoveEvent();
        } else {
            t.triggerStripMoveEvent();
            g_objStripInner.stop(true).animate(objPosition, {
                duration: g_options.strip_scroll_to_thumb_duration,
                easing: g_options.strip_scroll_to_thumb_easing,
                queue: false,
                progress: function() {
                    t.triggerStripMoveEvent();
                },
                always: function() {
                    t.triggerStripMoveEvent();
                }
            });
        }
    };
    this.triggerStripMoveEvent = function() {
        jQuery(t).trigger(t.events.STRIP_MOVE);
    };
    this.isTouchMotionActive = function() {
        if (!g_touchThumbsControl) return false;
        var isActive = g_touchThumbsControl.isTouchActive();
        return isActive;
    };
    this.isItemThumbVisible = function(objItem) {
        var objThumb = objItem.objThumbWrapper;
        var thumbPos = objThumb.position();
        var posMin = t.getInnerStripPos() * -1;
        if (g_isVertical == false) {
            var posMax = posMin + g_sizes.stripSize;
            var thumbPosMin = thumbPos.left;
            var thumbPosMax = thumbPos.left + objThumb.width();
        } else {
            var posMax = posMin + g_sizes.stripSize;
            var thumbPosMin = thumbPos.top;
            var thumbPosMax = thumbPos.top + objThumb.height();
        }
        var isVisible = false;
        if (thumbPosMax >= posMin && thumbPosMin <= posMax) isVisible = true;
        return isVisible;
    };
    this.getInnerStripPos = function() {
        if (g_isVertical == false) return g_objStripInner.position().left; else return g_objStripInner.position().top;
    };
    this.getInnerStripLimits = function() {
        var output = {};
        if (g_isVertical == false) output.maxPos = g_options.strip_padding_left; else output.maxPos = g_options.strip_padding_top;
        output.minPos = -(g_sizes.stripInnerSize - g_sizes.stripActiveSize);
        return output;
    };
    this.fixInnerStripLimits = function(distPos) {
        var minPos;
        var objLimits = t.getInnerStripLimits();
        if (distPos > objLimits.maxPos) distPos = objLimits.maxPos;
        if (distPos < objLimits.minPos) distPos = objLimits.minPos;
        return distPos;
    };
    this.scrollForeward = function() {
        scrollBy(-g_sizes.stripSize);
    };
    this.scrollBack = function() {
        scrollBy(g_sizes.stripSize);
    };
    this.________EXTERNAL_SETTERS___________ = function() {};
    this.setOptions = function(objOptions) {
        g_options = jQuery.extend(g_options, objOptions);
        g_thumbs.setOptions(objOptions);
        onAfterSetOptions();
    };
    this.setSizeVertical = function(height) {
        if (g_isVertical == false) {
            throw new Error("setSizeVertical error, the strip size is not vertical");
            return false;
        }
        var width = g_sizes.thumbSecondSize;
        var objCssStrip = {};
        objCssStrip["width"] = width + "px";
        objCssStrip["height"] = height + "px";
        g_objStrip.css(objCssStrip);
        storeStripSize(height);
        var objCssInner = {};
        objCssInner["width"] = width + "px";
        objCssInner["left"] = "0px";
        objCssInner["top"] = "0px";
        g_objStripInner.css(objCssInner);
        g_temp.is_placed = true;
        checkControlsEnableDisable();
    };
    this.setSizeHorizontal = function(width) {
        if (g_isVertical == true) {
            throw new Error("setSizeHorizontal error, the strip size is not horizontal");
            return false;
        }
        var height = g_sizes.thumbSecondSize + g_options.strip_padding_top + g_options.strip_padding_bottom;
        var objCssStrip = {};
        objCssStrip["width"] = width + "px";
        objCssStrip["height"] = height + "px";
        g_objStrip.css(objCssStrip);
        storeStripSize(width);
        var innerLeft = g_options.strip_padding_left;
        var objCssInner = {};
        objCssInner["height"] = height + "px";
        objCssInner["left"] = innerLeft + "px";
        objCssInner["top"] = "0px";
        g_objStripInner.css(objCssInner);
        g_temp.is_placed = true;
        checkControlsEnableDisable();
    };
    this.setPosition = function(left, top, offsetLeft, offsetTop) {
        g_functions.placeElement(g_objStrip, left, top, offsetLeft, offsetTop);
    };
    this.resize = function(newSize) {
        if (g_isVertical == false) {
            g_objStrip.width(newSize);
            g_sizes.stripActiveSize = newSize - g_options.strip_padding_left - g_options.strip_padding_right;
        } else {
            g_objStrip.height(newSize);
            g_sizes.stripActiveSize = newSize - g_options.strip_padding_top - g_options.strip_padding_bottom;
        }
        storeStripSize(newSize);
        checkControlsEnableDisable();
        checkAndRepositionInnerStrip();
        alignInnerStrip();
        scrollToSelectedThumb();
    };
    this.setThumbUnselected = function(objThumbWrapper) {
        g_thumbs.setThumbUnselected(objThumbWrapper);
    };
    this.setCustomThumbs = function(funcSetHtml) {
        g_thumbs.setCustomThumbs(funcSetHtml);
    };
    this.________EXTERNAL_GETTERS___________ = function() {};
    this.getObjects = function() {
        var thumbsOptions = g_thumbs.getOptions();
        var commonOpitions = jQuery.extend(g_options, thumbsOptions);
        var obj = {
            g_gallery: g_gallery,
            g_objGallery: g_objGallery,
            g_objWrapper: g_objWrapper,
            g_arrItems: g_arrItems,
            g_objStrip: g_objStrip,
            g_objStripInner: g_objStripInner,
            g_aviaControl: g_aviaControl,
            g_touchThumbsControl: g_touchThumbsControl,
            isVertical: g_isVertical,
            g_options: commonOpitions,
            g_thumbs: g_thumbs
        };
        return obj;
    };
    this.getObjThumbs = function() {
        return g_thumbs;
    };
    this.getSelectedThumb = function() {
        var selectedIndex = g_gallery.getSelectedItemIndex();
        if (selectedIndex == -1) return null;
        return g_thumbs.getThumbByIndex(selectedIndex);
    };
    this.getSizeAndPosition = function() {
        var obj = g_functions.getElementSize(g_objStrip);
        return obj;
    };
    this.getHeight = function() {
        var stripHeight = g_objStrip.outerHeight();
        return stripHeight;
    };
    this.getWidth = function() {
        var stripWidth = g_objStrip.outerWidth();
        return stripWidth;
    };
    this.getSizes = function() {
        return g_sizes;
    };
    this.isVertical = function() {
        return g_isVertical;
    };
    this.isPlaced = function() {
        return g_temp.is_placed;
    };
    this.isMoveEnabled = function() {
        var isEnabled = isStripMovingEnabled();
        return isEnabled;
    };
}

function UGTouchThumbsControl() {
    var g_parent, g_gallery, g_objGallery, g_objects;
    var g_objStrip, g_objStripInner, g_options, g_isVertical;
    var g_functions = new UGFunctions();
    var g_serviceParams = {
        touch_portion_time: 200,
        thumb_touch_slowFactor: 0,
        minDeltaTime: 70,
        minPath: 10,
        limitsBreakAddition: 30,
        returnAnimateSpeed: 500,
        animationEasing: "easeOutCubic",
        returnAnimationEasing: "easeOutCubic"
    };
    var g_temp = {
        touch_active: false,
        loop_active: false,
        mousePos: 0,
        innerPos: 0,
        startPos: 0,
        startTime: 0,
        lastTime: 0,
        buttonReleaseTime: 0,
        lastPos: 0,
        lastPortionPos: 0,
        lastDeltaTime: 0,
        lastDeltaPos: 0,
        speed: 0,
        handle: "",
        touchEnabled: false,
        isControlEnabled: true
    };
    this.enable = function() {
        g_temp.isControlEnabled = true;
    };
    this.disable = function() {
        g_temp.isControlEnabled = false;
    };
    this.init = function(objStrip) {
        g_parent = objStrip;
        g_objects = objStrip.getObjects();
        g_gallery = g_objects.g_gallery;
        g_objGallery = g_objects.g_objGallery;
        g_objStrip = g_objects.g_objStrip;
        g_objStripInner = g_objects.g_objStripInner;
        g_options = g_objects.g_options;
        g_isVertical = g_objects.isVertical;
        setServiceParams();
        initEvents();
    };
    function getActionVars() {
        var currentTime = jQuery.now();
        var obj = {};
        obj.passedTime = g_temp.lastTime - g_temp.startTime;
        obj.lastActiveTime = currentTime - g_temp.buttonReleaseTime;
        obj.passedDistance = g_temp.lastPos - g_temp.startPos;
        obj.passedDistanceAbs = Math.abs(obj.passedDistance);
        return obj;
    }
    this.isSignificantPassed = function() {
        var objVars = getActionVars();
        if (objVars.passedTime > 300) return true;
        if (objVars.passedDistanceAbs > 30) return true;
        return false;
    };
    this.isTouchActive = function() {
        if (g_temp.touch_active == true) return true;
        if (g_objStripInner.is(":animated") == true) return true;
        var objVars = getActionVars();
        if (objVars.lastActiveTime < 50) return true;
        return false;
    };
    function setServiceParams() {
        g_serviceParams.thumb_touch_slowFactor = g_functions.normalizeSetting(5e-5, .01, 1, 100, g_options.strip_thumb_touch_sensetivity, true);
    }
    function getMouseOrientPosition(event) {
        if (g_isVertical == false) return g_functions.getMousePosition(event).pageX; else return g_functions.getMousePosition(event).pageY;
    }
    function handleStripDrag(mousePos) {
        var diff = g_temp.mousePos - mousePos;
        var distPos = g_temp.innerPos - diff;
        var objLimits = g_parent.getInnerStripLimits();
        if (distPos > objLimits.maxPos) {
            var path = distPos - objLimits.maxPos;
            distPos = objLimits.maxPos + path / 3;
        }
        if (distPos < objLimits.minPos) {
            var path = objLimits.minPos - distPos;
            distPos = objLimits.minPos - path / 3;
        }
        g_parent.positionInnerStrip(distPos);
    }
    function storeInitTouchValues(pagePos) {
        var currentInnerPos = g_parent.getInnerStripPos();
        g_temp.mousePos = pagePos;
        g_temp.innerPos = currentInnerPos;
        g_temp.lastPortionPos = currentInnerPos;
        g_temp.lastDeltaTime = 0;
        g_temp.lastDeltaPos = 0;
        g_temp.startTime = jQuery.now();
        g_temp.startPos = g_temp.innerPos;
        g_temp.lastTime = g_temp.startTime;
        g_temp.lastPos = g_temp.startPos;
        g_temp.speed = 0;
    }
    function storeTouchPortionData() {
        var currentTime = jQuery.now();
        var deltaTime = currentTime - g_temp.lastTime;
        if (deltaTime >= g_serviceParams.touch_portion_time) {
            g_temp.lastDeltaTime = currentTime - g_temp.lastTime;
            if (g_temp.lastDeltaTime > g_serviceParams.touch_portion_time) g_temp.lastDeltaTime = g_serviceParams.touch_portion_time;
            g_temp.lastDeltaPos = g_temp.lastPos - g_temp.lastPortionPos;
            g_temp.lastPortionPos = g_temp.lastPos;
            g_temp.lastTime = currentTime;
        }
    }
    function continueTouchMotion() {
        var slowFactor = g_serviceParams.thumb_touch_slowFactor;
        var minDeltaTime = g_serviceParams.minDeltaTime;
        var minPath = g_serviceParams.minPath;
        var currentInnerPos = g_parent.getInnerStripPos();
        var currentTime = jQuery.now();
        var deltaTime = currentTime - g_temp.lastTime;
        var deltaPos = currentInnerPos - g_temp.lastPortionPos;
        if (deltaTime < minDeltaTime && g_temp.lastDeltaTime > 0) {
            deltaTime = g_temp.lastDeltaTime;
            deltaPos = g_temp.lastDeltaPos + deltaPos;
        }
        if (deltaTime < minDeltaTime) deltaTime = minDeltaTime;
        var dir = deltaPos > 0 ? 1 : -1;
        var speed = 0;
        if (deltaTime > 0) speed = deltaPos / deltaTime;
        var path = speed * speed / (slowFactor * 2) * dir;
        if (Math.abs(path) <= minPath) path = 0;
        var innerStripPos = g_parent.getInnerStripPos();
        var newPos = innerStripPos + path;
        var correctPos = g_parent.fixInnerStripLimits(newPos);
        var objLimits = g_parent.getInnerStripLimits();
        var limitsBreakAddition = g_serviceParams.limitsBreakAddition;
        var doQueue = false;
        var returnPos = correctPos;
        if (newPos > objLimits.maxPos) {
            doQueue = true;
            correctPos = limitsBreakAddition;
            if (newPos < limitsBreakAddition) correctPos = newPos;
        }
        if (newPos < objLimits.minPos) {
            doQueue = true;
            var maxStopPos = objLimits.minPos - limitsBreakAddition;
            correctPos = maxStopPos;
            if (newPos > maxStopPos) correctPos = newPos;
        }
        var correctPath = correctPos - innerStripPos;
        var animateSpeed = Math.abs(Math.round(speed / slowFactor));
        if (path != 0) animateSpeed = animateSpeed * correctPath / path;
        if (innerStripPos != correctPos) {
            var animateProps = {
                left: correctPos + "px"
            };
            if (g_isVertical == true) animateProps = {
                top: correctPos + "px"
            };
            g_objStripInner.animate(animateProps, {
                duration: animateSpeed,
                easing: g_serviceParams.animationEasing,
                queue: true,
                progress: onAnimateProgress
            });
        }
        if (doQueue == true) {
            var returnAnimateSpeed = g_serviceParams.returnAnimateSpeed;
            var returnAnimateProps = {
                left: returnPos + "px"
            };
            if (g_isVertical == true) returnAnimateProps = {
                top: returnPos + "px"
            };
            g_objStripInner.animate(returnAnimateProps, {
                duration: returnAnimateSpeed,
                easing: g_serviceParams.returnAnimationEasing,
                queue: true,
                progress: onAnimateProgress
            });
        }
    }
    function onAnimateProgress() {
        g_temp.lastPos = g_parent.getInnerStripPos();
        g_parent.triggerStripMoveEvent();
    }
    function startStripTouchLoop() {
        if (g_temp.loop_active == true) return true;
        g_temp.loop_active = true;
        g_temp.handle = setInterval(storeTouchPortionData, 10);
    }
    function endStripTouchLoop(event) {
        if (g_temp.loop_active == false) return true;
        if (event) {
            var pagePos = getMouseOrientPosition(event);
            continueTouchMotion(pagePos);
        }
        g_temp.loop_active = false;
        g_temp.handle = clearInterval(g_temp.handle);
    }
    function onTouchEnd(event) {
        if (g_temp.isControlEnabled == false) return true;
        g_temp.buttonReleaseTime = jQuery.now();
        if (g_temp.touch_active == false) {
            endStripTouchLoop(event);
            return true;
        }
        event.preventDefault();
        g_temp.touch_active = false;
        endStripTouchLoop(event);
        g_objStrip.removeClass("ug-dragging");
    }
    function onTouchStart(event) {
        if (g_temp.isControlEnabled == false) return true;
        event.preventDefault();
        g_temp.touch_active = true;
        var pagePos = getMouseOrientPosition(event);
        g_objStripInner.stop(true);
        storeInitTouchValues(pagePos);
        startStripTouchLoop();
        g_objStrip.addClass("ug-dragging");
    }
    function onTouchMove(event) {
        if (g_temp.isControlEnabled == false) return true;
        if (g_temp.touch_active == false) return true;
        event.preventDefault();
        if (event.buttons == 0) {
            g_temp.touch_active = false;
            endStripTouchLoop(event);
            return true;
        }
        var pagePos = getMouseOrientPosition(event);
        g_temp.lastPos = g_parent.getInnerStripPos();
        handleStripDrag(pagePos);
        storeTouchPortionData();
    }
    function initEvents() {
        g_objStrip.bind("mousedown touchstart", onTouchStart);
        jQuery(window).add("body").bind("mouseup touchend", onTouchEnd);
        jQuery("body").bind("mousemove touchmove", onTouchMove);
    }
    this.destroy = function() {
        g_objStrip.unbind("mousedown");
        g_objStrip.unbind("touchstart");
        jQuery(window).add("body").unbind("mouseup").unbind("touchend");
        jQuery("body").unbind("mousemove").unbind("touchmove");
    };
}

function UGPanelsBase() {
    var g_temp, g_panel, g_objPanel, g_options, g_objThis;
    var g_gallery = new UniteGalleryMain();
    var t = this, g_objHandle, g_objGallery;
    var g_functions = new UGFunctions();
    this.init = function(gallery, g_tempArg, g_panelArg, options, g_objThisArg) {
        g_temp = g_tempArg;
        g_panel = g_panelArg;
        g_gallery = gallery;
        g_options = options;
        g_objThis = g_objThisArg;
        g_objGallery = jQuery(g_gallery);
    };
    this.setHtml = function(g_objPanelArg) {
        g_objPanel = g_objPanelArg;
        if (g_temp.panelType == "strip") var enable_handle = g_options.strippanel_enable_handle; else var enable_handle = g_options.gridpanel_enable_handle;
        if (enable_handle == true) {
            g_objHandle = new UGPanelHandle();
            g_objHandle.init(g_panel, g_objPanel, g_options, g_temp.panelType, g_gallery);
            g_objHandle.setHtml();
        }
        if (g_temp.isDisabledAtStart === true) {
            var html = "<div class='ug-overlay-disabled'></div>";
            g_objPanel.append(html);
            setTimeout(function() {
                g_objPanel.children(".ug-overlay-disabled").hide();
            }, g_temp.disabledAtStartTimeout);
        }
    };
    this.placeElements = function() {
        if (g_objHandle) g_objHandle.placeHandle();
    };
    this.initEvents = function() {
        if (g_objHandle) {
            g_objHandle.initEvents();
            g_objGallery.on(g_gallery.events.SLIDER_ACTION_START, function() {
                g_objHandle.hideHandle();
            });
            g_objGallery.on(g_gallery.events.SLIDER_ACTION_END, function() {
                g_objHandle.showHandle();
            });
        }
    };
    this.destroy = function() {
        if (g_objHandle) {
            g_objHandle.destroy();
            g_objGallery.off(g_gallery.events.SLIDER_ACTION_START);
            g_objGallery.off(g_gallery.events.SLIDER_ACTION_END);
        }
    };
    function placePanelAnimation(panelDest, functionOnComplete) {
        switch (g_temp.orientation) {
          case "right":
          case "left":
            var objCss = {
                left: panelDest + "px"
            };
            break;

          case "top":
          case "bottom":
            var objCss = {
                top: panelDest + "px"
            };
            break;
        }
        g_objPanel.stop(true).animate(objCss, {
            duration: 300,
            easing: "easeInOutQuad",
            queue: false,
            complete: function() {
                if (functionOnComplete) functionOnComplete();
            }
        });
    }
    function placePanelNoAnimation(panelDest) {
        switch (g_temp.orientation) {
          case "right":
          case "left":
            g_functions.placeElement(g_objPanel, panelDest, null);
            break;

          case "top":
          case "bottom":
            g_functions.placeElement(g_objPanel, null, panelDest);
            break;
        }
    }
    function onPanelSlideFinish() {
        g_objThis.trigger(g_panel.events.FINISH_MOVE);
    }
    this.openPanel = function(noAnimation) {
        if (!noAnimation) var noAnimation = false;
        if (g_objPanel.is(":animated")) return false;
        if (g_temp.isClosed == false) return false;
        g_temp.isClosed = false;
        g_objThis.trigger(g_panel.events.OPEN_PANEL);
        if (noAnimation === false) placePanelAnimation(g_temp.originalPos, onPanelSlideFinish); else {
            placePanelNoAnimation(g_temp.originalPos);
            onPanelSlideFinish();
        }
    };
    this.closePanel = function(noAnimation) {
        if (!noAnimation) var noAnimation = false;
        if (g_objPanel.is(":animated")) return false;
        if (g_temp.isClosed == true) return false;
        var panelDest = t.getClosedPanelDest();
        g_temp.isClosed = true;
        g_objThis.trigger(g_panel.events.CLOSE_PANEL);
        if (noAnimation === false) placePanelAnimation(panelDest, onPanelSlideFinish); else {
            placePanelNoAnimation(panelDest);
            onPanelSlideFinish();
        }
    };
    this.setClosedState = function(originalPos) {
        g_temp.originalPos = originalPos;
        g_objThis.trigger(g_panel.events.CLOSE_PANEL);
        g_temp.isClosed = true;
    };
    this.setOpenedState = function(originalPos) {
        g_objThis.trigger(g_panel.events.OPEN_PANEL);
        g_temp.isClosed = false;
    };
    this.getClosedPanelDest = function() {
        var objPanelSize = g_functions.getElementSize(g_objPanel), panelDest;
        switch (g_temp.orientation) {
          case "left":
            g_temp.originalPos = objPanelSize.left;
            panelDest = -g_temp.panelWidth;
            break;

          case "right":
            g_temp.originalPos = objPanelSize.left;
            var gallerySize = g_gallery.getSize();
            panelDest = gallerySize.width;
            break;

          case "top":
            g_temp.originalPos = objPanelSize.top;
            panelDest = -g_temp.panelHeight;
            break;

          case "bottom":
            g_temp.originalPos = objPanelSize.top;
            var gallerySize = g_gallery.getSize();
            panelDest = gallerySize.height;
            break;
        }
        return panelDest;
    };
    this.isPanelClosed = function() {
        return g_temp.isClosed;
    };
    this.setDisabledAtStart = function(timeout) {
        if (timeout <= 0) return false;
        g_temp.isDisabledAtStart = true;
        g_temp.disabledAtStartTimeout = timeout;
    };
}

function UGPanelHandle() {
    var t = this, g_objPanel, g_panel, g_objHandleTip, g_panelOptions = {};
    var g_functions = new UGFunctions();
    var g_options = {
        panel_handle_align: "top",
        panel_handle_offset: 0,
        panel_handle_skin: 0
    };
    this.init = function(panel, objPanel, panelOptions, panelType, gallery) {
        g_panel = panel;
        g_objPanel = objPanel;
        switch (panelType) {
          case "grid":
            g_options.panel_handle_align = panelOptions.gridpanel_handle_align;
            g_options.panel_handle_offset = panelOptions.gridpanel_handle_offset;
            g_options.panel_handle_skin = panelOptions.gridpanel_handle_skin;
            break;

          case "strip":
            g_options.panel_handle_align = panelOptions.strippanel_handle_align;
            g_options.panel_handle_offset = panelOptions.strippanel_handle_offset;
            g_options.panel_handle_skin = panelOptions.strippanel_handle_skin;
            break;

          default:
            throw new Error("Panel handle error: wrong panel type: " + panelType);
            break;
        }
        var galleryOptions = gallery.getOptions();
        var globalSkin = galleryOptions.gallery_skin;
        if (g_options.panel_handle_skin == "") g_options.panel_handle_skin = globalSkin;
    };
    this.setHtml = function() {
        var orientation = g_panel.getOrientation();
        var classTip = "ug-panel-handle-tip";
        switch (orientation) {
          case "right":
            classTip += " ug-handle-tip-left";
            break;

          case "left":
            classTip += " ug-handle-tip-right";
            break;

          case "bottom":
            classTip += " ug-handle-tip-top";
            break;

          case "top":
            classTip += " ug-handle-tip-bottom";
            break;
        }
        g_objPanel.append("<div class='" + classTip + " ug-skin-" + g_options.panel_handle_skin + "'></div>");
        g_objHandleTip = g_objPanel.children(".ug-panel-handle-tip");
    };
    function removeHoverState() {
        g_objHandleTip.removeClass("ug-button-hover");
    }
    function setClosedState() {
        g_objHandleTip.addClass("ug-button-closed");
    }
    function removeClosedState() {
        g_objHandleTip.removeClass("ug-button-closed");
    }
    function onHandleClick(event) {
        event.stopPropagation();
        event.stopImmediatePropagation();
        if (g_functions.validateClickTouchstartEvent(event.type) == false) return true;
        if (g_panel.isPanelClosed()) g_panel.openPanel(); else g_panel.closePanel();
    }
    this.initEvents = function() {
        g_functions.addClassOnHover(g_objHandleTip);
        g_objHandleTip.bind("click touchstart", onHandleClick);
        jQuery(g_panel).on(g_panel.events.OPEN_PANEL, function() {
            removeHoverState();
            removeClosedState();
        });
        jQuery(g_panel).on(g_panel.events.CLOSE_PANEL, function() {
            removeHoverState();
            setClosedState();
        });
    };
    this.destroy = function() {
        g_functions.destroyButton(g_objHandleTip);
        jQuery(g_panel).off(g_panel.events.OPEN_PANEL);
        jQuery(g_panel).off(g_panel.events.CLOSE_PANEL);
    };
    function checkAndFixAlign() {
        var orientation = g_panel.getOrientation();
        switch (orientation) {
          case "right":
          case "left":
            if (g_options.panel_handle_align != "top" && g_options.panel_handle_align != "bottom") g_options.panel_handle_align = "top";
            break;

          case "bottom":
            if (g_options.panel_handle_align != "left" && g_options.panel_handle_align != "right") g_options.panel_handle_align = "left";
            break;

          case "top":
            if (g_options.panel_handle_align != "left" && g_options.panel_handle_align != "right") g_options.panel_handle_align = "right";
            break;
        }
    }
    this.placeHandle = function() {
        var handleSize = g_functions.getElementSize(g_objHandleTip);
        checkAndFixAlign();
        var orientation = g_panel.getOrientation();
        switch (orientation) {
          case "left":
            g_functions.placeElement(g_objHandleTip, "right", g_options.panel_handle_align, -handleSize.width);
            break;

          case "right":
            g_functions.placeElement(g_objHandleTip, -handleSize.width, g_options.panel_handle_align, 0, g_options.panel_handle_offset);
            break;

          case "top":
            g_functions.placeElement(g_objHandleTip, g_options.panel_handle_align, "bottom", g_options.panel_handle_offset, -handleSize.height);
            break;

          case "bottom":
            g_functions.placeElement(g_objHandleTip, g_options.panel_handle_align, "top", g_options.panel_handle_offset, -handleSize.height);
            break;

          default:
            throw new Error("Wrong panel orientation: " + orientation);
            break;
        }
    };
    this.hideHandle = function() {
        if (g_objHandleTip.is(":visible") == true) g_objHandleTip.hide();
    };
    this.showHandle = function() {
        if (g_objHandleTip.is(":visible") == false) g_objHandleTip.show();
    };
}

function UGStripPanel() {
    var t = this, g_objThis = jQuery(this);
    var g_gallery = new UniteGalleryMain(), g_objGallery, g_objWrapper, g_objPanel;
    var g_functions = new UGFunctions(), g_objStrip = new UGThumbsStrip(), g_panelBase = new UGPanelsBase();
    var g_objButtonNext, g_objButtonPrev;
    this.events = {
        FINISH_MOVE: "gridpanel_move_finish",
        OPEN_PANEL: "open_panel",
        CLOSE_PANEL: "close_panel"
    };
    var g_options = {
        strippanel_vertical_type: false,
        strippanel_padding_top: 8,
        strippanel_padding_bottom: 8,
        strippanel_padding_left: 0,
        strippanel_padding_right: 0,
        strippanel_enable_buttons: true,
        strippanel_buttons_skin: "",
        strippanel_padding_buttons: 2,
        strippanel_buttons_role: "scroll_strip",
        strippanel_enable_handle: true,
        strippanel_handle_align: "top",
        strippanel_handle_offset: 0,
        strippanel_handle_skin: "",
        strippanel_background_color: ""
    };
    var g_defaults_vertical = {
        strip_vertical_type: true,
        strippanel_padding_left: 8,
        strippanel_padding_right: 8,
        strippanel_padding_top: 0,
        strippanel_padding_bottom: 0
    };
    var g_defaults_no_buttons = {
        strippanel_padding_left: 8,
        strippanel_padding_right: 8,
        strippanel_padding_top: 8,
        strippanel_padding_bottom: 8
    };
    var g_temp = {
        panelType: "strip",
        panelWidth: 0,
        panelHeight: 0,
        isEventsInited: false,
        isClosed: false,
        orientation: null,
        originalPos: null,
        isFirstRun: true
    };
    function initPanel(gallery, customOptions) {
        g_gallery = gallery;
        g_objGallery = jQuery(g_gallery);
        g_options = jQuery.extend(g_options, customOptions);
        var repeatCustomOptions = false;
        if (g_options.strippanel_vertical_type == true) {
            g_options = jQuery.extend(g_options, g_defaults_vertical);
            repeatCustomOptions = true;
        }
        if (g_options.strippanel_enable_buttons == false) {
            g_options = jQuery.extend(g_options, g_defaults_no_buttons);
            repeatCustomOptions = true;
        }
        if (repeatCustomOptions == true) g_options = jQuery.extend(g_options, customOptions);
        var galleryOptions = g_gallery.getOptions();
        var globalSkin = galleryOptions.gallery_skin;
        if (g_options.strippanel_buttons_skin == "") g_options.strippanel_buttons_skin = globalSkin;
        g_objWrapper = g_gallery.getElement();
        g_panelBase.init(g_gallery, g_temp, t, g_options, g_objThis);
        g_objStrip = new UGThumbsStrip();
        g_objStrip.init(g_gallery, g_options);
    }
    function validatePanelBeforeRun() {
        if (g_options.strippanel_vertical_type == false) {
            if (g_temp.panelWidth == 0) {
                throw new Error("Strip panel error: The width not set, please set width");
                return false;
            }
        } else {
            if (g_temp.panelHeight == 0) {
                throw new Error("Strip panel error: The height not set, please set height");
                return false;
            }
        }
        if (g_temp.orientation == null) {
            throw new Error("Wrong orientation, please set panel orientation before run");
            return false;
        }
        return true;
    }
    function runPanel() {
        if (g_temp.isFirstRun == true && validatePanelBeforeRun() == false) return false;
        g_objStrip.run();
        setElementsSize();
        placeElements();
        initEvents();
        g_temp.isFirstRun = false;
        checkSideButtons();
    }
    function setPanelHtml(parentContainer) {
        if (!parentContainer) var parentContainer = g_objWrapper;
        parentContainer.append("<div class='ug-strip-panel'></div>");
        g_objPanel = parentContainer.children(".ug-strip-panel");
        if (g_options.strippanel_enable_buttons == true) {
            var arrowPrevClass = "ug-strip-arrow-left";
            var arrowNextClass = "ug-strip-arrow-right";
            if (g_options.strippanel_vertical_type == true) {
                arrowPrevClass = "ug-strip-arrow-up";
                arrowNextClass = "ug-strip-arrow-down";
            }
            g_objPanel.append("<div class='ug-strip-arrow " + arrowPrevClass + " ug-skin-" + g_options.strippanel_buttons_skin + "'><div class='ug-strip-arrow-tip'></div></div>");
            g_objPanel.append("<div class='ug-strip-arrow " + arrowNextClass + " ug-skin-" + g_options.strippanel_buttons_skin + "'><div class='ug-strip-arrow-tip'></div></div>");
        }
        g_panelBase.setHtml(g_objPanel);
        g_objStrip.setHtml(g_objPanel);
        if (g_options.strippanel_enable_buttons == true) {
            g_objButtonPrev = g_objPanel.children("." + arrowPrevClass);
            g_objButtonNext = g_objPanel.children("." + arrowNextClass);
        }
        setHtmlProperties();
    }
    function setHtmlProperties() {
        if (g_options.strippanel_background_color != "") g_objPanel.css("background-color", g_options.strippanel_background_color);
    }
    function setElementsSize_hor() {
        var stripHeight = g_objStrip.getHeight();
        var panelWidth = g_temp.panelWidth;
        if (g_objButtonNext) {
            g_objButtonPrev.height(stripHeight);
            g_objButtonNext.height(stripHeight);
            var prevTip = g_objButtonPrev.children(".ug-strip-arrow-tip");
            g_functions.placeElement(prevTip, "center", "middle");
            var nextTip = g_objButtonNext.children(".ug-strip-arrow-tip");
            g_functions.placeElement(nextTip, "center", "middle");
        }
        var panelHeight = stripHeight + g_options.strippanel_padding_top + g_options.strippanel_padding_bottom;
        g_objPanel.width(panelWidth);
        g_objPanel.height(panelHeight);
        g_temp.panelHeight = panelHeight;
        var stripWidth = panelWidth - g_options.strippanel_padding_left - g_options.strippanel_padding_right;
        if (g_objButtonNext) {
            var buttonWidth = g_objButtonNext.outerWidth();
            stripWidth = stripWidth - buttonWidth * 2 - g_options.strippanel_padding_buttons * 2;
        }
        g_objStrip.resize(stripWidth);
    }
    function setElementsSize_vert() {
        var stripWidth = g_objStrip.getWidth();
        var panelHeight = g_temp.panelHeight;
        if (g_objButtonNext) {
            g_objButtonPrev.width(stripWidth);
            g_objButtonNext.width(stripWidth);
            var prevTip = g_objButtonPrev.children(".ug-strip-arrow-tip");
            g_functions.placeElement(prevTip, "center", "middle");
            var nextTip = g_objButtonNext.children(".ug-strip-arrow-tip");
            g_functions.placeElement(nextTip, "center", "middle");
        }
        var panelWidth = stripWidth + g_options.strippanel_padding_left + g_options.strippanel_padding_right;
        g_objPanel.width(panelWidth);
        g_objPanel.height(panelHeight);
        g_temp.panelWidth = panelWidth;
        var stripHeight = panelHeight - g_options.strippanel_padding_top - g_options.strippanel_padding_bottom;
        if (g_objButtonNext) {
            var buttonHeight = g_objButtonNext.outerHeight();
            stripHeight = stripHeight - buttonHeight * 2 - g_options.strippanel_padding_buttons * 2;
        }
        g_objStrip.resize(stripHeight);
    }
    function setElementsSize() {
        if (g_options.strippanel_vertical_type == false) setElementsSize_hor(); else setElementsSize_vert();
    }
    function placeElements_hor() {
        if (g_objButtonNext) {
            g_functions.placeElement(g_objButtonPrev, "left", "top", g_options.strippanel_padding_left, g_options.strippanel_padding_top);
            g_functions.placeElement(g_objButtonNext, "right", "top", g_options.strippanel_padding_right, g_options.strippanel_padding_top);
        }
        var stripX = g_options.strippanel_padding_left;
        if (g_objButtonNext) stripX += g_objButtonNext.outerWidth() + g_options.strippanel_padding_buttons;
        g_objStrip.setPosition(stripX, g_options.strippanel_padding_top);
    }
    function placeElements_vert() {
        if (g_objButtonNext) {
            g_functions.placeElement(g_objButtonPrev, "left", "top", g_options.strippanel_padding_left, g_options.strippanel_padding_top);
            g_functions.placeElement(g_objButtonNext, "left", "bottom", g_options.strippanel_padding_left, g_options.strippanel_padding_bottom);
        }
        var stripY = g_options.strippanel_padding_top;
        if (g_objButtonNext) stripY += g_objButtonNext.outerHeight() + g_options.strippanel_padding_buttons;
        g_objStrip.setPosition(g_options.strippanel_padding_left, stripY);
    }
    function placeElements() {
        if (g_options.strippanel_vertical_type == false) placeElements_hor(); else placeElements_vert();
        g_panelBase.placeElements();
    }
    function __________EVENTS___________() {}
    function onNextButtonClick(objButton) {
        if (g_functions.isButtonDisabled(objButton)) return true;
        if (g_options.strippanel_buttons_role == "advance_item") g_gallery.nextItem(); else g_objStrip.scrollForeward();
    }
    function onPrevButtonClick(objButton) {
        if (g_functions.isButtonDisabled(objButton)) return true;
        if (g_options.strippanel_buttons_role == "advance_item") g_gallery.prevItem(); else g_objStrip.scrollBack();
    }
    function checkSideButtons() {
        if (!g_objButtonNext) return true;
        if (g_objStrip.isMoveEnabled() == false) {
            g_functions.disableButton(g_objButtonPrev);
            g_functions.disableButton(g_objButtonNext);
            return true;
        }
        var limits = g_objStrip.getInnerStripLimits();
        var pos = g_objStrip.getInnerStripPos();
        if (pos >= limits.maxPos) {
            g_functions.disableButton(g_objButtonPrev);
        } else {
            g_functions.enableButton(g_objButtonPrev);
        }
        if (pos <= limits.minPos) g_functions.disableButton(g_objButtonNext); else g_functions.enableButton(g_objButtonNext);
    }
    function onStripMove() {
        checkSideButtons();
    }
    function onItemChange() {
        if (g_gallery.isLastItem()) g_functions.disableButton(g_objButtonNext); else g_functions.enableButton(g_objButtonNext);
        if (g_gallery.isFirstItem()) g_functions.disableButton(g_objButtonPrev); else g_functions.enableButton(g_objButtonPrev);
    }
    function initEvents() {
        if (g_temp.isEventsInited == true) return false;
        g_temp.isEventsInited = true;
        if (g_objButtonNext) {
            g_functions.addClassOnHover(g_objButtonNext, "ug-button-hover");
            g_functions.addClassOnHover(g_objButtonPrev, "ug-button-hover");
            g_functions.setButtonOnClick(g_objButtonPrev, onPrevButtonClick);
            g_functions.setButtonOnClick(g_objButtonNext, onNextButtonClick);
            if (g_options.strippanel_buttons_role != "advance_item") {
                jQuery(g_objStrip).on(g_objStrip.events.STRIP_MOVE, onStripMove);
                jQuery(g_objStrip).on(g_objStrip.events.INNER_SIZE_CHANGE, checkSideButtons);
                g_objGallery.on(g_gallery.events.SIZE_CHANGE, checkSideButtons);
            } else {
                var galleryOptions = g_gallery.getOptions();
                if (galleryOptions.gallery_carousel == false) jQuery(g_gallery).on(g_gallery.events.ITEM_CHANGE, onItemChange);
            }
        }
        g_panelBase.initEvents();
    }
    this.destroy = function() {
        if (g_objButtonNext) {
            g_functions.destroyButton(g_objButtonNext);
            g_functions.destroyButton(g_objButtonPrev);
            jQuery(g_objStrip).off(g_objStrip.events.STRIP_MOVE);
            jQuery(g_gallery).off(g_gallery.events.ITEM_CHANGE);
            jQuery(g_gallery).off(g_gallery.events.SIZE_CHANGE);
        }
        g_panelBase.destroy();
        g_objStrip.destroy();
    };
    this.getOrientation = function() {
        return g_temp.orientation;
    };
    this.setOrientation = function(orientation) {
        g_temp.orientation = orientation;
    };
    this.init = function(gallery, customOptions) {
        initPanel(gallery, customOptions);
    };
    this.run = function() {
        runPanel();
    };
    this.setHtml = function(parentContainer) {
        setPanelHtml(parentContainer);
    };
    this.getElement = function() {
        return g_objPanel;
    };
    this.getSize = function() {
        var objSize = g_functions.getElementSize(g_objPanel);
        return objSize;
    };
    this.setWidth = function(width) {
        g_temp.panelWidth = width;
    };
    this.setHeight = function(height) {
        g_temp.panelHeight = height;
    };
    this.resize = function(newWidth) {
        t.setWidth(newWidth);
        setElementsSize();
        placeElements();
    };
    this.__________Functions_From_Base_____ = function() {};
    this.isPanelClosed = function() {
        return g_panelBase.isPanelClosed();
    };
    this.getClosedPanelDest = function() {
        return g_panelBase.getClosedPanelDest();
    };
    this.openPanel = function(noAnimation) {
        g_panelBase.openPanel(noAnimation);
    };
    this.closePanel = function(noAnimation) {
        g_panelBase.closePanel(noAnimation);
    };
    this.setOpenedState = function(originalPos) {
        g_panelBase.setOpenedState(originalPos);
    };
    this.setClosedState = function(originalPos) {
        g_panelBase.setClosedState(originalPos);
    };
    this.setCustomThumbs = function(funcSetHtml) {
        g_objStrip.setCustomThumbs(funcSetHtml);
    };
    this.setDisabledAtStart = function(timeout) {
        g_panelBase.setDisabledAtStart(timeout);
    };
}

function UGGridPanel() {
    var t = this, g_objThis = jQuery(this);
    var g_gallery = new UniteGalleryMain(), g_objGallery, g_objWrapper, g_objPanel;
    var g_functions = new UGFunctions();
    var g_objGrid = new UGThumbsGrid();
    var g_panelBase = new UGPanelsBase();
    var g_objArrowNext, g_objArrowPrev;
    this.events = {
        FINISH_MOVE: "gridpanel_move_finish",
        OPEN_PANEL: "open_panel",
        CLOSE_PANEL: "close_panel"
    };
    var g_options = {
        gridpanel_vertical_scroll: true,
        gridpanel_grid_align: "middle",
        gridpanel_padding_border_top: 10,
        gridpanel_padding_border_bottom: 4,
        gridpanel_padding_border_left: 10,
        gridpanel_padding_border_right: 10,
        gridpanel_arrows_skin: "",
        gridpanel_arrows_align_vert: "middle",
        gridpanel_arrows_padding_vert: 4,
        gridpanel_arrows_align_hor: "center",
        gridpanel_arrows_padding_hor: 10,
        gridpanel_space_between_arrows: 20,
        gridpanel_arrows_always_on: false,
        gridpanel_enable_handle: true,
        gridpanel_handle_align: "top",
        gridpanel_handle_offset: 0,
        gridpanel_handle_skin: "",
        gridpanel_background_color: ""
    };
    var g_defaultsVertical = {
        gridpanel_grid_align: "middle",
        gridpanel_padding_border_top: 2,
        gridpanel_padding_border_bottom: 2
    };
    var g_defaultsHorType = {
        gridpanel_grid_align: "center"
    };
    var g_temp = {
        panelType: "grid",
        isHorType: false,
        arrowsVisible: false,
        panelHeight: 0,
        panelWidth: 0,
        originalPosX: null,
        isEventsInited: false,
        isClosed: false,
        orientation: null
    };
    function initGridPanel(gallery, customOptions) {
        g_gallery = gallery;
        validateOrientation();
        if (customOptions && customOptions.vertical_scroll) {
            g_options.gridpanel_vertical_scroll = customOptions.vertical_scroll;
        }
        g_options = jQuery.extend(g_options, customOptions);
        if (g_temp.isHorType == true) {
            g_options = jQuery.extend(g_options, g_defaultsHorType);
            g_options = jQuery.extend(g_options, customOptions);
        } else if (g_options.gridpanel_vertical_scroll == true) {
            g_options = jQuery.extend(g_options, g_defaultsVertical);
            g_options = jQuery.extend(g_options, customOptions);
            g_options.grid_panes_direction = "bottom";
        }
        var galleryOptions = g_gallery.getOptions();
        var globalSkin = galleryOptions.gallery_skin;
        if (g_options.gridpanel_arrows_skin == "") g_options.gridpanel_arrows_skin = globalSkin;
        var objects = gallery.getObjects();
        g_objWrapper = objects.g_objWrapper;
        g_panelBase.init(g_gallery, g_temp, t, g_options, g_objThis);
        g_objGrid = new UGThumbsGrid();
        g_objGrid.init(g_gallery, g_options);
    }
    function validateOrientation() {
        if (g_temp.orientation == null) throw new Error("Wrong orientation, please set panel orientation before run");
    }
    function runPanel() {
        validateOrientation();
        processOptions();
        g_objGrid.run();
        setArrows();
        setPanelSize();
        placeElements();
        initEvents();
    }
    function setHtmlPanel() {
        g_objWrapper.append("<div class='ug-grid-panel'></div>");
        g_objPanel = g_objWrapper.children(".ug-grid-panel");
        if (g_temp.isHorType) {
            g_objPanel.append("<div class='grid-arrow grid-arrow-left-hortype ug-skin-" + g_options.gridpanel_arrows_skin + "'></div>");
            g_objPanel.append("<div class='grid-arrow grid-arrow-right-hortype ug-skin-" + g_options.gridpanel_arrows_skin + "'></div>");
            g_objArrowPrev = g_objPanel.children(".grid-arrow-left-hortype");
            g_objArrowNext = g_objPanel.children(".grid-arrow-right-hortype");
        } else if (g_options.gridpanel_vertical_scroll == false) {
            g_objPanel.append("<div class='grid-arrow grid-arrow-left ug-skin-" + g_options.gridpanel_arrows_skin + "'></div>");
            g_objPanel.append("<div class='grid-arrow grid-arrow-right ug-skin-" + g_options.gridpanel_arrows_skin + "'></div>");
            g_objArrowPrev = g_objPanel.children(".grid-arrow-left");
            g_objArrowNext = g_objPanel.children(".grid-arrow-right");
        } else {
            g_objPanel.append("<div class='grid-arrow grid-arrow-up ug-skin-" + g_options.gridpanel_arrows_skin + "'></div>");
            g_objPanel.append("<div class='grid-arrow grid-arrow-down ug-skin-" + g_options.gridpanel_arrows_skin + "'></div>");
            g_objArrowPrev = g_objPanel.children(".grid-arrow-up");
            g_objArrowNext = g_objPanel.children(".grid-arrow-down");
        }
        g_panelBase.setHtml(g_objPanel);
        g_objArrowPrev.fadeTo(0, 0);
        g_objArrowNext.fadeTo(0, 0);
        g_objGrid.setHtml(g_objPanel);
        setHtmlProperties();
    }
    function setHtmlProperties() {
        if (g_options.gridpanel_background_color != "") g_objPanel.css("background-color", g_options.gridpanel_background_color);
    }
    function processOptions() {
        if (g_options.gridpanel_grid_align == "center") g_options.gridpanel_grid_align = "middle";
    }
    function placePanelAnimation(panelX, functionOnComplete) {
        var objCss = {
            left: panelX + "px"
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
    function getGridMaxHeight() {
        var spaceTaken = g_options.gridpanel_padding_border_top + g_options.gridpanel_padding_border_bottom;
        var maxGridHeight = g_temp.panelHeight - spaceTaken;
        if (g_options.gridpanel_arrows_always_on == false) {
            var numPanes = g_objGrid.getNumPanesEstimationByHeight(maxGridHeight);
            if (numPanes == 1) return maxGridHeight;
        }
        var arrowsSize = g_functions.getElementSize(g_objArrowNext);
        var arrowsHeight = arrowsSize.height;
        var spaceTaken = arrowsHeight + g_options.gridpanel_arrows_padding_vert;
        if (g_options.gridpanel_vertical_scroll == true) spaceTaken *= 2;
        spaceTaken += g_options.gridpanel_padding_border_top + g_options.gridpanel_padding_border_bottom;
        maxGridHeight = g_temp.panelHeight - spaceTaken;
        return maxGridHeight;
    }
    function getGridMaxWidth() {
        var spaceTaken = g_options.gridpanel_padding_border_left + g_options.gridpanel_padding_border_right;
        var maxGridWidth = g_temp.panelWidth - spaceTaken;
        if (g_options.gridpanel_arrows_always_on == false) {
            var numPanes = g_objGrid.getNumPanesEstimationByWidth(maxGridWidth);
            if (numPanes == 1) return maxGridWidth;
        }
        var arrowsSize = g_functions.getElementSize(g_objArrowNext);
        var arrowsWidth = arrowsSize.width;
        spaceTaken += (arrowsWidth + g_options.gridpanel_arrows_padding_hor) * 2;
        maxGridWidth = g_temp.panelWidth - spaceTaken;
        return maxGridWidth;
    }
    function setArrows() {
        var showArrows = false;
        if (g_options.gridpanel_arrows_always_on == true) {
            showArrows = true;
        } else {
            var numPanes = g_objGrid.getNumPanes();
            if (numPanes > 1) showArrows = true;
        }
        if (showArrows == true) {
            g_objArrowNext.show().fadeTo(0, 1);
            g_objArrowPrev.show().fadeTo(0, 1);
            g_temp.arrowsVisible = true;
        } else {
            g_objArrowNext.hide();
            g_objArrowPrev.hide();
            g_temp.arrowsVisible = false;
        }
    }
    function setPanelSize() {
        var gridSize = g_objGrid.getSize();
        if (g_temp.isHorType == true) g_temp.panelHeight = gridSize.height + g_options.gridpanel_padding_border_top + g_options.gridpanel_padding_border_bottom; else g_temp.panelWidth = gridSize.width + g_options.gridpanel_padding_border_left + g_options.gridpanel_padding_border_right;
        g_functions.setElementSize(g_objPanel, g_temp.panelWidth, g_temp.panelHeight);
    }
    function placePanelNoAnimation(panelDest) {
        switch (g_temp.orientation) {
          case "right":
          case "left":
            g_functions.placeElement(g_objPanel, panelDest, null);
            break;
        }
    }
    function __________EVENTS___________() {}
    function onPanelSlideFinish() {
        g_objThis.trigger(t.events.FINISH_MOVE);
    }
    function initEvents() {
        if (g_temp.isEventsInited == true) return false;
        g_temp.isEventsInited = true;
        if (g_objArrowPrev) {
            g_functions.addClassOnHover(g_objArrowPrev);
            g_objGrid.attachPrevPaneButton(g_objArrowPrev);
        }
        if (g_objArrowNext) {
            g_functions.addClassOnHover(g_objArrowNext);
            g_objGrid.attachNextPaneButton(g_objArrowNext);
        }
        g_panelBase.initEvents();
    }
    this.destroy = function() {
        if (g_objArrowPrev) g_functions.destroyButton(g_objArrowPrev);
        if (g_objArrowNext) g_functions.destroyButton(g_objArrowNext);
        g_panelBase.destroy();
        g_objGrid.destroy();
    };
    function ______PLACE_ELEMENTS___________() {}
    function getGridPaddingLeft() {
        var gridPanelLeft = g_options.gridpanel_padding_border_left;
        return gridPanelLeft;
    }
    function placeElements_noarrows() {
        var gridY = g_options.gridpanel_grid_align, gridPaddingY = 0;
        switch (gridY) {
          case "top":
            gridPaddingY = g_options.gridpanel_padding_border_top;
            break;

          case "bottom":
            gridPaddingY = g_options.gridpanel_padding_border_bottom;
            break;
        }
        var gridPanelLeft = getGridPaddingLeft();
        var gridElement = g_objGrid.getElement();
        g_functions.placeElement(gridElement, gridPanelLeft, gridY, 0, gridPaddingY);
    }
    function placeElementsVert_arrows() {
        var gridY, prevArrowY, nextArrowY, nextArrowPaddingY;
        var objArrowSize = g_functions.getElementSize(g_objArrowPrev);
        var objGridSize = g_objGrid.getSize();
        switch (g_options.gridpanel_grid_align) {
          default:
          case "top":
            gridY = g_options.gridpanel_padding_border_top + objArrowSize.height + g_options.gridpanel_arrows_padding_vert;
            break;

          case "middle":
            gridY = "middle";
            break;

          case "bottom":
            gridY = g_temp.panelHeight - objGridSize.height - objArrowSize.height - g_options.gridpanel_padding_border_bottom - g_options.gridpanel_arrows_padding_vert;
            break;
        }
        var gridPanelLeft = getGridPaddingLeft();
        var gridElement = g_objGrid.getElement();
        g_functions.placeElement(gridElement, gridPanelLeft, gridY);
        var objGridSize = g_objGrid.getSize();
        switch (g_options.gridpanel_arrows_align_vert) {
          default:
          case "center":
          case "middle":
            prevArrowY = (objGridSize.top - objArrowSize.height) / 2;
            nextArrowY = objGridSize.bottom + (g_temp.panelHeight - objGridSize.bottom - objArrowSize.height) / 2;
            nextArrowPaddingY = 0;
            break;

          case "grid":
            prevArrowY = objGridSize.top - objArrowSize.height - g_options.gridpanel_arrows_padding_vert_vert;
            nextArrowY = objGridSize.bottom + g_options.gridpanel_arrows_padding_vert;
            nextArrowPaddingY = 0;
            break;

          case "border":
          case "borders":
            prevArrowY = g_options.gridpanel_padding_border_top;
            nextArrowY = "bottom";
            nextArrowPaddingY = g_options.gridpanel_padding_border_bottom;
            break;
        }
        g_functions.placeElement(g_objArrowPrev, "center", prevArrowY);
        g_functions.placeElement(g_objArrowNext, "center", nextArrowY, 0, nextArrowPaddingY);
    }
    function placeElementsVert() {
        if (g_temp.arrowsVisible == true) placeElementsVert_arrows(); else placeElements_noarrows();
    }
    function placeElementsHor_arrows() {
        var arrowsY, prevArrowPadding, arrowsPaddingY, nextArrowPadding;
        var objArrowSize = g_functions.getElementSize(g_objArrowPrev);
        var objGridSize = g_objGrid.getSize();
        var gridY = g_options.gridpanel_padding_border_top;
        switch (g_options.gridpanel_grid_align) {
          case "middle":
            switch (g_options.gridpanel_arrows_align_vert) {
              default:
                var elementsHeight = objGridSize.height + g_options.gridpanel_arrows_padding_vert + objArrowSize.height;
                gridY = (g_temp.panelHeight - elementsHeight) / 2;
                break;

              case "border":
              case "borders":
                var remainHeight = g_temp.panelHeight - objArrowSize.height - g_options.gridpanel_padding_border_bottom;
                gridY = (remainHeight - objGridSize.height) / 2;
                break;
            }
            break;

          case "bottom":
            var elementsHeight = objGridSize.height + objArrowSize.height + g_options.gridpanel_arrows_padding_vert;
            gridY = g_temp.panelHeight - elementsHeight - g_options.gridpanel_padding_border_bottom;
            break;
        }
        var gridElement = g_objGrid.getElement();
        var gridPanelLeft = getGridPaddingLeft();
        g_functions.placeElement(gridElement, gridPanelLeft, gridY);
        var objGridSize = g_objGrid.getSize();
        switch (g_options.gridpanel_arrows_align_vert) {
          default:
          case "center":
          case "middle":
            arrowsY = objGridSize.bottom + (g_temp.panelHeight - objGridSize.bottom - objArrowSize.height) / 2;
            arrowsPaddingY = 0;
            break;

          case "grid":
            arrowsY = objGridSize.bottom + g_options.gridpanel_arrows_padding_vert;
            arrowsPaddingY = 0;
            break;

          case "border":
          case "borders":
            arrowsY = "bottom";
            arrowsPaddingY = g_options.gridpanel_padding_border_bottom;
            break;
        }
        prevArrowPadding = -objArrowSize.width / 2 - g_options.gridpanel_space_between_arrows / 2;
        g_functions.placeElement(g_objArrowPrev, "center", arrowsY, prevArrowPadding, arrowsPaddingY);
        var nextArrowPadding = Math.abs(prevArrowPadding);
        g_functions.placeElement(g_objArrowNext, "center", arrowsY, nextArrowPadding, arrowsPaddingY);
    }
    function placeElementsHor() {
        if (g_temp.arrowsVisible == true) placeElementsHor_arrows(); else placeElements_noarrows();
    }
    function placeElementsHorType_arrows() {
        var gridX, prevArrowX, nextArrowX, arrowsY;
        var objArrowSize = g_functions.getElementSize(g_objArrowPrev);
        var objGridSize = g_objGrid.getSize();
        switch (g_options.gridpanel_grid_align) {
          default:
          case "left":
            gridX = g_options.gridpanel_padding_border_left + g_options.gridpanel_arrows_padding_hor + objArrowSize.width;
            break;

          case "middle":
          case "center":
            gridX = "center";
            break;

          case "right":
            gridX = g_temp.panelWidth - objGridSize.width - objArrowSize.width - g_options.gridpanel_padding_border_right - g_options.gridpanel_arrows_padding_hor;
            break;
        }
        var gridElement = g_objGrid.getElement();
        g_functions.placeElement(gridElement, gridX, g_options.gridpanel_padding_border_top);
        objGridSize = g_objGrid.getSize();
        switch (g_options.gridpanel_arrows_align_vert) {
          default:
          case "center":
          case "middle":
            arrowsY = (objGridSize.height - objArrowSize.height) / 2 + objGridSize.top;
            break;

          case "top":
            arrowsY = g_options.gridpanel_padding_border_top + g_options.gridpanel_arrows_padding_vert;
            break;

          case "bottom":
            arrowsY = g_temp.panelHeight - g_options.gridpanel_padding_border_bottom - g_options.gridpanel_arrows_padding_vert - objArrowSize.height;
            break;
        }
        switch (g_options.gridpanel_arrows_align_hor) {
          default:
          case "borders":
            prevArrowX = g_options.gridpanel_padding_border_left;
            nextArrowX = g_temp.panelWidth - g_options.gridpanel_padding_border_right - objArrowSize.width;
            break;

          case "grid":
            prevArrowX = objGridSize.left - g_options.gridpanel_arrows_padding_hor - objArrowSize.width;
            nextArrowX = objGridSize.right + g_options.gridpanel_arrows_padding_hor;
            break;

          case "center":
            prevArrowX = (objGridSize.left - objArrowSize.width) / 2;
            nextArrowX = objGridSize.right + (g_temp.panelWidth - objGridSize.right - objArrowSize.width) / 2;
            break;
        }
        g_functions.placeElement(g_objArrowPrev, prevArrowX, arrowsY);
        g_functions.placeElement(g_objArrowNext, nextArrowX, arrowsY);
    }
    function placeElementHorType_noarrows() {
        var gridX;
        var objGridSize = g_objGrid.getSize();
        switch (g_options.gridpanel_grid_align) {
          default:
          case "left":
            gridX = g_options.gridpanel_padding_border_left;
            break;

          case "middle":
          case "center":
            gridX = "center";
            break;

          case "right":
            gridX = g_temp.panelWidth - objGridSize.width - g_options.gridpanel_padding_border_right;
            break;
        }
        var gridElement = g_objGrid.getElement();
        g_functions.placeElement(gridElement, gridX, g_options.gridpanel_padding_border_top);
    }
    function placeElementsHorType() {
        if (g_temp.arrowsVisible == true) placeElementsHorType_arrows(); else placeElementHorType_noarrows();
    }
    function placeElements() {
        if (g_temp.isHorType == false) {
            if (g_options.gridpanel_vertical_scroll == true) placeElementsVert(); else placeElementsHor();
        } else {
            placeElementsHorType();
        }
        g_panelBase.placeElements();
    }
    this.getOrientation = function() {
        return g_temp.orientation;
    };
    this.setOrientation = function(orientation) {
        g_temp.orientation = orientation;
        switch (orientation) {
          case "right":
          case "left":
            g_temp.isHorType = false;
            break;

          case "top":
          case "bottom":
            g_temp.isHorType = true;
            break;

          default:
            throw new Error("Wrong grid panel orientation: " + orientation);
            break;
        }
    };
    this.setHeight = function(height) {
        if (g_temp.isHorType == true) throw new Error("setHeight is not appliable to this orientatio (" + g_temp.orientation + "). Please use setWidth");
        g_temp.panelHeight = height;
        var gridMaxHeight = getGridMaxHeight();
        g_objGrid.setMaxHeight(gridMaxHeight);
    };
    this.setWidth = function(width) {
        if (g_temp.isHorType == false) throw new Error("setWidth is not appliable to this orientatio (" + g_temp.orientation + "). Please use setHeight");
        g_temp.panelWidth = width;
        var gridMaxWidth = getGridMaxWidth();
        g_objGrid.setMaxWidth(gridMaxWidth);
    };
    this.init = function(gallery, customOptions) {
        initGridPanel(gallery, customOptions);
    };
    this.setHtml = function() {
        setHtmlPanel();
    };
    this.run = function() {
        runPanel();
    };
    this.getElement = function() {
        return g_objPanel;
    };
    this.getSize = function() {
        var objSize = g_functions.getElementSize(g_objPanel);
        return objSize;
    };
    this.__________Functions_From_Base_____ = function() {};
    this.isPanelClosed = function() {
        return g_panelBase.isPanelClosed();
    };
    this.getClosedPanelDest = function() {
        return g_panelBase.getClosedPanelDest();
    };
    this.openPanel = function(noAnimation) {
        g_panelBase.openPanel(noAnimation);
    };
    this.closePanel = function(noAnimation) {
        g_panelBase.closePanel(noAnimation);
    };
    this.setOpenedState = function(originalPos) {
        g_panelBase.setOpenedState(originalPos);
    };
    this.setClosedState = function(originalPos) {
        g_panelBase.setClosedState(originalPos);
    };
    this.setDisabledAtStart = function(timeout) {
        g_panelBase.setDisabledAtStart(timeout);
    };
}

function UGThumbsGrid() {
    var t = this, g_objThis = jQuery(this);
    var g_gallery = new UniteGalleryMain(), g_objGallery, g_objects, g_objWrapper;
    var g_functions = new UGFunctions(), g_arrItems, g_objGrid, g_objInner;
    var g_thumbs = new UGThumbsGeneral(), g_tilesDesign = new UGTileDesign();
    var g_options = {
        grid_panes_direction: "left",
        grid_num_cols: 2,
        grid_min_cols: 2,
        grid_num_rows: 2,
        grid_space_between_cols: 10,
        grid_space_between_rows: 10,
        grid_space_between_mobile: 10,
        grid_transition_duration: 300,
        grid_transition_easing: "easeInOutQuad",
        grid_carousel: false,
        grid_padding: 0,
        grid_vertical_scroll_ondrag: false
    };
    this.events = {
        PANE_CHANGE: "pane_change"
    };
    var g_temp = {
        eventSizeChange: "thumb_size_change",
        isHorizontal: false,
        isMaxHeight: false,
        isMaxWidth: false,
        gridHeight: 0,
        gridWidth: 0,
        innerWidth: 0,
        innerHeight: 0,
        numPanes: 0,
        arrPanes: 0,
        numThumbs: 0,
        currentPane: 0,
        numThumbsInPane: 0,
        isNavigationVertical: false,
        touchActive: false,
        startScrollPos: 0,
        isFirstTimeRun: true,
        isTilesMode: false,
        storedEventID: "thumbsgrid",
        tileMaxWidth: null,
        tileMaxHeight: null,
        spaceBetweenCols: null,
        spaceBetweenRows: null
    };
    function __________GENERAL_________() {}
    function init(gallery, customOptions, isTilesMode) {
        g_objects = gallery.getObjects();
        g_gallery = gallery;
        g_gallery.attachThumbsPanel("grid", t);
        g_objGallery = jQuery(gallery);
        g_objWrapper = g_objects.g_objWrapper;
        g_arrItems = g_objects.g_arrItems;
        if (isTilesMode === true) g_temp.isTilesMode = true;
        g_temp.numThumbs = g_arrItems.length;
        setOptions(customOptions);
        if (g_temp.isTilesMode == true) {
            g_tilesDesign.setFixedMode();
            g_tilesDesign.setApproveClickFunction(isApproveTileClick);
            g_tilesDesign.init(gallery, g_options);
            var options_td = g_tilesDesign.getOptions();
            g_temp.tileMaxHeight = options_td.tile_height;
            g_temp.tileMaxWidth = options_td.tile_width;
            g_thumbs = g_tilesDesign.getObjThumbs();
        } else {
            customOptions.thumb_fixed_size = true;
            g_thumbs.init(gallery, customOptions);
        }
    }
    function setHtml(parentContainer) {
        var objParent = g_objWrapper;
        if (parentContainer) objParent = parentContainer;
        objParent.append("<div class='ug-thumbs-grid'><div class='ug-thumbs-grid-inner'></div></div>");
        g_objGrid = objParent.children(".ug-thumbs-grid");
        g_objInner = g_objGrid.children(".ug-thumbs-grid-inner");
        if (g_temp.isTilesMode == true) g_tilesDesign.setHtml(g_objInner); else g_thumbs.setHtmlThumbs(g_objInner);
    }
    function validateBeforeRun() {
        if (g_temp.isHorizontal == false) {
            if (g_temp.gridHeight == 0) throw new Error("You must set height before run.");
        } else {
            if (g_temp.gridWidth == 0) throw new Error("You must set width before run.");
        }
    }
    function run() {
        var selectedItem = g_gallery.getSelectedItem();
        validateBeforeRun();
        if (g_temp.isFirstTimeRun == true) {
            initEvents();
            if (g_temp.isTilesMode == true) {
                initGridDynamicSize();
                initSizeParams();
                g_tilesDesign.run();
            } else {
                g_thumbs.setHtmlProperties();
                initSizeParams();
                g_thumbs.loadThumbsImages();
            }
        } else {
            if (g_temp.isTilesMode == true) {
                var isChanged = initGridDynamicSize();
                if (isChanged == true) {
                    initSizeParams();
                    g_tilesDesign.run();
                }
            }
        }
        positionThumbs();
        if (g_temp.isFirstTimeRun == true && g_temp.isTilesMode) {
            var objTiles = g_thumbs.getThumbs();
            objTiles.each(function(index, tile) {
                g_objWrapper.trigger(g_temp.eventSizeChange, jQuery(tile));
            });
            objTiles.fadeTo(0, 1);
        }
        if (selectedItem != null) scrollToThumb(selectedItem.index);
        g_objThis.trigger(t.events.PANE_CHANGE, g_temp.currentPane);
        g_temp.isFirstTimeRun = false;
    }
    function getThumbsSize() {
        if (g_temp.isTilesMode == true) var objThumbSize = g_tilesDesign.getGlobalTileSize(); else var objThumbSize = g_thumbs.getGlobalThumbSize();
        return objThumbSize;
    }
    function initGridDynamicSize() {
        if (g_temp.isTilesMode == false) throw new Error("Dynamic size can be set only in tiles mode");
        var isChanged = false;
        var isMobile = g_gallery.isMobileMode();
        var spaceOld = g_temp.spaceBetweenCols;
        if (isMobile == true) {
            g_temp.spaceBetweenCols = g_options.grid_space_between_mobile;
            g_temp.spaceBetweenRows = g_options.grid_space_between_mobile;
        } else {
            g_temp.spaceBetweenCols = g_options.grid_space_between_cols;
            g_temp.spaceBetweenRows = g_options.grid_space_between_rows;
        }
        if (g_temp.spaceBetweenCols != spaceOld) isChanged = true;
        var lastThumbSize = getThumbsSize();
        var lastThumbWidth = lastThumbSize.width;
        var tileWidth = g_temp.tileMaxWidth;
        var numCols = g_functions.getNumItemsInSpace(g_temp.gridWidth, g_temp.tileMaxWidth, g_temp.spaceBetweenCols);
        if (numCols < g_options.grid_min_cols) {
            tileWidth = g_functions.getItemSizeInSpace(g_temp.gridWidth, g_options.grid_min_cols, g_temp.spaceBetweenCols);
        }
        g_tilesDesign.setTileSizeOptions(tileWidth);
        if (tileWidth != lastThumbWidth) isChanged = true;
        return isChanged;
    }
    function initSizeParamsHor() {
        var objThumbSize = getThumbsSize();
        var thumbsHeight = objThumbSize.height;
        var gridWidth = g_temp.gridWidth;
        var gridHeight = g_options.grid_num_rows * thumbsHeight + (g_options.grid_num_rows - 1) * g_temp.spaceBetweenRows + g_options.grid_padding * 2;
        g_temp.gridHeight = gridHeight;
        g_functions.setElementSize(g_objGrid, gridWidth, gridHeight);
        g_functions.setElementSize(g_objInner, gridWidth, gridHeight);
        g_temp.innerWidth = gridWidth;
        g_temp.innerHeight = gridHeight;
    }
    function initSizeParamsVert() {
        var objThumbSize = getThumbsSize();
        var thumbsWidth = objThumbSize.width;
        var gridWidth = g_options.grid_num_cols * thumbsWidth + (g_options.grid_num_cols - 1) * g_temp.spaceBetweenCols + g_options.grid_padding * 2;
        var gridHeight = g_temp.gridHeight;
        g_temp.gridWidth = gridWidth;
        g_functions.setElementSize(g_objGrid, gridWidth, gridHeight);
        g_functions.setElementSize(g_objInner, gridWidth, gridHeight);
        g_temp.innerWidth = gridWidth;
        g_temp.innerHeight = gridHeight;
    }
    function initSizeParams() {
        if (g_temp.isHorizontal == false) initSizeParamsVert(); else initSizeParamsHor();
    }
    function scrollToThumb(thumbIndex) {
        var paneIndex = getPaneIndexByThumbIndex(thumbIndex);
        if (paneIndex == -1) return false;
        t.gotoPane(paneIndex, "scroll");
    }
    function setOptions(objOptions) {
        g_options = jQuery.extend(g_options, objOptions);
        g_thumbs.setOptions(objOptions);
        g_temp.isNavigationVertical = g_options.grid_panes_direction == "top" || g_options.grid_panes_direction == "bottom";
        g_temp.spaceBetweenCols = g_options.grid_space_between_cols;
        g_temp.spaceBetweenRows = g_options.grid_space_between_rows;
    }
    function positionThumb_hor() {
        var arrThumbs = g_objInner.children(".ug-thumb-wrapper");
        var posx = 0;
        var posy = 0;
        var counter = 0;
        var baseX = 0;
        var maxx = 0, maxy = 0;
        g_temp.innerWidth = 0;
        g_temp.numPanes = 1;
        g_temp.arrPanes = [];
        g_temp.numThumbsInPane = 0;
        g_temp.arrPanes.push(baseX);
        var numThumbs = arrThumbs.length;
        for (i = 0; i < numThumbs; i++) {
            var objThumb = jQuery(arrThumbs[i]);
            g_functions.placeElement(objThumb, posx, posy);
            var thumbWidth = objThumb.outerWidth();
            var thumbHeight = objThumb.outerHeight();
            if (posx > maxx) maxx = posx;
            var endY = posy + thumbHeight;
            if (endY > maxy) maxy = endY;
            var endX = maxx + thumbWidth;
            if (endX > g_temp.innerWidth) g_temp.innerWidth = endX;
            posx += thumbWidth + g_temp.spaceBetweenCols;
            counter++;
            if (counter >= g_options.grid_num_cols) {
                posy += thumbHeight + g_temp.spaceBetweenRows;
                posx = baseX;
                counter = 0;
            }
            if (g_temp.numPanes == 1) g_temp.numThumbsInPane++;
            if (posy + thumbHeight > g_temp.gridHeight) {
                posy = 0;
                baseX = g_temp.innerWidth + g_temp.spaceBetweenCols;
                posx = baseX;
                counter = 0;
                if (g_temp.isMaxHeight == true && g_temp.numPanes == 1) {
                    g_temp.gridHeight = maxy;
                    g_objGrid.height(g_temp.gridHeight);
                }
                if (i < numThumbs - 1) {
                    g_temp.numPanes++;
                    g_temp.arrPanes.push(baseX);
                }
            }
        }
        g_objInner.width(g_temp.innerWidth);
        if (g_temp.isMaxHeight == true && g_temp.numPanes == 1) {
            g_temp.gridHeight = maxy;
            g_objGrid.height(maxy);
        }
    }
    function positionThumb_vert() {
        var arrThumbs = g_objInner.children(".ug-thumb-wrapper");
        var posx = 0;
        var posy = 0;
        var maxy = 0;
        var counter = 0;
        var baseX = 0;
        var paneStartY = 0;
        g_temp.innerWidth = 0;
        g_temp.numPanes = 1;
        g_temp.arrPanes = [];
        g_temp.numThumbsInPane = 0;
        g_temp.arrPanes.push(baseX);
        var numThumbs = arrThumbs.length;
        for (i = 0; i < numThumbs; i++) {
            var objThumb = jQuery(arrThumbs[i]);
            g_functions.placeElement(objThumb, posx, posy);
            var thumbWidth = objThumb.outerWidth();
            var thumbHeight = objThumb.outerHeight();
            posx += thumbWidth + g_temp.spaceBetweenCols;
            var endy = posy + thumbHeight;
            if (endy > maxy) maxy = endy;
            counter++;
            if (counter >= g_options.grid_num_cols) {
                posy += thumbHeight + g_temp.spaceBetweenRows;
                posx = baseX;
                counter = 0;
            }
            if (g_temp.numPanes == 1) g_temp.numThumbsInPane++;
            endy = posy + thumbHeight;
            var paneMaxY = paneStartY + g_temp.gridHeight;
            if (endy > paneMaxY) {
                if (g_temp.isMaxHeight == true && g_temp.numPanes == 1) {
                    g_temp.gridHeight = maxy;
                    g_objGrid.height(g_temp.gridHeight);
                    paneMaxY = g_temp.gridHeight;
                }
                posy = paneMaxY + g_temp.spaceBetweenRows;
                paneStartY = posy;
                baseX = 0;
                posx = baseX;
                counter = 0;
                if (i < numThumbs - 1) {
                    g_temp.numPanes++;
                    g_temp.arrPanes.push(posy);
                }
            }
        }
        g_objInner.height(maxy);
        g_temp.innerHeight = maxy;
        if (g_temp.isMaxHeight == true && g_temp.numPanes == 1) {
            g_temp.gridHeight = maxy;
            g_objGrid.height(maxy);
        }
    }
    function positionThumb_hortype() {
        var arrThumbs = g_objInner.children(".ug-thumb-wrapper");
        var baseX = g_options.grid_padding;
        var baseY = g_options.grid_padding;
        var posy = baseY;
        var posx = baseX;
        var maxx = 0, maxy = 0, paneMaxY = 0, gridMaxY = 0;
        var rowsCounter = 0;
        g_temp.innerWidth = 0;
        g_temp.numPanes = 1;
        g_temp.arrPanes = [];
        g_temp.numThumbsInPane = 0;
        g_temp.arrPanes.push(baseX - g_options.grid_padding);
        var numThumbs = arrThumbs.length;
        for (i = 0; i < numThumbs; i++) {
            var objThumb = jQuery(arrThumbs[i]);
            var thumbWidth = objThumb.outerWidth();
            var thumbHeight = objThumb.outerHeight();
            if (posx - baseX + thumbWidth > g_temp.gridWidth) {
                rowsCounter++;
                posy = 0;
                if (rowsCounter >= g_options.grid_num_rows) {
                    rowsCounter = 0;
                    baseX = posx;
                    posy = baseY;
                    paneMaxY = 0;
                    if (g_temp.numPanes == 1) {
                        g_temp.gridWidth = maxx + g_options.grid_padding;
                        g_objGrid.width(g_temp.gridWidth);
                        g_temp.gridHeight = gridMaxY + g_options.grid_padding;
                        g_objGrid.height(g_temp.gridHeight);
                    }
                    g_temp.numPanes++;
                    g_temp.arrPanes.push(baseX - g_options.grid_padding);
                } else {
                    posx = baseX;
                    posy = paneMaxY + g_temp.spaceBetweenRows;
                }
            }
            g_functions.placeElement(objThumb, posx, posy);
            var endX = posx + thumbWidth;
            if (endX > maxx) maxx = endX;
            var endY = posy + thumbHeight;
            if (endY > paneMaxY) paneMaxY = endY;
            if (endY > gridMaxY) gridMaxY = endY;
            if (endY > maxy) maxy = endY;
            var endX = maxx + thumbWidth;
            if (endX > g_temp.innerWidth) g_temp.innerWidth = endX;
            posx += thumbWidth + g_temp.spaceBetweenCols;
            if (g_temp.numPanes == 1) g_temp.numThumbsInPane++;
        }
        g_temp.innerWidth = maxx + g_options.grid_padding;
        g_temp.innerHeight = gridMaxY + g_options.grid_padding;
        g_objInner.width(g_temp.innerWidth);
        g_objInner.height(g_temp.innerHeight);
        if (g_temp.numPanes == 1) {
            g_temp.gridWidth = maxx + g_options.grid_padding;
            g_temp.gridHeight = gridMaxY + g_options.grid_padding;
            g_objGrid.width(g_temp.gridWidth);
            g_objGrid.height(g_temp.gridHeight);
        }
    }
    function positionThumbs() {
        if (g_temp.isHorizontal == false) {
            if (g_temp.isNavigationVertical) positionThumb_vert(); else positionThumb_hor();
        } else {
            positionThumb_hortype();
        }
    }
    function validateThumbIndex(thumbIndex) {
        if (thumbIndex < 0 || thumbIndex >= g_temp.numThumbs) {
            throw new Error("Thumb not exists: " + thumbIndex);
            return false;
        }
        return true;
    }
    function validatePaneIndex(paneIndex) {
        if (paneIndex >= g_temp.numPanes || paneIndex < 0) {
            throw new Error("Pane " + index + " doesn't exists.");
            return false;
        }
        return true;
    }
    function validateInnerPos(pos) {
        var absPos = Math.abs(pos);
        if (g_temp.isNavigationVertical == false) {
            if (absPos < 0 || absPos >= g_temp.innerWidth) {
                throw new Error("wrong inner x position: " + pos);
                return false;
            }
        } else {
            if (absPos < 0 || absPos >= g_temp.innerHeight) {
                throw new Error("wrong inner y position: " + pos);
                return false;
            }
        }
        return true;
    }
    function setInnerPos(pos) {
        var objCss = getInnerPosObj(pos);
        if (objCss == false) return false;
        g_objInner.css(objCss);
    }
    function animateInnerTo(pos) {
        var objCss = getInnerPosObj(pos);
        if (objCss == false) return false;
        g_objInner.stop(true).animate(objCss, {
            duration: g_options.grid_transition_duration,
            easing: g_options.grid_transition_easing,
            queue: false
        });
    }
    function animateToCurrentPane() {
        var innerPos = -g_temp.arrPanes[g_temp.currentPane];
        animateInnerTo(innerPos);
    }
    function __________GETTERS_________() {}
    function getInnerSize() {
        if (g_temp.isNavigationVertical == true) return g_temp.innerHeight; else return g_temp.innerWidth;
    }
    function getPaneSize() {
        if (g_temp.isNavigationVertical == true) return g_temp.gridHeight; else return g_temp.gridWidth;
    }
    function getInnerPosObj(pos) {
        var obj = {};
        if (g_temp.isNavigationVertical == true) obj.top = pos + "px"; else obj.left = pos + "px";
        return obj;
    }
    function getMousePos(event) {
        var mousePos = g_functions.getMousePosition(event);
        if (g_temp.isNavigationVertical == true) return mousePos.pageY; else return mousePos.pageX;
    }
    function getInnerPos() {
        var objSize = g_functions.getElementSize(g_objInner);
        if (g_temp.isNavigationVertical == true) return objSize.top; else return objSize.left;
    }
    function getPaneIndexByThumbIndex(thumbIndex) {
        if (validateThumbIndex(thumbIndex) == false) return -1;
        var numPane = Math.floor(thumbIndex / g_temp.numThumbsInPane);
        return numPane;
    }
    function getPanePosition(index) {
        var pos = g_temp.arrPanes[index];
        return pos;
    }
    function isSignificantPassed() {
        if (g_temp.numPanes == 1) return false;
        var objData = g_functions.getStoredEventData(g_temp.storedEventID);
        var passedTime = objData.diffTime;
        var currentInnerPos = getInnerPos();
        var passedDistanceAbs = Math.abs(currentInnerPos - objData.startInnerPos);
        if (passedDistanceAbs > 30) return true;
        if (passedDistanceAbs > 5 && passedTime > 300) return true;
        return false;
    }
    function isMovementValidForChange() {
        var objData = g_functions.getStoredEventData(g_temp.storedEventID);
        var currentInnerPos = getInnerPos();
        diffPos = Math.abs(objData.startInnerPos - currentInnerPos);
        var paneSize = getPaneSize();
        var breakSize = Math.round(paneSize * 3 / 8);
        if (diffPos >= breakSize) return true;
        if (objData.diffTime < 300 && diffPos > 25) return true;
        return false;
    }
    function isApproveTileClick() {
        if (g_temp.numPanes == 1) return true;
        var isApprove = g_functions.isApproveStoredEventClick(g_temp.storedEventID, g_temp.isNavigationVertical);
        return isApprove;
    }
    function __________EVENTS_______() {}
    function onThumbClick(event) {
        if (isSignificantPassed() == true) return true;
        var objThumb = jQuery(this);
        var objItem = g_thumbs.getItemByThumb(objThumb);
        g_gallery.selectItem(objItem);
    }
    function onTouchStart(event) {
        if (g_temp.numPanes == 1) return true;
        if (g_temp.touchActive == true) return true;
        if (g_temp.isTilesMode == false) event.preventDefault();
        g_temp.touchActive = true;
        var addData = {
            startInnerPos: getInnerPos()
        };
        g_functions.storeEventData(event, g_temp.storedEventID, addData);
    }
    function handleScrollTop() {
        if (g_options.grid_vertical_scroll_ondrag == false) return false;
        if (g_temp.isNavigationVertical == true) return false;
        var scrollDir = g_functions.handleScrollTop(g_temp.storedEventID);
        if (scrollDir === "vert") return true;
        return false;
    }
    function onTouchMove(event) {
        if (g_temp.touchActive == false) return true;
        event.preventDefault();
        g_functions.updateStoredEventData(event, g_temp.storedEventID);
        var objData = g_functions.getStoredEventData(g_temp.storedEventID, g_temp.isNavigationVertical);
        var isScroll = handleScrollTop();
        if (isScroll) return true;
        var diff = objData.diffMousePos;
        var innerPos = objData.startInnerPos + diff;
        var direction = diff > 0 ? "prev" : "next";
        var lastPaneSize = g_temp.arrPanes[g_temp.numPanes - 1];
        if (g_options.grid_carousel == false && innerPos > 0 && direction == "prev") {
            innerPos = innerPos / 3;
        }
        if (g_options.grid_carousel == false && innerPos < -lastPaneSize && direction == "next") {
            innerPos = objData.startInnerPos + diff / 3;
        }
        setInnerPos(innerPos);
    }
    function onTouchEnd(event) {
        if (g_temp.touchActive == false) return true;
        g_functions.updateStoredEventData(event, g_temp.storedEventID);
        var objData = g_functions.getStoredEventData(g_temp.storedEventID, g_temp.isNavigationVertical);
        g_temp.touchActive = false;
        if (isMovementValidForChange() == false) {
            animateToCurrentPane();
            return true;
        }
        var innerPos = getInnerPos();
        var diff = innerPos - objData.startInnerPos;
        var direction = diff > 0 ? "prev" : "next";
        if (direction == "next") {
            if (g_options.grid_carousel == false && t.isLastPane()) animateToCurrentPane(); else t.nextPane();
        } else {
            if (g_options.grid_carousel == false && t.isFirstPane()) {
                animateToCurrentPane();
            } else t.prevPane();
        }
    }
    function onItemChange() {
        var objItem = g_gallery.getSelectedItem();
        g_thumbs.setThumbSelected(objItem.objThumbWrapper);
        scrollToThumb(objItem.index);
    }
    function initEvents() {
        if (g_temp.isTilesMode == false) {
            g_thumbs.initEvents();
            var objThumbs = g_objGrid.find(".ug-thumb-wrapper");
            objThumbs.on("click touchend", onThumbClick);
            g_objGallery.on(g_gallery.events.ITEM_CHANGE, onItemChange);
        } else {
            g_tilesDesign.initEvents();
        }
        g_objGrid.bind("mousedown touchstart", onTouchStart);
        jQuery("body").bind("mousemove touchmove", onTouchMove);
        jQuery(window).add("body").bind("mouseup touchend", onTouchEnd);
    }
    this.destroy = function() {
        if (g_temp.isTilesMode == false) {
            var objThumbs = g_objGrid.find(".ug-thumb-wrapper");
            objThumbs.off("click");
            objThumbs.off("touchend");
            g_objGallery.on(g_gallery.events.ITEM_CHANGE);
            g_thumbs.destroy();
        } else {
            g_tilesDesign.destroy();
        }
        g_objGrid.unbind("mousedown");
        g_objGrid.unbind("touchstart");
        jQuery("body").unbind("mousemove");
        jQuery("body").unbind("touchmove");
        jQuery(window).add("body").unbind("touchend");
        jQuery(window).add("body").unbind("mouseup");
        g_objThis.off(t.events.PANE_CHANGE);
    };
    this.__________EXTERNAL_GENERAL_________ = function() {};
    this.setThumbUnselected = function(objThumbWrapper) {
        g_thumbs.setThumbUnselected(objThumbWrapper);
    };
    this.isItemThumbVisible = function(objItem) {
        var itemIndex = objItem.index;
        var paneIndex = getPaneIndexByThumbIndex(itemIndex);
        if (paneIndex == g_temp.currentPane) return true;
        return false;
    };
    this.__________EXTERNAL_API_________ = function() {};
    this.getNumPanesEstimationByHeight = function(gridHeight) {
        if (g_temp.isTilesMode == true) {
            var thumbHeight = g_options.tile_height;
        } else {
            var thumbsOptions = g_thumbs.getOptions();
            var thumbHeight = thumbsOptions.thumb_height;
        }
        var numThumbs = g_thumbs.getNumThumbs();
        var numRows = Math.ceil(numThumbs / g_options.grid_num_cols);
        var totalHeight = numRows * thumbHeight + (numRows - 1) * g_temp.spaceBetweenRows;
        var numPanes = Math.ceil(totalHeight / gridHeight);
        return numPanes;
    };
    this.getNumPanesEstimationByWidth = function(gridWidth) {
        if (g_temp.isTilesMode) {
            var thumbWidth = g_options.tile_width;
        } else {
            var thumbsOptions = g_thumbs.getOptions();
            var thumbWidth = thumbsOptions.thumb_width;
        }
        var numThumbs = g_thumbs.getNumThumbs();
        var numCols = Math.ceil(numThumbs / g_options.grid_num_rows);
        var totalWidth = numCols * thumbWidth + (numCols - 1) * g_temp.spaceBetweenCols;
        var numPanes = Math.ceil(totalWidth / gridWidth);
        return numPanes;
    };
    this.getHeightEstimationByWidth = function(width) {
        if (g_temp.isTilesMode == false) throw new Error("This function works only with tiles mode");
        var numThumbs = g_thumbs.getNumThumbs();
        var numCols = g_functions.getNumItemsInSpace(width, g_options.tile_width, g_temp.spaceBetweenCols);
        var numRows = Math.ceil(numThumbs / numCols);
        if (numRows > g_options.grid_num_rows) numRows = g_options.grid_num_rows;
        var gridHeight = g_functions.getSpaceByNumItems(numRows, g_options.tile_height, g_temp.spaceBetweenRows);
        gridHeight += g_options.grid_padding * 2;
        return gridHeight;
    };
    this.getElement = function() {
        return g_objGrid;
    };
    this.getSize = function() {
        var objSize = g_functions.getElementSize(g_objGrid);
        return objSize;
    };
    this.getNumPanes = function() {
        return g_temp.numPanes;
    };
    this.isFirstPane = function() {
        if (g_temp.currentPane == 0) return true;
        return false;
    };
    this.isLastPane = function() {
        if (g_temp.currentPane == g_temp.numPanes - 1) return true;
        return false;
    };
    this.getPaneInfo = function() {
        var obj = {
            pane: g_temp.currentPane,
            total: g_temp.numPanes
        };
        return obj;
    };
    this.getPane = function() {
        return g_temp.currentPane;
    };
    this.setWidth = function(gridWidth) {
        g_temp.gridWidth = gridWidth;
        g_temp.isHorizontal = true;
    };
    this.setMaxWidth = function(maxWidth) {
        g_temp.gridWidth = maxWidth;
        g_temp.isMaxWidth = true;
        g_temp.isHorizontal = true;
    };
    this.setHeight = function(gridHeight) {
        g_temp.gridHeight = gridHeight;
        g_temp.isHorizontal = false;
    };
    this.setMaxHeight = function(maxHeight) {
        g_temp.gridHeight = maxHeight;
        g_temp.isMaxHeight = true;
        g_temp.isHorizontal = false;
    };
    this.gotoPane = function(index, fromWhere) {
        if (validatePaneIndex(index) == false) return false;
        if (index == g_temp.currentPane) return false;
        var innerPos = -g_temp.arrPanes[index];
        g_temp.currentPane = index;
        animateInnerTo(innerPos);
        g_objThis.trigger(t.events.PANE_CHANGE, index);
    };
    this.nextPane = function() {
        var nextPaneIndex = g_temp.currentPane + 1;
        if (nextPaneIndex >= g_temp.numPanes) {
            if (g_options.grid_carousel == false) return true;
            nextPaneIndex = 0;
        }
        t.gotoPane(nextPaneIndex, "next");
    };
    this.prevPane = function() {
        var prevPaneIndex = g_temp.currentPane - 1;
        if (prevPaneIndex < 0) {
            prevPaneIndex = g_temp.numPanes - 1;
            if (g_options.grid_carousel == false) return false;
        }
        t.gotoPane(prevPaneIndex, "prev");
    };
    this.attachNextPaneButton = function(objButton) {
        g_functions.setButtonOnClick(objButton, t.nextPane);
        if (g_options.grid_carousel == true) return true;
        if (t.isLastPane()) objButton.addClass("ug-button-disabled");
        g_objThis.on(t.events.PANE_CHANGE, function() {
            if (t.isLastPane()) objButton.addClass("ug-button-disabled"); else objButton.removeClass("ug-button-disabled");
        });
    };
    this.attachPrevPaneButton = function(objButton) {
        g_functions.setButtonOnClick(objButton, t.prevPane);
        if (g_options.grid_carousel == true) return true;
        if (t.isFirstPane()) objButton.addClass("ug-button-disabled");
        g_objThis.on(t.events.PANE_CHANGE, function() {
            if (t.isFirstPane()) objButton.addClass("ug-button-disabled"); else objButton.removeClass("ug-button-disabled");
        });
    };
    this.attachBullets = function(objBullets) {
        objBullets.setActive(g_temp.currentPane);
        jQuery(objBullets).on(objBullets.events.BULLET_CLICK, function(data, numBullet) {
            t.gotoPane(numBullet, "theme");
            objBullets.setActive(numBullet);
        });
        jQuery(t).on(t.events.PANE_CHANGE, function(data, numPane) {
            objBullets.setActive(numPane);
        });
    };
    this.getObjTileDesign = function() {
        return g_tilesDesign;
    };
    this.init = function(gallery, customOptions, isTilesMode) {
        init(gallery, customOptions, isTilesMode);
    };
    this.run = function() {
        run();
    };
    this.setHtml = function(parentContainer) {
        setHtml(parentContainer);
    };
}

function UGTiles() {
    var t = this, g_objThis = jQuery(this);
    var g_gallery = new UniteGalleryMain(), g_objGallery, g_objWrapper, g_objParent;
    var g_functions = new UGFunctions(), g_arrItems, g_objTileDesign = new UGTileDesign();
    var g_thumbs = new UGThumbsGeneral(), g_vars = {};
    var g_arrNestedGridRow, g_arrNestedItems;
    var g_options = {
        tiles_type: "columns",
        tiles_col_width: 250,
        tiles_align: "center",
        tiles_exact_width: false,
        tiles_space_between_cols: 3,
        tiles_space_between_cols_mobile: 3,
        tiles_include_padding: true,
        tiles_min_columns: 2,
        tiles_max_columns: 0,
        tiles_keep_order: false,
        tiles_set_initial_height: true,
        tiles_justified_row_height: 150,
        tiles_justified_space_between: 3,
        tiles_nested_optimal_tile_width: 250,
        tiles_nested_col_width: null,
        tiles_nested_debug: false,
        tiles_enable_transition: true
    };
    this.events = {
        THUMB_SIZE_CHANGE: "thumb_size_change",
        TILES_FIRST_PLACED: "tiles_first_placed",
        ALL_TILES_LOADED: "all_tiles_loaded"
    };
    var g_temp = {
        isFirstTimeRun: true,
        handle: null,
        isTransActive: false,
        isTransInited: false,
        isFirstPlaced: true,
        isAllLoaded: false
    };
    var g_nestedWork = {
        colWidth: null,
        nestedOptimalCols: 5,
        gridY: 0,
        maxColumns: 0,
        columnsValueToEnableHeightResize: 3,
        resizeLeftRightToColumn: true,
        currentItem: 0,
        currentGap: null,
        optimalTileWidth: null,
        maxGridY: 0
    };
    function __________GENERAL_________() {}
    function init(gallery, customOptions) {
        g_objects = gallery.getObjects();
        g_gallery = gallery;
        g_objGallery = jQuery(gallery);
        g_objWrapper = g_objects.g_objWrapper;
        g_arrItems = g_objects.g_arrItems;
        g_options = jQuery.extend(g_options, customOptions);
        modifyOptions();
        g_objTileDesign.init(gallery, g_options);
        g_thumbs = g_objTileDesign.getObjThumbs();
    }
    function modifyOptions() {
        if (g_options.tiles_min_columns < 1) g_options.tiles_min_columns = 1;
        if (g_options.tiles_max_columns != 0 && g_options.tiles_max_columns < g_options.tiles_min_columns) {
            g_options.tiles_max_columns = g_options.tiles_min_columns;
        }
    }
    function setHtml(objParent) {
        if (!objParent) {
            if (g_objParent) objParent = g_objParent; else var objParent = g_objWrapper;
        }
        g_objParent = objParent;
        var tilesType = g_options.tiles_type;
        objParent.addClass("ug-tiletype-" + tilesType);
        g_objTileDesign.setHtml(objParent);
        objParent.children(".ug-thumb-wrapper").hide();
    }
    function setTransition() {
        g_objParent.addClass("ug-tiles-rest-mode");
        g_temp.isTransInited = true;
        if (g_options.tiles_enable_transition == true) {
            g_objParent.addClass("ug-tiles-transit");
            var optionsTile = g_objTileDesign.getOptions();
            if (optionsTile.tile_enable_image_effect == true && optionsTile.tile_image_effect_reverse == false) g_objParent.addClass("ug-tiles-transit-overlays");
            g_temp.isTransActive = true;
        }
    }
    function getParentWidth() {
        return g_functions.getElementSize(g_objParent).width;
    }
    function doBeforeTransition() {
        if (g_temp.isTransInited == false) return false;
        g_objParent.addClass("ug-tiles-transition-active");
        g_objParent.removeClass("ug-tiles-rest-mode");
        if (g_temp.isTransActive == false) return false;
        g_objTileDesign.disableEvents();
    }
    function doAfterTransition_setClasses() {
        if (g_temp.isTransInited == false) return false;
        g_objParent.removeClass("ug-tiles-transition-active");
        g_objParent.addClass("ug-tiles-rest-mode");
    }
    function doAfterTransition() {
        if (g_temp.isTransActive == true) {
            setTimeout(function() {
                g_objTileDesign.enableEvents();
                g_objTileDesign.triggerSizeChangeEventAllTiles();
                doAfterTransition_setClasses();
            }, 800);
            if (g_temp.handle) clearTimeout(g_temp.handle);
            g_temp.handle = setTimeout(function() {
                doAfterTransition_setClasses();
                g_objTileDesign.triggerSizeChangeEventAllTiles();
                g_temp.handle = null;
            }, 2e3);
        } else {
            g_objTileDesign.triggerSizeChangeEventAllTiles();
            doAfterTransition_setClasses();
        }
    }
    function __________COLUMN_TYPE_RELATED_________() {}
    function fillTilesVars_countWidthByCols() {
        g_vars.colWidth = (g_vars.availWidth - g_vars.colGap * (g_vars.numCols - 1)) / g_vars.numCols;
        g_vars.colWidth = Math.floor(g_vars.colWidth);
        g_vars.totalWidth = g_functions.getSpaceByNumItems(g_vars.numCols, g_vars.colWidth, g_vars.colGap);
    }
    function fillTilesVars() {
        g_vars.colWidth = g_options.tiles_col_width;
        g_vars.minCols = g_options.tiles_min_columns;
        g_vars.maxCols = g_options.tiles_max_columns;
        if (g_gallery.isMobileMode() == false) {
            g_vars.colGap = g_options.tiles_space_between_cols;
        } else {
            g_vars.colGap = g_options.tiles_space_between_cols_mobile;
        }
        g_vars.galleryWidth = getParentWidth();
        g_vars.availWidth = g_vars.galleryWidth;
        if (g_options.tiles_include_padding == true) g_vars.availWidth = g_vars.galleryWidth - g_vars.colGap * 2;
        if (g_options.tiles_exact_width == true) {
            g_vars.numCols = g_functions.getNumItemsInSpace(g_vars.availWidth, g_vars.colWidth, g_vars.colGap);
            if (g_vars.maxCols > 0 && g_vars.numCols > g_vars.maxCols) g_vars.numCols = g_vars.maxCols;
            if (g_vars.numCols < g_vars.minCols) {
                g_vars.numCols = g_vars.minCols;
                fillTilesVars_countWidthByCols();
            } else {
                g_vars.totalWidth = g_vars.numCols * (g_vars.colWidth + g_vars.colGap) - g_vars.colGap;
            }
        } else {
            var numCols = g_functions.getNumItemsInSpaceRound(g_vars.availWidth, g_vars.colWidth, g_vars.colGap);
            if (numCols < g_vars.minCols) numCols = g_vars.minCols; else if (g_vars.maxCols != 0 && numCols > g_vars.maxCols) numCols = g_vars.maxCols;
            g_vars.numCols = numCols;
            fillTilesVars_countWidthByCols();
        }
        switch (g_options.tiles_align) {
          case "center":
          default:
            g_vars.addX = Math.round((g_vars.galleryWidth - g_vars.totalWidth) / 2);
            break;

          case "left":
            g_vars.addX = 0;
            break;

          case "right":
            g_vars.addX = g_vars.galleryWidth - g_vars.totalWidth;
            break;
        }
        g_vars.arrPosx = [];
        for (col = 0; col < g_vars.numCols; col++) {
            var colX = g_functions.getColX(col, g_vars.colWidth, g_vars.colGap);
            g_vars.arrPosx[col] = colX + g_vars.addX;
        }
    }
    function initColHeights() {
        g_vars.maxColHeight = 0;
        g_vars.colHeights = [ 0 ];
    }
    function getTilesMinCol() {
        var numCol = 0;
        var minHeight = 999999999;
        for (col = 0; col < g_vars.numCols; col++) {
            if (g_vars.colHeights[col] == undefined || g_vars.colHeights[col] == 0) return col;
            if (g_vars.colHeights[col] < minHeight) {
                numCol = col;
                minHeight = g_vars.colHeights[col];
            }
        }
        return numCol;
    }
    function placeTile(objTile, toShow, setGalleryHeight, numCol) {
        if (numCol === null || typeof numCol == "undefined") var numCol = getTilesMinCol();
        var posy = 0;
        if (g_vars.colHeights[numCol] !== undefined) posy = g_vars.colHeights[numCol];
        var itemHeight = g_objTileDesign.getTileHeightByWidth(g_vars.colWidth, objTile);
        if (itemHeight === null) {
            if (g_options.tiles_enable_transition == true) throw new Error("Can't know tile height, please turn off transition");
            var itemSize = g_functions.getElementSize(objTile);
            itemHeight = itemSize.height;
        }
        var posx = g_vars.arrPosx[numCol];
        g_functions.placeElement(objTile, posx, posy);
        var realHeight = posy + itemHeight;
        g_vars.colHeights[numCol] = realHeight + g_vars.colGap;
        if (g_vars.maxColHeight < realHeight) g_vars.maxColHeight = realHeight;
        if (toShow == true) objTile.show().fadeTo(0, 1);
        if (setGalleryHeight == true) {
            g_objParent.height(g_vars.maxColHeight);
        }
    }
    function placeTiles(toShow) {
        if (!toShow) toShow = false;
        fillTilesVars();
        initColHeights();
        var objThumbs = g_thumbs.getThumbs(g_thumbs.type.GET_THUMBS_RATIO);
        doBeforeTransition();
        g_objTileDesign.resizeAllTiles(g_vars.colWidth, g_objTileDesign.resizemode.VISIBLE_ELEMENTS, objThumbs);
        for (var index = 0; index < objThumbs.length; index++) {
            var objTile = jQuery(objThumbs[index]);
            var col = undefined;
            if (g_options.tiles_keep_order == true) col = g_functions.getColByIndex(g_vars.numCols, index);
            placeTile(objTile, toShow, false, col);
        }
        doAfterTransition();
        var galleryHeight = g_objParent.height();
        if (g_temp.isTransActive == true && galleryHeight > g_vars.maxColHeight) setTimeout(function() {
            g_objParent.height(g_vars.maxColHeight);
        }, 700); else g_objParent.height(g_vars.maxColHeight);
    }
    function isOrderedTilePlaceAlowed(objTile) {
        var index = objTile.index();
        var currentItem = g_gallery.getItem(index);
        if (currentItem.ordered_placed === true) return false;
        var prevIndex = g_functions.getPrevRowSameColIndex(index, g_vars.numCols);
        if (prevIndex < 0) return true;
        var objPrevItem = g_gallery.getItem(prevIndex);
        if (objPrevItem.ordered_placed === true) return true;
        return false;
    }
    function placeOrderedTile(objTile, isForce) {
        if (isForce !== true) {
            var isAlowed = isOrderedTilePlaceAlowed(objTile);
            if (isAlowed == false) return false;
        }
        var index = objTile.index();
        var col = g_functions.getColByIndex(g_vars.numCols, index);
        var objItem = g_gallery.getItem(index);
        g_objTileDesign.resizeTile(objTile, g_vars.colWidth);
        placeTile(objTile, true, true, col);
        objItem.ordered_placed = true;
        var numItems = g_gallery.getNumItems();
        var nextIndex = g_functions.getNextRowSameColIndex(index, g_vars.numCols);
        if (nextIndex >= numItems) return false;
        var nextTile = g_thumbs.getThumbByIndex(nextIndex);
        var nextItem = g_gallery.getItem(nextIndex);
        var isLoaded = g_thumbs.isThumbLoaded(nextTile);
        if (g_thumbs.isThumbLoaded(nextTile) && !nextItem.ordered_placed) placeOrderedTile(nextTile, true);
    }
    function onSingleImageLoad(objImage, isError) {
        if (isError == true) return false;
        objImage = jQuery(objImage);
        var objTile = jQuery(objImage).parent();
        g_thumbs.triggerImageLoadedEvent(objTile, objImage);
        if (g_options.tiles_keep_order == true) {
            placeOrderedTile(objTile);
        } else {
            g_objTileDesign.resizeTile(objTile, g_vars.colWidth);
            placeTile(objTile, true, true);
        }
    }
    function runColumnsType() {
        var objThumbs = g_thumbs.getThumbs(g_thumbs.type.GET_THUMBS_NO_RATIO);
        if (!objThumbs || objThumbs.length == 0) return false;
        g_temp.isAllLoaded = false;
        if (g_temp.isFirstPlaced == true) {
            fillTilesVars();
            initColHeights();
            var diffWidth = Math.abs(g_vars.galleryWidth - g_vars.totalWidth);
            if (g_options.tiles_set_initial_height == true && g_functions.isScrollbarExists() == false && diffWidth < 25) {
                var numThumbs = objThumbs.length;
                var numRows = Math.ceil(objThumbs.length / g_vars.numCols);
                var estimateHeight = numRows * g_options.tiles_col_width * .75;
                g_objParent.height(estimateHeight);
                fillTilesVars();
            }
        }
        objThumbs.fadeTo(0, 0);
        var objImages = objThumbs.find("img.ug-thumb-image");
        var initNumCols = g_vars.numCols;
        var initWidth = g_vars.galleryWidth;
        g_functions.checkImagesLoaded(objImages, function() {
            fillTilesVars();
            if (initNumCols != g_vars.numCols || initWidth != g_vars.galleryWidth) {
                placeTiles(false);
            }
            setTransition();
            g_objThis.trigger(t.events.ALL_TILES_LOADED);
        }, function(objImage, isError) {
            if (g_temp.isFirstPlaced == true) g_gallery.triggerEvent(t.events.TILES_FIRST_PLACED);
            onSingleImageLoad(objImage, isError);
        });
    }
    function __________JUSTIFIED_TYPE_RELATED_________() {}
    function getJustifiedData() {
        var galleryWidth = getParentWidth();
        var objTiles = g_thumbs.getThumbs(true);
        var rowHeightOpt = g_options.tiles_justified_row_height;
        var arrWidths = [];
        var totalWidth = 0;
        var gap = g_options.tiles_justified_space_between;
        var numTiles = objTiles.length;
        jQuery.each(objTiles, function(index, objTile) {
            objTile = jQuery(objTile);
            var objItem = g_thumbs.getItemByThumb(objTile);
            var tileWidth = objItem.thumbWidth;
            var tileHeight = objItem.thumbHeight;
            if (tileHeight !== rowHeightOpt) tileWidth = Math.floor(objItem.thumbRatioByWidth * rowHeightOpt);
            arrWidths[index] = tileWidth;
            totalWidth += tileWidth;
        });
        var numRows = Math.ceil(totalWidth / galleryWidth);
        if (numRows > numTiles) numRows = numTiles;
        var finalRowWidth = totalWidth / numRows;
        var arrRows = [], eachRowWidth = 0;
        var rowsWidths = [], rowsTiles = [], row = [];
        var progressWidth = 0, numRow = 0;
        jQuery.each(objTiles, function(index, objTile) {
            var tileWidth = arrWidths[index];
            if (progressWidth + tileWidth / 2 > (numRow + 1) * finalRowWidth) {
                rowsWidths[arrRows.length] = eachRowWidth;
                arrRows.push(row);
                row = [];
                eachRowWidth = 0;
                numRow++;
            }
            progressWidth += tileWidth;
            eachRowWidth += tileWidth;
            row.push(objTile);
        });
        rowsWidths[arrRows.length] = eachRowWidth;
        arrRows.push(row);
        var arrRowWidths = [];
        var arrRowHeights = [];
        var totalHeight = 0;
        jQuery.each(arrRows, function(index, row) {
            var numTiles = row.length;
            var rowWidth = rowsWidths[index];
            var gapWidth = (row.length - 1) * gap;
            var ratio = (galleryWidth - gapWidth) / rowWidth;
            var rowHeight = Math.round(rowHeightOpt * ratio);
            totalHeight += rowHeight;
            if (index > 0) totalHeight += gap;
            arrRowHeights.push(rowHeight);
            var ratioHeights = rowHeight / rowHeightOpt;
            var arrRowTileWidths = [];
            var actualRowWidth = gapWidth;
            jQuery.each(row, function(indexInRow, tile) {
                var objTile = jQuery(tile);
                var tileIndex = objTile.index();
                var tileWidth = arrWidths[tileIndex];
                var newWidth = Math.round(tileWidth * ratioHeights);
                arrRowTileWidths[indexInRow] = newWidth;
                actualRowWidth += newWidth;
            });
            var diff = actualRowWidth - galleryWidth;
            var newTotal = 0;
            jQuery.each(arrRowTileWidths, function(indexInRow, width) {
                if (diff == 0) return false;
                if (diff < 0) {
                    arrRowTileWidths[indexInRow] = width + 1;
                    diff++;
                } else {
                    arrRowTileWidths[indexInRow] = width - 1;
                    diff--;
                }
                if (indexInRow == arrRowTileWidths.length - 1 && diff != 0) arrRowTileWidths[indexInRow] -= diff;
            });
            arrRowWidths[index] = arrRowTileWidths;
        });
        var objData = {
            arrRows: arrRows,
            arrRowWidths: arrRowWidths,
            arrRowHeights: arrRowHeights,
            gap: gap,
            totalHeight: totalHeight
        };
        return objData;
    }
    function placeJustified(toShow) {
        if (!toShow) var toShow = false;
        var parentWidth = getParentWidth();
        var objData = getJustifiedData();
        g_objParent.height(objData.totalHeight);
        var parentWidthAfter = getParentWidth();
        if (parentWidthAfter != parentWidth) objData = getJustifiedData();
        doBeforeTransition();
        var posy = 0;
        var totalWidth = 0;
        jQuery.each(objData.arrRows, function(index, row) {
            var arrRowTileWidths = objData.arrRowWidths[index];
            var rowHeight = objData.arrRowHeights[index];
            var posx = 0;
            jQuery.each(row, function(indexInRow, tile) {
                var objTile = jQuery(tile);
                var tileHeight = rowHeight;
                var tileWidth = arrRowTileWidths[indexInRow];
                g_objTileDesign.resizeTile(objTile, tileWidth, tileHeight, g_objTileDesign.resizemode.VISIBLE_ELEMENTS);
                g_functions.placeElement(objTile, posx, posy);
                posx += tileWidth;
                if (posx > totalWidth) totalWidth = posx;
                posx += objData.gap;
                if (toShow == true) jQuery(tile).show();
            });
            posy += rowHeight + objData.gap;
        });
        doAfterTransition();
    }
    function runJustifiedType() {
        var objImages = jQuery(g_objWrapper).find("img.ug-thumb-image");
        var objTiles = g_thumbs.getThumbs();
        g_temp.isAllLoaded = false;
        objTiles.fadeTo(0, 0);
        g_functions.checkImagesLoaded(objImages, function() {
            setTimeout(function() {
                placeJustified(true);
                objTiles.fadeTo(0, 1);
                g_gallery.triggerEvent(t.events.TILES_FIRST_PLACED);
                setTransition();
                g_objThis.trigger(t.events.ALL_TILES_LOADED);
            });
        }, function(objImage, isError) {
            objImage = jQuery(objImage);
            var objTile = jQuery(objImage).parent();
            g_thumbs.triggerImageLoadedEvent(objTile, objImage);
        });
    }
    function __________NESTED_TYPE_RELATED_________() {}
    function runNestedType() {
        var objImages = jQuery(g_objWrapper).find("img.ug-thumb-image");
        var objTiles = g_thumbs.getThumbs();
        g_temp.isAllLoaded = false;
        objTiles.fadeTo(0, 0);
        g_functions.checkImagesLoaded(objImages, function() {
            if (g_gallery.isMobileMode() == true) {
                placeTiles(true);
            } else placeNestedImages(true);
            g_gallery.triggerEvent(t.events.TILES_FIRST_PLACED);
            setTransition();
            g_objThis.trigger(t.events.ALL_TILES_LOADED);
        }, function(objImage, isError) {
            objImage = jQuery(objImage);
            var objTile = jQuery(objImage).parent();
            g_thumbs.triggerImageLoadedEvent(objTile, objImage);
        });
    }
    function fillNestedVars() {
        var galleryWidth = getParentWidth();
        g_nestedWork.galleryWidth = galleryWidth;
        g_arrNestedGridRow = {};
        g_nestedWork.colWidth = g_options.tiles_nested_col_width;
        g_nestedWork.optimalTileWidth = g_options.tiles_nested_optimal_tile_width;
        g_nestedWork.currentGap = g_options.tiles_space_between_cols;
        if (g_gallery.isMobileMode() == true) g_nestedWork.currentGap = g_options.tiles_space_between_cols_mobile;
        if (g_nestedWork.colWidth == null) {
            g_nestedWork.colWidth = Math.floor(g_nestedWork.optimalTileWidth / g_nestedWork.nestedOptimalCols);
        } else if (g_nestedWork.optimalTileWidth > g_nestedWork.colWidth) {
            g_nestedWork.nestedOptimalCols = Math.ceil(g_nestedWork.optimalTileWidth / g_nestedWork.colWidth);
        } else {
            g_nestedWork.nestedOptimalCols = 1;
        }
        g_nestedWork.maxColumns = g_functions.getNumItemsInSpace(galleryWidth, g_nestedWork.colWidth, g_nestedWork.currentGap);
        g_nestedWork.colWidth = g_functions.getItemSizeInSpace(galleryWidth, g_nestedWork.maxColumns, g_nestedWork.currentGap);
        g_nestedWork.gridY = 0;
        g_arrNestedItems = [];
        var objTiles = g_thumbs.getThumbs(true);
        objTiles.each(function() {
            var objTile = jQuery(this);
            var sizes = setNestedSize(objTile);
            g_arrNestedItems.push(sizes);
        });
        if (g_nestedWork.optimalTileWidth > g_nestedWork.colWidth) {
            g_nestedWork.nestedOptimalCols = Math.ceil(g_nestedWork.optimalTileWidth / g_nestedWork.colWidth);
        } else {
            g_nestedWork.nestedOptimalCols = 1;
        }
        g_nestedWork.totalWidth = g_nestedWork.maxColumns * (g_nestedWork.colWidth + g_nestedWork.currentGap) - g_nestedWork.currentGap;
        switch (g_options.tiles_align) {
          case "center":
          default:
            g_nestedWork.addX = Math.round((g_nestedWork.galleryWidth - g_nestedWork.totalWidth) / 2);
            break;

          case "left":
            g_nestedWork.addX = 0;
            break;

          case "right":
            g_nestedWork.addX = g_nestedWork.galleryWidth - g_nestedWork.totalWidth;
            break;
        }
        g_nestedWork.maxGridY = 0;
    }
    function placeNestedImages(toShow) {
        var parentWidth = getParentWidth();
        fillNestedVars();
        placeNestedImagesCycle();
        var totalHeight = g_nestedWork.maxGridY * (g_nestedWork.colWidth + g_nestedWork.currentGap) - g_nestedWork.currentGap;
        g_objParent.height(totalHeight);
        var parentWidthAfter = getParentWidth();
        if (parentWidthAfter != parentWidth) {
            fillNestedVars();
            placeNestedImagesCycle();
        }
        if (g_options.tiles_nested_debug == false) drawNestedImages(toShow);
    }
    function setNestedSize(objTile) {
        var dimWidth, dimHeight;
        var output = {};
        var colWidth = g_nestedWork.colWidth;
        var gapWidth = g_nestedWork.currentGap;
        var objImageSize = g_objTileDesign.getTileImageSize(objTile);
        var index = objTile.index();
        var maxDim = Math.ceil(getPresettedRandomByWidth(index) * (g_nestedWork.nestedOptimalCols * 1 / 3) + g_nestedWork.nestedOptimalCols * 2 / 3);
        var imgWidth = objImageSize.width;
        var imgHeight = objImageSize.height;
        var ratio = imgWidth / imgHeight;
        if (imgWidth > imgHeight) {
            dimWidth = maxDim;
            dimHeight = Math.round(dimWidth / ratio);
            if (dimHeight == 0) {
                dimHeight = 1;
            }
        } else {
            dimHeight = maxDim;
            dimWidth = Math.round(dimHeight * ratio);
            if (dimWidth == 0) {
                dimWidth = 1;
            }
        }
        output.dimWidth = dimWidth;
        output.dimHeight = dimHeight;
        output.width = dimWidth * colWidth + gapWidth * (dimWidth - 1);
        output.height = dimHeight * colWidth + gapWidth * (dimHeight - 1);
        output.imgWidth = imgWidth;
        output.imgHeight = imgHeight;
        output.left = 0;
        output.top = 0;
        return output;
    }
    function getPresettedRandomByWidth(index) {
        return Math.abs(Math.sin(Math.abs(Math.sin(index) * 1e3)));
    }
    function placeNestedImagesDebug(toShow, placeOne) {
        if (placeOne == false) {
            for (var i = g_nestedWork.currentItem; i < g_arrNestedItems.length; i++) {
                placeNestedImage(i, true);
            }
            g_nestedWork.currentItem = g_arrNestedItems.length - 1;
        } else {
            placeNestedImage(g_nestedWork.currentItem, true);
        }
        for (var i = 0; i <= g_nestedWork.currentItem; i++) {
            drawNestedImage(i, true);
        }
        g_nestedWork.currentItem++;
    }
    function placeNestedImagesCycle(placeOne) {
        if (g_options.tiles_nested_debug == true) {
            if (typeof placeOne === "undefined") placeOne = true;
            placeNestedImagesDebug(true, placeOne);
            return false;
        }
        for (var i = 0; i < g_arrNestedItems.length; i++) placeNestedImage(i, true);
    }
    function placeNestedImage(tileID, toShow) {
        if (!toShow) var toShow = false;
        g_nestedWork.maxColHeight = 0;
        var rowsValue = g_functions.getObjectLength(g_arrNestedGridRow);
        for (var row = g_nestedWork.gridY; row <= rowsValue + 1; row++) {
            for (var column = 0; column < g_nestedWork.maxColumns; column++) {
                if (isGridRowExists(g_nestedWork.gridY) == false || isGridCellTaken(g_nestedWork.gridY, column) == false) {
                    var totalFree = getTotalFreeFromPosition(column);
                    calculateOptimalStretchAndPosition(tileID, totalFree, column);
                    return;
                }
            }
            g_nestedWork.gridY++;
        }
    }
    function calculateOptimalStretchAndPosition(tileID, totalFree, column) {
        var sizes = jQuery.extend(true, {}, g_arrNestedItems[tileID]);
        var currentWidth = sizes.dimWidth;
        var placeForNextImage = totalFree - sizes.dimWidth;
        var optimalWidth = g_nestedWork.nestedOptimalCols;
        var onlyCurrentImage = totalFree <= sizes.dimWidth || placeForNextImage <= .33 * optimalWidth || totalFree <= optimalWidth;
        if (onlyCurrentImage) {
            resizeToNewWidth(tileID, totalFree);
        } else if (placeForNextImage <= optimalWidth) {
            if (optimalWidth >= 4) {
                if (isGridImageAligned(Math.floor(totalFree / 2), column) == true) {
                    resizeToNewWidth(tileID, Math.floor(totalFree / 2) + 1);
                } else {
                    resizeToNewWidth(tileID, Math.floor(totalFree / 2));
                }
            } else {
                resizeToNewWidth(objImage, totalFree);
            }
        } else {
            if (isGridImageAligned(currentWidth, column) == true) {
                switch (currentWidth >= optimalWidth) {
                  case true:
                    resizeToNewWidth(tileID, currentWidth - 1);
                    break;

                  case false:
                    resizeToNewWidth(tileID, currentWidth + 1);
                    break;
                }
            }
        }
        sizes = jQuery.extend(true, {}, g_arrNestedItems[tileID]);
        var columnInfo = getGridColumnHeight(tileID, sizes.dimWidth, column);
        if (g_nestedWork.columnsValueToEnableHeightResize <= columnInfo[0] && g_nestedWork.maxColumns >= 2 * g_nestedWork.nestedOptimalCols) {
            var sideHelper = getGridImageVerticalDifference(column, sizes);
            var columnSizes = resizeToNewHeight(tileID, sideHelper.newHeight, true);
            g_arrNestedItems[tileID].dimHeight = columnSizes.dimHeight;
            var columnResizes = redistributeColumnItems(columnInfo, columnSizes.dimWidth, column);
            var columnCrosshairs = getColumnCrosshairsCount(columnResizes);
            var disableColumnResizes = false;
            if (columnCrosshairs >= 2) {
                disableColumnResizes = true;
            }
            if (sideHelper.newHeight >= sizes.dimHeight) {
                sizes = resizeToNewHeight(tileID, sideHelper.newHeight, true);
            }
            var sideResizes = getSideResizeInfo(sideHelper.idToResize, sideHelper.newHeight, sizes.dimHeight);
            sizes.top = g_nestedWork.gridY;
            sizes.left = column;
            sideResizes.push({
                tileID: tileID,
                sizes: sizes
            });
            var sideResizesVal = calcResizeRatio(sideResizes);
            var columnResizesVal = calcResizeRatio(columnResizes);
            if (sideResizesVal < columnResizesVal || disableColumnResizes == true) {
                applyResizes(sideResizes);
                return;
            } else {
                applyResizes(columnResizes);
                return;
            }
        }
        sizes.left = column;
        sizes.top = g_nestedWork.gridY;
        g_arrNestedItems[tileID] = sizes;
        putImageToGridRow(tileID, sizes, column, g_nestedWork.gridY);
        g_nestedWork.maxGridY = sizes.top + sizes.dimHeight;
    }
    function getColumnCrosshairsCount(tilesAndSizes) {
        var crosshairsCountR = 0;
        var crosshairsCountL = 0;
        for (var i = 0; i < tilesAndSizes.length - 1; i++) {
            var sizes = tilesAndSizes[i].sizes;
            var topItem = -1;
            var bottomItem = -1;
            if (isGridRowExists(sizes.top + sizes.dimHeight) && g_nestedWork.maxColumns > sizes.left + sizes.dimWidth) {
                topItem = g_arrNestedGridRow[sizes.top + sizes.dimHeight - 1][sizes.left + sizes.dimWidth];
                bottomItem = g_arrNestedGridRow[sizes.top + sizes.dimHeight][sizes.left + sizes.dimWidth];
            }
            if (topItem != bottomItem) {
                crosshairsCountR++;
            }
        }
        for (var i = 0; i < tilesAndSizes.length - 1; i++) {
            var sizes = tilesAndSizes[i].sizes;
            var topItem = -1;
            var bottomItem = -1;
            if (isGridRowExists(sizes.top + sizes.dimHeight) && sizes.left - 1 >= 0) {
                topItem = g_arrNestedGridRow[sizes.top + sizes.dimHeight - 1][sizes.left - 1];
                bottomItem = g_arrNestedGridRow[sizes.top + sizes.dimHeight][sizes.left - 1];
            }
            if (topItem != bottomItem) {
                crosshairsCountL++;
            }
        }
        return Math.max(crosshairsCountL, crosshairsCountR);
    }
    function getSideResizeInfo(idToResize, newHeight, dimHeight) {
        var currentTile = g_arrNestedItems[idToResize];
        var tileHeight = currentTile.dimHeight;
        var tileWidth = currentTile.dimWidth;
        var tileLeft = currentTile.left;
        var tileTop = currentTile.top;
        var tileDimTop = parseInt(tileTop / (g_nestedWork.colWidth + g_nestedWork.currentGap));
        var tileDimLeft = parseInt(tileLeft / (g_nestedWork.colWidth + g_nestedWork.currentGap));
        var newSideHeight = tileHeight - newHeight + dimHeight;
        var sideSizes = resizeToNewHeight(idToResize, newSideHeight, true);
        var output = [];
        output.push({
            tileID: idToResize,
            sizes: sideSizes
        });
        return output;
    }
    function applyResizes(resizeTilesAndSizes) {
        for (var i = 0; i < resizeTilesAndSizes.length; i++) {
            var sizes = resizeTilesAndSizes[i].sizes;
            var tileID = resizeTilesAndSizes[i].tileID;
            g_arrNestedItems[tileID] = jQuery.extend(true, {}, sizes);
            putImageToGridRow(tileID, sizes, sizes.left, sizes.top);
        }
    }
    function redistributeColumnItems(columnInfo, columnWidth) {
        var originalHeight = 0;
        var columnHeight = 0;
        var objTiles = [];
        var cordX = 0, cordY = 0;
        for (var i = 0; i < columnInfo[1].length; i++) {
            var tileID = columnInfo[1][i];
            var currentTile = g_arrNestedItems[columnInfo[1][i]];
            columnHeight += currentTile.dimHeight;
            if (i == 0) {
                var sizes = resizeToNewWidth(tileID, columnWidth, true);
                originalHeight += sizes.dimHeight;
                objTiles.push([ columnInfo[1][i], sizes.dimHeight ]);
                continue;
            }
            originalHeight += currentTile.dimHeight;
            objTiles.push([ tileID, currentTile.dimHeight ]);
        }
        cordX = currentTile.left;
        cordY = currentTile.top;
        var tempHeight = columnHeight;
        var output = [];
        for (var i = objTiles.length - 1; i >= 0; i--) {
            var tileID = objTiles[i][0];
            var newHeight;
            if (i != 0) {
                newHeight = Math.max(Math.round(columnHeight * 1 / 3), Math.floor(objTiles[i][1] * (columnHeight / originalHeight)));
                tempHeight = tempHeight - newHeight;
                sizes = resizeToNewHeight(tileID, newHeight, true);
                sizes.left = cordX;
                sizes.top = cordY;
                output.push({
                    tileID: tileID,
                    sizes: sizes
                });
                cordY += sizes.dimHeight;
            } else {
                newHeight = tempHeight;
                sizes = resizeToNewHeight(tileID, newHeight, true);
                sizes.left = cordX;
                sizes.top = cordY;
                output.push({
                    tileID: tileID,
                    sizes: sizes
                });
            }
        }
        return output;
    }
    function getGridColumnHeight(tileID, dimWidth, column) {
        var tempY = g_nestedWork.gridY - 1;
        var curImage = 0;
        var prevImage = 0;
        var columnHeight = 1;
        var imagesIDs = [];
        var toReturn = [];
        imagesIDs.push(tileID);
        if (tempY >= 0) {
            prevImage = 0;
            while (tempY >= 0) {
                curImage = g_arrNestedGridRow[tempY][column];
                if ((typeof g_arrNestedGridRow[tempY][column - 1] === "undefined" || g_arrNestedGridRow[tempY][column - 1] != g_arrNestedGridRow[tempY][column]) && (typeof g_arrNestedGridRow[tempY][column + dimWidth] === "undefined" || g_arrNestedGridRow[tempY][column + dimWidth - 1] != g_arrNestedGridRow[tempY][column + dimWidth]) && g_arrNestedGridRow[tempY][column] == g_arrNestedGridRow[tempY][column + dimWidth - 1]) {
                    if (prevImage != curImage) {
                        columnHeight++;
                        imagesIDs.push(curImage);
                    }
                } else {
                    toReturn.push(columnHeight);
                    toReturn.push(imagesIDs);
                    return toReturn;
                }
                tempY--;
                prevImage = curImage;
            }
            toReturn.push(columnHeight);
            toReturn.push(imagesIDs);
            return toReturn;
        }
        return [ 0, [] ];
    }
    function getGridImageVerticalDifference(column, sizes) {
        var newHeightR = 0;
        var newHeightL = 0;
        var dimWidth = sizes.dimWidth;
        var dimHeight = sizes.dimHeight;
        var leftID = 0;
        var rightID = 0;
        var array = jQuery.map(g_arrNestedGridRow, function(value, index) {
            return [ value ];
        });
        if (typeof array[g_nestedWork.gridY] === "undefined" || typeof array[g_nestedWork.gridY][column - 1] === "undefined") {
            newHeightL = 0;
        } else {
            var tempY = 0;
            while (true) {
                if (typeof g_arrNestedGridRow[g_nestedWork.gridY + tempY] !== "undefined" && g_arrNestedGridRow[g_nestedWork.gridY + tempY][column - 1] != -1) {
                    leftID = g_arrNestedGridRow[g_nestedWork.gridY + tempY][column - 2];
                    tempY++;
                    newHeightL++;
                } else {
                    break;
                }
            }
        }
        if (typeof array[g_nestedWork.gridY] === "undefined" || typeof array[g_nestedWork.gridY][column + dimWidth] === "undefined") {
            newHeightR = 0;
        } else {
            tempY = 0;
            while (true) {
                if (typeof g_arrNestedGridRow[g_nestedWork.gridY + tempY] !== "undefined" && g_arrNestedGridRow[g_nestedWork.gridY + tempY][column + dimWidth] != -1) {
                    rightID = g_arrNestedGridRow[g_nestedWork.gridY + tempY][column + dimWidth + 1];
                    tempY++;
                    newHeightR++;
                } else {
                    break;
                }
            }
        }
        var newHeight = 0;
        var idToResize = 0;
        if (Math.abs(dimHeight - newHeightL) < Math.abs(dimHeight - newHeightR) && newHeightL != 0) {
            newHeight = newHeightL;
            idToResize = leftID;
        } else if (newHeightR != 0) {
            newHeight = newHeightR;
            idToResize = rightID;
        } else {
            newHeight = dimHeight;
        }
        var output = {
            newHeight: newHeight,
            idToResize: idToResize
        };
        return output;
    }
    function resizeToNewWidth(tileID, newDimWidth, toReturn) {
        if (!toReturn) {
            toReturn = false;
        }
        var colWidth = g_nestedWork.colWidth;
        var gapWidth = g_nestedWork.currentGap;
        var currentTile = g_arrNestedItems[tileID];
        var imgWidth = currentTile.imgWidth;
        var imgHeight = currentTile.imgHeight;
        var ratio = imgWidth / imgHeight;
        dimWidth = newDimWidth;
        dimHeight = Math.round(dimWidth / ratio);
        if (toReturn == true) {
            var sizes = jQuery.extend(true, {}, currentTile);
            sizes.dimWidth = dimWidth;
            sizes.dimHeight = dimHeight;
            sizes.width = dimWidth * colWidth + gapWidth * (dimWidth - 1);
            sizes.height = dimHeight * colWidth + gapWidth * (dimHeight - 1);
            return sizes;
        }
        currentTile.dimWidth = dimWidth;
        currentTile.dimHeight = dimHeight;
        currentTile.width = dimWidth * colWidth + gapWidth * (dimWidth - 1);
        currentTile.height = dimHeight * colWidth + gapWidth * (dimHeight - 1);
    }
    function resizeToNewHeight(tileID, newDimHeight, toReturn) {
        if (!toReturn) {
            toReturn = false;
        }
        var currentTile = g_arrNestedItems[tileID];
        var dimWidth = currentTile.dimWidth;
        var colWidth = g_nestedWork.colWidth;
        var gapWidth = g_nestedWork.currentGap;
        if (toReturn == true) {
            var sizes = jQuery.extend(true, {}, currentTile);
            sizes.dimHeight = newDimHeight;
            sizes.width = dimWidth * colWidth + gapWidth * (dimWidth - 1);
            sizes.height = newDimHeight * colWidth + gapWidth * (newDimHeight - 1);
            return sizes;
        }
        currentTile.dimHeight = newDimHeight;
        currentTile.width = dimWidth * colWidth + gapWidth * (dimWidth - 1);
        currentTile.height = newDimHeight * colWidth + gapWidth * (newDimHeight - 1);
    }
    function calcResizeRatio(objTilesAndSizes) {
        var tempResizes = 0;
        var tempNum = 0;
        for (var i = 0; i < objTilesAndSizes.length; i++) {
            var sizes = g_arrNestedItems[objTilesAndSizes[i].tileID];
            if (sizes.dimHeight != 0 && sizes.height != 0) {
                resizeVal = sizes.dimWidth / sizes.dimHeight / (sizes.imgWidth / sizes.imgHeight);
            } else {
                return;
            }
            if (resizeVal < 1) {
                resizeVal = 1 / resizeVal;
            }
            tempResizes += resizeVal;
            tempNum++;
        }
        return tempResizes / tempNum;
    }
    function isGridImageAligned(dimWidth, column) {
        var y = g_nestedWork.gridY - 1;
        if (y <= 0 || isGridRowExists(y) == false) {
            return false;
        }
        if (g_arrNestedGridRow[y][column + dimWidth - 1] != g_arrNestedGridRow[y][column + dimWidth]) {
            return true;
        }
        return false;
    }
    function getTotalFreeFromPosition(column) {
        var x = column;
        var totalFree = 0;
        if (isGridRowExists(g_nestedWork.gridY) == true) {
            while (isGridCellTaken(g_nestedWork.gridY, x) == false) {
                totalFree++;
                x++;
            }
        } else {
            totalFree = g_nestedWork.maxColumns;
        }
        return totalFree;
    }
    function isGridRowExists(y) {
        if (typeof g_arrNestedGridRow[y] === "undefined") {
            return false;
        }
        return true;
    }
    function putImageToGridRow(id, sizes, gridX, gridY) {
        for (var y = 0; y < sizes.dimHeight; y++) {
            for (var x = 0; x < sizes.dimWidth; x++) {
                if (isGridRowExists(gridY + y) == 0) {
                    addGridRow(gridY + y);
                }
                setGridCellValue(gridY + y, gridX + x, id);
            }
        }
    }
    function addGridRow(y) {
        g_arrNestedGridRow[y] = new Object();
        for (var t = 0; t < g_nestedWork.maxColumns; t++) {
            g_arrNestedGridRow[y][t] = -1;
        }
    }
    function isGridCellTaken(y, x) {
        return g_arrNestedGridRow[y][x] != -1;
    }
    function setGridCellValue(y, x, value) {
        g_arrNestedGridRow[y][x] = value;
    }
    function drawNestedImages(toShow) {
        if (!toShow) var toShow = false;
        doBeforeTransition();
        for (var i = 0; i < g_arrNestedItems.length; i++) {
            drawNestedImage(i, toShow);
        }
        g_objParent.height(g_nestedWork.maxColHeight);
        doAfterTransition();
    }
    function drawNestedImage(i, toShow) {
        var objTile = g_thumbs.getThumbByIndex(i);
        var sizes = g_arrNestedItems[i];
        var newY = sizes.top * (g_nestedWork.colWidth + g_nestedWork.currentGap);
        var newX = g_nestedWork.addX + sizes.left * (g_nestedWork.colWidth + g_nestedWork.currentGap);
        g_objTileDesign.resizeTile(objTile, sizes.width, sizes.height, g_objTileDesign.resizemode.VISIBLE_ELEMENTS);
        g_functions.placeElement(objTile, newX, newY);
        if (newY + sizes.height > g_nestedWork.maxColHeight) {
            g_nestedWork.maxColHeight = newY + sizes.height;
        }
        if (toShow == true) {
            objTile.fadeTo(0, 1);
        }
    }
    function __________COMMON_AND_EVENTS_______() {}
    function onResize() {
        if (g_temp.isFirstTimeRun == true) return true;
        if (g_temp.isAllLoaded == false) return false;
        switch (g_options.tiles_type) {
          case "columns":
            placeTiles(false);
            break;

          case "justified":
            placeJustified(false);
            break;

          case "nested":
            var isMobileMode = g_gallery.isMobileMode();
            if (isMobileMode == true) {
                placeTiles(false);
            } else placeNestedImages(false);
            break;
        }
    }
    function initEvents() {
        g_objThis.on(t.events.ALL_TILES_LOADED, function() {
            g_temp.isAllLoaded = true;
        });
        g_objGallery.on(g_gallery.events.SIZE_CHANGE, onResize);
        g_objGallery.on(t.events.TILES_FIRST_PLACED, function() {
            g_temp.isFirstPlaced = false;
        });
        g_objTileDesign.initEvents();
    }
    function run() {
        g_objWrapper.children(".ug-tile").show();
        if (g_temp.isFirstTimeRun == true) {
            initEvents();
        }
        g_objTileDesign.run();
        switch (g_options.tiles_type) {
          default:
          case "columns":
            runColumnsType();
            break;

          case "justified":
            runJustifiedType();
            break;

          case "nested":
            runNestedType();
            break;
        }
        g_temp.isFirstTimeRun = false;
    }
    this.destroy = function() {
        g_objGallery.off(g_gallery.events.SIZE_CHANGE);
        g_objTileDesign.destroy();
        g_objGallery.off(t.events.TILES_FIRST_PLACED);
    };
    this.init = function(gallery, customOptions) {
        init(gallery, customOptions);
    };
    this.setHtml = function(objParent) {
        setHtml(objParent);
    };
    this.getObjTileDesign = function() {
        return g_objTileDesign;
    };
    this.run = function() {
        run();
    };
    this.runNewItems = function() {
        if (!g_objParent) throw new Error("Can't run new items - parent not set");
        g_objTileDesign.setHtml(g_objParent, true);
        g_objTileDesign.run(true);
        switch (g_options.tiles_type) {
          case "columns":
            runColumnsType();
            break;

          default:
          case "justified":
          case "nested":
            throw new Error("Tiles type: " + g_options.tiles_type + " not support load more yet");
            break;
        }
    };
}

function UGTileDesign() {
    var t = this, g_objThis = jQuery(this);
    var g_gallery = new UniteGalleryMain(), g_objGallery;
    var g_functions = new UGFunctions(), g_objParentWrapper, g_objWrapper;
    var g_thumbs = new UGThumbsGeneral(), g_items;
    this.resizemode = {
        FULL: "full",
        WRAPPER_ONLY: "wrapper_only",
        VISIBLE_ELEMENTS: "visible_elements"
    };
    this.sizeby = {
        GLOBAL_RATIO: "global_ratio",
        TILE_RATIO: "tile_ratio",
        IMAGE_RATIO: "image_ratio",
        CUSTOM: "custom"
    };
    this.events = {
        TILE_CLICK: "tile_click"
    };
    var g_options = {
        tile_width: 250,
        tile_height: 200,
        tile_size_by: t.sizeby.IMAGE_RATIO,
        tile_visible_before_image: false,
        tile_enable_background: true,
        tile_background_color: "#F0F0F0",
        tile_enable_border: false,
        tile_border_width: 3,
        tile_border_color: "#F0F0F0",
        tile_border_radius: 0,
        tile_enable_outline: false,
        tile_outline_color: "#8B8B8B",
        tile_enable_shadow: false,
        tile_shadow_h: 1,
        tile_shadow_v: 1,
        tile_shadow_blur: 3,
        tile_shadow_spread: 2,
        tile_shadow_color: "#8B8B8B",
        tile_enable_action: true,
        tile_as_link: false,
        tile_link_newpage: true,
        tile_enable_overlay: true,
        tile_overlay_opacity: .4,
        tile_overlay_color: "#000000",
        tile_enable_icons: true,
        tile_show_link_icon: false,
        tile_videoplay_icon_always_on: "never",
        tile_space_between_icons: 26,
        tile_enable_image_effect: false,
        tile_image_effect_type: "bw",
        tile_image_effect_reverse: false,
        tile_enable_textpanel: false,
        tile_textpanel_source: "title",
        tile_textpanel_always_on: false,
        tile_textpanel_appear_type: "slide",
        tile_textpanel_position: "inside_bottom",
        tile_textpanel_offset: 0
    };
    var g_defaults = {
        thumb_color_overlay_effect: true,
        thumb_overlay_reverse: true,
        thumb_image_overlay_effect: false,
        tile_textpanel_enable_description: false,
        tile_textpanel_bg_opacity: .6,
        tile_textpanel_padding_top: 8,
        tile_textpanel_padding_bottom: 8
    };
    var g_temp = {
        ratioByHeight: 0,
        ratioByWidth: 0,
        eventSizeChange: "thumb_size_change",
        funcCustomTileHtml: null,
        funcCustomPositionElements: null,
        funcParentApproveClick: null,
        isSaparateIcons: false,
        tileInnerReduce: 0,
        isTextpanelOutside: false,
        hasImageContainer: false,
        isVideoplayIconAlwaysOn: false,
        isTextPanelHidden: false
    };
    function init(gallery, customOptions) {
        g_gallery = gallery;
        g_objGallery = jQuery(gallery);
        var objects = g_gallery.getObjects();
        g_objWrapper = objects.g_objWrapper;
        g_items = g_gallery.getArrItems();
        g_options = jQuery.extend(g_options, g_defaults);
        g_options = jQuery.extend(g_options, customOptions);
        modifyOptions();
        g_thumbs.init(gallery, g_options);
        var objCustomOptions = {
            allow_onresize: false
        };
        var customThumbsAdd = [ "overlay" ];
        if (g_temp.funcCustomTileHtml) customThumbsAdd = [];
        g_thumbs.setCustomThumbs(setHtmlThumb, customThumbsAdd, objCustomOptions);
        var thumbOptions = g_thumbs.getOptions();
        g_options = jQuery.extend(g_options, thumbOptions);
        g_temp.ratioByWidth = g_options.tile_width / g_options.tile_height;
        g_temp.ratioByHeight = g_options.tile_height / g_options.tile_width;
        if (g_options.tile_size_by == t.sizeby.GLOBAL_RATIO && g_temp.isTextpanelOutside) g_temp.hasImageContainer = true;
    }
    function modifyOptions() {
        if (g_options.tile_enable_overlay == true) {
            g_options.thumb_overlay_opacity = g_options.tile_overlay_opacity;
            g_options.thumb_overlay_color = g_options.tile_overlay_color;
        } else if (g_options.tile_enable_icons == false) {
            g_options.thumb_color_overlay_effect = false;
        } else {
            g_options.thumb_overlay_opacity = 0;
        }
        if (g_options.tile_as_link) {
            g_options.thumb_wrapper_as_link = true;
            g_options.thumb_link_newpage = g_options.tile_link_newpage;
        }
        if (g_options.tile_enable_outline == true && g_options.tile_enable_border == false) g_options.tile_enable_outline = false;
        g_temp.tileInnerReduce = 0;
        if (g_options.tile_enable_border) {
            g_temp.tileInnerReduce = g_options.tile_border_width * 2;
            g_thumbs.setThumbInnerReduce(g_temp.tileInnerReduce);
        }
        g_temp.isSaparateIcons = !g_functions.isRgbaSupported();
        if (g_options.tile_enable_textpanel == true) {
            switch (g_options.tile_textpanel_position) {
              case "top":
                g_options.tile_textpanel_align = "top";

              case "bottom":
                g_temp.isTextpanelOutside = true;
                g_options.tile_textpanel_always_on = true;
                g_options.tile_textpanel_offset = 0;
                break;

              case "inside_top":
                g_options.tile_textpanel_align = "top";
                break;

              case "middle":
                g_options.tile_textpanel_align = "middle";
                g_options.tile_textpanel_appear_type = "fade";
                break;
            }
            if (g_options.tile_textpanel_always_on == false) g_temp.isSaparateIcons = true;
        }
        if (g_options.tile_textpanel_offset != 0) {
            g_options.tile_textpanel_appear_type = "fade";
            g_options.tile_textpanel_margin = g_options.tile_textpanel_offset;
        }
        if (g_options.tile_textpanel_source == "title_and_desc") {
            g_options.tile_textpanel_enable_description = true;
            g_options.tile_textpanel_desc_style_as_title = true;
        }
    }
    function modifyOptionsBeforeRender() {
        var isMobile = g_gallery.isMobileMode();
        g_temp.isTextPanelHidden = false;
        if (isMobile == true && g_options.tile_textpanel_always_on == false) g_temp.isTextPanelHidden = true;
        g_temp.isVideoplayIconAlwaysOn = g_options.tile_videoplay_icon_always_on;
        switch (g_options.tile_videoplay_icon_always_on) {
          case "always":
            g_temp.isVideoplayIconAlwaysOn = true;
            break;

          case "never":
            g_temp.isVideoplayIconAlwaysOn = false;
            break;

          case "mobile_only":
            g_temp.isVideoplayIconAlwaysOn = isMobile == true ? true : false;
            break;

          case "desktop_only":
            g_temp.isVideoplayIconAlwaysOn = isMobile == false ? true : false;
            break;
        }
    }
    function setHtmlThumb(objThumbWrapper, objItem) {
        objThumbWrapper.addClass("ug-tile");
        if (g_temp.funcCustomTileHtml) {
            g_temp.funcCustomTileHtml(objThumbWrapper, objItem);
            return false;
        }
        var html = "";
        if (g_temp.hasImageContainer == true) {
            html += "<div class='ug-image-container ug-trans-enabled'>";
        }
        var classImage = "ug-thumb-image";
        if (g_options.tile_enable_image_effect == false || g_options.tile_image_effect_reverse == true) classImage += " ug-trans-enabled";
        var imageAlt = g_functions.stripTags(objItem.title);
        imageAlt = g_functions.htmlentitles(imageAlt);
        html += '<img src="' + g_functions.escapeDoubleSlash(objItem.urlThumb) + "\" alt='" + imageAlt + "' class='" + classImage + "'>";
        if (g_temp.hasImageContainer == true) {
            html += "</div>";
        }
        objThumbWrapper.append(html);
        if (g_options.tile_size_by == t.sizeby.GLOBAL_RATIO) {
            objThumbWrapper.fadeTo(0, 0);
        }
        var objCss = {};
        if (g_options.tile_enable_background == true) {
            objCss["background-color"] = g_options.tile_background_color;
        }
        if (g_options.tile_enable_border == true) {
            objCss["border-width"] = g_options.tile_border_width + "px";
            objCss["border-style"] = "solid";
            objCss["border-color"] = g_options.tile_border_color;
            if (g_options.tile_border_radius) objCss["border-radius"] = g_options.tile_border_radius + "px";
        }
        if (g_options.tile_enable_outline == true) {
            objCss["outline"] = "1px solid " + g_options.tile_outline_color;
        }
        if (g_options.tile_enable_shadow == true) {
            var htmlShadow = g_options.tile_shadow_h + "px ";
            htmlShadow += g_options.tile_shadow_v + "px ";
            htmlShadow += g_options.tile_shadow_blur + "px ";
            htmlShadow += g_options.tile_shadow_spread + "px ";
            htmlShadow += g_options.tile_shadow_color;
            objCss["box-shadow"] = htmlShadow;
        }
        objThumbWrapper.css(objCss);
        var htmlAdd = "";
        if (g_options.tile_enable_icons) {
            if (g_options.tile_as_link == false && g_options.tile_enable_action == true) {
                var iconPlayClass = "ug-button-play ug-icon-zoom";
                if (objItem.type != "image") iconPlayClass = "ug-button-play ug-icon-play";
                htmlAdd += "<div class='ug-tile-icon " + iconPlayClass + "' style='display:none'></div>";
            }
            if (objItem.link && g_options.tile_show_link_icon == true || g_options.tile_as_link == true) {
                if (g_options.tile_as_link == false) {
                    var linkTarget = "";
                    if (g_options.tile_link_newpage == true) linkTarget = " target='_blank'";
                    htmlAdd += "<a href='" + objItem.link + "'" + linkTarget + " class='ug-tile-icon ug-icon-link'></a>";
                } else {
                    htmlAdd += "<div class='ug-tile-icon ug-icon-link' style='display:none'></div>";
                }
            }
            var toSaparateIcon = g_temp.isSaparateIcons;
            if (toSaparateIcon == false && objItem.type != "image" && g_temp.isVideoplayIconAlwaysOn == true) toSaparateIcon = true;
            if (toSaparateIcon) var objOverlay = objThumbWrapper; else var objOverlay = objThumbWrapper.children(".ug-thumb-overlay");
            objOverlay.append(htmlAdd);
            var objButtonZoom = objOverlay.children("." + iconPlayClass);
            if (objButtonZoom.length == 0) objButtonZoom = null; else objButtonZoom.hide();
            var objButtonLink = objOverlay.children(".ug-icon-link");
            if (objButtonLink.length == 0) objButtonLink = null; else objButtonLink.hide();
            if (!objButtonLink && g_options.tile_enable_action == true) objThumbWrapper.addClass("ug-tile-clickable");
        } else {
            if (g_options.tile_enable_action == true) objThumbWrapper.addClass("ug-tile-clickable");
        }
        if (g_options.tile_enable_image_effect == true) {
            var imageEffectClassAdd = "";
            if (g_options.tile_image_effect_reverse == false) imageEffectClassAdd = " ug-trans-enabled";
            var imageOverlayHtml = "<div class='ug-tile-image-overlay" + imageEffectClassAdd + "' >";
            var imageEffectClass = " ug-" + g_options.tile_image_effect_type + "-effect";
            imageOverlayHtml += '<img src="' + g_functions.escapeDoubleSlash(objItem.urlThumb) + "\" alt='" + objItem.title + "' class='" + imageEffectClass + imageEffectClassAdd + "'>";
            imageOverlayHtml += "</div>";
            objThumbWrapper.append(imageOverlayHtml);
            if (g_options.tile_image_effect_reverse == true) {
                objThumbWrapper.children(".ug-tile-image-overlay").fadeTo(0, 0);
            }
        }
        if (g_options.tile_enable_textpanel == true) {
            var objTextPanel = new UGTextPanel();
            objTextPanel.init(g_gallery, g_options, "tile");
            var textpanelAddClass = "";
            if (g_options.tile_textpanel_always_on == true || g_temp.isTextpanelOutside == true) textpanelAddClass = "ug-trans-enabled";
            objTextPanel.appendHTML(objThumbWrapper, textpanelAddClass);
            var panelTitle = objItem.title;
            var panelDesc = "";
            switch (g_options.tile_textpanel_source) {
              case "desc":
              case "description":
                panelTitle = objItem.description;
                break;

              case "desc_title":
                if (objItem.description != "") panelTitle = objItem.description;
                break;

              case "title_and_desc":
                panelTitle = objItem.title;
                panelDesc = objItem.description;
                break;
            }
            objTextPanel.setTextPlain(panelTitle, panelDesc);
            if (g_options.tile_textpanel_always_on == false) objTextPanel.getElement().fadeTo(0, 0);
            objThumbWrapper.data("objTextPanel", objTextPanel);
            if (g_options.tile_textpanel_always_on == true) {
                var textPanelElement = getTextPanelElement(objThumbWrapper);
                textPanelElement.css("z-index", 2);
            }
            if (g_temp.isTextpanelOutside == true) {
                var htmlClone = "<div class='ug-tile-cloneswrapper'></div>";
                objThumbWrapper.append(htmlClone);
                var objCloneWrapper = objThumbWrapper.children(".ug-tile-cloneswrapper");
                var objTextPanelClone = new UGTextPanel();
                objTextPanelClone.init(g_gallery, g_options, "tile");
                objTextPanelClone.appendHTML(objCloneWrapper);
                objTextPanelClone.setTextPlain(panelTitle, panelDesc);
                objThumbWrapper.data("objTextPanelClone", objTextPanelClone);
            }
        }
        if (objItem.addHtml !== null) objThumbWrapper.append(objItem.addHtml);
    }
    this.loadTileImage = function(objTile) {
        var objImage = t.getTileImage(objTile);
        g_functions.checkImagesLoaded(objImage, null, function(objImage, isError) {
            onPlaceImage(null, objTile, jQuery(objImage));
        });
    };
    function _________________GETTERS________________() {}
    function getTileOverlayImage(objTile) {
        var objOverlayImage = objTile.children(".ug-tile-image-overlay");
        return objOverlayImage;
    }
    function getTileOverlay(objTile) {
        var objOverlay = objTile.children(".ug-thumb-overlay");
        return objOverlay;
    }
    function getTileImageContainer(objTile) {
        if (g_temp.hasImageContainer == false) return null;
        var objImageContainer = objTile.children(".ug-image-container");
        return objImageContainer;
    }
    function getTileImageEffect(objTile) {
        var objImageEffect = objTile.find(".ug-tile-image-overlay img");
        return objImageEffect;
    }
    function getTextPanel(objTile) {
        var objTextPanel = objTile.data("objTextPanel");
        return objTextPanel;
    }
    function getTextPanelClone(objTile) {
        var objTextPanelClone = objTile.data("objTextPanelClone");
        return objTextPanelClone;
    }
    function getTextPanelElement(objTile) {
        var objTextPanel = objTile.children(".ug-textpanel");
        return objTextPanel;
    }
    function getTextPanelCloneElement(objTile) {
        var objTextPanel = objTile.find(".ug-tile-cloneswrapper .ug-textpanel");
        if (objTextPanel.length == 0) throw new Error("text panel cloned element not found");
        return objTextPanel;
    }
    function getTextPanelHeight(objTile) {
        if (g_temp.isTextpanelOutside == true) var objTextPanel = getTextPanelCloneElement(objTile); else var objTextPanel = getTextPanelElement(objTile);
        if (!objTextPanel) return 0;
        var objSize = g_functions.getElementSize(objTextPanel);
        return objSize.height;
    }
    function getButtonLink(objTile) {
        var objButton = objTile.find(".ug-icon-link");
        if (objButton.length == 0) return null;
        return objButton;
    }
    function getTileRatio(objTile) {
        var ratio = g_temp.ratioByHeight;
        switch (g_options.tile_size_by) {
          default:
            ratio = g_temp.ratioByHeight;
            break;

          case t.sizeby.IMAGE_RATIO:
            if (!objTile) throw new Error("tile should be given for tile ratio");
            var item = t.getItemByTile(objTile);
            if (typeof item.thumbRatioByHeight != "undefined") {
                if (item.thumbRatioByHeight == 0) {
                    trace(item);
                    throw new Error("the item ratio not inited yet");
                }
                ratio = item.thumbRatioByHeight;
            }
            break;

          case t.sizeby.CUSTOM:
            return null;
            break;
        }
        return ratio;
    }
    function getButtonZoom(objTile) {
        var objButton = objTile.find(".ug-button-play");
        if (objButton.length == 0) return null;
        return objButton;
    }
    function isOverStyle(objTile) {
        if (objTile.hasClass("ug-thumb-over")) return true;
        return false;
    }
    function isTileClickable(objTile) {
        return objTile.hasClass("ug-tile-clickable");
    }
    function isItemIconAlwaysOn(objItem) {
        if (g_options.tile_enable_icons == true && g_temp.isVideoplayIconAlwaysOn == true && objItem.type != "image") return true;
        return false;
    }
    function _________________SETTERS________________() {}
    function positionElements_images(objTile, width, height, visibleOnly) {
        var objImageOverlay = getTileOverlayImage(objTile);
        var objThumbImage = t.getTileImage(objTile);
        var objImageEffect = getTileImageEffect(objTile);
        width -= g_temp.tileInnerReduce;
        height -= g_temp.tileInnerReduce;
        var imagePosy = null;
        if (g_temp.isTextpanelOutside == true) {
            var textHeight = getTextPanelHeight(objTile);
            height -= textHeight;
            if (g_options.tile_textpanel_position == "top") {
                imagePosy = textHeight;
            }
            if (g_temp.hasImageContainer == true) {
                var objImageContainer = getTileImageContainer(objTile);
                g_functions.setElementSize(objImageContainer, width, height);
                if (imagePosy !== null) g_functions.placeElement(objImageContainer, 0, imagePosy);
            }
        }
        if (g_options.tile_enable_image_effect == false) {
            g_functions.scaleImageCoverParent(objThumbImage, width, height);
            if (g_temp.hasImageContainer == false && imagePosy !== null) g_functions.placeElement(objThumbImage, 0, imagePosy);
        } else {
            var dontResize = "nothing";
            if (visibleOnly === true && g_temp.isTextpanelOutside == false) {
                if (g_options.tile_image_effect_reverse == true) {
                    dontResize = "effect";
                } else {
                    dontResize = "image";
                }
            }
            if (dontResize != "effect") {
                g_functions.setElementSize(objImageOverlay, width, height);
                if (imagePosy !== null) g_functions.placeElement(objImageOverlay, 0, imagePosy);
                g_functions.scaleImageCoverParent(objImageEffect, width, height);
            }
            if (dontResize != "image") {
                if (g_temp.hasImageContainer == true) {
                    g_functions.scaleImageCoverParent(objThumbImage, width, height);
                } else {
                    if (dontResize == "effect") {
                        g_functions.scaleImageCoverParent(objThumbImage, width, height);
                        if (imagePosy !== null) g_functions.placeElement(objThumbImage, 0, imagePosy);
                    } else g_functions.cloneElementSizeAndPos(objImageEffect, objThumbImage, false, null, imagePosy);
                }
            }
        }
    }
    function positionElements_textpanel(objTile, panelType, tileWidth, tileHeight) {
        var panelWidth = null;
        if (tileWidth) panelWidth = tileWidth - g_temp.tileInnerReduce;
        if (tileHeight) tileHeight -= g_temp.tileInnerReduce;
        if (panelType == "clone") {
            var objTextPanelClone = getTextPanelClone(objTile);
            objTextPanelClone.refresh(true, true, panelWidth);
            var objItem = t.getItemByTile(objTile);
            objItem.textPanelCloneSizeSet = true;
            return false;
        }
        var objTextPanel = getTextPanel(objTile);
        if (!objTextPanel) return false;
        var panelHeight = null;
        if (g_temp.isTextpanelOutside == true) panelHeight = getTextPanelHeight(objTile);
        objTextPanel.refresh(false, true, panelWidth, panelHeight);
        var isPosition = g_options.tile_textpanel_always_on == true || g_options.tile_textpanel_appear_type == "fade";
        if (isPosition) {
            if (g_temp.isTextpanelOutside == true && tileHeight && g_options.tile_textpanel_position == "bottom") {
                var posy = tileHeight - panelHeight;
                objTextPanel.positionPanel(posy);
            } else objTextPanel.positionPanel();
        }
    }
    function positionElements(objTile) {
        var objItem = t.getItemByTile(objTile);
        var objButtonZoom = getButtonZoom(objTile);
        var objButtonLink = getButtonLink(objTile);
        var sizeTile = g_functions.getElementSize(objTile);
        positionElements_images(objTile, sizeTile.width, sizeTile.height);
        if (g_options.tile_enable_textpanel == true) positionElements_textpanel(objTile, "regular", sizeTile.width, sizeTile.height);
        var overlayWidth = sizeTile.width - g_temp.tileInnerReduce;
        var overlayHeight = sizeTile.height - g_temp.tileInnerReduce;
        var overlayY = 0;
        if (g_temp.isTextpanelOutside == true) {
            var textHeight = getTextPanelHeight(objTile);
            overlayHeight -= textHeight;
            if (g_options.tile_textpanel_position == "top") overlayY = textHeight;
        }
        var objOverlay = getTileOverlay(objTile);
        g_functions.setElementSizeAndPosition(objOverlay, 0, overlayY, overlayWidth, overlayHeight);
        if (objButtonZoom || objButtonLink) {
            var gapVert = 0;
            if (g_options.tile_enable_textpanel == true && g_temp.isTextPanelHidden == false && g_temp.isTextpanelOutside == false) {
                var objTextPanelElement = getTextPanelElement(objTile);
                var texPanelSize = g_functions.getElementSize(objTextPanelElement);
                if (texPanelSize.height > 0) gapVert = Math.floor(texPanelSize.height / 2 * -1);
            }
        }
        if (objButtonZoom && objButtonLink) {
            var sizeZoom = g_functions.getElementSize(objButtonZoom);
            var sizeLink = g_functions.getElementSize(objButtonLink);
            var spaceBetween = g_options.tile_space_between_icons;
            var buttonsWidth = sizeZoom.width + spaceBetween + sizeLink.width;
            var buttonsX = Math.floor((sizeTile.width - buttonsWidth) / 2);
            if (buttonsX < spaceBetween) {
                spaceBetween = Math.floor((sizeTile.width - sizeZoom.width - sizeLink.width) / 3);
                buttonsWidth = sizeZoom.width + spaceBetween + sizeLink.width;
                buttonsX = Math.floor((sizeTile.width - buttonsWidth) / 2);
            }
            g_functions.placeElement(objButtonZoom, buttonsX, "middle", 0, gapVert);
            g_functions.placeElement(objButtonLink, buttonsX + sizeZoom.width + spaceBetween, "middle", 0, gapVert);
        } else {
            if (objButtonZoom) g_functions.placeElement(objButtonZoom, "center", "middle", 0, gapVert);
            if (objButtonLink) g_functions.placeElement(objButtonLink, "center", "middle", 0, gapVert);
        }
        if (objButtonZoom) objButtonZoom.show();
        if (objButtonLink) objButtonLink.show();
    }
    this.setHtml = function(objParent, isAppend) {
        g_objParentWrapper = objParent;
        if (isAppend !== true) modifyOptionsBeforeRender();
        g_thumbs.setHtmlThumbs(objParent, isAppend);
    };
    function setImageOverlayEffect(objTile, isActive) {
        var objItem = t.getItemByTile(objTile);
        var objOverlayImage = getTileOverlayImage(objTile);
        var animationDuration = g_options.thumb_transition_duration;
        if (g_options.tile_image_effect_reverse == false) {
            var objThumbImage = t.getTileImage(objTile);
            if (isActive) {
                objThumbImage.fadeTo(0, 1);
                objOverlayImage.stop(true).fadeTo(animationDuration, 0);
            } else objOverlayImage.stop(true).fadeTo(animationDuration, 1);
        } else {
            if (isActive) {
                objOverlayImage.stop(true).fadeTo(animationDuration, 1);
            } else {
                objOverlayImage.stop(true).fadeTo(animationDuration, 0);
            }
        }
    }
    function setTextpanelEffect(objTile, isActive) {
        var animationDuration = g_options.thumb_transition_duration;
        var objTextPanel = getTextPanelElement(objTile);
        if (!objTextPanel) return true;
        if (g_options.tile_textpanel_appear_type == "slide") {
            var panelSize = g_functions.getElementSize(objTextPanel);
            if (panelSize.width == 0) return false;
            var startPos = -panelSize.height;
            var endPos = 0;
            var startClass = {}, endClass = {};
            var posName = "bottom";
            if (g_options.tile_textpanel_position == "inside_top") posName = "top";
            startClass[posName] = startPos + "px";
            endClass[posName] = endPos + "px";
            if (isActive == true) {
                objTextPanel.fadeTo(0, 1);
                if (objTextPanel.is(":animated") == false) objTextPanel.css(startClass);
                endClass["opacity"] = 1;
                objTextPanel.stop(true).animate(endClass, animationDuration);
            } else {
                objTextPanel.stop(true).animate(startClass, animationDuration);
            }
        } else {
            if (isActive == true) {
                objTextPanel.stop(true).fadeTo(animationDuration, 1);
            } else {
                objTextPanel.stop(true).fadeTo(animationDuration, 0);
            }
        }
    }
    function setIconsEffect(objTile, isActive, noAnimation) {
        var animationDuration = g_options.thumb_transition_duration;
        if (noAnimation && noAnimation === true) animationDuration = 0;
        var g_objIconZoom = getButtonZoom(objTile);
        var g_objIconLink = getButtonLink(objTile);
        var opacity = isActive ? 1 : 0;
        if (g_objIconZoom) g_objIconZoom.stop(true).fadeTo(animationDuration, opacity);
        if (g_objIconLink) g_objIconLink.stop(true).fadeTo(animationDuration, opacity);
    }
    function setOverStyle(data, objTile) {
        objTile = jQuery(objTile);
        if (g_options.tile_enable_image_effect) setImageOverlayEffect(objTile, true);
        if (g_options.tile_enable_textpanel == true && g_options.tile_textpanel_always_on == false && g_temp.isTextPanelHidden == false) setTextpanelEffect(objTile, true);
        if (g_temp.isSaparateIcons && g_options.tile_enable_icons == true) {
            var isSet = g_options.thumb_overlay_reverse == true;
            var objItem = t.getItemByTile(objTile);
            if (isItemIconAlwaysOn(objItem) == false) setIconsEffect(objTile, isSet, false);
        }
    }
    function setNormalStyle(data, objTile) {
        objTile = jQuery(objTile);
        if (g_options.tile_enable_image_effect) setImageOverlayEffect(objTile, false);
        if (g_options.tile_enable_textpanel == true && g_options.tile_textpanel_always_on == false) setTextpanelEffect(objTile, false);
        if (g_temp.isSaparateIcons == true && g_options.tile_enable_icons == true) {
            var isSet = g_options.thumb_overlay_reverse == true ? false : true;
            var objItem = t.getItemByTile(objTile);
            if (isItemIconAlwaysOn(objItem) == false) setIconsEffect(objTile, isSet, false); else {
                setIconsEffect(objTile, true, true);
            }
        }
    }
    function setAllTilesNormalStyle(objTileExcept) {
        var objTiles = g_thumbs.getThumbs().not(objTileExcept);
        objTiles.each(function(index, objTile) {
            g_thumbs.setThumbNormalStyle(jQuery(objTile));
        });
    }
    function _________________EVENTS________________() {}
    function onSizeChange(data, objTile, forcePosition) {
        objTile = jQuery(objTile);
        if (g_options.tile_visible_before_image == true && objTile.data("image_placed") !== true && forcePosition !== true) return true;
        positionElements(objTile);
        g_thumbs.setThumbNormalStyle(objTile);
    }
    function onPlaceImage(data, objTile, objImage) {
        positionElements(objTile);
        objImage.fadeTo(0, 1);
        objTile.data("image_placed", true);
    }
    function onMobileClick(objTile) {
        if (isTileClickable(objTile) == true) {
            g_objThis.trigger(t.events.TILE_CLICK, objTile);
            return true;
        }
        if (isOverStyle(objTile) == false) {
            setAllTilesNormalStyle(objTile);
            g_thumbs.setThumbOverStyle(objTile);
        }
    }
    function onTileClick(event) {
        var objTile = jQuery(this);
        var tagname = objTile.prop("tagName").toLowerCase();
        var isApproved = true;
        if (g_temp.funcParentApproveClick && g_temp.funcParentApproveClick() == false) isApproved = false;
        if (tagname == "a") {
            if (isApproved == false) event.preventDefault();
        } else {
            if (isOverStyle(objTile) == false) {
                if (isApproved == true) onMobileClick(objTile);
            } else {
                if (isTileClickable(objTile) == false) return true;
                if (isApproved == true) g_objThis.trigger(t.events.TILE_CLICK, objTile);
            }
        }
    }
    function onZoomButtonClick(event) {
        event.stopPropagation();
        var objTile = jQuery(this).parents(".ug-tile");
        var isApproved = true;
        if (g_temp.funcParentApproveClick && g_temp.funcParentApproveClick() == false) isApproved = false;
        if (isOverStyle(objTile) == false) {
            onMobileClick(objTile);
            return true;
        }
        if (isApproved == true) {
            g_objThis.trigger(t.events.TILE_CLICK, objTile);
            return false;
        }
    }
    function onLinkButtonClick(event) {
        var objTile = jQuery(this).parents(".ug-tile");
        if (g_temp.funcParentApproveClick && g_temp.funcParentApproveClick() == false) event.preventDefault();
        if (isOverStyle(objTile) == false && g_options.tile_as_link == false) {
            event.preventDefault();
            onMobileClick(objTile);
        }
    }
    this.initEvents = function() {
        g_thumbs.initEvents();
        jQuery(g_thumbs).on(g_thumbs.events.SETOVERSTYLE, setOverStyle);
        jQuery(g_thumbs).on(g_thumbs.events.SETNORMALSTYLE, setNormalStyle);
        jQuery(g_thumbs).on(g_thumbs.events.PLACEIMAGE, onPlaceImage);
        g_objWrapper.on(g_temp.eventSizeChange, onSizeChange);
        g_objParentWrapper.on("click", ".ug-tile", onTileClick);
        g_objParentWrapper.on("click", ".ug-tile .ug-button-play", onZoomButtonClick);
        g_objParentWrapper.on("click", ".ug-tile .ug-icon-link", onLinkButtonClick);
    };
    this.destroy = function() {
        g_objParentWrapper.off("click", ".ug-tile");
        g_objParentWrapper.off("click", ".ug-tile .ug-button-play");
        g_objParentWrapper.off("click", ".ug-tile .ug-icon-link");
        jQuery(g_thumbs).off(g_thumbs.events.SETOVERSTYLE);
        jQuery(g_thumbs).off(g_thumbs.events.SETNORMALSTYLE);
        jQuery(g_thumbs).off(g_thumbs.events.PLACEIMAGE);
        g_objWrapper.off(g_temp.eventSizeChange);
        if (g_options.tile_enable_textpanel == true) {
            var objThumbs = g_thumbs.getThumbs();
            jQuery.each(objThumbs, function(index, thumb) {
                var textPanel = getTextPanel(jQuery(thumb));
                if (textPanel) textPanel.destroy();
            });
        }
        g_thumbs.destroy();
    };
    this.init = function(gallery, g_thumbs, customOptions) {
        init(gallery, g_thumbs, customOptions);
    };
    this.setFixedMode = function() {
        g_options.tile_size_by = t.sizeby.GLOBAL_RATIO;
        g_options.tile_visible_before_image = true;
    };
    this.setApproveClickFunction = function(funcApprove) {
        g_temp.funcParentApproveClick = funcApprove;
    };
    this.resizeTile = function(objTile, newWidth, newHeight, resizeMode) {
        if (g_temp.isTextpanelOutside == true) positionElements_textpanel(objTile, "clone", newWidth);
        if (!newWidth) {
            var newWidth = g_options.tile_width;
            var newHeight = g_options.tile_height;
        } else {
            if (!newHeight) {
                var newHeight = t.getTileHeightByWidth(newWidth, objTile);
            }
        }
        g_functions.setElementSize(objTile, newWidth, newHeight);
        switch (resizeMode) {
          default:
          case t.resizemode.FULL:
            t.triggerSizeChangeEvent(objTile, true);
            break;

          case t.resizemode.WRAPPER_ONLY:
            return true;
            break;

          case t.resizemode.VISIBLE_ELEMENTS:
            if (g_temp.funcCustomTileHtml) {
                t.triggerSizeChangeEvent(objTile, true);
                return true;
            }
            positionElements_images(objTile, newWidth, newHeight, true);
            if (g_options.tile_enable_textpanel == true && g_options.tile_textpanel_always_on == true && newWidth) {
                positionElements_textpanel(objTile, "regular", newWidth, newHeight);
            }
            break;
        }
    };
    this.resizeAllTiles = function(newWidth, resizeMode, objTiles) {
        modifyOptionsBeforeRender();
        var newHeight = null;
        if (g_options.tile_size_by == t.sizeby.GLOBAL_RATIO) newHeight = t.getTileHeightByWidth(newWidth);
        if (!objTiles) var objTiles = g_thumbs.getThumbs();
        objTiles.each(function(index, objTile) {
            t.resizeTile(jQuery(objTile), newWidth, newHeight, resizeMode);
        });
    };
    this.triggerSizeChangeEvent = function(objTile, isForce) {
        if (!objTile) return false;
        if (!isForce) var isForce = false;
        g_objWrapper.trigger(g_temp.eventSizeChange, [ objTile, isForce ]);
    };
    this.triggerSizeChangeEventAllTiles = function(isForce) {
        var objThumbs = g_thumbs.getThumbs();
        objThumbs.each(function() {
            var objTile = jQuery(this);
            t.triggerSizeChangeEvent(objTile, isForce);
        });
    };
    this.disableEvents = function() {
        var objThumbs = g_thumbs.getThumbs();
        objThumbs.css("pointer-events", "none");
    };
    this.enableEvents = function() {
        var objThumbs = g_thumbs.getThumbs();
        objThumbs.css("pointer-events", "auto");
    };
    this.setOptions = function(newOptions) {
        g_options = jQuery.extend(g_options, newOptions);
        g_thumbs.setOptions(newOptions);
    };
    this.setTileSizeOptions = function(newTileWidth) {
        if (g_options.tile_size_by !== t.sizeby.GLOBAL_RATIO) throw new Error("setNewTileOptions works with global ration only");
        g_options.tile_width = newTileWidth;
        g_options.tile_height = Math.floor(newTileWidth * g_temp.ratioByHeight);
    };
    this.setCustomFunctions = function(funcCustomHtml, funcPositionElements) {
        g_temp.funcCustomTileHtml = funcCustomHtml;
        g_temp.funcCustomPositionElements = funcPositionElements;
    };
    this.run = function(newOnly) {
        var getMode = g_thumbs.type.GET_THUMBS_ALL;
        if (newOnly === true) getMode = g_thumbs.type.GET_THUMBS_NEW;
        var objThumbs = g_thumbs.getThumbs(getMode);
        if (g_options.tile_size_by == t.sizeby.GLOBAL_RATIO) {
            t.resizeAllTiles(g_options.tile_width, t.resizemode.WRAPPER_ONLY, objThumbs);
        }
        if (g_options.tile_enable_image_effect == true && g_options.tile_image_effect_reverse == false) objThumbs.children(".ug-thumb-image").fadeTo(0, 0);
        g_thumbs.setHtmlProperties(objThumbs);
        if (g_options.tile_visible_before_image == true) {
            objThumbs.children(".ug-thumb-image").fadeTo(0, 0);
            g_thumbs.loadThumbsImages();
        }
    };
    this._____________EXTERNAL_GETTERS____________ = function() {};
    this.getObjThumbs = function() {
        return g_thumbs;
    };
    this.getOptions = function() {
        return g_options;
    };
    this.getTileImage = function(objTile) {
        var objImage = objTile.find("img.ug-thumb-image");
        return objImage;
    };
    this.getItemByTile = function(objTile) {
        return g_thumbs.getItemByThumb(objTile);
    };
    this.getTileHeightByWidth = function(newWidth, objTile) {
        var ratio = getTileRatio(objTile);
        if (ratio === null) return null;
        var height = Math.floor((newWidth - g_temp.tileInnerReduce) * ratio) + g_temp.tileInnerReduce;
        if (objTile && g_temp.isTextpanelOutside == true && g_options.tile_size_by == t.sizeby.IMAGE_RATIO) height += getTextPanelHeight(objTile);
        return height;
    };
    this.getTileImageSize = function(objTile) {
        var objItem = t.getItemByTile(objTile);
        if (!objItem.thumbWidth || !objItem.thumbHeight) throw new Error("Can't get image size - image not inited.");
        var objSize = {
            width: objItem.thumbWidth,
            height: objItem.thumbHeight
        };
        return objSize;
    };
    this.getGlobalTileSize = function() {
        if (g_options.tile_size_by != t.sizeby.GLOBAL_RATIO) throw new Error("The size has to be global ratio");
        var objSize = {
            width: g_options.tile_width,
            height: g_options.tile_height
        };
        return objSize;
    };
}

function UGAviaControl() {
    var g_parent, g_gallery, g_objects, g_objStrip, g_objStripInner, g_options;
    var g_isVertical;
    var g_temp = {
        touchEnabled: false,
        isMouseInsideStrip: false,
        strip_finalPos: 0,
        handle_timeout: "",
        isStripMoving: false,
        isControlEnabled: true
    };
    this.enable = function() {
        g_temp.isControlEnabled = true;
    };
    this.disable = function() {
        g_temp.isControlEnabled = false;
    };
    this.init = function(objParent) {
        g_parent = objParent;
        g_objects = objParent.getObjects();
        g_gallery = g_objects.g_gallery;
        g_objStrip = g_objects.g_objStrip;
        g_objStripInner = g_objects.g_objStripInner;
        g_options = g_objects.g_options;
        g_isVertical = g_objects.isVertical;
        initEvents();
    };
    function getMousePos(event) {
        if (g_isVertical == false) return event.pageX;
        return event.pageY;
    }
    function initEvents(event) {
        jQuery("body").on("touchstart", function(event) {
            if (g_temp.isControlEnabled == false) return true;
            g_temp.touchEnabled = true;
        });
        jQuery("body").mousemove(function(event) {
            if (g_temp.isControlEnabled == false) return true;
            if (g_temp.touchEnabled == true) {
                jQuery("body").off("mousemove");
                return true;
            }
            g_temp.isMouseInsideStrip = g_objStrip.ismouseover();
            var strip_touch_active = g_parent.isTouchMotionActive();
            if (g_temp.isMouseInsideStrip == true && strip_touch_active == false) {
                var mousePos = getMousePos(event);
                moveStripToMousePosition(mousePos);
            } else {
                stopStripMovingLoop();
            }
        });
    }
    this.destroy = function() {
        jQuery("body").off("touchstart");
        jQuery("body").off("mousemove");
    };
    function getInnerPosY(mouseY) {
        var innerOffsetTop = g_options.strip_padding_top;
        var innerOffsetBottom = g_options.strip_padding_bottom;
        var stripHeight = g_objStrip.height();
        var innerHeight = g_objStripInner.height();
        if (stripHeight > innerHeight) return null;
        var stripOffset = g_objStrip.offset();
        var offsetY = stripOffset.top;
        var posy = mouseY - offsetY - innerOffsetTop;
        if (posy < 0) return null;
        var mlineStart = g_options.thumb_height;
        var mlineEnd = stripHeight - g_options.thumb_height;
        var mLineSize = mlineEnd - mlineStart;
        if (posy < mlineStart) posy = mlineStart;
        if (posy > mlineEnd) posy = mlineEnd;
        var ratio = (posy - mlineStart) / mLineSize;
        var innerPosY = (innerHeight - stripHeight) * ratio;
        innerPosY = Math.round(innerPosY) * -1 + innerOffsetTop;
        return innerPosY;
    }
    function getInnerPosX(mouseX) {
        var innerOffsetLeft = g_options.strip_padding_left;
        var innerOffsetRight = g_options.strip_padding_right;
        var stripWidth = g_objStrip.width() - innerOffsetLeft - innerOffsetRight;
        var innerWidth = g_objStripInner.width();
        if (stripWidth > innerWidth) return null;
        var stripOffset = g_objStrip.offset();
        var offsetX = stripOffset.left;
        var posx = mouseX - offsetX - innerOffsetLeft;
        var mlineStart = g_options.thumb_width;
        var mlineEnd = stripWidth - g_options.thumb_width;
        var mLineSize = mlineEnd - mlineStart;
        if (posx < mlineStart) posx = mlineStart;
        if (posx > mlineEnd) posx = mlineEnd;
        var ratio = (posx - mlineStart) / mLineSize;
        var innerPosX = (innerWidth - stripWidth) * ratio;
        innerPosX = Math.round(innerPosX) * -1 + innerOffsetLeft;
        return innerPosX;
    }
    function moveStripStep() {
        if (g_temp.is_strip_moving == false) {
            return false;
        }
        var innerPos = g_parent.getInnerStripPos();
        if (Math.floor(innerPos) == Math.floor(g_temp.strip_finalPos)) {
            stopStripMovingLoop();
        }
        var diff = Math.abs(g_temp.strip_finalPos - innerPos);
        var dpos;
        if (diff < 1) {
            dpos = diff;
        } else {
            dpos = diff / 4;
            if (dpos > 0 && dpos < 1) dpos = 1;
        }
        if (g_temp.strip_finalPos < innerPos) dpos = dpos * -1;
        var newPos = innerPos + dpos;
        g_parent.positionInnerStrip(newPos);
    }
    function startStripMovingLoop() {
        if (g_temp.isStripMoving == true) return false;
        g_temp.isStripMoving = true;
        g_temp.handle_timeout = setInterval(moveStripStep, 10);
    }
    function stopStripMovingLoop() {
        if (g_temp.isStripMoving == false) return false;
        g_temp.isStripMoving = false;
        g_temp.handle_timeout = clearInterval(g_temp.handle_timeout);
    }
    function getInnerPos(mousePos) {
        if (g_isVertical == false) return getInnerPosX(mousePos); else return getInnerPosY(mousePos);
    }
    function moveStripToMousePosition(mousePos) {
        var innerPos = getInnerPos(mousePos);
        if (innerPos === null) return false;
        g_temp.is_strip_moving = true;
        g_temp.strip_finalPos = innerPos;
        startStripMovingLoop();
    }
}

function UGSlider() {
    var t = this, g_objThis = jQuery(t);
    var g_gallery = new UniteGalleryMain(), g_objGallery, g_objWrapper, g_objThumbs;
    var g_objSlider, g_objInner, g_objSlide1, g_objSlide2, g_objSlide3, g_objArrowLeft, g_objArrowRight;
    var g_objTouchSlider, g_objZoomSlider, g_objZoomPanel, g_objButtonPlay = null, g_objButtonFullscreen = null, g_objBullets = null;
    var g_objVideoPlayer = new UGVideoPlayer(), g_optionsPrefix;
    var g_functions = new UGFunctions(), g_objProgress = null, g_objTextPanel = null;
    this.events = {
        ITEM_CHANGED: "item_changed",
        BEFORE_SWITCH_SLIDES: "before_switch",
        BEFORE_RETURN: "before_return",
        AFTER_RETURN: "after_return",
        ZOOM_START: "slider_zoom_start",
        ZOOM_END: "slider_zoom_end",
        ZOOMING: "slider_zooming",
        ZOOM_CHANGE: "slider_zoom_change",
        START_DRAG: "start_drag",
        AFTER_DRAG_CHANGE: "after_drag_change",
        ACTION_START: "action_start",
        ACTION_END: "action_end",
        CLICK: "slider_click",
        TRANSITION_START: "slider_transition_start",
        TRANSITION_END: "slider_transition_end",
        AFTER_PUT_IMAGE: "after_put_image",
        IMAGE_MOUSEENTER: "slider_image_mouseenter",
        IMAGE_MOUSELEAVE: "slider_image_mouseleave",
        CURRENTSLIDE_LOAD_START: "slider_current_loadstart",
        CURRENTSLIDE_LOAD_END: "slider_current_loadend"
    };
    var g_options = {
        slider_scale_mode: "fill",
        slider_scale_mode_media: "fill",
        slider_scale_mode_fullscreen: "down",
        slider_item_padding_top: 0,
        slider_item_padding_bottom: 0,
        slider_item_padding_left: 0,
        slider_item_padding_right: 0,
        slider_background_color: "",
        slider_background_opacity: 1,
        slider_image_padding_top: 0,
        slider_image_padding_bottom: 0,
        slider_image_padding_left: 0,
        slider_image_padding_right: 0,
        slider_image_border: false,
        slider_image_border_width: 10,
        slider_image_border_color: "#ffffff",
        slider_image_border_radius: 0,
        slider_image_border_maxratio: .35,
        slider_image_shadow: false,
        slider_video_constantsize: false,
        slider_video_constantsize_scalemode: "fit",
        slider_video_constantsize_width: 854,
        slider_video_constantsize_height: 480,
        slider_video_padding_top: 0,
        slider_video_padding_bottom: 0,
        slider_video_padding_left: 0,
        slider_video_padding_right: 0,
        slider_video_enable_closebutton: true,
        slider_transition: "slide",
        slider_transition_speed: 300,
        slider_transition_easing: "easeInOutQuad",
        slider_control_swipe: true,
        slider_control_zoom: true,
        slider_zoom_mousewheel: true,
        slider_vertical_scroll_ondrag: false,
        slider_loader_type: 1,
        slider_loader_color: "white",
        slider_enable_links: true,
        slider_links_newpage: false,
        slider_enable_bullets: false,
        slider_bullets_skin: "",
        slider_bullets_space_between: -1,
        slider_bullets_align_hor: "center",
        slider_bullets_align_vert: "bottom",
        slider_bullets_offset_hor: 0,
        slider_bullets_offset_vert: 10,
        slider_enable_arrows: true,
        slider_arrows_skin: "",
        slider_arrow_left_align_hor: "left",
        slider_arrow_left_align_vert: "middle",
        slider_arrow_left_offset_hor: 20,
        slider_arrow_left_offset_vert: 0,
        slider_arrow_right_align_hor: "right",
        slider_arrow_right_align_vert: "middle",
        slider_arrow_right_offset_hor: 20,
        slider_arrow_right_offset_vert: 0,
        slider_enable_progress_indicator: true,
        slider_progress_indicator_type: "pie",
        slider_progress_indicator_align_hor: "right",
        slider_progress_indicator_align_vert: "top",
        slider_progress_indicator_offset_hor: 10,
        slider_progress_indicator_offset_vert: 10,
        slider_enable_play_button: true,
        slider_play_button_skin: "",
        slider_play_button_align_hor: "left",
        slider_play_button_align_vert: "top",
        slider_play_button_offset_hor: 40,
        slider_play_button_offset_vert: 8,
        slider_play_button_mobilehide: false,
        slider_enable_fullscreen_button: true,
        slider_fullscreen_button_skin: "",
        slider_fullscreen_button_align_hor: "left",
        slider_fullscreen_button_align_vert: "top",
        slider_fullscreen_button_offset_hor: 11,
        slider_fullscreen_button_offset_vert: 9,
        slider_fullscreen_button_mobilehide: false,
        slider_enable_zoom_panel: true,
        slider_zoompanel_skin: "",
        slider_zoompanel_align_hor: "left",
        slider_zoompanel_align_vert: "top",
        slider_zoompanel_offset_hor: 12,
        slider_zoompanel_offset_vert: 92,
        slider_zoompanel_mobilehide: false,
        slider_controls_always_on: false,
        slider_controls_appear_ontap: true,
        slider_controls_appear_duration: 300,
        slider_enable_text_panel: true,
        slider_textpanel_always_on: true,
        slider_videoplay_button_type: "square"
    };
    var g_defaultsProgressBar = {
        slider_progress_indicator_align_hor: "left",
        slider_progress_indicator_align_vert: "bottom",
        slider_progress_indicator_offset_hor: 0,
        slider_progress_indicator_offset_vert: 0
    };
    var g_temp = {
        isRunOnce: false,
        isTextPanelSaparateHover: false,
        numPrev: 1,
        numCurrent: 2,
        numNext: 3,
        isControlsVisible: true,
        currentControlsMode: "image"
    };
    function __________GENERAL___________() {}
    function initSlider(objGallery, objOptions, optionsPrefix) {
        g_gallery = objGallery;
        if (optionsPrefix) {
            g_optionsPrefix = optionsPrefix;
            objOptions = g_functions.convertCustomPrefixOptions(objOptions, g_optionsPrefix, "slider");
        }
        g_objGallery = jQuery(objGallery);
        var objects = g_gallery.getObjects();
        g_objWrapper = objects.g_objWrapper;
        g_objThumbs = objects.g_objThumbs;
        if (objOptions.hasOwnProperty("slider_progress_indicator_type")) g_options.slider_progress_indicator_type = objOptions.slider_progress_indicator_type;
        if (g_options.slider_progress_indicator_type == "bar") {
            g_options = jQuery.extend(g_options, g_defaultsProgressBar);
        }
        if (objOptions) t.setOptions(objOptions);
        processOptions();
        if (g_options.slider_enable_bullets == true) {
            g_objBullets = new UGBullets();
            var bulletsOptions = {
                bullets_skin: g_options.slider_bullets_skin,
                bullets_space_between: g_options.slider_bullets_space_between
            };
            g_objBullets.init(g_gallery, bulletsOptions);
        }
        if (g_options.slider_enable_text_panel) {
            g_objTextPanel = new UGTextPanel();
            g_objTextPanel.init(g_gallery, g_options, "slider");
        }
        if (g_options.slider_enable_zoom_panel) {
            g_objZoomPanel = new UGZoomButtonsPanel();
            g_objZoomPanel.init(t, g_options);
        }
        var galleryID = g_gallery.getGalleryID();
        g_objVideoPlayer.init(g_options, false, galleryID);
    }
    function runSlider() {
        if (g_temp.isRunOnce == true) return false;
        g_temp.isRunOnce = true;
        if (g_options.slider_background_color) {
            var bgColor = g_options.slider_background_color;
            if (g_options.slider_background_opacity != 1) bgColor = g_functions.convertHexToRGB(bgColor, g_options.slider_background_opacity);
            g_objSlider.css("background-color", bgColor);
        } else if (g_options.slider_background_opacity != 1) {
            bgColor = g_functions.convertHexToRGB("#000000", g_options.slider_background_opacity);
            g_objSlider.css("background-color", bgColor);
        }
        if (g_options.slider_control_swipe == true) {
            g_objTouchSlider = new UGTouchSliderControl();
            g_objTouchSlider.init(t, g_options);
        }
        if (g_options.slider_control_zoom == true) {
            g_objZoomSlider = new UGZoomSliderControl();
            g_objZoomSlider.init(t, g_options);
        }
        if (g_objTextPanel) g_objTextPanel.run();
        initEvents();
    }
    function processOptions() {
        var galleryOptions = g_gallery.getOptions();
        var globalSkin = galleryOptions.gallery_skin;
        if (g_options.slider_bullets_skin == "") g_options.slider_bullets_skin = globalSkin;
        if (g_options.slider_arrows_skin == "") g_options.slider_arrows_skin = globalSkin;
        if (g_options.slider_zoompanel_skin == "") g_options.slider_zoompanel_skin = globalSkin;
        if (g_options.slider_play_button_skin == "") g_options.slider_play_button_skin = globalSkin;
        if (g_options.slider_fullscreen_button_skin == "") g_options.slider_fullscreen_button_skin = globalSkin;
        g_options.video_enable_closebutton = g_options.slider_video_enable_closebutton;
        if (galleryOptions.gallery_mousewheel_role != "zoom") g_options.slider_zoom_mousewheel = false;
    }
    function getHtmlSlide(loaderClass, numSlide) {
        var classVideoplay = "ug-type-square";
        if (g_options.slider_videoplay_button_type == "round") classVideoplay = "ug-type-round";
        var html = "";
        html += "<div class='ug-slide-wrapper ug-slide" + numSlide + "'>";
        html += "<div class='ug-item-wrapper'></div>";
        html += "<div class='ug-slider-preloader " + loaderClass + "'></div>";
        html += "<div class='ug-button-videoplay " + classVideoplay + "' style='display:none'></div>";
        html += "</div>";
        return html;
    }
    function setHtmlSlider(objParent) {
        if (objParent) g_objWrapper = objParent;
        var loaderClass = getLoaderClass();
        var galleryOptions = g_gallery.getOptions();
        var html = "<div class='ug-slider-wrapper'>";
        html += "<div class='ug-slider-inner'>";
        html += getHtmlSlide(loaderClass, 1);
        html += getHtmlSlide(loaderClass, 2);
        html += getHtmlSlide(loaderClass, 3);
        html += "</div>";
        if (g_options.slider_enable_arrows == true) {
            html += "<div class='ug-slider-control ug-arrow-left ug-skin-" + g_options.slider_arrows_skin + "'></div>";
            html += "<div class='ug-slider-control ug-arrow-right ug-skin-" + g_options.slider_arrows_skin + "'></div>";
        }
        if (g_options.slider_enable_play_button == true) {
            html += "<div class='ug-slider-control ug-button-play ug-skin-" + g_options.slider_play_button_skin + "'></div>";
        }
        if (g_options.slider_enable_fullscreen_button == true) {
            html += "<div class='ug-slider-control ug-button-fullscreen ug-skin-" + g_options.slider_fullscreen_button_skin + "'></div>";
        }
        html += "</div>";
        g_objWrapper.append(html);
        g_objSlider = g_objWrapper.children(".ug-slider-wrapper");
        g_objInner = g_objSlider.children(".ug-slider-inner");
        g_objSlide1 = g_objInner.children(".ug-slide1");
        g_objSlide2 = g_objInner.children(".ug-slide2");
        g_objSlide3 = g_objInner.children(".ug-slide3");
        g_objSlide1.data("slidenum", 1);
        g_objSlide2.data("slidenum", 2);
        g_objSlide3.data("slidenum", 3);
        if (g_objBullets) g_objBullets.appendHTML(g_objSlider);
        if (g_options.slider_enable_arrows == true) {
            g_objArrowLeft = g_objSlider.children(".ug-arrow-left");
            g_objArrowRight = g_objSlider.children(".ug-arrow-right");
        }
        if (g_options.slider_enable_play_button == true) {
            g_objButtonPlay = g_objSlider.children(".ug-button-play");
        }
        if (g_options.slider_enable_fullscreen_button == true) {
            g_objButtonFullscreen = g_objSlider.children(".ug-button-fullscreen");
        }
        if (g_options.slider_enable_progress_indicator == true) {
            g_objProgress = g_functions.initProgressIndicator(g_options.slider_progress_indicator_type, g_options, g_objSlider);
            var finalType = g_objProgress.getType();
            if (finalType == "bar" && g_options.slider_progress_indicator_type == "pie") {
                g_options.slider_progress_indicator_type = "bar";
                g_options = jQuery.extend(g_options, g_defaultsProgressBar);
            }
            g_gallery.setProgressIndicator(g_objProgress);
        }
        if (g_options.slider_enable_text_panel == true) {
            g_objTextPanel.appendHTML(g_objSlider);
            if (g_options.slider_textpanel_always_on == false) {
                var panelElement = g_objTextPanel.getElement();
                panelElement.hide().data("isHidden", true);
                g_temp.isTextPanelSaparateHover = true;
            }
        }
        if (g_options.slider_enable_zoom_panel == true) {
            g_objZoomPanel.appendHTML(g_objSlider);
        }
        g_objVideoPlayer.setHtml(g_objInner);
    }
    function positionSlideElements(objSlide) {
        var objPreloader = getSlidePreloader(objSlide);
        g_functions.placeElementInParentCenter(objPreloader);
        var objVideoPlayButton = getSlideVideoPlayButton(objSlide);
        g_functions.placeElementInParentCenter(objVideoPlayButton);
    }
    function positionElements() {
        if (g_objBullets) {
            objBullets = g_objBullets.getElement();
            g_functions.placeElement(objBullets, g_options.slider_bullets_align_hor, g_options.slider_bullets_align_vert, g_options.slider_bullets_offset_hor, g_options.slider_bullets_offset_vert);
            g_functions.placeElement(objBullets, g_options.slider_bullets_align_hor, g_options.slider_bullets_align_vert, g_options.slider_bullets_offset_hor, g_options.slider_bullets_offset_vert);
        }
        if (g_options.slider_enable_arrows == true) {
            g_functions.placeElement(g_objArrowLeft, g_options.slider_arrow_left_align_hor, g_options.slider_arrow_left_align_vert, g_options.slider_arrow_left_offset_hor, g_options.slider_arrow_left_offset_vert);
            g_functions.placeElement(g_objArrowRight, g_options.slider_arrow_right_align_hor, g_options.slider_arrow_left_align_vert, g_options.slider_arrow_right_offset_hor, g_options.slider_arrow_right_offset_vert);
        }
        if (g_options.slider_controls_always_on == false) hideControls(true);
        if (g_objProgress) {
            var objProgressElement = g_objProgress.getElement();
            if (g_options.slider_progress_indicator_type == "bar") {
                var sliderWidth = g_objSlider.width();
                g_objProgress.setSize(sliderWidth);
                g_functions.placeElement(objProgressElement, "left", g_options.slider_progress_indicator_align_vert, 0, g_options.slider_progress_indicator_offset_vert);
            } else {
                g_functions.placeElement(objProgressElement, g_options.slider_progress_indicator_align_hor, g_options.slider_progress_indicator_align_vert, g_options.slider_progress_indicator_offset_hor, g_options.slider_progress_indicator_offset_vert);
            }
        }
        if (g_objTextPanel) g_objTextPanel.positionPanel();
        placeControlsElements();
        positionSlideElements(g_objSlide1);
        positionSlideElements(g_objSlide2);
        positionSlideElements(g_objSlide3);
        checkMobileModify();
    }
    function placeControlsElements() {
        if (g_objButtonPlay) g_functions.placeElement(g_objButtonPlay, g_options.slider_play_button_align_hor, g_options.slider_play_button_align_vert, g_options.slider_play_button_offset_hor, g_options.slider_play_button_offset_vert);
        if (g_objButtonFullscreen) g_functions.placeElement(g_objButtonFullscreen, g_options.slider_fullscreen_button_align_hor, g_options.slider_fullscreen_button_align_vert, g_options.slider_fullscreen_button_offset_hor, g_options.slider_fullscreen_button_offset_vert);
        if (g_objZoomPanel) {
            var zoomPanelElement = g_objZoomPanel.getElement();
            g_functions.placeElement(zoomPanelElement, g_options.slider_zoompanel_align_hor, g_options.slider_zoompanel_align_vert, g_options.slider_zoompanel_offset_hor, g_options.slider_zoompanel_offset_vert);
        }
    }
    function positionSlides() {
        var slides = t.getSlidesReference();
        var posX = 0, posY = 0, innerWidth;
        var posXPrev = 0, posXCurrent = 0, posXNext, nextHasItem, prevHasItem;
        nextHasItem = t.isSlideHasItem(slides.objNextSlide);
        prevHasItem = t.isSlideHasItem(slides.objPrevSlide);
        if (prevHasItem) {
            posXCurrent = slides.objPrevSlide.outerWidth();
            slides.objPrevSlide.css("z-index", 1);
        } else slides.objPrevSlide.hide();
        posXNext = posXCurrent + slides.objCurrentSlide.outerWidth();
        innerWidth = posXNext;
        if (nextHasItem) {
            innerWidth = posXNext + slides.objNextSlide.outerWidth();
            slides.objPrevSlide.css("z-index", 2);
        } else slides.objNextSlide.hide();
        slides.objCurrentSlide.css("z-index", 3);
        g_functions.placeElement(slides.objCurrentSlide, posXCurrent, posY);
        g_objInner.css({
            left: -posXCurrent + "px",
            width: innerWidth + "px"
        });
        if (prevHasItem) {
            g_functions.placeElement(slides.objPrevSlide, posXPrev, posY);
            g_functions.showElement(slides.objPrevSlide);
        }
        if (nextHasItem) {
            g_functions.showElement(slides.objNextSlide);
            g_functions.placeElement(slides.objNextSlide, posXNext, posY);
        }
    }
    function resizeSlideItem(objSlide) {
        var index = objSlide.data("index");
        if (index === undefined || index == null) return false;
        var objItem = g_gallery.getItem(index);
        if (!objItem) return false;
        setItemToSlide(objSlide, objItem);
    }
    function showPreloader(objPreloader) {
        objPreloader.stop(true).show(100);
    }
    function hidePreloader(objPreloader) {
        objPreloader.stop(true).hide(100);
    }
    function getImageBorderWidth(objImage, imageData) {
        var borderWidth = g_options.slider_image_border_width;
        if (borderWidth <= 10) return borderWidth;
        var imageSize = g_functions.getElementSize(objImage);
        var imageWidth = imageSize.width;
        var imageHeight = imageSize.height;
        if (imageData) {
            if (imageData.hasOwnProperty("imageWidth")) imageWidth = imageData.imageWidth;
            if (imageData.hasOwnProperty("imageHeight")) imageHeight = imageData.imageHeight;
        }
        if (imageWidth <= 0) return borderWidth;
        var totalSize = imageWidth < imageHeight ? imageWidth : imageHeight;
        var borderSize = borderWidth * 2;
        var borderRatio = borderSize / totalSize;
        if (borderRatio < g_options.slider_image_border_maxratio) return borderWidth;
        var borderWidth = totalSize * g_options.slider_image_border_maxratio / 2;
        borderWidth = Math.round(borderWidth);
        return borderWidth;
    }
    function setImageDesign(objImage, slideType, imageData) {
        var css = {};
        if (g_options.slider_image_border == true) {
            css["border-style"] = "solid";
            var borderWidth = getImageBorderWidth(objImage, imageData);
            css["border-width"] = borderWidth + "px";
            css["border-color"] = g_options.slider_image_border_color;
            css["border-radius"] = g_options.slider_image_border_radius;
        }
        if (slideType != "image" && g_options.slider_video_constantsize == true) css["background-color"] = "#000000";
        if (g_options.slider_image_shadow == true) {
            css["box-shadow"] = "3px 3px 10px 0px #353535";
        }
        objImage.css(css);
    }
    function scaleImageConstantSize(objImage, objItem) {
        var constantWidth = g_options.slider_video_constantsize_width;
        var constantHeight = g_options.slider_video_constantsize_height;
        var scaleMode = g_options.slider_video_constantsize_scalemode;
        var objSize = g_functions.scaleImageExactSizeInParent(objImage, objItem.imageWidth, objItem.imageHeight, constantWidth, constantHeight, scaleMode);
        return objSize;
    }
    function setImageToSlide(objSlide, objItem, isForce) {
        var objItemWrapper = objSlide.children(".ug-item-wrapper");
        var objPreloader = getSlidePreloader(objSlide);
        if (typeof objItem.urlImage == "undefined" || objItem.urlImage == "") throw new Error("The slide don't have big image defined ( data-image='imageurl' ). Please check gallery items.", "showbig");
        var urlImage = objItem.urlImage;
        var currentImage = objSlide.data("urlImage");
        objSlide.data("urlImage", urlImage);
        var scaleMode = t.getScaleMode(objSlide);
        var slideType = t.getSlideType(objSlide);
        objPadding = t.getObjImagePadding();
        if (currentImage == urlImage && isForce !== true) {
            var objImage = objItemWrapper.children("img");
            if (objItem.imageWidth == 0 || objItem.imageHeight == 0) {
                g_gallery.checkFillImageSize(objImage, objItem);
            }
            var objImageData = {};
            if (slideType != "image" && g_options.slider_video_constantsize == true) {
                objImageData = scaleImageConstantSize(objImage, objItem);
            } else {
                objImageData = g_functions.scaleImageFitParent(objImage, objItem.imageWidth, objItem.imageHeight, scaleMode, objPadding);
            }
            setImageDesign(objImage, slideType, objImageData);
            g_objThis.trigger(t.events.AFTER_PUT_IMAGE, objSlide);
        } else {
            objImage = g_functions.placeImageInsideParent(urlImage, objItemWrapper, objItem.imageWidth, objItem.imageHeight, scaleMode, objPadding);
            if (objItem.isBigImageLoaded == true) {
                objImage.fadeTo(0, 1);
                hidePreloader(objPreloader);
                if (slideType != "image" && g_options.slider_video_constantsize == true) var objImageData = scaleImageConstantSize(objImage, objItem); else var objImageData = g_functions.getImageInsideParentData(objItemWrapper, objItem.imageWidth, objItem.imageHeight, scaleMode, objPadding);
                objImage.css("width", objImageData.imageWidth + "px");
                setImageDesign(objImage, slideType, objImageData);
                g_objThis.trigger(t.events.AFTER_PUT_IMAGE, objSlide);
            } else {
                objImage.fadeTo(0, 0);
                showPreloader(objPreloader);
                objSlide.data("isLoading", true);
                if (t.isSlideCurrent(objSlide)) g_objThis.trigger(t.events.CURRENTSLIDE_LOAD_START);
                objImage.data("itemIndex", objItem.index);
                objImage.on("load", function() {
                    var objImage = jQuery(this);
                    var itemIndex = objImage.data("itemIndex");
                    objImage.fadeTo(0, 1);
                    var objSlide = objImage.parent().parent();
                    var slideType = t.getSlideType(objSlide);
                    var objPreloader = getSlidePreloader(objSlide);
                    var objPadding = t.getObjImagePadding();
                    var scaleMode = t.getScaleMode(objSlide);
                    hidePreloader(objPreloader);
                    objSlide.data("isLoading", false);
                    if (t.isSlideCurrent(objSlide)) g_objThis.trigger(t.events.CURRENTSLIDE_LOAD_END);
                    g_gallery.onItemBigImageLoaded(null, objImage);
                    var objItem = g_gallery.getItem(itemIndex);
                    var objImageData = {};
                    if (slideType != "image" && g_options.slider_video_constantsize == true) scaleImageConstantSize(objImage, objItem); else {
                        objImageData = g_functions.scaleImageFitParent(objImage, objItem.imageWidth, objItem.imageHeight, scaleMode, objPadding);
                    }
                    objImage.fadeTo(0, 1);
                    setImageDesign(objImage, slideType, objImageData);
                    g_objThis.trigger(t.events.AFTER_PUT_IMAGE, objSlide);
                });
            }
        }
    }
    function setItemToSlide(objSlide, objItem) {
        try {
            var objItemWrapper = objSlide.children(".ug-item-wrapper");
            if (objItem == null) {
                objItemWrapper.html("");
                objSlide.removeData("index");
                objSlide.removeData("type");
                objSlide.removeData("urlImage");
                return false;
            }
            var currentIndex = objSlide.data("index");
            objSlide.data("index", objItem.index);
            objSlide.data("type", objItem.type);
            if (g_options.slider_enable_links == true && objItem.type == "image") {
                if (objItem.link) objSlide.addClass("ug-slide-clickable"); else objSlide.removeClass("ug-slide-clickable");
            }
            setImageToSlide(objSlide, objItem);
            var objVideoPlayButton = getSlideVideoPlayButton(objSlide);
            switch (objItem.type) {
              case "image":
                objVideoPlayButton.hide();
                break;

              default:
                objVideoPlayButton.show();
                break;
            }
        } catch (error) {
            if (typeof error.fileName != "undefined" && error.fileName == "showbig") g_gallery.showErrorMessageReplaceGallery(error.message);
            objItemWrapper.html("");
            throw new Error(error);
            return true;
        }
    }
    function hideTextPanel() {
        if (!g_objTextPanel) return false;
        if (isTextPanelHidden() == true) return false;
        var panelElement = g_objTextPanel.getElement();
        var animationTime = 0;
        if (g_temp.isTextPanelSaparateHover == true || g_options.slider_textpanel_always_on == true) {
            animationTime = g_options.slider_controls_appear_duration;
        }
        panelElement.stop().fadeTo(animationTime, 0);
        panelElement.data("isHidden", true);
    }
    function showTextPanel() {
        if (!g_objTextPanel) return false;
        if (isTextPanelHidden() == false) return false;
        var panelElement = g_objTextPanel.getElement();
        var animationTime = 0;
        if (g_temp.isTextPanelSaparateHover == true || g_options.slider_textpanel_always_on == true) {
            panelElement.show();
            g_objTextPanel.positionElements();
            animationTime = g_options.slider_controls_appear_duration;
        }
        panelElement.stop().show().fadeTo(animationTime, 1);
        panelElement.data("isHidden", false);
    }
    function isTextPanelHidden() {
        var panelElement = g_objTextPanel.getElement();
        var isHidden = panelElement.data("isHidden");
        if (isHidden === false) return false;
        return true;
    }
    function validateSlideType(type, objSlide) {
        if (objSlide == undefined) var objSlide = t.getCurrentSlide();
        var slideType = t.getSlideType(objSlide);
        if (slideType != type) {
            throw new Error("Wrong slide type: " + slideType + ", should be: " + type);
            return false;
        }
        return true;
    }
    function __________VIDEO_PLAYER_______() {}
    function setVideoPlayerPosition() {
        var objCurrentSlide = t.getCurrentSlide();
        var objImage = t.getSlideImage(objCurrentSlide);
        var slideSize = g_functions.getElementSize(objCurrentSlide);
        var left = slideSize.left;
        var top = slideSize.top;
        if (g_options.slider_video_constantsize == true) {
            var imageSize = g_functions.getElementSize(objImage);
            left += imageSize.left;
            top += imageSize.top;
        } else {
            left += g_options.slider_video_padding_left;
            top += g_options.slider_video_padding_top;
        }
        g_objVideoPlayer.setPosition(left, top);
    }
    function setVideoPlayerConstantSize() {
        var videoWidth = g_options.slider_video_constantsize_width;
        var videoHeight = g_options.slider_video_constantsize_height;
        g_objVideoPlayer.setSize(videoWidth, videoHeight);
        var videoElement = g_objVideoPlayer.getObject();
        setImageDesign(videoElement, "video");
    }
    function __________TRANSITION_______() {}
    function doTransition(direction, objItem, forceTransition) {
        g_objThis.trigger(t.events.TRANSITION_START);
        var transition = g_options.slider_transition;
        if (forceTransition) transition = forceTransition;
        t.stopSlideAction(null, true);
        switch (transition) {
          default:
          case "fade":
            transitionFade(objItem);
            break;

          case "slide":
            transitionSlide(direction, objItem);
            break;

          case "lightbox_open":
            transitionFade(objItem, false, true);
            break;
        }
    }
    this.switchSlideNums = function(direction) {
        g_objThis.trigger(t.events.BEFORE_SWITCH_SLIDES);
        switch (direction) {
          case "left":
            var currentNum = g_temp.numCurrent;
            g_temp.numCurrent = g_temp.numNext;
            g_temp.numNext = g_temp.numPrev;
            g_temp.numPrev = currentNum;
            break;

          case "right":
            var currentNum = g_temp.numCurrent;
            g_temp.numCurrent = g_temp.numPrev;
            g_temp.numPrev = g_temp.numNext;
            g_temp.numNext = currentNum;
            break;

          default:
            throw new Error("wrong direction: " + direction);
            break;
        }
        g_objThis.trigger(t.events.ITEM_CHANGED);
    };
    function transitionSlide(direction, objItem) {
        var animating = t.isAnimating();
        if (animating == true) {
            g_temp.itemWaiting = objItem;
            return true;
        }
        if (g_temp.itemWaiting != null) g_temp.itemWaiting = null;
        var slides = t.getSlidesReference();
        switch (direction) {
          case "right":
            setItemToSlide(slides.objPrevSlide, objItem);
            positionSlides();
            var posPrev = g_functions.getElementSize(slides.objPrevSlide);
            var destX = -posPrev.left;
            t.switchSlideNums("right");
            break;

          case "left":
            setItemToSlide(slides.objNextSlide, objItem);
            positionSlides();
            var posNext = g_functions.getElementSize(slides.objNextSlide);
            var destX = -posNext.left;
            t.switchSlideNums("left");
            break;

          default:
            throw new Error("wrong direction: " + direction);
            break;
        }
        var transSpeed = g_options.slider_transition_speed;
        var transEasing = g_options.slider_transition_easing;
        var animateParams = {
            duration: transSpeed,
            easing: transEasing,
            queue: false,
            always: function() {
                t.stopSlideAction();
                g_objVideoPlayer.hide();
                if (g_temp.itemWaiting != null) {
                    var direction = getSlideDirection(g_temp.itemWaiting);
                    transitionSlide(direction, g_temp.itemWaiting);
                } else {
                    t.placeNabourItems();
                    g_objThis.trigger(t.events.TRANSITION_END);
                }
            }
        };
        g_objInner.animate({
            left: destX + "px"
        }, animateParams);
    }
    function animateOpacity(objItem, opacity, completeFunction) {
        if (completeFunction) objItem.fadeTo(g_options.slider_transition_speed, opacity, completeFunction); else objItem.fadeTo(g_options.slider_transition_speed, opacity);
    }
    function transitionFade(objItem, noAnimation, noHidePlayer) {
        if (!noAnimation) var noAnimation = false;
        var slides = t.getSlidesReference();
        setItemToSlide(slides.objNextSlide, objItem);
        var objCurrentPos = g_functions.getElementSize(slides.objCurrentSlide);
        g_functions.placeElement(slides.objNextSlide, objCurrentPos.left, objCurrentPos.top);
        var currentNum = g_temp.numCurrent;
        g_temp.numCurrent = g_temp.numNext;
        g_temp.numNext = currentNum;
        g_objThis.trigger(t.events.ITEM_CHANGED);
        slides.objNextSlide.stop(true);
        slides.objCurrentSlide.stop(true);
        if (noAnimation == true) {
            slides.objCurrentSlide.fadeTo(0, 0);
            slides.objNextSlide.fadeTo(0, 1);
            t.placeNabourItems();
            g_objThis.trigger(t.events.TRANSITION_END);
            if (noHidePlayer !== true) g_objVideoPlayer.hide();
        } else {
            slides.objNextSlide.fadeTo(0, 0);
            animateOpacity(slides.objCurrentSlide, 0, function() {
                t.placeNabourItems();
                g_objThis.trigger(t.events.TRANSITION_END);
                if (noHidePlayer !== true) g_objVideoPlayer.hide();
            });
            if (g_objVideoPlayer.isVisible() == true) {
                var videoElement = g_objVideoPlayer.getObject();
                animateOpacity(videoElement, 0);
            }
            animateOpacity(slides.objNextSlide, 1);
        }
    }
    function __________CONTROLS_OBJECT_______() {}
    function modifyForMobile() {
        if (g_options.slider_fullscreen_button_mobilehide == true && g_objButtonFullscreen) g_objButtonFullscreen.hide();
        if (g_options.slider_play_button_mobilehide == true && g_objButtonPlay) g_objButtonPlay.hide();
        if (g_options.slider_zoompanel_mobilehide == true && g_objZoomPanel) g_objZoomPanel.getElement().hide();
    }
    function modifyForDesctop() {
        if (g_options.slider_fullscreen_button_mobilehide == true && g_objButtonFullscreen) g_objButtonFullscreen.show();
        if (g_options.slider_play_button_mobilehide == true && g_objButtonPlay) g_objButtonPlay.show();
        if (g_options.slider_zoompanel_mobilehide == true && g_objZoomPanel) g_objZoomPanel.getElement().show();
    }
    function checkMobileModify() {
        var isMobile = g_gallery.isMobileMode();
        if (isMobile) modifyForMobile(); else modifyForDesctop();
    }
    function getControlsObjects() {
        var objControl = g_objSlider.children(".ug-slider-control");
        return objControl;
    }
    function hideControls(noAnimation) {
        if (g_functions.isTimePassed("sliderControlsToggle") == false) return false;
        if (g_temp.isControlsVisible == false) return false;
        if (!noAnimation) var noAnimation = false;
        var objControls = getControlsObjects();
        if (noAnimation === true) objControls.stop().fadeTo(0, 0).hide(); else {
            objControls.stop().fadeTo(g_options.slider_controls_appear_duration, 0, function() {
                objControls.hide();
            });
        }
        g_temp.isControlsVisible = false;
    }
    function checkAndShowControls(noAnimation) {
        if (g_options.slider_controls_always_on == true) showControls(noAnimation);
    }
    function showControls(noAnimation) {
        if (g_functions.isTimePassed("sliderControlsToggle") == false) return false;
        if (g_temp.isControlsVisible == true) return true;
        if (!noAnimation) var noAnimation = false;
        var objControls = getControlsObjects();
        if (noAnimation === true) objControls.stop().show(); else {
            objControls.stop().show().fadeTo(0, 0);
            objControls.fadeTo(g_options.slider_controls_appear_duration, 1);
        }
        g_temp.isControlsVisible = true;
    }
    function toggleControls() {
        if (g_temp.isControlsVisible == false) showControls(); else hideControls();
    }
    function setControlsMode(mode) {
        if (mode == g_temp.currentControlsMode) return false;
        switch (mode) {
          case "image":
            if (g_objZoomPanel) g_objZoomPanel.getElement().show();
            break;

          case "video":
            if (g_objZoomPanel) g_objZoomPanel.getElement().hide();
            break;

          default:
            throw new Error("wrong controld mode: " + mode);
            break;
        }
        g_temp.currentControlsMode = mode;
    }
    function __________EVENTS___________() {}
    function onItemChange(data, arg_objItem, role) {
        var objItem = g_gallery.getSelectedItem();
        t.setItem(objItem, false, role);
        var itemIndex = objItem.index;
        if (g_objBullets) g_objBullets.setActive(itemIndex);
        if (g_objTextPanel) {
            if (g_temp.isTextPanelSaparateHover == false) showTextPanel();
        }
        if (objItem.type == "image") {
            setControlsMode("image");
        } else {
            setControlsMode("video");
        }
    }
    function onBulletClick(event, bulletIndex) {
        g_gallery.selectItem(bulletIndex);
    }
    function onClick(event) {
        if (g_objTouchSlider && g_objTouchSlider.isTapEventOccured(event) == false) return true;
        g_objThis.trigger(t.events.CLICK, event);
    }
    function onActualClick() {
        var currentSlide = t.getCurrentSlide();
        var isClickable = currentSlide.hasClass("ug-slide-clickable");
        var objItem = t.getCurrentItem();
        if (isClickable) {
            if (g_options.slider_links_newpage == false) {
                location.href = objItem.link;
            } else {
                window.open(objItem.link, "_blank");
            }
            return true;
        }
        if (g_options.slider_controls_always_on == false && g_options.slider_controls_appear_ontap == true && t.isCurrentSlideType("image") == true) {
            toggleControls();
            if (g_objTextPanel && g_options.slider_textpanel_always_on == true && t.isCurrentSlideType("image") && t.isCurrentSlideImageFit()) showTextPanel();
        }
    }
    function onZoomChange(event) {
        if (g_objTextPanel && t.isCurrentSlideType("image") && t.isCurrentSlideImageFit() == false) hideTextPanel();
    }
    function onMouseEnter() {
        showControls();
    }
    function onMouseLeave() {
        hideControls();
    }
    function objVideoPlayClick(objButton) {
        var objSlide = objButton.parent();
        t.startSlideAction(objSlide);
    }
    function onVideoPlayerShow() {
        if (g_gallery.isPlayMode()) {
            g_gallery.pausePlaying();
        }
        g_objThis.trigger(t.events.ACTION_START);
    }
    function onVideoPlayerHide() {
        if (g_gallery.isPlayMode()) {
            g_gallery.continuePlaying();
        }
        g_objThis.trigger(t.events.ACTION_END);
    }
    function onItemImageUpdate(event, index, urlImage) {
        if (g_objSlide1.data("index") == index) {
            objItem = g_gallery.getItem(index);
            setImageToSlide(g_objSlide1, objItem, true);
        }
        if (g_objSlide2.data("index") == index) {
            objItem = g_gallery.getItem(index);
            setImageToSlide(g_objSlide2, objItem, true);
        }
        if (g_objSlide3.data("index") == index) {
            objItem = g_gallery.getItem(index);
            setImageToSlide(g_objSlide3, objItem, true);
        }
    }
    function onSlideImageLoaded(data, objSlide) {
        objSlide = jQuery(objSlide);
        var objImage = t.getSlideImage(objSlide);
        var objButtonVideoPlay = getSlideVideoPlayButton(objSlide);
        var objSize = g_functions.getElementSize(objImage);
        g_functions.placeElement(objButtonVideoPlay, "center", "middle", objSize.left, objSize.top, objImage);
    }
    function initSlideEvents(objSlide) {
        var objVideoPlayButton = getSlideVideoPlayButton(objSlide);
        g_functions.addClassOnHover(objVideoPlayButton);
        g_functions.setButtonOnClick(objVideoPlayButton, objVideoPlayClick);
    }
    function initEvents() {
        g_objGallery.on(g_gallery.events.ITEM_IMAGE_UPDATED, onItemImageUpdate);
        g_objGallery.on(g_gallery.events.ITEM_CHANGE, onItemChange);
        if (g_objBullets) jQuery(g_objBullets).on(g_objBullets.events.BULLET_CLICK, onBulletClick);
        if (g_options.slider_enable_arrows == true) {
            g_functions.addClassOnHover(g_objArrowRight, "ug-arrow-hover");
            g_functions.addClassOnHover(g_objArrowLeft, "ug-arrow-hover");
            g_gallery.setNextButton(g_objArrowRight);
            g_gallery.setPrevButton(g_objArrowLeft);
        }
        if (g_options.slider_controls_always_on == false) {
            g_objSlider.hover(onMouseEnter, onMouseLeave);
        }
        g_objSlider.on("touchend click", onClick);
        g_objThis.on(t.events.CLICK, onActualClick);
        if (g_objTextPanel && g_temp.isTextPanelSaparateHover == true) {
            g_objSlider.hover(showTextPanel, hideTextPanel);
        }
        if (g_objButtonPlay) {
            g_functions.addClassOnHover(g_objButtonPlay, "ug-button-hover");
            g_gallery.setPlayButton(g_objButtonPlay);
        }
        if (g_objButtonFullscreen) {
            g_functions.addClassOnHover(g_objButtonFullscreen, "ug-button-hover");
            g_gallery.setFullScreenToggleButton(g_objButtonFullscreen);
        }
        if (g_objZoomSlider) {
            g_objThis.on(t.events.ZOOM_CHANGE, onZoomChange);
        }
        if (g_objZoomPanel) g_objZoomPanel.initEvents();
        g_objVideoPlayer.initEvents();
        jQuery(g_objVideoPlayer).on(g_objVideoPlayer.events.SHOW, onVideoPlayerShow);
        jQuery(g_objVideoPlayer).on(g_objVideoPlayer.events.HIDE, onVideoPlayerHide);
        initSlideEvents(g_objSlide1);
        initSlideEvents(g_objSlide2);
        initSlideEvents(g_objSlide3);
        g_objThis.on(t.events.AFTER_PUT_IMAGE, onSlideImageLoaded);
        g_objSlider.on("mouseenter", ".ug-item-wrapper img", function(event) {
            g_objThis.trigger(t.events.IMAGE_MOUSEENTER);
        });
        g_objSlider.on("mouseleave", ".ug-item-wrapper img", function(event) {
            var isMouseOver = t.isMouseInsideSlideImage(event);
            if (isMouseOver == false) g_objThis.trigger(t.events.IMAGE_MOUSELEAVE);
        });
    }
    this.destroy = function() {
        g_objThis.off(t.events.AFTER_PUT_IMAGE);
        g_objGallery.off(g_gallery.events.ITEM_IMAGE_UPDATED);
        g_objGallery.off(g_gallery.events.ITEM_CHANGE);
        if (g_objBullets) jQuery(g_objBullets).on(g_objBullets.events.BULLET_CLICK);
        g_objSlider.off("mouseenter");
        g_objSlider.off("mouseleave");
        g_objSlider.off("touchend");
        g_objSlider.off("click");
        g_objThis.off(t.events.CLICK);
        if (g_objZoomSlider) g_objThis.off(t.events.ZOOM_CHANGE);
        g_objThis.off(t.events.BEFORE_SWITCH_SLIDES);
        jQuery(g_objVideoPlayer).off(g_objVideoPlayer.events.SHOW);
        jQuery(g_objVideoPlayer).off(g_objVideoPlayer.events.HIDE);
        g_objVideoPlayer.destroy();
        g_objSlider.off("mouseenter", ".ug-item-wrapper img");
        g_objSlider.off("mouseleave", ".ug-item-wrapper img");
    };
    function __________GETTERS___________() {}
    function getLoaderClass() {
        var loaderClass;
        switch (g_options.slider_loader_type) {
          default:
          case 1:
            loaderClass = "ug-loader1";
            break;

          case 2:
            loaderClass = "ug-loader2";
            break;

          case 3:
            loaderClass = "ug-loader3";
            break;

          case 4:
            loaderClass = "ug-loader4";
            break;

          case 5:
            loaderClass = "ug-loader5";
            break;

          case 6:
            loaderClass = "ug-loader6";
            break;

          case 7:
            loaderClass = "ug-loader7";
            break;

          case 8:
            loaderClass = "ug-loader8";
            break;

          case 9:
            loaderClass = "ug-loader9";
            break;
        }
        if (g_options.slider_loader_color == "black") loaderClass += " ug-loader-black";
        return loaderClass;
    }
    function getSlideByNum(num) {
        switch (num) {
          case 1:
            return g_objSlide1;
            break;

          case 2:
            return g_objSlide2;
            break;

          case 3:
            return g_objSlide3;
            break;

          default:
            throw new Error("wrong num: " + num);
            break;
        }
    }
    function getSlideDirection(objItem) {
        var slides = t.getSlidesReference();
        var currentIndex = slides.objCurrentSlide.data("index");
        var nextIndex = objItem.index;
        var direction = "left";
        if (currentIndex > nextIndex) direction = "right";
        return direction;
    }
    function getSlidePreloader(objSlide) {
        if (!objSlide) var objSlide = t.getCurrentSlide();
        var objPreloader = objSlide.children(".ug-slider-preloader");
        return objPreloader;
    }
    function getSlideVideoPlayButton(objSlide) {
        var objButton = objSlide.children(".ug-button-videoplay");
        return objButton;
    }
    function getSlideItem(objSlide) {
        if (!objSlide) var objSlide = t.getCurrentSlide();
        var index = objSlide.data("index");
        if (index == undefined) return null;
        var objItem = g_gallery.getItem(index);
        return objItem;
    }
    function getNumSlide(objSlide) {
        var numSlide = objSlide.data("slidenum");
        return numSlide;
    }
    this.________EXTERNAL_GENERAL___________ = function() {};
    this.init = function(objGallery, objOptions, optionsPrefix) {
        initSlider(objGallery, objOptions, optionsPrefix);
    };
    this.getSlideImage = function(objSlide) {
        if (!objSlide) var objSlide = t.getCurrentSlide();
        var objImage = objSlide.find(".ug-item-wrapper img");
        return objImage;
    };
    this.setHtml = function(objParent) {
        setHtmlSlider(objParent);
    };
    this.run = function() {
        runSlider();
    };
    this.isInnerInPlace = function() {
        var slides = t.getSlidesReference();
        var posCurrent = g_functions.getElementSize(slides.objCurrentSlide);
        var inPlaceX = -posCurrent.left;
        var objInnerSize = g_functions.getElementSize(g_objInner);
        if (inPlaceX == objInnerSize.left) return true; else return false;
    };
    this.isAnimating = function() {
        var isAnimated = g_objInner.is(":animated");
        return isAnimated;
    };
    this.isSlideCurrent = function(objSlide) {
        var numSlide = objSlide.data("slidenum");
        if (g_temp.numCurrent == numSlide) return true;
        return false;
    };
    this.isSlideHasItem = function(objSlide) {
        var index = objSlide.data("index");
        if (index === undefined || index === null) return false;
        return true;
    };
    this.getObjImagePadding = function() {
        var objPadding = {
            padding_top: g_options.slider_image_padding_top,
            padding_bottom: g_options.slider_image_padding_bottom,
            padding_left: g_options.slider_image_padding_left,
            padding_right: g_options.slider_image_padding_right
        };
        return objPadding;
    };
    this.getSlidesReference = function() {
        var obj = {
            objPrevSlide: getSlideByNum(g_temp.numPrev),
            objNextSlide: getSlideByNum(g_temp.numNext),
            objCurrentSlide: getSlideByNum(g_temp.numCurrent)
        };
        return obj;
    };
    this.getCurrentSlide = function() {
        var slides = t.getSlidesReference();
        return slides.objCurrentSlide;
    };
    this.getCurrentItemIndex = function() {
        var slides = t.getSlidesReference();
        var currentIndex = slides.objCurrentSlide.data("index");
        if (currentIndex === null || currentIndex === undefined) currentIndex = -1;
        return currentIndex;
    };
    this.getCurrentItem = function() {
        var currentIndex = t.getCurrentItemIndex();
        if (currentIndex == -1) return null;
        var objItem = g_gallery.getItem(currentIndex);
        return objItem;
    };
    this.getSlideType = function(objSlide) {
        if (objSlide == undefined) objSlide = t.getCurrentSlide();
        var type = objSlide.data("type");
        return type;
    };
    this.isMouseInsideSlideImage = function(event) {
        var objImage = t.getSlideImage();
        var point = g_functions.getMousePosition(event);
        if (point.pageX === undefined) point = g_objTouchSlider.getLastMousePos();
        var pointImg = g_functions.getMouseElementPoint(point, objImage);
        var objSize = g_functions.getElementSize(objImage);
        isMouseInside = g_functions.isPointInsideElement(pointImg, objSize);
        return isMouseInside;
    };
    this.isCurrentSlideType = function(type) {
        var currentSlideType = t.getSlideType();
        if (currentSlideType == type) return true;
        return false;
    };
    this.isCurrentSlideLoadingImage = function() {
        var currentSlide = t.getCurrentSlide();
        var isLoading = currentSlide.data("isLoading");
        if (isLoading === true) return true;
        return false;
    };
    this.setItem = function(objItem, forseTransition, role) {
        var slides = t.getSlidesReference();
        var currentIndex = slides.objCurrentSlide.data("index");
        var nextIndex = objItem.index;
        if (nextIndex == currentIndex) {
            return true;
        }
        var isFirstSlide = currentIndex == undefined;
        if (isFirstSlide) {
            setItemToSlide(slides.objCurrentSlide, objItem);
            t.placeNabourItems();
        } else {
            var direction = "left";
            var numItems = g_gallery.getNumItems();
            if (role == "next") direction = "left"; else if (role == "prev" || currentIndex > nextIndex) direction = "right"; else if (currentIndex > nextIndex) direction = "right";
            doTransition(direction, objItem, forseTransition);
        }
    };
    this.placeNabourItems = function() {
        var slides = t.getSlidesReference();
        var currentIndex = slides.objCurrentSlide.data("index");
        var itemPrev = g_gallery.getPrevItem(currentIndex);
        var itemNext = g_gallery.getNextItem(currentIndex);
        setItemToSlide(slides.objNextSlide, itemNext);
        setItemToSlide(slides.objPrevSlide, itemPrev);
        positionSlides();
    };
    this.________EXTERNAL_API___________ = function() {};
    this.stopSlideAction = function(objSlide, isPause) {
        if (!objSlide) objSlide = t.getCurrentSlide();
        if (isPause === true) g_objVideoPlayer.pause(); else g_objVideoPlayer.hide();
    };
    this.startSlideAction = function(objSlide) {
        if (!objSlide) objSlide = t.getCurrentSlide();
        var objItem = getSlideItem(objSlide);
        if (objItem.type == "image") return true;
        if (g_options.slider_video_constantsize == true) setVideoPlayerConstantSize();
        setVideoPlayerPosition();
        g_objVideoPlayer.show();
        switch (objItem.type) {
          case "youtube":
            g_objVideoPlayer.playYoutube(objItem.videoid);
            break;

          case "vimeo":
            g_objVideoPlayer.playVimeo(objItem.videoid);
            break;

          case "html5video":
            g_objVideoPlayer.playHtml5Video(objItem.videoogv, objItem.videowebm, objItem.videomp4, objItem.urlImage);
            break;

          case "soundcloud":
            g_objVideoPlayer.playSoundCloud(objItem.trackid);
            break;

          case "wistia":
            g_objVideoPlayer.playWistia(objItem.videoid);
            break;
        }
    };
    this.getScaleMode = function(objSlide) {
        if (!objSlide) var objSlide = t.getCurrentSlide();
        var slideType = t.getSlideType(objSlide);
        if (slideType != "image") return g_options.slider_scale_mode_media;
        if (g_options.slider_scale_mode == g_options.slider_scale_mode_fullscreen) return g_options.slider_scale_mode;
        if (g_gallery.isFullScreen() == true) return g_options.slider_scale_mode_fullscreen; else return g_options.slider_scale_mode;
    };
    this.getObjects = function() {
        var obj = {
            g_objSlider: g_objSlider,
            g_objInner: g_objInner,
            g_options: g_options,
            g_objZoomSlider: g_objZoomSlider
        };
        return obj;
    };
    this.getObjZoom = function() {
        return g_objZoomSlider;
    };
    this.getOptions = function() {
        return g_options;
    };
    this.getElement = function() {
        return g_objSlider;
    };
    this.getVideoObject = function() {
        return g_objVideoPlayer;
    };
    this.isCurrentSlideImageFit = function() {
        var objSlide = t.getCurrentSlide();
        var slideType = t.getSlideType(objSlide);
        validateSlideType("image", objSlide);
        var objImage = t.getSlideImage(objSlide);
        if (objImage.length == 0) return false;
        var isFit = g_functions.isImageFitParent(objImage);
        return isFit;
    };
    this.isCurrentImageInPlace = function() {
        var objImage = t.getSlideImage();
        if (objImage.length == 0) return false;
        var scaleMode = t.getScaleMode();
        var objPadding = t.getObjImagePadding();
        var objItem = getSlideItem();
        var objParent = objImage.parent();
        var objFitSize = g_functions.getImageInsideParentData(objParent, objItem.imageWidth, objItem.imageHeight, scaleMode, objPadding);
        var objSize = g_functions.getElementSize(objImage);
        var output = false;
        if (objFitSize.imageWidth == objSize.width) output = true;
        return output;
    };
    this.isSlideActionActive = function() {
        return g_objVideoPlayer.isVisible();
    };
    this.isSwiping = function() {
        if (!g_objTouchSlider) return false;
        var isActive = g_objTouchSlider.isTouchActive();
        return isActive;
    };
    this.isPreloading = function() {
        var objPreloader = getSlidePreloader();
        if (objPreloader.is(":visible")) return true;
        return false;
    };
    this.setOptions = function(objOptions) {
        if (g_optionsPrefix) objOptions = g_functions.convertCustomPrefixOptions(objOptions, g_optionsPrefix, "slider");
        g_options = jQuery.extend(g_options, objOptions);
    };
    this.setSize = function(width, height) {
        if (width < 0 || height < 0) return true;
        var objCssSlider = {};
        objCssSlider["width"] = width + "px";
        objCssSlider["height"] = height + "px";
        g_objSlider.css(objCssSlider);
        var objCssInner = {};
        objCssInner["height"] = height + "px";
        objCssInner["top"] = "0px";
        objCssInner["left"] = "0px";
        g_objInner.css(objCssInner);
        var objCssSlide = {};
        objCssSlide["height"] = height + "px";
        objCssSlide["width"] = width + "px";
        g_objSlide1.css(objCssSlide);
        g_objSlide2.css(objCssSlide);
        g_objSlide3.css(objCssSlide);
        var itemWidth = width - g_options.slider_item_padding_left - g_options.slider_item_padding_right;
        var itemHeight = height - g_options.slider_item_padding_top - g_options.slider_item_padding_bottom;
        var objCssItemWrapper = {};
        objCssItemWrapper["width"] = itemWidth + "px";
        objCssItemWrapper["height"] = itemHeight + "px";
        objCssItemWrapper["top"] = g_options.slider_item_padding_top + "px";
        objCssItemWrapper["left"] = g_options.slider_item_padding_left + "px";
        g_objSlider.find(".ug-item-wrapper").css(objCssItemWrapper);
        if (g_objTextPanel) {
            g_objTextPanel.setSizeByParent();
        }
        positionElements();
        resizeSlideItem(g_objSlide1);
        resizeSlideItem(g_objSlide2);
        resizeSlideItem(g_objSlide3);
        positionSlides();
        var currentSlideType = t.getSlideType();
        if (currentSlideType != "image" && g_options.slider_video_constantsize == true) {
            setVideoPlayerConstantSize();
        } else {
            var videoWidth = width - g_options.slider_video_padding_left - g_options.slider_video_padding_right;
            var videoHeight = height - g_options.slider_video_padding_top - g_options.slider_video_padding_bottom;
            g_objVideoPlayer.setSize(videoWidth, videoHeight);
        }
        setVideoPlayerPosition();
    };
    this.refreshSlideItems = function() {
        if (t.isAnimating() == true) return true;
        resizeSlideItem(g_objSlide1);
        resizeSlideItem(g_objSlide2);
        resizeSlideItem(g_objSlide3);
        positionSlides();
    };
    this.isMouseOver = function() {
        return g_objSlider.ismouseover();
    };
    this.setPosition = function(left, top) {
        g_functions.placeElement(g_objSlider, left, top);
    };
    this.zoomIn = function() {
        if (!g_objZoomSlider) return true;
        g_objZoomSlider.zoomIn();
    };
    this.zoomOut = function() {
        if (!g_objZoomSlider) return true;
        g_objZoomSlider.zoomOut();
    };
    this.zoomBack = function() {
        if (!g_objZoomSlider) return true;
        g_objZoomSlider.zoomBack();
    };
}

function UGTextPanel() {
    var t = this;
    var g_objPanel, g_objParent, g_objTitle, g_objDesc;
    var g_objBG, g_objTextWrapper, g_gallery;
    var g_functions = new UGFunctions(), g_optionsPrefix = "";
    var g_options = {
        textpanel_align: "bottom",
        textpanel_margin: 0,
        textpanel_text_valign: "middle",
        textpanel_padding_top: 10,
        textpanel_padding_bottom: 10,
        textpanel_height: null,
        textpanel_padding_title_description: 5,
        textpanel_padding_right: 11,
        textpanel_padding_left: 11,
        textpanel_fade_duration: 200,
        textpanel_enable_title: true,
        textpanel_enable_description: true,
        textpanel_enable_bg: true,
        textpanel_bg_color: "#000000",
        textpanel_bg_opacity: .4,
        textpanel_title_color: null,
        textpanel_title_font_family: null,
        textpanel_title_text_align: null,
        textpanel_title_font_size: null,
        textpanel_title_bold: null,
        textpanel_css_title: {},
        textpanel_desc_color: null,
        textpanel_desc_font_family: null,
        textpanel_desc_text_align: null,
        textpanel_desc_font_size: null,
        textpanel_desc_bold: null,
        textpanel_css_description: {},
        textpanel_desc_style_as_title: false,
        textpanel_bg_css: {}
    };
    var g_temp = {
        isFirstTime: true,
        setInternalHeight: true,
        lastTitleBottom: 0,
        lastDescHeight: 0
    };
    function positionElementsTop(animateHeight, startY) {
        if (!startY) var startY = g_options.textpanel_padding_top;
        var maxy = startY;
        if (g_objTitle) {
            var titleY = maxy;
            g_functions.placeElement(g_objTitle, 0, titleY);
            var isTitleVisible = g_objTitle.is(":visible");
            if (isTitleVisible == true) {
                var objTitleSize = g_functions.getElementSize(g_objTitle);
                var maxy = objTitleSize.bottom;
                if (maxy > 0) g_temp.lastTitleBottom = maxy;
            } else {
                var maxy = 20;
                if (g_temp.lastTitleBottom > 0) maxy = g_temp.lastTitleBottom;
            }
        }
        var textDesc = "";
        if (g_objDesc) textDesc = jQuery.trim(g_objDesc.text());
        if (textDesc != "") {
            var descY = maxy;
            if (g_objTitle) descY += g_options.textpanel_padding_title_description;
            g_functions.placeElement(g_objDesc, 0, descY);
            var isVisible = jQuery(g_objDesc).is(":visible");
            if (isVisible == true) {
                var objDescSize = g_functions.getElementSize(g_objDesc);
                maxy = objDescSize.bottom;
                if (objDescSize.height > 0) g_temp.lastDescHeight = objDescSize.height;
            } else {
                var descHeight = 16;
                if (g_temp.lastDescHeight > 0) descHeight = g_temp.lastDescHeight;
                maxy = descY + descHeight;
            }
        }
        if (!g_options.textpanel_height && g_temp.setInternalHeight == true) {
            var panelHeight = maxy + g_options.textpanel_padding_bottom;
            setHeight(panelHeight, animateHeight);
        }
    }
    function getTotalTextHeight() {
        var totalHeight = 0;
        if (g_objTitle) totalHeight += g_objTitle.outerHeight();
        if (g_objDesc) {
            var textDesc = "";
            if (g_objDesc) textDesc = jQuery.trim(g_objDesc.text());
            if (textDesc != "") {
                if (g_objTitle) totalHeight += g_options.textpanel_padding_title_description;
                totalHeight += g_objDesc.outerHeight();
            }
        }
        return totalHeight;
    }
    function positionElementsMiddle() {
        var totalTextHeight = getTotalTextHeight();
        var startY = (g_objTextWrapper.height() - totalTextHeight) / 2;
        positionElementsTop(false, startY);
    }
    function positionElementBottom() {
        var totalTextHeight = getTotalTextHeight();
        var startY = g_objTextWrapper.height() - totalTextHeight - g_options.textpanel_padding_bottom;
        positionElementsTop(false, startY);
    }
    this.positionElements = function(animateHeight) {
        if (!g_options.textpanel_height || g_options.textpanel_text_valign == "top") {
            positionElementsTop(animateHeight);
            return false;
        }
        switch (g_options.textpanel_text_valign) {
          default:
          case "top":
            positionElementsTop(false);
            break;

          case "bottom":
            positionElementBottom();
            break;

          case "center":
          case "middle":
            positionElementsMiddle();
            break;
        }
    };
    function setHeight(height, animateHeight) {
        if (!animateHeight) var animateHeight = false;
        if (animateHeight == true) {
            if (g_objBG) {
                var currentHeight = g_objBG.height();
                if (height > currentHeight) g_objBG.height(height);
            }
            var objCss = {
                height: height + "px"
            };
            g_objPanel.add(g_objTextWrapper).animate(objCss, g_options.textpanel_fade_duration);
        } else {
            if (g_objBG) g_objBG.height(height);
            g_objPanel.add(g_objTextWrapper).height(height);
        }
    }
    this.init = function(objGallery, customOptions, optionsPrefix) {
        g_gallery = objGallery;
        if (optionsPrefix) {
            g_optionsPrefix = optionsPrefix;
            customOptions = g_functions.convertCustomPrefixOptions(customOptions, g_optionsPrefix, "textpanel");
        }
        if (customOptions) g_options = jQuery.extend(g_options, customOptions);
        if (g_options.textpanel_enable_title == false && g_options.textpanel_enable_description == false) throw new Error("Textpanel Error: The title or description must be enabled");
        if (g_options.textpanel_height && g_options.textpanel_height < 0) g_options.textpanel_height = null;
        if (g_options.textpanel_desc_style_as_title == true) {
            if (!g_options.textpanel_desc_color) g_options.textpanel_desc_color = g_options.textpanel_title_color;
            if (!g_options.textpanel_desc_bold) g_options.textpanel_desc_bold = g_options.textpanel_title_bold;
            if (!g_options.textpanel_desc_font_family) g_options.textpanel_desc_font_family = g_options.textpanel_title_font_family;
            if (!g_options.textpanel_desc_font_size) g_options.textpanel_desc_font_size = g_options.textpanel_title_font_size;
            if (!g_options.textpanel_desc_text_align) g_options.textpanel_desc_text_align = g_options.textpanel_title_text_align;
        }
    };
    this.appendHTML = function(objParent, addClass) {
        g_objParent = objParent;
        if (addClass) {
            addClass = " " + addClass;
        } else addClass = "";
        var html = "<div class='ug-textpanel" + addClass + "'>";
        if (g_options.textpanel_enable_bg == true) html += "<div class='ug-textpanel-bg" + addClass + "'></div>";
        html += "<div class='ug-textpanel-textwrapper" + addClass + "'>";
        if (g_options.textpanel_enable_title == true) html += "<div class='ug-textpanel-title" + addClass + "'></div>";
        if (g_options.textpanel_enable_description == true) html += "<div class='ug-textpanel-description" + addClass + "'></div>";
        html += "</div></div>";
        objParent.append(html);
        g_objPanel = objParent.children(".ug-textpanel");
        g_objTextWrapper = g_objPanel.children(".ug-textpanel-textwrapper");
        setCss();
    };
    function setCss() {
        if (g_options.textpanel_enable_bg == true) {
            g_objBG = g_objPanel.children(".ug-textpanel-bg");
            g_objBG.fadeTo(0, g_options.textpanel_bg_opacity);
            var objCssBG = {
                "background-color": g_options.textpanel_bg_color
            };
            objCssBG = jQuery.extend(objCssBG, g_options.textpanel_bg_css);
            g_objBG.css(objCssBG);
        }
        if (g_options.textpanel_enable_title == true) {
            g_objTitle = g_objTextWrapper.children(".ug-textpanel-title");
            var objCssTitle = {};
            if (g_options.textpanel_title_color !== null) objCssTitle["color"] = g_options.textpanel_title_color;
            if (g_options.textpanel_title_font_family !== null) objCssTitle["font-family"] = g_options.textpanel_title_font_family;
            if (g_options.textpanel_title_text_align !== null) objCssTitle["text-align"] = g_options.textpanel_title_text_align;
            if (g_options.textpanel_title_font_size !== null) objCssTitle["font-size"] = g_options.textpanel_title_font_size + "px";
            if (g_options.textpanel_title_bold !== null) {
                if (g_options.textpanel_title_bold === true) objCssTitle["font-weight"] = "bold"; else objCssTitle["font-weight"] = "normal";
            }
            if (g_options.textpanel_css_title) objCssTitle = jQuery.extend(objCssTitle, g_options.textpanel_css_title);
            g_objTitle.css(objCssTitle);
        }
        if (g_options.textpanel_enable_description == true) {
            g_objDesc = g_objTextWrapper.children(".ug-textpanel-description");
            var objCssDesc = {};
            if (g_options.textpanel_desc_color !== null) objCssDesc["color"] = g_options.textpanel_desc_color;
            if (g_options.textpanel_desc_font_family !== null) objCssDesc["font-family"] = g_options.textpanel_desc_font_family;
            if (g_options.textpanel_desc_text_align !== null) objCssDesc["text-align"] = g_options.textpanel_desc_text_align;
            if (g_options.textpanel_desc_font_size !== null) objCssDesc["font-size"] = g_options.textpanel_desc_font_size + "px";
            if (g_options.textpanel_desc_bold !== null) {
                if (g_options.textpanel_desc_bold === true) objCssDesc["font-weight"] = "bold"; else objCssDesc["font-weight"] = "normal";
            }
            if (g_options.textpanel_css_title) objCssDesc = jQuery.extend(objCssDesc, g_options.textpanel_css_description);
            g_objDesc.css(objCssDesc);
        }
    }
    function onItemChange() {
        var objItem = g_gallery.getSelectedItem();
        t.setText(objItem.title, objItem.description);
    }
    function initEvents() {
        jQuery(g_gallery).on(g_gallery.events.ITEM_CHANGE, onItemChange);
    }
    this.destroy = function() {
        jQuery(g_gallery).off(g_gallery.events.ITEM_CHANGE);
    };
    this.run = function() {
        t.setSizeByParent();
        initEvents();
    };
    this.setPanelSize = function(panelWidth, panelHeight) {
        g_temp.setInternalHeight = true;
        if (!panelHeight) var panelHeight = 80; else g_temp.setInternalHeight = false;
        if (g_options.textpanel_height) panelHeight = g_options.textpanel_height;
        g_objPanel.width(panelWidth);
        g_objPanel.height(panelHeight);
        if (g_objBG) {
            g_objBG.width(panelWidth);
            g_objBG.height(panelHeight);
        }
        var textWrapperWidth = panelWidth - g_options.textpanel_padding_left - g_options.textpanel_padding_right;
        var textWrapperLeft = g_options.textpanel_padding_left;
        g_functions.setElementSizeAndPosition(g_objTextWrapper, textWrapperLeft, 0, textWrapperWidth, panelHeight);
        if (g_objTitle) g_objTitle.width(textWrapperWidth);
        if (g_objDesc) g_objDesc.width(textWrapperWidth);
        if (g_temp.isFirstTime == false) t.positionElements(false);
    };
    this.setSizeByParent = function() {
        var objSize = g_functions.getElementSize(g_objParent);
        t.setPanelSize(objSize.width);
    };
    this.setTextPlain = function(title, description) {
        if (g_objTitle) g_objTitle.html(title);
        if (g_objDesc) g_objDesc.html(description);
    };
    this.setText = function(title, description) {
        if (g_temp.isFirstTime == true) {
            t.setTextPlain(title, description);
            g_temp.isFirstTime = false;
            t.positionElements(false);
        } else {
            g_objTextWrapper.stop().fadeTo(g_options.textpanel_fade_duration, 0, function() {
                t.setTextPlain(title, description);
                t.positionElements(true);
                jQuery(this).fadeTo(g_options.textpanel_fade_duration, 1);
            });
        }
    };
    this.positionPanel = function(customTop, customLeft) {
        var objCss = {};
        if (customTop !== undefined && customTop !== null) {
            objCss.top = customTop;
            objCss.bottom = "auto";
        } else {
            switch (g_options.textpanel_align) {
              case "top":
                objCss.top = g_options.textpanel_margin + "px";
                break;

              case "bottom":
                objCss.top = "auto";
                objCss.bottom = g_options.textpanel_margin + "px";
                break;

              case "middle":
                objCss.top = g_functions.getElementRelativePos(g_objPanel, "middle", g_options.textpanel_margin);
                break;
            }
        }
        if (customLeft !== undefined && customLeft !== null) objCss.left = customLeft;
        g_objPanel.css(objCss);
    };
    this.setOptions = function(objOptions) {
        if (g_optionsPrefix) objOptions = g_functions.convertCustomPrefixOptions(objOptions, g_optionsPrefix, "textpanel");
        g_options = jQuery.extend(g_options, objOptions);
    };
    this.getElement = function() {
        return g_objPanel;
    };
    this.getSize = function() {
        var objSize = g_functions.getElementSize(g_objPanel);
        return objSize;
    };
    this.refresh = function(toShow, noPosition, panelWidth, panelHeight) {
        setCss();
        if (!panelWidth) t.setSizeByParent(); else t.setPanelSize(panelWidth, panelHeight);
        t.positionElements(false);
        if (noPosition !== true) t.positionPanel();
        if (toShow === true) t.show();
    };
    this.hide = function() {
        g_objPanel.hide();
    };
    this.show = function() {
        g_objPanel.show();
    };
    this.getOptions = function() {
        return g_options;
    };
    this.getOption = function(optionName) {
        if (g_options.hasOwnProperty(optionName) == false) return null;
        return g_options[optionName];
    };
}

function UGZoomButtonsPanel() {
    var t = this;
    var g_objPanel, g_objParent, g_objButtonPlus, g_objButtonMinus, g_objButtonReturn;
    var g_slider = new UGSlider();
    var g_functions = new UGFunctions();
    var g_options = {
        slider_zoompanel_skin: ""
    };
    var g_temp = {};
    this.init = function(objSlider, customOptions) {
        g_slider = objSlider;
        if (customOptions) g_options = jQuery.extend(g_options, customOptions);
    };
    this.appendHTML = function(objParent) {
        g_objParent = objParent;
        var html = "<div class='ug-slider-control ug-zoompanel ug-skin-" + g_options.slider_zoompanel_skin + "'>";
        html += "<div class='ug-zoompanel-button ug-zoompanel-plus'></div>";
        html += "<div class='ug-zoompanel-button ug-zoompanel-minus ug-zoompanel-button-disabled'></div>";
        html += "<div class='ug-zoompanel-button ug-zoompanel-return ug-zoompanel-button-disabled'></div>";
        html += "</div>";
        objParent.append(html);
        g_objPanel = objParent.children(".ug-zoompanel");
        g_objButtonPlus = g_objPanel.children(".ug-zoompanel-plus");
        g_objButtonMinus = g_objPanel.children(".ug-zoompanel-minus");
        g_objButtonReturn = g_objPanel.children(".ug-zoompanel-return");
    };
    this.setObjects = function(objButtonPlus, objButtonMinus, objButtonReturn) {
        g_objButtonPlus = objButtonPlus;
        g_objButtonMinus = objButtonMinus;
        g_objButtonReturn = objButtonReturn;
        if (g_objButtonMinus) g_objButtonMinus.addClass("ug-zoompanel-button-disabled");
        if (g_objButtonReturn) g_objButtonReturn.addClass("ug-zoompanel-button-disabled");
    };
    this.getElement = function() {
        return g_objPanel;
    };
    function isButtonDisabled(objButton) {
        if (!objButton) return true;
        if (objButton.hasClass("ug-zoompanel-button-disabled")) return true;
        return false;
    }
    function disableButton(objButton) {
        if (objButton) objButton.addClass("ug-zoompanel-button-disabled");
    }
    function enableButton(objButton) {
        if (objButton) objButton.removeClass("ug-zoompanel-button-disabled");
    }
    function onZoomChange() {
        if (g_slider.isCurrentSlideType("image") == false) return true;
        var isFit = g_slider.isCurrentSlideImageFit();
        if (isFit == true) {
            if (isButtonDisabled(g_objButtonMinus) == false) {
                disableButton(g_objButtonMinus);
                disableButton(g_objButtonReturn);
            }
        } else {
            if (isButtonDisabled(g_objButtonMinus) == true) {
                enableButton(g_objButtonMinus);
                enableButton(g_objButtonReturn);
            }
        }
    }
    t.initEvents = function() {
        g_functions.addClassOnHover(g_objButtonPlus, "ug-button-hover");
        g_functions.addClassOnHover(g_objButtonMinus, "ug-button-hover");
        g_functions.addClassOnHover(g_objButtonReturn, "ug-button-hover");
        g_functions.setButtonOnClick(g_objButtonPlus, function() {
            if (isButtonDisabled(g_objButtonPlus) == true) return true;
            g_slider.zoomIn();
        });
        g_functions.setButtonOnClick(g_objButtonMinus, function() {
            if (isButtonDisabled(g_objButtonMinus) == true) return true;
            g_slider.zoomOut();
        });
        g_functions.setButtonOnClick(g_objButtonReturn, function() {
            if (isButtonDisabled(g_objButtonReturn) == true) return true;
            g_slider.zoomBack();
        });
        jQuery(g_slider).on(g_slider.events.ZOOM_CHANGE, onZoomChange);
        jQuery(g_slider).on(g_slider.events.ITEM_CHANGED, onZoomChange);
    };
}

function UGBullets() {
    var t = this, g_numBullets = 0, g_gallery = new UniteGalleryMain();
    var g_objBullets, g_objParent, g_activeIndex = -1, g_bulletWidth;
    var g_functions = new UGFunctions();
    var g_temp = {
        isInited: false
    };
    var g_options = {
        bullets_skin: "",
        bullets_addclass: "",
        bullets_space_between: -1
    };
    this.events = {
        BULLET_CLICK: "bullet_click"
    };
    this.init = function(gallery, customOptions, numBullets) {
        g_gallery = gallery;
        if (numBullets) g_numBullets = numBullets; else g_numBullets = g_gallery.getNumItems();
        g_temp.isInited = true;
        g_options = jQuery.extend(g_options, customOptions);
        if (g_options.bullets_skin == "") g_options.bullets_skin = g_options.gallery_skin;
    };
    function setHtmlBullets() {
        var html = "";
        var addHtml = "";
        if (g_options.bullets_space_between != -1) addHtml = " style='margin-left:" + g_options.bullets_space_between + "px'";
        for (var i = 0; i < g_numBullets; i++) {
            if (i == 0) html += "<div class='ug-bullet'></div>"; else html += "<div class='ug-bullet'" + addHtml + "></div>";
        }
        g_objBullets.html(html);
        if (!g_bulletWidth) {
            var objBullet = g_objBullets.find(".ug-bullet:first-child");
            if (objBullet.length) g_bulletWidth = objBullet.width();
        }
    }
    this.getBulletsWidth = function() {
        if (g_numBullets == 0) return 0;
        if (!g_bulletWidth) return 0;
        var totalWidth = g_numBullets * g_bulletWidth + (g_numBullets - 1) * g_options.bullets_space_between;
        return totalWidth;
    };
    this.appendHTML = function(objParent) {
        g_objParent = objParent;
        validateInited();
        var addClass = "";
        if (g_options.bullets_addclass != "") addClass = " " + g_options.bullets_addclass;
        var html = "<div class='ug-slider-control ug-bullets ug-skin-" + g_options.bullets_skin + addClass + "'>";
        html += "</div>";
        g_objBullets = jQuery(html);
        objParent.append(g_objBullets);
        setHtmlBullets();
        initEvents();
    };
    this.updateNumBullets = function(numBullets) {
        g_numBullets = numBullets;
        setHtmlBullets();
        initEvents();
    };
    function onBulletClick(objBullet) {
        if (t.isActive(objBullet) == true) return true;
        var index = objBullet.index();
        jQuery(t).trigger(t.events.BULLET_CLICK, index);
    }
    function initEvents() {
        var objBullets = g_objBullets.children(".ug-bullet");
        g_functions.setButtonOnClick(objBullets, onBulletClick);
        objBullets.on("mousedown mouseup", function(event) {
            return false;
        });
    }
    this.getElement = function() {
        return g_objBullets;
    };
    this.setActive = function(index) {
        validateInited();
        validateIndex(index);
        var children = g_objBullets.children(".ug-bullet");
        children.removeClass("ug-bullet-active");
        var bullet = jQuery(children[index]);
        bullet.addClass("ug-bullet-active");
        g_activeIndex = index;
    };
    this.isActive = function(index) {
        validateIndex(index);
        if (typeof index != "number") var objBullet = index; else {
            var objBullet = g_objBullets.children(".ug-bullet")[index];
        }
        if (objBullet.hasClass("ug-bullet-active")) return true;
        return false;
    };
    this.getNumBullets = function() {
        return g_numBullets;
    };
    function validateIndex(index) {
        if (index < 0 || index >= g_numBullets) throw new Error("wrong bullet index: " + index);
    }
    function validateInited() {
        if (g_temp.isInited == true) return true;
        throw new Error("The bullets are not inited!");
    }
}

function UGProgressBar() {
    var t = this, g_isInited = false;
    var g_percent = 0, g_objBar, g_objInner, g_functions = new UGFunctions();
    var g_options = {
        slider_progressbar_color: "#ffffff",
        slider_progressbar_opacity: .6,
        slider_progressbar_line_width: 5
    };
    this.put = function(g_objWrapper, userOptions) {
        if (userOptions) g_options = jQuery.extend(g_options, userOptions);
        g_objWrapper.append("<div class='ug-progress-bar'><div class='ug-progress-bar-inner'></div></div>");
        g_objBar = g_objWrapper.children(".ug-progress-bar");
        g_objInner = g_objBar.children(".ug-progress-bar-inner");
        g_objInner.css("background-color", g_options.slider_progressbar_color);
        g_objBar.height(g_options.slider_progressbar_line_width);
        g_objInner.height(g_options.slider_progressbar_line_width);
        g_objInner.width("0%");
        var opacity = g_options.slider_progressbar_opacity;
        var objInnerHTML = g_objInner[0];
        objInnerHTML.style.opacity = opacity;
        objInnerHTML.style.filter = "alpha(opacity=" + opacity * 100 + ")";
    };
    this.putHidden = function(g_objWrapper, userOptions) {
        t.put(g_objWrapper, userOptions);
        g_objBar.hide();
    };
    this.getElement = function() {
        return g_objBar;
    };
    this.setSize = function(width) {
        g_objBar.width(width);
        g_objInner.width(width);
        t.draw();
    };
    this.setPosition = function(left, top, offsetLeft, offsetTop) {
        g_functions.placeElement(g_objBar, left, top, offsetLeft, offsetTop);
    };
    this.draw = function() {
        var innerWidth = g_percent * 100;
        g_objInner.width(innerWidth + "%");
    };
    this.setProgress = function(percent) {
        g_percent = g_functions.normalizePercent(percent);
        t.draw();
    };
    this.getType = function() {
        return "bar";
    };
}

function UGProgressPie() {
    var t = this, g_isInited = false;
    var g_percent, g_objPie, g_functions = new UGFunctions();
    var g_options = {
        slider_progresspie_type_fill: false,
        slider_progresspie_color1: "#B5B5B5",
        slider_progresspie_color2: "#E5E5E5",
        slider_progresspie_stroke_width: 6,
        slider_progresspie_width: 30,
        slider_progresspie_height: 30
    };
    this.put = function(g_objWrapper, userOptions) {
        if (userOptions) g_options = jQuery.extend(g_options, userOptions);
        g_objWrapper.append("<canvas class='ug-canvas-pie' width='" + g_options.slider_progresspie_width + "' height='" + g_options.slider_progresspie_height + "'></canvas>");
        g_objPie = g_objWrapper.children(".ug-canvas-pie");
    };
    this.putHidden = function(g_objWrapper, userOptions) {
        t.put(g_objWrapper, userOptions);
        draw(.1);
        g_objPie.hide();
    };
    this.getElement = function() {
        return g_objPie;
    };
    this.setPosition = function(left, top) {
        g_functions.placeElement(g_objPie, left, top);
    };
    this.getSize = function() {
        var obj = {
            width: g_options.slider_progresspie_width,
            height: g_options.slider_progresspie_height
        };
        return obj;
    };
    function draw(percent) {
        if (!percent) var percent = 0;
        var radius = Math.min(g_options.slider_progresspie_width, g_options.slider_progresspie_height) / 2;
        var ctx = g_objPie[0].getContext("2d");
        if (g_isInited == false) {
            g_isInited = true;
            ctx.rotate(Math.PI * (3 / 2));
            ctx.translate(-2 * radius, 0);
        }
        ctx.clearRect(0, 0, g_options.slider_progresspie_width, g_options.slider_progresspie_height);
        var centerX = g_options.slider_progresspie_width / 2;
        var centerY = g_options.slider_progresspie_height / 2;
        var startPoint = 0;
        var endPoint = percent * Math.PI * 2;
        if (g_options.slider_progresspie_type_fill == true) {
            ctx.beginPath();
            ctx.moveTo(centerX, centerY);
            ctx.arc(centerX, centerY, radius, startPoint, endPoint);
            ctx.lineTo(centerX, centerY);
            ctx.fillStyle = g_options.slider_progresspie_color1;
            ctx.fill();
            ctx.closePath();
        } else {
            ctx.globalCompositeOperation = "source-over";
            ctx.beginPath();
            ctx.moveTo(centerX, centerY);
            ctx.arc(centerX, centerY, radius, startPoint, endPoint);
            ctx.lineTo(centerX, centerY);
            ctx.fillStyle = g_options.slider_progresspie_color1;
            ctx.fill();
            ctx.closePath();
            ctx.globalCompositeOperation = "destination-out";
            var radius2 = radius - g_options.slider_progresspie_stroke_width;
            ctx.beginPath();
            ctx.moveTo(centerX, centerY);
            ctx.arc(centerX, centerY, radius2, startPoint, endPoint);
            ctx.lineTo(centerX, centerY);
            ctx.fillStyle = g_options.slider_progresspie_color1;
            ctx.fill();
            ctx.closePath();
        }
        if (g_options.slider_progresspie_type_fill == true) {
            startPoint = endPoint;
            endPoint = Math.PI * 2;
            ctx.beginPath();
            ctx.arc(centerX, centerY, radius, startPoint, endPoint);
            ctx.lineTo(centerX, centerY);
            ctx.fillStyle = g_options.slider_progresspie_color2;
            ctx.fill();
            ctx.closePath();
        }
    }
    this.setProgress = function(percent) {
        percent = g_functions.normalizePercent(percent);
        g_percent = percent;
        draw(percent);
    };
    this.getType = function() {
        return "pie";
    };
}

function UGTouchSliderControl() {
    var g_objSlider, g_objInner, g_parent = new UGSlider();
    var g_objParent, g_options, t = this;
    var g_functions = new UGFunctions();
    var g_options = {
        slider_transition_continuedrag_speed: 250,
        slider_transition_continuedrag_easing: "linear",
        slider_transition_return_speed: 300,
        slider_transition_return_easing: "easeInOutQuad"
    };
    var g_temp = {
        touch_active: false,
        startMouseX: 0,
        startMouseY: 0,
        lastMouseX: 0,
        lastMouseY: 0,
        startPosx: 0,
        startTime: 0,
        isInitDataValid: false,
        slides: null,
        lastNumTouches: 0,
        isDragging: false,
        storedEventID: "touchSlider",
        videoStartX: 0,
        isDragVideo: false,
        videoObject: null
    };
    function getDiffPosFromCurrentItem(slides) {
        if (!slides) var slides = g_parent.getSlidesReference();
        var posCurrent = g_functions.getElementSize(slides.objCurrentSlide);
        var inPlaceX = -posCurrent.left;
        var objInnerSize = g_functions.getElementSize(g_objInner);
        var diffPos = inPlaceX - objInnerSize.left;
        return diffPos;
    }
    function isMovementValidForChange() {
        var slides = g_parent.getSlidesReference();
        var diffPos = getDiffPosFromCurrentItem(slides);
        var breakSize = Math.round(slides.objCurrentSlide.width() * 3 / 8);
        if (Math.abs(diffPos) >= breakSize) return true;
        var diffX = Math.abs(g_temp.lastMouseX - g_temp.startMouseX);
        var diffY = Math.abs(g_temp.lastMouseY - g_temp.startMouseY);
        if (diffX < 20) return false;
        var endTime = jQuery.now();
        var diffTime = endTime - g_temp.startTime;
        if (diffTime < 500) return true;
        return false;
    }
    this.isTapEventOccured = function(event) {
        var arrTouches = g_functions.getArrTouches(event);
        var numTouches = arrTouches.length;
        if (numTouches != 0 || g_temp.lastNumTouches != 0) {
            g_temp.lastNumTouches = numTouches;
            return false;
        }
        g_temp.lastNumTouches = numTouches;
        var slides = g_parent.getSlidesReference();
        var diffPos = getDiffPosFromCurrentItem(slides);
        var diffX = Math.abs(g_temp.lastMouseX - g_temp.startMouseX);
        var diffY = Math.abs(g_temp.lastMouseY - g_temp.startMouseY);
        var endTime = jQuery.now();
        var diffTime = endTime - g_temp.startTime;
        if (diffX < 20 && diffY < 50 && diffTime < 500) return true;
        return false;
    };
    function returnToPlace(slides) {
        if (g_parent.isInnerInPlace() == true) return false;
        g_objParent.trigger(g_parent.events.BEFORE_RETURN);
        if (!slides) var slides = g_parent.getSlidesReference();
        var posCurrent = g_functions.getElementSize(slides.objCurrentSlide);
        var destX = -posCurrent.left;
        g_objInner.animate({
            left: destX + "px"
        }, {
            duration: g_options.slider_transition_return_speed,
            easing: g_options.slider_transition_continuedrag_easing,
            queue: false,
            progress: function(animation, number, remainingMS) {
                if (g_temp.isDragVideo == true) {
                    var objSize = g_functions.getElementSize(g_objInner);
                    var innerX = objSize.left;
                    var posDiff = innerX - destX;
                    var videoPosX = g_temp.videoStartX + posDiff;
                    g_temp.videoObject.css("left", videoPosX);
                }
            },
            complete: function() {
                g_objParent.trigger(g_parent.events.AFTER_RETURN);
            }
        });
    }
    function changeItem(direction) {
        g_parent.getVideoObject().hide();
        g_parent.switchSlideNums(direction);
        g_parent.placeNabourItems();
    }
    function continueSlideDragChange() {
        var slides = g_parent.getSlidesReference();
        var diffPos = getDiffPosFromCurrentItem(slides);
        if (diffPos == 0) return false;
        var direction = diffPos > 0 ? "left" : "right";
        var isReturn = false;
        switch (direction) {
          case "right":
            if (g_parent.isSlideHasItem(slides.objPrevSlide)) {
                var posPrev = g_functions.getElementSize(slides.objPrevSlide);
                var destX = -posPrev.left;
            } else isReturn = true;
            break;

          case "left":
            if (g_parent.isSlideHasItem(slides.objNextSlide)) {
                var posNext = g_functions.getElementSize(slides.objNextSlide);
                var destX = -posNext.left;
            } else isReturn = true;
            break;
        }
        if (isReturn == true) {
            returnToPlace(slides);
        } else {
            g_objInner.stop().animate({
                left: destX + "px"
            }, {
                duration: g_options.slider_transition_continuedrag_speed,
                easing: g_options.slider_transition_continuedrag_easing,
                queue: false,
                progress: function() {
                    if (g_temp.isDragVideo == true) {
                        var objSize = g_functions.getElementSize(g_objInner);
                        var innerX = objSize.left;
                        var posDiff = innerX - g_temp.startPosx;
                        var videoPosX = g_temp.videoStartX + posDiff;
                        g_temp.videoObject.css("left", videoPosX);
                    }
                },
                always: function() {
                    changeItem(direction);
                    g_objParent.trigger(g_parent.events.AFTER_DRAG_CHANGE);
                }
            });
        }
    }
    function handleSliderDrag(event) {
        var diff = g_temp.lastMouseX - g_temp.startMouseX;
        if (diff == 0) return true;
        var direction = diff < 0 ? "left" : "right";
        var objZoomSlider = g_parent.getObjZoom();
        if (objZoomSlider) {
            var isPanEnabled = objZoomSlider.isPanEnabled(event, direction);
            if (isPanEnabled == true) {
                g_temp.isInitDataValid = false;
                return true;
            } else {
                if (g_temp.isInitDataValid == false) {
                    storeInitTouchData(event);
                    return true;
                }
            }
        }
        var currentPosx = g_temp.startPosx + diff;
        if (diff > 0 && currentPosx > 0) currentPosx = currentPosx / 3; else if (diff < 0) {
            var innerEnd = currentPosx + g_objInner.width();
            var sliderWidth = g_objSlider.width();
            if (innerEnd < sliderWidth) {
                currentPosx = g_temp.startPosx + diff / 3;
            }
        }
        if (g_temp.isDragging == false) {
            g_temp.isDragging = true;
            g_objParent.trigger(g_parent.events.START_DRAG);
        }
        g_objInner.css("left", currentPosx + "px");
        if (g_temp.isDragVideo == true) {
            var posDiff = currentPosx - g_temp.startPosx;
            var videoPosX = g_temp.videoStartX + posDiff;
            g_temp.videoObject.css("left", videoPosX);
        }
    }
    function storeInitTouchData(event) {
        var mousePos = g_functions.getMousePosition(event);
        g_temp.startMouseX = mousePos.pageX;
        g_temp.startMouseY = mousePos.pageY;
        g_temp.lastMouseX = g_temp.startMouseX;
        g_temp.lastMouseY = g_temp.startMouseY;
        g_temp.startTime = jQuery.now();
        var arrTouches = g_functions.getArrTouches(event);
        g_temp.startArrTouches = g_functions.getArrTouchPositions(arrTouches);
        var objPos = g_functions.getElementSize(g_objInner);
        g_temp.startPosx = objPos.left;
        g_temp.isInitDataValid = true;
        g_temp.isDragVideo = false;
        g_functions.storeEventData(event, g_temp.storedEventID);
    }
    function disableTouchActive(who) {
        g_temp.touch_active = false;
    }
    function enableTouchActive(who, event) {
        g_temp.touch_active = true;
        storeInitTouchData(event);
    }
    function onTouchStart(event) {
        event.preventDefault();
        g_temp.isDragging = false;
        if (g_parent.isAnimating() == true) {
            g_objInner.stop(true, true);
        }
        var arrTouches = g_functions.getArrTouches(event);
        if (arrTouches.length > 1) {
            if (g_temp.touch_active == true) {
                disableTouchActive("1");
            }
            return true;
        }
        if (g_temp.touch_active == true) {
            return true;
        }
        enableTouchActive("1", event);
    }
    function onTouchMove(event) {
        if (g_temp.touch_active == false) return true;
        if (event.buttons == 0) {
            disableTouchActive("2");
            continueSlideDragChange();
            return true;
        }
        g_functions.updateStoredEventData(event, g_temp.storedEventID);
        event.preventDefault();
        var mousePos = g_functions.getMousePosition(event);
        g_temp.lastMouseX = mousePos.pageX;
        g_temp.lastMouseY = mousePos.pageY;
        var scrollDir = null;
        if (g_options.slider_vertical_scroll_ondrag == true) scrollDir = g_functions.handleScrollTop(g_temp.storedEventID);
        if (scrollDir !== "vert") handleSliderDrag(event);
    }
    function onTouchEnd(event) {
        var arrTouches = g_functions.getArrTouches(event);
        var numTouches = arrTouches.length;
        var isParentInPlace = g_parent.isInnerInPlace();
        if (isParentInPlace == true && g_temp.touch_active == false && numTouches == 0) {
            return true;
        }
        if (numTouches == 0 && g_temp.touch_active == true) {
            disableTouchActive("3");
            var isValid = false;
            var wasVerticalScroll = g_functions.wasVerticalScroll(g_temp.storedEventID);
            if (wasVerticalScroll == false) isValid = isMovementValidForChange();
            if (isValid == true) continueSlideDragChange(); else returnToPlace();
        } else {
            if (numTouches == 1 && g_temp.touch_active == false) {
                enableTouchActive("2", event);
            }
        }
    }
    function initEvents() {
        g_objSlider.bind("mousedown touchstart", onTouchStart);
        jQuery("body").bind("mousemove touchmove", onTouchMove);
        jQuery(window).add("body").bind("mouseup touchend", onTouchEnd);
    }
    this.init = function(objSlider, customOptions) {
        g_parent = objSlider;
        g_objParent = jQuery(g_parent);
        g_objects = objSlider.getObjects();
        g_objSlider = g_objects.g_objSlider;
        g_objInner = g_objects.g_objInner;
        g_options = jQuery.extend(g_options, customOptions);
        initEvents();
    };
    this.getLastMousePos = function() {
        var obj = {
            pageX: g_temp.lastMouseX,
            pageY: g_temp.lastMouseY
        };
        return obj;
    };
    this.isTouchActive = function() {
        return g_temp.touch_active;
    };
}

function UGZoomSliderControl() {
    var g_objSlider, g_objInner, g_parent = new UGSlider(), g_objParent;
    var g_functions = new UGFunctions();
    var t = this;
    var g_options = {
        slider_zoom_step: 1.2,
        slider_zoom_max_ratio: 6,
        slider_zoom_return_pan_duration: 400,
        slider_zoom_return_pan_easing: "easeOutCubic"
    };
    var g_temp = {
        isPanActive: false,
        startMouseX: 0,
        startMouseY: 0,
        lastMouseX: 0,
        lastMouseY: 0,
        startImageX: 0,
        startImageY: 0,
        panXActive: false,
        panYActive: false,
        objImage: null,
        objImageSize: null,
        objParent: null,
        objParentSize: null,
        objSlide: null,
        storeImageLastTime: 0,
        isZoomActive: false,
        startDistance: 0,
        startMiddlePoint: null,
        imageOrientPoint: null,
        objFitImageSize: null,
        isZoomedOnce: false
    };
    function initObject(objSlider, customOptions) {
        g_parent = objSlider;
        g_objParent = jQuery(g_parent);
        g_objects = objSlider.getObjects();
        g_objSlider = g_objects.g_objSlider;
        g_objInner = g_objects.g_objInner;
        g_options = jQuery.extend(g_options, customOptions);
        initEvents();
    }
    function getFitScaleMode() {
        var scaleMode = g_parent.getScaleMode();
        if (scaleMode != "down") scaleMode = "fit";
        return scaleMode;
    }
    function storeCurrentImage() {
        var currentTime = jQuery.now();
        var diff = currentTime - g_temp.storeImageLastTime;
        if (diff < 20) return false;
        var slides = g_parent.getSlidesReference();
        g_temp.objSlide = slides.objCurrentSlide;
        g_temp.objImage = slides.objCurrentSlide.find("img");
        if (g_temp.objImage.length == 0) return false;
        g_temp.objImageSize = g_functions.getElementSize(g_temp.objImage);
        g_temp.objParent = g_temp.objImage.parent();
        g_temp.objParentSize = g_functions.getElementSize(g_temp.objParent);
        var scaleMode = getFitScaleMode();
        objPadding = g_parent.getObjImagePadding();
        g_temp.objFitImageSize = g_functions.getImageInsideParentDataByImage(g_temp.objImage, scaleMode, objPadding);
        var currentTime = jQuery.now();
        g_temp.storeImageLastTime = currentTime;
        return true;
    }
    function zoomCurrentImage(mode, mousePos) {
        var slides = g_parent.getSlidesReference();
        var objImage = slides.objCurrentSlide.find("img");
        var scaleMode = getFitScaleMode();
        g_objParent.trigger(g_parent.events.ZOOM_START);
        var isZoomed = true;
        var objPadding = g_parent.getObjImagePadding();
        if (mode == "back") {
            var objOriginalSize = g_functions.getImageOriginalSize(objImage);
            g_functions.scaleImageFitParent(objImage, objOriginalSize.width, objOriginalSize.height, scaleMode, objPadding);
        } else {
            var zoomIn = mode == "in" ? true : false;
            isZoomed = g_functions.zoomImageInsideParent(objImage, zoomIn, g_options.slider_zoom_step, mousePos, scaleMode, g_options.slider_zoom_max_ratio, objPadding);
        }
        if (isZoomed == true) {
            g_objParent.trigger(g_parent.events.ZOOMING);
            g_objParent.trigger(g_parent.events.ZOOM_CHANGE);
            g_objParent.trigger(g_parent.events.ZOOM_END);
        }
    }
    function ____________PAN_____________() {}
    function isPanPosible(objImage, event, stictTouchesCheck) {
        var arrTouches = g_functions.getArrTouches(event);
        if (stictTouchesCheck === true) {
            if (arrTouches.length != 1) return false;
        } else {
            if (arrTouches.length > 1) return false;
        }
        if (g_functions.isElementBiggerThenParent(objImage)) return true;
        return false;
    }
    function storePanInitValues(event) {
        var mousePos = g_functions.getMousePosition(event);
        g_temp.startMouseX = mousePos.pageX;
        g_temp.startMouseY = mousePos.pageY;
        g_temp.lastMouseX = g_temp.startMouseX;
        g_temp.lastMouseY = g_temp.startMouseY;
        g_temp.startImageX = g_temp.objImageSize.left;
        g_temp.startImageY = g_temp.objImageSize.top;
        g_temp.panXActive = g_temp.objImageSize.width > g_temp.objParentSize.width;
        g_temp.panYActive = g_temp.objImageSize.height > g_temp.objParentSize.height;
    }
    function startPan(event) {
        g_temp.isPanActive = true;
        storePanInitValues(event);
    }
    function panImage(event) {
        if (g_temp.objImage == undefined || g_temp.objImage.length == 0) return true;
        var mousePos = g_functions.getMousePosition(event);
        var diffX = mousePos.pageX - g_temp.startMouseX;
        var diffY = mousePos.pageY - g_temp.startMouseY;
        var diffLastX = mousePos.pageX - g_temp.lastMouseX;
        var diffLastY = mousePos.pageY - g_temp.lastMouseY;
        var directionX = diffLastX < 0 ? "left" : "right";
        var directionY = diffLastY < 0 ? "up" : "down";
        g_temp.lastMouseX = mousePos.pageX;
        g_temp.lastMouseY = mousePos.pageY;
        var posImage = g_functions.getElementSize(g_temp.objImage);
        if (g_temp.panYActive == false) {
            diffLastY = 0;
        } else {
            if (directionY == "down" && posImage.top > 0) {
                diffLastY = diffLastY / 3;
            } else if (directionY == "up" && posImage.bottom < g_temp.objParentSize.height) {
                diffLastY = diffLastY / 3;
            }
        }
        if (g_temp.panXActive == false || g_parent.isInnerInPlace() == false) {
            diffLastX = 0;
        } else {
            if (directionX == "right" && posImage.left > 0) {
                diffLastX = diffLastX / 3;
            } else if (directionX == "left" && posImage.right < g_temp.objParentSize.width) {
                diffLastX = diffLastX / 3;
            }
        }
        var imageX = posImage.left + diffLastX;
        var imageY = posImage.top + diffLastY;
        g_functions.placeElement(g_temp.objImage, imageX, imageY);
    }
    function checkReturnAfterPan() {
        var isReturnX = false, isReturnY = false, newX = 0, newY = 0;
        var objSize = g_functions.getElementSize(g_temp.objImage);
        var objImagePadding = g_parent.getObjImagePadding();
        var objCenterPos = g_functions.getElementCenterPosition(g_temp.objImage, objImagePadding);
        g_temp.panXActive = g_temp.objImageSize.width > g_temp.objParentSize.width;
        g_temp.panYActive = g_temp.objImageSize.height > g_temp.objParentSize.height;
        if (g_temp.panYActive == true) {
            if (objSize.top > 0) {
                newY = 0;
                isReturnY = true;
            } else if (objSize.bottom < g_temp.objParentSize.height) {
                newY = g_temp.objParentSize.height - objSize.height;
                isReturnY = true;
            }
        } else {
            if (objSize.top != objCenterPos.top) {
                isReturnY = true;
                newY = objCenterPos.top;
            }
        }
        if (g_temp.panXActive == true) {
            if (objSize.left > 0) {
                newX = 0;
                isReturnX = true;
            } else if (objSize.right < g_temp.objParentSize.width) {
                newX = g_temp.objParentSize.width - objSize.width;
                isReturnX = true;
            }
        } else {
            if (objSize.left != objCenterPos.left) {
                isReturnX = true;
                newX = objCenterPos.left;
            }
        }
        var objCss = {};
        if (isReturnY == true) objCss.top = newY + "px";
        if (isReturnX == true) objCss.left = newX + "px";
        if (isReturnY == true || isReturnX == true) {
            g_temp.objImage.animate(objCss, {
                duration: g_options.slider_zoom_return_pan_duration,
                easing: g_options.slider_zoom_return_pan_easing,
                queue: false
            });
        }
    }
    function isImageAnimating() {
        if (g_temp.objImage && g_temp.objImage.is(":animated")) return true;
        return false;
    }
    function ____________END_PAN_____________() {}
    function ________TOUCH_ZOOM_____________() {}
    function startTouchZoom(arrTouches) {
        g_temp.isZoomActive = true;
        g_temp.startDistance = g_functions.getDistance(arrTouches[0].pageX, arrTouches[0].pageY, arrTouches[1].pageX, arrTouches[1].pageY);
        if (g_temp.startDistance == 0) g_temp.startDistance = 1;
        g_temp.startMiddlePoint = g_functions.getMiddlePoint(arrTouches[0].pageX, arrTouches[0].pageY, arrTouches[1].pageX, arrTouches[1].pageY);
        g_temp.objImageSize = g_functions.getElementSize(g_temp.objImage);
        g_temp.startImageX = g_temp.objImageSize.left;
        g_temp.startImageY = g_temp.objImageSize.top;
        g_temp.imageOrientPoint = g_functions.getElementLocalPoint(g_temp.startMiddlePoint, g_temp.objImage);
        var isInsideImage = g_functions.isPointInsideElement(g_temp.imageOrientPoint, g_temp.objImageSize);
        if (isInsideImage == false) {
            g_temp.imageOrientPoint = g_functions.getElementCenterPoint(g_temp.objImage);
        }
        g_objParent.trigger(g_parent.events.ZOOM_START);
    }
    function checkTouchZoomEnd(event) {
        if (g_temp.isZoomActive == false) return false;
        var arrTouches = g_functions.getArrTouches(event);
        if (arrTouches.length != 2) {
            g_temp.isZoomActive = false;
            g_objParent.trigger(g_parent.events.ZOOM_END);
        }
    }
    function checkTouchZoomStart(event) {
        if (g_temp.isZoomActive == true) return true;
        var arrTouches = g_functions.getArrTouches(event);
        if (arrTouches.length != 2) return true;
        startTouchZoom(arrTouches);
    }
    function doTouchZoom(event) {
        var arrTouches = g_functions.getArrTouches(event);
        var distance = g_functions.getDistance(arrTouches[0].pageX, arrTouches[0].pageY, arrTouches[1].pageX, arrTouches[1].pageY);
        var zoomRatio = distance / g_temp.startDistance;
        var middlePoint = g_functions.getMiddlePoint(arrTouches[0].pageX, arrTouches[0].pageY, arrTouches[1].pageX, arrTouches[1].pageY);
        var newWidth = g_temp.objImageSize.width * zoomRatio;
        var newHeight = g_temp.objImageSize.height * zoomRatio;
        var objOriginalSize = g_functions.getImageOriginalSize(g_temp.objImage);
        var expectedZoomRatio = 1;
        if (objOriginalSize.width > 0) expectedZoomRatio = newWidth / objOriginalSize.width;
        if (expectedZoomRatio > g_options.slider_zoom_max_ratio) return true;
        panX = -(g_temp.imageOrientPoint.x * zoomRatio - g_temp.imageOrientPoint.x);
        panY = -(g_temp.imageOrientPoint.y * zoomRatio - g_temp.imageOrientPoint.y);
        var diffMiddleX = middlePoint.x - g_temp.startMiddlePoint.x;
        var diffMiddleY = middlePoint.y - g_temp.startMiddlePoint.y;
        var posx = g_temp.startImageX + panX + diffMiddleX;
        var posy = g_temp.startImageY + panY + diffMiddleY;
        g_functions.setElementSizeAndPosition(g_temp.objImage, posx, posy, newWidth, newHeight);
        g_objParent.trigger(g_parent.events.ZOOMING);
        g_objParent.trigger(g_parent.events.ZOOM_CHANGE);
    }
    function checkReturnFromZoom() {
        if (g_temp.objImage == undefined || g_temp.objImage.length == 0) return true;
        var objSize = g_functions.getElementSize(g_temp.objImage);
        if (objSize.width < g_temp.objFitImageSize.imageWidth) {
            g_temp.objImage.css({
                position: "absolute",
                margin: "none"
            });
            var objCss = {
                top: g_temp.objFitImageSize.imageTop + "px",
                left: g_temp.objFitImageSize.imageLeft + "px",
                width: g_temp.objFitImageSize.imageWidth + "px",
                height: g_temp.objFitImageSize.imageHeight + "px"
            };
            g_temp.objImage.animate(objCss, {
                duration: g_options.slider_zoom_return_pan_duration,
                easing: g_options.slider_zoom_return_pan_easing,
                queue: false
            });
        } else {
            checkReturnAfterPan();
        }
    }
    function ________END_TOUCH_ZOOM_____________() {}
    function onTouchStart(event) {
        if (g_parent.isCurrentSlideType("image") == false) return true;
        var isStored = storeCurrentImage();
        if (g_temp.objImage == undefined || g_temp.objImage.length == 0) return true;
        event.preventDefault();
        if (isImageAnimating() == true) {
            g_temp.objImage.stop(true);
        }
        if (g_temp.isZoomActive == true) {
            checkTouchZoomEnd(event);
        } else {
            checkTouchZoomStart(event);
        }
        if (g_temp.isZoomActive == true) {
            g_temp.isPanActive = false;
        } else if (isPanPosible(g_temp.objImage, event) == true && g_temp.isZoomedOnce == true) {
            startPan(event);
        }
    }
    function onTouchEnd(event) {
        if (g_parent.isCurrentSlideType("image") == false) return true;
        var objTarget = jQuery(event.target);
        if (objTarget.data("ug-button") == true) {
            return false;
        }
        var isStored = storeCurrentImage();
        if (g_temp.objImage == undefined || g_temp.objImage.length == 0) return true;
        var panWasActive = g_temp.isPanActive;
        var zoomWasActive = g_temp.isZoomActive;
        if (g_parent.isInnerInPlace() == false) {
            g_temp.isZoomActive = false;
            g_temp.isPanActive = false;
            return true;
        }
        if (g_temp.isZoomActive == true) {
            checkTouchZoomEnd(event);
        } else {
            checkTouchZoomStart(event);
        }
        if (g_temp.isZoomActive == true) {
            g_temp.isPanActive = false;
        } else {
            var panPosible = isPanPosible(g_temp.objImage, event, true);
            if (g_temp.isPanActive == true) {
                g_temp.isPanActive = false;
            } else if (panPosible == true) {
                startPan(event);
            }
        }
        if ((panWasActive || zoomWasActive) && g_temp.isZoomActive == false && g_temp.isPanActive == false) {
            checkReturnFromZoom();
        }
    }
    function onTouchMove(event) {
        if (g_parent.isCurrentSlideType("image") == false) return true;
        if (g_temp.isZoomActive == true) {
            doTouchZoom(event);
        } else if (g_temp.isPanActive == true) {
            panImage(event);
        }
    }
    function onSliderMouseWheel(event, delta, deltaX, deltaY) {
        if (g_options.slider_zoom_mousewheel == false) return true;
        if (g_parent.isCurrentSlideType("image") == false) return true;
        event.preventDefault();
        var zoomIn = delta > 0;
        var mousePos = g_functions.getMousePosition(event);
        var mode = zoomIn == true ? "in" : "out";
        zoomCurrentImage(mode, mousePos);
    }
    function initEvents() {
        g_objSlider.on("mousewheel", onSliderMouseWheel);
        g_objSlider.bind("mousedown touchstart", onTouchStart);
        jQuery("body").bind("mousemove touchmove", onTouchMove);
        jQuery(window).add("body").bind("mouseup touchend", onTouchEnd);
        g_objParent.bind(g_parent.events.BEFORE_RETURN, function() {
            checkReturnFromZoom();
        });
        g_objParent.bind(g_parent.events.ITEM_CHANGED, function() {
            g_temp.isZoomedOnce = false;
        });
        g_objParent.bind(g_parent.events.ZOOM_CHANGE, function() {
            g_temp.isZoomedOnce = true;
        });
    }
    this.________EXTERNAL_____________ = function() {};
    this.isPanEnabled = function(event, direction) {
        storeCurrentImage();
        if (g_temp.objImage == undefined || g_temp.objImage.length == 0) return false;
        if (g_temp.isZoomedOnce == false) return false;
        if (isPanPosible(g_temp.objImage, event) == false) return false;
        if (g_parent.isInnerInPlace() == false) return false;
        if (direction == "left") {
            if (g_temp.objImageSize.right <= g_temp.objParentSize.width) return false;
        } else {
            if (g_temp.objImageSize.left >= 0) return false;
        }
        return true;
    };
    this.init = function(objSlider, customOptions) {
        initObject(objSlider, customOptions);
    };
    this.zoomIn = function() {
        zoomCurrentImage("in");
    };
    this.zoomOut = function() {
        zoomCurrentImage("out");
    };
    this.zoomBack = function() {
        zoomCurrentImage("back");
    };
}

function UGWistiaAPI() {
    this.isAPILoaded = false;
    var t = this, g_objThis = jQuery(this), g_intHandle;
    var g_player, g_isPlayerReady = false;
    this.events = {
        START_PLAYING: "start_playing",
        STOP_PLAYING: "stop_playing",
        VIDEO_ENDED: "video_ended"
    };
    function isWistiaActive() {
        return typeof Wistia != "undefined";
    }
    this.loadAPI = function() {
        if (g_ugWistiaAPI.isAPILoaded == true) return true;
        if (isWistiaActive()) {
            g_ugWistiaAPI.isAPILoaded = true;
            return true;
        }
        g_ugFunctions.loadJs("fast.wistia.com/assets/external/E-v1.js", true);
        g_ugWistiaAPI.isAPILoaded = true;
    };
    function putVideoActually(divID, videoID, width, height, isAutoplay) {
        g_player = null;
        g_isPlayerReady = false;
        var htmlID = divID + "_video";
        var html = "<div id='" + htmlID + "' class='wistia_embed' style='width:" + width + ";height:" + height + ";' data-video-width='" + width + "' data-video-height='" + height + "'>&nbsp;</div>";
        jQuery("#" + divID).html(html);
        g_player = Wistia.embed(videoID, {
            version: "v1",
            videoWidth: width,
            videoHeight: height,
            container: htmlID,
            autoPlay: isAutoplay
        });
        g_isPlayerReady = true;
        initEvents();
    }
    function initEvents() {
        g_player.bind("play", function() {
            g_objThis.trigger(t.events.START_PLAYING);
        });
        g_player.bind("pause", function() {
            g_objThis.trigger(t.events.STOP_PLAYING);
        });
        g_player.bind("end", function() {
            g_objThis.trigger(t.events.STOP_PLAYING);
            g_objThis.trigger(t.events.VIDEO_ENDED);
        });
    }
    this.doCommand = function(command) {
        if (g_player == null) return false;
        if (g_isPlayerReady == false) return false;
        switch (command) {
          case "play":
            g_player.play();
            break;

          case "pause":
            g_player.pause();
            break;
        }
    };
    this.pause = function() {
        t.doCommand("pause");
    };
    this.play = function() {
        t.doCommand("play");
    };
    this.putVideo = function(divID, videoID, width, height, isAutoplay) {
        if (isWistiaActive()) {
            putVideoActually(divID, videoID, width, height, isAutoplay);
            return true;
        }
        this.loadAPI();
        g_intHandle = setInterval(function() {
            if (isWistiaActive()) {
                putVideoActually(divID, videoID, width, height, isAutoplay);
                clearInterval(g_intHandle);
            }
        }, 500);
    };
    this.isPlayerReady = function() {
        if (g_isPlayerReady && g_player) return true;
        return false;
    };
}

function UGSoundCloudAPI() {
    this.isAPILoaded = false;
    var t = this, g_objThis = jQuery(this), g_intHandle;
    var g_player, g_lastContainerID;
    this.events = {
        START_PLAYING: "start_playing",
        STOP_PLAYING: "stop_playing",
        VIDEO_ENDED: "video_ended"
    };
    function isSCActive() {
        return typeof SC != "undefined";
    }
    this.loadAPI = function() {
        if (g_ugSoundCloudAPI.isAPILoaded == true) return true;
        if (isSCActive()) {
            g_ugSoundCloudAPI.isAPILoaded = true;
            return true;
        }
        g_ugFunctions.loadJs("w.soundcloud.com/player/api.js", true);
        g_ugSoundCloudAPI.isAPILoaded = true;
    };
    function putSoundActually(divID, trackID, width, height, isAutoplay) {
        g_player = null;
        g_isPlayerReady = false;
        var iframeID = divID + "_iframe";
        var url = location.protocol + "//w.soundcloud.com/player/?url=http://api.soundcloud.com/tracks/" + trackID;
        url += "&amp;buying=false&amp;liking=false&amp;download=false&amp;sharing=false&amp;show_artwork=true&show_comments=false&amp;show_playcount=true&amp;show_user=false&amp;hide_related=true&amp;visual=true&amp;start_track=0&amp;callback=true";
        if (isAutoplay === true) url += "&amp;auto_play=true"; else url += "&amp;auto_play=false";
        var html = "<iframe id='" + iframeID + "' src=" + url + " width='" + width + "' height='" + height + "' frameborder='0' scrolling='no' webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>";
        jQuery("#" + divID).html(html);
        g_player = SC.Widget(iframeID);
        g_player.bind(SC.Widget.Events.READY, function() {
            if (g_player) {
                g_isPlayerReady = true;
                initEvents();
            }
        });
        g_lastContainerID = divID;
    }
    function initEvents() {
        g_player.bind(SC.Widget.Events.PLAY, function() {
            g_objThis.trigger(t.events.START_PLAYING);
        });
        g_player.bind(SC.Widget.Events.PAUSE, function() {
            g_objThis.trigger(t.events.STOP_PLAYING);
        });
        g_player.bind(SC.Widget.Events.FINISH, function() {
            g_objThis.trigger(t.events.STOP_PLAYING);
            g_objThis.trigger(t.events.VIDEO_ENDED);
        });
    }
    this.putSound = function(divID, trackID, width, height, isAutoplay) {
        if (isSCActive()) {
            putSoundActually(divID, trackID, width, height, isAutoplay);
            return true;
        }
        this.loadAPI();
        g_intHandle = setInterval(function() {
            if (isSCActive()) {
                putSoundActually(divID, trackID, width, height, isAutoplay);
                clearInterval(g_intHandle);
            }
        }, 500);
    };
    this.doCommand = function(command) {
        if (g_player == null) return false;
        if (g_isPlayerReady == false) return false;
        switch (command) {
          case "play":
            g_player.play();
            break;

          case "pause":
            g_player.pause();
            break;
        }
    };
    this.pause = function() {
        t.doCommand("pause");
    };
    this.play = function() {
        t.doCommand("play");
    };
    this.destroy = function() {
        g_isPlayerReady = false;
        g_player = null;
        if (g_lastContainerID) {
            jQuery("#" + g_lastContainerID).html("");
            g_lastContainerID = null;
        }
    };
}

function UGHtml5MediaAPI() {
    this.isAPILoaded = false;
    var t = this, g_objThis = jQuery(this), g_intHandle;
    var g_player;
    this.events = {
        START_PLAYING: "start_playing",
        STOP_PLAYING: "stop_playing",
        VIDEO_ENDED: "video_ended"
    };
    this.loadAPI = function() {
        if (g_ugHtml5MediaAPI.isAPILoaded == true) return true;
        if (isMediaElementActive()) {
            g_ugHtml5MediaAPI.isAPILoaded = true;
            return true;
        }
        g_ugFunctions.loadJs("cdnjs.cloudflare.com/ajax/libs/mediaelement/2.18.1/mediaelement.min.js", true);
        g_ugFunctions.loadCss("cdnjs.cloudflare.com/ajax/libs/mediaelement/2.18.1/mediaelementplayer.min.css", true);
        g_ugHtml5MediaAPI.isAPILoaded = true;
    };
    function isMediaElementActive() {
        return typeof mejs != "undefined";
    }
    function putVideoActually(divID, data, width, height, isAutoplay) {
        g_player = null;
        g_isPlayerReady = false;
        var urlFlash = location.protocol + "//cdnjs.cloudflare.com/ajax/libs/mediaelement/2.18.1/flashmediaelement-cdn.swf";
        var urlSilverlight = location.protocol + "//cdnjs.cloudflare.com/ajax/libs/mediaelement/2.18.1/silverlightmediaelement.xap";
        var htmlID = divID + "_video";
        var htmlAutoplay = "";
        if (isAutoplay && isAutoplay === true) htmlAutoplay = "autoplay='autoplay'";
        var htmlPoster = "";
        if (data.posterImage) htmlPoster = "poster='" + data.posterImage + "'";
        var html = "<video id='" + htmlID + "' width='" + width + "' height='" + height + "'  controls='controls' preload='none' " + htmlAutoplay + " " + htmlPoster + ">";
        if (data.mp4 != "") html += "<source type='video/mp4' src='" + data.mp4 + "' />";
        if (data.webm != "") html += "<source type='video/webm' src='" + data.webm + "' />";
        if (data.ogv != "") html += "<source type='video/ogg' src='" + data.ogv + "' />";
        html += "<object width='" + width + "' height='" + height + "' type='application/x-shockwave-flash' data='" + urlFlash + "'>";
        html += "<param name='movie' value='" + urlFlash + "' />";
        html += "<param name='flashvars' value='controls=true&file=" + data.mp4 + "' />";
        html += "</object>";
        html += "</video>";
        jQuery("#" + divID).html(html);
        new MediaElement(htmlID, {
            enablePluginDebug: false,
            flashName: urlFlash,
            silverlightName: urlSilverlight,
            success: function(mediaElement, domObject) {
                g_isPlayerReady = true;
                g_player = mediaElement;
                if (isAutoplay == false) g_player.pause();
                initEvents();
            },
            error: function(objError) {
                trace(objError);
            }
        });
    }
    function initEvents() {
        g_ugFunctions.addEvent(g_player, "play", function() {
            g_objThis.trigger(t.events.START_PLAYING);
        });
        g_ugFunctions.addEvent(g_player, "pause", function() {
            g_objThis.trigger(t.events.STOP_PLAYING);
        });
        g_ugFunctions.addEvent(g_player, "ended", function() {
            g_objThis.trigger(t.events.STOP_PLAYING);
            g_objThis.trigger(t.events.VIDEO_ENDED);
        });
    }
    this.putVideo = function(divID, data, width, height, isAutoplay) {
        if (isMediaElementActive()) {
            putVideoActually(divID, data, width, height, isAutoplay);
            return true;
        }
        this.loadAPI();
        g_intHandle = setInterval(function() {
            if (isMediaElementActive()) {
                putVideoActually(divID, data, width, height, isAutoplay);
                clearInterval(g_intHandle);
            }
        }, 500);
    };
    this.doCommand = function(command) {
        if (g_player == null) return false;
        if (g_isPlayerReady == false) return false;
        switch (command) {
          case "play":
            g_player.play();
            break;

          case "pause":
            g_player.pause();
            break;
        }
    };
    this.pause = function() {
        t.doCommand("pause");
    };
    this.play = function() {
        t.doCommand("play");
    };
}

function UGVimeoAPI() {
    this.isAPILoaded = false;
    var t = this, g_objThis = jQuery(this), g_intHandle;
    var g_player = null, g_isPlayerReady = false, g_lastCotnainerID, g_cueChangeAutoplay = false;
    this.events = {
        START_PLAYING: "start_playing",
        STOP_PLAYING: "stop_playing",
        VIDEO_ENDED: "video_ended"
    };
    this.loadAPI = function() {
        if (g_ugVimeoAPI.isAPILoaded == true) return true;
        if (isFroogaloopActive()) {
            g_ugVimeoAPI.isAPILoaded = true;
            return true;
        }
        g_ugFunctions.loadJs("f.vimeocdn.com/js/froogaloop2.min.js", true);
        g_ugVimeoAPI.isAPILoaded = true;
    };
    function isFroogaloopActive() {
        return typeof Froogaloop != "undefined";
    }
    function putVideoActually(divID, videoID, width, height, isAutoplay) {
        g_player = null;
        g_isPlayerReady = false;
        var url = location.protocol + "//player.vimeo.com/video/" + videoID + "?api=1";
        if (isAutoplay === true) url += "&amp;byline=0&amp;autoplay=1&amp;title=0&amp;portrait=0";
        var html = "<iframe src=" + url + " width='" + width + "' height='" + height + "' frameborder='0' webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>";
        jQuery("#" + divID).html(html);
        var iframe = jQuery("#" + divID + " iframe")[0];
        g_player = Froogaloop(iframe);
        g_player.addEvent("ready", function() {
            if (g_player) {
                g_isPlayerReady = true;
                initEvents();
            }
        });
        g_lastCotnainerID = divID;
    }
    function initEvents() {
        if (!g_player) return false;
        g_player.addEvent("cuechange", function() {
            if (g_cueChangeAutoplay == true) t.play();
        });
        g_player.addEvent("play", function() {
            g_objThis.trigger(t.events.START_PLAYING);
        });
        g_player.addEvent("pause", function() {
            g_objThis.trigger(t.events.STOP_PLAYING);
        });
        g_player.addEvent("finish", function() {
            g_objThis.trigger(t.events.STOP_PLAYING);
            g_objThis.trigger(t.events.VIDEO_ENDED);
        });
    }
    this.doCommand = function(command) {
        if (g_player == null) return false;
        if (g_isPlayerReady == false) return false;
        switch (command) {
          default:
            g_player.api(command);
            break;
        }
    };
    this.pause = function() {
        t.doCommand("pause");
    };
    this.play = function() {
        t.doCommand("play");
    };
    this.destroy = function() {
        if (g_player) {
            g_player.api("unload");
            g_player = null;
            g_isPlayerReady = false;
        }
        if (g_lastCotnainerID) {
            jQuery("#" + g_lastCotnainerID).html("");
        }
    };
    this.putVideo = function(divID, videoID, width, height, isAutoplay) {
        if (isFroogaloopActive()) {
            putVideoActually(divID, videoID, width, height, isAutoplay);
            return true;
        }
        this.loadAPI();
        g_intHandle = setInterval(function() {
            if (isFroogaloopActive()) {
                putVideoActually(divID, videoID, width, height, isAutoplay);
                clearInterval(g_intHandle);
            }
        }, 500);
    };
    this.isPlayerReady = function() {
        if (g_isPlayerReady && g_player) return true;
        return false;
    };
    this.changeVideo = function(videoID, isAutoplay) {
        if (t.isPlayerReady() == false) return false;
        g_cueChangeAutoplay = isAutoplay;
        g_player.api("loadVideo", videoID);
    };
    this.getVideoImages = function(videoID, itemIndex, onSuccessFunction) {
        var url = location.protocol + "//vimeo.com/api/v2/video/" + videoID + ".json";
        jQuery.get(url, {}, function(data) {
            var obj = {};
            obj.preview = data[0].thumbnail_large;
            obj.thumb = data[0].thumbnail_medium;
            onSuccessFunction(itemIndex, obj);
        });
    };
}

function UGYoutubeAPI() {
    this.isAPILoaded = false;
    var t = this, g_player = null, g_intHandle, g_isPlayerReady = false;
    var g_objThis = jQuery(this), g_prevState = -1, g_lastContainerID;
    var g_options = {
        video_youtube_showinfo: true
    };
    this.events = {
        START_PLAYING: "start_playing",
        STOP_PLAYING: "stop_playing",
        VIDEO_ENDED: "video_ended"
    };
    function putVideoActually(divID, videoID, width, height, isAutoplay) {
        if (g_player && g_isPlayerReady) {
            g_player.destroy();
        }
        var playerVars = {
            controls: 2,
            showinfo: g_options.video_youtube_showinfo,
            rel: 0
        };
        if (isAutoplay === true) playerVars.autoplay = 1;
        g_isPlayerReady = false;
        g_player = new YT.Player(divID, {
            height: height,
            width: width,
            videoId: videoID,
            playerVars: playerVars,
            events: {
                onReady: onPlayerReady,
                onStateChange: onPlayerStateChange
            }
        });
        g_lastContainerID = divID;
    }
    function isYTActive() {
        if (typeof YT != "undefined" && typeof YT.Player != "undefined") return true;
        return false;
    }
    this.setOptions = function(objOptions) {
        g_options = jQuery.extend(g_options, objOptions);
    };
    this.putVideo = function(divID, videoID, width, height, isAutoplay) {
        if (isYTActive()) {
            putVideoActually(divID, videoID, width, height, isAutoplay);
            return true;
        }
        this.loadAPI();
        g_intHandle = setInterval(function() {
            if (isYTActive()) {
                putVideoActually(divID, videoID, width, height, isAutoplay);
                clearInterval(g_intHandle);
            }
        }, 500);
    };
    function onPlayerReady() {
        g_isPlayerReady = true;
    }
    function onPlayerStateChange() {
        if (typeof g_player.getPlayerState != "function") {
            trace("Youtube API error: can't get player state");
            return false;
        }
        var state = g_player.getPlayerState();
        switch (state) {
          case YT.PlayerState.PLAYING:
            g_objThis.trigger(t.events.START_PLAYING);
            break;

          case YT.PlayerState.ENDED:
            g_objThis.trigger(t.events.STOP_PLAYING);
            g_objThis.trigger(t.events.VIDEO_ENDED);
            break;

          default:
            if (g_prevState == YT.PlayerState.PLAYING) g_objThis.trigger(t.events.STOP_PLAYING);
            break;
        }
        g_prevState = state;
    }
    this.loadAPI = function() {
        if (g_ugYoutubeAPI.isAPILoaded == true) return true;
        if (typeof YT != "undefined") {
            g_ugYoutubeAPI.isAPILoaded = true;
            return true;
        }
        g_ugFunctions.loadJs("https://www.youtube.com/player_api", false);
        g_ugYoutubeAPI.isAPILoaded = true;
    };
    this.doCommand = function(command, opt1) {
        if (!g_player) return true;
        if (g_isPlayerReady == false) return false;
        switch (command) {
          case "play":
            if (typeof g_player.playVideo != "function") return false;
            g_player.playVideo();
            break;

          case "pause":
            if (typeof g_player.pauseVideo != "function") return false;
            g_player.pauseVideo();
            break;

          case "seek":
            if (typeof g_player.seekTo != "function") return false;
            g_player.seekTo(opt1);
            break;

          case "stopToBeginning":
            var state = g_player.getPlayerState();
            g_player.pauseVideo();
            switch (state) {
              case YT.PlayerState.PLAYING:
              case YT.PlayerState.ENDED:
              case YT.PlayerState.PAUSED:
                g_player.seekTo(0);
                break;
            }
            break;
        }
    };
    this.play = function() {
        t.doCommand("play");
    };
    this.pause = function() {
        t.doCommand("pause");
    };
    this.destroy = function() {
        try {
            if (g_player) {
                g_isPlayerReady = false;
                g_player.clearVideo();
                g_player.destroy();
            }
        } catch (objError) {
            jQuery("#" + g_lastContainerID).html("");
        }
    };
    this.stopToBeginning = function() {
        t.doCommand("stopToBeginning");
    };
    this.changeVideo = function(videoID, isAutoplay) {
        if (t.isPlayerReady() == false) return false;
        if (isAutoplay && isAutoplay == true) g_player.loadVideoById(videoID, 0, "large"); else g_player.cueVideoById(videoID, 0, "large");
    };
    this.isPlayerReady = function() {
        if (g_isPlayerReady && g_player) return true;
        return false;
    };
    this.getVideoImages = function(videoID) {
        var obj = {};
        obj.preview = "https://i.ytimg.com/vi/" + videoID + "/sddefault.jpg";
        obj.thumb = "https://i.ytimg.com/vi/" + videoID + "/default.jpg";
        return obj;
    };
}

function UGVideoPlayer() {
    var t = this, g_galleryID, g_objThis = jQuery(this), g_functions = new UGFunctions();
    var g_youtubeAPI = new UGYoutubeAPI(), g_vimeoAPI = new UGVimeoAPI();
    var g_html5API = new UGHtml5MediaAPI(), g_soundCloudAPI = new UGSoundCloudAPI(), g_wistiaAPI = new UGWistiaAPI();
    var g_objPlayer, g_objYoutube, g_objVimeo, g_objHtml5, g_objButtonClose, g_objSoundCloud, g_objWistia;
    var g_activePlayerType = null;
    var g_options = {
        video_enable_closebutton: true
    };
    this.events = {
        SHOW: "video_show",
        HIDE: "video_hide",
        PLAY_START: "video_play_start",
        PLAY_STOP: "video_play_stop",
        VIDEO_ENDED: "video_ended"
    };
    var g_temp = {
        standAloneMode: false,
        youtubeInnerID: "",
        vimeoPlayerID: "",
        html5PlayerID: "",
        wistiaPlayerID: "",
        soundCloudPlayerID: ""
    };
    this.init = function(optOptions, isStandAloneMode, galleryID) {
        g_galleryID = galleryID;
        if (!g_galleryID) throw new Error("missing gallery ID for video player, it's a must!");
        g_options = jQuery.extend(g_options, optOptions);
        g_youtubeAPI.setOptions(g_options);
        if (isStandAloneMode && isStandAloneMode == true) g_temp.standAloneMode = true;
    };
    this.setHtml = function(objParent) {
        g_temp.youtubeInnerID = g_galleryID + "_youtube_inner";
        g_temp.vimeoPlayerID = g_galleryID + "_videoplayer_vimeo";
        g_temp.html5PlayerID = g_galleryID + "_videoplayer_html5";
        g_temp.wistiaPlayerID = g_galleryID + "_videoplayer_wistia";
        g_temp.soundCloudPlayerID = g_galleryID + "_videoplayer_soundcloud";
        var html = "<div class='ug-videoplayer' style='display:none'>";
        html += "<div class='ug-videoplayer-wrapper ug-videoplayer-youtube' style='display:none'><div id='" + g_temp.youtubeInnerID + "'></div></div>";
        html += "<div id='" + g_temp.vimeoPlayerID + "' class='ug-videoplayer-wrapper ug-videoplayer-vimeo' style='display:none'></div>";
        html += "<div id='" + g_temp.html5PlayerID + "' class='ug-videoplayer-wrapper ug-videoplayer-html5'></div>";
        html += "<div id='" + g_temp.soundCloudPlayerID + "' class='ug-videoplayer-wrapper ug-videoplayer-soundcloud'></div>";
        html += "<div id='" + g_temp.wistiaPlayerID + "' class='ug-videoplayer-wrapper ug-videoplayer-wistia'></div>";
        if (g_temp.standAloneMode == false && g_options.video_enable_closebutton == true) html += "<div class='ug-videoplayer-button-close'></div>";
        html += "</div>";
        objParent.append(html);
        g_objPlayer = objParent.children(".ug-videoplayer");
        g_objYoutube = g_objPlayer.children(".ug-videoplayer-youtube");
        g_objVimeo = g_objPlayer.children(".ug-videoplayer-vimeo");
        g_objHtml5 = g_objPlayer.children(".ug-videoplayer-html5");
        g_objSoundCloud = g_objPlayer.children(".ug-videoplayer-soundcloud");
        g_objWistia = g_objPlayer.children(".ug-videoplayer-wistia");
        if (g_temp.standAloneMode == false && g_options.video_enable_closebutton == true) g_objButtonClose = g_objPlayer.children(".ug-videoplayer-button-close");
    };
    function __________EVENTS___________() {}
    function onCloseButtonClick() {
        t.hide();
    }
    function onPlayStart() {
        g_objThis.trigger(t.events.PLAY_START);
        if (g_objButtonClose) g_objButtonClose.hide();
    }
    function onPlayStop() {
        g_objThis.trigger(t.events.PLAY_STOP);
        if (g_objButtonClose) g_objButtonClose.show();
    }
    function onVideoEnded() {
        g_objThis.trigger(t.events.VIDEO_ENDED);
    }
    function initEvents() {
        if (g_objButtonClose) {
            g_functions.setButtonMobileReady(g_objButtonClose);
            g_functions.setButtonOnClick(g_objButtonClose, onCloseButtonClick);
        }
        jQuery(g_youtubeAPI).on(g_youtubeAPI.events.START_PLAYING, onPlayStart);
        jQuery(g_youtubeAPI).on(g_youtubeAPI.events.STOP_PLAYING, onPlayStop);
        jQuery(g_youtubeAPI).on(g_youtubeAPI.events.VIDEO_ENDED, onVideoEnded);
        jQuery(g_vimeoAPI).on(g_vimeoAPI.events.START_PLAYING, onPlayStart);
        jQuery(g_vimeoAPI).on(g_vimeoAPI.events.STOP_PLAYING, onPlayStop);
        jQuery(g_vimeoAPI).on(g_vimeoAPI.events.VIDEO_ENDED, onVideoEnded);
        jQuery(g_html5API).on(g_html5API.events.START_PLAYING, onPlayStart);
        jQuery(g_html5API).on(g_html5API.events.STOP_PLAYING, onPlayStop);
        jQuery(g_html5API).on(g_html5API.events.VIDEO_ENDED, onVideoEnded);
        jQuery(g_soundCloudAPI).on(g_soundCloudAPI.events.START_PLAYING, onPlayStart);
        jQuery(g_soundCloudAPI).on(g_soundCloudAPI.events.STOP_PLAYING, onPlayStop);
        jQuery(g_soundCloudAPI).on(g_soundCloudAPI.events.VIDEO_ENDED, onVideoEnded);
        jQuery(g_wistiaAPI).on(g_wistiaAPI.events.START_PLAYING, onPlayStart);
        jQuery(g_wistiaAPI).on(g_wistiaAPI.events.STOP_PLAYING, onPlayStop);
        jQuery(g_wistiaAPI).on(g_wistiaAPI.events.VIDEO_ENDED, onVideoEnded);
    }
    this.destroy = function() {
        if (g_objButtonClose) {
            g_objButtonClose.off("click");
            g_objButtonClose.off("touchend");
        }
        jQuery(g_youtubeAPI).off(g_youtubeAPI.events.START_PLAYING);
        jQuery(g_youtubeAPI).off(g_youtubeAPI.events.STOP_PLAYING);
        jQuery(g_vimeoAPI).off(g_vimeoAPI.events.START_PLAYING);
        jQuery(g_vimeoAPI).off(g_vimeoAPI.events.STOP_PLAYING);
        jQuery(g_html5API).off(g_html5API.events.START_PLAYING);
        jQuery(g_html5API).off(g_html5API.events.STOP_PLAYING);
        jQuery(g_soundCloudAPI).off(g_soundCloudAPI.events.START_PLAYING, onPlayStart);
        jQuery(g_soundCloudAPI).off(g_soundCloudAPI.events.STOP_PLAYING, onPlayStop);
        jQuery(g_wistiaAPI).off(g_wistiaAPI.events.START_PLAYING, onPlayStart);
        jQuery(g_wistiaAPI).off(g_wistiaAPI.events.STOP_PLAYING, onPlayStop);
        g_activePlayerType = null;
    };
    this.initEvents = function() {
        initEvents();
    };
    this.setSize = function(width, height) {
        g_functions.setElementSize(g_objPlayer, width, height);
        if (g_objButtonClose) g_functions.placeElement(g_objButtonClose, "right", "top");
    };
    this.setPosition = function(left, top) {
        g_functions.placeElement(g_objPlayer, left, top);
    };
    this.getObject = function() {
        return g_objPlayer;
    };
    this.show = function() {
        if (t.isVisible() == true) return true;
        g_objPlayer.show();
        g_objPlayer.fadeTo(0, 1);
        if (g_objButtonClose) g_objButtonClose.show();
        g_objThis.trigger(t.events.SHOW);
    };
    this.hide = function() {
        if (t.isVisible() == false) return true;
        stopAndHidePlayers();
        g_activePlayerType = null;
        g_objPlayer.hide();
        g_objThis.trigger(t.events.HIDE);
    };
    this.getActiveAPI = function() {
        switch (g_activePlayerType) {
          case "youtube":
            return g_youtubeAPI;
            break;

          case "vimeo":
            return g_vimeoAPI;
            break;

          case "wistia":
            return g_wistiaAPI;
            break;

          case "soundcloud":
            return g_soundCloudAPI;
            break;

          case "html5":
            return g_html5API;
            break;

          default:
            return null;
            break;
        }
    };
    this.pause = function() {
        var activeAPI = t.getActiveAPI();
        if (activeAPI == null) return false;
        if (typeof activeAPI.pause == "function") activeAPI.pause();
    };
    this.isVisible = function() {
        return g_objPlayer.is(":visible");
    };
    function stopAndHidePlayers(except) {
        var arrPlayers = [ "youtube", "vimeo", "html5", "soundcloud", "wistia" ];
        for (var index in arrPlayers) {
            var player = arrPlayers[index];
            if (player == except) continue;
            switch (player) {
              case "youtube":
                g_youtubeAPI.pause();
                g_youtubeAPI.destroy();
                g_objYoutube.hide();
                break;

              case "vimeo":
                g_vimeoAPI.pause();
                g_vimeoAPI.destroy();
                g_objVimeo.hide();
                break;

              case "html5":
                g_html5API.pause();
                g_objHtml5.hide();
                break;

              case "soundcloud":
                g_soundCloudAPI.pause();
                g_soundCloudAPI.destroy();
                g_objSoundCloud.hide();
                break;

              case "wistia":
                g_wistiaAPI.pause();
                g_objWistia.hide();
                break;
            }
        }
    }
    this.playYoutube = function(videoID, isAutoplay) {
        if (typeof isAutoplay == "undefined") var isAutoplay = true;
        stopAndHidePlayers("youtube");
        g_objYoutube.show();
        var objYoutubeInner = g_objYoutube.children("#" + g_temp.youtubeInnerID);
        if (objYoutubeInner.length == 0) g_objYoutube.append("<div id='" + g_temp.youtubeInnerID + "'></div>");
        if (g_youtubeAPI.isPlayerReady() == true && g_temp.standAloneMode == true) g_youtubeAPI.changeVideo(videoID, isAutoplay); else {
            g_youtubeAPI.putVideo(g_temp.youtubeInnerID, videoID, "100%", "100%", isAutoplay);
        }
        g_activePlayerType = "youtube";
    };
    this.playVimeo = function(videoID, isAutoplay) {
        if (typeof isAutoplay == "undefined") var isAutoplay = true;
        stopAndHidePlayers("vimeo");
        g_objVimeo.show();
        g_vimeoAPI.putVideo(g_temp.vimeoPlayerID, videoID, "100%", "100%", isAutoplay);
        g_activePlayerType = "vimeo";
    };
    this.playHtml5Video = function(ogv, webm, mp4, posterImage, isAutoplay) {
        if (typeof isAutoplay == "undefined") var isAutoplay = true;
        stopAndHidePlayers("html5");
        g_objHtml5.show();
        var data = {
            ogv: ogv,
            webm: webm,
            mp4: mp4,
            posterImage: posterImage
        };
        g_html5API.putVideo(g_temp.html5PlayerID, data, "100%", "100%", isAutoplay);
        g_activePlayerType = "html5";
    };
    this.playSoundCloud = function(trackID, isAutoplay) {
        if (typeof isAutoplay == "undefined") var isAutoplay = true;
        stopAndHidePlayers("soundcloud");
        g_objSoundCloud.show();
        g_soundCloudAPI.putSound(g_temp.soundCloudPlayerID, trackID, "100%", "100%", isAutoplay);
        g_activePlayerType = "soundcloud";
    };
    this.playWistia = function(videoID, isAutoplay) {
        if (typeof isAutoplay == "undefined") var isAutoplay = true;
        stopAndHidePlayers("wistia");
        g_objWistia.show();
        g_wistiaAPI.putVideo(g_temp.wistiaPlayerID, videoID, "100%", "100%", isAutoplay);
        g_activePlayerType = "wistia";
    };
}

var g_ugYoutubeAPI = new UGYoutubeAPI();

var g_ugVimeoAPI = new UGVimeoAPI();

var g_ugHtml5MediaAPI = new UGHtml5MediaAPI();

var g_ugSoundCloudAPI = new UGSoundCloudAPI();

var g_ugWistiaAPI = new UGWistiaAPI();

jQuery.fn.unitegallery = function(options) {
    var element = jQuery(this);
    var galleryID = "#" + element.attr("id");
    if (!options) var options = {};
    var objGallery = new UniteGalleryMain();
    objGallery.run(galleryID, options);
    var api = new UG_API(objGallery);
    return api;
};

function ugCheckForMinJQueryVersion() {
    var isMinJQuery = g_ugFunctions.checkMinJqueryVersion("1.8.0");
    if (isMinJQuery == false) throw new Error("The gallery can run from jquery 1.8 You have jQuery " + jQuery.fn.jquery + " Please update your jQuery library.");
}

function ugCheckForErrors(galleryID, type) {
    function checkForJqueryPresents() {
        if (typeof jQuery == "undefined") throw new Error("jQuery library not included");
    }
    function checkForDoubleJQuery() {
        if (typeof jQuery.fn.unitegallery == "function") return true;
        var errorMessage = "You have some jquery.js library include that comes after the gallery files js include.";
        errorMessage += "<br> This include eliminates the gallery libraries, and make it not work.";
        if (type == "cms") {
            errorMessage += "<br><br> To fix it you can:<br>&nbsp;&nbsp;&nbsp; 1. In the Gallery Settings -> Troubleshooting set option:  <strong><b>Put JS Includes To Body</b></strong> option to true.";
            errorMessage += "<br>&nbsp;&nbsp;&nbsp; 2. Find the double jquery.js include and remove it.";
        } else {
            errorMessage += "<br><br> Please find and remove this jquery.js include and the gallery will work. <br> * There should be only one jquery.js include before all other js includes in the page.";
        }
        throw new Error(errorMessage);
    }
    try {
        if (type == "jquery") {
            checkForJqueryPresents();
            ugCheckForMinJQueryVersion();
        } else {
            ugCheckForMinJQueryVersion();
            checkForDoubleJQuery();
        }
    } catch (objError) {
        var message = objError.message;
        message = "Unite Gallery Error: " + message;
        message = "<div style='font-size:16px;color:#BC0C06;max-width:900px;border:1px solid red;padding:10px;'>" + message + "</div>";
        if (type == "jquery") {
            var objGallery = document.getElementById(galleryID);
            objGallery.innerHTML = message;
            objGallery.style.display = "block";
        } else jQuery(galleryID).show().html(message);
        return false;
    }
    return true;
}

function UniteGalleryMain() {
    var t = this;
    var g_galleryID;
    var g_objGallery = jQuery(t), g_objWrapper, g_objParent;
    var g_objThumbs, g_objSlider, g_functions = new UGFunctions(), g_objTabs, g_objLoadMore;
    var g_arrItems = [], g_numItems, g_selectedItem = null, g_selectedItemIndex = -1;
    var g_objTheme, g_objCache = {};
    this.events = {
        ITEM_CHANGE: "item_change",
        SIZE_CHANGE: "size_change",
        ENTER_FULLSCREEN: "enter_fullscreen",
        EXIT_FULLSCREEN: "exit_fullscreen",
        START_PLAY: "start_play",
        STOP_PLAY: "stop_play",
        PAUSE_PLAYING: "pause_playing",
        CONTINUE_PLAYING: "continue_playing",
        SLIDER_ACTION_START: "slider_action_start",
        SLIDER_ACTION_END: "slider_action_end",
        ITEM_IMAGE_UPDATED: "item_image_updated",
        GALLERY_KEYPRESS: "gallery_keypress",
        GALLERY_BEFORE_REQUEST_ITEMS: "gallery_before_request_items",
        OPEN_LIGHTBOX: "open_lightbox",
        CLOSE_LIGHTBOX: "close_lightbox"
    };
    var g_options = {
        gallery_width: 900,
        gallery_height: 500,
        gallery_min_width: 150,
        gallery_min_height: 100,
        gallery_theme: "default",
        gallery_skin: "default",
        gallery_images_preload_type: "minimal",
        gallery_autoplay: false,
        gallery_play_interval: 3e3,
        gallery_pause_on_mouseover: true,
        gallery_mousewheel_role: "zoom",
        gallery_control_keyboard: true,
        gallery_carousel: true,
        gallery_preserve_ratio: true,
        gallery_background_color: "",
        gallery_debug_errors: false,
        gallery_shuffle: false,
        gallery_urlajax: null,
        gallery_enable_tabs: false,
        gallery_enable_loadmore: false,
        gallery_enable_cache: true,
        gallery_initial_catid: ""
    };
    var g_temp = {
        objCustomOptions: {},
        isAllItemsPreloaded: false,
        isFreestyleMode: false,
        lastWidth: 0,
        lastHeigh: 0,
        handleResize: null,
        isInited: false,
        isPlayMode: false,
        isPlayModePaused: false,
        playTimePassed: 0,
        playTimeLastStep: 0,
        playHandle: "",
        playStepInterval: 33,
        objProgress: null,
        isFakeFullscreen: false,
        thumbsType: null,
        isYoutubePresent: false,
        isVimeoPresent: false,
        isHtml5VideoPresent: false,
        isSoundCloudPresent: false,
        isWistiaPresent: false,
        resizeDelay: 100,
        isRunFirstTime: true,
        originalOptions: {},
        funcCustomHeight: null
    };
    function __________INIT_GALLERY_______() {}
    function getThemeFunction(themeName) {
        var themeFunction = themeName;
        if (themeFunction.indexOf("UGTheme_") == -1) themeFunction = "UGTheme_" + themeFunction;
        return themeFunction;
    }
    function initTheme(objCustomOptions) {
        if (objCustomOptions.hasOwnProperty("gallery_theme")) g_options.gallery_theme = objCustomOptions.gallery_theme; else {
            var defaultTheme = g_options.gallery_theme;
            if (g_ugFunctions.isThemeRegistered(defaultTheme) == false) g_options.gallery_theme = g_ugFunctions.getFirstRegisteredTheme();
        }
        var themeFunction = getThemeFunction(g_options.gallery_theme);
        try {
            g_options.gallery_theme = eval(themeFunction);
        } catch (e) {}
        g_options.gallery_theme = eval(themeFunction);
        g_objTheme = new g_options.gallery_theme();
        g_objTheme.init(t, objCustomOptions);
    }
    function resetOptions() {
        g_options = jQuery.extend({}, g_temp.originalOptions);
        g_selectedItemIndex = -1;
        g_selectedItem = null;
        g_objSlider = undefined;
        g_objThumbs = undefined;
        g_objSlider = undefined;
    }
    function checkForStartupErrors() {
        try {
            ugCheckForMinJQueryVersion();
        } catch (e) {
            throwErrorShowMessage(e.message);
        }
        if (typeof g_objWrapper.outerWidth() == "object") throwErrorShowMessage("You have some buggy script. most chances jquery-ui.js that destroy jquery outerWidth, outerHeight functions. The gallery can't run. Please update jquery-ui.js to latest version.");
        setTimeout(function() {
            ugCheckForErrors(g_galleryID, "cms");
        }, 5e3);
    }
    function runGallery(galleryID, objCustomOptions, htmlItems, cacheID) {
        var isCustomOptions = typeof objCustomOptions == "object";
        if (isCustomOptions) g_temp.objCustomOptions = objCustomOptions;
        if (g_temp.isRunFirstTime == true) {
            g_galleryID = galleryID;
            g_objWrapper = jQuery(g_galleryID);
            if (g_objWrapper.length == 0) {
                trace("div with id: " + g_galleryID + " not found");
                return false;
            }
            g_objParent = g_objWrapper.parent();
            checkForStartupErrors();
            g_temp.originalOptions = jQuery.extend({}, g_options);
            if (isCustomOptions) g_options = jQuery.extend(g_options, objCustomOptions);
            if (g_options.gallery_enable_cache == true && g_options.gallery_initial_catid) cacheItems(g_options.gallery_initial_catid);
            t.setSizeClass();
            var objItems = g_objWrapper.children();
            fillItemsArray(objItems);
            loadAPIs();
            g_objWrapper.find("img").fadeTo(0, 0).hide();
            g_objWrapper.show();
            clearInitData();
        } else {
            t.destroy();
            resetOptions();
            g_options = jQuery.extend(g_options, g_temp.objCustomOptions);
            if (htmlItems) {
                if (cacheID && g_options.gallery_enable_cache == true) cacheItems(cacheID, htmlItems);
                if (htmlItems == "noitems") {
                    showErrorMessage("No items in this category", "");
                    return false;
                }
                g_objWrapper.html(htmlItems);
                var objItems = g_objWrapper.children();
                fillItemsArray(objItems);
                loadAPIs();
                g_objWrapper.children().fadeTo(0, 0).hide();
                g_objWrapper.show();
                clearInitData();
            }
        }
        if (g_temp.isRunFirstTime == true && g_options.gallery_enable_tabs == true) {
            g_objTabs = new UGTabs();
            g_objTabs.init(t, g_options);
        }
        if (g_temp.isRunFirstTime == true && g_options.gallery_enable_loadmore == true) {
            g_objLoadMore = new UGLoadMore();
            g_objLoadMore.init(t, g_options);
        }
        if (isCustomOptions) modifyInitParams(g_temp.objCustomOptions);
        validateParams();
        if (g_options.gallery_shuffle == true) t.shuffleItems();
        initTheme(g_temp.objCustomOptions);
        setGalleryHtml();
        setHtmlObjectsProperties();
        var galleryWidth = g_objWrapper.width();
        if (galleryWidth == 0) {
            g_functions.waitForWidth(g_objWrapper, runGalleryActually);
        } else runGalleryActually();
    }
    function runGalleryActually() {
        t.setSizeClass();
        if (g_temp.isFreestyleMode == false) {
            if (g_options.gallery_preserve_ratio == true) setHeightByOriginalRatio();
        }
        g_objTheme.run();
        if (g_objTabs && g_temp.isRunFirstTime) g_objTabs.run();
        preloadBigImages();
        initEvents();
        if (g_numItems > 0) t.selectItem(0);
        if (g_options.gallery_autoplay == true) t.startPlayMode();
        g_temp.isRunFirstTime = false;
    }
    function showErrorMessage(message, prefix) {
        if (typeof prefix == "undefined") var prefix = "<b>Unite Gallery Error: </b>"; else prefix = "<b>" + prefix + ": </b>";
        message = prefix + message;
        var html = "<div class='ug-error-message-wrapper'><div class='ug-error-message'>" + message + "</div></div>";
        g_objWrapper.children().remove();
        g_objWrapper.html(html);
        g_objWrapper.show();
    }
    function throwErrorShowMessage(message) {
        showErrorMessage(message);
        throw new Error(message);
    }
    function modifyInitParams() {
        if (!g_options.gallery_images_preload_type) g_options.gallery_images_preload_type = "minimal";
        if (g_options.gallery_min_height == undefined || g_options.gallery_height < g_options.gallery_min_height) {
            g_options.gallery_min_height = 0;
        }
        if (g_options.gallery_min_width == undefined || g_options.gallery_width < g_options.gallery_min_width) {
            g_options.gallery_min_width = 0;
        }
    }
    function validateParams() {
        if (!g_options.gallery_theme) throw new Error("The gallery can't run without theme");
        if (jQuery.isNumeric(g_options.gallery_height) && g_options.gallery_height < g_options.gallery_min_height) throw new Error("The <b>gallery_height</b> option must be bigger then <b>gallery_min_height option</b>");
        if (g_options.gallery_width < g_options.gallery_min_width) throw new Error("The <b>gallery_width</b> option must be bigger then <b>gallery_min_width option</b>");
    }
    function setGalleryHtml() {
        g_objWrapper.addClass("ug-gallery-wrapper");
        g_objWrapper.append("<div class='ug-overlay-disabled' style='display:none'></div>");
        t.setSizeClass();
    }
    function clearInitData() {
        var objItems = g_objWrapper.children().remove();
    }
    function storeLastSize() {
        var objSize = t.getSize();
        g_temp.lastWidth = objSize.width;
        g_temp.lastHeight = objSize.height;
    }
    function setHeightByOriginalRatio() {
        var objSize = t.getSize();
        var ratio = objSize.width / objSize.height;
        if (ratio != objSize.orig_ratio) {
            var newHeight = objSize.width / objSize.orig_ratio;
            newHeight = Math.round(newHeight);
            if (newHeight < g_options.gallery_min_height) newHeight = g_options.gallery_min_height;
            g_objWrapper.height(newHeight);
        }
    }
    function setHtmlObjectsProperties() {
        var optionWidth = g_functions.getCssSizeParam(g_options.gallery_width);
        var objCss = {
            "max-width": optionWidth,
            "min-width": g_functions.getCssSizeParam(g_options.gallery_min_width)
        };
        if (g_temp.isFreestyleMode == false) {
            var galleryHeight = g_functions.getCssSizeParam(g_options.gallery_height);
            objCss["height"] = galleryHeight;
        } else {
            objCss["overflow"] = "visible";
        }
        if (g_options.gallery_background_color) objCss["background-color"] = g_options.gallery_background_color;
        g_objWrapper.css(objCss);
    }
    function fillItemByChild(objChild) {
        var isMobile = t.isMobileMode();
        var tagname = objChild.prop("tagName").toLowerCase();
        var itemLink = "";
        if (tagname == "a") {
            itemLink = objChild.attr("href");
            objChild = objChild.children();
            var tagname = objChild.prop("tagName").toLowerCase();
        }
        var itemType = objChild.data("type");
        if (itemType == undefined) itemType = "image";
        var objItem = {};
        objItem.type = itemType;
        if (tagname == "img") {
            var lasyLoadSrc = objChild.data("lazyload-src");
            if (lasyLoadSrc && lasyLoadSrc != "") {
                objChild.attr("src", lasyLoadSrc);
                jQuery.removeData(objChild, "lazyload-src");
            }
            var urlImage = objChild.data("image");
            var urlThumb = objChild.data("thumb");
            if (typeof urlImage == "undefined") urlImage = null;
            if (typeof urlThumb == "undefined") urlThumb = null;
            var imageSrc = objChild.attr("src");
            if (!urlImage) urlImage = imageSrc;
            if (!urlThumb) urlThumb = imageSrc;
            if (!urlThumb) urlThumb = urlImage;
            if (!urlImage) urlImage = urlThumb;
            objItem.urlThumb = urlThumb;
            objItem.urlImage = urlImage;
            objItem.title = objChild.attr("alt");
            objItem.objThumbImage = objChild;
            objItem.objThumbImage.attr("src", objItem.urlThumb);
        } else {
            if (itemType == "image") {
                trace("Problematic gallery item found:");
                trace(objChild);
                trace("Please look for some third party js script that could add this item to the gallery");
                throw new Error("The item should not be image type");
            }
            objItem.urlThumb = objChild.data("thumb");
            objItem.title = objChild.data("title");
            objItem.objThumbImage = null;
            objItem.urlImage = objChild.data("image");
        }
        if (isMobile == true) {
            var urlThumbMobile = objChild.data("thumb-mobile");
            if (typeof urlThumbMobile != "undefined" && urlThumbMobile != "") {
                objItem.urlThumb = urlThumbMobile;
                if (tagname == "img") objChild.attr("src", objItem.urlThumb);
            }
            var urlImageMobile = objChild.data("image-mobile");
            if (typeof urlImageMobile != "undefined" && urlImageMobile != "") objItem.urlImage = urlImageMobile;
        }
        objItem.link = itemLink;
        objItem.description = objChild.attr("title");
        if (!objItem.description) objItem.description = objChild.data("description");
        if (!objItem.description) objItem.description = "";
        objItem.isNewAdded = false;
        objItem.isLoaded = false;
        objItem.isThumbImageLoaded = false;
        objItem.objPreloadImage = null;
        objItem.isBigImageLoadStarted = false;
        objItem.isBigImageLoaded = false;
        objItem.isBigImageLoadError = false;
        objItem.imageWidth = 0;
        objItem.imageHeight = 0;
        objItem.thumbWidth = 0;
        objItem.thumbHeight = 0;
        objItem.thumbRatioByWidth = 0;
        objItem.thumbRatioByHeight = 0;
        var dataWidth = objChild.data("width");
        var dataHeight = objChild.data("height");
        if (dataWidth && typeof dataWidth == "number" && dataHeight && typeof dataHeight == "number") {
            objItem.thumbWidth = dataWidth;
            objItem.thumbHeight = dataHeight;
            objItem.thumbRatioByWidth = dataWidth / dataHeight;
            objItem.thumbRatioByHeight = dataHeight / dataWidth;
        }
        objItem.addHtml = null;
        var isImageMissing = objItem.urlImage == undefined || objItem.urlImage == "";
        var isThumbMissing = objItem.urlThumb == undefined || objItem.urlThumb == "";
        switch (objItem.type) {
          case "youtube":
            objItem.videoid = objChild.data("videoid");
            if (isImageMissing || isThumbMissing) {
                var objImages = g_ugYoutubeAPI.getVideoImages(objItem.videoid);
                if (isImageMissing) objItem.urlImage = objImages.preview;
                if (isThumbMissing) {
                    objItem.urlThumb = objImages.thumb;
                    if (tagname == "img") objChild.attr("src", objItem.urlThumb);
                }
            }
            g_temp.isYoutubePresent = true;
            break;

          case "vimeo":
            objItem.videoid = objChild.data("videoid");
            g_temp.isVimeoPresent = true;
            break;

          case "html5video":
            objItem.videoogv = objChild.data("videoogv");
            objItem.videowebm = objChild.data("videowebm");
            objItem.videomp4 = objChild.data("videomp4");
            g_temp.isHtml5VideoPresent = true;
            break;

          case "soundcloud":
            objItem.trackid = objChild.data("trackid");
            g_temp.isSoundCloudPresent = true;
            break;

          case "wistia":
            objItem.videoid = objChild.data("videoid");
            g_temp.isWistiaPresent = true;
            break;

          case "custom":
            var objChildImage = objChild.children("img");
            if (objChildImage.length) {
                objChildImage = jQuery(objChildImage[0]);
                objItem.urlThumb = objChildImage.attr("src");
                objItem.title = objChildImage.attr("alt");
                objItem.objThumbImage = objChildImage;
            }
            var objChildren = objChild.children().not("img:first-child");
            if (objChildren.length) objItem.addHtml = objChildren.clone();
            break;
        }
        if (objItem.objThumbImage) {
            objItem.objThumbImage.removeAttr("data-description", "");
            objItem.objThumbImage.removeAttr("data-image", "");
            objItem.objThumbImage.removeAttr("data-thumb", "");
            objItem.objThumbImage.removeAttr("title", "");
        }
        return objItem;
    }
    function fillItemsArray(arrChildren, isAppend) {
        if (isAppend !== true) {
            g_arrItems = [];
        } else {
            for (var i = 0; i < g_numItems; i++) g_arrItems[i].isNewAdded = false;
        }
        for (var i = 0; i < arrChildren.length; i++) {
            var objChild = jQuery(arrChildren[i]);
            var objItem = fillItemByChild(objChild);
            numIndex = g_arrItems.length;
            objItem.index = numIndex;
            if (isAppend === true) {
                objItem.isNewAdded = true;
            }
            g_arrItems.push(objItem);
        }
        g_numItems = g_arrItems.length;
    }
    function loadAPIs() {
        if (g_temp.isYoutubePresent) g_ugYoutubeAPI.loadAPI();
        if (g_temp.isVimeoPresent) g_ugVimeoAPI.loadAPI();
        if (g_temp.isHtml5VideoPresent) g_ugHtml5MediaAPI.loadAPI();
        if (g_temp.isSoundCloudPresent) g_ugSoundCloudAPI.loadAPI();
        if (g_temp.isWistiaPresent) g_ugWistiaAPI.loadAPI();
    }
    function preloadBigImages() {
        if (g_options.gallery_images_preload_type == "visible" && !g_objThumbs) g_options.gallery_images_preload_type = "minimal";
        if (g_temp.isAllItemsPreloaded == true) return true;
        switch (g_options.gallery_images_preload_type) {
          default:
          case "minimal":
            break;

          case "all":
            jQuery(g_arrItems).each(function() {
                preloadItemImage(this);
            });
            break;

          case "visible":
            jQuery(g_arrItems).each(function() {
                var objItem = this;
                var isVisible = g_objThumbs.isItemThumbVisible(objItem);
                if (isVisible == true) preloadItemImage(objItem);
            });
            break;
        }
    }
    function checkPreloadItemImage(objItem) {
        if (objItem.isBigImageLoadStarted == true || objItem.isBigImageLoaded == true || objItem.isBigImageLoadError == true) {
            return false;
        }
        switch (g_options.gallery_images_preload_type) {
          default:
          case "minimal":
            break;

          case "all":
            preloadItemImage(objItem);
            break;

          case "visible":
            var isVisible = g_objThumbs.isItemThumbVisible(objItem);
            if (isVisible == true) preloadItemImage(objItem);
            break;
        }
    }
    function preloadItemImage(objItem) {
        if (objItem.isBigImageLoadStarted == true || objItem.isBigImageLoaded == true || objItem.isBigImageLoadError == true) {
            return true;
        }
        var imageUrl = objItem.urlImage;
        if (imageUrl == "" || imageUrl == undefined) {
            objItem.isBigImageLoadError = true;
            return false;
        }
        objItem.isBigImageLoadStarted = true;
        objItem.objPreloadImage = jQuery("<img/>").attr("src", imageUrl);
        objItem.objPreloadImage.data("itemIndex", objItem.index);
        objItem.objPreloadImage.on("load", t.onItemBigImageLoaded);
        objItem.objPreloadImage.on("error", function() {
            var objImage = jQuery(this);
            var itemIndex = objImage.data("itemIndex");
            var objItem = g_arrItems[itemIndex];
            objItem.isBigImageLoadError = true;
            objItem.isBigImageLoaded = false;
            var imageUrl = jQuery(this).attr("src");
            console.log("Can't load image: " + imageUrl);
            g_objGallery.trigger(t.events.ITEM_IMAGE_UPDATED, [ itemIndex, objItem.urlImage ]);
            objItem.objThumbImage.attr("src", objItem.urlThumb);
        });
        checkAllItemsStartedPreloading();
    }
    this.onItemBigImageLoaded = function(event, objImage) {
        if (!objImage) var objImage = jQuery(this);
        var itemIndex = objImage.data("itemIndex");
        var objItem = g_arrItems[itemIndex];
        objItem.isBigImageLoaded = true;
        var objSize = g_functions.getImageOriginalSize(objImage);
        objItem.imageWidth = objSize.width;
        objItem.imageHeight = objSize.height;
    };
    this.checkFillImageSize = function(objImage, objItem) {
        if (!objItem) {
            var itemIndex = objImage.data("itemIndex");
            if (itemIndex === undefined) throw new Error("Wrong image given to gallery.checkFillImageSize");
            var objItem = g_arrItems[itemIndex];
        }
        var objSize = g_functions.getImageOriginalSize(objImage);
        objItem.imageWidth = objSize.width;
        objItem.imageHeight = objSize.height;
    };
    function preloadNearBigImages(objItem) {
        if (g_temp.isAllItemsPreloaded == true) return false;
        if (!objItem) var objItem = g_selectedItem;
        if (!objItem) return true;
        var currentIndex = objItem.index;
        var lastItemIndex = currentIndex - 1;
        var nextItemIndex = currentIndex + 1;
        if (lastItemIndex > 0) preloadItemImage(g_arrItems[lastItemIndex]);
        if (nextItemIndex < g_numItems) preloadItemImage(g_arrItems[nextItemIndex]);
    }
    function checkAllItemsStartedPreloading() {
        if (g_temp.isAllItemsPreloaded == true) return false;
        for (var index in g_arrItems) {
            if (g_arrItems[index].isBigImageLoadStarted == false) return false;
        }
        g_temp.isAllItemsPreloaded = true;
    }
    this.setFreestyleMode = function() {
        g_temp.isFreestyleMode = true;
    };
    this.attachThumbsPanel = function(type, objThumbs) {
        g_temp.thumbsType = type;
        g_objThumbs = objThumbs;
    };
    this.initSlider = function(customOptions, optionsPrefix) {
        if (!customOptions) var customOptions = {};
        customOptions = jQuery.extend(g_temp.objCustomOptions, customOptions);
        g_objSlider = new UGSlider();
        g_objSlider.init(t, customOptions, optionsPrefix);
    };
    function __________END_INIT_GALLERY_______() {}
    function __________EVENTS_____________() {}
    this.onGalleryMouseWheel = function(event, delta, deltaX, deltaY) {
        event.preventDefault();
        if (delta > 0) t.prevItem(); else t.nextItem();
    };
    function onSliderMouseEnter(event) {
        if (g_options.gallery_pause_on_mouseover == true && t.isFullScreen() == false && g_temp.isPlayMode == true && g_objSlider && g_objSlider.isSlideActionActive() == false) t.pausePlaying();
    }
    function onSliderMouseLeave(event) {
        if (g_options.gallery_pause_on_mouseover == true && g_temp.isPlayMode == true && g_objSlider && g_objSlider.isSlideActionActive() == false) {
            var isStillLoading = g_objSlider.isCurrentSlideLoadingImage();
            if (isStillLoading == false) t.continuePlaying();
        }
    }
    function onKeyPress(event) {
        var obj = jQuery(event.target);
        if (obj.is("textarea") || obj.is("select") || obj.is("input")) return true;
        var keyCode = event.charCode ? event.charCode : event.keyCode ? event.keyCode : event.which ? event.which : 0;
        var wasAction = true;
        switch (keyCode) {
          case 39:
            t.nextItem();
            break;

          case 37:
            t.prevItem();
            break;

          default:
            wasAction = false;
            break;
        }
        if (wasAction == true) {
            event.preventDefault();
            event.stopPropagation();
            event.stopImmediatePropagation();
        }
        g_objGallery.trigger(t.events.GALLERY_KEYPRESS, [ keyCode, event ]);
    }
    function onGalleryResized() {
        var objSize = t.getSize();
        if (objSize.width == 0) return true;
        t.setSizeClass();
        var objSize = t.getSize();
        if (objSize.width != g_temp.lastWidth || g_temp.isFreestyleMode == false && objSize.height != g_temp.lastHeight) {
            var heightWasSet = false;
            if (g_temp.funcCustomHeight) {
                var newHeight = g_temp.funcCustomHeight(objSize);
                if (newHeight) {
                    g_objWrapper.height(newHeight);
                    heightWasSet = true;
                }
            }
            if (heightWasSet == false && g_options.gallery_preserve_ratio == true && g_temp.isFreestyleMode == false) setHeightByOriginalRatio();
            storeLastSize();
            g_objGallery.trigger(t.events.SIZE_CHANGE);
        }
    }
    function onThumbsChange(event) {
        if (g_options.gallery_images_preload_type == "visible" && g_temp.isAllItemsPreloaded == false) {
            preloadBigImages();
        }
    }
    function onFullScreenChange() {
        var isFullscreen = g_functions.isFullScreen();
        var event = isFullscreen ? t.events.ENTER_FULLSCREEN : t.events.EXIT_FULLSCREEN;
        var fullscreenID = g_functions.getGlobalData("fullscreenID");
        if (g_galleryID !== fullscreenID) return true;
        if (isFullscreen) {
            g_objWrapper.addClass("ug-fullscreen");
        } else {
            g_objWrapper.removeClass("ug-fullscreen");
        }
        g_objGallery.trigger(event);
        onGalleryResized();
    }
    function onItemImageUpdated(event, index) {
        var objItem = t.getItem(index);
        checkPreloadItemImage(objItem);
    }
    function onCurrentSlideImageLoadEnd() {
        if (t.isPlayMode() == true) t.continuePlaying();
    }
    function initEvents() {
        g_objWrapper.on("dragstart", function(event) {
            event.preventDefault();
        });
        g_objGallery.on(t.events.ITEM_IMAGE_UPDATED, onItemImageUpdated);
        if (g_objThumbs) {
            switch (g_temp.thumbsType) {
              case "strip":
                jQuery(g_objThumbs).on(g_objThumbs.events.STRIP_MOVE, onThumbsChange);
                break;

              case "grid":
                jQuery(g_objThumbs).on(g_objThumbs.events.PANE_CHANGE, onThumbsChange);
                break;
            }
        }
        if (g_options.gallery_mousewheel_role == "advance" && g_temp.isFreestyleMode == false) g_objWrapper.on("mousewheel", t.onGalleryMouseWheel);
        storeLastSize();
        jQuery(window).resize(function() {
            g_objWrapper.css("width", "auto");
            g_functions.whenContiniousEventOver("gallery_resize", onGalleryResized, g_temp.resizeDelay);
        });
        setTimeout(function() {
            setInterval(onGalleryResized, 2e3);
        }, 1e4);
        g_functions.addFullScreenChangeEvent(onFullScreenChange);
        if (g_objSlider) {
            jQuery(g_objSlider).on(g_objSlider.events.ITEM_CHANGED, function() {
                var sliderIndex = g_objSlider.getCurrentItemIndex();
                if (sliderIndex != -1) t.selectItem(sliderIndex);
            });
            if (g_options.gallery_pause_on_mouseover == true) {
                var sliderElement = g_objSlider.getElement();
                sliderElement.hover(onSliderMouseEnter, onSliderMouseLeave);
                g_objGallery.on(t.events.ENTER_FULLSCREEN, function() {
                    onSliderMouseLeave();
                });
            }
            retriggerEvent(g_objSlider, g_objSlider.events.ACTION_START, t.events.SLIDER_ACTION_START);
            retriggerEvent(g_objSlider, g_objSlider.events.ACTION_END, t.events.SLIDER_ACTION_END);
            jQuery(g_objSlider).on(g_objSlider.events.CURRENTSLIDE_LOAD_END, onCurrentSlideImageLoadEnd);
        }
        if (g_options.gallery_control_keyboard == true) jQuery(document).keydown(onKeyPress);
    }
    this.destroy = function() {
        g_objWrapper.off("dragstart");
        g_objGallery.off(t.events.ITEM_IMAGE_UPDATED);
        if (g_objThumbs) {
            switch (g_temp.thumbsType) {
              case "strip":
                jQuery(g_objThumbs).off(g_objThumbs.events.STRIP_MOVE);
                break;

              case "grid":
                jQuery(g_objThumbs).off(g_objThumbs.events.PANE_CHANGE);
                break;
            }
        }
        g_objWrapper.off("mousewheel");
        jQuery(window).off("resize");
        g_functions.destroyFullScreenChangeEvent();
        if (g_objSlider) {
            jQuery(g_objSlider).off(g_objSlider.events.ITEM_CHANGED);
            var sliderElement = g_objSlider.getElement();
            sliderElement.off("mouseenter");
            sliderElement.off("mouseleave");
            g_objGallery.off(t.events.ENTER_FULLSCREEN);
            jQuery(g_objSlider).off(g_objSlider.events.ACTION_START);
            jQuery(g_objSlider).off(g_objSlider.events.ACTION_END);
            jQuery(g_objSlider).off(g_objSlider.events.CURRENTSLIDE_LOAD_END);
        }
        if (g_options.gallery_control_keyboard == true) jQuery(document).off("keydown");
        if (g_objTheme && typeof g_objTheme.destroy == "function") {
            g_objTheme.destroy();
        }
        g_objWrapper.html("");
    };
    function __________GENERAL_______() {}
    this.getArrItems = function() {
        return g_arrItems;
    };
    this.getObjects = function() {
        var objects = {
            g_galleryID: g_galleryID,
            g_objWrapper: g_objWrapper,
            g_objThumbs: g_objThumbs,
            g_objSlider: g_objSlider,
            g_options: g_options,
            g_arrItems: g_arrItems,
            g_numItems: g_numItems
        };
        return objects;
    };
    this.getObjSlider = function() {
        return g_objSlider;
    };
    this.getItem = function(index) {
        if (index < 0) {
            throw new Error("item with index: " + index + " not found");
            return null;
        }
        if (index >= g_numItems) {
            throw new Error("item with index: " + index + " not found");
            return null;
        }
        return g_arrItems[index];
    };
    this.getWidth = function() {
        var objSize = t.getSize();
        return objSize.width;
    };
    this.getHeight = function() {
        var objSize = t.getSize();
        return objSize.height;
    };
    this.getSize = function() {
        var objSize = g_functions.getElementSize(g_objWrapper);
        objSize.orig_width = g_options.gallery_width;
        objSize.orig_height = g_options.gallery_height;
        objSize.orig_ratio = objSize.orig_width / objSize.orig_height;
        return objSize;
    };
    this.getGalleryID = function() {
        var id = g_galleryID.replace("#", "");
        return id;
    };
    this.getNextItem = function(index, forceCarousel) {
        if (typeof index == "object") index = index.index;
        var nextIndex = index + 1;
        if (forceCarousel !== true && g_numItems == 1) return null;
        if (nextIndex >= g_numItems) {
            if (g_options.gallery_carousel == true || forceCarousel === true) nextIndex = 0; else return null;
        }
        var objItem = g_arrItems[nextIndex];
        return objItem;
    };
    this.getPrevItem = function(index, forceCarousel) {
        if (typeof index == "object") index = index.index;
        var prevIndex = index - 1;
        if (prevIndex < 0) {
            if (g_options.gallery_carousel == true || forceCarousel === true) prevIndex = g_numItems - 1; else return null;
        }
        var objItem = g_arrItems[prevIndex];
        return objItem;
    };
    this.getSelectedItem = function() {
        return g_selectedItem;
    };
    this.getSelectedItemIndex = function() {
        return g_selectedItemIndex;
    };
    this.getNumItems = function() {
        return g_numItems;
    };
    this.isLastItem = function() {
        if (g_selectedItemIndex == g_numItems - 1) return true;
        return false;
    };
    this.isFirstItem = function() {
        if (g_selectedItemIndex == 0) return true;
        return false;
    };
    this.getOptions = function() {
        return g_options;
    };
    this.getElement = function() {
        return g_objWrapper;
    };
    this.___________SET_CONTROLS___________ = function() {};
    this.setNextButton = function(objButton) {
        objButton.data("ug-button", true);
        g_functions.setButtonOnClick(objButton, t.nextItem);
    };
    this.setPrevButton = function(objButton) {
        objButton.data("ug-button", true);
        g_functions.setButtonOnClick(objButton, t.prevItem);
    };
    this.setFullScreenToggleButton = function(objButton) {
        objButton.data("ug-button", true);
        g_functions.setButtonOnTap(objButton, t.toggleFullscreen);
        g_objGallery.on(t.events.ENTER_FULLSCREEN, function() {
            objButton.addClass("ug-fullscreenmode");
        });
        g_objGallery.on(t.events.EXIT_FULLSCREEN, function() {
            objButton.removeClass("ug-fullscreenmode");
        });
    };
    this.destroyFullscreenButton = function(objButton) {
        g_functions.destroyButton(objButton);
        g_objGallery.off(t.events.ENTER_FULLSCREEN);
        g_objGallery.off(t.events.EXIT_FULLSCREEN);
    };
    this.setPlayButton = function(objButton) {
        objButton.data("ug-button", true);
        g_functions.setButtonOnClick(objButton, t.togglePlayMode);
        g_objGallery.on(t.events.START_PLAY, function() {
            objButton.addClass("ug-stop-mode");
        });
        g_objGallery.on(t.events.STOP_PLAY, function() {
            objButton.removeClass("ug-stop-mode");
        });
    };
    this.destroyPlayButton = function(objButton) {
        g_functions.destroyButton(objButton);
        g_objGallery.off(t.events.START_PLAY);
        g_objGallery.off(t.events.STOP_PLAY);
    };
    this.setProgressIndicator = function(objProgress) {
        g_temp.objProgress = objProgress;
    };
    this.setTextContainers = function(objTitle, objDescription) {
        g_objGallery.on(t.events.ITEM_CHANGE, function() {
            var objItem = t.getSelectedItem();
            objTitle.html(objItem.title);
            objDescription.html(objItem.description);
        });
    };
    this.showDisabledOverlay = function() {
        g_objWrapper.children(".ug-overlay-disabled").show();
    };
    this.hideDisabledOverlay = function() {
        g_objWrapper.children(".ug-overlay-disabled").hide();
    };
    this.___________END_SET_CONTROLS___________ = function() {};
    function cacheItems(cacheID, htmlItemsArg) {
        if (htmlItemsArg) {
            var htmlItems = htmlItemsArg;
            if (htmlItems != "noitems") htmlItems = jQuery(htmlItemsArg).clone();
        } else {
            var htmlItems = g_objWrapper.children().clone();
        }
        g_objCache[cacheID] = htmlItems;
    }
    function removeAllSizeClasses(objWrapper) {
        if (!objWrapper) objWrapper = g_objWrapper;
        objWrapper.removeClass("ug-under-480");
        objWrapper.removeClass("ug-under-780");
        objWrapper.removeClass("ug-under-960");
    }
    function retriggerEvent(object, originalEvent, newEvent) {
        jQuery(object).on(originalEvent, function(event) {
            g_objGallery.trigger(newEvent, [ this ]);
        });
    }
    function advanceNextStep() {
        var timeNow = jQuery.now();
        var timeDiff = timeNow - g_temp.playTimeLastStep;
        g_temp.playTimeLastStep = timeNow;
        var isVisible = t.isGalleryVisible();
        if (isVisible == false) {
            return false;
        }
        g_temp.playTimePassed += timeDiff;
        if (g_temp.objProgress) {
            var percent = g_temp.playTimePassed / g_options.gallery_play_interval;
            g_temp.objProgress.setProgress(percent);
        }
        if (g_temp.playTimePassed >= g_options.gallery_play_interval) {
            t.nextItem();
            g_temp.playTimePassed = 0;
        }
    }
    this.___________PLAY_MODE___________ = function() {};
    this.startPlayMode = function() {
        g_temp.isPlayMode = true;
        g_temp.isPlayModePaused = false;
        g_temp.playTimePassed = 0;
        g_temp.playTimeLastStep = jQuery.now();
        g_temp.playHandle = setInterval(advanceNextStep, g_temp.playStepInterval);
        if (g_temp.objProgress) {
            var objElement = g_temp.objProgress.getElement();
            g_temp.objProgress.setProgress(0);
            objElement.show();
        }
        g_objGallery.trigger(t.events.START_PLAY);
        if (g_objSlider && g_objSlider.isCurrentSlideLoadingImage() == true) {
            t.pausePlaying();
        }
    };
    this.resetPlaying = function() {
        if (g_temp.isPlayMode == false) return true;
        g_temp.playTimePassed = 0;
        g_temp.playTimeLastStep = jQuery.now();
    };
    this.pausePlaying = function() {
        if (g_temp.isPlayModePaused == true) return true;
        g_temp.isPlayModePaused = true;
        clearInterval(g_temp.playHandle);
        g_objGallery.trigger(t.events.PAUSE_PLAYING);
    };
    this.continuePlaying = function() {
        if (g_temp.isPlayModePaused == false) return true;
        g_temp.isPlayModePaused = false;
        g_temp.playTimeLastStep = jQuery.now();
        g_temp.playHandle = setInterval(advanceNextStep, g_temp.playStepInterval);
    };
    this.stopPlayMode = function() {
        g_temp.isPlayMode = false;
        clearInterval(g_temp.playHandle);
        g_temp.playTimePassed = 0;
        if (g_temp.objProgress) {
            var objElement = g_temp.objProgress.getElement();
            objElement.hide();
        }
        g_objGallery.trigger(t.events.STOP_PLAY);
    };
    this.isPlayMode = function() {
        return g_temp.isPlayMode;
    };
    this.togglePlayMode = function() {
        if (t.isPlayMode() == false) t.startPlayMode(); else t.stopPlayMode();
    };
    function unselectSeletedItem() {
        if (g_selectedItem == null) return true;
        if (g_objThumbs) g_objThumbs.setThumbUnselected(g_selectedItem.objThumbWrapper);
        g_selectedItem = null;
        g_selectedItemIndex = -1;
    }
    this.___________GENERAL_EXTERNAL___________ = function() {};
    this.shuffleItems = function() {
        g_arrItems = g_functions.arrayShuffle(g_arrItems);
        for (var index in g_arrItems) g_arrItems[index].index = parseInt(index);
    };
    this.setOptions = function(customOptions) {
        g_options = jQuery.extend(g_options, customOptions);
    };
    this.selectItem = function(objItem, role) {
        if (typeof objItem == "number") objItem = t.getItem(objItem);
        var itemIndex = objItem.index;
        if (itemIndex == g_selectedItemIndex) return true;
        unselectSeletedItem();
        g_selectedItem = objItem;
        g_selectedItemIndex = itemIndex;
        g_objGallery.trigger(t.events.ITEM_CHANGE, [ objItem, role ]);
        if (g_temp.isPlayMode == true) {
            t.resetPlaying();
            var stillLoading = g_objSlider.isCurrentSlideLoadingImage();
            if (stillLoading == true) t.pausePlaying();
        }
    };
    this.nextItem = function() {
        var newItemIndex = g_selectedItemIndex + 1;
        if (g_numItems == 0) return true;
        if (g_options.gallery_carousel == false && newItemIndex >= g_numItems) return true;
        if (newItemIndex >= g_numItems) newItemIndex = 0;
        t.selectItem(newItemIndex, "next");
    };
    this.prevItem = function() {
        var newItemIndex = g_selectedItemIndex - 1;
        if (g_selectedItemIndex == -1) newItemIndex = 0;
        if (g_numItems == 0) return true;
        if (g_options.gallery_carousel == false && newItemIndex < 0) return true;
        if (newItemIndex < 0) newItemIndex = g_numItems - 1;
        t.selectItem(newItemIndex, "prev");
    };
    function toFakeFullScreen() {
        jQuery("body").addClass("ug-body-fullscreen");
        g_objWrapper.addClass("ug-fake-fullscreen");
        g_temp.isFakeFullscreen = true;
        g_objGallery.trigger(t.events.ENTER_FULLSCREEN);
        g_objGallery.trigger(t.events.SIZE_CHANGE);
    }
    function exitFakeFullscreen() {
        jQuery("body").removeClass("ug-body-fullscreen");
        g_objWrapper.removeClass("ug-fake-fullscreen");
        g_temp.isFakeFullscreen = false;
        g_objGallery.trigger(t.events.EXIT_FULLSCREEN);
        g_objGallery.trigger(t.events.SIZE_CHANGE);
    }
    this.isFullScreen = function() {
        if (g_temp.isFakeFullscreen == true) return true;
        if (g_functions.isFullScreen() == true) return true;
        return false;
    };
    this.isFakeFullscreen = function() {
        return g_temp.isFakeFullscreen;
    };
    this.toFullScreen = function() {
        g_functions.setGlobalData("fullscreenID", g_galleryID);
        var divGallery = g_objWrapper.get(0);
        var isSupported = g_functions.toFullscreen(divGallery);
        if (isSupported == false) toFakeFullScreen();
    };
    this.exitFullScreen = function() {
        if (g_temp.isFakeFullscreen == true) exitFakeFullscreen(); else g_functions.exitFullscreen();
    };
    this.toggleFullscreen = function() {
        if (t.isFullScreen() == false) {
            t.toFullScreen();
        } else {
            t.exitFullScreen();
        }
    };
    this.resize = function(newWidth, newHeight, noevent) {
        g_objWrapper.css("width", "auto");
        g_objWrapper.css("max-width", newWidth + "px");
        if (newHeight) g_objWrapper.height(newHeight);
        if (!noevent && noevent !== true) onGalleryResized();
    };
    this.setSizeClass = function(objWrapper, width) {
        if (!objWrapper) var objWrapper = g_objWrapper;
        if (!width) {
            var objSize = t.getSize();
            var width = objSize.width;
        }
        if (width == 0) var width = jQuery(window).width();
        var addClass = "";
        if (width <= 480) {
            addClass = "ug-under-480";
        } else if (width <= 780) {
            addClass = "ug-under-780";
        } else if (width < 960) {
            addClass = "ug-under-960";
        }
        if (objWrapper.hasClass(addClass) == true) return true;
        removeAllSizeClasses(objWrapper);
        if (addClass != "") objWrapper.addClass(addClass);
    };
    this.isMobileMode = function() {
        if (g_objWrapper.hasClass("ug-under-480")) return true;
        return false;
    };
    this.isSmallWindow = function() {
        var windowWidth = jQuery(window).width();
        if (!windowWidth) return true;
        if (windowWidth <= 480) return true;
        return false;
    };
    this.isGalleryVisible = function() {
        var isVisible = g_objWrapper.is(":visible");
        return isVisible;
    };
    this.changeItems = function(itemsContent, cacheID) {
        if (!itemsContent) var itemsContent = "noitems";
        runGallery(g_galleryID, "nochange", itemsContent, cacheID);
    };
    this.addItems = function(itemsContent) {
        if (!itemsContent || itemsContent.length == 0) return false;
        var objNewItemsWrapper = g_objWrapper.children(".ug-newitems-wrapper");
        if (objNewItemsWrapper.length == 0) g_objWrapper.append("<div class='ug-newitems-wrapper' style='display:none'></div>");
        objNewItemsWrapper = g_objWrapper.children(".ug-newitems-wrapper");
        objNewItemsWrapper.append(itemsContent);
        var objChildren = jQuery(objNewItemsWrapper.children());
        fillItemsArray(objChildren, true);
        loadAPIs();
        if (!g_objTheme || typeof g_objTheme.addItems != "function") throw new Error("addItems function not found in the theme");
        objNewItemsWrapper.remove();
        g_objTheme.addItems();
    };
    this.getNewAddedItemsIndexes = function() {
        var arrIndexes = [];
        jQuery.each(g_arrItems, function(index, objItem) {
            if (objItem.isNewAdded == true) arrIndexes.push(index);
        });
        return arrIndexes;
    };
    this.showErrorMessageReplaceGallery = function(message) {
        showErrorMessage(message);
    };
    this.setFuncCustomHeight = function(func) {
        g_temp.funcCustomHeight = func;
    };
    this.__________EXTERNAL_EVENTS_______ = function() {};
    this.triggerEvent = function(event, arrParams) {
        if (!arrParams) g_objGallery.trigger(event); else {
            if (jQuery.type(arrParams) != "array") arrParams = [ arrParams ];
            g_objGallery.trigger(event, arrParams);
        }
    };
    this.onEvent = function(event, func) {
        g_objGallery.on(event, func);
    };
    this.destroyEvent = function(event) {
        g_objGallery.off(event);
    };
    this.__________AJAX_REQUEST_______ = function() {};
    this.ajaxRequest = function(action, data, successFunction, errorFunction) {
        if (!successFunction || typeof successFunction != "function") throw new Error("ajaxRequest error: success function should be passed");
        var urlAjax = g_options.gallery_urlajax;
        if (!urlAjax || urlAjax == "") throw new Error("ajaxRequest error: Ajax url don't passed");
        if (typeof data == "undefined") var data = {};
        var objData = {
            action: "unitegallery_ajax_action",
            client_action: action,
            galleryID: g_galleryID,
            data: data
        };
        jQuery.ajax({
            type: "post",
            url: g_options.gallery_urlajax,
            dataType: "json",
            data: objData,
            success: function(response) {
                if (!response) {
                    throw new Error("Empty ajax response!");
                }
                if (response == -1 || response === 0) throw new Error("ajax error!!!");
                if (typeof response.success == "undefined") throw new Error("ajax error!!!");
                if (response.success == false) {
                    showErrorMessage(response.message, "ajax error");
                    return false;
                }
                successFunction(response);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log("Ajax Error!!! " + textStatus);
                responseText = jqXHR.responseText;
                if (errorFunction && typeof errorFunction == "function") {
                    errorFunction(responseText);
                } else trace(responseText);
            }
        });
    };
    this.requestNewItems = function(catID, isForce, cacheID) {
        var checkCache = g_options.gallery_enable_cache;
        if (!cacheID) cacheID = catID;
        if (isForce == true) checkCache = false;
        if (checkCache == true && g_objCache.hasOwnProperty(cacheID)) {
            var htmlItems = g_objCache[cacheID];
            t.changeItems(htmlItems, cacheID);
        } else {
            g_objGallery.trigger(t.events.GALLERY_BEFORE_REQUEST_ITEMS);
            t.ajaxRequest("front_get_cat_items", {
                catid: catID
            }, function(response) {
                var htmlItems = response.html;
                t.changeItems(htmlItems, cacheID);
            });
        }
    };
    this.run = function(galleryID, objParams) {
        var debug_errors = g_options.gallery_debug_errors;
        if (objParams && objParams.hasOwnProperty("gallery_debug_errors")) g_options.gallery_debug_errors = objParams.gallery_debug_errors;
        if (g_options.gallery_debug_errors == true) {
            try {
                runGallery(galleryID, objParams);
            } catch (objError) {
                if (typeof objError == "object") {
                    var message = objError.message;
                    var lineNumber = objError.lineNumber;
                    var fileName = objError.fileName;
                    var stack = objError.stack;
                    message += " <br><br> in file: " + fileName;
                    message += " <b> line " + lineNumber + "</b>";
                    trace(objError);
                } else {
                    var message = objError;
                }
                message = message.replace("Error:", "");
                showErrorMessage(message);
            }
        } else {
            runGallery(galleryID, objParams);
        }
    };
}

function UGLightbox() {
    var t = this, g_objThis = jQuery(this);
    var g_gallery = new UniteGalleryMain(), g_objGallery, g_objWrapper;
    var g_objSlider = new UGSlider(), g_objOverlay, g_objArrowLeft, g_objArrowRight, g_objButtonClose;
    var g_functions = new UGFunctions(), g_objTextPanel = new UGTextPanel(), g_objNumbers;
    var g_objTopPanel;
    var g_options = {
        lightbox_type: "wide",
        lightbox_show_textpanel: true,
        lightbox_textpanel_width: 550,
        lightbox_hide_arrows_onvideoplay: true,
        lightbox_arrows_position: "sides",
        lightbox_arrows_offset: 10,
        lightbox_arrows_inside_offset: 10,
        lightbox_arrows_inside_alwayson: false,
        lightbox_overlay_color: null,
        lightbox_overlay_opacity: 1,
        lightbox_top_panel_opacity: null,
        lightbox_show_numbers: true,
        lightbox_numbers_size: null,
        lightbox_numbers_color: null,
        lightbox_numbers_padding_top: null,
        lightbox_numbers_padding_right: null,
        lightbox_compact_closebutton_offsetx: 1,
        lightbox_compact_closebutton_offsety: 1,
        lightbox_close_on_emptyspace: true
    };
    this.events = {
        LIGHTBOX_INIT: "lightbox_init"
    };
    var g_temp = {
        topPanelHeight: 44,
        initTextPanelHeight: 26,
        isOpened: false,
        isRightNowOpened: false,
        putSlider: true,
        isCompact: false,
        fadeDuration: 300,
        positionFrom: null,
        textPanelTop: null,
        textPanelLeft: null,
        isArrowsInside: false,
        isArrowsOnHoverMode: false,
        lastMouseX: null,
        lastMouseY: null,
        originalOptions: null,
        isSliderChangedOnce: false,
        isTopPanelEnabled: true
    };
    var g_defaults = {
        lightbox_slider_controls_always_on: true,
        lightbox_slider_enable_bullets: false,
        lightbox_slider_enable_arrows: false,
        lightbox_slider_enable_progress_indicator: false,
        lightbox_slider_enable_play_button: false,
        lightbox_slider_enable_fullscreen_button: false,
        lightbox_slider_enable_zoom_panel: false,
        lightbox_slider_enable_text_panel: false,
        lightbox_slider_scale_mode_media: "down",
        lightbox_slider_scale_mode: "down",
        lightbox_slider_loader_type: 3,
        lightbox_slider_loader_color: "black",
        lightbox_slider_transition: "fade",
        lightbox_slider_image_padding_top: g_temp.topPanelHeight,
        lightbox_slider_image_padding_bottom: 0,
        lightbox_slider_video_padding_top: 0,
        lightbox_slider_video_padding_bottom: 0,
        lightbox_textpanel_align: "middle",
        lightbox_textpanel_padding_top: 5,
        lightbox_textpanel_padding_bottom: 5,
        slider_video_constantsize: false,
        lightbox_slider_image_border: false,
        lightbox_textpanel_enable_title: true,
        lightbox_textpanel_enable_description: false,
        lightbox_textpanel_desc_style_as_title: true,
        lightbox_textpanel_enable_bg: false,
        video_enable_closebutton: false,
        lightbox_slider_video_enable_closebutton: false,
        video_youtube_showinfo: false,
        lightbox_slider_enable_links: false
    };
    var g_defaultsCompact = {
        lightbox_overlay_opacity: .6,
        lightbox_slider_image_border: true,
        lightbox_slider_image_shadow: true,
        lightbox_slider_image_padding_top: 30,
        lightbox_slider_image_padding_bottom: 30,
        slider_video_constantsize: true,
        lightbox_textpanel_align: "bottom",
        lightbox_textpanel_title_text_align: "left",
        lightbox_textpanel_desc_text_align: "left",
        lightbox_textpanel_padding_left: 10,
        lightbox_textpanel_padding_right: 10
    };
    function __________GENERAL_________() {}
    function initLightbox(gallery, customOptions) {
        g_gallery = gallery;
        g_objGallery = jQuery(gallery);
        g_options = jQuery.extend(g_options, g_defaults);
        g_options = jQuery.extend(g_options, customOptions);
        g_temp.originalOptions = jQuery.extend({}, g_options);
        if (g_options.lightbox_type == "compact") {
            g_temp.isCompact = true;
            g_options = jQuery.extend(g_options, g_defaultsCompact);
            g_options = jQuery.extend(g_options, customOptions);
        }
        modifyOptions();
        if (g_temp.putSlider == true) {
            g_gallery.initSlider(g_options, "lightbox");
            g_objects = gallery.getObjects();
            g_objSlider = g_objects.g_objSlider;
        } else {
            g_objSlider = null;
        }
        if (g_options.lightbox_show_textpanel == true) {
            g_objTextPanel.init(g_gallery, g_options, "lightbox");
        } else g_objTextPanel = null;
    }
    function modifyOptions() {
        if (g_temp.isCompact == true && g_options.lightbox_show_textpanel == true) {
            g_options.lightbox_slider_image_padding_bottom = g_temp.initTextPanelHeight;
        }
        if (g_temp.isCompact == true && g_options.lightbox_arrows_position == "inside") {
            g_temp.isArrowsInside = true;
        }
        if (g_temp.isArrowsInside == true && g_options.lightbox_arrows_inside_alwayson == false) g_temp.isArrowsOnHoverMode = true;
        if (g_options.lightbox_show_textpanel == false) {
            g_temp.isTopPanelEnabled = false;
            g_temp.topPanelHeight = 0;
            g_options.lightbox_slider_image_padding_top = 0;
        }
    }
    function putLightboxHtml() {
        var html = "";
        var classAddition = "";
        if (g_temp.isCompact == true) {
            classAddition = " ug-lightbox-compact";
        }
        html += "<div class='ug-gallery-wrapper ug-lightbox" + classAddition + "'>";
        html += "<div class='ug-lightbox-overlay'></div>";
        if (g_temp.isCompact == false && g_temp.isTopPanelEnabled) {
            html += "<div class='ug-lightbox-top-panel'>";
            html += "<div class='ug-lightbox-top-panel-overlay'></div>";
            if (g_options.lightbox_show_numbers) html += "<div class='ug-lightbox-numbers'></div>";
            html += "</div>";
        } else {
            if (g_options.lightbox_show_numbers) html += "<div class='ug-lightbox-numbers'></div>";
        }
        html += "<div class='ug-lightbox-button-close'></div>";
        html += "<div class='ug-lightbox-arrow-left'></div>";
        html += "<div class='ug-lightbox-arrow-right'></div>";
        html += "</div>";
        g_objWrapper = jQuery(html);
        jQuery("body").append(g_objWrapper);
        if (g_objSlider) g_objSlider.setHtml(g_objWrapper);
        g_objOverlay = g_objWrapper.children(".ug-lightbox-overlay");
        if (g_temp.isCompact == false && g_temp.isTopPanelEnabled == true) {
            g_objTopPanel = g_objWrapper.children(".ug-lightbox-top-panel");
            if (g_objTopPanel.length == 0) g_objTopPanel = null;
        }
        g_objButtonClose = g_objWrapper.find(".ug-lightbox-button-close");
        if (g_options.lightbox_show_numbers) g_objNumbers = g_objWrapper.find(".ug-lightbox-numbers");
        g_objArrowLeft = g_objWrapper.children(".ug-lightbox-arrow-left");
        g_objArrowRight = g_objWrapper.children(".ug-lightbox-arrow-right");
        if (g_objTextPanel) {
            if (g_objTopPanel) g_objTextPanel.appendHTML(g_objTopPanel); else g_objTextPanel.appendHTML(g_objWrapper);
        }
    }
    function setProperties() {
        if (g_options.lightbox_overlay_color !== null) g_objOverlay.css("background-color", g_options.lightbox_overlay_color);
        if (g_options.lightbox_overlay_opacity !== null) g_objOverlay.fadeTo(0, g_options.lightbox_overlay_opacity);
        if (g_objTopPanel && g_options.lightbox_top_panel_opacity !== null) {
            g_objTopPanel.children(".ug-lightbox-top-panel-overlay").fadeTo(0, g_options.lightbox_top_panel_opacity);
        }
        if (g_objNumbers) {
            var cssNumbers = {};
            if (g_options.lightbox_numbers_size !== null) cssNumbers["font-size"] = g_options.lightbox_numbers_size + "px";
            if (g_options.lightbox_numbers_color) cssNumbers["color"] = g_options.lightbox_numbers_color;
            if (g_options.lightbox_numbers_padding_right !== null) cssNumbers["padding-right"] = g_options.lightbox_numbers_padding_right + "px";
            if (g_options.lightbox_numbers_padding_top !== null) cssNumbers["padding-top"] = g_options.lightbox_numbers_padding_top + "px";
            g_objNumbers.css(cssNumbers);
        }
    }
    function refreshSliderItem(newHeight) {
        if (!g_objSlider) return true;
        var objOptions = {
            slider_image_padding_top: newHeight
        };
        g_objSlider.setOptions(objOptions);
        g_objSlider.refreshSlideItems();
    }
    function __________WIDE_ONLY_________() {}
    function handlePanelHeight(fromWhere) {
        if (!g_objTopPanel) return false;
        if (!g_objTextPanel) return false;
        var panelHeight = g_objTopPanel.height();
        if (panelHeight == 0) return false;
        if (g_objTopPanel.is(":visible") == false) return false;
        var newPanelHeight = panelHeight;
        var objTextPanelSize = g_objTextPanel.getSize();
        var textPanelHeight = objTextPanelSize.height;
        if (panelHeight != g_temp.topPanelHeight) newPanelHeight = g_temp.topPanelHeight;
        if (textPanelHeight > newPanelHeight) newPanelHeight = textPanelHeight;
        if (panelHeight != newPanelHeight) {
            g_objTopPanel.height(newPanelHeight);
            if (g_objSlider && g_objSlider.isAnimating() == false) refreshSliderItem(newPanelHeight);
        }
    }
    function positionTextPanelWide(size) {
        var objOptions = {};
        var textWidth = g_options.lightbox_textpanel_width;
        var minPaddingLeft = 47;
        var minPaddingRight = 40;
        var maxTextPanelWidth = size.width - minPaddingLeft - minPaddingRight;
        if (textWidth > maxTextPanelWidth) {
            objOptions.textpanel_padding_left = minPaddingLeft;
            objOptions.textpanel_padding_right = minPaddingRight;
            objOptions.textpanel_title_text_align = "center";
            objOptions.textpanel_desc_text_align = "center";
        } else {
            objOptions.textpanel_padding_left = Math.floor((size.width - textWidth) / 2);
            objOptions.textpanel_padding_right = objOptions.textpanel_padding_left;
            objOptions.textpanel_title_text_align = "left";
            objOptions.textpanel_desc_text_align = "left";
            if (g_options.lightbox_textpanel_title_text_align) objOptions.textpanel_title_text_align = g_options.lightbox_textpanel_desc_text_align;
            if (g_options.lightbox_textpanel_desc_text_align) objOptions.textpanel_desc_text_align = g_options.lightbox_textpanel_desc_text_align;
        }
        g_objTextPanel.setOptions(objOptions);
        g_objTextPanel.refresh(true, true);
        handlePanelHeight("positionTextPanelWide");
        g_objTextPanel.positionPanel();
    }
    function hideTopPanel() {
        if (!g_objTopPanel) return false;
        g_objTopPanel.hide();
    }
    function showTopPanel() {
        if (!g_objTopPanel) return false;
        g_objTopPanel.show();
    }
    function __________COMPACT_ONLY_________() {}
    function handleCompactHeight(objImageSize) {
        if (g_temp.isOpened == false) return false;
        if (!g_objTextPanel) return false;
        if (!g_objSlider) return false;
        var wrapperSize = g_functions.getElementSize(g_objWrapper);
        var textPanelSize = g_objTextPanel.getSize();
        if (textPanelSize.width == 0 || textPanelSize.height > 120) return false;
        if (!objImageSize) {
            var objImage = g_objSlider.getSlideImage();
            var objImageSize = g_functions.getElementSize(objImage);
        }
        if (objImageSize.height == 0 || objImageSize.width == 0) return false;
        var totalBottom = objImageSize.bottom + textPanelSize.height;
        if (totalBottom < wrapperSize.height) return false;
        var sliderOptions = g_objSlider.getOptions();
        var imagePaddingBottom = textPanelSize.height;
        if (imagePaddingBottom != sliderOptions.slider_image_padding_bottom) {
            var objOptions = {
                slider_image_padding_bottom: imagePaddingBottom
            };
            if (g_objSlider.isAnimating() == false) {
                g_objSlider.setOptions(objOptions);
                g_objSlider.refreshSlideItems();
                return true;
            }
        }
        return false;
    }
    function setCompactTextpanelTop(objImageSize, positionPanel) {
        if (!objImageSize) {
            var objImage = g_objSlider.getSlideImage();
            var objImageSize = g_functions.getElementSize(objImage);
        }
        g_temp.textPanelTop = objImageSize.bottom;
        if (positionPanel === true) g_objTextPanel.positionPanel(g_temp.textPanelTop, g_temp.textPanelLeft);
    }
    function handleCompactTextpanelSizes(showTextpanel) {
        var wrapperSize = g_functions.getElementSize(g_objWrapper);
        var objImage = g_objSlider.getSlideImage();
        var objImageSize = g_functions.getElementSize(objImage);
        if (objImageSize.width == 0) return false;
        g_temp.textPanelLeft = objImageSize.left;
        g_temp.textPanelTop = objImageSize.bottom;
        var textPanelWidth = objImageSize.width;
        if (g_objNumbers) {
            var objNumbersSize = g_functions.getElementSize(g_objNumbers);
            textPanelWidth -= objNumbersSize.width;
            var numbersLeft = objImageSize.right - objNumbersSize.width;
            g_functions.placeElement(g_objNumbers, numbersLeft, g_temp.textPanelTop);
        }
        if (g_objTextPanel) {
            g_objTextPanel.show();
            g_objTextPanel.refresh(true, true, textPanelWidth);
            setCompactTextpanelTop(objImageSize);
        }
        var isChanged = handleCompactHeight(objImageSize);
        if (isChanged == false) {
            g_temp.positionFrom = "handleCompactTextpanelSizes";
            if (g_objTextPanel) {
                g_objTextPanel.positionPanel(g_temp.textPanelTop, g_temp.textPanelLeft);
                if (showTextpanel === true) {
                    showTextpanel();
                    showNumbers();
                }
            }
        }
    }
    function isSliderImageInPlace() {
        if (g_objSlider.isCurrentSlideType("image") == false) return true;
        var isImageInPlace = g_objSlider.isCurrentImageInPlace() == true;
        return isImageInPlace;
    }
    function positionArrowsInside(toShow, isAnimation) {
        if (g_temp.isArrowsInside == false) return false;
        if (!g_objArrowLeft) return false;
        var isImageInPlace = isSliderImageInPlace();
        g_objArrowLeft.show();
        g_objArrowRight.show();
        g_temp.positionFrom = "positionArrowsInside";
        if (g_temp.isArrowsOnHoverMode == true && isImageInPlace == true && isMouseInsideImage() == false) hideArrows(true);
        if (isImageInPlace == false) {
            var leftArrowLeft = g_functions.getElementRelativePos(g_objArrowLeft, "left", g_options.lightbox_arrows_offset);
            var leftArrowTop = g_functions.getElementRelativePos(g_objArrowLeft, "middle");
            var rightArrowLeft = g_functions.getElementRelativePos(g_objArrowRight, "right", g_options.lightbox_arrows_offset);
            var rightArrowTop = leftArrowTop;
        } else {
            var objImage = g_objSlider.getSlideImage();
            var objImageSize = g_functions.getElementSize(objImage);
            var objSliderSize = g_functions.getElementSize(g_objSlider.getElement());
            var leftArrowLeft = g_functions.getElementRelativePos(g_objArrowLeft, "left", 0, objImage) + objImageSize.left + g_options.lightbox_arrows_inside_offset;
            var leftArrowTop = g_functions.getElementRelativePos(g_objArrowLeft, "middle", 0, objImage) + objImageSize.top;
            var rightArrowLeft = g_functions.getElementRelativePos(g_objArrowLeft, "right", 0, objImage) + objImageSize.left - g_options.lightbox_arrows_inside_offset;
            var rightArrowTop = leftArrowTop;
        }
        if (isAnimation === true) {
            var objCssLeft = {
                left: leftArrowLeft,
                top: leftArrowTop
            };
            var objCssRight = {
                left: rightArrowLeft,
                top: rightArrowTop
            };
            g_objArrowLeft.stop().animate(objCssLeft, {
                duration: g_temp.fadeDuration
            });
            g_objArrowRight.stop().animate(objCssRight, {
                duration: g_temp.fadeDuration
            });
        } else {
            g_objArrowLeft.stop();
            g_objArrowRight.stop();
            g_functions.placeElement(g_objArrowLeft, leftArrowLeft, leftArrowTop);
            g_functions.placeElement(g_objArrowRight, rightArrowLeft, rightArrowTop);
        }
        if (toShow == true) showArrows(isAnimation);
    }
    function positionCloseButton(toShow, isAnimation) {
        g_temp.positionFrom = null;
        var isImageInPlace = isSliderImageInPlace();
        var minButtonTop = 2;
        var maxButtonLeft = g_functions.getElementRelativePos(g_objButtonClose, "right", 2, g_objWrapper);
        if (isImageInPlace == false) {
            var closeButtonTop = minButtonTop;
            var closeButtonLeft = maxButtonLeft;
        } else {
            var objImage = g_objSlider.getSlideImage();
            var objImageSize = g_functions.getElementSize(objImage);
            var objSliderSize = g_functions.getElementSize(g_objSlider.getElement());
            var objButtonSize = g_functions.getElementSize(g_objButtonClose);
            if (objSliderSize.top == objSliderSize.height) objSliderSize.top = 0;
            var closeButtonLeft = objSliderSize.left + objImageSize.right - objButtonSize.width / 2 + g_options.lightbox_compact_closebutton_offsetx;
            var closeButtonTop = objSliderSize.top + objImageSize.top - objButtonSize.height / 2 - g_options.lightbox_compact_closebutton_offsety;
            if (closeButtonTop < minButtonTop) closeButtonTop = minButtonTop;
            if (closeButtonLeft > maxButtonLeft) closeButtonLeft = maxButtonLeft;
        }
        if (isAnimation === true) {
            var objCss = {
                left: closeButtonLeft,
                top: closeButtonTop
            };
            g_objButtonClose.stop().animate(objCss, {
                duration: g_temp.fadeDuration
            });
        } else {
            g_objButtonClose.stop();
            g_functions.placeElement(g_objButtonClose, closeButtonLeft, closeButtonTop);
        }
        if (toShow === true) showCloseButton(isAnimation);
    }
    function hideCompactElements() {
        if (g_objButtonClose) g_objButtonClose.stop().fadeTo(g_temp.fadeDuration, 0);
        hideTextPanel();
        hideNumbers();
        g_temp.positionFrom = "hideCompactElements";
        if (g_temp.isArrowsInside == true) hideArrows();
    }
    function actualHideCompactElements() {
        if (g_objButtonClose) g_objButtonClose.hide();
        if (g_objArrowLeft && g_temp.isArrowsInside == true) {
            g_objArrowLeft.hide();
            g_objArrowRight.hide();
        }
        if (g_objNumbers) g_objNumbers.hide();
        if (g_objTextPanel) g_objTextPanel.hide();
    }
    function __________COMMON_________() {}
    function positionElements() {
        var size = g_functions.getElementSize(g_objWrapper);
        if (g_objTopPanel) g_functions.setElementSizeAndPosition(g_objTopPanel, 0, 0, size.width, g_temp.topPanelHeight);
        if (g_objArrowLeft && g_temp.isArrowsInside == false) {
            if (g_options.lightbox_hide_arrows_onvideoplay == true) {
                g_objArrowLeft.show();
                g_objArrowRight.show();
            }
            g_functions.placeElement(g_objArrowLeft, "left", "middle", g_options.lightbox_arrows_offset);
            g_functions.placeElement(g_objArrowRight, "right", "middle", g_options.lightbox_arrows_offset);
        }
        if (g_temp.isCompact == false) g_functions.placeElement(g_objButtonClose, "right", "top", 2, 2);
        if (g_objTextPanel) {
            g_temp.positionFrom = "positionElements";
            if (g_temp.isCompact == false) positionTextPanelWide(size); else {
                showTextPanel();
                showNumbers();
            }
        }
        var sliderWidth = size.width;
        var sliderHeight = size.height;
        var sliderTop = 0;
        var sliderLeft = 0;
        if (g_objSlider) {
            if (g_objTopPanel) {
                var topPanelHeight = g_objTopPanel.height();
                var objOptions = {
                    slider_image_padding_top: topPanelHeight
                };
                g_objSlider.setOptions(objOptions);
            }
            g_objSlider.setSize(sliderWidth, sliderHeight);
            g_objSlider.setPosition(sliderLeft, sliderTop);
        }
    }
    function hideTextPanel() {
        if (g_objTextPanel) g_objTextPanel.getElement().stop().fadeTo(g_temp.fadeDuration, 0);
    }
    function hideNumbers() {
        if (g_objNumbers) g_objNumbers.stop().fadeTo(g_temp.fadeDuration, 0);
    }
    function isMouseInsideImage() {
        if (!g_temp.lastMouseX) return true;
        var obj = {
            pageX: g_temp.lastMouseX,
            pageY: g_temp.lastMouseY
        };
        var isMouseInside = g_objSlider.isMouseInsideSlideImage(obj);
        return isMouseInside;
    }
    function hideArrows(noAnimation, isForce) {
        if (!g_objArrowLeft) return false;
        if (g_temp.isArrowsOnHoverMode == true && isForce === false) {
            if (isMouseInsideImage() == true) ;
            return true;
        }
        if (noAnimation === true) {
            g_objArrowLeft.stop().fadeTo(0, 0);
            g_objArrowRight.stop().fadeTo(0, 0);
        } else {
            g_objArrowLeft.stop().fadeTo(g_temp.fadeDuration, 0);
            g_objArrowRight.stop().fadeTo(g_temp.fadeDuration, 0);
        }
    }
    function isArrowsHidden() {
        if (!g_objArrowLeft) return true;
        if (g_objArrowLeft.is(":visible") == false) return true;
        var opacity = g_objArrowLeft.css("opacity");
        if (opacity != 1) return true;
        return false;
    }
    function showArrows(noStop, fromHover) {
        if (!g_objArrowLeft) return false;
        if (g_temp.isArrowsOnHoverMode == true && fromHover !== true && isSliderImageInPlace() == true) return true;
        if (g_objSlider.isSwiping() == true) return true;
        if (noStop !== true) {
            g_objArrowLeft.stop();
            g_objArrowRight.stop();
        }
        g_objArrowLeft.fadeTo(g_temp.fadeDuration, 1);
        g_objArrowRight.fadeTo(g_temp.fadeDuration, 1);
    }
    function showCloseButton(noStop) {
        if (noStop !== true) g_objButtonClose.stop();
        g_objButtonClose.fadeTo(g_temp.fadeDuration, 1);
    }
    function updateTextPanelText(currentItem) {
        if (!g_objTextPanel) return false;
        if (!currentItem) var currentItem = g_objSlider.getCurrentItem();
        g_objTextPanel.setTextPlain(currentItem.title, currentItem.description);
    }
    function updateNumbersText(currentItem) {
        if (!g_objNumbers) return false;
        if (!currentItem) var currentItem = g_objSlider.getCurrentItem();
        var numItems = g_gallery.getNumItems();
        var numCurrentItem = currentItem.index + 1;
        g_objNumbers.html(numCurrentItem + " / " + numItems);
    }
    function showTextPanel() {
        if (!g_objTextPanel) return false;
        g_objTextPanel.getElement().show().stop().fadeTo(g_temp.fadeDuration, 1);
    }
    function showNumbers() {
        if (g_objNumbers) g_objNumbers.stop().fadeTo(g_temp.fadeDuration, 1);
    }
    function __________EVENTS_________() {}
    function onSliderDragStart() {
        if (g_temp.isCompact == false) return true;
        hideCompactElements();
    }
    function onZoomChange() {
        if (g_temp.isCompact == false) return true;
        g_temp.positionFrom = "onZoomChange";
        positionCloseButton(false, true);
        positionArrowsInside(false, true);
        if (g_temp.isCompact == true) {
            var isImageInPlace = g_objSlider.isCurrentSlideType("image") && g_objSlider.isCurrentImageInPlace() == true;
            if (isImageInPlace == false) {
                hideTextPanel();
                hideNumbers();
            } else {
                g_temp.positionFrom = "onZoomChange";
                showTextPanel();
                showNumbers();
            }
        }
    }
    function onSliderAfterReturn() {
        if (g_temp.isCompact == false) return true;
        g_temp.positionFrom = "onSliderAfterReturn";
        positionCloseButton(true);
        positionArrowsInside(true);
        var isChanged = handleCompactHeight();
        if (isChanged == false) handleCompactTextpanelSizes();
        showTextPanel();
        showNumbers();
    }
    function onSliderAfterPutImage(data, objSlide) {
        objSlide = jQuery(objSlide);
        if (g_temp.isCompact == false) return true;
        if (g_objSlider.isSlideCurrent(objSlide) == false) return true;
        g_temp.positionFrom = "onSliderAfterPutImage";
        positionCloseButton(true);
        positionArrowsInside(true);
        handleCompactTextpanelSizes();
    }
    function onSliderTransitionEnd() {
        var sliderOptions = g_objSlider.getOptions();
        var imagePaddingTop = sliderOptions.slider_image_padding_top;
        if (g_objTopPanel) {
            var panelHeight = g_objTopPanel.height();
            if (panelHeight != imagePaddingTop) refreshSliderItem(panelHeight);
        }
        if (g_temp.isCompact == true) {
            updateTextPanelText();
            updateNumbersText();
            g_temp.positionFrom = "onSliderTransitionEnd";
            positionCloseButton(true);
            positionArrowsInside(true);
            if (g_objSlider.isSlideActionActive() == false) {
                var isChanged = handleCompactHeight();
                if (isChanged == false) handleCompactTextpanelSizes();
            }
            showTextPanel();
            showNumbers();
        }
    }
    function onItemChange(data, currentItem) {
        if (g_temp.isCompact == false) {
            if (g_objNumbers) updateNumbersText(currentItem);
            if (g_objTextPanel) {
                updateTextPanelText(currentItem);
                if (g_temp.isRightNowOpened == false) {
                    g_objTextPanel.positionElements(false);
                    handlePanelHeight("onchange");
                    g_objTextPanel.positionPanel();
                }
            }
        } else {
            if (g_objSlider.isAnimating() == false) {
                if (g_objTextPanel) updateTextPanelText(currentItem);
                if (g_objNumbers) updateNumbersText(currentItem);
            }
        }
        if (g_temp.isSliderChangedOnce == false) {
            g_temp.isSliderChangedOnce = true;
            g_objThis.trigger(t.events.LIGHTBOX_INIT);
        }
    }
    function onSliderClick(data, event) {
        var slideType = g_objSlider.getSlideType();
        if (slideType != "image" && g_temp.isCompact == false && g_objSlider.isSlideActionActive()) return true;
        var isPreloading = g_objSlider.isPreloading();
        if (isPreloading == true) {
            t.close("slider");
            return true;
        }
        if (g_options.lightbox_close_on_emptyspace == true) {
            var isInside = g_objSlider.isMouseInsideSlideImage(event);
            if (isInside == false) t.close("slider_inside");
        }
    }
    function onResize() {
        positionElements();
    }
    function onPlayVideo() {
        if (g_objTopPanel) {
            hideTopPanel();
        } else {
            if (g_objNumbers) g_objNumbers.hide();
        }
        if (g_objArrowLeft && g_options.lightbox_hide_arrows_onvideoplay == true) {
            g_objArrowLeft.hide();
            g_objArrowRight.hide();
        }
    }
    function onStopVideo() {
        if (g_objTopPanel) {
            showTopPanel();
            handlePanelHeight("onStopVideo");
        } else {
            if (g_objNumbers) g_objNumbers.show();
        }
        if (g_objArrowLeft && g_options.lightbox_hide_arrows_onvideoplay == true) {
            g_objArrowLeft.show();
            g_objArrowRight.show();
        }
    }
    function onKeyPress(data, key, event) {
        var isScrollKey = false;
        switch (key) {
          case 27:
            if (g_temp.isOpened == true) t.close("keypress");
            break;

          case 38:
          case 40:
          case 33:
          case 34:
            isScrollKey = true;
            break;
        }
        if (g_temp.isOpened == true && isScrollKey == true) event.preventDefault();
    }
    function onImageMouseEnter() {
        if (g_temp.isArrowsOnHoverMode == true) showArrows(false, true);
    }
    function onImageMouseLeave(event) {
        g_temp.positionFrom = "hideCompactElements";
        if (g_temp.isArrowsOnHoverMode == true && isSliderImageInPlace() == true) hideArrows(false, true);
    }
    function onMouseMove(event) {
        g_temp.lastMouseX = event.pageX;
        g_temp.lastMouseY = event.pageY;
        var isHidden = isArrowsHidden();
        if (isHidden == true && isMouseInsideImage() && g_objSlider.isAnimating() == false) {
            g_temp.positionFrom = "onMouseMove";
            if (g_objArrowLeft && g_objArrowLeft.is(":animated") == false) showArrows(false, true);
        }
    }
    function onMouseWheel(event, delta, deltaX, deltaY) {
        if (g_temp.isOpened == false) return true;
        switch (g_options.gallery_mousewheel_role) {
          default:
          case "zoom":
            var slideType = g_objSlider.getSlideType();
            if (slideType != "image") event.preventDefault();
            break;

          case "none":
            event.preventDefault();
            break;

          case "advance":
            g_gallery.onGalleryMouseWheel(event, delta, deltaX, deltaY);
            break;
        }
    }
    function initEvents() {
        g_objOverlay.on("touchstart", function(event) {
            event.preventDefault();
        });
        g_objOverlay.on("touchend", function(event) {
            t.close("overlay");
        });
        g_functions.addClassOnHover(g_objArrowRight, "ug-arrow-hover");
        g_functions.addClassOnHover(g_objArrowLeft, "ug-arrow-hover");
        g_functions.addClassOnHover(g_objButtonClose);
        g_gallery.setNextButton(g_objArrowRight);
        g_gallery.setPrevButton(g_objArrowLeft);
        g_objButtonClose.click(function() {
            t.close("button");
        });
        g_objGallery.on(g_gallery.events.ITEM_CHANGE, onItemChange);
        if (g_objSlider) {
            jQuery(g_objSlider).on(g_objSlider.events.TRANSITION_END, onSliderTransitionEnd);
            jQuery(g_objSlider).on(g_objSlider.events.CLICK, onSliderClick);
            var objVideo = g_objSlider.getVideoObject();
            jQuery(objVideo).on(objVideo.events.PLAY_START, onPlayVideo);
            jQuery(objVideo).on(objVideo.events.PLAY_STOP, onStopVideo);
            jQuery(g_objSlider).on(g_objSlider.events.START_DRAG, onSliderDragStart);
            jQuery(g_objSlider).on(g_objSlider.events.TRANSITION_START, onSliderDragStart);
            jQuery(g_objSlider).on(g_objSlider.events.AFTER_DRAG_CHANGE, onSliderAfterReturn);
            jQuery(g_objSlider).on(g_objSlider.events.AFTER_RETURN, onSliderAfterReturn);
            jQuery(g_objSlider).on(g_objSlider.events.AFTER_PUT_IMAGE, onSliderAfterPutImage);
            jQuery(g_objSlider).on(g_objSlider.events.ZOOM_CHANGE, onZoomChange);
            jQuery(g_objSlider).on(g_objSlider.events.IMAGE_MOUSEENTER, onImageMouseEnter);
            jQuery(g_objSlider).on(g_objSlider.events.IMAGE_MOUSELEAVE, onImageMouseLeave);
        }
        jQuery(window).resize(function() {
            if (g_temp.isOpened == false) return true;
            g_functions.whenContiniousEventOver("lightbox_resize", onResize, 100);
        });
        g_objGallery.on(g_gallery.events.GALLERY_KEYPRESS, onKeyPress);
        if (g_temp.isArrowsOnHoverMode == true) {
            jQuery(document).bind("mousemove", onMouseMove);
        }
        g_objWrapper.on("mousewheel", onMouseWheel);
    }
    this.destroy = function() {
        jQuery(document).unbind("mousemove");
        g_objOverlay.off("touchstart");
        g_objOverlay.off("touchend");
        g_objButtonClose.off("click");
        g_objGallery.off(g_gallery.events.ITEM_CHANGE);
        if (g_objSlider) {
            jQuery(g_objSlider).off(g_objSlider.events.TRANSITION_END);
            jQuery(g_objSlider).off(g_objSlider.events.CLICK);
            jQuery(g_objSlider).off(g_objSlider.events.START_DRAG);
            jQuery(g_objSlider).off(g_objSlider.events.TRANSITION_START);
            jQuery(g_objSlider).off(g_objSlider.events.AFTER_DRAG_CHANGE);
            jQuery(g_objSlider).off(g_objSlider.events.AFTER_RETURN);
            var objVideo = g_objSlider.getVideoObject();
            jQuery(objVideo).off(objVideo.events.PLAY_START);
            jQuery(objVideo).off(objVideo.events.PLAY_STOP);
            jQuery(g_objSlider).on(g_objSlider.events.IMAGE_MOUSEENTER, onImageMouseEnter);
            jQuery(g_objSlider).on(g_objSlider.events.IMAGE_MOUSELEAVE, onImageMouseLeave);
            g_objSlider.destroy();
        }
        jQuery(window).unbind("resize");
        g_objGallery.off(g_gallery.events.GALLERY_KEYPRESS, onKeyPress);
        g_objWrapper.off("mousewheel");
        g_objWrapper.remove();
    };
    this.open = function(index) {
        var objItem = g_gallery.getItem(index);
        g_temp.isOpened = true;
        g_temp.isRightNowOpened = true;
        setTimeout(function() {
            g_temp.isRightNowOpened = false;
        }, 100);
        if (g_objSlider) {
            g_objSlider.setItem(objItem, "lightbox_open");
        }
        if (g_objTextPanel) {
            g_objTextPanel.setTextPlain(objItem.title, objItem.description);
        }
        g_objOverlay.stop().fadeTo(0, 0);
        g_objWrapper.show();
        g_objWrapper.fadeTo(0, 1);
        g_objOverlay.stop().fadeTo(g_temp.fadeDuration, g_options.lightbox_overlay_opacity);
        positionElements();
        if (g_temp.isCompact == true) {
            var isPreloading = g_objSlider.isPreloading();
            if (isPreloading == true) {
                actualHideCompactElements();
            } else {
                if (g_temp.isArrowsInside == true) {
                    g_objArrowLeft.hide();
                    g_objArrowRight.hide();
                }
            }
        }
        if (g_objSlider) g_objSlider.startSlideAction();
        g_objGallery.trigger(g_gallery.events.OPEN_LIGHTBOX, objItem);
    };
    this.close = function(fromWhere) {
        g_temp.isOpened = false;
        if (g_temp.isCompact == true) hideCompactElements();
        if (g_objSlider) g_objSlider.stopSlideAction();
        var slideType = g_objSlider.getSlideType();
        if (slideType != "image") g_objWrapper.hide(); else {
            g_objWrapper.fadeTo(g_temp.fadeDuration, 0, function() {
                g_objWrapper.hide();
            });
        }
        g_objGallery.trigger(g_gallery.events.CLOSE_LIGHTBOX);
    };
    this.init = function(gallery, customOptions) {
        initLightbox(gallery, customOptions);
    };
    function switchToWide() {
        g_temp.isCompact = false;
        modifyOptions();
        g_temp.isArrowsInside = false;
        g_temp.isArrowsOnHoverMode = false;
        g_options = jQuery.extend({}, g_temp.originalOptions);
        g_options.lightbox_arrows_position = "sides";
        g_objSlider.setOptions(g_options);
    }
    this.putHtml = function() {
        var isSmallWindow = g_gallery.isSmallWindow();
        if (isSmallWindow && g_temp.isCompact == true) switchToWide();
        putLightboxHtml();
    };
    this.run = function() {
        setProperties();
        if (g_objSlider) g_objSlider.run();
        initEvents();
    };
}

function UGCarousel() {
    var t = this, g_objThis = jQuery(this);
    var g_gallery = new UniteGalleryMain(), g_objGallery, g_objWrapper;
    var g_functions = new UGFunctions(), g_arrItems, g_objTileDesign = new UGTileDesign();
    var g_thumbs = new UGThumbsGeneral(), g_objCarouselWrapper, g_objInner, arrOrigTiles = [];
    var g_options = {
        carousel_padding: 8,
        carousel_space_between_tiles: 20,
        carousel_navigation_numtiles: 3,
        carousel_scroll_duration: 500,
        carousel_scroll_easing: "easeOutCubic",
        carousel_autoplay: true,
        carousel_autoplay_timeout: 3e3,
        carousel_autoplay_direction: "right",
        carousel_autoplay_pause_onhover: true,
        carousel_vertical_scroll_ondrag: false
    };
    this.events = {
        START_PLAY: "carousel_start_play",
        PAUSE_PLAY: "carousel_pause_play",
        STOP_PLAY: "carousel_stop_play"
    };
    var g_temp = {
        eventSizeChange: "thumb_size_change",
        isFirstTimeRun: true,
        carouselMaxWidth: null,
        tileWidth: 0,
        initTileWidth: 0,
        initTileHeight: 0,
        sideSpace: 1500,
        spaceActionSize: 500,
        numCurrent: 0,
        touchActive: false,
        startInnerPos: 0,
        lastTime: 0,
        startTime: 0,
        startMousePos: 0,
        lastMousePos: 0,
        scrollShortDuration: 200,
        scrollShortEasing: "easeOutQuad",
        handle: null,
        isPlayMode: false,
        isPaused: false,
        storedEventID: "carousel"
    };
    function __________GENERAL_________() {}
    function init(gallery, customOptions) {
        g_objects = gallery.getObjects();
        g_gallery = gallery;
        g_objGallery = jQuery(gallery);
        g_objWrapper = g_objects.g_objWrapper;
        g_arrItems = g_objects.g_arrItems;
        g_options = jQuery.extend(g_options, customOptions);
        g_objTileDesign.setFixedMode();
        g_objTileDesign.setApproveClickFunction(isApproveTileClick);
        g_objTileDesign.init(gallery, g_options);
        g_thumbs = g_objTileDesign.getObjThumbs();
        g_options = g_objTileDesign.getOptions();
        g_temp.initTileWidth = g_options.tile_width;
        g_temp.initTileHeight = g_options.tile_height;
        g_temp.tileWidth = g_options.tile_width;
    }
    function setHtml(objParent) {
        if (!objParent) var objParent = g_objWrapper;
        var html = "<div class='ug-carousel-wrapper'><div class='ug-carousel-inner'></div></div>";
        g_objWrapper.append(html);
        g_objCarouselWrapper = g_objWrapper.children(".ug-carousel-wrapper");
        g_objInner = g_objCarouselWrapper.children(".ug-carousel-inner");
        g_objTileDesign.setHtml(g_objInner);
        g_thumbs.getThumbs().fadeTo(0, 1);
    }
    function resizeTiles(newTileWidth, newTileHeight) {
        if (!newTileHeight) {
            var newTileHeight = g_temp.initTileHeight / g_temp.initTileWidth * newTileWidth;
        }
        g_temp.tileWidth = newTileWidth;
        var optUpdate = {
            tile_width: newTileWidth,
            tile_height: newTileHeight
        };
        g_objTileDesign.setOptions(optUpdate);
        g_options.tile_width = newTileWidth;
        g_options.tile_height = newTileHeight;
        g_objTileDesign.resizeAllTiles(newTileWidth);
        positionTiles(true);
    }
    function run() {
        if (g_temp.carouselMaxWidth === null) {
            throw new Error("The carousel width not set");
            return false;
        }
        if (g_temp.tileWidth < g_temp.initTileWidth) {
            var newTileWidth = g_temp.carouselMaxWidth - g_options.carousel_padding * 2;
            if (newTileWidth > g_temp.initTileWidth) newTileWidth = g_temp.initTileWidth;
            resizeTiles(newTileWidth);
            var numTiles = g_functions.getNumItemsInSpace(g_temp.carouselMaxWidth, newTileWidth, g_options.carousel_space_between_tiles);
        } else {
            var numTiles = g_functions.getNumItemsInSpace(g_temp.carouselMaxWidth, g_temp.tileWidth, g_options.carousel_space_between_tiles);
            if (numTiles <= 0) {
                numTiles = 1;
                var newTileWidth = g_temp.carouselMaxWidth - g_options.carousel_padding * 2;
                resizeTiles(newTileWidth);
            }
        }
        var realWidth = g_functions.getSpaceByNumItems(numTiles, g_temp.tileWidth, g_options.carousel_space_between_tiles);
        realWidth += g_options.carousel_padding * 2;
        g_objCarouselWrapper.width(realWidth);
        if (g_temp.isFirstTimeRun == true) {
            initEvents();
            g_objTileDesign.run();
            jQuery.each(g_arrItems, function(index, item) {
                item.objThumbWrapper.data("index", index);
                g_objWrapper.trigger(g_temp.eventSizeChange, [ item.objThumbWrapper, true ]);
                item.objTileOriginal = item.objThumbWrapper.clone(true, true);
            });
            positionTiles(true);
            if (g_options.carousel_autoplay == true) t.startAutoplay();
        } else {
            if (g_options.carousel_autoplay == true) t.pauseAutoplay();
            scrollToTile(0, false);
            if (g_options.carousel_autoplay == true) t.startAutoplay();
        }
        positionElements();
        g_temp.isFirstTimeRun = false;
    }
    function __________GETTERS_______() {}
    function getInnerPos() {
        return g_functions.getElementSize(g_objInner).left;
    }
    function getMousePos(event) {
        return g_functions.getMousePosition(event).pageX;
    }
    function getTiles() {
        var objTiles = g_objInner.children(".ug-thumb-wrapper");
        return objTiles;
    }
    function getNumTilesInSpace(space) {
        var numItems = g_functions.getNumItemsInSpace(space, g_temp.tileWidth, g_options.carousel_space_between_tiles);
        return numItems;
    }
    function getNumTiles() {
        return getTiles().length;
    }
    function getTile(numTile) {
        validateTileNum(numTile);
        var objTiles = getTiles();
        var objTile = jQuery(objTiles[numTile]);
        return objTile;
    }
    function getFirstTile() {
        return g_objInner.children(".ug-thumb-wrapper").first();
    }
    function getLastTile() {
        return g_objInner.children(".ug-thumb-wrapper").last();
    }
    function getTileClones(objTile, numClones, dir) {
        var index = objTile.data("index");
        if (index == undefined) {
            throw new Error("every tile should have index!");
        }
        var arrClonedItems = [];
        for (var i = 0; i < numClones; i++) {
            if (dir == "prev") var itemToAdd = g_gallery.getPrevItem(index, true); else var itemToAdd = g_gallery.getNextItem(index, true);
            if (!itemToAdd) {
                throw new Error("the item to add is empty");
            }
            var clonedTile = itemToAdd.objTileOriginal.clone(true, true);
            index = itemToAdd.index;
            clonedTile.addClass("cloned");
            arrClonedItems.push(clonedTile);
        }
        return arrClonedItems;
    }
    function getRemainSpaceRight() {
        var wrapperSize = g_functions.getElementSize(g_objCarouselWrapper);
        var innerSize = g_functions.getElementSize(g_objInner);
        var spaceTaken = innerSize.width - wrapperSize.width + innerSize.left;
        var spaceRemain = g_temp.sideSpace - spaceTaken;
        return spaceRemain;
    }
    function getRemainSpaceLeft() {
        var spaceTaken = -getInnerPos();
        var spaceRemain = g_temp.sideSpace - spaceTaken;
        return spaceRemain;
    }
    function getCarouselWidth() {
        var objSize = g_functions.getElementSize(g_objCarouselWrapper);
        return objSize.width;
    }
    function getNumTilesInCarousel() {
        var width = getCarouselWidth();
        var numTiles = getNumTilesInSpace(width);
        return numTiles;
    }
    function __________OTHER_METHODS_______() {}
    function positionTiles(setHeight) {
        if (!setHeight) var setHeight = false;
        var objTiles = getTiles();
        var posx = 0;
        var maxHeight = 0, totalWidth;
        jQuery.each(objTiles, function(index, objTile) {
            objTile = jQuery(objTile);
            g_functions.placeElement(objTile, posx, 0);
            var tileSize = g_functions.getElementSize(objTile);
            posx += tileSize.width + g_options.carousel_space_between_tiles;
            maxHeight = Math.max(maxHeight, tileSize.height);
            if (index == objTiles.length - 1) totalWidth = tileSize.right;
        });
        g_objInner.width(totalWidth);
        maxHeight += g_options.carousel_padding * 2;
        if (setHeight === true) {
            g_objInner.height(maxHeight);
            g_objCarouselWrapper.height(maxHeight);
        }
        scrollToTile(g_temp.numCurrent, false);
        return totalWidth;
    }
    function validateTileNum(numTile) {
        if (numTile > getTiles().length - 1) throw new Error("Wrogn tile number: " + numTile);
    }
    function addTiles(numTiles, dir) {
        if (dir == "left") var anchorTile = getFirstTile(); else var anchorTile = getLastTile();
        var clonesType = dir == "left" ? "prev" : "next";
        var arrNewTiles = getTileClones(anchorTile, numTiles, clonesType);
        jQuery.each(arrNewTiles, function(index, objTile) {
            if (dir == "left") g_objInner.prepend(objTile); else g_objInner.append(objTile);
            g_objWrapper.trigger(g_temp.eventSizeChange, objTile);
            g_objTileDesign.loadTileImage(objTile);
        });
    }
    function removeTiles(numTilesToRemove, direction) {
        validateTileNum(numTiles);
        var arrTiles = getTiles();
        var numTiles = arrTiles.length;
        for (var i = 0; i < numTilesToRemove; i++) {
            if (direction == "left") jQuery(arrTiles[i]).remove(); else {
                jQuery(arrTiles[numTiles - 1 - i]).remove();
            }
        }
    }
    function setInnerPos(pos) {
        var objCss = {
            left: pos + "px"
        };
        g_objInner.css(objCss);
    }
    function scrollToTile(numTile, isAnimation, isShort) {
        if (isAnimation === undefined) {
            var isAnimation = true;
            if (g_objInner.is(":animated")) return true;
        }
        var objTile = getTile(numTile);
        var objSize = g_functions.getElementSize(objTile);
        var posScroll = -objSize.left + g_options.carousel_padding;
        var objCss = {
            left: posScroll + "px"
        };
        if (isAnimation === true) {
            var duration = g_options.carousel_scroll_duration;
            var easing = g_options.carousel_scroll_easing;
            if (isShort === true) {
                duration = g_temp.scrollShortDuration;
                easing = g_temp.scrollShortEasing;
            }
            g_objInner.stop(true).animate(objCss, {
                duration: duration,
                easing: easing,
                queue: false,
                complete: function() {
                    g_temp.numCurrent = numTile;
                    fillSidesWithTiles(true);
                }
            });
        } else {
            g_temp.numCurrent = numTile;
            g_objInner.css(objCss);
        }
    }
    function getNeerestTileNum() {
        var innerPos = -getInnerPos();
        var numTiles = getNumTilesInSpace(innerPos);
        var tile1Pos = g_functions.getElementSize(getTile(numTiles)).left;
        var tile2Pos = g_functions.getElementSize(getTile(numTiles + 1)).left;
        if (Math.abs(tile1Pos - innerPos) < Math.abs(tile2Pos - innerPos)) return numTiles; else return numTiles + 1;
    }
    function scrollToNeerestTile() {
        var tileNum = getNeerestTileNum();
        scrollToTile(tileNum, true, true);
    }
    function fillSidesWithTiles() {
        var spaceLeft = getRemainSpaceLeft();
        var spaceRight = getRemainSpaceRight();
        var numItemsLeft = 0, numItemsRight = 0, numItemsRemoveLeft = 0, numItemsRemoveRight = 0;
        var numTiles = getNumTiles();
        if (spaceLeft > g_temp.spaceActionSize) {
            numItemsLeft = getNumTilesInSpace(spaceLeft);
            addTiles(numItemsLeft, "left");
            g_temp.numCurrent += numItemsLeft;
        } else if (spaceLeft < -g_temp.spaceActionSize) {
            var numItemsRemoveLeft = getNumTilesInSpace(Math.abs(spaceLeft));
            removeTiles(numItemsRemoveLeft, "left");
            g_temp.numCurrent -= numItemsRemoveLeft;
        }
        if (spaceRight > g_temp.spaceActionSize) {
            numItemsRight = getNumTilesInSpace(spaceRight);
            addTiles(numItemsRight, "right");
        } else if (spaceRight < -g_temp.spaceActionSize) {
            numItemsRemoveRight = getNumTilesInSpace(Math.abs(spaceRight));
            removeTiles(numItemsRemoveRight, "right");
        }
        if (numItemsRemoveRight > numTiles) {
            throw new Error("Can't remove more then num tiles");
        }
        var isPositioned = false;
        if (numItemsLeft || numItemsRight || numItemsRemoveLeft || numItemsRemoveRight) {
            positionTiles();
            isPositioned = true;
        }
        return isPositioned;
    }
    function positionElements(isFirstTime) {
        g_functions.placeElement(g_objInner, 0, g_options.carousel_padding);
        fillSidesWithTiles();
    }
    function __________AUTOPLAY_______() {}
    this.startAutoplay = function() {
        g_temp.isPlayMode = true;
        g_temp.isPaused = false;
        g_objThis.trigger(t.events.START_PLAY);
        if (g_temp.handle) clearInterval(g_temp.handle);
        g_temp.handle = setInterval(autoplayStep, g_options.carousel_autoplay_timeout);
    };
    this.unpauseAutoplay = function() {
        if (g_temp.isPlayMode == false) return true;
        if (g_temp.isPaused == false) return true;
        t.startAutoplay();
    };
    this.pauseAutoplay = function() {
        if (g_temp.isPlayMode == false) return true;
        g_temp.isPaused = true;
        if (g_temp.handle) clearInterval(g_temp.handle);
        g_objThis.trigger(t.events.PAUSE_PLAY);
    };
    this.stopAutoplay = function() {
        if (g_temp.isPlayMode == false) return true;
        g_temp.isPaused = false;
        g_temp.isPlayMode = false;
        if (g_temp.handle) clearInterval(g_temp.handle);
        g_objThis.trigger(t.events.STOP_PLAY);
    };
    function autoplayStep() {
        if (g_options.carousel_autoplay_direction == "left") {
            t.scrollRight(1);
        } else {
            t.scrollLeft(1);
        }
    }
    function __________EVENTS_______() {}
    function onTouchStart(event) {
        if (g_temp.touchActive == true) return true;
        g_temp.touchActive = true;
        t.pauseAutoplay();
        g_temp.startTime = jQuery.now();
        g_temp.startMousePos = getMousePos(event);
        g_temp.startInnerPos = getInnerPos();
        g_temp.lastTime = g_temp.startTime;
        g_temp.lastMousePos = g_temp.startMousePos;
        g_functions.storeEventData(event, g_temp.storedEventID);
    }
    function onTouchMove(event) {
        if (g_temp.touchActive == false) return true;
        g_functions.updateStoredEventData(event, g_temp.storedEventID);
        event.preventDefault();
        var scrollDir = null;
        if (g_options.carousel_vertical_scroll_ondrag == true) scrollDir = g_functions.handleScrollTop(g_temp.storedEventID);
        if (scrollDir === "vert") return true;
        g_temp.lastMousePos = getMousePos(event);
        var diff = g_temp.lastMousePos - g_temp.startMousePos;
        var innerPos = g_temp.startInnerPos + diff;
        var direction = diff > 0 ? "prev" : "next";
        var innerSize = g_functions.getElementSize(g_objInner).width;
        if (innerPos > 0 && direction == "prev") {
            innerPos = innerPos / 3;
        }
        if (innerPos < -innerSize && direction == "next") {
            innerPos = g_temp.startInnerPos + diff / 3;
        }
        setInnerPos(innerPos);
    }
    function onTouchEnd(event) {
        if (g_temp.touchActive == false) return true;
        g_temp.touchActive = false;
        scrollToNeerestTile();
        t.unpauseAutoplay();
    }
    function onMouseEnter(event) {
        if (g_options.carousel_autoplay_pause_onhover == false) return true;
        if (g_temp.isPlayMode == true && g_temp.isPaused == false) t.pauseAutoplay();
    }
    function onMouseLeave(event) {
        if (g_options.carousel_autoplay_pause_onhover == false) return true;
        t.unpauseAutoplay();
    }
    function initEvents() {
        g_objTileDesign.initEvents();
        g_objCarouselWrapper.bind("mousedown touchstart", onTouchStart);
        jQuery("body").bind("mousemove touchmove", onTouchMove);
        jQuery(window).add("body").bind("mouseup touchend", onTouchEnd);
        g_objCarouselWrapper.hover(onMouseEnter, onMouseLeave);
    }
    this.destroy = function() {
        if (g_temp.handle) clearInterval(g_temp.handle);
        g_objThis.off(t.events.START_PLAY);
        g_objThis.off(t.events.STOP_PLAY);
        g_objCarouselWrapper.unbind("mousedown");
        g_objCarouselWrapper.unbind("touchstart");
        jQuery("body").unbind("mousemove");
        jQuery("body").unbind("touchmove");
        jQuery(window).add("body").unbind("mouseup").unbind("touchend");
        g_objCarouselWrapper.off("mouseenter").off("mouseleave");
        g_objTileDesign.destroy();
    };
    this.init = function(gallery, customOptions, width) {
        if (width) this.setMaxWidth(width);
        init(gallery, customOptions);
    };
    this.setMaxWidth = function(width) {
        g_temp.carouselMaxWidth = width;
    };
    this.setHtml = function(objParent) {
        setHtml(objParent);
    };
    this.getElement = function() {
        return g_objCarouselWrapper;
    };
    this.getObjTileDesign = function() {
        return g_objTileDesign;
    };
    this.getEstimatedHeight = function() {
        var height = g_options.tile_height + g_options.carousel_padding * 2;
        return height;
    };
    this.run = function() {
        run();
    };
    this.scrollRight = function(tilesToScroll) {
        if (!tilesToScroll || typeof tilesToScroll == "object") var tilesToScroll = g_options.carousel_navigation_numtiles;
        var numTilesInCarousel = getNumTilesInCarousel();
        if (tilesToScroll > numTilesInCarousel) tilesToScroll = numTilesInCarousel;
        var numPrev = g_temp.numCurrent - tilesToScroll;
        if (numPrev <= 0) numPrev = 0;
        scrollToTile(numPrev);
    };
    this.scrollLeft = function(tilesToScroll) {
        if (!tilesToScroll || typeof tilesToScroll == "object") var tilesToScroll = g_options.carousel_navigation_numtiles;
        var numTilesInCarousel = getNumTilesInCarousel();
        if (tilesToScroll > numTilesInCarousel) tilesToScroll = numTilesInCarousel;
        var numTiles = getNumTiles();
        var numNext = g_temp.numCurrent + tilesToScroll;
        if (numNext >= numTiles) numNext = numTiles - 1;
        scrollToTile(numNext);
    };
    this.setScrollLeftButton = function(objButton) {
        g_functions.setButtonMobileReady(objButton);
        g_functions.setButtonOnClick(objButton, t.scrollLeft);
    };
    this.setScrollRightButton = function(objButton) {
        g_functions.setButtonMobileReady(objButton);
        g_functions.setButtonOnClick(objButton, t.scrollRight);
    };
    this.setPlayPauseButton = function(objButton) {
        g_functions.setButtonMobileReady(objButton);
        if (g_temp.isPlayMode == true && g_temp.isPaused == false) {
            objButton.addClass("ug-pause-icon");
        }
        g_objThis.on(t.events.START_PLAY, function() {
            objButton.addClass("ug-pause-icon");
        });
        g_objThis.on(t.events.STOP_PLAY, function() {
            objButton.removeClass("ug-pause-icon");
        });
        g_functions.setButtonOnClick(objButton, function() {
            if (g_temp.isPlayMode == false || g_temp.isPaused == true) t.startAutoplay(); else t.stopAutoplay();
        });
    };
    function isApproveTileClick() {
        var passedTime = g_temp.lastTime - g_temp.startTime;
        var passedDistanceAbs = Math.abs(g_temp.lastMousePos - g_temp.startMousePos);
        if (passedTime > 300) return false;
        if (passedDistanceAbs > 30) return false;
        return true;
    }
}

function UGTabs() {
    var t = this, g_objThis = jQuery(this), g_objGallery;
    var g_gallery = new UniteGalleryMain(), g_functions = new UGFunctions();
    var g_objTabs, g_objSelect;
    var g_options = {
        tabs_type: "tabs",
        tabs_container: "#ug_tabs",
        tabs_class_selected: "ug-tab-selected"
    };
    this.events = {};
    function initTabs(gallery, customOptions) {
        g_gallery = gallery;
        g_objGallery = jQuery(g_gallery);
        g_options = jQuery.extend(g_options, customOptions);
        if (g_options.tabs_type == "select") g_objSelect = jQuery(g_options.tabs_container); else g_objTabs = jQuery(g_options.tabs_container + " .ug-tab");
    }
    function runTabs() {
        initEvents();
    }
    function requestGalleryItems(catid) {
        g_gallery.requestNewItems(catid);
    }
    function onTabClick() {
        var classSelected = g_options.tabs_class_selected;
        var objTab = jQuery(this);
        if (objTab.hasClass(classSelected)) return true;
        g_objTabs.not(objTab).removeClass(classSelected);
        objTab.addClass(classSelected);
        var catID = objTab.data("catid");
        if (!catID) return true;
        requestGalleryItems(catID);
    }
    function onSelectChange() {
        var objSelect = jQuery(this);
        var catID = objSelect.val();
        if (!catID) return true;
        requestGalleryItems(catID);
    }
    function initEvents() {
        if (g_options.tabs_type == "select") g_objSelect.change(onSelectChange); else g_objTabs.click(onTabClick);
    }
    this.destroy = function() {
        if (g_objSelect) g_objSelect.off("change");
        if (g_objTabs) g_objTabs.off("click");
    };
    this.init = function(gallery, customOptions) {
        initTabs(gallery, customOptions);
    };
    this.run = function() {
        runTabs();
    };
}

function UG_API(gallery) {
    var t = this, g_objThis = jQuery(t);
    var g_gallery = new UniteGalleryMain(), g_objGallery;
    var g_arrEvents = [];
    g_gallery = gallery;
    g_objGallery = jQuery(gallery);
    this.events = {
        API_INIT_FUNCTIONS: "api_init",
        API_ON_EVENT: "api_on_event"
    };
    function convertItemDataForOutput(item) {
        var output = {
            index: item.index,
            title: item.title,
            description: item.description,
            urlImage: item.urlImage,
            urlThumb: item.urlThumb
        };
        var addData = item.objThumbImage.data();
        for (var key in addData) {
            switch (key) {
              case "image":
              case "description":
                continue;
                break;
            }
            output[key] = addData[key];
        }
        return output;
    }
    this.on = function(event, handlerFunction, notCache) {
        if (notCache !== true) {
            g_arrEvents.push({
                event: event,
                func: handlerFunction
            });
        }
        switch (event) {
          case "item_change":
            g_objGallery.on(g_gallery.events.ITEM_CHANGE, function() {
                var currentItem = g_gallery.getSelectedItem();
                var output = convertItemDataForOutput(currentItem);
                handlerFunction(output.index, output);
            });
            break;

          case "resize":
            g_objGallery.on(g_gallery.events.SIZE_CHANGE, handlerFunction);
            break;

          case "enter_fullscreen":
            g_objGallery.on(g_gallery.events.ENTER_FULLSCREEN, handlerFunction);
            break;

          case "exit_fullscreen":
            g_objGallery.on(g_gallery.events.EXIT_FULLSCREEN, handlerFunction);
            break;

          case "play":
            g_objGallery.on(g_gallery.events.START_PLAY, handlerFunction);
            break;

          case "stop":
            g_objGallery.on(g_gallery.events.STOP_PLAY, handlerFunction);
            break;

          case "pause":
            g_objGallery.on(g_gallery.events.PAUSE_PLAYING, handlerFunction);
            break;

          case "continue":
            g_objGallery.on(g_gallery.events.CONTINUE_PLAYING, handlerFunction);
            break;

          case "open_lightbox":
            g_objGallery.on(g_gallery.events.OPEN_LIGHTBOX, handlerFunction);
            break;

          case "close_lightbox":
            g_objGallery.on(g_gallery.events.CLOSE_LIGHTBOX, handlerFunction);
            break;

          default:
            if (console) console.log("wrong api event: " + event);
            break;
        }
        g_objGallery.trigger(t.events.API_ON_EVENT, [ event, handlerFunction ]);
    };
    this.play = function() {
        g_gallery.startPlayMode();
    };
    this.stop = function() {
        g_gallery.stopPlayMode();
    };
    this.togglePlay = function() {
        g_gallery.togglePlayMode();
    };
    this.enterFullscreen = function() {
        g_gallery.toFullScreen();
    };
    this.exitFullscreen = function() {
        g_gallery.exitFullScreen();
    };
    this.toggleFullscreen = function() {
        g_gallery.toggleFullscreen();
    };
    this.resetZoom = function() {
        var objSlider = g_gallery.getObjSlider();
        if (!objSlider) return false;
        objSlider.zoomBack();
    };
    this.zoomIn = function() {
        var objSlider = g_gallery.getObjSlider();
        if (!objSlider) return false;
        objSlider.zoomIn();
    };
    this.zoomOut = function() {
        var objSlider = g_gallery.getObjSlider();
        if (!objSlider) return false;
        objSlider.zoomOut();
    };
    this.nextItem = function() {
        g_gallery.nextItem();
    };
    this.prevItem = function() {
        g_gallery.prevItem();
    };
    this.selectItem = function(numItem) {
        g_gallery.selectItem(numItem);
    };
    this.resize = function(width, height) {
        if (height) g_gallery.resize(width, height); else g_gallery.resize(width);
    };
    this.getItem = function(numItem) {
        var data = g_gallery.getItem(numItem);
        var output = convertItemDataForOutput(data);
        return output;
    };
    this.getNumItems = function() {
        var numItems = g_gallery.getNumItems();
        return numItems;
    };
    this.reloadGallery = function(customOptions) {
        if (!customOptions) var customOptions = {};
        g_gallery.run(null, customOptions);
        g_arrEvents.map(function(obj) {
            t.on(obj.event, obj.func, true);
        });
    };
    this.destroy = function() {
        g_gallery.destroy();
    };
    g_objGallery.trigger(t.events.API_INIT_FUNCTIONS, t);
}

function UGLoadMore() {
    var t = this, g_objThis = jQuery(this), g_objGallery;
    var g_gallery = new UniteGalleryMain(), g_functions = new UGFunctions();
    var g_objWrapper, g_objButton, g_objLoader, g_objError;
    var g_temp = {
        isInited: false
    };
    var g_options = {
        loadmore_container: "ug_loadmore_wrapper"
    };
    this.events = {};
    function initObjects() {
        g_objWrapper = jQuery("#" + g_options.loadmore_container);
        if (g_objWrapper.length == 0) return false;
        g_objButton = g_objWrapper.find(".ug-loadmore-button");
        if (g_objButton.length == 0) return false;
        g_objLoader = g_objWrapper.find(".ug-loadmore-loader");
        if (g_objLoader.length == 0) return false;
        g_objError = g_objWrapper.find(".ug-loadmore-error");
        if (g_objError.length == 0) return false;
        g_temp.isInited = true;
    }
    function showLoadmore() {
        g_objWrapper.show();
    }
    function onLoadmoreClick() {
        g_objButton.hide();
        g_objLoader.show();
        var data = {
            numitems: g_gallery.getNumItems()
        };
        g_gallery.ajaxRequest("front_loadmore", data, function(response) {
            g_objLoader.hide();
            var htmlItems = response.html_items;
            var showLoadmore = response.show_loadmore;
            if (showLoadmore == true) {
                g_objButton.blur().show();
                g_objLoader.hide();
            } else {
                g_objWrapper.hide();
            }
            g_gallery.addItems(htmlItems);
        }, function(errorText) {
            errorText = "Ajax Error!" + errorText;
            g_objLoader.hide();
            g_objError.show();
            g_objError.html(errorText);
        });
    }
    function initEvents() {
        g_gallery.onEvent("tiles_first_placed", showLoadmore);
        g_objButton.click(onLoadmoreClick);
    }
    this.destroy = function() {
        if (g_temp.isInited == false) return false;
    };
    this.init = function(gallery, customOptions) {
        g_gallery = gallery;
        g_objGallery = jQuery(g_gallery);
        g_options = jQuery.extend(g_options, customOptions);
        initObjects();
        if (g_temp.isInited == false) {
            trace("load more not inited, something is wrong");
            return false;
        }
        initEvents();
    };
}
//# sourceMappingURL=unitegallery.js.map
