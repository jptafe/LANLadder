document.addEventListener('DOMContentLoaded', function() {
    var options = {"accordion": false}
    var elems = document.querySelectorAll('.collapsible');
    var instances = M.Collapsible.init(elems, options);
    options = {}; // Default empty
    elems = document.querySelectorAll('.materialboxed');
    instances = M.Materialbox.init(elems, options);
    elems = document.querySelectorAll('select');
    instances = M.FormSelect.init(elems, options);
});

function color(value){
    console.log(value);
}