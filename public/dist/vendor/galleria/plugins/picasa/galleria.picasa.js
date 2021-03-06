(function($) {
    Galleria.requires(1.25, "The Picasa Plugin requires Galleria version 1.2.5 or later.");
    var PATH = Galleria.utils.getScriptPath();
    Galleria.Picasa = function() {
        this.options = {
            max: 30,
            imageSize: "medium",
            thumbSize: "thumb",
            complete: function() {}
        };
    };
    Galleria.Picasa.prototype = {
        constructor: Galleria.Picasa,
        search: function(phrase, callback) {
            return this._call("search", "all", {
                q: phrase
            }, callback);
        },
        user: function(username, callback) {
            return this._call("user", "user/" + username, callback);
        },
        useralbum: function(username, album, callback) {
            return this._call("useralbum", "user/" + username + "/album/" + album, callback);
        },
        setOptions: function(options) {
            $.extend(this.options, options);
            return this;
        },
        _call: function(type, url, params, callback) {
            url = "https://picasaweb.google.com/data/feed/api/" + url + "?";
            if (typeof params == "function") {
                callback = params;
                params = {};
            }
            var self = this;
            params = $.extend({
                kind: "photo",
                access: "public",
                "max-results": this.options.max,
                thumbsize: this._getSizes().join(","),
                alt: "json-in-script",
                callback: "?"
            }, params);
            $.each(params, function(key, value) {
                url += "&" + key + "=" + value;
            });
            var data = false;
            Galleria.utils.wait({
                until: function() {
                    return data;
                },
                success: function() {
                    self._parse.call(self, data.feed.entry, callback);
                },
                error: function() {
                    var msg = "";
                    if (type == "user") {
                        msg = "user not found.";
                    } else if (type == "useralbum") {
                        msg = "album or user not found.";
                    }
                    Galleria.raise("Picasa request failed" + (msg ? ": " + msg : "."));
                },
                timeout: 5e3
            });
            $.getJSON(url, function(result) {
                data = result;
            });
            return self;
        },
        _getSizes: function() {
            var self = this, norm = {
                small: "72c",
                thumb: "104u",
                medium: "640u",
                big: "1024u",
                original: "1600u"
            }, op = self.options, t = {}, n, sz = [ 32, 48, 64, 72, 94, 104, 110, 128, 144, 150, 160, 200, 220, 288, 320, 400, 512, 576, 640, 720, 800, 912, 1024, 1152, 1280, 1440, 1600 ];
            $([ "thumbSize", "imageSize" ]).each(function() {
                if (op[this] in norm) {
                    t[this] = norm[op[this]];
                } else {
                    n = Galleria.utils.parseValue(op[this]);
                    if (n > 1600) {
                        n = 1600;
                    } else {
                        $.each(sz, function(i) {
                            if (n < this) {
                                n = sz[i - 1];
                                return false;
                            }
                        });
                    }
                    t[this] = n;
                }
            });
            return [ t.thumbSize, t.imageSize, "1280u" ];
        },
        _parse: function(data, callback) {
            var self = this, gallery = [], img;
            $.each(data, function() {
                img = this.media$group.media$thumbnail;
                gallery.push({
                    thumb: img[0].url,
                    image: img[1].url,
                    big: img[2].url,
                    title: this.summary.$t
                });
            });
            callback.call(this, gallery);
        }
    };
    var load = Galleria.prototype.load;
    Galleria.prototype.load = function() {
        if (arguments.length || typeof this._options.picasa !== "string") {
            load.apply(this, Galleria.utils.array(arguments));
            return;
        }
        var self = this, args = Galleria.utils.array(arguments), picasa = this._options.picasa.split(":"), p, opts = $.extend({}, self._options.picasaOptions), loader = typeof opts.loader !== "undefined" ? opts.loader : $("<div>").css({
            width: 48,
            height: 48,
            opacity: .7,
            background: "#000 url(" + PATH + "loader.gif) no-repeat 50% 50%"
        });
        if (picasa.length) {
            if (typeof Galleria.Picasa.prototype[picasa[0]] !== "function") {
                Galleria.raise(picasa[0] + " method not found in Picasa plugin");
                return load.apply(this, args);
            }
            if (!picasa[1]) {
                Galleria.raise("No picasa argument found");
                return load.apply(this, args);
            }
            window.setTimeout(function() {
                self.$("target").append(loader);
            }, 100);
            p = new Galleria.Picasa();
            if (typeof self._options.picasaOptions === "object") {
                p.setOptions(self._options.picasaOptions);
            }
            var arg = [];
            if (picasa[0] == "useralbum") {
                arg = picasa[1].split("/");
                if (arg.length != 2) {
                    Galleria.raise("Picasa useralbum not correctly formatted (should be [user]/[album])");
                    return;
                }
            } else {
                arg.push(picasa[1]);
            }
            arg.push(function(data) {
                self._data = data;
                loader.remove();
                self.trigger(Galleria.DATA);
                p.options.complete.call(p, data);
            });
            p[picasa[0]].apply(p, arg);
        } else {
            load.apply(this, args);
        }
    };
})(jQuery);
//# sourceMappingURL=galleria.picasa.js.map
