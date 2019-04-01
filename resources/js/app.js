
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