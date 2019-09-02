$("#encode").click(function () {
    var div = $("<div>");
    div.html($("#input").val());
    output = bbencode(div);
    $("#output").val(output);
});

$("#decode").click(function () {
    var output = $("#output").val()
    var html = bbdecode(output, true);
    $("#html").val(html);
    $("#preview").html(html);
});

function bbdecode(bbcode, paragraphs) {
    //BBCodes
    this.codes = {
        "h1": function (value) {
            return "<h1>" + value + "</h1>";
        },
        "h2": function (value) {
            return "<h2>" + value + "</h2>";
        },
        "h3": function (value) {
            return "<h3>" + value + "</h3>";
        },
        "h4": function (value) {
            return "<h2>" + value + "</h4>";
        },
        "h5": function (value) {
            return "<h2>" + value + "</h5>";
        },
        "h6": function (value) {
            return "<h2>" + value + "</h6>";
        },
        "br": function () {
            return "<br>";
        },
        "b": function (value) {
            return "<b>" + value + "</b>";
        },
        "i": function (value) {
            return "<i>" + value + "</i>";
        },
        "u": function (value) {
            return "<u>" + value + "</u>";
        },
        "s": function (value) {
            return "<s>" + value + "</s>";
        },
        "center": function (value) {
            return "<span style=\"text-align: center; display: block;\">" + value + "</span>";
        },
        "right": function (value) {
            return "<span style=\"text-align: right; display: block;\">" + value + "</span>";
        },
        "size": function (value, attribute) {
            return $("<span>").html(value).css("font-size", attribute + "px");
        },
        "font": function (value, attribute) {
            return $("<span>").html(value).css("font-family", attribute);
        },
        "color": function (value, attribute) {
            return $("<span>").html(value).css("color", attribute);
        },
        "highlight": function (value, attribute) {
            return $("<span>").html(value).css("background", attribute);
        },
        "url": function (value, attribute) {
            if (attribute) {
                return $("<a>").html(value).attr({"href": attribute, "target": "_blank"});
            }
            return $("<a>").html(value).attr({"href": value, "target": "_blank"});
        },
        "img": function (value) {
            return $("<img>").attr("src", value);
        },
        "list": function (value, attribute) {
            value = value.replace("</li>", "")
                .replace(/((?:<br>)*)<br><\/li>/g, "$1</li>")
                .replace(/\s*?<br>\s*?<ul>/g, "<ul>")
                .replace(/\s*<br><\/li>/g, "</li>")
                .replace(/^<br>/, "")
                .replace(/<br>$/, "")
                .replace(/\s*?<\/li>/g, "</li>")
                .replace(/<\/ul>\s*(<br>)?/g, "</ul>")
                .trim();
            var style = "";
            var tag = "ul";
            switch (attribute) {
                case "a":
                    style = "lower-alpha";
                    break;
                case "A":
                    style = "upper-alpha";
                    break;
                case "i":
                    style = "lower-roman";
                    break;
                case "I":
                    style = "upper-roman";
                    break;
                case "circle":
                    style = "circle";
                    break;
                case "square":
                    style = "square";
                    break;
                case "disc":
                    style = "disc";
            }
            switch (attribute) {
                case "1":
                case "a":
                case "A":
                case "i":
                case "I":
                    tag = "ol";
            }
            return $("<" + tag + ">").html(value + (value ? "</li>" : "")).css("list-style-type", style);
        },
        "*": function (value, attribute) {
            return "</li><li>";
        },
        "code": function (value) {
            return "<pre><code>" + value.trim() + "</code></pre>";
        }
    };

    //BBCodes of which content shouldn't be parsed
    this.noparse = ["noparse", "code"];

    //Escape HTML entities
    var bbcode = $("<div>").text(bbcode).html()

    //Replace new lines with [br]
        .replace(/(\r\n)|(\n\r)|(\n)|(\r)/g, "[br]")

        //Escape square brackets and replace [br] with new lines in noparse tags
        .replace(new RegExp("\\[(" + this.noparse.join("|") + ")\\](.*?)\\[\/\\1\\]", "g"), function (match, tag, value) {
            value = value.replace(/\[br\]/g, "\r\n")
                .replace(/\[/g, "&lsqb;")
                .replace(/\]/g, "&rsqb;");
            return "[" + tag + "]" + value + "[/" + tag + "]";
        })

        //Escape left square brackets that have been
        //added to content without escaping or noscript tags by mistake
        .replace(/\[ /g, "&lsqb; ")

        //Check if bbcode attribute has a key, otherwise add a key
        .replace(/\[([^ \[\]]+?(?! ))=(.+?)\]/g, function (match, tag, attribute) {
            return "[" + tag + " value=" + attribute.replace(/=/g, "&equals;") + "]";
        })

        //Check if bbcode attributes are quoted, otherwise add quotes
        .replace(/\[([^ \[\]]+?)( .+?)\]/g, function (match, tag, attributes) {
            attributes = (attributes + " m=").replace(/ ([^ ]+?)=("|')?(.+?)\2(?= [^ ]+?=)/g, function (match, key, quote, value) {
                if (quote == "'") {
                    value = value.replace(/\\\'/g, "&apos;").replace(/'/g, "&apos;");
                } else {
                    value = value.replace(/\\\"/g, "&quot;").replace(/"/g, "&quot;");
                }
                quote = quote ? quote : "\"";
                return " " + key + "=" + quote + value + quote;
            }).slice(0, -3);
            return "[" + tag + attributes + "]";
        })

        //Self close BBcode tags without closing tag
        .replace(/\[([^ /\[\]]+?)(?: .+?|)\]/g, function (match, tag) {
            if (!new RegExp("\\[\/" + tag + "\\]").test(bbcode)) {
                return match.slice(0, -1) + "/]";
            }
            return match;
        })

        //Replace all tags e.g. [x] with [bbcode bbcode="x"]
        .replace(/\[\/.*?\]/g, "[/bbcode]")
        .replace(/\[(\/)?(.+?)( .+?)?(\/)?\]/g, function (match, slash1, tag, attributes, slash2) {
            if (tag == "bbcode") {
                return match;
            }
            slash1 = slash1 ? slash1 : "";
            tag = $("<div>").text(tag).html();
            attributes = attributes ? attributes : "";
            slash2 = slash2 ? slash2 : "";
            return "\[" + slash1 + "bbcode bbcode=\"" + tag + "\"" + attributes + slash2 + "\]";
        });

    //Convert to XML and add root element
    var xml = "<!DOCTYPE bbcode [<!ENTITY lsqb \"[\"><!ENTITY rsqb \"]\"><!ENTITY equals \"=\">]><bbcode>" + bbcode.replace(/\[/g, "<").replace(/\]/g, ">") + "</bbcode>";

    //XML element to HTML string
    var self = this;

    function decode(element) {
        var r = "";
        $(element).contents().each(function () {
            if (this.nodeType == 3) {
                r += $("<div>").text(this.data).html();
            } else {
                var contents = decode(this);
                if (this.attributes.bbcode && this.attributes.bbcode.value && self.codes[this.attributes.bbcode.value]) {
                    var attributes;
                    if (this.attributes.length == 2) {
                        attributes = this.attributes.value.value;
                    } else {
                        attributes = {};
                        for (x in this.attributes) {
                            attributes[this.attributes[x].name] = this.attributes[x].value;
                        }
                    }
                    var html = self.codes[this.attributes.bbcode.value](contents, attributes);
                    if ($.type(html) !== "string") {
                        html = $("<div>").append(html).html()
                    }
                    r += html;
                } else {
                    r += contents;
                }
            }
        });
        return r;
    }

    function wrapParagraphs(html) {
        html = $("<div>").html(html + "<br><br>");

        //Tags allowed inside paragraphs
        var phrasingContent = ["a", "abbr", "audio", "b", "bdi", "bdo", "br", "button", "canvas", "cite", "code", "command", "datalist", "dfn", "em", "embed", "i", "iframe", "img", "input", "kbd", "keygen", "label", "mark", "math", "meter", "noscript", "object", "output", "progress", "q", "ruby", "s", "samp", "script", "select", "small", "span", "strong", "sub", "sup", "svg", "textarea", "time", "u", "var", "video", "wbr"];

        //Get dividers between paragraphs
        var matches = html.contents().filter(function () {
            var tag = this && this.tagName ? this.tagName.toLowerCase() : false;
            var nextTag = this.nextSibling && this.nextSibling.tagName ? this.nextSibling.tagName.toLowerCase() : false;
            return (tag == "br" && nextTag == "br") || (tag && phrasingContent.indexOf(tag) == -1);
        });

        function prevUntil(node, nodes) {
            if (node.previousSibling) {
                var tag = node.previousSibling.tagName ? node.previousSibling.tagName.toLowerCase() : false;
                if ((phrasingContent.indexOf(tag) > -1) || !tag) {
                    nodes.unshift(node.previousSibling);
                    prevUntil(node.previousSibling, nodes)
                }
                ;
            }
            return nodes;
        }

        matches.each(function () {
            var prev = prevUntil(this, []);
            if (prev.length) {
                $(prev).wrapAll("<p>");
            }
        });

        html.children("p").children("br + br").prev().remove().end().remove()

        html.children("p").each(function () {
            if ($(this).contents().length < 2 && ($(this).children("br").length || !$(this).contents().length)) {
                $(this).replaceWith("<br>");
            }
        });

        return html.html().slice(0, -8);
    }

    //XML string to Data Object Model
    try {
        var dom = $.parseXML(xml);
        var html = decode($(dom).children("bbcode"));
        html = paragraphs ? wrapParagraphs(html) : html;
        return html;
    } catch (error) {
        //Error invalid XML
        window.console && console.error(error);
    }
}

function bbencode(element) {

    this.codes = [
        function (value) {
            if (this[0].tagName == "H1" || this[0].tagName == "H2" || this[0].tagName == "H3" || this[0].tagName == "H4" || this[0].tagName == "H5" || this[0].tagName == "H6") {
                var hSize = this[0].tagName.slice(-1);
                var Size = 7 - hSize;
                return bbcode("size", value, Size.toString());
            }
        },
        function (value) {
            if (this[0].tagName == "B" || this[0].tagName == "STRONG") {
                return bbcode("b", value);
            }
            if (this[0].tagName == "I" || this[0].tagName == "EM") {
                return bbcode("i", value);
            }
            if (this[0].tagName == "U") {
                return bbcode("u", value);
            }
            if (this[0].tagName == "S" || this[0].tagName == "DEL") {
                return bbcode("s", value);
            }
        },
        function (value) {
            if (this[0].tagName == "A") {
                if (this.html() == this.attr("href")) {
                    return bbcode("url", this.html());
                }
                return bbcode("url", value, this.attr("href"));
            }
        },
        function () {
            if (this[0].tagName == "IMG") {
                return bbcode("img", this.attr("src"));
            }
        },
        function (value) {
            if (this[0].tagName == "UL") {
                return bbcode("list", value.trim().replace(/(.)\s*(\[(?:\*|list)\])/g, "$1$2"));
            }
        },
        function (value) {
            if (this[0].tagName == "LI") {
                return "[*]" + value.trim();
            }
        },
        function (value, raw) {
            if (this[0].tagName == "CODE") {
                return bbcode("code", raw);
            }
        },
        function (value) {
            if (this[0].tagName != "A" && this.css("color") != this.parent().css("color")) {
                return bbcode("color", value, this.css("color"));
            }
        },

        // function (value) {
        //     if (this.css("background-color") != this.parent().css("background-color")) {
        //         return bbcode("highlight", value, this.css("background-color"));
        //     }
        // },
        function (value) {
            var check = $("<" + this[0].tagName + ">");
            $("html").append(check);
            if (this.css("font-size") != check.css("font-size") && this.css("font-size") != this.parent().css("font-size")) {
                return bbcode("size", value, convertFontsize(parseInt(this.css("font-size"))));
            }
            check.remove();
        },
        function (value) {
            var check = $("<" + this[0].tagName + ">");
            $("html").append(check);
            if (this.css("font-family") != check.css("font-family") && this.css("font-family") != this.parent().css("font-family")) {
                return bbcode("font", value, this.css("font-family"));
            }
            check.remove();
        },
        function (value) {
            if (this.css("text-align") == "center" && this.parent().css("text-align") != "center") {
                return bbcode("center", value);
            }
            if (this.css("text-align") == "right" && this.parent().css("text-align") != "right") {
                return bbcode("right", value);
            }
            if (this.css("text-align") == "left" && this.parent().css("text-align") != "left") {
                return bbcode("left", value);
            }
        },

        function (value) {
            if (this[0].tagName == "P" && this.next().length && this.next()[0].tagName == "P") {
                return value + "\r\n";
            }
        },

        function () {
            if (this[0].tagName == "BR") {
                return "\r\n";
            }
        }
    ];

    function bbcode(tag, value, attributes) {
        var attribute = "";
        if ($.type(attributes) === "string") {
            attribute = "=\"" + attributes + "\"";
        }
        return "[" + tag + attribute + "]" + (value ? value + "[/" + tag + "]" : "");
    }

    function convertFontsize(size) {
        var pixsize = parseInt(size);
        var fontsize = 0;
        if (pixsize <= 10) {
            fontsize = 1;
        } else if (pixsize > 10 && pixsize <= 13) {
            fontsize = 2
        } else if (pixsize > 13 && pixsize <= 16) {
            fontsize = 3
        } else if (pixsize > 16 && pixsize <= 18) {
            fontsize = 4
        } else if (pixsize > 18 && pixsize <= 24) {
            fontsize = 5
        } else if (pixsize > 24 && pixsize <= 32) {
            fontsize = 6
        } else if (pixsize > 32) {
            fontsize = 7
        }
        return fontsize.toString();
    }

    var self = this;

    function encode(element) {
        element.contents().each(function () {
            var raw = $(this).html();
            var elements = encode($(this));
            if (this.nodeType == 3) {
                this.data = this.data.replace(/( \t)+/g, " ").replace(/(\r\n|\n|\r)/g, "");
            } else {
                for (x in self.codes) {
                    var r = self.codes[x].call($(this), elements, raw);
                    elements = r ? r : elements;
                }
                $(this).replaceWith(elements);
            }
        });
        return element.html();
    }


    element = element.clone().hide();
    $("html").append(element);
    var encoded = encode(element).trim();
    element.remove();
    return encoded;
}




