(function(factory) {
    /* global define */
    if (typeof define === 'function' && define.amd) {
        // AMD. Register as an anonymous module.
        define(['jquery'], factory);
    } else if (typeof module === 'object' && module.exports) {
        // Node/CommonJS
        module.exports = factory(require('jquery'));
    } else {
        // Browser globals
        factory(window.jQuery);
    }
}(function($) {

    var ytVideo = function(context) {
        var self = this;
        var options = context.options;
        var isIncludedInToolbar = false;

        for (var idx in options.toolbar) {
            // toolbar => [groupName, [list of button]]
            var buttons = options.toolbar[idx][1];
            if ($.inArray('ytVideo', buttons) > -1) {
                isIncludedInToolbar = true;
                break;
            }
        }

        if (!isIncludedInToolbar) {
            return;
        }

        var ui = $.summernote.ui;
        var $editor = context.layoutInfo.editor;
        var lang = options.langInfo;   

        // Define YOUTUBE URL;
        const YOUTUBE_URL = 'https://www.youtube.com/watch?v=VIDEO_ID';
        const YOUTUBE_THUMBNAIL = 'https://img.youtube.com/vi/VIDEO_ID/sddefault.jpg';

        // Create a map button to be used in the toolbar
        context.memo('button.ytVideo', function() {
            var button = ui.button({
                contents: "<i class='fab fa-youtube-square'/>",
                tooltip: lang.youtubeVideoButton.tooltip,
                click: function(e) {
                    self.show();
                }
            });

            return button.render();
        });

        this.createVideoDialog = function($container) {          
            var dialogOption = {
                title: lang.VideoDialog.title,
                body: '<div class="form-group">' +
                    '<label>' + lang.VideoDialog.label + '</label>' +
                    '<input id="youtube-video-id-input" class="form-control" type="text" placeholder="' + lang.VideoDialog.placeholder + '" />' +
                    '</div>',
                footer: '<button href="#" id="btn-add" class="btn btn-primary">' + lang.VideoDialog.button + '</button>',
                closeOnEscape: true
            };

            self.$dialog = ui.dialog(dialogOption).render().appendTo($container);
            self.$dialog.css({
                "z-index": "20",
                "height": "100%"
            });
            self.$addBtn = self.$dialog.find('#btn-add');
            self.$videoInput = self.$dialog.find('#youtube-video-id-input')[0];           
            // self.$mapContainer = self.$dialog.find('#map-in-dialog')[0];
        };

        this.enableAddButton = function() {
            if (self.$videoInput.value && self.$videoInput.value.length > 0) {
                self.$addBtn.attr("disabled", false);
            }
        };

        this.disableAddButton = function() {
            self.$addBtn.attr("disabled", true);
        };

        this.showVideoDialog = function() {
            // self.disableAddButton();
            self.enableAddButton();
            self.$videoInput.value = "";

            return $.Deferred(function(deferred) {
                ui.onDialogShown(self.$dialog, function() {
                    context.triggerEvent('dialog.shown');
                    self.$videoInput.focus();
                    // google.maps.event.trigger(self.map, 'resize');
                    $('.modal-backdrop').css("z-index", 10);

                    self.$addBtn.click(function(event) {
                        event.preventDefault();
                        deferred.resolve({
                            place: self.$videoInput.value
                        });
                    });
                });

                ui.onDialogHidden(self.$dialog, function() {      
                    self.$addBtn.off('click');
                    if (deferred.state() === 'pending') {
                        deferred.reject();
                    }
                });

                ui.showDialog(self.$dialog);
            });
        };

        this.show = function() {
            context.invoke('editor.saveRange');

            self.showVideoDialog()
            .then(function(data) {
                context.invoke('editor.restoreRange');
                self.insertVideoEleToEditor(data.place);
                ui.hideDialog(self.$dialog);
            }).fail(function() {
                context.invoke('editor.restoreRange');
            });
        };

        this.insertVideoEleToEditor = function(video_id) {
            var $div_element_container = $('<div>', { class : 'ytvideo' });
            var $div = $('<div>', {
                class: 'youtube-video-summernote',
            });            
            var $anchor_tag = $('<a>', {
                href: YOUTUBE_URL.replace("VIDEO_ID", video_id),        
            });
            var $img = $('<img>', {
                src: YOUTUBE_THUMBNAIL.replace('VIDEO_ID', video_id),
            });     
           
            $div.html($img);
            $anchor_tag.html($div);  
            $div_element_container.html($anchor_tag);                    
            context.invoke('editor.insertNode',$div_element_container[0]);
        };

        this.initialize = function() {
            var $container = options.dialogsInBody ? $(document.body) : $editor;
            self.createVideoDialog($container);
        };

        this.destroy = function() {
            ui.hideDialog(self.$dialog);
            self.$dialog.remove();
        };
    };

    $.extend(true, $.summernote, {
        lang: {
            'en-US': {
                youtubeVideoButton: {
                    tooltip: "Youtube Video"
                },
                VideoDialog: {
                    title: "Insert Youtube Video",
                    label: "Video id",
                    placeholder: "e.g. 5NQOJQmN6AA",
                    button: "Insert Video"
                }
            },
            'th-TH': {
                youtubeVideoButton: {
                    tooltip: "แผนที่"
                },
                VideoDialog: {
                    title: "แทรกแผนที่",
                    label: "ชื่อสถานที่หรือที่อยู่",
                    placeholder: "e.g. Eiffel Tower",
                    button: "แทรกแผนที่"
                }
            }
        },
        plugins: {
            'ytVideo': ytVideo
        }
    });

}));

var loadAPIPromise;

function loadScript(url, callback) {
    if (!loadAPIPromise) {
        var deferred = $.Deferred();
        $.getScript(url)
            .done(function(script, textStatus) {
                deferred.resolve();
            })
            .fail(function(jqxhr, settings, exception) {
                console.log('Unable to load script: ' + url);
                console.log(exception)
            });
        loadAPIPromise = deferred.promise();
    }
    loadAPIPromise.done(callback);
}