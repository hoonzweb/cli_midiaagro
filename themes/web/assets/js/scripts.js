$(function () {
    // mobile menu open
    $(".j_toggle_menu_mobile").click(function (e) {
        e.preventDefault();

        $(this).toggleClass("open");
        if ($(".j_menu_mobile").hasClass("active")) {
            $(".j_menu_mobile").removeClass("active").fadeOut("fast");
        } else {
            $(".j_menu_mobile").addClass("active").fadeIn("fast");
        }
    });

    // search toggle
    $(".j_toggle_search").click(function (e) {
        e.preventDefault();

        $(this).toggleClass("open");
        if ($(".j_search").hasClass("active")) {
            $(".j_search").removeClass("active").fadeOut("fast");
        } else {
            $(".j_search").addClass("active").fadeIn("fast", function () {
                $(this).find("input").focus();
            });
        }
    });

    // focus and blur
    $(".j_focus_blur").focus(function () {
        var el = $(this);
        var valDefault = el.data('value');
        var val = el.val();
        if (val === valDefault) {
            el.val('');
        }
        el.on("blur", function () {
            if (el.val() === '') {
                el.val(valDefault);
            }
        });
    });

    // scroll animate
    $("[data-go]").click(function (e) {
        e.preventDefault();

        var goto = $($(this).data("go")).offset().top;
        $("html, body").animate({scrollTop: goto}, goto / 2, "easeOutBounce");
    });

    //ajax form
    $("form:not('.ajax_off')").submit(function (e) {
        e.preventDefault();
        var form = $(this);
        var load = $(".ajax_load");
        var flashClass = "ajax_response";
        var flash = $(form).find("." + flashClass);

        form.ajaxSubmit({
            url: form.attr("action"),
            type: "POST",
            dataType: "json",
            beforeSend: function () {
                load.fadeIn(200).css("display", "flex");
            },
            success: function (response) {
                //redirect
                if (response.redirect) {
                    window.location.href = response.redirect;
                } else {
                    load.fadeOut(200);
                }

                //message
                if (response.message) {
                    if (flash.length) {
                        flash.html(response.message).fadeIn(100).effect("bounce", 300);
                    } else {
                        form.prepend("<div class='" + flashClass + "'>" + response.message + "</div>")
                            .find("." + flashClass).effect("bounce", 300);
                    }
                } else {
                    flash.fadeOut(100);
                }
            },
            complete: function () {
                if (form.data("reset") === true) {
                    form.trigger("reset");
                }
            }
        });
    });

    $(".j_ads").each(function () {
        var obj = $(this);
        var objImg = obj.find("a");
        var interval = 5000;

        objImg.hide();
        objImg.first().addClass("active").show();
        if (objImg.length > 1) {
            setInterval(function () {
                obj.find(".active").fadeOut("slow", function () {
                    if ($(this).next().length) {
                        $(this).removeClass().next().addClass("active").fadeIn("slow");
                    } else {
                        objImg.removeClass().first().addClass("active").fadeIn("slow");
                    }
                });
            }, interval);
        }
    });
});