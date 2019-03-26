
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

$(document).ready(function () {
    $('.quill-container').each(function () {
        var quillContainer = this;
        new Quill(quillContainer, {
            modules: {
                toolbar: [
                    ['bold', 'italic', 'underline', 'strike'],
                    ['link', 'blockquote', 'image'],
                    [{ list: 'ordered' }, { list: 'bullet' }]
                ]
            },
            theme: 'snow'
        });

        $(quillContainer).parents('form').on('submit', function () {
            $(quillContainer).siblings('input[type=hidden]').val(
                $(quillContainer).children('.ql-editor').html()
            );
        });
    });
})