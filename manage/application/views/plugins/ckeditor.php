<script src="<?= site_url('assets/js/vendor/ckeditor/ckeditor.js'); ?>"></script>
<script src="<?= site_url('assets/js/vendor/ckeditor/adapters/jquery.js'); ?>"></script>
<script>
    $(function () {
        $('textarea.editor').ckeditor(function (element) {
            setInterval(function() {
                $(element).parent().find('iframe').css('display', 'block');
            }, 100)
        }, {
            toolbarGroups: [
                {name: 'document', groups: ['mode', 'document', 'doctools']},
                {name: 'styles', groups: ['styles']},
                {name: 'clipboard', groups: ['clipboard', 'undo']},
                {name: 'editing', groups: ['find', 'selection', 'spellchecker', 'editing']},
                {name: 'basicstyles', groups: ['basicstyles', 'cleanup']},
                {name: 'forms', groups: ['forms']},
                {name: 'paragraph', groups: ['list', 'indent', 'blocks', 'align', 'bidi', 'paragraph']},
                {name: 'links', groups: ['links']},
                {name: 'insert', groups: ['insert']},
                {name: 'colors', groups: ['colors']},
                {name: 'tools', groups: ['tools']},
                {name: 'others', groups: ['others']},
                {name: 'about', groups: ['about']}
            ],
            removeButtons: 'autoFormat,CommentSelectedRange,UncommentSelectedRange,Print,Preview,NewPage,Templates,PasteText,PasteFromWord,Cut,Copy,Paste,Find,Replace,SelectAll,AutoCorrect,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,Form,Outdent,Indent,Blockquote,CreateDiv,BidiLtr,BidiRtl,Language,Anchor,Flash,HorizontalRule,Smiley,SpecialChar,PageBreak,Iframe,ShowBlocks,Maximize,BGColor,TextColor,Superscript,Subscript,Strike,Format',
        })
    });
</script>