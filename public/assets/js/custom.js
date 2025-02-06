Array.prototype.clean = function(deleteValue = '') {
    for (var i = 0; i < this.length; i++) {
        if (this[i] == deleteValue) {
            this.splice(i, 1);
            i--;
        }
    }
    return this;
};
Array.prototype.unique = function() {
    var a = this.concat();
    for (var i = 0; i < a.length; ++i) {
        for (var j = i + 1; j < a.length; ++j) {
            if (a[i] === a[j])
                a.splice(j--, 1);
        }
    }
    return a;
};
Array.prototype.remove = function() {
    var what, a = arguments,
        L = a.length,
        ax;
    while (L && this.length) {
        what = a[--L];
        while ((ax = this.indexOf(what)) !== -1) {
            this.splice(ax, 1);
        }
    }
    return this;
};
$.ajaxSetup({
    error: function(jqXHR, textStatus, errorThrown) {

    }
});

function selectFileWithCKFinder(elementId) {
    CKFinder.modal({
        chooseFiles: true,
        width: 800,
        height: 600,
        onInit: function(finder) {
            finder.on('files:choose', function(evt) {
                var file = evt.data.files.first();
                var output = document.getElementById(elementId);
                output.value = file.getUrl();
                $(`.filename`).html( file.getUrl());
            });

            finder.on('file:choose:resizedImage', function(evt) {
                var output = document.getElementById(elementId); 
                output.value = evt.data.resizedUrl;
            });
        }
    });
}
 var editor = CKEDITOR.replace('ckfinder');
 CKFinder.setupCKEditor(editor);
var Plugins = function() {

    var _componentInit = function() {
        swal.setDefaults({
            buttonsStyling: false,
            confirmButtonClass: 'btn btn-primary',
            cancelButtonClass: 'btn btn-light'
        });
        $('.tokenfield').tokenfield({
            delimiter: ','
        });
        $('.maxlength').maxlength({
            alwaysShow: true,
            placement: 'bottom'
        });
        $('[data-toggle="tooltip"]').tooltip();
        $('.form-input-styled').uniform();
        $('select.select').select2({
            minimumResultsForSearch: Infinity
        });
        $('.form-control-file').uniform({
            fileButtonClass: 'action btn bg-blue',
            selectClass: 'uniform-select bg-pink-400 border-pink-400'
        });
        $('.mask-decimal').inputmask({
                alias: 'decimal',
                groupSeparator: '.',
                autoGroup: true
            })
            // Select with search
        $('.select-search').select2();
        $('body').delegate('.form-control-file', 'click', function(e) {
            e.preventDefault()
            selectFileWithCKFinder($(this).data('key'))
        })
    };


    //
    // Return objects assigned to module
    //

    return {
        init: function() {
            _componentInit();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    Plugins.init();
});