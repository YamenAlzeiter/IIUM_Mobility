(function() {
    if (typeof CKEDITOR !== 'undefined') {
        CKEDITOR.plugins.add('insertId', {
            icons: 'insertId',
            init: function(editor) {
                editor.addCommand('insertUser', {
                    exec: function(editor) {
                        editor.insertText(' {user} ');
                    }
                });
                editor.addCommand('insertReason', {
                    exec: function(editor) {
                        editor.insertText(' {reason} ');
                    }
                });
                editor.addCommand('insertLink', {
                    exec: function(editor) {
                        var linkText = prompt("Enter the text for the link:", "click here");
                        if (linkText !== null && linkText.trim() !== "") {
                            editor.insertHtml(`<a href='{link}'>${linkText}</a>`);
                        }
                    }
                });

                editor.ui.addButton('InsertUser', {
                    label: 'Insert User',
                    command: 'insertUser',
                    toolbar: 'insert',
                    icon: 'https://style.iium.edu.my/images/iconly/light/Add-User.svg'
                });
                editor.ui.addButton('InsertReason', {
                    label: 'Insert Reason',
                    command: 'insertReason',
                    toolbar: 'insert',
                    icon: 'https://style.iium.edu.my/images/iconly/light/Paper.svg'
                });
                editor.ui.addButton('InsertLink', {
                    label: 'Insert Link',
                    command: 'insertLink',
                    toolbar: 'insert',
                    icon: 'https://style.iium.edu.my/images/iconly/light/Bookmark.svg'
                });
            }
        });
    } else {
        // If CKEditor is not loaded, wait and try again
        setTimeout(arguments.callee, 50);
    }
})();
