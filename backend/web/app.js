$(function(){
    'use strict';
    $('#uploadFile').change(ev => {
        $(ev.target).closest('form').trigger('submit');
    })
})