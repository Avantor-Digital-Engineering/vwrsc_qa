    var startElement;
    var stopCalled;
    var max = 0;
    var prevHelper;

    $(document).ready(function () {
        initialize_sortable();
    });
    function init_sortable() {

        $("#ulQuestions, #ulAnswers").sortable({
            connectWith: ".connectedSortable",
            placeholder: "place",
            helper: 'clone',
            receive: function (event, ui) {
                if (ui.sender.hasClass('answers')) {
                    if (ui.item.next().hasClass('dummy'))
                        ui.item.next().remove();
                    else if (ui.item.prev().hasClass('dummy'))
                        ui.item.prev().remove();
                    else
                        removeDummy(ui.item, ($(ui.item).index() == 0))
                   
                }
                else {
                    if (stopCalled) {
                        stopCalled = false;
                        return;
                    }
                    createDummy();
                }
                ui.item.css('border', '1px solid #CCC');
            },

            change: function (event, ui) {

                if (prevHelper && prevHelper.hasClass('dummy'))
                    prevHelper.css('border', '1px solid #CCC');

                if (ui.placeholder.next().hasClass('dummy')) {

                    ui.placeholder.next().css('border', '1px solid #000');
                    prevHelper = ui.placeholder.next();
                }
            },

            remove: function (event, ui) {
                if (ui.item.hasClass('dummy')) {
                    stopCalled = true;
                    $(this).sortable('cancel');
                }
            },

            start: function (event, ui) {

                if (ui.item.prev().hasClass('dummy'))
                    startElement = ui.item.prev();
                else
                    startElement = ui.item.next().next();
            },

            create: function (event, ui) {
                init_sortable();
            }
        }).disableSelection();
    }

    function createDummy() {
        var lastItem = (startElement.length != 0);
        var html = '<li class="dummy content_ht"><div>Drag and Drop it here </div></li>';

        if (lastItem) {

            $('.placeHolder').append(html);
            $('.placeHolder').find('li').last().height(max);

        }
        else {
            startElement.after(html);
            startElement.next().height(max);
        }
    }

    function removeDummy(item, down) {
        if (down) {
            if (item.next().hasClass('dummy'))
                item.next().remove();
            else if (item.next().length != 0)
                removeDummy(item.next(), down);
            else
                removeDummy(item.prev(), false);
        }
        else {

            if (item.prev().hasClass('dummy'))
                item.prev().remove();
            else if (item.prev().length != 0)
                removeDummy(item.prev(), down);
            else
                removeDummy(item.next(), true);
        }
    }

    function initialize_sortable() {

        $('.answers').find('.content_ht').each(function (index) {


            if ($(this).height() > max) max = $(this).height();

        });

        $('.answers').find('.content_ht').each(function (index) {

            $(this).height(max);
        });

        $('.placeHolder').find('.dummy').each(function (index) {

            $(this).height(max);
        });

        $('.questions').find('.content_ht').each(function (index) {

            $(this).height(max);
        });

        var cont_hei = $('.answers').find('.content_ht').length * max + 70;
        $('.answers').height(cont_hei);
        $('.placeHolder').height(cont_hei);
        $('.questions').height(cont_hei);

        init_sortable();
    }