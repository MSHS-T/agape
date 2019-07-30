
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

$(document).ready(function () {
    $('.quill-container').each(function () {
        var quillContainer = this;
        var quill = new Quill(quillContainer, {
            modules: {
                toolbar: [
                    ['bold', 'italic', 'underline', 'strike'],
                    [{ 'color': ["#000000", "#e60000", "#ff9900", "#ffff00", "#008a00", "#0066cc", "#9933ff", "#ffffff", "#facccc", "#ffebcc", "#ffffcc", "#cce8cc", "#cce0f5", "#ebd6ff", "#bbbbbb", "#f06666", "#ffc266", "#ffff66", "#66b966", "#66a3e0", "#c285ff", "#888888", "#a10000", "#b26b00", "#b2b200", "#006100", "#0047b2", "#6b24b2", "#444444", "#5c0000", "#663d00", "#666600", "#003700", "#002966", "#3d1466"] }],
                    ['link', 'blockquote', 'image'],
                    [{ list: 'ordered' }, { list: 'bullet' }]
                ],
                keyboard: {
                    bindings: {
                        tab: {
                            key: 9,
                            handler: function () {
                                $(quillContainer).closest(".form-group.row")
                                    .next(".form-group.row")
                                    .find(':input,.ql-editor')
                                    .first()
                                    .focus();
                            }
                        }
                    }
                },
            },
            theme: 'snow'
        });
        quill.on('text-change', function () {
            $(quillContainer).siblings('input[type=hidden]').val(
                $(quillContainer).children('.ql-editor').html()
            );
        });
        $(quillContainer).find('.ql-toolbar').find(':button').attr('tabindex', '-1');
        tabindex = parseInt($(quillContainer).attr('data-tabindex'), 10);
        $(quillContainer).find('.ql-editor').attr('tabindex', tabindex);
    });

    $('[data-toggle="tooltip"]').tooltip();
})