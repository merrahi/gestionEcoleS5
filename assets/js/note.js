//  note.js

//const $ = require('jquery');
// this "modifies" the jquery module: adding behavior to it
// the bootstrap module doesn't export/return anything
//require('bootstrap');

// or you can include specific pieces
// require('bootstrap/js/dist/tooltip');
// require('bootstrap/js/dist/popover');




// a supprimer
var $collectionHolder;

// setup an "add a tag" link
var $addTagButton = $('<button type="button" class="add_tag_link">Add a tag</button>');
var $newLinkLi = $('<li></li>').append($addTagButton);

$(document).ready(function() {
    // load groupes
    $("#filiere-notes").on("change",function (e) {
        let path =$(this).find('option:selected').data('path');
        $.ajax({
            url: path,
            type: "GET",
            dataType: "json",
            //data:{grId:$(this).val()},
            async: true,
            success: function (groupes) {
                // Groupes
                $("#groupe-notes").empty();
                $( groupes ).each(function( index, groupe ) {
                    console.log( index + ": " + groupe );
                    var option='<option value="'+groupe.id+'">'+groupe.libelle+'</option>';
                    $("#groupe-notes").append(option);
                });
            },
            complete : function () {
                // get modules
                loadModules($('#groupe-notes').val());
                //loadNotes();
            }
        });
    });
    // load modules
    $("#groupe-notes").on("change",function (e) {
        let groupe =$(this).val();
        loadModules(groupe);
    });
    // load exams
    $("#module-notes").on("change",function (e) {
        let module =$(this).val();
        loadExams(module);
    });
    // Laod notes
    $('body').on("click",'ul#exam-notes > li',function (e) {
        e.preventDefault();
        if(!$(this).hasClass('active')){
            $('ul#exam-notes> li').removeClass('active');
            $(this).addClass('active');
            let exam =$(this).data('id');
            loadNotes(exam);
        }
    });

    function loadModules(groupe){
        $.ajax({
            url: 'modules/groupe/'+groupe,
            type: "GET",
            dataType: "json",
            async: true,
            success: function (modules) {
                // modules
                // Groupes
                $("#module-notes").empty();
                $( modules ).each(function( index, module ) {
                    console.log( index + ": " + module );
                    var option='<option value="'+module.id+'">'+module.libelle+'</option>';
                    $("#module-notes").append(option);
                });
            },
            complete : function () {
                // get exams
                 $("#exam-notes").empty();
                loadExams($('#module-notes').val());
                //loadNotes();
            }
        });
    }

    function loadExams(module){
        $.ajax({
            url: 'exams/module/'+module,
            type: "GET",
            dataType: "json",
            async: true,
            success: function (exams) {
                // modules
                // Groupes
                $("#exam-notes").empty();
                $( exams ).each(function( index, exam ) {
                    var active= index ? '' : 'active';
                    var li='<li class="list-group-item '+active+'" data-id="'+exam.id+'">'+ exam.type_e +' '+ exam.name_e +' '+ exam.fait_le +'</li>';
                    /*var option='<option value="'+exam.id+'">'+exam.name_e+'</option>';*/
                    $("#exam-notes").append(li);
                });
            },
            complete : function () {
                // get exams
                //$("#exam-notes").empty();
                $("#listNotes > tbody").empty();
                loadNotes($('#exam-notes > li.active').data('id'));
                //loadNotes();
            }

        });
    }

    function loadNotes( exam){

        $.ajax({
            url: 'notes/exam/'+exam,
            type: "GET",
            dataType: "json",
            async: true,
            success: function (notes) {

                //notes
                $("#listNotes > tbody").empty();
                $(notes).each(function (index, note) {
                var row = '<tr> '
                    + '<td scope="row">'
                    + '  <span class="custom-control custom-checkbox">'
                    + '    <input type="checkbox" class="custom-control-input check-notes" id="check-notes'+note.id+'" >'
                    + '    <label class="custom-control-label" for="check-notes'+note.id+'"></label>'
                    + '  </span>'
                    + '</td>'
                    + '<td scope="row">' + note.id + '</td>'
                    + '<td>' + note.etudiant.first_name + '</td>'
                    + '<td>' + note.etudiant.last_name + '</td>'
                    + '<td>' + note.moyenne + '</td>'
                    + '<td>' + note.appreciation + '</td>'
                    +'<td class="actions">'
                    +   '<a href="/etudiant/details/"' + note.etudiant.id + '" class="btn btn-success"><i class="fa fa-eye" aria-hidden="true"></i></a>'
                    +   '<a href="/etudiant/edit/"' + note.etudiant.id + '" class="btn btn-primary"><i class="fa fa-edit" aria-hidden="true"></i></a>'
                    +   '<a href="/etudiant/delete/"' + note.etudiant.id + '" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>'
                    + '</td>'
                    + '</tr>';
                $("#listNotes > tbody").append(row);
            });
            }
        });
    }



    $(".close").click(function () {
        console.log('alert');
        $(".alert").hide();
    });
    // a supprimer

    // Get the ul that holds the collection of tags
    $collectionHolder = $('ul.tags');

    // add the "add a tag" anchor and li to the tags ul
    $collectionHolder.append($newLinkLi);

    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    $collectionHolder.data('index', $collectionHolder.find('input').length);

    $addTagButton.on('click', function(e) {
        // add a new tag form (see next code block)
        addTagForm($collectionHolder, $newLinkLi);
    });



    function addTagForm($collectionHolder, $newLinkLi) {
        // Get the data-prototype explained earlier
        var prototype = $collectionHolder.data('prototype');

        // get the new index
        var index = $collectionHolder.data('index');

        var newForm = prototype;
        // You need this only if you didn't set 'label' => false in your tags field in TaskType
        // Replace '__name__label__' in the prototype's HTML to
        // instead be a number based on how many items we have
        // newForm = newForm.replace(/__name__label__/g, index);

        // Replace '__name__' in the prototype's HTML to
        // instead be a number based on how many items we have
        newForm = newForm.replace(/__name__/g, index);

        // increase the index with one for the next item
        $collectionHolder.data('index', index + 1);

        // Display the form in the page in an li, before the "Add a tag" link li
        var $newFormLi = $('<li></li>').append(newForm);
        $newLinkLi.before($newFormLi);
    }

});