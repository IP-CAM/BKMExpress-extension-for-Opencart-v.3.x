!function (t, e) {
    "object" == typeof exports && "object" == typeof module ? module.exports = e() : "function" == typeof define && define.amd ? define([], e) : "object" == typeof exports ? exports.Bex = e() : t.Bex = e()
}(this, function () {
    return function (t) {
        function e(n) {
            if (r[n]) return r[n].exports;
            var o = r[n] = {exports: {}, id: n, loaded: !1};
            return t[n].call(o.exports, o, o.exports, e), o.loaded = !0, o.exports
        }

        var r = {};
        return e.m = t, e.c = r, e.p = "javascripts/", e(0)
    }([function (t, e, r) {
        t.exports = r(1)
    }, function (t, e, r) {
        "use strict";

        function n(t) {
            return t && t.__esModule ? t : {"default": t}
        }

        function o(t, e) {
            if (!(t instanceof e)) throw new TypeError("Cannot call a class as a function")
        }

        var i = function () {
            function t(t, e) {
                for (var r = 0; r < e.length; r++) {
                    var n = e[r];
                    n.enumerable = n.enumerable || !1, n.configurable = !0, "value" in n && (n.writable = !0), Object.defineProperty(t, n.key, n)
                }
            }

            return function (e, r, n) {
                return r && t(e.prototype, r), n && t(e, n), e
            }
        }(), s = r(2);
        r(22);
        var u = r(23), a = r(24), f = r(25), c = r(26), h = r(27), l = n(h), p = r(28);
        r(29);
        var y = s.Symbol, d = s.Symbol, g = function () {
            function t(e) {
                if (o(this, t), e !== d) throw"Cannot constructor application"
            }

            return i(t, [{
                key: "init", value: function (t, e, r) {
                    (0, c.checkInitParameters)(t.path, t.token, e, r);
                    var n = JSON.parse(atob(t.token.split(".")[1])), o = "SgkTicket" === n.cls.split(".")[8];
                    if (t.path && e) {
                        var i = p.RESOURCE_ROOT + "bex-express.html", s = {};
                        s.url = i, r.skipButton ? (s.width = "0", s.height = "0", s.minHeight = "0") : (s.width = r.buttonSize ? r.buttonSize[0] : "200", s.height = r.buttonSize ? r.buttonSize[1] : "70", s.minHeight = r.buttonSize ? r.buttonSize[1] : "320");
                        var h = (0, u.createFrame)(s);
                        document.getElementById(r.container).appendChild(h);
                        var y = null, d = "", g = function () {
                            var t = document.getElementById(r.container), n = r.id || "test",
                                o = document.getElementById(n);
                            if ("modal" === e) {
                                var i = window.innerHeight / 5;
                                d = document.body.style.position, (0, a.createApp)(t, o, e, r), y = setInterval(function () {
                                    window.innerHeight < i + 600 ? t.style.paddingTop = "0px" : t.style.paddingTop = i
                                }, 150)
                            }
                            "dropin" === e && (0, a.createApp)(t, o, e, r.frameStyle), document.body.style.overflow = "hidden !important"
                        };
                        l["default"].subscribe("openSpa", g);
                        var v = function E(n) {
                            "ok" === n.contents && l["default"].publish("ticket", {
                                from: "bex",
                                contents: [t.id, t.path, t.token, r.skipButton, e, o]
                            }), null !== r.skipButton && r.skipButton && l["default"].unsubscribe("expressReady", E)
                        };
                        l["default"].subscribe("expressReady", v);
                        var w = function S(t) {
                            console.log("Payment completed."), clearInterval(y), (0, f.resetFrameStyle)(r, h, r.buttonSize), r.onComplete(t.status), null !== r.skipButton && r.skipButton && (l["default"].unsubscribe("paymentComplete", S), l["default"].unsubscribe("cancelApp", b))
                        };
                        l["default"].subscribe("paymentComplete", w);
                        var b = function x(t) {
                            console.info("App canceled."), clearInterval(y), document.body.style.position = d, (0, f.resetFrameStyle)(r, h, r.buttonSize), r.onCancel(t.canceled), null !== r.skipButton && r.skipButton && (l["default"].unsubscribe("cancelApp", x), l["default"].unsubscribe("paymentComplete", w))
                        };
                        l["default"].subscribe("cancelApp", b);
                        var m = window.setInterval(function () {
                            h && h.src.indexOf(i) < 0 && (alert("Iframe url Changed ! Please Login again."), console.info("App canceled."), (0, f.resetFrameStyle)(r, h, r.buttonSize), h.src = i, clearInterval(m))
                        }, 300)
                    }
                }
            }, {
                key: "refresh", value: function (t) {
                    l["default"].publish("ticketFromCancelApp", {from: "bex", contents: [t.id, t.path, t.token]})
                }
            }], [{
                key: "getInstance", get: function () {
                    return this[y] || (this[y] = new t(d)), this[y]
                }
            }]), t
        }();
        t.exports = {init: g.getInstance.init, refresh: g.getInstance.refresh, version: "1.0.0"}
    }, function (t, e, r) {
        "use strict";
        t.exports = r(3)() ? Symbol : r(4)
    }, function (t, e) {
        "use strict";
        var r = {object: !0, symbol: !0};
        t.exports = function () {
            var t;
            if ("function" != typeof Symbol) return !1;
            t = Symbol("test symbol");
            try {
                String(t)
            } catch (e) {
                return !1
            }
            return !!r[typeof Symbol.iterator] && (!!r[typeof Symbol.toPrimitive] && !!r[typeof Symbol.toStringTag])
        }
    }, function (t, e, r) {
        "use strict";
        var n, o, i, s, u = r(5), a = r(20), f = Object.create, c = Object.defineProperties, h = Object.defineProperty,
            l = Object.prototype, p = f(null);
        if ("function" == typeof Symbol) {
            n = Symbol;
            try {
                String(n()), s = !0
            } catch (y) {
            }
        }
        var d = function () {
            var t = f(null);
            return function (e) {
                for (var r, n, o = 0; t[e + (o || "")];) ++o;
                return e += o || "", t[e] = !0, r = "@@" + e, h(l, r, u.gs(null, function (t) {
                    n || (n = !0, h(this, r, u(t)), n = !1)
                })), r
            }
        }();
        i = function (t) {
            if (this instanceof i) throw new TypeError("Symbol is not a constructor");
            return o(t)
        }, t.exports = o = function g(t) {
            var e;
            if (this instanceof g) throw new TypeError("Symbol is not a constructor");
            return s ? n(t) : (e = f(i.prototype), t = void 0 === t ? "" : String(t), c(e, {
                __description__: u("", t),
                __name__: u("", d(t))
            }))
        }, c(o, {
            "for": u(function (t) {
                return p[t] ? p[t] : p[t] = o(String(t))
            }),
            keyFor: u(function (t) {
                var e;
                a(t);
                for (e in p) if (p[e] === t) return e
            }),
            hasInstance: u("", n && n.hasInstance || o("hasInstance")),
            isConcatSpreadable: u("", n && n.isConcatSpreadable || o("isConcatSpreadable")),
            iterator: u("", n && n.iterator || o("iterator")),
            match: u("", n && n.match || o("match")),
            replace: u("", n && n.replace || o("replace")),
            search: u("", n && n.search || o("search")),
            species: u("", n && n.species || o("species")),
            split: u("", n && n.split || o("split")),
            toPrimitive: u("", n && n.toPrimitive || o("toPrimitive")),
            toStringTag: u("", n && n.toStringTag || o("toStringTag")),
            unscopables: u("", n && n.unscopables || o("unscopables"))
        }), c(i.prototype, {
            constructor: u(o), toString: u("", function () {
                return this.__name__
            })
        }), c(o.prototype, {
            toString: u(function () {
                return "Symbol (" + a(this).__description__ + ")"
            }), valueOf: u(function () {
                return a(this)
            })
        }), h(o.prototype, o.toPrimitive, u("", function () {
            var t = a(this);
            return "symbol" == typeof t ? t : t.toString()
        })), h(o.prototype, o.toStringTag, u("c", "Symbol")), h(i.prototype, o.toStringTag, u("c", o.prototype[o.toStringTag])), h(i.prototype, o.toPrimitive, u("c", o.prototype[o.toPrimitive]))
    }, function (t, e, r) {
        "use strict";
        var n, o = r(6), i = r(15), s = r(16), u = r(17);
        n = t.exports = function (t, e) {
            var r, n, s, a, f;
            return arguments.length < 2 || "string" != typeof t ? (a = e, e = t, t = null) : a = arguments[2], null == t ? (r = s = !0, n = !1) : (r = u.call(t, "c"), n = u.call(t, "e"), s = u.call(t, "w")), f = {
                value: e,
                configurable: r,
                enumerable: n,
                writable: s
            }, a ? o(i(a), f) : f
        }, n.gs = function (t, e, r) {
            var n, a, f, c;
            return "string" != typeof t ? (f = r, r = e, e = t, t = null) : f = arguments[3], null == e ? e = void 0 : s(e) ? null == r ? r = void 0 : s(r) || (f = r, r = void 0) : (f = e, e = r = void 0), null == t ? (n = !0, a = !1) : (n = u.call(t, "c"), a = u.call(t, "e")), c = {
                get: e,
                set: r,
                configurable: n,
                enumerable: a
            }, f ? o(i(f), c) : c
        }
    }, function (t, e, r) {
        "use strict";
        t.exports = r(7)() ? Object.assign : r(8)
    }, function (t, e) {
        "use strict";
        t.exports = function () {
            var t, e = Object.assign;
            return "function" == typeof e && (t = {foo: "raz"}, e(t, {bar: "dwa"}, {trzy: "trzy"}), t.foo + t.bar + t.trzy === "razdwatrzy")
        }
    }, function (t, e, r) {
        "use strict";
        var n = r(9), o = r(14), i = Math.max;
        t.exports = function (t, e) {
            var r, s, u, a = i(arguments.length, 2);
            for (t = Object(o(t)), u = function (n) {
                try {
                    t[n] = e[n]
                } catch (o) {
                    r || (r = o)
                }
            }, s = 1; s < a; ++s) e = arguments[s], n(e).forEach(u);
            if (void 0 !== r) throw r;
            return t
        }
    }, function (t, e, r) {
        "use strict";
        t.exports = r(10)() ? Object.keys : r(11)
    }, function (t, e) {
        "use strict";
        t.exports = function () {
            try {
                return Object.keys("primitive"), !0
            } catch (t) {
                return !1
            }
        }
    }, function (t, e, r) {
        "use strict";
        var n = r(12), o = Object.keys;
        t.exports = function (t) {
            return o(n(t) ? Object(t) : t)
        }
    }, function (t, e, r) {
        "use strict";
        var n = r(13)();
        t.exports = function (t) {
            return t !== n && null !== t
        }
    }, function (t, e) {
        "use strict";
        t.exports = function () {
        }
    }, function (t, e, r) {
        "use strict";
        var n = r(12);
        t.exports = function (t) {
            if (!n(t)) throw new TypeError("Cannot use null or undefined");
            return t
        }
    }, function (t, e, r) {
        "use strict";
        var n = r(12), o = Array.prototype.forEach, i = Object.create, s = function (t, e) {
            var r;
            for (r in t) e[r] = t[r]
        };
        t.exports = function (t) {
            var e = i(null);
            return o.call(arguments, function (t) {
                n(t) && s(Object(t), e)
            }), e
        }
    }, function (t, e) {
        "use strict";
        t.exports = function (t) {
            return "function" == typeof t
        }
    }, function (t, e, r) {
        "use strict";
        t.exports = r(18)() ? String.prototype.contains : r(19)
    }, function (t, e) {
        "use strict";
        var r = "razdwatrzy";
        t.exports = function () {
            return "function" == typeof r.contains && (r.contains("dwa") === !0 && r.contains("foo") === !1)
        }
    }, function (t, e) {
        "use strict";
        var r = String.prototype.indexOf;
        t.exports = function (t) {
            return r.call(this, t, arguments[1]) > -1
        }
    }, function (t, e, r) {
        "use strict";
        var n = r(21);
        t.exports = function (t) {
            if (!n(t)) throw new TypeError(t + " is not a symbol");
            return t
        }
    }, function (t, e) {
        "use strict";
        t.exports = function (t) {
            return !!t && ("symbol" == typeof t || !!t.constructor && ("Symbol" === t.constructor.name && "Symbol" === t[t.constructor.toStringTag]))
        }
    }, function (t, e) {
        /** @license
         * eventsource.js
         * Available under MIT License (MIT)
         * https://github.com/Yaffle/EventSource/
         */
        !function (t) {
            "use strict";

            function e() {
                this.data = {}
            }

            function r() {
                this.listeners = new e
            }

            function n(t) {
                c(function () {
                    throw t
                }, 0)
            }

            function o(t) {
                this.type = t, this.target = void 0
            }

            function i(t, e) {
                o.call(this, t), this.data = e.data, this.lastEventId = e.lastEventId
            }

            function s(t, e) {
                var r = t;
                return r !== r && (r = e), r < T ? T : r > R ? R : r
            }

            function u(t, e, r) {
                try {
                    "function" == typeof e && e.call(t, r)
                } catch (o) {
                    n(o)
                }
            }

            function a(e, n) {
                function a() {
                    z = b, void 0 != L && (L.abort(), L = void 0), 0 !== j && (h(j), j = 0), 0 !== D && (h(D), D = 0), U.readyState = b
                }

                function f(t) {
                    var r = "";
                    if (z === w || z === v) try {
                        r = L.responseText
                    } catch (n) {
                    }
                    var f = void 0, l = !1;
                    if (z === v) {
                        var p = 0, y = "", d = void 0;
                        if ("contentType" in L) "" !== t && "error" !== t && (p = 200, y = "OK", d = L.contentType); else try {
                            p = L.status, y = L.statusText, d = L.getResponseHeader("Content-Type")
                        } catch (n) {
                            p = 0, y = "", d = void 0
                        }
                        if (void 0 == d && (d = ""), 0 === p && "" === y && "load" === t && "" !== r && (p = 200, y = "OK", "" === d)) {
                            var T = /^data\:([^,]*?)(?:;base64)?,[\S]*$/.exec(e);
                            void 0 != T && (d = T[1])
                        }
                        if (200 === p && _.test(d)) {
                            if (z = w, M = !0, k = I, U.readyState = w, f = new o("open"), U.dispatchEvent(f), u(U, U.onopen, f), z === b) return
                        } else if (0 !== p && (200 !== p || "" !== d)) {
                            var P = "";
                            P = 200 !== p ? "EventSource's response has a status " + p + " " + y.replace(/\s+/g, " ") + " that is not 200. Aborting the connection." : "EventSource's response has a Content-Type specifying an unsupported type: " + d.replace(/\s+/g, " ") + ". Aborting the connection.", c(function () {
                                throw new Error(P)
                            }, 0), l = !0
                        }
                    }
                    if (z === w) {
                        r.length > N && (M = !0);
                        for (var B = N - 1, Y = r.length, D = "\n"; ++B < Y;) if (D = r.charAt(B), X === m && "\n" === D) X = E; else if (X === m && (X = E), "\r" === D || "\n" === D) {
                            if ("data" === J ? F.push(G) : "id" === J ? H = G : "event" === J ? q = G : "retry" === J ? (I = s(Number(G), I), k = I) : "heartbeatTimeout" === J && (O = s(Number(G), O), 0 !== j && (h(j), j = c(W, O))), G = "", J = "", X === E) {
                                if (0 !== F.length && (C = H, "" === q && (q = "message"), f = new i(q, {
                                        data: F.join("\n"),
                                        lastEventId: H
                                    }), U.dispatchEvent(f), "message" === q && u(U, U.onmessage, f), z === b)) return;
                                F.length = 0, q = ""
                            }
                            X = "\r" === D ? m : E
                        } else X === E && (X = S), X === S ? ":" === D ? X = x : J += D : X === x ? (" " !== D && (G += D), X = A) : X === A && (G += D);
                        N = Y
                    }
                    z !== w && z !== v || !("load" === t || "error" === t || l || N > 1048576 || 0 === j && !M) ? 0 === j && (M = !1, j = c(W, O)) : (l ? a() : ("" !== t || 0 !== j || M || c(function () {
                        throw new Error("No activity within " + O + " milliseconds. Reconnecting.")
                    }, 0), z = g, L.abort(), 0 !== j && (h(j), j = 0), k > 16 * I && (k = 16 * I), k > R && (k = R), j = c(W, k), k = 2 * k + 1, U.readyState = v), f = new o("error"), U.dispatchEvent(f), u(U, U.onerror, f))
                }

                function l() {
                    f("progress")
                }

                function p() {
                    f("load")
                }

                function T() {
                    f("error")
                }

                function P() {
                    f(4 === L.readyState ? 0 === L.status ? "error" : "load" : "progress")
                }

                e = e.toString();
                var B = y && void 0 != n && Boolean(n.withCredentials), I = s(1e3, 0), O = s(45e3, 0), C = "", U = this,
                    k = I, M = !1, Y = void 0 != n && void 0 != n.Transport ? n.Transport : d, L = new Y, j = 0, D = 0,
                    N = 0, z = g, F = [], H = "", q = "", W = void 0, X = E, J = "", G = "";
                "readyState" in L && void 0 != t.opera && (D = c(function K() {
                    3 === L.readyState && f("progress"), D = c(K, 500)
                }, 0)), W = function () {
                    if (j = 0, z !== g) return void f("");
                    if ((!("ontimeout" in L) || "sendAsBinary" in L || "mozAnon" in L) && void 0 != t.document && void 0 != t.document.readyState && "complete" !== t.document.readyState) return void(j = c(W, 4));
                    L.onload = p, L.onerror = T, "onabort" in L && (L.onabort = T), "onprogress" in L && (L.onprogress = l), "onreadystatechange" in L && (L.onreadystatechange = P), M = !1, j = c(W, O), N = 0, z = v, F.length = 0, q = "", H = C, G = "", J = "", X = E;
                    var r = e.slice(0, 5);
                    r = "data:" !== r && "blob:" !== r ? e + ((e.indexOf("?", 0) === -1 ? "?" : "&") + "lastEventId=" + encodeURIComponent(C) + "&r=" + (Math.random() + 1).toString().slice(2)) : e, L.open("GET", r, !0), "withCredentials" in L && (L.withCredentials = B), "responseType" in L && (L.responseType = "text"), "setRequestHeader" in L && L.setRequestHeader("Accept", "text/event-stream"), L.send(void 0)
                }, r.call(this), this.close = a, this.url = e, this.readyState = v, this.withCredentials = B, this.onopen = void 0, this.onmessage = void 0, this.onerror = void 0, W()
            }

            function f() {
                this.CONNECTING = v, this.OPEN = w, this.CLOSED = b
            }

            var c = t.setTimeout, h = t.clearTimeout;
            e.prototype.get = function (t) {
                return this.data[t + "~"]
            }, e.prototype.set = function (t, e) {
                this.data[t + "~"] = e
            }, e.prototype["delete"] = function (t) {
                delete this.data[t + "~"]
            }, r.prototype.dispatchEvent = function (t) {
                t.target = this;
                var e = t.type.toString(), r = this.listeners, o = r.get(e);
                if (void 0 != o) for (var i = o.length, s = -1, u = void 0; ++s < i;) {
                    u = o[s];
                    try {
                        u.call(this, t)
                    } catch (a) {
                        n(a)
                    }
                }
            }, r.prototype.addEventListener = function (t, e) {
                t = t.toString();
                var r = this.listeners, n = r.get(t);
                void 0 == n && (n = [], r.set(t, n));
                for (var o = n.length; --o >= 0;) if (n[o] === e) return;
                n.push(e)
            }, r.prototype.removeEventListener = function (t, e) {
                t = t.toString();
                var r = this.listeners, n = r.get(t);
                if (void 0 != n) {
                    for (var o = n.length, i = [], s = -1; ++s < o;) n[s] !== e && i.push(n[s]);
                    0 === i.length ? r["delete"](t) : r.set(t, i)
                }
            }, i.prototype = o.prototype;
            var l = t.XMLHttpRequest, p = t.XDomainRequest, y = void 0 != l && void 0 != (new l).withCredentials,
                d = y || void 0 != l && void 0 == p ? l : p, g = -1, v = 0, w = 1, b = 2, m = 3, E = 4, S = 5, x = 6,
                A = 7, _ = /^text\/event\-stream;?(\s*charset\=utf\-8)?$/i, T = 1e3, R = 18e6;
            f.prototype = r.prototype, a.prototype = new f, f.call(a), y && (a.prototype.withCredentials = void 0);
            var P = function () {
                return void 0 != t.EventSource && "withCredentials" in t.EventSource.prototype
            };
            void 0 != d && (void 0 == t.EventSource || y && !P()) && (t.NativeEventSource = t.EventSource, t.EventSource = a)
        }("undefined" != typeof window ? window : this)
    }, function (t, e) {
        "use strict";

        function r(t) {
            var e = document.createElement("iframe");
            return t = t || {}, e.setAttribute("src", t.url || ""), e.style.width = t.width + "px", e.id = t.id || "test", e.style.height = t.height + "px", e.style.frameBorder = t.frameBorder || "0", e.style.border = "0px", e.style.padding = "0px", e.style.margin = "0px", e.scrolling = t.scrolling || "no", e.style.minHeight = t.minHeight + "px", e
        }

        t.exports = {createFrame: r}
    }, function (t, e) {
        "use strict";

        function r(t, e, r, n) {
            void 0 === window.containingDivStyle && (window.containingDivStyle = t.getAttribute("style")), t.removeAttribute("style"), t.style.display = "block", t.style.position = "fixed", t.style.zIndex = "9999", t.style.left = "0", t.style.top = "0", t.style.bottom = "0", t.style.right = "0", t.style.width = "1px", t.style.minWidth = "100%", t.style.height = "100%", t.style.backgroundColor = "rgb(0,0,0)", t.style.backgroundColor = "rgba(0,0,0,0.4)", t.style.overflowY = "scroll", t.style.overflowX = "hidden", t.style.textAlign = "center", "redirect" !== r || /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ? (e.style.frameBorder = "0", e.scrolling = "no", void 0 !== n ? (t.style.paddingTop = window.innerHeight / 5 + "px", e.style.width = n.appWidth ? n.appWidth + "px" : "400px", e.style.height = n.appHeight ? n.appHeight + "px" : "600px", /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ? (e.style.width = window.innerWidth + "px", e.style.minWidth = "100%", e.style.minHeight = "100%", e.style.height = "100%", t.style.paddingTop = "0px", document.body.style.overflow = "hidden !important", t.style.webkitOverflowScrolling = "touch", document.body.style.position = "fixed") : (e.style.maxWidth = "400px", e.style.width = "100%", e.style.height = "600px")) : /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ? (e.style.width = window.innerWidth + "px", e.style.minWidth = "100%", e.style.minHeight = "100%", e.style.height = "100%", t.style.paddingTop = "0px") : (e.style.maxWidth = "400px", e.style.width = "100%", e.style.height = "600px")) : (e.style.width = "100%", e.style.height = "950px", t.style.width = "100%")
        }

        t.exports = {createApp: r}
    }, function (t, e) {
        "use strict";

        function r(t, e, r) {
            var n = document.getElementById(t.container);
            n && void 0 != n && (n.removeAttribute("style"), n.setAttribute("style", window.containingDivStyle)), e.removeAttribute("style"), t.skipButton && e && e.parentNode ? e.parentNode.removeChild(e) : (e.width = r ? r[0] + "px" : "200px", e.height = r ? r[1] + "px" : "70px", e.style.border = "0"), document.body.style.overflow = "auto !important"
        }

        t.exports = {resetFrameStyle: r}
    }, function (t, e) {
        "use strict";

        function r(t, e, r, n) {
            if (!t) throw new Error("Bkm-express API Client Misconfigured: clientTokenId required.");
            if (!e) throw new Error("Bkm-express API Client Misconfigured: clientToken required.");
            if (!r) throw new Error("Bkm-express API Client Misconfigured: application type required.");
            if (!n) throw new Error("Bkm-express API Client Misconfigured: configurations required.")
        }

        t.exports = {checkInitParameters: r}
    }, function (t, e, r) {
        var n, o, i, s = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (t) {
            return typeof t
        } : function (t) {
            return t && "function" == typeof Symbol && t.constructor === Symbol && t !== Symbol.prototype ? "symbol" : typeof t
        };
        !function (r, u) {
            "object" === s(e) && "undefined" != typeof t ? t.exports = u() : (o = [], n = u, i = "function" == typeof n ? n.apply(e, o) : n, !(void 0 !== i && (t.exports = i)))
        }(void 0, function () {
            function t(t) {
                return null != t && (b.push(t), !0)
            }

            function e(t) {
                var e, r = {};
                for (e in w) w.hasOwnProperty(e) && (r[e] = w[e]);
                return r._origin = t || "*", r
            }

            function r(t) {
                var e, r, n = i(this);
                return !s(t) && (!s(n) && (r = Array.prototype.slice.call(arguments, 1), e = u(t, r, n), e !== !1 && (p(v.top, e, n), !0)))
            }

            function n(t, e) {
                var r = i(this);
                return !g(t, e, r) && (m[r] = m[r] || {}, m[r][t] = m[r][t] || [], m[r][t].push(e), !0)
            }

            function o(t, e) {
                var r, n, o = i(this);
                if (g(t, e, o)) return !1;
                if (n = m[o] && m[o][t], !n) return !1;
                for (r = 0; r < n.length; r++) if (n[r] === e) return n.splice(r, 1), !0;
                return !1
            }

            function i(t) {
                return t && t._origin || "*"
            }

            function s(t) {
                return "string" != typeof t
            }

            function u(t, e, r) {
                var n = !1, o = {event: t, origin: r}, i = e[e.length - 1];
                "function" == typeof i && (o.reply = d(i, r), e = e.slice(0, -1)), o.args = e;
                try {
                    n = E + JSON.stringify(o)
                } catch (s) {
                    throw new Error("Could not stringify event: " + s.message)
                }
                return n
            }

            function a(t) {
                var e, r, n, o;
                if (t.data.slice(0, E.length) !== E) return !1;
                try {
                    e = JSON.parse(t.data.slice(E.length))
                } catch (i) {
                    return !1
                }
                return null != e.reply && (r = t.origin, n = t.source, o = e.reply, e.reply = function (t) {
                    var e = u(o, [t], r);
                    return e !== !1 && void n.postMessage(e, r)
                }, e.args.push(e.reply)), e
            }

            function f(t) {
                v || (v = t || window, v.addEventListener ? v.addEventListener("message", h, !1) : v.attachEvent ? v.attachEvent("onmessage", h) : null === v.onmessage ? v.onmessage = h : v = null)
            }

            function c() {
                return "xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx".replace(/[xy]/g, function (t) {
                    var e = 16 * Math.random() | 0, r = "x" === t ? e : 3 & e | 8;
                    return r.toString(16)
                })
            }

            function h(t) {
                var e;
                s(t.data) || (e = a(t), e && (l("*", e.event, e.args, t), l(t.origin, e.event, e.args, t), y(t.data, e.origin, t.source)))
            }

            function l(t, e, r, n) {
                var o;
                if (m[t] && m[t][e]) for (o = 0; o < m[t][e].length; o++) m[t][e][o].apply(n, r)
            }

            function p(t, e, r) {
                var n;
                try {
                    for (t.postMessage(e, r), t.opener && t.opener !== t && !t.opener.closed && t.opener !== v && p(t.opener.top, e, r), n = 0; n < t.frames.length; n++) p(t.frames[n], e, r)
                } catch (o) {
                }
            }

            function y(t, e, r) {
                var n, o;
                for (n = b.length - 1; n >= 0; n--) o = b[n], o.closed === !0 ? b.splice(n, 1) : r !== o && p(o.top, t, e)
            }

            function d(t, e) {
                function r(o, i) {
                    t(o, i), w.target(e).unsubscribe(n, r)
                }

                var n = c();
                return w.target(e).subscribe(n, r), n
            }

            function g(t, e, r) {
                return !!s(t) || ("function" != typeof e || !!s(r))
            }

            var v, w, b = [], m = {}, E = "/*framebus*/";
            return f(), w = {
                target: e,
                include: t,
                publish: r,
                pub: r,
                trigger: r,
                emit: r,
                subscribe: n,
                sub: n,
                on: n,
                unsubscribe: o,
                unsub: o,
                off: o
            }
        })
    }, function (t, e, r) {
        "use strict";
        Object.defineProperty(e, "__esModule", {value: !0});
        e.API_ROOT = "https://test-api.bkmexpress.com.tr/v1/", e.RESOURCE_ROOT = "https://test-js.bkmexpress.com.tr/v1/"
    }, function (t, e, r) {
        (function (e) {
            !function (r) {
                "use strict";

                function n(t) {
                    if ("function" == typeof o) return o(t);
                    if ("function" == typeof e) return new e(t, "base64").toString("binary");
                    if ("object" == typeof r.base64js) {
                        var n = r.base64js.b64ToByteArray(t);
                        return Array.prototype.map.call(n, function (t) {
                            return String.fromCharCode(t)
                        }).join("")
                    }
                    throw new Error("you're probably in an ios webworker. please include use beatgammit's base64-js")
                }

                var o = r.atob;
                r.atob = n, t.exports = n
            }(window)
        }).call(e, r(30).Buffer)
    }, function (t, e, r) {
        (function (t, n) {/*!
	 * The buffer module from node.js, for the browser.
	 *
	 * @author   Feross Aboukhadijeh <feross@feross.org> <http://feross.org>
	 * @license  MIT
	 */
            "use strict";

            function o() {
                try {
                    var t = new Uint8Array(1);
                    return t.__proto__ = {
                        __proto__: Uint8Array.prototype, foo: function () {
                            return 42
                        }
                    }, 42 === t.foo() && "function" == typeof t.subarray && 0 === t.subarray(1, 1).byteLength
                } catch (e) {
                    return !1
                }
            }

            function i() {
                return t.TYPED_ARRAY_SUPPORT ? 2147483647 : 1073741823
            }

            function s(e, r) {
                if (i() < r) throw new RangeError("Invalid typed array length");
                return t.TYPED_ARRAY_SUPPORT ? (e = new Uint8Array(r), e.__proto__ = t.prototype) : (null === e && (e = new t(r)), e.length = r), e
            }

            function t(e, r, n) {
                if (!(t.TYPED_ARRAY_SUPPORT || this instanceof t)) return new t(e, r, n);
                if ("number" == typeof e) {
                    if ("string" == typeof r) throw new Error("If encoding is specified then the first argument must be a string");
                    return c(this, e)
                }
                return u(this, e, r, n)
            }

            function u(t, e, r, n) {
                if ("number" == typeof e) throw new TypeError('"value" argument must not be a number');
                return "undefined" != typeof ArrayBuffer && e instanceof ArrayBuffer ? p(t, e, r, n) : "string" == typeof e ? h(t, e, r) : y(t, e)
            }

            function a(t) {
                if ("number" != typeof t) throw new TypeError('"size" argument must be a number');
                if (t < 0) throw new RangeError('"size" argument must not be negative')
            }

            function f(t, e, r, n) {
                return a(e), e <= 0 ? s(t, e) : void 0 !== r ? "string" == typeof n ? s(t, e).fill(r, n) : s(t, e).fill(r) : s(t, e)
            }

            function c(e, r) {
                if (a(r), e = s(e, r < 0 ? 0 : 0 | d(r)), !t.TYPED_ARRAY_SUPPORT) for (var n = 0; n < r; ++n) e[n] = 0;
                return e
            }

            function h(e, r, n) {
                if ("string" == typeof n && "" !== n || (n = "utf8"), !t.isEncoding(n)) throw new TypeError('"encoding" must be a valid string encoding');
                var o = 0 | v(r, n);
                e = s(e, o);
                var i = e.write(r, n);
                return i !== o && (e = e.slice(0, i)), e
            }

            function l(t, e) {
                var r = e.length < 0 ? 0 : 0 | d(e.length);
                t = s(t, r);
                for (var n = 0; n < r; n += 1) t[n] = 255 & e[n];
                return t
            }

            function p(e, r, n, o) {
                if (r.byteLength, n < 0 || r.byteLength < n) throw new RangeError("'offset' is out of bounds");
                if (r.byteLength < n + (o || 0)) throw new RangeError("'length' is out of bounds");
                return r = void 0 === n && void 0 === o ? new Uint8Array(r) : void 0 === o ? new Uint8Array(r, n) : new Uint8Array(r, n, o), t.TYPED_ARRAY_SUPPORT ? (e = r, e.__proto__ = t.prototype) : e = l(e, r), e
            }

            function y(e, r) {
                if (t.isBuffer(r)) {
                    var n = 0 | d(r.length);
                    return e = s(e, n), 0 === e.length ? e : (r.copy(e, 0, 0, n), e)
                }
                if (r) {
                    if ("undefined" != typeof ArrayBuffer && r.buffer instanceof ArrayBuffer || "length" in r) return "number" != typeof r.length || V(r.length) ? s(e, 0) : l(e, r);
                    if ("Buffer" === r.type && Q(r.data)) return l(e, r.data)
                }
                throw new TypeError("First argument must be a string, Buffer, ArrayBuffer, Array, or array-like object.")
            }

            function d(t) {
                if (t >= i()) throw new RangeError("Attempt to allocate Buffer larger than maximum size: 0x" + i().toString(16) + " bytes");
                return 0 | t
            }

            function g(e) {
                return +e != e && (e = 0), t.alloc(+e)
            }

            function v(e, r) {
                if (t.isBuffer(e)) return e.length;
                if ("undefined" != typeof ArrayBuffer && "function" == typeof ArrayBuffer.isView && (ArrayBuffer.isView(e) || e instanceof ArrayBuffer)) return e.byteLength;
                "string" != typeof e && (e = "" + e);
                var n = e.length;
                if (0 === n) return 0;
                for (var o = !1; ;) switch (r) {
                    case"ascii":
                    case"latin1":
                    case"binary":
                        return n;
                    case"utf8":
                    case"utf-8":
                    case void 0:
                        return W(e).length;
                    case"ucs2":
                    case"ucs-2":
                    case"utf16le":
                    case"utf-16le":
                        return 2 * n;
                    case"hex":
                        return n >>> 1;
                    case"base64":
                        return G(e).length;
                    default:
                        if (o) return W(e).length;
                        r = ("" + r).toLowerCase(), o = !0
                }
            }

            function w(t, e, r) {
                var n = !1;
                if ((void 0 === e || e < 0) && (e = 0), e > this.length) return "";
                if ((void 0 === r || r > this.length) && (r = this.length), r <= 0) return "";
                if (r >>>= 0, e >>>= 0, r <= e) return "";
                for (t || (t = "utf8"); ;) switch (t) {
                    case"hex":
                        return U(this, e, r);
                    case"utf8":
                    case"utf-8":
                        return B(this, e, r);
                    case"ascii":
                        return O(this, e, r);
                    case"latin1":
                    case"binary":
                        return C(this, e, r);
                    case"base64":
                        return P(this, e, r);
                    case"ucs2":
                    case"ucs-2":
                    case"utf16le":
                    case"utf-16le":
                        return k(this, e, r);
                    default:
                        if (n) throw new TypeError("Unknown encoding: " + t);
                        t = (t + "").toLowerCase(), n = !0
                }
            }

            function b(t, e, r) {
                var n = t[e];
                t[e] = t[r], t[r] = n
            }

            function m(e, r, n, o, i) {
                if (0 === e.length) return -1;
                if ("string" == typeof n ? (o = n, n = 0) : n > 2147483647 ? n = 2147483647 : n < -2147483648 && (n = -2147483648), n = +n, isNaN(n) && (n = i ? 0 : e.length - 1), n < 0 && (n = e.length + n), n >= e.length) {
                    if (i) return -1;
                    n = e.length - 1
                } else if (n < 0) {
                    if (!i) return -1;
                    n = 0
                }
                if ("string" == typeof r && (r = t.from(r, o)), t.isBuffer(r)) return 0 === r.length ? -1 : E(e, r, n, o, i);
                if ("number" == typeof r) return r = 255 & r, t.TYPED_ARRAY_SUPPORT && "function" == typeof Uint8Array.prototype.indexOf ? i ? Uint8Array.prototype.indexOf.call(e, r, n) : Uint8Array.prototype.lastIndexOf.call(e, r, n) : E(e, [r], n, o, i);
                throw new TypeError("val must be string, number or Buffer")
            }

            function E(t, e, r, n, o) {
                function i(t, e) {
                    return 1 === s ? t[e] : t.readUInt16BE(e * s)
                }

                var s = 1, u = t.length, a = e.length;
                if (void 0 !== n && (n = String(n).toLowerCase(), "ucs2" === n || "ucs-2" === n || "utf16le" === n || "utf-16le" === n)) {
                    if (t.length < 2 || e.length < 2) return -1;
                    s = 2, u /= 2, a /= 2, r /= 2
                }
                var f;
                if (o) {
                    var c = -1;
                    for (f = r; f < u; f++) if (i(t, f) === i(e, c === -1 ? 0 : f - c)) {
                        if (c === -1 && (c = f), f - c + 1 === a) return c * s
                    } else c !== -1 && (f -= f - c), c = -1
                } else for (r + a > u && (r = u - a), f = r; f >= 0; f--) {
                    for (var h = !0, l = 0; l < a; l++) if (i(t, f + l) !== i(e, l)) {
                        h = !1;
                        break
                    }
                    if (h) return f
                }
                return -1
            }

            function S(t, e, r, n) {
                r = Number(r) || 0;
                var o = t.length - r;
                n ? (n = Number(n), n > o && (n = o)) : n = o;
                var i = e.length;
                if (i % 2 !== 0) throw new TypeError("Invalid hex string");
                n > i / 2 && (n = i / 2);
                for (var s = 0; s < n; ++s) {
                    var u = parseInt(e.substr(2 * s, 2), 16);
                    if (isNaN(u)) return s;
                    t[r + s] = u
                }
                return s
            }

            function x(t, e, r, n) {
                return K(W(e, t.length - r), t, r, n)
            }

            function A(t, e, r, n) {
                return K(X(e), t, r, n)
            }

            function _(t, e, r, n) {
                return A(t, e, r, n)
            }

            function T(t, e, r, n) {
                return K(G(e), t, r, n)
            }

            function R(t, e, r, n) {
                return K(J(e, t.length - r), t, r, n)
            }

            function P(t, e, r) {
                return 0 === e && r === t.length ? $.fromByteArray(t) : $.fromByteArray(t.slice(e, r))
            }

            function B(t, e, r) {
                r = Math.min(t.length, r);
                for (var n = [], o = e; o < r;) {
                    var i = t[o], s = null, u = i > 239 ? 4 : i > 223 ? 3 : i > 191 ? 2 : 1;
                    if (o + u <= r) {
                        var a, f, c, h;
                        switch (u) {
                            case 1:
                                i < 128 && (s = i);
                                break;
                            case 2:
                                a = t[o + 1], 128 === (192 & a) && (h = (31 & i) << 6 | 63 & a, h > 127 && (s = h));
                                break;
                            case 3:
                                a = t[o + 1], f = t[o + 2], 128 === (192 & a) && 128 === (192 & f) && (h = (15 & i) << 12 | (63 & a) << 6 | 63 & f, h > 2047 && (h < 55296 || h > 57343) && (s = h));
                                break;
                            case 4:
                                a = t[o + 1], f = t[o + 2], c = t[o + 3], 128 === (192 & a) && 128 === (192 & f) && 128 === (192 & c) && (h = (15 & i) << 18 | (63 & a) << 12 | (63 & f) << 6 | 63 & c, h > 65535 && h < 1114112 && (s = h))
                        }
                    }
                    null === s ? (s = 65533, u = 1) : s > 65535 && (s -= 65536, n.push(s >>> 10 & 1023 | 55296), s = 56320 | 1023 & s), n.push(s), o += u
                }
                return I(n)
            }

            function I(t) {
                var e = t.length;
                if (e <= tt) return String.fromCharCode.apply(String, t);
                for (var r = "", n = 0; n < e;) r += String.fromCharCode.apply(String, t.slice(n, n += tt));
                return r
            }

            function O(t, e, r) {
                var n = "";
                r = Math.min(t.length, r);
                for (var o = e; o < r; ++o) n += String.fromCharCode(127 & t[o]);
                return n
            }

            function C(t, e, r) {
                var n = "";
                r = Math.min(t.length, r);
                for (var o = e; o < r; ++o) n += String.fromCharCode(t[o]);
                return n
            }

            function U(t, e, r) {
                var n = t.length;
                (!e || e < 0) && (e = 0), (!r || r < 0 || r > n) && (r = n);
                for (var o = "", i = e; i < r; ++i) o += q(t[i]);
                return o
            }

            function k(t, e, r) {
                for (var n = t.slice(e, r), o = "", i = 0; i < n.length; i += 2) o += String.fromCharCode(n[i] + 256 * n[i + 1]);
                return o
            }

            function M(t, e, r) {
                if (t % 1 !== 0 || t < 0) throw new RangeError("offset is not uint");
                if (t + e > r) throw new RangeError("Trying to access beyond buffer length")
            }

            function Y(e, r, n, o, i, s) {
                if (!t.isBuffer(e)) throw new TypeError('"buffer" argument must be a Buffer instance');
                if (r > i || r < s) throw new RangeError('"value" argument is out of bounds');
                if (n + o > e.length) throw new RangeError("Index out of range")
            }

            function L(t, e, r, n) {
                e < 0 && (e = 65535 + e + 1);
                for (var o = 0, i = Math.min(t.length - r, 2); o < i; ++o) t[r + o] = (e & 255 << 8 * (n ? o : 1 - o)) >>> 8 * (n ? o : 1 - o)
            }

            function j(t, e, r, n) {
                e < 0 && (e = 4294967295 + e + 1);
                for (var o = 0, i = Math.min(t.length - r, 4); o < i; ++o) t[r + o] = e >>> 8 * (n ? o : 3 - o) & 255
            }

            function D(t, e, r, n, o, i) {
                if (r + n > t.length) throw new RangeError("Index out of range");
                if (r < 0) throw new RangeError("Index out of range")
            }

            function N(t, e, r, n, o) {
                return o || D(t, e, r, 4, 3.4028234663852886e38, -3.4028234663852886e38), Z.write(t, e, r, n, 23, 4), r + 4
            }

            function z(t, e, r, n, o) {
                return o || D(t, e, r, 8, 1.7976931348623157e308, -1.7976931348623157e308), Z.write(t, e, r, n, 52, 8), r + 8
            }

            function F(t) {
                if (t = H(t).replace(et, ""), t.length < 2) return "";
                for (; t.length % 4 !== 0;) t += "=";
                return t
            }

            function H(t) {
                return t.trim ? t.trim() : t.replace(/^\s+|\s+$/g, "")
            }

            function q(t) {
                return t < 16 ? "0" + t.toString(16) : t.toString(16)
            }

            function W(t, e) {
                e = e || 1 / 0;
                for (var r, n = t.length, o = null, i = [], s = 0; s < n; ++s) {
                    if (r = t.charCodeAt(s), r > 55295 && r < 57344) {
                        if (!o) {
                            if (r > 56319) {
                                (e -= 3) > -1 && i.push(239, 191, 189);
                                continue
                            }
                            if (s + 1 === n) {
                                (e -= 3) > -1 && i.push(239, 191, 189);
                                continue
                            }
                            o = r;
                            continue
                        }
                        if (r < 56320) {
                            (e -= 3) > -1 && i.push(239, 191, 189), o = r;
                            continue
                        }
                        r = (o - 55296 << 10 | r - 56320) + 65536
                    } else o && (e -= 3) > -1 && i.push(239, 191, 189);
                    if (o = null, r < 128) {
                        if ((e -= 1) < 0) break;
                        i.push(r)
                    } else if (r < 2048) {
                        if ((e -= 2) < 0) break;
                        i.push(r >> 6 | 192, 63 & r | 128)
                    } else if (r < 65536) {
                        if ((e -= 3) < 0) break;
                        i.push(r >> 12 | 224, r >> 6 & 63 | 128, 63 & r | 128)
                    } else {
                        if (!(r < 1114112)) throw new Error("Invalid code point");
                        if ((e -= 4) < 0) break;
                        i.push(r >> 18 | 240, r >> 12 & 63 | 128, r >> 6 & 63 | 128, 63 & r | 128)
                    }
                }
                return i
            }

            function X(t) {
                for (var e = [], r = 0; r < t.length; ++r) e.push(255 & t.charCodeAt(r));
                return e
            }

            function J(t, e) {
                for (var r, n, o, i = [], s = 0; s < t.length && !((e -= 2) < 0); ++s) r = t.charCodeAt(s), n = r >> 8, o = r % 256, i.push(o), i.push(n);
                return i
            }

            function G(t) {
                return $.toByteArray(F(t))
            }

            function K(t, e, r, n) {
                for (var o = 0; o < n && !(o + r >= e.length || o >= t.length); ++o) e[o + r] = t[o];
                return o
            }

            function V(t) {
                return t !== t
            }

            var $ = r(31), Z = r(32), Q = r(33);
            e.Buffer = t, e.SlowBuffer = g, e.INSPECT_MAX_BYTES = 50, t.TYPED_ARRAY_SUPPORT = void 0 !== n.TYPED_ARRAY_SUPPORT ? n.TYPED_ARRAY_SUPPORT : o(), e.kMaxLength = i(), t.poolSize = 8192, t._augment = function (e) {
                return e.__proto__ = t.prototype, e
            }, t.from = function (t, e, r) {
                return u(null, t, e, r)
            }, t.TYPED_ARRAY_SUPPORT && (t.prototype.__proto__ = Uint8Array.prototype, t.__proto__ = Uint8Array, "undefined" != typeof Symbol && Symbol.species && t[Symbol.species] === t && Object.defineProperty(t, Symbol.species, {
                value: null,
                configurable: !0
            })), t.alloc = function (t, e, r) {
                return f(null, t, e, r)
            }, t.allocUnsafe = function (t) {
                return c(null, t)
            }, t.allocUnsafeSlow = function (t) {
                return c(null, t)
            }, t.isBuffer = function (t) {
                return !(null == t || !t._isBuffer)
            }, t.compare = function (e, r) {
                if (!t.isBuffer(e) || !t.isBuffer(r)) throw new TypeError("Arguments must be Buffers");
                if (e === r) return 0;
                for (var n = e.length, o = r.length, i = 0, s = Math.min(n, o); i < s; ++i) if (e[i] !== r[i]) {
                    n = e[i], o = r[i];
                    break
                }
                return n < o ? -1 : o < n ? 1 : 0
            }, t.isEncoding = function (t) {
                switch (String(t).toLowerCase()) {
                    case"hex":
                    case"utf8":
                    case"utf-8":
                    case"ascii":
                    case"latin1":
                    case"binary":
                    case"base64":
                    case"ucs2":
                    case"ucs-2":
                    case"utf16le":
                    case"utf-16le":
                        return !0;
                    default:
                        return !1
                }
            }, t.concat = function (e, r) {
                if (!Q(e)) throw new TypeError('"list" argument must be an Array of Buffers');
                if (0 === e.length) return t.alloc(0);
                var n;
                if (void 0 === r) for (r = 0, n = 0; n < e.length; ++n) r += e[n].length;
                var o = t.allocUnsafe(r), i = 0;
                for (n = 0; n < e.length; ++n) {
                    var s = e[n];
                    if (!t.isBuffer(s)) throw new TypeError('"list" argument must be an Array of Buffers');
                    s.copy(o, i), i += s.length
                }
                return o
            }, t.byteLength = v, t.prototype._isBuffer = !0, t.prototype.swap16 = function () {
                var t = this.length;
                if (t % 2 !== 0) throw new RangeError("Buffer size must be a multiple of 16-bits");
                for (var e = 0; e < t; e += 2) b(this, e, e + 1);
                return this
            }, t.prototype.swap32 = function () {
                var t = this.length;
                if (t % 4 !== 0) throw new RangeError("Buffer size must be a multiple of 32-bits");
                for (var e = 0; e < t; e += 4) b(this, e, e + 3), b(this, e + 1, e + 2);
                return this
            }, t.prototype.swap64 = function () {
                var t = this.length;
                if (t % 8 !== 0) throw new RangeError("Buffer size must be a multiple of 64-bits");
                for (var e = 0; e < t; e += 8) b(this, e, e + 7), b(this, e + 1, e + 6), b(this, e + 2, e + 5), b(this, e + 3, e + 4);
                return this
            }, t.prototype.toString = function () {
                var t = 0 | this.length;
                return 0 === t ? "" : 0 === arguments.length ? B(this, 0, t) : w.apply(this, arguments)
            }, t.prototype.equals = function (e) {
                if (!t.isBuffer(e)) throw new TypeError("Argument must be a Buffer");
                return this === e || 0 === t.compare(this, e)
            }, t.prototype.inspect = function () {
                var t = "", r = e.INSPECT_MAX_BYTES;
                return this.length > 0 && (t = this.toString("hex", 0, r).match(/.{2}/g).join(" "), this.length > r && (t += " ... ")), "<Buffer " + t + ">"
            }, t.prototype.compare = function (e, r, n, o, i) {
                if (!t.isBuffer(e)) throw new TypeError("Argument must be a Buffer");
                if (void 0 === r && (r = 0), void 0 === n && (n = e ? e.length : 0), void 0 === o && (o = 0), void 0 === i && (i = this.length), r < 0 || n > e.length || o < 0 || i > this.length) throw new RangeError("out of range index");
                if (o >= i && r >= n) return 0;
                if (o >= i) return -1;
                if (r >= n) return 1;
                if (r >>>= 0, n >>>= 0, o >>>= 0, i >>>= 0, this === e) return 0;
                for (var s = i - o, u = n - r, a = Math.min(s, u), f = this.slice(o, i), c = e.slice(r, n), h = 0; h < a; ++h) if (f[h] !== c[h]) {
                    s = f[h], u = c[h];
                    break
                }
                return s < u ? -1 : u < s ? 1 : 0
            }, t.prototype.includes = function (t, e, r) {
                return this.indexOf(t, e, r) !== -1
            }, t.prototype.indexOf = function (t, e, r) {
                return m(this, t, e, r, !0)
            }, t.prototype.lastIndexOf = function (t, e, r) {
                return m(this, t, e, r, !1)
            }, t.prototype.write = function (t, e, r, n) {
                if (void 0 === e) n = "utf8", r = this.length, e = 0; else if (void 0 === r && "string" == typeof e) n = e, r = this.length, e = 0; else {
                    if (!isFinite(e)) throw new Error("Buffer.write(string, encoding, offset[, length]) is no longer supported");
                    e = 0 | e, isFinite(r) ? (r = 0 | r, void 0 === n && (n = "utf8")) : (n = r, r = void 0)
                }
                var o = this.length - e;
                if ((void 0 === r || r > o) && (r = o), t.length > 0 && (r < 0 || e < 0) || e > this.length) throw new RangeError("Attempt to write outside buffer bounds");
                n || (n = "utf8");
                for (var i = !1; ;) switch (n) {
                    case"hex":
                        return S(this, t, e, r);
                    case"utf8":
                    case"utf-8":
                        return x(this, t, e, r);
                    case"ascii":
                        return A(this, t, e, r);
                    case"latin1":
                    case"binary":
                        return _(this, t, e, r);
                    case"base64":
                        return T(this, t, e, r);
                    case"ucs2":
                    case"ucs-2":
                    case"utf16le":
                    case"utf-16le":
                        return R(this, t, e, r);
                    default:
                        if (i) throw new TypeError("Unknown encoding: " + n);
                        n = ("" + n).toLowerCase(), i = !0
                }
            }, t.prototype.toJSON = function () {
                return {type: "Buffer", data: Array.prototype.slice.call(this._arr || this, 0)}
            };
            var tt = 4096;
            t.prototype.slice = function (e, r) {
                var n = this.length;
                e = ~~e, r = void 0 === r ? n : ~~r, e < 0 ? (e += n, e < 0 && (e = 0)) : e > n && (e = n), r < 0 ? (r += n, r < 0 && (r = 0)) : r > n && (r = n), r < e && (r = e);
                var o;
                if (t.TYPED_ARRAY_SUPPORT) o = this.subarray(e, r), o.__proto__ = t.prototype; else {
                    var i = r - e;
                    o = new t(i, (void 0));
                    for (var s = 0; s < i; ++s) o[s] = this[s + e]
                }
                return o
            }, t.prototype.readUIntLE = function (t, e, r) {
                t = 0 | t, e = 0 | e, r || M(t, e, this.length);
                for (var n = this[t], o = 1, i = 0; ++i < e && (o *= 256);) n += this[t + i] * o;
                return n
            }, t.prototype.readUIntBE = function (t, e, r) {
                t = 0 | t, e = 0 | e, r || M(t, e, this.length);
                for (var n = this[t + --e], o = 1; e > 0 && (o *= 256);) n += this[t + --e] * o;
                return n
            }, t.prototype.readUInt8 = function (t, e) {
                return e || M(t, 1, this.length), this[t]
            }, t.prototype.readUInt16LE = function (t, e) {
                return e || M(t, 2, this.length), this[t] | this[t + 1] << 8
            }, t.prototype.readUInt16BE = function (t, e) {
                return e || M(t, 2, this.length), this[t] << 8 | this[t + 1]
            }, t.prototype.readUInt32LE = function (t, e) {
                return e || M(t, 4, this.length), (this[t] | this[t + 1] << 8 | this[t + 2] << 16) + 16777216 * this[t + 3]
            }, t.prototype.readUInt32BE = function (t, e) {
                return e || M(t, 4, this.length), 16777216 * this[t] + (this[t + 1] << 16 | this[t + 2] << 8 | this[t + 3])
            }, t.prototype.readIntLE = function (t, e, r) {
                t = 0 | t, e = 0 | e, r || M(t, e, this.length);
                for (var n = this[t], o = 1, i = 0; ++i < e && (o *= 256);) n += this[t + i] * o;
                return o *= 128, n >= o && (n -= Math.pow(2, 8 * e)), n
            }, t.prototype.readIntBE = function (t, e, r) {
                t = 0 | t, e = 0 | e, r || M(t, e, this.length);
                for (var n = e, o = 1, i = this[t + --n]; n > 0 && (o *= 256);) i += this[t + --n] * o;
                return o *= 128, i >= o && (i -= Math.pow(2, 8 * e)), i
            }, t.prototype.readInt8 = function (t, e) {
                return e || M(t, 1, this.length), 128 & this[t] ? (255 - this[t] + 1) * -1 : this[t]
            }, t.prototype.readInt16LE = function (t, e) {
                e || M(t, 2, this.length);
                var r = this[t] | this[t + 1] << 8;
                return 32768 & r ? 4294901760 | r : r
            }, t.prototype.readInt16BE = function (t, e) {
                e || M(t, 2, this.length);
                var r = this[t + 1] | this[t] << 8;
                return 32768 & r ? 4294901760 | r : r
            }, t.prototype.readInt32LE = function (t, e) {
                return e || M(t, 4, this.length), this[t] | this[t + 1] << 8 | this[t + 2] << 16 | this[t + 3] << 24
            }, t.prototype.readInt32BE = function (t, e) {
                return e || M(t, 4, this.length), this[t] << 24 | this[t + 1] << 16 | this[t + 2] << 8 | this[t + 3]
            }, t.prototype.readFloatLE = function (t, e) {
                return e || M(t, 4, this.length), Z.read(this, t, !0, 23, 4)
            }, t.prototype.readFloatBE = function (t, e) {
                return e || M(t, 4, this.length), Z.read(this, t, !1, 23, 4)
            }, t.prototype.readDoubleLE = function (t, e) {
                return e || M(t, 8, this.length), Z.read(this, t, !0, 52, 8)
            }, t.prototype.readDoubleBE = function (t, e) {
                return e || M(t, 8, this.length), Z.read(this, t, !1, 52, 8)
            }, t.prototype.writeUIntLE = function (t, e, r, n) {
                if (t = +t, e = 0 | e, r = 0 | r, !n) {
                    var o = Math.pow(2, 8 * r) - 1;
                    Y(this, t, e, r, o, 0)
                }
                var i = 1, s = 0;
                for (this[e] = 255 & t; ++s < r && (i *= 256);) this[e + s] = t / i & 255;
                return e + r
            }, t.prototype.writeUIntBE = function (t, e, r, n) {
                if (t = +t, e = 0 | e, r = 0 | r, !n) {
                    var o = Math.pow(2, 8 * r) - 1;
                    Y(this, t, e, r, o, 0)
                }
                var i = r - 1, s = 1;
                for (this[e + i] = 255 & t; --i >= 0 && (s *= 256);) this[e + i] = t / s & 255;
                return e + r
            }, t.prototype.writeUInt8 = function (e, r, n) {
                return e = +e, r = 0 | r, n || Y(this, e, r, 1, 255, 0), t.TYPED_ARRAY_SUPPORT || (e = Math.floor(e)), this[r] = 255 & e, r + 1
            }, t.prototype.writeUInt16LE = function (e, r, n) {
                return e = +e, r = 0 | r, n || Y(this, e, r, 2, 65535, 0), t.TYPED_ARRAY_SUPPORT ? (this[r] = 255 & e, this[r + 1] = e >>> 8) : L(this, e, r, !0), r + 2
            }, t.prototype.writeUInt16BE = function (e, r, n) {
                return e = +e, r = 0 | r, n || Y(this, e, r, 2, 65535, 0), t.TYPED_ARRAY_SUPPORT ? (this[r] = e >>> 8, this[r + 1] = 255 & e) : L(this, e, r, !1), r + 2
            }, t.prototype.writeUInt32LE = function (e, r, n) {
                return e = +e, r = 0 | r, n || Y(this, e, r, 4, 4294967295, 0), t.TYPED_ARRAY_SUPPORT ? (this[r + 3] = e >>> 24, this[r + 2] = e >>> 16, this[r + 1] = e >>> 8, this[r] = 255 & e) : j(this, e, r, !0), r + 4
            }, t.prototype.writeUInt32BE = function (e, r, n) {
                return e = +e, r = 0 | r, n || Y(this, e, r, 4, 4294967295, 0), t.TYPED_ARRAY_SUPPORT ? (this[r] = e >>> 24, this[r + 1] = e >>> 16, this[r + 2] = e >>> 8, this[r + 3] = 255 & e) : j(this, e, r, !1), r + 4
            }, t.prototype.writeIntLE = function (t, e, r, n) {
                if (t = +t, e = 0 | e, !n) {
                    var o = Math.pow(2, 8 * r - 1);
                    Y(this, t, e, r, o - 1, -o)
                }
                var i = 0, s = 1, u = 0;
                for (this[e] = 255 & t; ++i < r && (s *= 256);) t < 0 && 0 === u && 0 !== this[e + i - 1] && (u = 1), this[e + i] = (t / s >> 0) - u & 255;
                return e + r
            }, t.prototype.writeIntBE = function (t, e, r, n) {
                if (t = +t, e = 0 | e, !n) {
                    var o = Math.pow(2, 8 * r - 1);
                    Y(this, t, e, r, o - 1, -o)
                }
                var i = r - 1, s = 1, u = 0;
                for (this[e + i] = 255 & t; --i >= 0 && (s *= 256);) t < 0 && 0 === u && 0 !== this[e + i + 1] && (u = 1), this[e + i] = (t / s >> 0) - u & 255;
                return e + r
            }, t.prototype.writeInt8 = function (e, r, n) {
                return e = +e, r = 0 | r, n || Y(this, e, r, 1, 127, -128), t.TYPED_ARRAY_SUPPORT || (e = Math.floor(e)), e < 0 && (e = 255 + e + 1), this[r] = 255 & e, r + 1
            }, t.prototype.writeInt16LE = function (e, r, n) {
                return e = +e, r = 0 | r, n || Y(this, e, r, 2, 32767, -32768), t.TYPED_ARRAY_SUPPORT ? (this[r] = 255 & e, this[r + 1] = e >>> 8) : L(this, e, r, !0), r + 2
            }, t.prototype.writeInt16BE = function (e, r, n) {
                return e = +e, r = 0 | r, n || Y(this, e, r, 2, 32767, -32768), t.TYPED_ARRAY_SUPPORT ? (this[r] = e >>> 8, this[r + 1] = 255 & e) : L(this, e, r, !1), r + 2
            }, t.prototype.writeInt32LE = function (e, r, n) {
                return e = +e, r = 0 | r, n || Y(this, e, r, 4, 2147483647, -2147483648), t.TYPED_ARRAY_SUPPORT ? (this[r] = 255 & e, this[r + 1] = e >>> 8, this[r + 2] = e >>> 16, this[r + 3] = e >>> 24) : j(this, e, r, !0), r + 4
            }, t.prototype.writeInt32BE = function (e, r, n) {
                return e = +e, r = 0 | r, n || Y(this, e, r, 4, 2147483647, -2147483648), e < 0 && (e = 4294967295 + e + 1), t.TYPED_ARRAY_SUPPORT ? (this[r] = e >>> 24, this[r + 1] = e >>> 16, this[r + 2] = e >>> 8, this[r + 3] = 255 & e) : j(this, e, r, !1), r + 4
            }, t.prototype.writeFloatLE = function (t, e, r) {
                return N(this, t, e, !0, r)
            }, t.prototype.writeFloatBE = function (t, e, r) {
                return N(this, t, e, !1, r)
            }, t.prototype.writeDoubleLE = function (t, e, r) {
                return z(this, t, e, !0, r)
            }, t.prototype.writeDoubleBE = function (t, e, r) {
                return z(this, t, e, !1, r)
            }, t.prototype.copy = function (e, r, n, o) {
                if (n || (n = 0), o || 0 === o || (o = this.length), r >= e.length && (r = e.length), r || (r = 0), o > 0 && o < n && (o = n), o === n) return 0;
                if (0 === e.length || 0 === this.length) return 0;
                if (r < 0) throw new RangeError("targetStart out of bounds");
                if (n < 0 || n >= this.length) throw new RangeError("sourceStart out of bounds");
                if (o < 0) throw new RangeError("sourceEnd out of bounds");
                o > this.length && (o = this.length), e.length - r < o - n && (o = e.length - r + n);
                var i, s = o - n;
                if (this === e && n < r && r < o) for (i = s - 1; i >= 0; --i) e[i + r] = this[i + n]; else if (s < 1e3 || !t.TYPED_ARRAY_SUPPORT) for (i = 0; i < s; ++i) e[i + r] = this[i + n]; else Uint8Array.prototype.set.call(e, this.subarray(n, n + s), r);
                return s
            }, t.prototype.fill = function (e, r, n, o) {
                if ("string" == typeof e) {
                    if ("string" == typeof r ? (o = r, r = 0, n = this.length) : "string" == typeof n && (o = n, n = this.length), 1 === e.length) {
                        var i = e.charCodeAt(0);
                        i < 256 && (e = i)
                    }
                    if (void 0 !== o && "string" != typeof o) throw new TypeError("encoding must be a string");
                    if ("string" == typeof o && !t.isEncoding(o)) throw new TypeError("Unknown encoding: " + o)
                } else "number" == typeof e && (e = 255 & e);
                if (r < 0 || this.length < r || this.length < n) throw new RangeError("Out of range index");
                if (n <= r) return this;
                r >>>= 0, n = void 0 === n ? this.length : n >>> 0, e || (e = 0);
                var s;
                if ("number" == typeof e) for (s = r; s < n; ++s) this[s] = e; else {
                    var u = t.isBuffer(e) ? e : W(new t(e, o).toString()), a = u.length;
                    for (s = 0; s < n - r; ++s) this[s + r] = u[s % a]
                }
                return this
            };
            var et = /[^+\/0-9A-Za-z-_]/g
        }).call(e, r(30).Buffer, function () {
            return this
        }())
    }, function (t, e) {
        "use strict";

        function r(t) {
            var e = t.length;
            if (e % 4 > 0) throw new Error("Invalid string. Length must be a multiple of 4");
            return "=" === t[e - 2] ? 2 : "=" === t[e - 1] ? 1 : 0
        }

        function n(t) {
            return 3 * t.length / 4 - r(t)
        }

        function o(t) {
            var e, n, o, i, s, u = t.length;
            i = r(t), s = new c(3 * u / 4 - i), n = i > 0 ? u - 4 : u;
            var a = 0;
            for (e = 0; e < n; e += 4) o = f[t.charCodeAt(e)] << 18 | f[t.charCodeAt(e + 1)] << 12 | f[t.charCodeAt(e + 2)] << 6 | f[t.charCodeAt(e + 3)], s[a++] = o >> 16 & 255, s[a++] = o >> 8 & 255, s[a++] = 255 & o;
            return 2 === i ? (o = f[t.charCodeAt(e)] << 2 | f[t.charCodeAt(e + 1)] >> 4, s[a++] = 255 & o) : 1 === i && (o = f[t.charCodeAt(e)] << 10 | f[t.charCodeAt(e + 1)] << 4 | f[t.charCodeAt(e + 2)] >> 2, s[a++] = o >> 8 & 255, s[a++] = 255 & o), s
        }

        function i(t) {
            return a[t >> 18 & 63] + a[t >> 12 & 63] + a[t >> 6 & 63] + a[63 & t]
        }

        function s(t, e, r) {
            for (var n, o = [], s = e; s < r; s += 3) n = (t[s] << 16) + (t[s + 1] << 8) + t[s + 2], o.push(i(n));
            return o.join("")
        }

        function u(t) {
            for (var e, r = t.length, n = r % 3, o = "", i = [], u = 16383, f = 0, c = r - n; f < c; f += u) i.push(s(t, f, f + u > c ? c : f + u));
            return 1 === n ? (e = t[r - 1], o += a[e >> 2], o += a[e << 4 & 63], o += "==") : 2 === n && (e = (t[r - 2] << 8) + t[r - 1], o += a[e >> 10], o += a[e >> 4 & 63], o += a[e << 2 & 63], o += "="), i.push(o), i.join("")
        }

        e.byteLength = n, e.toByteArray = o, e.fromByteArray = u;
        for (var a = [], f = [], c = "undefined" != typeof Uint8Array ? Uint8Array : Array, h = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/", l = 0, p = h.length; l < p; ++l) a[l] = h[l], f[h.charCodeAt(l)] = l;
        f["-".charCodeAt(0)] = 62, f["_".charCodeAt(0)] = 63
    }, function (t, e) {
        e.read = function (t, e, r, n, o) {
            var i, s, u = 8 * o - n - 1, a = (1 << u) - 1, f = a >> 1, c = -7, h = r ? o - 1 : 0, l = r ? -1 : 1,
                p = t[e + h];
            for (h += l, i = p & (1 << -c) - 1, p >>= -c, c += u; c > 0; i = 256 * i + t[e + h], h += l, c -= 8) ;
            for (s = i & (1 << -c) - 1, i >>= -c, c += n; c > 0; s = 256 * s + t[e + h], h += l, c -= 8) ;
            if (0 === i) i = 1 - f; else {
                if (i === a) return s ? NaN : (p ? -1 : 1) * (1 / 0);
                s += Math.pow(2, n), i -= f
            }
            return (p ? -1 : 1) * s * Math.pow(2, i - n)
        }, e.write = function (t, e, r, n, o, i) {
            var s, u, a, f = 8 * i - o - 1, c = (1 << f) - 1, h = c >> 1,
                l = 23 === o ? Math.pow(2, -24) - Math.pow(2, -77) : 0, p = n ? 0 : i - 1, y = n ? 1 : -1,
                d = e < 0 || 0 === e && 1 / e < 0 ? 1 : 0;
            for (e = Math.abs(e), isNaN(e) || e === 1 / 0 ? (u = isNaN(e) ? 1 : 0, s = c) : (s = Math.floor(Math.log(e) / Math.LN2), e * (a = Math.pow(2, -s)) < 1 && (s--, a *= 2), e += s + h >= 1 ? l / a : l * Math.pow(2, 1 - h), e * a >= 2 && (s++, a /= 2), s + h >= c ? (u = 0, s = c) : s + h >= 1 ? (u = (e * a - 1) * Math.pow(2, o), s += h) : (u = e * Math.pow(2, h - 1) * Math.pow(2, o), s = 0)); o >= 8; t[r + p] = 255 & u, p += y, u /= 256, o -= 8) ;
            for (s = s << o | u, f += o; f > 0; t[r + p] = 255 & s, p += y, s /= 256, f -= 8) ;
            t[r + p - y] |= 128 * d
        }
    }, function (t, e) {
        var r = {}.toString;
        t.exports = Array.isArray || function (t) {
            return "[object Array]" == r.call(t)
        }
    }])
});