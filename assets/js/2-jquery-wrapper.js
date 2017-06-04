function xhr(f,d,sccfn,donefn,confirmfn) {
    $.blockUI({message: '<img src="vendor/bower/crowpack/assets/img/spinner.gif"><h1>Loading</h1>',overlayCSS: {backgroundColor:  '#fff',opacity: 0.8, cursor: 'wait'},css: {border: 0,padding: 0,backgroundColor: 'transparent'}});

    $.when(
        $.ajax({type: "POST", url: f, data: d, dataType: 'json',
            success: function(data) {
                //console.log(data);
                $.unblockUI();
                if(data.dberror) {
                    //swal({title: "Error!",text:data.errmsg,type:"error",confirmButtonText:"OK"});
                    var ctext = JSON.stringify(data, null, 4);
                    swal({title: "Response",text: ctext,confirmButtonText:"OK",customClass:'console'});
                }
                if(data.errmsg) {
                  swal({title: "Info!",text:data.errmsg,type:"error",confirmButtonText:"OK"});
                }
                if(data.sccmsg) {
                  swal({title: "Success!",text:data.sccmsg,type:"success",confirmButtonText:"OK"},confirmfn);
                }
            },
            error: function(xhr, status, error) {
                $.unblockUI();
                var msg= "Response: "+xhr.responseText+"<br>Status:  "+status+"<br>Error: "+error;
                swal({title: "Response",text: msg,confirmButtonText:"OK",customClass:'console'});
                //$('#console').html( msg );
            } // end error
        }) // end ajax
    ).then(function( data, textStatus, jqXHR ) {
      sccfn(data); // Alerts 200
    }).done(donefn);
} // end xhr

function getobjectsbyvalue(key,val,arr) {
    var found_objs = $.grep(arr, function(item) {
        return item[key] == val;
    });
return found_objs;
}
