# jQuery

# COMMON
Window redirect

    window.location.href='';
    
# STRING 
String explode

    .split("_");

# DOM MANIPULATION
Get content of an element

    .html();
    
Set content of an element

    .html('new content');


# FORM ELEMENTS
If checkbox is checked

    $("#el").is(":checked")
    
If selectbox is selected

    $('#el').is(":selected")
    
Get value of a form element

    .val();
    
# ARRAYS
Length of an array

    .length
    
Iteration

    $.each([ 52, 97 ], function( index, value ) {
        alert( index + ": " + value );
    });
    

    