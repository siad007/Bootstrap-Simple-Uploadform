/*global define*/
/*global $*/
/*global jQuery*/
/*global XMLHttpRequest*/
/*global FormData*/


(function (factory) {
    "use strict";

    if (typeof define === 'function' && define.amd) {
        // AMD. Register as an anonymous module.
        define(['jquery'], factory);
    } else {
        // Browser globals
        factory(jQuery);
    }
}(function ($) {
    "use strict";

    $.fn.bsUploadform = function (action) {
        // default options
        var defaults = {
                // icon for non specific files
                defaultIcon: "<i class='glyphicon glyphicon-file'></i>",
                // icons for specific mimetypes
                filetypeIcons: {
                    image: "<i class='glyphicon glyphicon-camera'></i>",
                    audio: "<i class='glyphicon glyphicon-music'></i>"
                },
                // function that'll  be called at serverresponse
                onServerResponse: function () {
                }
            },
            // merging default options with user input
            settings = $.extend({}, defaults, action);

        return this.each(function () {
            var dialog = $(this),
                input = null,
                btnOpen = null,
                progressbar = null,
                btnUpload = null,
                btnClose = null,
                iconClose = null,
                fileContainer = null,
                files = null,
                fileLen = null,
                folder = null,
                client = new XMLHttpRequest(),
                formData = null,
                current = 0,
                fullSize = 0,
                loaded = 0,
                /**
                 * returns formated filesize.
                 *
                 * @param {numeric} bytes
                 * @return {string}
                 */
                getFileSize = function (bytes) {
                    var i = 0;
                    while (1023 < bytes) {
                        bytes /= 1024;
                        i += 1;
                    }
                    return i ? bytes.toFixed(2) + ["", " KB", " MB", " GB", " TB"][i] : bytes + " Bytes";
                },
                /**
                 * display the choosen files in $(".fileContainer")
                 */
                displayFiles = function () {
                    var i,
                        file = null,
                        html = "",
                        icon = settings.defaultIcon,
                        propIcon = null;
                    for (i = 0; i < fileLen; i += 1) {
                        html = "";
                        file = files[i];

                        fullSize += file.size;

                        // get the right icon for the input file
                        for (propIcon in settings.filetypeIcons) {
                            if (settings.filetypeIcons.hasOwnProperty(propIcon)) {
                                if (file.type.indexOf(propIcon) > -1) {
                                    icon = settings.filetypeIcons[propIcon];
                                }
                            }
                        }

                        html += "<li class='col-lg-12'>";
                        html += "<div class='filetype col-lg-1'>" + icon + "</div>";
                        html += "<strong class='filename col-lg-8'>" + file.name + "</strong>";
                        html += "<small class='filesize muted col-lg-3 text-right'>" +
                            getFileSize(file.size) + "</small>";
                        html += '<div class="clearfix"></div>';
                        html += "</li>";
                        fileContainer.append(html);
                    }
                    $(btnUpload).removeAttr('disabled');
                },
                /**
                 * function to reset buttons states, progressbar, fileContainer, files and counts
                 */
                reset = function () {
                    progressbar.css('width', '100%');
                    fileContainer.empty();
                    files = null;
                    current = 0;
                    progressbar.css('width', '0%');
                    $(btnOpen).removeAttr('disabled');
                    $(btnClose).removeAttr('disabled');
                    $(iconClose).show();
                    if (folder !== null) {
                        $(folder).removeAttr('readonly');
                    }
                    return false;
                },
                /**
                 * function to upload one file
                 *
                 * call settings.onServerResponse when ajax-request has finished
                 */
                uploadFile = function () {

                    /**
                     * cancel recursion after the last file upload
                     */
                    if (current === fileLen) {
                        reset();
                        return false;
                    }

                    var file = files[current],
                        url = settings.url;

                    formData = new FormData();

                    /**
                     * if a folder select exists, get the folder opject and append it to the url
                     */
                    if ($(dialog).find(".folder").length > 0) {
                        folder = $(dialog).find(".folder");
                    }
                    if (folder) {
                        url = settings.url + "/" + folder.val() + "/";
                    }

                    /**
                     * validate the status. The status can be used on the serverside, maybe to put additional
                     * information in the repsonse at the end of the upload-process. (e.g. redirect url / action)
                     */
                    if (current < (fileLen - 1)) {
                        url += "progress";
                    } else {
                        url += "done";
                    }

                    formData.append("file", file);

                    /**
                     * put the additional inputs in the request
                     */
                    $("input", dialog).each(function () {
                        var id = $(this).attr("id"),
                            value = $(this).val();
                        if (value !== "") {
                            formData.append(id, value);
                        }
                    });

                    /**
                     * Errorhandler
                     * @param {Exception} e
                     */
                    client.onerror = function (e) {
                        reset();
                    };

                    /**
                     * Successhandler, increment the total upload filesize
                     * @param {Exception} e
                     */
                    client.onload = function (e) {
                        loaded += files[current].size;
                        current += 1;
                        settings.onServerResponse(client.responseText);
                        uploadFile();
                    };

                    /**
                     * Progresshandler
                     * @param {Exception} e
                     */
                    client.upload.onprogress = function (e) {
                        var l = loaded + e.loaded,
                            p = Math.round(l * 100 / fullSize);
                        progressbar.css('width', p + '%');
                    };

                    /**
                     * Cancelhandler
                     * @param {Exception} e
                     */
                    client.onabort = function (e) {
                        reset();
                    };

                    /**
                     * Serverrequest
                     */
                    client.open("POST", url);
                    client.send(formData);
                };

            /**
             * assign variables and set events
             */
            function init() {
                dialog.addClass('uploadform');

                input = $(dialog).find("input[type=file]");
                btnOpen = $(dialog).find(".openDialog");
                progressbar = $(dialog).find(".progress-bar");
                btnUpload = $(dialog).find(".btnUpload");
                fileContainer = $(dialog).find(".fileContainer");
                btnClose = $(dialog).find(".btn-close");
                iconClose = $(dialog).find(".close");

                $(btnUpload).attr('disabled', 'disabled');

                settings.url = $(dialog).find("form").attr("action");

                if ($(dialog).find(".folder").length > 0) {
                    folder = $(dialog).find(".folder");
                }
                $(btnOpen).unbind();
                $(btnOpen).click(function (e) {
                    e.preventDefault();
                    input.click();
                });
                $(input).unbind();
                $(input).change(function () {
                    current = 0;
                    fullSize = 0;
                    loaded = 0;
                    fileContainer.html("");
                    progressbar.css('width', '0%');
                    files = this.files;
                    fileLen = this.files.length;
                    displayFiles();
                });
                $(btnUpload).unbind();
                $(btnUpload).click(function (e) {
                    e.preventDefault();
                    uploadFile();
                    $(btnOpen).attr('disabled', 'disabled');
                    $(btnUpload).attr('disabled', 'disabled');
                    $(btnClose).attr('disabled', 'disabled');
                    $(iconClose).hide();
                    if (folder !== null) {
                        $(folder).attr('readonly', 'readonly');
                    }
                });
            }

            /**
             * delete variables and unbind events
             */
            function destroy() {
                dialog.removeClass('uploadform');

                $(btnOpen).unbind();
                $(input).unbind();
                $(btnUpload).unbind();

                dialog = null;
                input = null;
                btnOpen = null;
                progressbar = null;
                btnUpload = null;
                btnClose = null;
                fileContainer = null;
                files = null;
                fileLen = null;
                folder = null;
                client = null;
                formData = null;
                current = null;
                fullSize = null;
                loaded = null;
            }

            /**
             * init or destroy plugin
             */
            if (!action || action === 'init' || typeof action === 'object') {
                init();
            } else if (action === 'destroy') {
                destroy();
            }
        });
    };

}));
