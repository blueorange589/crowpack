function helper() {
    function delayedexecution(fn,ms=2000) {
        setTimeout(function() { fn(); }, ms);
    }
}


function dom() {
    function resetvals(arr,newval='') {
        $.each(arr, function(index,id) {
            $('#'+id).val(newval);
        });
    }

    function resethtmls(arr,newval='') {
        $.each(arr, function(index,id) {
            $('#'+id).html(newval);
        });
    }

}


