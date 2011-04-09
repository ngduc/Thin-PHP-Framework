/**
 * Controls: Image plugin
 *
 * Depends on jWYSIWYG
 */
(function ($) {
	if (undefined === $.wysiwyg) {
		throw "wysiwyg.image.js depends on $.wysiwyg";
	}

	if (!$.wysiwyg.controls) {
		$.wysiwyg.controls = {};
	}

	/*
	 * Wysiwyg namespace: public properties and methods
	 */
	$.wysiwyg.controls.image = {
		init: function (Wysiwyg) {
			var self = this, elements, dialog, szURL, formImageHtml,
				formTextLegend, formTextPreview, formTextUrl, formTextTitle,
				formTextDescription, formTextWidth, formTextHeight, formTextOriginal,
				formTextFloat, formTextFloatNone, formTextFloatLeft, formTextFloatRight,
				formTextSubmit, formTextReset,
				img = {
					alt: "",
					self: Wysiwyg.dom.getElement("img"), // link to element node
					src: "http://",
					title: ""
				};

			formTextLegend  = "Insert Image";
			formTextPreview = "Preview";
			formTextUrl     = "URL";
			formTextTitle   = "Title";
			formTextDescription = "Description";
			formTextWidth   = "Width";
			formTextHeight  = "Height";
			formTextOriginal = "Original W x H";
			formTextFloat	= "Float";
			formTextFloatNone = "None";
			formTextFloatLeft = "Left";
			formTextFloatRight = "Right";
			formTextSubmit  = "Insert Image";
			formTextReset   = "Cancel";

			if ($.wysiwyg.i18n) {
				formTextLegend = $.wysiwyg.i18n.t(formTextLegend, "dialogs.image");
				formTextPreview = $.wysiwyg.i18n.t(formTextPreview, "dialogs.image");
				formTextUrl = $.wysiwyg.i18n.t(formTextUrl, "dialogs.image");
				formTextTitle = $.wysiwyg.i18n.t(formTextTitle, "dialogs.image");
				formTextDescription = $.wysiwyg.i18n.t(formTextDescription, "dialogs.image");
				formTextWidth = $.wysiwyg.i18n.t(formTextWidth, "dialogs.image");
				formTextHeight = $.wysiwyg.i18n.t(formTextHeight, "dialogs.image");
				formTextOriginal = $.wysiwyg.i18n.t(formTextOriginal, "dialogs.image");
				formTextFloat = $.wysiwyg.i18n.t(formTextFloat, "dialogs.image");
				formTextFloatNone = $.wysiwyg.i18n.t(formTextFloatNone, "dialogs.image");
				formTextFloatLeft = $.wysiwyg.i18n.t(formTextFloatLeft, "dialogs.image");
				formTextFloatRight = $.wysiwyg.i18n.t(formTextFloatRight, "dialogs.image");
				formTextSubmit = $.wysiwyg.i18n.t(formTextSubmit, "dialogs.image");
				formTextReset = $.wysiwyg.i18n.t(formTextReset, "dialogs");
			}

			formImageHtml = '<form class="wysiwyg"><fieldset><legend>' + formTextLegend + '</legend>' +
				'<label>' + formTextPreview + ': <img src="" alt="' + formTextPreview + '" style="float: left; margin: 5px; width: 80px; height: 60px; border: 1px solid rgb(192, 192, 192);"/></label>' +
				'<label>' + formTextUrl + ': <input type="text" name="src" value=""/></label>' +
				'<label>' + formTextTitle + ': <input type="text" name="imgtitle" value=""/></label>' +
				'<label>' + formTextDescription + ': <input type="text" name="description" value=""/></label>' +
				'<label>' + formTextWidth + ' x ' + formTextHeight + ': <input type="text" name="width" value="" class="width"/> x <input type="text" name="height" value="" class="height"/></label>' +
				'<label>' + formTextOriginal + ': <input type="text" name="naturalWidth" value="" class="width" disabled="disabled"/> x ' +
				'<input type="text" name="naturalHeight" value="" class="height" disabled="disabled"/></label>' +
				'<label>' + formTextFloat + ': <select name="float">' + 
				'<option value="">' + formTextFloatNone + '</option>' +
				'<option value="left">' + formTextFloatLeft + '</option>' +
				'<option value="right">' + formTextFloatRight + '</option></select></label>' +
				'<input type="submit" class="button" value="' + formTextSubmit + '"/> ' +
				'<input type="reset" value="' + formTextReset + '"/></fieldset></form>';

			if (img.self) {
				img.src = img.self.src ? img.self.src : "";
				img.alt = img.self.alt ? img.self.alt : "";
				img.title = img.self.title ? img.self.title : "";
				img.width = img.self.width ? img.self.width : "";
				img.height = img.self.height ? img.self.height : "";
			}

			if ($.modal) {
				elements = $(formImageHtml);
				elements = self.makeForm(elements, img);

				$.modal(elements, {
					onShow: function (dialog) {
						$("input:submit", dialog.data).click(function (e) {
							self.processInsert(dialog, Wysiwyg, img);

							$.modal.close();
							return false;
						});
						$("input:reset", dialog.data).click(function (e) {
							$.modal.close();
							return false;
						});
						$("fieldset", dialog.data).click(function (e) {
							e.stopPropagation();
						});
					},
					maxWidth: Wysiwyg.defaults.formWidth,
					maxHeight: Wysiwyg.defaults.formHeight,
					overlayClose: true
				});
			} else if ($.fn.dialog) {
				elements = $(formImageHtml);
				elements = self.makeForm(elements, img);

				dialog = elements.appendTo("body");
				dialog.dialog({
					modal: true,
					width: Wysiwyg.defaults.formWidth,
					height: Wysiwyg.defaults.formHeight,
					open: function (ev, ui) {
						$("input:submit", dialog).click(function (e) {
							self.processInsert(dialog, Wysiwyg, img);

							$(dialog).dialog("close");
							return false;
						});
						$("input:reset", dialog).click(function (e) {
							$(dialog).dialog("close");
							return false;
						});
						$('fieldset', dialog).click(function (e) {
							e.stopPropagation();
						});
					},
					close: function (ev, ui) {
						dialog.dialog("destroy");
					}
				});
			} else {
				if ($.browser.msie) {
					Wysiwyg.ui.focus();
					Wysiwyg.editorDoc.execCommand("insertImage", true, null);
				} else {
					elements = $("<div/>")
						.css({"position": "fixed",
							"z-index": 2000,
							"left": "50%", "top": "50%", "background": "rgb(0, 0, 0)",
							"margin-top": -1 * Math.round(Wysiwyg.defaults.formHeight / 2),
							"margin-left": -1 * Math.round(Wysiwyg.defaults.formWidth / 2)})
						.html(formImageHtml);
					elements = self.makeForm(elements, img);

					$("input:submit", elements).click(function (event) {
						self.processInsert(elements, Wysiwyg, img);

						$(elements).remove();
						return false;
					});
					$("input:reset", elements).click(function (event) {
						if ($.browser.msie) {
							Wysiwyg.ui.returnRange();
						}

						$(elements).remove();
						return false;
					});

					$("body").append(elements);
					elements.click(function(e) {
						e.stopPropagation();
					});
				}
			}

			$(Wysiwyg.editorDoc).trigger("editorRefresh.wysiwyg");
		},

		processInsert: function (form, Wysiwyg, img) {
			var image,
				szURL = $('input[name="src"]', form).val(),
				title = $('input[name="imgtitle"]', form).val(),
				description = $('input[name="description"]', form).val(),
				width = $('input[name="width"]', form).val(),
				height = $('input[name="height"]', form).val(),
				styleFloat = $('select[name="float"]', form).val(),
				style = [],
				found;

			if (img.self) {
				// to preserve all img attributes
				$(img.self).attr("src", szURL)
					.attr("title", title)
					.attr("alt", description)
					.css("float", styleFloat);

				if (width.toString().match(/^[0-9]+(px|%)?$/)) {
					$(img.self).css("width", width);
				} else {
					$(img.self).css("width", "");
				}

				if (height.toString().match(/^[0-9]+(px|%)?$/)) {
					$(img.self).css("height", height);
				} else {
					$(img.self).css("height", "");
				}
			} else {
				found = width.toString().match(/^[0-9]+(px|%)?$/);
				if (found) {
					if (found[1]) {
						style.push("width: " + width + ";");
					} else {
						style.push("width: " + width + "px;");
					}
				}

				found = height.toString().match(/^[0-9]+(px|%)?$/);
				if (found) {
					if (found[1]) {
						style.push("height: " + height + ";");
					} else {
						style.push("height: " + height + "px;");
					}
				}

				if (styleFloat.length > 0) {
					style.push("float: " + styleFloat + ";");
				}

				if (style.length > 0) {
					style = ' style="' + style.join(" ") + '"';
				}

				image = "<img src='" + szURL + "' title='" + title + "' alt='" + description + "'" + style + "/>";
				Wysiwyg.insertHtml(image);
			}
		},

		makeForm: function (form, img) {
			form.find("input[name=src]").val(img.src);
			form.find("input[name=imgtitle]").val(img.title);
			form.find("input[name=description]").val(img.alt);
			form.find('input[name="width"]').val(img.width);
			form.find('input[name="height"]').val(img.height);
			form.find('img').attr("src", img.src);

			form.find('img').bind("load", function () {
				if (form.find('img').attr("naturalWidth")) {
					form.find('input[name="naturalWidth"]').val(form.find('img').attr("naturalWidth"));
					form.find('input[name="naturalHeight"]').val(form.find('img').attr("naturalHeight"));
				}
			});

			form.find("input[name=src]").bind("change", function () {
				form.find('img').attr("src", this.value);
			});

			return form;
		}
	};

	$.wysiwyg.insertImage = function (object, szURL, attributes) {
		if ("object" !== typeof (object) || !object.context) {
			object = this;
		}

		if (!object.each) {
			console.error($.wysiwyg.messages.noObject);
		}

		return object.each(function () {
			var self = $(this).data("wysiwyg"),
				image,
				attribute;

			if (!self) {
				return this;
			}

			if (!szURL || szURL.length === 0) {
				return this;
			}

			if ($.browser.msie) {
				self.ui.focus();
			}

			if (attributes) {
				self.editorDoc.execCommand("insertImage", false, "#jwysiwyg#");
				image = self.getElementByAttributeValue("img", "src", "#jwysiwyg#");

				if (image) {
					image.src = szURL;

					for (attribute in attributes) {
						if (attributes.hasOwnProperty(attribute)) {
							image.setAttribute(attribute, attributes[attribute]);
						}
					}
				}
			} else {
				self.editorDoc.execCommand("insertImage", false, szURL);
			}

			$(self.editorDoc).trigger("editorRefresh.wysiwyg");

			return this;
		});
	};
})(jQuery);