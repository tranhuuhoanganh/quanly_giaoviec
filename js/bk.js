window.addEventListener("load", (function() { var t, e = null,
        n = 25e5,
        o = 2e7,
        l = 3e6,
        a = document.getElementsByClassName("bk-btn"),
        s = "",
        r = document.getElementById("bk-modal"),
        d = "",
        c = "https://ws.baokim.vn/payment-services",
        m = window.location.hostname; "m." == (m = m.replace("www.", "")).substring(0, 2) && (m = m.substring(2)); var p = window.location.protocol;

    function u() { var n = document.getElementsByClassName("bk-product-name"),
            o = document.getElementsByClassName("bk-product-price"),
            l = document.getElementsByClassName("bk-product-qty"),
            a = document.getElementsByClassName("bk-product-image"),
            s = document.getElementsByClassName("bk-product-property"),
            r = [],
            d = [],
            u = [],
            g = [],
            b = ""; for (maxLoop = n.length, i = 0; i < maxLoop; i++) { r.push(n[i].innerHTML); var y = P(o[i].innerHTML);
            y = o[i].firstElementChild && o[i].firstElementChild.innerHTML.match(/\d+/g) ? P(o[i].firstElementChild.innerHTML) : P(o[i].innerHTML), d.push(y); var v = null;
            a[i] && (a[i].hasAttribute("data-src") ? v = a[i].getAttribute("data-src") : a[i].hasAttribute("src") ? v = a[i].getAttribute("src") : a[i].hasAttribute("data-o_src") && (v = a[i].getAttribute("data-o_src")), v && !1 === v.includes("//") && (v = p + "//" + m + "/" + v)), g.push(v), void 0 !== l[i] && l[i].value ? u.push(l[i].value) : u.push(1) } var h = "undefined" != typeof variant_id_pro ? variant_id_pro : null; if (!h) { var f = document.getElementById("product-selectors");
            f && (h = f.value); var k = document.getElementById("product-select");
            k && (h = k.value); var _ = document.querySelectorAll("[name=variantId]");
            _.length > 0 && (h = _[0].value); var E = document.getElementById("productSelect");
            E && (h = E.value) } var L = null,
            x = s.length; if (x > 0) { for (i = 0; i < x; i++) { var C = s[i];
                h || (h = C.value, isNaN(h) && (h = null)), "input" == C.tagName.toLowerCase() ? b += C.value + " - " : "select" == C.tagName.toLowerCase() ? b += C.options[C.selectedIndex].text + " - " : b += C.innerHTML + " " } b = b.substring(0, b.length - 2) } var N = []; for (i = 0; i < maxLoop; i++) { "undefined" != typeof meta && void 0 !== meta.product && (L = meta.product.id); var T = { name: r[i], image: g[i], quantity: u[i], price: d[i], platform_product_id: L, platform_variant_id: h };
            N.push(T) } var w = { products: N, domain: m, merchantLogo: t.logo, productProperty: b };
        console.log(w); var B = I("POST", c + "api/v1/order-temporary/store", JSON.stringify(w));
        B && (e = B.token) } console.log(m),
        function() { var e = I("GET", "https://pc.baokim.vn/api/plus/get-merchant?domain=" + m, null); if (!e) return; if (200 != e.code) return; var i = e.meta; if (!i) return; if (null == (t = i.data)) return g.style.display = "none", b.style.display = "none", y.style.display = "none", v.style.display = "none", h.style.display = "none", void(f.style.display = "none"); var c = t.config,
                p = c.payment,
                u = c.installment,
                k = c.installment_amigo;
            r && (d += '<div id="bk-modal-payment" class="bk-modal">', d += '<div class="bk-modal-content" id="bk-modal-content-style">', d += '<div id="bk-modal-pop" class="bk-modal-header">', d += '<div class="bk-container-fluid" style="box-sizing: border-box">', d += '<div class="bk-row bk-popup-header">', d += '<div class="bk-col-5 bk-col-lg-3" style="box-sizing: border-box" id="bk-logo">', d += "</div>", d += '<div class="bk-col-3 bk-col-lg-6" style="box-sizing: border-box">', d += "</div>", d += '<div class="bk-col-4 bk-col-lg-3 bk-text-right" style="box-sizing: border-box">', d += '<button type="button" id="bk-modal-close">&times;</button>', d += "</div>", d += "</div>", d += "</div>", d += "</div>", d += '<div class="bk-modal-body">', d += '<iframe width="100%" height="100%" id="iframe" src=""></iframe>', d += "</div>", d += "</div>", d += "</div>", d += '<div id="bk-modal-notify" class="bk-modal">', d += '<div class="bk-modal-content" id="bk-modal-content-notify">', d += '<div class="bk-modal-header">', d += '<div class="bk-container-fluid">', d += '<div class="bk-row bk-popup-header">', d += '<div class="bk-col-3" id="bk-logo">', d += "</div>", d += '<div class="bk-col-6">', d += "</div>", d += '<div class="bk-col-3 bk-text-right">', d += '<button type="button" id="bk-modal-close">&times;</button>', d += "</div>", d += "</div>", d += "</div>", d += "</div>", d += '<div class="bk-modal-body">', d += '<p class="text-center">Sản phẩm đã hết hàng, không thể thanh toán</p>', d += '<button type="button" class="bk-modal-notify-close bk-btn-notify-close">Đóng</button>', d += "</div>", d += "</div>", d += "</div>", r.innerHTML = d); if (p.enable) { var _ = document.getElementsByClassName("bk-product-price"),
                    E = !0,
                    L = _.length; for (w = 0; w < L; w++) { if ("LIÊN HỆ" === (H = _[w].innerHTML).toUpperCase() || "ĐẶT HÀNG" === H.toUpperCase()) return void(E = !1); if (void 0 === (H = _[w].firstElementChild && _[w].firstElementChild.innerHTML.match(/\d+/g) ? P(_[w].firstElementChild.innerHTML) : P(_[w].innerHTML))) return void(E = !1) } if (E) { var C = "Giao tận nơi hoặc nhận tại cửa hàng",
                        N = "#e00",
                        T = "#fff"; if (null != t.style_popup) { const e = t.style_popup; for (var w = 0; w < e.length; w++) 1 == e[w].type && 1 == e[w].status && (null != e[w].note_btn_integrated && (C = e[w].note_btn_integrated), null != e[w].bg_color_btn_payment && (N = e[w].bg_color_btn_payment), null != e[w].tx_color_btn_payment && (T = e[w].tx_color_btn_payment)) } s += '<button class="bk-btn-paynow" style="display: inline-block;background-color: ' + N + " !important;color: " + T + ' !important" type="button">', s += "<strong>Mua ngay</strong>", s += "<span>" + C + "</span>", s += "</button>" } } if (u.enable) { var B = 0,
                    M = (_ = document.getElementsByClassName("bk-product-price"), document.getElementsByClassName("bk-product-name"));
                L = _.length; for (console.log("length: " + L), w = 0; w < L; w++) { var H = P(_[w].innerHTML);
                    H = _[w].firstElementChild && _[w].firstElementChild.innerHTML.match(/\d+/g) ? P(_[w].firstElementChild.innerHTML) : P(_[w].innerHTML), M.length > 1 ? B += H : B = H } var A = !1; "donghoduyanh.com" == m && (l = 5e6), B >= l && (A = !0), "demo-bkplus.baokim.vn" != m && "devtest.baokim.vn:9405" != m && "devtest.baokim.vn" != m && "bkplus.myharavan.com" != m || (A = !0); var O = "Visa, Master, JCB",
                    S = "#288ad6",
                    j = "#fff"; if (null != t.style_popup) { const e = t.style_popup; for (w = 0; w < e.length; w++) 2 == e[w].type && 1 == e[w].status && (null != e[w].note_btn_integrated && (O = e[w].note_btn_integrated), null != e[w].bg_color_btn_installment && (S = e[w].bg_color_btn_installment), null != e[w].tx_color_btn_installment && (j = e[w].tx_color_btn_installment)) } A && (s += '<button class="bk-btn-installment" style="display: inline-block;background-color: ' + S + " !important;color: " + j + ' !important" type="button">', s += "<strong>Trả góp qua thẻ</strong>", s += "<span>" + O + "</span>", s += "</button>") } if (k.enable) { B = 0, _ = document.getElementsByClassName("bk-product-price"), M = document.getElementsByClassName("bk-product-name"), L = _.length; for (w = 0; w < L; w++) { console.log(w + " : " + _[w].innerHTML);
                    H = P(_[w].innerHTML);
                    H = _[w].firstElementChild && _[w].firstElementChild.innerHTML.match(/\d+/g) ? P(_[w].firstElementChild.innerHTML) : P(_[w].innerHTML), M.length > 1 ? B += H : B = H } var q = !1; if (k.hasOwnProperty("min_order_amount") && (n = k.min_order_amount), k.hasOwnProperty("max_order_amount") && (o = k.max_order_amount), B >= n && B <= o && (q = !0), "demo-bkplus.baokim.vn" != m && "devtest.baokim.vn:9405" != m && "devtest.baokim.vn" != m && "bkplus.myharavan.com" != m || (q = !0), console.log(B), q) { "<strong>MUA NGAY - TRẢ SAU</strong>", "<span>Lãi suất 0% - Phê duyệt trong 20 giây</span>", "</div>", s += '<button class="bk-btn-installment-amigo" style="display: flex" type="button">', s += '<div class="bk-insta-content"><strong>MUA NGAY - TRẢ SAU</strong><span>Lãi suất 0% - Phê duyệt trong 20 giây</span></div>', s += "</button>" } } for (x in a) a[x].innerHTML = s }(); var g = document.getElementById("bk-btn-paynow"),
        b = document.getElementsByClassName("bk-btn-paynow"),
        y = document.getElementById("bk-btn-installment"),
        v = document.getElementsByClassName("bk-btn-installment"),
        h = document.getElementById("bk-btn-installment-amigo"),
        f = document.getElementsByClassName("bk-btn-installment-amigo"),
        k = document.getElementsByClassName("bk-btn-paynow-list"),
        _ = document.getElementsByClassName("bk-btn-installment-list"),
        E = document.getElementById("bk-modal-payment"),
        L = document.getElementById("bk-modal-notify"),
        C = document.getElementById("bk-modal-close"),
        N = document.getElementsByClassName("bk-modal-notify-close"),
        T = document.getElementById("iframe"),
        w = document.getElementById("bk-modal-pop"),
        B = document.getElementById("bk-modal-content-style"); if (b.length > 0)
        for (x = 0; x < b.length; x++) b[x].addEventListener("click", (function() { M(this) })); if (v.length > 0)
        for (x = 0; x < v.length; x++) v[x].addEventListener("click", (function() { M(this, "/installment") })); if (f.length > 0)
        for (x = 0; x < f.length; x++) f[x].addEventListener("click", (function() { M(this, "/insta/installment") }));

    function M(n, o = "") { if ("bk-btn-paynow" == n.className) { var i = "#006d9c"; if (null != t.style_popup) { const e = t.style_popup; for (var l = 0; l < e.length; l++) 1 == e[l].type && 1 == e[l].status && (null != e[l].bg_color_mdl_payment && (i = e[l].bg_color_mdl_payment, w.style.backgroundColor = i), 2 == e[l].display_mode_popup && (B.style.width = "100%", B.style.margin = "0px", B.style.height = "100%")) } } if ("bk-btn-installment" == n.className) { var a = "#006d9c"; if (null != t.style_popup) { const e = t.style_popup; for (l = 0; l < e.length; l++) 2 == e[l].type && 1 == e[l].status && (null != e[l].bg_color_mdl_installment && (a = e[l].bg_color_mdl_installment, w.style.backgroundColor = a), 2 == e[l].display_mode_popup && (B.style.width = "100%", B.style.margin = "0px", B.style.height = "100%")) } } if ("bk-btn-installment-amigo" == n.className) { var s = "#006d9c"; if (null != t.style_popup) { const e = t.style_popup; for (l = 0; l < e.length; l++) 3 == e[l].type && 1 == e[l].status && (null != e[l].bg_color_mdl_insta && (s = e[l].bg_color_mdl_insta, w.style.backgroundColor = s), 2 == e[l].display_mode_popup && (B.style.width = "100%", B.style.margin = "0px", B.style.height = "100%")) } } var r, d, c = document.getElementsByClassName("bk-check-out-of-stock"),
            m = !1; if (c.length > 0)
            for (l = 0; l < c.length; l++) { if ("Hết hàng" === c[l].value) return m = !0, null; if ("Liên hệ" === c[l].value) return m = !0, null }
        if (m) L.css({ display: "block" }), L.removeClass("hide");
        else { var p = navigator.vendor && navigator.vendor.indexOf("Apple") > -1 && navigator.userAgent && -1 == navigator.userAgent.indexOf("CriOS") && -1 == navigator.userAgent.indexOf("FxiOS");
            e || u(); var g = O(o);
            0 == p ? (T.setAttribute("src", g), E.style.display = "block", E.classList.remove("hide"), r = document.getElementsByTagName("body")[0], d = r.offsetWidth, r.style.overflow = "hidden", r.style.width = d) : window.location = g } } if (document.addEventListener("keydown", (t => { "Escape" === t.key && (E.style.display = "none", S()) })), C && C.addEventListener("click", (function() { E.style.display = "none", S() })), N.length > 0)
        for (j = 0; j < N.length; j++) N[j].addEventListener("click", (function() { L.style.display = "none", S() })); if (k.length > 0)
        for (i = 0; i < k.length; i++) k[i].addEventListener("click", (function() { H(this) })); if (_.length > 0)
        for (i = 0; i < _.length; i++) _[i].addEventListener("click", (function() { H(this, "/installment") }));

    function H(t, e = "") { var n = {},
            o = [],
            i = [],
            l = [];
        i.push(t.getAttribute("data-price")), l.push(t.getAttribute("data-image")), o.push(t.getAttribute("data-name")), n.productPrices = i, n.productNames = o, n.productImages = l, console.log(n), A(n); var a = O(e);
        T.setAttribute("src", a) } var A = function(n) { E.style.display = "block", E.classList.remove("hide"); var o = ["1"];
        maxLoopList = n.productNames.length; var l = []; for (i = 0; i < maxLoopList; i++) { var a = { name: n.productNames[i], image: n.productImages[i], quantity: o[i], price: n.productPrices[i] };
            l.push(a) } var s = { products: l, domain: m, merchantLogo: t.logo, productProperty: "" },
            r = I("POST", c + "api/v1/order-temporary/store", JSON.stringify(s));
        r && (e = r.token) };

    function I(t, e, n, o = !1) { var i = new XMLHttpRequest;
        i.open(t, e, o); var l = null; try { i.setRequestHeader("Content-Type", "application/json"), i.send(n), l = i.response, l = JSON.parse(l), console.log(l) } catch (t) { console.log("Request failed"), console.log(t) } return l }

    function O(t = "") { return "https://pg.baokim.vn/" + t + "?token=" + e }

    function S() { var t = document.getElementsByTagName("body")[0];
        t.style.overflow = "auto", t.style.width = "auto" }

    function P(t) { return price = t.replace("VNĐ", ""), price = t.replace("VND", ""), price = t.replace(/[\[\]&]+/g, ""), price = t.split(".").join(""), price = price.split(",").join(""), price = price.split(" ").join(""), price = t.replace(/[^0-9]/g, ""), price = parseInt(price, 10), price } if ("undefined" != typeof meta && console.log(meta), "xedienvietthanh.com" == window.location.hostname) { for (i = 0; i < b.length; i++) b[i].innerHTML = "", b[i].innerHTML = '<strong style="display: block">Mua ngay</strong><span style="display: block">(Mua online được giảm giá 500k)</span><span style="display: block; margin-bottom: 5px;">Giao hàng miễn phí</span>'; for (i = 0; i < v.length; i++) v[i].innerHTML = "", v[i].innerHTML = '<strong style="display: block">Mua trả góp 0%</strong><span style="display: block"> Thủ tục đơn giản</span><span style="display: block; margin-bottom: 5px;">Qua thẻ: Visa, Master, JCB</span>' } }));