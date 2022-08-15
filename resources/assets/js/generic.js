$(document).ready(function () {

    // $(window).on('load', function() {
    //     $(document.body).addClass('is-fully-loaded');
    // });


    require('object-fit-images')();

    $.material.init();

    $('.carousel').carousel();

    jQuery('.js-select').select2();

    $('.delete-btn-modal-js').click(function (e) {
        e.preventDefault();
        $('#deleteModal').modal('show');
        $('#deleteModalForm').attr('action', e.target.getAttribute('data-action'));
    });

    $('.data-table').DataTable({
        responsive: true,
        "language": {
            "processing": "Подождите...",
            "search": "Поиск:",
            "lengthMenu": "Показать _MENU_ записей",
            "info": "Записи с _START_ до _END_ из _TOTAL_ записей",
            "infoEmpty": "Записи с 0 до 0 из 0 записей",
            "infoFiltered": "(отфильтровано из _MAX_ записей)",
            "infoPostFix": "",
            "loadingRecords": "Загрузка записей...",
            "zeroRecords": "Записи отсутствуют.",
            "emptyTable": "В таблице отсутствуют данные",
            "paginate": {
                "first": "Первая",
                "previous": "Предыдущая",
                "next": "Следующая",
                "last": "Последняя"
            },
            "aria": {
                "sortAscending": ": активировать для сортировки столбца по возрастанию",
                "sortDescending": ": активировать для сортировки столбца по убыванию"
            }
        },
        "order": [[0, 'asc']]
    });

    $('[type="file"]').on('change', function (e) {
        const label = e.target.parentNode.querySelector('label');

        var dflt = e.target.getAttribute('placeholder');

        label.textContent = e.target.value ? e.target.files[0].name : dflt;
    });


    $(document).on('click', '#noteEditorRevealer', function (e) {
        var noteField = $('#noteField');
        var noteText = $('#noteText');

        noteField.val(noteText.text());
        noteField.parent().show();
    });

    $(document).on('click', '#noteEditorCloser', function (e) {
        $('#noteField').parent().hide();
    });

    $(document).on('click', '#noteUpdater', function (e) {
        e.preventDefault();

        var noteText = $('#noteText');
        var defaultNote = 'Заметка об ученике';
        // var oldNote = noteText.text().trim();

        var noteField = $('#noteField');
        var newNote = noteField.val().trim();

        noteField.parent().hide();

        $.ajax({
            type: "POST",
            url: this.href,
            data: { note: newNote || defaultNote, field: 'note' },
            success: function (response) {
                var message = response.message;
                if (response.isUpdated) {
                    noteText.text(newNote || defaultNote);
                    toastr.success(message);
                } else {
                    toastr.error(message);
                }
            },
            dataType: 'json',
        });
    });

    $(document).on('click', '.js-editor-revealer', function (e) {
        var $revealer = $(this);
        var $parent = $revealer.closest('.js-editor-block');
        var $messageText = $parent.find('.js-editor-message');
        var $editorActions = $parent.find('.js-editor-actions');

        $messageText.removeAttr('readonly');
        $messageText.addClass('editor-message--active');
        $messageText.focus();

        $editorActions.show();
        $revealer.hide();
    });

    $(document).on('click', '.js-editor-closer', function (e) {
        var $closer = $(this);
        var $parent = $closer.closest('.js-editor-block');

        var $revealer = $parent.find('.js-editor-revealer');
        var $messageText = $parent.find('.js-editor-message');
        var $editorActions = $parent.find('.js-editor-actions');

        $revealer.show();
        $editorActions.hide();

        $messageText.prop('readonly', true);
        $messageText.removeClass('editor-message--active');
    });


    $(document).on('click', '.js-editor-updater', function (e) {
        e.preventDefault();

        var $updater = $(this);
        var $parent = $updater.closest('.js-editor-block');

        var $revealer = $parent.find('.js-editor-revealer');
        var $messageText = $parent.find('.js-editor-message');
        var $editorActions = $parent.find('.js-editor-actions');

        var newMessage = $messageText.val();

        $editorActions.hide();
        $revealer.show();

        $messageText.prop('readonly', true);
        $messageText.removeClass('editor-message--active');

        $.ajax({
            type: "POST",
            url: this.href,
            data: { message: newMessage, field: 'message' },
            success: function (response) {
                var message = response.message;
                if (response.isUpdated) {
                    $messageText.text(newMessage);
                    toastr.success(message);
                } else {
                    toastr.error(message);
                }
            },
            dataType: 'json',
        });
    });


    $(document).on('change', '#userGroupSelect', function (e) {

        $name = $('#userGroupName');

        e.preventDefault();

        $group = $(e.target);

        var text = $group.find('option:selected').text();

        $.ajax({
            type: "POST",
            url: $group.data('url'),
            data: { group_id: $group.val(), field: 'group_id' },
            success: function (response) {
                var message = response.message;
                if (response.isUpdated) {
                    $name.text(text);
                    toastr.success(message);
                } else {
                    toastr.error(message);
                }
            },
            dataType: 'json',
        });
    });


    $('.js-role-picker-remover').on('click', function () {
        $(this).closest('.role-picker-overlay').remove();
    });

    $('#user-menu-revealer').on('click', function(e) {
        $(e.target).parent().toggleClass('revealed');
    });
});


