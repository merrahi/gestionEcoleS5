// app.js

const $ = require('jquery');
// this "modifies" the jquery module: adding behavior to it
// the bootstrap module doesn't export/return anything
//require('bootstrap');

// or you can include specific pieces
// require('bootstrap/js/dist/tooltip');
// require('bootstrap/js/dist/popover');

$(document).ready(function() {
    $("#selectedGroupe").on("change",function (e) {
         e.preventDefault();
        let path =$(this).val();
        console.log(path);
        if($(this).val()=="/etudiant/all") $(location).attr('href',"/etudiant/all");
        $.ajax({
            url: path,
            type: "GET",
            dataType: "json",
            //data:{id:$(this).val()},
            async: true,
            success: function (data) {
                $("#listEtudiants > tbody").empty();
                $( data.etudiants ).each(function( index, etudiant ) {
                    console.log( index + ": " + etudiant );
                    var row='<tr> '
                        +'<img src="{{ asset(\'icons/personne-avatar.png\' ) }} " width="30px" height="30px" class="rounded mx-auto d-block" alt="...">'
                        +'<th scope="row">'+etudiant.id+'</th>'
                        +'<td>'+etudiant.first_name+'</td>'
                        +'<td>'+etudiant.last_name+'</td>'
                      /*  +'<td>'+etudiant.name+'</td>'*/
                        +'<td>'+etudiant.birth_day +'</td>'
                        +'<td>'
                        +'<a href="/etudiant/details/"'+etudiant.id+'" class="btn btn-success">View</a>'
                        +'<a href="/etudiant/edit/"'+etudiant.id+'" class="btn btn-default">edit</a>'
                        +'<a href="/etudiant/delete/"'+etudiant.id+'" class="btn btn-danger">delete</a>'
                        +'</td>'
                        +'</tr>';
                    $("#listEtudiants > tbody").append(row);
                });










                /*let id=data.id;
                let isActive=data.isActive;
                //$("#activeState"+id).addClass("disabledButton");
                isActive ? alert("ko") :  alert("koo");
                isActive ? $("#activeState"+id).addClass("disabledButton").prop("disabled", true) : $("#activeState"+id).prop(disabled, false).removeClass("disabledButton");
                /!*let page= $("."+categoryselect+"").find(".currentPage");
                page.html(parseInt(page.html())+1);*/
            }
        });
    });
    $(".close").click(function () {
        console.log('alert');
        $(".alert").hide();
    });
});